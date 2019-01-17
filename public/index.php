<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Middleware\Json as JsonMiddleware;

require '../vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
    'cache.enabled'
];

// container
$c = new \Slim\Container($configuration);

// http cache middleware
$c['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};

// custom logger
$c['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger('test-app');
    $logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', \Monolog\Logger::DEBUG));
    return $logger;
};

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
        $c->get('\App\Services\Service'),
        $c->get('cache')
    );
};

$app = new \Slim\App($c);

// middleware
$app->add(new JsonMiddleware());
$app->add(new \Slim\HttpCache\Cache('public', 86400));

// routes
$app->post('/create', '\App\Controllers\PaymentController:create');

$app->get('/log', function(Request $request, Response $response) use($c) {

    $c->get('logger')->addInfo('custom logger using Monolog, writing to container error log.');

    return $response->withJson('written to the erro log file.');
});

$app->run();