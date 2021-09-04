<?php

use Roots\WPConfig\Config;

use function Env\env;

/**
* Configuration - Plugin: Fluent SMTP
* @url: https://wordpress.org/plugins/fluent-smtp/
*/

// Configuration - Plugin: Sendgrid
if (null !== env('SENDGRID_API_KEY')) {
    Config::define('FLUENTMAIL_SENDGRID_API_KEY', env('SENDGRID_API_KEY'));
}

// Configuration - Plugin: Gmail
if (null !== env('FLUENT_GMAIL_ID') && null !== env('FLUENT_GMAIL_SECRET')) {
    Config::define('FLUENTMAIL_GMAIL_CLIENT_ID', env('FLUENT_GMAIL_ID'));
    Config::define('FLUENTMAIL_GMAIL_CLIENT_SECRET', env('FLUENT_GMAIL_SECRET'));
}
