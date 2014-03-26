<?php 
namespace Rystband\Controllers;

class Mc extends BaseAuth 
{

    
    public function display()
    {
        \Base::instance()->set('pagetitle', 'MC');
        \Base::instance()->set('subtitle', '');
        
        $view = new \Dsc\Template;
        echo $view->render('mc/home.php');
    }

}