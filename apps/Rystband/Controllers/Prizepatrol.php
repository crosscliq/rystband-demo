<?php 
namespace Rystband\Controllers;

class Prizepatrol extends BaseAuth 
{   

    
     public function display()
    {
        \Base::instance()->set('pagetitle', 'Prize Patrol');
        \Base::instance()->set('subtitle', '');
                
        $view = new \Dsc\Template;
        echo $view->render('prizepatrol/home.php');
    }

}
