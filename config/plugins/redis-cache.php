<?php

use Roots\WPConfig\Config;

use function Env\env;

/**
* Configuration - Plugin: Redis
* @url: https://wordpress.org/plugins/redis-cache/
*/
if (null !== env('REDIS_URL')) {
    $env = \parse_url(env('REDIS_URL'));
    
    Config::define('WP_CACHE', true);
    Config::define('WP_REDIS_DISABLED', false);
    Config::define('WP_REDIS_CLIENT', 'predis');
    Config::define('WP_REDIS_SCHEME', $env['scheme']);
    Config::define('WP_REDIS_HOST', $env['host']);
    Config::define('WP_REDIS_PORT', $env['port']);
    Config::define('WP_REDIS_PASSWORD', $env['pass']);

    // 28 Days
    Config::define('WP_REDIS_MAXTTL', 2419200);

    unset($env);
}
