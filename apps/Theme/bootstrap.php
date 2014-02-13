<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "site":
        $f3->set('UI_OVERRIDES', $f3->get('PATH_ROOT') . "apps/Theme/Views" );

          // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "apps/Theme/Views/";
        $f3->set('UI', $ui);
        
        // append this app's template folder to the path
        $templates = $f3->get('TEMPLATES');
        $templates .= ";" . $f3->get('PATH_ROOT') . "apps/Theme/Templates/";
        $f3->set('TEMPLATES', $templates);
        
         // register the less css file
       // \Minify\Factory::registerLessCssSource( $f3->get('PATH_ROOT') . "apps/Theme/Less/global.less.css" );
        
        // add the media assets to be minified        
        $files = array(
            'site/js/jquery/jquery.min.js',
            'site/js/jquery/jquery.widget.min.js',
            'site/js/jquery/jquery.mousewheel.js',
            'site/js/prettify/prettify.js',
            'site/js/load-metro.js',
            'site/js/docs.js'
        );
        
        foreach ($files as $file) 
        {
            \Minify\Factory::js($file);
        }
        
        $files = array(
            'site/css/metro-bootstrap.css',
            'site/css/metro-bootstrap-responsive.css',
            'site/css/docs.css',
            'site/js/prettify/prettify.css',
            'site/css/style.css'
        );

        foreach ($files as $file)
        {
            \Minify\Factory::css($file);
        }
        
        \Minify\Factory::registerPath($f3->get('PATH_ROOT') . "public/site/");
        \Minify\Factory::registerPath($f3->get('PATH_ROOT') . "public/images/");       
       
        
        
        break;
}
?>
