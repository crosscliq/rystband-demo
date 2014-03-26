<?php 
namespace Rystband\Controllers;

class Header extends Base 
{	

	 public function base($f3) {
        
        $view = new \View;
        echo $view->render('header/header.php');
     }
     public function customer($f3) {
        $view = new \View;
        echo $view->render('header/header.php');
     }
}
