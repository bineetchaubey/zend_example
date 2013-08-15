<?php
namespace Incuser\Form;

use  Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct(){

		parent::__construct('Login');

		$this->setAttribute('method','post');
		$this->add(array(
                'name' => "username",
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                		'label' => 'Your Username',
                	),
                /*'attributes' => array(
                		'id' => 'UserName',
                	)*/
			));

		$this->add(array(
				'name' => 'password',
				'type' => 'Zend\Form\Element\Password',
				'options' => array(
                        'label' => 'Your Password',
					)
			));

		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'login',
						'id' => 'SubmitLogin',
					)
			));

	}
}