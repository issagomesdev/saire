<?php

if (! function_exists('asset_v')) {
    /**
     * Como asset('css/site/styles.css') sempre gera a MESMA URL mesmo
     * quando o conteudo do arquivo muda, o Cache-Control agressivo do
     * Nginx (30d, immutable) + o Cloudflare na frente da VPS nunca
     * sabem que precisam buscar a versao nova -- usuarios que ja
     * visitaram o site ficam presos no CSS/JS antigo ate o cache
     * expirar. Anexar "?v=<mtime>" muda a URL a cada deploy que altere
     * o arquivo, forcando um cache miss so nesse caso (o cache longo
     * continua valendo, e bem-vindo, para tudo que nao mudou).
     */
    function asset_v(string $path): string
    {
        $fullPath = public_path($path);
        $version = is_file($fullPath) ? filemtime($fullPath) : time();

        return asset($path).'?v='.$version;
    }
}
