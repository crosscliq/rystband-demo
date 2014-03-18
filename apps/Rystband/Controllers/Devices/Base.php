<?php 
namespace Rystband\Controllers\Devices;

class Base extends \Dsc\Controller 
{
    public function display()
    {
        \Base::instance()->set('pagetitle', 'Home');
        \Base::instance()->set('subtitle', '');
                
        $view = new \Dsc\Template;
        echo $view->render('home/default.php');
    }

     public function own($f3)
    {
        \Base::instance()->set('pagetitle', 'Welcome');
        \Base::instance()->set('subtitle', '');
        

        $view = new \Dsc\Template;
        echo $view->render('attendee/own.php');
    }
}
?> 