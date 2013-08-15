<?php
return array(
        // added for Acl   ###################################
        'controller_plugins' => array(
            'invokables' => array(
               'MyAclPlugin' => 'Myacl\Controller\Plugin\MyAclPlugin',
             )
         ),
        // end: added for Acl   ###################################     
);