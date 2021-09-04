<?php

use Roots\WPConfig\Config;

use function Env\env;

/**
 * Configuration overrides for WP_ENV === 'production'
 */
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', false);
Config::define('SCRIPT_DEBUG', false);
ini_set('display_errors', '0');

/** Disable all file modifications including updates and update notifications */
Config::define('DISALLOW_FILE_MODS', true);

// Enforce SSL for Login/Admin in production
if ('on' === $_SERVER['HTTPS'] ?? null) {
    Config::define('FORCE_SSL_LOGIN', true);
    Config::define('FORCE_SSL_ADMIN', true);
}

/**
 * Multi Site
 *
 * If your Multisite is running on multiple domains
 * f.ex.: www.example.com main domain and www.subexample.com (instead of sub.example.com) as sub domain
 * use $_SERVER[ 'HTTP_HOST' ] instead of WP_MULTISITE_MAIN_DOMAIN in DOMAIN_CURRENT_SITE:
 * define( 'DOMAIN_CURRENT_SITE', $_SERVER[ 'HTTP_HOST' ]  );
 *
 * Without this, logins will only work in the DOMAIN_CURRENT_SITE.
 * Reauth is required on all sites in the network after this.
 */

if (env('WP_ALLOW_MULTISITE')) {
    define('MULTISITE', true);
    define('SUBDOMAIN_INSTALL', true);
    define('WP_ALLOW_MULTISITE', env('WP_ALLOW_MULTISITE'));
    define('DOMAIN_CURRENT_SITE', env('WP_MULTISITE_MAIN_DOMAIN') ?? $_SERVER['HTTP_HOST'] ?? 'localhost');
    define('PATH_CURRENT_SITE', '/');
    define('SITE_ID_CURRENT_SITE', 1);
    define('BLOG_ID_CURRENT_SITE', 1);
    define('SUNRISE', true);
}
