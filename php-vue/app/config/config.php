<?php

    // Environments
    define('ENV', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'local');

    // Constants
    if(ENV === 'production') {
        // Mypage Database
        define('DB_HOST_MP', 'xxx');
        define('DB_USER_MP', 'xxx');
        define('DB_PASS_MP', 'xxx');

        // Login Service Database
        define('DB_HOST_LG', 'xxx');
        define('DB_USER_LG', 'xxx');
        define('DB_PASS_LG', 'xxx');

        // URL ROOT
        define('URL_ROOT', 'https://xxx.jp/admin/xxx');

        // URL_MYPAGE
        define('URL_MYPAGE', 'https://xxx.jp/mypage/xxx');

        // URL_VUE
        define('URL_VUE', 'https://cdn.jsdelivr.net/npm/vue@2.6.11');

        // S3 BUCKET KEY
        define('S3_BUCKET_KEY', 'xxx/prod/');

        // FORM DOMAIN
        define('DOMAIN_FORM', 'https://form.xxx.jp');

        // Site Name
        define('SITE_NAME', 'xxx xxx | 管理画面');

        // Bags images
        define('BAGS_IMG_PATH', '/mypage/xxx/public/img/bag/');

        // Bags thumbnail images
        define('BAGS_THUM_PATH', '/mypage/xxx/public/img/bag/small/');

    } else if(ENV === 'development') {
        // Mypage Database
        define('DB_HOST_MP', 'xxx');
        define('DB_USER_MP', 'xxx');
        define('DB_PASS_MP', 'xxx');

        // Login Service Database
        define('DB_HOST_LG', 'xxx');
        define('DB_USER_LG', 'xxx');
        define('DB_PASS_LG', 'xxx');

        // URL ROOT
        define('URL_ROOT', 'https://dev.xxx.jp/admin/xxx');

        // URL_MYPAGE
        define('URL_MYPAGE', 'https://dev.xxx.jp/mypage/xxx');

        // URL_VUE
        define('URL_VUE', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js');

        // S3 BUCKET KEY
        define('S3_BUCKET_KEY', 'xxx/dev/');

        // FORM DOMAIN
        define('DOMAIN_FORM', 'https://devform.xxx.jp');

        // Site Name
        define('SITE_NAME', 'xxx xxx - 開発環境 - | 管理画面');

        // Bags images
        define('BAGS_IMG_PATH', '/mypage/xxx/public/img/bag/');

        // Bags thumbnail images
        define('BAGS_THUM_PATH', '/mypage/xxx/public/img/bag/small/');

    } else {
        // Mypage Database
        define('DB_HOST_MP', 'localhost');
        define('DB_USER_MP', 'xxx');
        define('DB_PASS_MP', 'xxx');

        // Login Service Database
        define('DB_HOST_LG', 'xxx');
        define('DB_USER_LG', 'xxx');
        define('DB_PASS_LG', 'xxx');

        // URL ROOT
        define('URL_ROOT', 'http://localhost/admin/xxx');

        // URL_MYPAGE
        define('URL_MYPAGE', 'http://localhost/mypage/xxx');

        // URL_VUE
        define('URL_VUE', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js');

        // S3 BUCKET KEY
        define('S3_BUCKET_KEY', 'xxx/local/');

        // FORM DOMAIN
        define('DOMAIN_FORM', 'https://devform.xxx.jp');

        // Site Name
        define('SITE_NAME', '◯◯ - Local環境 - | 管理画面');

        // Bags images
        define('BAGS_IMG_PATH', '/mypage/xxx/public/img/bag/');

        // Bags thumbnail images
        define('BAGS_THUM_PATH', '/mypage/xxx/public/img/bag/small/');
    }
    define('DB_NAME_MP', 'xxx');
    define('DB_NAME_LG', 'xxx');
    define('DB_ENCODING', 'utf8');

    // App Root
    define('APP_ROOT', dirname(dirname(__FILE__)));
    define('DIR_ROOT', dirname(dirname(dirname(__FILE__))));

    // vuejs-datepicker
    define('URL_VUE_DATEPICKER', 'https://unpkg.com/vuejs-datepicker');
    define('URL_VUE_DATEPICKER_JA', 'https://unpkg.com/vuejs-datepicker@1.6.2/dist/locale/translations/ja.js');

    // moment.js
    define('URL_MOMENT', 'https://cdn.jsdelivr.net/npm/moment@2.27.0/moment.min.js');
    define('URL_MOMENT_LOCAL', 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/locale/ja.min.js');

    // AWS mypageS3Uploader IAM
    define('ACCESS_KEY_ID', 'xxx');
    define('ACCESS_KEY_SECRET', 'xxx+xxx');
    define('AWS_REGION', 'ap-northeast-1');
    define('AWS_VERSION', 'latest');
    define('S3_BUCKET_NAME', 'xxx-bucket');
    define('S3_IMG_PATH', 'https://xxx-bucket.s3-ap-northeast-1.amazonaws.com/'.S3_BUCKET_KEY);

    define('PROGRAM_ID', 1000000050);

    if(ENV !== 'production') {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }