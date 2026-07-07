#!/bin/bash
# docker/php/entrypoint.dev.sh
#
# Roda como root (ver docker/php/www.dev.conf) para evitar problemas
# de permissao entre o bind mount do host e o container. Prepara o
# ambiente a cada `docker compose up`, mantendo o fluxo "clonar e
# subir" sem passos manuais extras.
set -e

# O bind mount do codigo pertence ao usuario do host, o que faz o git
# recusar operar no repositorio ("dubious ownership"). Necessario para
# o composer conseguir consultar metadados de pacotes via git.
git config --global --add safe.directory /var/www/html

if [ ! -f vendor/autoload.php ]; then
    # vendor/ e um volume nomeado (ver docker-compose.yml): o diretorio
    # sempre existe, mas comeca vazio, entao checar so "-d vendor" nunca
    # detectaria a falta de dependencias instaladas.
    echo "[entrypoint] vendor/autoload.php ausente, rodando composer install..."
    composer install --no-interaction --prefer-dist
fi

if [ ! -f .env ] && [ -f .env.example ]; then
    echo "[entrypoint] .env ausente, copiando de .env.example..."
    cp .env.example .env
fi

if [ -f .env ] && ! grep -q "^APP_KEY=base64" .env; then
    echo "[entrypoint] Gerando APP_KEY..."
    php artisan key:generate --ansi --force
fi

if [ -n "$DB_HOST" ]; then
    echo "[entrypoint] Aguardando MySQL em ${DB_HOST}:${DB_PORT:-3306}..."
    for i in $(seq 1 30); do
        (echo > "/dev/tcp/${DB_HOST}/${DB_PORT:-3306}") >/dev/null 2>&1 && break
        sleep 1
    done
fi

php artisan storage:link --force >/dev/null 2>&1 || true

exec "$@"
