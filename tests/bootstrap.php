<?php

/**
 * Bootstrap de teste dedicado.
 *
 * O container já recebe APP_ENV/DB_CONNECTION/etc. reais via
 * docker-compose (env_file: .env). O atributo force="true" nas tags
 * <env> do phpunit.xml usa putenv(), mas o Repository do phpdotenv (que
 * o Laravel usa para resolver env()/app()->environment()) lê de
 * $_ENV/$_SERVER — que o Docker já populou diretamente e putenv() não
 * sobrescreve. Sem isto, os testes rodariam contra o MySQL de
 * desenvolvimento de verdade em vez do sqlite isolado.
 */
$testEnv = [
    'APP_ENV' => 'testing',
    'DB_CONNECTION' => 'sqlite',
    'DB_DATABASE' => ':memory:',
    'CACHE_DRIVER' => 'array',
    'SESSION_DRIVER' => 'array',
    'QUEUE_CONNECTION' => 'sync',
    'MAIL_MAILER' => 'array',
    'BCRYPT_ROUNDS' => '4',
    'TELESCOPE_ENABLED' => 'false',
];

foreach ($testEnv as $key => $value) {
    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

require __DIR__.'/../vendor/autoload.php';
