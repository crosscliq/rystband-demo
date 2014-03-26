<?php 
namespace Rystband\Controllers\Devices\Box;

class Login extends \Rystband\Controllers\Devices\Base 
{   
    var $pusher = null;

    
    public function index($item) {
        $f3 = \Base::instance();
        $f3->set('item',$item );
       

        $view = new \Dsc\Template;
        echo $view->render('device/'.$item->type.'/index.php');

    }

    

}
?> 