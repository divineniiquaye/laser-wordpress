<?php

/**
 * Your base production configuration goes in this file. Environment-specific
 * overrides go in their respective config/environments/{{WP_ENV}}.php file.
 *
 * A good default policy is to deviate from the production config as little as
 * possible. Try to define as much of your configuration in this file as you
 * can.
 */

use Roots\WPConfig\Config;
use function Env\env;

/**
 * Directory containing all of the site's files
 *
 * @var string
 */
$root_dir = dirname(__DIR__);

/**
 * Document Root
 *
 * @var string
 */
$webroot_dir = $root_dir . '/web';

/**
 * Allow WordPress to detect HTTPS when used behind a reverse proxy or a load balancer
 * See https://codex.wordpress.org/Function_Reference/is_ssl#Notes
 */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

/**
 * Gets the request URI from the given server environment
 *
 * @param array<string,mixed> $server
 *
 * @link http://php.net/manual/en/reserved.variables.server.php
 */
function request_uri(array $server, bool $path = false) : string
{
    if (\array_key_exists('HTTPS', $server)) {
        if ('on' === $server['HTTPS']) {
            $scheme = 'https://';
        }
    }

    if (\array_key_exists('HTTP_HOST', $server)) {
        $domain = $server['HTTP_HOST'];
    } elseif (\array_key_exists('SERVER_NAME', $server)) {
        $domain = $server['SERVER_NAME'];

        if (\array_key_exists('SERVER_PORT', $server) && env('INCLUDE_SERVER_PORT')) {
            $domain .= ':' . $server['SERVER_PORT'];
        }
    }

    if ($path) {
        if (\array_key_exists('REQUEST_URI', $server)) {
            $target = $server['REQUEST_URI'];
        } elseif (\array_key_exists('PHP_SELF', $server)) {
            $target = $server['PHP_SELF'];
            if (\array_key_exists('QUERY_STRING', $server)) {
                $target .= '?' . $server['QUERY_STRING'];
            }
        }
    }

    return ($scheme ?? 'http://') . ($domain ?? 'localhost') . ($target ?? null);
}

/**
 * Use Dotenv to set required environment variables and load .env file in root
 * .env.local will override .env if it exists
 */
if (null === $appDeployed = env('APP_IN_CLOUD')) {
    $env_files = file_exists($root_dir . '/.env.local') ? ['.env', '.env.local'] : ['.env'];
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable($root_dir, $env_files, false);

    if (file_exists($root_dir . '/.env')) {
        $dotenv->load();
        $dotenv->required(['WP_HOME', 'WP_SITEURL']);

        if (!env('DATABASE_URL')) {
            $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
        }
    }
}

/**
 * Load Plugin Configurations
 */
function includeDirectory($dir)
{
    foreach (scandir($dir) as $filename) {
        $path = $dir . '/' . $filename;

        if (is_file($path)) {
            require_once($path);
        }
    }
}

if ('heroku' === $appDeployed) {
    includeDirectory($root_dir . "/heroku");
}

includeDirectory($root_dir . "/config/plugins");

/**
 * Configuration - Worker: IronWorker for WP CronJobs
 *  Disable WP Cronjobs, because they will be run using the iron worker.
 */
if (env('IRON_WORKER_PROJECT_ID') && env('IRON_WORKER_TOKEN')) {
    Config::define('DISABLE_WP_CRON', true);
}

/**
 * Set up our global environment constant and load its config first
 * Default: production
 */
define('WP_ENV', env('WP_ENV') ?? 'production');

/**
 * URLs
 */
Config::define('WP_HOME', $siteUrl = env('WP_HOME') ?? request_uri($_SERVER));
Config::define('WP_SITEURL', env('WP_SITEURL') ?? $siteUrl . '/wp');

/**
 * Custom Content Directory
 */
Config::define('CONTENT_DIR', '/app');
Config::define('WP_CONTENT_DIR', $webroot_dir . Config::get('CONTENT_DIR'));
Config::define('WP_CONTENT_URL', Config::get('WP_HOME') . Config::get('CONTENT_DIR'));

/**
 * DB settings
 * 
 * NB: Avoiding override
 */
Config::define('DB_NAME', env('DB_NAME'));
Config::define('DB_USER', env('DB_USER'));
Config::define('DB_PASSWORD', env('DB_PASSWORD'));
Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'wp_';

if (env('DATABASE_URL')) {
    $dsn = (object) parse_url(env('DATABASE_URL'));

    Config::define('DB_NAME', substr($dsn->path, 1));
    Config::define('DB_USER', $dsn->user);
    Config::define('DB_PASSWORD', isset($dsn->pass) ? $dsn->pass : null);
    Config::define('DB_HOST', isset($dsn->port) ? "{$dsn->host}:{$dsn->port}" : $dsn->host);
}

/**
 * Authentication Unique Keys and Salts
 */
Config::define('AUTH_KEY', env('AUTH_KEY'));
Config::define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
Config::define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
Config::define('NONCE_KEY', env('NONCE_KEY'));
Config::define('AUTH_SALT', env('AUTH_SALT'));
Config::define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
Config::define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
Config::define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Custom Settings
 */
Config::define('AUTOMATIC_UPDATER_DISABLED', true);
Config::define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ?: false);
// Disable the plugin and theme file editor in the admin
Config::define('DISALLOW_FILE_EDIT', true);
// Disable plugin and theme updates and installation from the admin
Config::define('DISALLOW_FILE_MODS', true);
// Limit the number of post revisions that Wordpress stores (true (default WP): store every revision)
Config::define('WP_POST_REVISIONS', env('WP_POST_REVISIONS') ?: true);

/**
 * Debugging Settings
 */
Config::define('WP_DEBUG_DISPLAY', false);
Config::define('WP_DEBUG_LOG', false);
Config::define('SCRIPT_DEBUG', false);
ini_set('display_errors', '0');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
    require_once $env_config;
}

Config::apply();

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', $webroot_dir . '/wp/');
}
