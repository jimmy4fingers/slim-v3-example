<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Middleware\Json as JsonMiddleware;

require '../vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);

// container
$c['\App\Repositories\Repository'] = function($c) {
    return new \App\Repositories\Repository(
        new \App\Data\Hydrators\Hydrator(
            new \App\Entities\Entity()
        )
    );
};

$c['\App\Services\Service'] = function ($c) {
    return new \App\Services\Service(
        $c->get('\App\Repositories\Repository')
    );
};

$c['\App\Controllers\PaymentController'] = function ($c) {
    return new \App\Controllers\PaymentController(
        $c->get('\App\Services\Service')
    );
};

$app = new \Slim\App($c);

// middleware
$app->add(new JsonMiddleware());

// routes
$app->post('/create', '\App\Controllers\PaymentController:create');

$app->run();