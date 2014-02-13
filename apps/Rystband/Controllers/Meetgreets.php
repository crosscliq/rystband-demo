<?php 
namespace Rystband\Controllers;

class Meetgreets extends BaseAuth 
{   

    
     public function display()
    {
        \Base::instance()->set('pagetitle', 'Prize Patrol');
        \Base::instance()->set('subtitle', '');
                
        $view = new \Dsc\Template;
        echo $view->render('meetgreet/home.php');
    }

}
?> 