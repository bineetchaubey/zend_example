<?php
namespace Blog\Model;

/** for validation in input field **/
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Post  implements InputFilterAwareInterface
{
    public $id;
    public $title;
    public $body;
    public $user_id;
    public $tag ;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
        $this->body = (!empty($data['body'])) ? $data['body'] : null;
        $this->user_id = (!empty($data['user_id'])) ?  (int)$data['user_id'] : null;
        $this->tag =  (!empty($data['tag'])) ? $data['tag'] : null;
    }


    public function setInputFilter(InputFilterInterface $inputFilterintreface){
   		throw new \Exception('Not Use');
  	}

 	public function getInputFilter(){
 		if(!$this->inputFilter){
 			$inputfilter = new InputFilter();
 			$inputFactory = new inputFactory();
            

 			/*$inputfilter->add($inputFactory->createInput(array(
 					'name' => 'id',
 					'required' => true,
 					'filters' => array(
 						array('name' => 'id'), 
 						)
 				)));*/

 			$inputfilter->add($inputFactory->createInput(array(
 					'name' => 'title',
 					'required' => 'true',
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
 					'name' => 'body',
 					'required' => true,
 				)));

 			$this->inputFilter = $inputfilter;
 		}

 		return $this->inputFilter;
 	}


}
