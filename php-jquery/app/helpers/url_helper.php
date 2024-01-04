<?php

    // リダイレクト
    function redirect($page){
        header('Location:' . URL_ROOT . '/' . $page);
    }

    function img($img){
        return URL_ROOT . '/img/' . $img; 
    }

    function css($css){
        return URL_ROOT . '/css/' . $css . '.css'; 
    }