<?php 
namespace Rystband\Controllers\Devices;

class Content extends Base 
{   
    var $pusher = null;
    
    public function car() {
        $f3 = \Base::instance();
       
        $view = new \Dsc\Template;
        echo $view->render('content/car/index.php');

    }

}


?> 