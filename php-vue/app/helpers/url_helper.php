<?php
    function img($img){
        return URL_MYPAGE . '/img/' . $img; 
    }

    function css($css){
        return URL_MYPAGE . '/css/' . $css . '.css'; 
    }

    function js($js){
        return URL_MYPAGE . '/js/' . $js . '.js';
    }

    function font($font){
        return DIR_ROOT . '/public/fonts/' . $font; 
    }

    function dirImg($img){
        return DIR_ROOT . '/public/img/' . $img; 
    }

    function includes($php){
        return APP_ROOT . '/views/includes/' . $php . '.php';
    }

    function url($url){
        return URL_ROOT . '/' . $url;
    }

    // リダイレクト
    function redirect($page){
        header('Location:' . URL_ROOT . '/' . $page);
    }

    function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $return = curl_exec($ch);
        curl_close ($ch);
        return $return;
    }