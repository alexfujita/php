<?php

    // Environments
    define('ENV', $_SERVER['HTTP_HOST'] !== 'localhost' ? 'production' : 'local');

    // Constants
    if(ENV === 'production') {
        // Database
        define('DB_HOST', '127.0.0.1');
        define('DB_USER', 'xxx');
        define('DB_PASS', 'xxx');
        define('DB_NAME', 'xxx');

        // URL ROOT
        define('URL_ROOT', 'http://121.0.0.1');

    } else {
        // Mypage Database
        define('DB_HOST', '127.0.0.1');
        define('DB_USER', 'xxx');
        define('DB_PASS', 'xxx');
        define('DB_NAME', 'xxx');

        // URL ROOT
        define('URL_ROOT', 'http://localhost/xxx');

    }

    define('SITE_NAME', 'xxx');

    define('DB_ENCODING', 'utf8');

    // App Root
    define('APP_ROOT', dirname(dirname(__FILE__)));
    define('DIR_ROOT', dirname(dirname(dirname(__FILE__))));

    // URL_VUE
    define('URL_VUE', 'https://cdn.jsdelivr.net/npm/vue@2.6.11');

    if(ENV !== 'production') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }