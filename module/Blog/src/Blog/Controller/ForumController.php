<?php
namespace Blog\Controller;

/**
 * This is Forum Controller FIle 
 *
 * 
 *
 * PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Bineet kumar Chaubey <bineet.chaubey@indianic.com>
 * @copyright  2010 - 2014 indiaNIC
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/PackageName
 * @see        Zend Controler
 * @since      File available since Release 0.0.1
 * @deprecated File deprecated in Release 2.0.0
 */

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Blog\Entity\User;
use Blog\Entity\Post;
use Blog\Entity\Group;

/**
* This forum controller class
*
*
* @author Bineet 
* @version 1.0
* @package  Zend
* @subpackage Learn Zend2
*/

class ForumController extends AbstractActionController
{
	  /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
    * Set Doctrine Entity manager
    *
    * @author Bineet Kumar Chaubey
    * @param Object  DOctrine EntityMnager
    * @return Object Entity manager
    */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    /**
    * Set Doctrine Entity manager
    *
    * @author Bineet Kumar Chaubey
    * @return Object Entity manager
    */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    /**
    * Forum controller  index page 
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel class
    */
  	public function indexAction(){
  		
          $msg = "This is forum controller main page";
         
  		// return new ViewModel(array('formdata' => $msg ));
  		return new ViewModel(array(
                    'anc' => $msg ,
                    'flashMessages' => $this->flashMessenger()->getMessages(),
        ));
  	}
    
    /**
    * Forum controller  test page only display text 
    *
    * @author Bineet Kumar Chaubey
    * @return Object viewModel class
    */
    public function getpostAction(){
    	return new ViewModel(array('post' => 'result set'));
    }

    /**
    *  Display all user with DOctrine fetch query 
    *
    * @author Bineet Kumar Chaubey <bineet.chaubey@indianic.com>
    * @return Object viewModel class
    */

    function getuserAction(){
         return new ViewModel(array(
            'Users' => $this->getEntityManager()->getRepository('Blog\Entity\User')->findAll() 
        ));
    }
    
    /**
    *  Display all user Entity  with post entity  DOctrine fetch query 
    *
    * @author Bineet Kumar Chaubey <bineet.chaubey@indianic.com>
    * @return Object viewModel class
    */

    function getuserwithpostAction(){

        $query = $this->getEntityManager()->createQuery('SELECT u  FROM Blog\Entity\User u JOIN u.posts a ');
         $users = $query->getResult();
        //$users = $query->getArrayResult();

       /*echo "<pre>";
       var_dump($users-);*/

       return new ViewModel(array('users' => $users));
    }

    /**
    *  Display all , post entity , DOctrine fetch query 
    *
    * @author Bineet Kumar Chaubey <bineet.chaubey@indianic.com>
    * @return Object viewModel class
    */

    function getallpostAction(){
       return new ViewModel(array(
            'Posts' => $this->getEntityManager()->getRepository('Blog\Entity\Post')->findAll() 
        )); 
    }

    /**
    *  Insert user with groups Entity , DOctrine fetch query 
    *
    * @author Bineet Kumar Chaubey <bineet.chaubey@indianic.com>
    * @return Object viewModel class
    */

    public function insertuserwithgroupAction(){
              
              $user= $this->getEntityManager()->getRepository('Blog\Entity\User')->find(2);

              $group = new Group();
              $group->name = "baseball";
              $group->display_name = "Baseball";
            
              $this->em->persist($group);
              $user->addGroups($group);
              $this->em->flush();
    }
    
    /**
    *  Test a Contoller plugin  only for test and
    *  also test event manager with attached a event
    *
    * @author Bineet Kumar Chaubey <bineet.chaubey@indianic.com>
    * @return Object viewModel class
    */

    public function gettestpluginAction(){
        
        $pluginobj =  $this->MyFirstPlugin();
        $pluginobj->events()->attach('WordpressLikehook', function($event) {
           $message = "Trying to retrieve photo: " . $event->getParam('username');
           return $message;
          });

         $resultdata = $pluginobj->getuseradetal();

        return new ViewModel (array('resultdata'=> $resultdata ));

    }

    public function getuserwithgroupAction(){

         $user= $this->getEntityManager()->getRepository('Blog\Entity\User')->findAll();
      
          return new ViewModel(array(
            'Usergroup' => $user
        ));

    }
}

