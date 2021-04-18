<?php

function debug($arr) {
    echo '<pre class="debug">' . print_r($arr, true) . '</pre>';
}

function upperCamelCase($name) {
    $name = str_replace('-', ' ', $name);
    $name = ucwords($name);
    $name = str_replace(' ', '', $name);
    
    return $name;
}

function lowerCamelCase($name) {
    $name = upperCamelCase($name);
    $name = lcfirst($name);
    
    return $name;
}

function isAjax() {
    return 
        isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

function redirect($http = false) {
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
    }
    header("Location: $redirect");
    exit;
}

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}

function icon($name) {
    $icon = APP . '/icons/' . $name . '.svg';
    return file_get_contents($icon);
}

function siteUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'].'/';
    
    return $protocol.$domainName;
}