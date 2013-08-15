<?php
namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @property string $name
 * @property int $age
 * @property int $id
 */
 class User  implements InputFilterAwareInterface 
 { 
    /**
    * validation input filter
    */
    protected $inputFilter;
 	
 	/**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\Column(name="name",type="string")
    */

    protected $name;


    /**
    *@ORM\Column(name="username", type="string")
    */

    protected $username;

    /**
    *@ORM\Column(name="password", type="text")
    */

    protected $password;

    /**
    *@ORM\Column(name="email", type="text")
    */

    protected $email;

   /**
    * @ORM\Column(type="integer", columnDefinition="ENUM('1','0')") 
    */
    private $state;


    /**
    * @ORM\Column(name="age", type="integer")
    */

   protected $age;


   /**
    * @ORM\Column(name="role", type="string")
    */

   protected $role;


    /**
    * @ORM\OneToMany(targetEntity="Post", mappedBy="author")
    */
    protected $posts ;


    /**
    * @ORM\ManyToMany(targetEntity="Group", mappedBy="users")
    */

     protected $groups;

     /**
     * return arary for user post
     */
    public function __construct() {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
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
 
    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) 
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->age = $data['age'];
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->role = $data['role'];
        $this->email = $data['email'];
        $this->state = $data['state'];
    }

    /** @return Collection */
    public function getPosts() {
        return $this->posts;
    }
     
    /** @param Post $post */
    public function addPosts(Post $post) {
        $this->posts->add($post);
        $post->setUser($this);
    }

    /**
    * get user Groups
    * @return Group $groups
    */
    public function getGroups(){
        return $this->groups;
    }

    /**
    *  add Group object in user object;
    */
    public function addGroups(Group $group){
        $this->groups->add($group);
        $group->addUsers($this);
    }
  
    public function setInputFilter(InputFilterInterface $inputFilterintreface){
        throw new \Exception('Not Use');
    }

   /**
   * For validation input field ;
   */

   public function getInputFilter(){
        if(!$this->inputFilter){
            $inputfilter = new InputFilter();
            $inputFactory = new InputFactory();

            $inputfilter->add($inputFactory->createInput(array(
                    'name' => 'name',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim') 
                        ),
                    'validators' =>array(
                            array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'encoding' => 'UTF-8',
                                            'min' => '1',
                                            'max' => '1000'
                                        )
                                )
                        )
                )));

            $inputfilter->add($inputFactory->createInput(array(
                    'name' => 'username',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim') 
                        ),
                    'validators' =>array(
                            array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'encoding' => 'UTF-8',
                                            'min' => '1',
                                            'max' => '1000'
                                        )
                                )
                        )
                )));


            $inputfilter->add($inputFactory->createInput(array(
                    'name' => 'password',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim') 
                        ),
                    'validators' =>array(
                            array(
                                    'name' => 'StringLength',
                                    'options' => array(
                                            'encoding' => 'UTF-8',
                                            'min' => '1',
                                            'max' => '20'
                                        )
                                )
                        )
                )));

            $inputfilter->add($inputFactory->createInput(array(
                    'name' => 'email',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim') 
                        ),
                    'validators' =>array(
                            array(
                                    'name' => 'emailaddress',                                 
                                )
                        )
                )));


            $inputfilter->add($inputFactory->createInput(array(
                    'name' => 'age',
                    'required' => true,
                    'filters' => array(
                            array('name' => 'Int'),
                            array('name' => 'StringTrim') 
                        ),
                    'validators' =>array(
                            array(
                                    'name' => 'Between',
                                    'options' => array(
                                            'encoding' => 'UTF-8',
                                            'min' => '1',
                                            'max' => '100'
                                        )
                                )
                        )
                )));


            $this->inputFilter = $inputfilter;
        }

        return $this->inputFilter;
    }

     public function removeGroup($group)
    {
        //optionally add a check here to see that $group exists before removing it.
        return $this->groups->removeElement($group);
    }

 }