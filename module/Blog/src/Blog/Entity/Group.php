<?php
 namespace Blog\Entity;

 use Doctrine\ORM\Mapping as ORM;
 use Zend\InputFilter\Factory as InputFactory;
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;

 /**
 * This is Entity class for Group user
 * 
 * @author Bineet kumar Chaubey
 * @version 1.0
 * @package Zend2 
 * @subpackage Doctrine2
 */

 /**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 * @property int id
 * @property string name
 * @property string display_name
 */

 class Group  implements InputFilterAwareInterface 
 {
    /**
    * validation input filter
    */
    protected $inputFilter;

 	/**
 	* @ORM\Id
 	* @ORM\Column(type="integer")
 	* @ORM\GeneratedValue(strategy="AUTO")
 	*/

    protected $id;

    /**
    * @ORM\Column(name="name", type="string")
    */

    protected $name;

    /**
    * @ORM\Column(name="display_name", type="string")
    */

    protected $display_name;

    /**
    * @ORM\ManyToMany(targetEntity="User", inversedBy="users")
    * @ORM\JoinTable(name="users_groups")
    */

    protected $users;


     /**
     * intialize user object array collections
     */
 	function __construct()
 	{
 		$this->users = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getUsers(){
    	$this->users;
    }

    public function addUsers(User $user){
    	$this->users->add($user);
    	// $user->addGroups($this);
    	/**
    	*  above commented code  o not you in both Entity(both way) in many to many 
    	*  relations unless insert query go into infinit loop
    	*/
    }

    public function parsearraydata($data){
    	$this->id   =   (!empty($data['id'])) ? $data['id'] : null ;
    	$this->name =   (!empty($data['name'])) ? $data['name'] : null ;
    	$this->display_name = (!empty($data['display_name'])) ? $data['display_name'] : null ;
    }


    /**
     * @ORM\PrePersist 
     * @ORM\PreUpdate
     */
    public function validate()
    {
    
        echo $this->name ; die("test doctrine validation") ;

        if ($this->name == null) {
            throw new Exception('Name not be null');
        }

        if ($this->display_name == null) {
            throw new Exception('display field not be null');
        }
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
                    'name' => 'display_name',
                    'required' => true,
                )));

            $this->inputFilter = $inputfilter;
        }

        return $this->inputFilter;
    }
    
 }
