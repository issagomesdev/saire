#!/bin/bash
# docker/php/entrypoint.prod.sh
#
# Roda como root (ver Dockerfile) para poder:
#   1. publicar /var/www/html/public em /shared/public, um volume
#      nomeado compartilhado com o container Nginx (que nao tem acesso
#      ao filesystem da imagem do app);
#   2. corrigir a dono de volumes nomeados recem-criados pelo Docker
#      (eles nascem com dono root).
# Em seguida troca para "appuser" via su-exec antes de rodar qualquer
# comando artisan e antes do processo final do php-fpm.
set -e

# Esta imagem nao tem (e nao deve ter) um .env fisico: .dockerignore
# exclui o arquivo do build context de proposito, para que o segredo
# nunca fique gravado numa camada da imagem. Toda a config chega via
# env_file no docker-compose.prod.yml, que o Docker ja injeta como
# variavel de ambiente real do processo -- por isso NENHUM comando aqui
# pode depender de reescrever o .env (ex.: "artisan key:generate" sem
# --show), so leitura via getenv()/$_ENV.
#
# APP_KEY especificamente precisa ser gerado uma unica vez no .env do
# HOST, antes do primeiro boot (README > Docker > Production): gerar de
# novo a cada recreate invalidaria sessoes, cookies e qualquer coluna
# "encrypted" ja gravada no banco. Falhar cedo aqui evita subir com uma
# app "quebrada" que só daria erro no primeiro request autenticado.
if [ -z "$APP_KEY" ]; then
    echo "[entrypoint] ERRO: APP_KEY nao esta definida no ambiente." >&2
    echo "[entrypoint] Gere uma e coloque no .env do host antes de subir o container:" >&2
    echo '  sed -i "s|^APP_KEY=.*|APP_KEY=base64:$(openssl rand -base64 32)|" .env' >&2
    exit 1
fi

mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache
chown -R appuser:appgroup storage bootstrap/cache

# Cria o link simbolico ANTES de sincronizar, para que ele va junto
# na copia para /shared/public.
su-exec appuser php artisan storage:link --force >/dev/null 2>&1 || true

if [ -d /shared/public ]; then
    echo "[entrypoint] Publicando assets em /shared/public..."
    # --delete garante que arquivos de builds antigos (hashes do Vite)
    # nao fiquem "presos" no volume compartilhado com o Nginx: um
    # volume nomeado so e populado automaticamente pelo Docker na
    # primeira criacao, entao sem isso um redeploy com assets novos
    # nunca chegaria ao Nginx.
    rsync -a --delete /var/www/html/public/ /shared/public/
    chown -R appuser:appgroup /shared/public
fi

echo "[entrypoint] Reconstruindo cache de configuracao/rotas/views..."
su-exec appuser php artisan config:cache
su-exec appuser php artisan route:cache
su-exec appuser php artisan view:cache

if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "[entrypoint] RUN_MIGRATIONS=true, executando migrations..."
    su-exec appuser php artisan migrate --force
fi

# php-fpm precisa iniciar como root (nao via su-exec): e o proprio
# master process, ja rodando como root, quem le "user"/"group" no
# www.conf e derruba privilegio para "appuser" em cada worker.
exec "$@"
