<?php 
namespace Dash\Controllers;


Class Users extends \Users\Admin\Controllers\Users {


	 public function beforeRoute($f3){
        $user = $f3->get('SESSION.dash.user');
      
        if(empty($user)){
            $f3->reroute('/login');
        }
    } 



}




?>