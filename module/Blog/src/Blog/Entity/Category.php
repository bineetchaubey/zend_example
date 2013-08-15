<?php
namespace Blog\Entity;

use Doctrine\ORM\Mapping  as ORM;

/**
* @ORM\Entity;
* @ORM\Table(name="categories")
* @property int id
* @property string name
*/

 class Category 
 {
 	/**
 	* @ORM\Id
 	* @ORM\Column(name="id", type="integer")
 	* @ORM\GeneratedValue(strategy="AUTO")
 	*/
 	protected $id ;

    /**
 	* @ORM\Column(name="name", type="string")
 	*/

 	protected $name;

 	/**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }
 
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }


 }