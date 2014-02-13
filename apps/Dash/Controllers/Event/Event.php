<?php 
namespace Dash\Controllers\Event;

class Event extends \Dash\Controllers\BaseAuth 
{
    
    public function display($f3) {
        \Base::instance()->set('pagetitle', 'Events');
        \Base::instance()->set('subtitle', '');
        
        \Base::instance()->set('eventid', strtolower($f3->get('PARAMS.eventid')));



        $model = new \Dash\Models\Event\Event;
        
        $event = $model->getAllEventInfo($f3->get('PARAMS.eventid'));
       
        \Base::instance()->set('event', $event );
        
        $view = new \Dsc\Template;
        $view->setLayout('dash.php');
        echo $view->render('Dash/Views::event/dashboard.php');
    }

}


?>