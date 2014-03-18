<?php 
$f3 = \Base::instance();
$global_app_name = $f3->get('APP_NAME');

switch ($global_app_name) 
{
    case "site":
        // register event listener
        \Dsc\System::instance()->getDispatcher()->addListener(\Rystband\Userlistener::instance());
        \Dsc\System::instance()->getDispatcher()->addListener(\Rystband\Pusherlistener::instance());
        //fixing a view bug where I shouldn't call my app Site
        
        //
        $f3->config( $f3->get('PATH_ROOT').'apps/Rystband/config.ini');
        //HEADERS ROUTES, these are so JS can call the headers TODO maybe move to this php logic
        $f3->route('GET /header', '\Rystband\Controllers\Header->base');
        $f3->route('GET /header-cust', '\Rystband\Controllers\Header->customer');

        $f3->route('GET /soap', '\Rystband\Controllers\Attendees->soap'); 
        //USERS FRONTEND AUTH ROUTES, creates signup, and login, logout routes
        $f3->route('GET /', function($f3) {
           $f3->reroute('/welcome');
        });
       
        $f3->route('GET /home', '\Rystband\Controllers\Auth->showLogin');
        $f3->route('POST /home', '\Rystband\Controllers\Auth->doLogin');     
        
        $f3->route('GET /login', '\Rystband\Controllers\Auth->showLogin'); 
        $f3->route('POST /login', '\Rystband\Controllers\Auth->doLogin');
        $f3->route('GET /signup', '\Rystband\Controllers\Auth->showSignup');
        $f3->route('POST /signup', '\Rystband\Controllers\Auth->doSignup');
        $f3->route('GET|POST /logout', '\Users\Rystband\Controllers\User->logout');     
        $f3->route('GET /roles', '\Rystband\Controllers\Users->roles');
        $f3->route('GET /active/role/@roleid', '\Rystband\Controllers\Users->role');
        //Tag Parser
        $f3->route('GET /band/@tagid', '\Rystband\Controllers\Tags->action');
        $f3->route('GET /band/@tagid/selfsignup', '\Rystband\Controllers\Selfregister->selfsignin');
        $f3->route('POST /band/@tagid/selfsignup', '\Rystband\Controllers\Selfregister->add');
        $f3->route('GET /band/@id/registerconfirm', '\Rystband\Controllers\Selfregister->registerconfirm');
        $f3->route('GET /band/@tagid/alreadyregistered', '\Rystband\Controllers\Selfregister->alreadyregistered');
        $f3->route('GET /empty', '\Rystband\Controllers\Tags->displayEmpty');

         $f3->route('POST /self/assign/tag/@tagid', '\Rystband\Controllers\Selfregister->assign');
        $f3->route('GET /self/signin/@tagid', '\Rystband\Controllers\Selfregister->signin');
        
        //Attendee Reg pages
        $f3->route('GET /attendee', '\Rystband\Controllers\Attendees->display');
        $f3->route('POST /attendee/assign/tag/@tagid', '\Rystband\Controllers\Attendee->assign');
        $f3->route('GET /attendee/signin/@tagid', '\Rystband\Controllers\Attendee->signin');
        $f3->route('GET /attendee/create/@tagid', '\Rystband\Controllers\Attendee->create');
        $f3->route('POST /attendee/create/@tagid', '\Rystband\Controllers\Attendee->add');
        $f3->route('GET /attendee/edit/@id', '\Rystband\Controllers\Attendee->edit');
        $f3->route('GET /attendee/customer/@id', '\Rystband\Controllers\Attendee->attendee');
        $f3->route('POST /attendee/customer/update/@id', '\Rystband\Controllers\Attendee->update');
        $f3->route('GET /attendee/confirm/@id', '\Rystband\Controllers\Attendee->confirm');
        // TODO set some app-specific settings, if desired
        //Ticketing pages
        $f3->route('GET /ticketing', '\Rystband\Controllers\Ticketing->display');
        $f3->route('GET /ticketing/create/@id', '\Rystband\Controllers\Ticketing->create');
        $f3->route('POST /ticketing/create/@id', '\Rystband\Controllers\Ticketing->add');
        $f3->route('GET /ticketing/edit/@id', '\Rystband\Controllers\Ticketing->edit');
        $f3->route('GET /ticketing/confirm/@id', '\Rystband\Controllers\Ticketing->confirm');

         //Transfer pages
        $f3->route('GET /transfer', '\Rystband\Controllers\Transfer->home');
        $f3->route('GET /transfer/origin/@id', '\Rystband\Controllers\Transfer->origin');
        $f3->route('GET /transfer/destination/@tagid', '\Rystband\Controllers\Transfer->destination');
        $f3->route('GET /transfer/notempty/@tagid', '\Rystband\Controllers\Transfer->notempty');
        $f3->route('GET /transfer/empty/@tagid', '\Rystband\Controllers\Transfer->isempty');


         //Meet greet Reg pages
        $f3->route('GET /meetgreet', '\Rystband\Controllers\Meetgreets->display');
        $f3->route('GET /meetgreet/create/@tagid', '\Rystband\Controllers\Meetgreet->create');
        $f3->route('POST /meetgreet/create/@tagid', '\Rystband\Controllers\Meetgreet->add');
        $f3->route('GET /meetgreet/edit/@id', '\Rystband\Controllers\Meetgreet->edit');
        $f3->route('GET /meetgreet/customer/@tagid', '\Rystband\Controllers\Meetgreet->meetgreet');
        $f3->route('POST /meetgreet/customer/update/@id', '\Rystband\Controllers\Meetgreet->update');
        $f3->route('GET /meetgreet/confirm/@id', '\Rystband\Controllers\Meetgreet->confirm');
        
          //Meet greet Reg pages
        $f3->route('GET /gatekeeper', '\Rystband\Controllers\Gatekeeper->display');
        $f3->route('GET /gatekeeper/ticket/ok/@ticketid', '\Rystband\Controllers\Gatekeeper->ok');
        $f3->route('GET /gatekeeper/ticket/bad/@ticketid', '\Rystband\Controllers\Gatekeeper->bad');
       

        $f3->route('GET /mc', '\Rystband\Controllers\Mc->display');

        $f3->route('GET /games/raffle', '\Rystband\Controllers\Games\Raffle->display');
        $f3->route('POST /games/raffle/play', '\Rystband\Controllers\Games\Raffle->play');
        $f3->route('GET /games/raffle/winners', '\Rystband\Controllers\Games\Raffle->winners');
        $f3->route('GET /games/raffle/nomorewinners', '\Rystband\Controllers\Games\Raffle->nomorewinners');
        $f3->route('GET /prizepatrol', '\Rystband\Controllers\Prizepatrol->display');

        $f3->route('GET /privacy/policy', '\Rystband\Controllers\Privacy->display');
        
        $f3->route('GET|POST /logout', function() {
             \Base::instance()->clear('SESSION');
             \Base::instance()->clear('COOKIE');
             setcookie('id','',time()-3600);
             \Base::instance()->reroute('/');
        });          
        
        // append this app's UI folder to the path
        $ui = $f3->get('UI');
        $ui .= ";" . $f3->get('PATH_ROOT') . "apps/Rystband/Views/";
        $f3->set('UI', $ui);


         $f3->route('POST /sysauth', '\Rystband\Controllers\Login->sysauth'); 

         $f3->route('GET /welcome', '\Rystband\Controllers\Home->own');

         $f3->route('GET /device/@name', '\Rystband\Controllers\Device->route'); 
         $f3->route('GET /content/@name', '\Rystband\Controllers\Devices\Content->@name');
         $f3->route('GET /content/car', '\Rystband\Controllers\Devices\Content->car');  

         $f3->route('POST /band/@tagid', '\Rystband\Controllers\Devices\Content->carrequest');
        

        break;

         case "device":
             $f3->route('POST /band/@tagid', '\Rystband\Controllers\Device->tap');
         break;
}
?>
