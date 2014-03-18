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

     public function carrequest() {
        $f3 = \Base::instance();
        
        $pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id');
        $data = array('POST' => $f3->get('POST'));
        $pusher->trigger('cardisplay', 'post', $data);

    }


}


?> 