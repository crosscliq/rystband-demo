<?php 
namespace Dash\Controllers;

class Placeholder extends Base 
{
    


    public function display() {

    	$view = new \Dsc\Template;
        echo $view->render('Dash/Views::dashboard/home.php');
    }


    public function placeholder() {
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::placeholder/placeholder.php');
    }

}
?>