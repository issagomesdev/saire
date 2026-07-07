# docker/nginx/Dockerfile
# Usado apenas em PRODUCAO. Em desenvolvimento a imagem oficial
# nginx:alpine e usada diretamente, com o default.conf montado via
# volume (veja docker-compose.yml) para permitir edicao sem rebuild.
FROM nginx:1.27-alpine

COPY default.conf /etc/nginx/conf.d/default.conf
