<?php 
namespace Rystband\Controllers;

class Device extends Base 
{   

    
     public function display()
    {
        \Base::instance()->set('pagetitle', 'Privacy Policy');
        \Base::instance()->set('subtitle', '');
                
        $view = new \Dsc\Template;
        echo $view->render('device/view.php');
    }

}
?> 