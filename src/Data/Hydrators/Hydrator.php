<?php 

namespace App\Data\Hydrators;

use App\Entities\Entity;

class Hydrator
{
    private $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     *
     * @param array $data
     * @return void
     */
    public function hydrate(array $data) 
    {
        $this->set($data);

        return $this->entity;
    }

    /**
     *
     * @param [array] $data
     */
    private function set(array $data)
    {
        $data['data'] = $data;
        $reflection = new \ReflectionClass($this->entity);

        foreach ($data as $key => $value) {
            if (property_exists($this->entity, $key)) {
                $this->setPrivateValue($reflection, $key, $value);
            } else {
                throw new \Exception($key . ' property does not exist.');
            }
        }
    }

    /**
     *
     * @param \ReflectionClass $class
     * @param [string] $name
     * @param [mixed] $value
     * @return \ReflectionClass
     */
    private function setPrivateValue(\ReflectionClass $class, string $name, $value) : \ReflectionClass
    {
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        $property->setValue($this->entity, $value);

        return $class;
    }
}