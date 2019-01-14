<?php 

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class PaymentController 
{
    private $service;

    /**
     *
     * @param App\Services\Service $service
     * @return void
     */
    public function __construct(\App\Services\Service $service)
    {
        $this->service = $service;
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
        $entity = $this->service->create(['data'=>['id'=>'fsdfds']]);

        $response->getBody()->write(json_encode($entity->get()));

        return $response;
    }
}