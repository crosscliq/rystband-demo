<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "sales":
  
        $f3->route('GET /', function($f3) {

            
        $view = new \Dsc\Template;
        echo $view->render('home/default.php');
        });
        $f3->route('GET /features', function($f3) {

            
        $view = new \Dsc\Template;
        echo $view->render('features/default.php');
        });

        
        $f3->route('GET /features/golf', function($f3) {

            
        $view = new \Dsc\Template;
        echo $view->render('features/golf.php');
        });


        // TODO set some app-specific settings, if desired
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "apps/Sales/Views/";
        $f3->set('UI', $ui);
        
        // append this app's template folder to the path
        $templates = $f3->get('TEMPLATES');
        $templates .= ";" . $f3->get('PATH_ROOT') . "apps/Sales/Templates/";
        $f3->set('TEMPLATES', $templates);
        

        //\Modules\Factory::registerPositions( array('nav', 'footer', 'above-content', 'below-content') );
        //\Modules\Factory::registerPath( $f3->get('PATH_ROOT') . "apps/Sales/Modules/" );
        
        break;

       
}
?>