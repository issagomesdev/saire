# syntax=docker/dockerfile:1

##
## Etapa "base": dependências de sistema e extensões PHP comuns
## a desenvolvimento e produção. Mantida em uma única camada-base
## para evitar duplicação (DRY) entre os targets abaixo.
##
## PHP 8.3: composer.lock trava maennchen/zipstream-php 3.2.1, que exige
## PHP >=8.3 (composer.json aceita ^8.1, mas o lock atual so instala em
## 8.3+). Usar 8.3 aqui evita divergir do lock file existente.
FROM php:8.3-fpm-alpine AS base

# Copia o binário oficial do Composer (evita depender do instalador via curl)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache \
        bash \
        curl \
        git \
        icu-libs \
        libzip \
        libpng \
        libjpeg-turbo \
        freetype \
        oniguruma \
        su-exec \
        rsync \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && apk del .build-deps \
    && rm -rf /var/cache/apk/*

# Pool do PHP-FPM: desativa clear_env para que as variáveis de ambiente
# definidas no docker-compose (DB_*, REDIS_*, etc.) cheguem até o Laravel.
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

##
## Etapa "development": código montado via bind mount (hot reload de PHP),
## dependências de dev instaladas, Xdebug disponível sob demanda.
##
FROM base AS development

RUN apk add --no-cache --virtual .xdebug-deps $PHPIZE_DEPS linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del .xdebug-deps

COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini

# Sobrescreve o pool da etapa "base": em desenvolvimento o codigo vem
# de um bind mount do host (docker-compose.yml), e no Docker Desktop
# (Windows/macOS) um "chown" para um usuario nao-root nao surte efeito
# real sobre arquivos de bind mount. Rodar como root evita erros de
# permissao em storage/ e bootstrap/cache; isso e aceitavel por ser um
# ambiente local e descartavel — producao usa www.conf (nao-root de
# verdade, ver etapa "production" abaixo).
COPY docker/php/www.dev.conf /usr/local/etc/php-fpm.d/www.conf

COPY docker/php/entrypoint.dev.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
# php-fpm recusa iniciar com pool "user = root" sem esta flag
# explicita — condizente com rodar como root apenas em desenvolvimento
# (ver www.dev.conf acima).
CMD ["php-fpm", "--allow-to-run-as-root"]

##
## Etapa "frontend-builder": compila os assets (Vite) isoladamente,
## sem poluir a imagem final de produção com Node/npm.
##
FROM node:20-alpine AS frontend-builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources/ resources/
COPY vite.config.js ./

RUN npm run build

##
## Etapa "production": imagem enxuta, somente dependências de runtime,
## OPcache otimizado e usuário não-root.
##
FROM base AS production

RUN addgroup -g 1000 appgroup \
    && adduser -D -u 1000 -G appgroup appuser

COPY docker/php/php.prod.ini /usr/local/etc/php/conf.d/99-app.ini
COPY docker/php/entrypoint.prod.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

COPY --chown=appuser:appgroup . .
COPY --from=frontend-builder --chown=appuser:appgroup /app/public/build ./public/build

RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --optimize-autoloader \
        --prefer-dist \
    && composer clear-cache

RUN mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache /shared/public \
    && chown -R appuser:appgroup storage bootstrap/cache /shared/public

# O entrypoint precisa iniciar como root para sincronizar /shared/public
# (volume compartilhado com o Nginx) e ajustar permissoes de volumes
# nomeados recem-criados; usa su-exec para rodar os comandos artisan
# como "appuser". O php-fpm final continua iniciando como root de
# proposito: e ele mesmo (via "user"/"group" no www.conf) quem derruba
# privilegio para "appuser" em cada worker.
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
