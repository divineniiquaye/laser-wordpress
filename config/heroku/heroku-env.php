<?php

use function Env\env;

/**
 * Configuration - Wordpress Environment
 */
if (env('HEROKU_ENVIRONMENT')) {
    \putenv('WP_ENV=' . env('HEROKU_ENVIRONMENT'));
}
