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
        $tagid = $f3->get('PARAMS.tagid');
        $tags = new \Rystband\Models\Tags;
        $tags->setState('filter.tagid', $tagid);
        $tag = $tags->getItem();

        $attendees = new \Rystband\Models\Attendees;
        $attendees->setState('filter.id', $tag->{'attendee.id'});
        $attendee = $attendees->getItem();

        $pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id'));
        $data = array('feature' => $f3->get('POST.feature'), 'attendee' => (array) $attendee->cast() );
        $pusher->trigger('cardisplay', 'post', $data);
    	
        $f3->set('tag', $tag);
        $f3->set('tagid', $tagid);

        $route = \Base::instance()->get('PARAMS[0]');
        $peices = explode('/', $route);
        $channel = end($peices);
       
        $f3->set('channel', $channel);
      
        if(empty($tag->attendee)) {
            $f3->set('showselfregister', true);
            $view = new \Dsc\Template;
            echo $view->render('Msft/Views::attendee/own.php');
        } else {
             $f3->set('showselfregister', false);
            $view = new \Dsc\Template;
            echo $view->render('Msft/Views::attendee/own.php');
        }

    }


}


?> 
