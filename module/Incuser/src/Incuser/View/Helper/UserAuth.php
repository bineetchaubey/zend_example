<?php
namespace Incuser\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Session\Container;

/**
*  Helper class for user Authentication
*  
* @author Bineet Kumar Chaubey
* @version 1.0
* @package Zend2
*/

class UserAuth extends AbstractHelper
{
    protected $count = 0;

    public function __invoke()
    {
        /*$this->count++;
        $output  = sprintf("I have seen 'The Jerk' %d time(s).", $this->count);
        $escaper = $this->getView()->plugin('escapehtml');
        return $escaper($output);*/

        return $this;
    }

    function isLogin(){
        $user_container = new Container('IndaNICUser');
         if(isset($user_container->user_login)){
         	return true;
         }else{
         	return false;
         } 

    }


    function getCradential(){
         
         if($this->isLogin()){
            $user_container = new Container('IndaNICUser');
            return $user_container->user_login ;
         }else{
         	return false;
         }

    }

}