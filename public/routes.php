<?php

function handleRoutes()
{
    $request = $_SERVER['REQUEST_URI'];
    $request = parse_url($request, PHP_URL_PATH);

    switch ($request) {
        case '/':
            require __DIR__ . '/pages/home.php';
            break;

        case '/login':
            require __DIR__ . '/pages/login.php';
            break;

        case '/register':
            require __DIR__ . '/pages/register.php';
            break;

        default:
            require __DIR__ . '/pages/notfound.php';
            break;
    }
}
