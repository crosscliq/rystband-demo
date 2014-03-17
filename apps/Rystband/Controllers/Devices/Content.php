<?php 
namespace Rystband\Controllers\Devices;

class Content extends Base 
{   
    var $pusher = null;
    
    public function car() {
        $f3 = \Base::instance();
       
        $view = new \Dsc\Template;
        $view->setLayout('content.php');
        echo $view->render('content/car/index.php');

    }

}


?> 