<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$test_middleware = function ($request, $response, $next) {
    $response->getBody()->write('BEFORE');
    $response = $next($request, $response);
    $response->getBody()->write('AFTER');

    return $response;
};
