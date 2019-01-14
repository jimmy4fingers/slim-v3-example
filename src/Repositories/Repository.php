<?php 

namespace App\Repositories;

use App\Data\Hydrators\Hydrator;

class Repository
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function create(array $data)
    {
        return $this->hydrator->hydrate($data);
    }
}