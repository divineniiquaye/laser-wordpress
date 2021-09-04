<?php

use function Env\env;

/**
 * Configuration - Database: Heroku JawsDb MySQL/Maria
 * @url: https://elements.heroku.com/addons/jawsdb
 * @url: https://elements.heroku.com/addons/jawsdb-maria
 */
$jawsDB_url = env('JAWSDB_URL') ?? env('JAWSDB_MARIA_URL');

if (!empty($jawsDB_url)) {
    \putenv('DATABASE_URL=' . $jawsDB_url);
}

unset($jawsDB_url);
