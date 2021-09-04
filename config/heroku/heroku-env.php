<?php

use function Env\env;

/**
 * Configuration - Wordpress Environment
 */
if (env('HEROKU_ENVIRONMENT')) {
    $_ENV['WP_ENV'] = env('HEROKU_ENVIRONMENT');
}
