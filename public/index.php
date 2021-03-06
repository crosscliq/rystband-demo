<?php

ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);
if(!empty($_COOKIE['id'])) {
session_id($_COOKIE['id']);
}

$app = require('../vendor/bcosca/fatfree/lib/base.php');
$app->set('HOST', $_SERVER['HTTP_HOST']);
$app->set('PATH_ROOT', __dir__ . '/../');
$app->set('AUTOLOAD',
        $app->get('PATH_ROOT') . 'lib/;' .
        $app->get('PATH_ROOT') . 'apps/;'
);

$app->config( $app->get('PATH_ROOT') . 'config/common.config.ini');

require $app->get('PATH_ROOT') . 'vendor/autoload.php';


$app->set('db.jig.dir', $app->get('PATH_ROOT') . 'jig/');


$app->set('APP_NAME', 'site');
//TODO maybe we query the event model, and get the event object from the main DB and load it. so than we can  let the DB be controlled by the dash

$app->set('event.db', strtolower(explode(".",$_SERVER['HTTP_HOST'])[0]));
if ($app->get('event.db') == 'dashboard') {
    $app->set('APP_NAME', 'dash');
}

if ($app->get('event.db') == 'admin') {
    $app->set('APP_NAME', 'admin');
}
if ($app->get('event.db') == 'rystband') {
    $app->set('APP_NAME', 'sales');
}
if ($app->get('event.db') == 'www') {
    $app->set('APP_NAME', 'sales');
}




if($app->get('event.db') != 'admin' && $app->get('event.db') != 'dashboard' && !empty($app->get('event.db') && $app->get('event.db') != 'rystband'  && $app->get('event.db') != 'www' ) ) {

//WE are loading an event
//HERE WE CAN CHECK THIS IT IS A VALID EVENT REGISTERED AND SUCH

$model = new \Dash\Site\Models\Events;
$item = $model->setState('filter.eventid', $app->get('event.db'))->getItem();
$app->set('SESSION.event', $item );
$app->set('APP_NAME', 'site');
}

if (empty($app->get('event.db'))) {
    $app->set('event.db', 'rystband');
}

if (strpos($app->get('AGENT'), 'CROSSCLIQ')) {
    $app->set('APP_NAME', 'device');
    $app->set('eventid', $app->get('event.db'));

}

$logger = new \Log( $app->get('application.logfile') );
\Registry::set('logger', $logger);

if ($app->get('DEBUG')) {
    ini_set('display_errors',1);
}

// bootstap each mini-app
\Dsc\Apps::instance()->bootstrap();

// load routes
\Dsc\System::instance()->get('router')->registerRoutes();
 
// trigger the preflight event
\Dsc\System::instance()->preflight();

/*
$db_name = \Base::instance()->get('db.mongo.name');
$db = new \DB\Mongo('mongodb://localhost:27017', $db_name);
new \DB\Mongo\Session($db);
*/
$app->set('UPLOADS','uploads/'); // don't forget to set an Upload directory, and make it writable!

$app->route('POST /uploadtest',
    function() {
	$overwrite = false; // set to true, to overwrite an existing file; Default: false
$slug = true; // rename file to filesystem-friendly version
$web = \Web::instance();
	
	$files = $web->receive(function($file){
        var_dump($file);
        /* looks like:
          array(5) {
              ["name"] =>     string(19) "csshat_quittung.png"
              ["type"] =>     string(9) "image/png"
              ["tmp_name"] => string(14) "/tmp/php2YS85Q"
              ["error"] =>    int(0)
              ["size"] =>     int(172245)
            }
        */
        // $file['name'] already contains the slugged name now

        // maybe you want to check the file size
        if($file['size'] > (2 * 1024 * 1024)) // if bigger than 2 MB
            return false; // this file is not valid, return false will skip moving it

        // everything went fine, hurray!
        return true; // allows the file to be moved from php tmp dir to your defined upload dir
    },
    $overwrite,
    $slug
);

    }
);






$app->run();


?>
