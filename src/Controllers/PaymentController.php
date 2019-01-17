<?php 

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class PaymentController 
{
    private $service;
    private $cache;

    /**
     *
     * @param App\Services\Service $service
     * @return void
     */
    public function __construct(\App\Services\Service $service, \Slim\HttpCache\CacheProvider $cache)
    {
        $this->service = $service;
        $this->cache = $cache;
    }

    /**
     * create a new payment entity and return its data
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function create(Request $request, Response $response) : Response
    {
        $entity = $this->service->create(['data'=>[$request->getParsedBody()]]);
        $response->getBody()->write(json_encode($entity->get()));

        // add expires header
        $response = $this->cache->withExpires($response, time() + 3600);

        return $response;
    }
}