<?php
namespace Blog\Entity;

use Doctrine\ORM\Mapping  as ORM;

/**
* @ORM\Entity;
* @ORM\Table(name="posts")
* @property int id
* @property string title
* @property test body
*/
class Post 
{
	
	/**
	* @ORM\Id
	* @ORM\Column(type="integer")
	* @ORM\GeneratedValue(strategy="AUTO")
	*/

	protected $id;

	/**
	* @ORM\Column(name="title", type="string")
	*/
	protected $title;

	/**
	* @ORM\Column(name="body", type="text")
	*/

	protected $body;

	/**
	* @ORM\ManyToOne(targetEntity="User" , inversedBy ="posts")
	* @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    * 
	*/

	protected $author;

   
    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="post_categories",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $categories;

    
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }


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
 
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }



    /** @return User|null */
    public function getAuthor() {
        return $this->author;
    }
     
    /** @param User $user */
    public function setAuthor(User $author) {
        if($author === null || $author instanceof User) {
            $this->author = $author;
        } else {
            throw new InvalidArgumentException('$user must be instance of Entity\User or null!');
        }
    }

}