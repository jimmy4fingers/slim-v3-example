<?php 

namespace App\Middleware;

class Json
{
    public function __invoke($request, $response, $next)
    {
        // before
        $response = $next($request, $response);
        // after
        
        $data = json_decode($response->getBody(), true);
        
        return $response->withJson($data);
    }
}
