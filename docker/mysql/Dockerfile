# docker/mysql/Dockerfile
#
# my.cnf e copiado para dentro da imagem em vez de montado via bind
# mount: o mysqld recusa (com um aviso silencioso, "is ignored") ler
# arquivos de configuracao "world-writable", e e exatamente assim que
# Docker Desktop no Windows/macOS apresenta arquivos de bind mount —
# a configuracao customizada seria carregada sem erro nenhum, so que
# jamais aplicada. Copiar para a imagem garante permissoes corretas
# (e identicas) em qualquer host.
FROM mysql:8.0

COPY my.cnf /etc/mysql/conf.d/my.cnf
