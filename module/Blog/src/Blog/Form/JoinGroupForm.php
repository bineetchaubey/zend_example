<?php
namespace Blog\Form;

use Zend\Form\Form;

class JoinGroupForm extends Form
{
	public function __construct($name = Null)
	{
		parent::__construct('joingroup');
		$this->setAttribute('method','post');
		$this->add(array(
				'name' => 'gorupname',
				'type' => 'Zend\Form\Element\MultiCheckbox',
				'options' => array(
					'label' => "Group Name", 
					)
				));

		
		$this->add(array(
			    'name' => 'Submit',
			    'type' => 'Zend\Form\Element\Submit',
			    'attributes' => array(
			    		'value' =>  'Join Group',
			    		'id'    => 'joingroupubmitbtn'
			    	)
			));
	}

}