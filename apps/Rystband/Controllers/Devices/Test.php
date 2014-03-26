<?php 
namespace Rystband\Controllers\Devices;

class Test extends Base 
{   
    var $pusher = null;

   
    
    public function message($msg = null) {
echo ' you used the text controller' . $msg;

	$route = \Base::instance()->get('PARAMS[0]');
         	$peices = explode('/', $route);
        	$channel = end($peices);


       		
        	$tags = new \Rystband\Models\Tags;
        	$tags->setState('filter.tagid', $channel);
        	$tag = $tags->getItem();



        	$attendees = new \Rystband\Models\Attendees;
        	$attendees->setState('filter.id', $tag->{'attendee.id'});
        	$attendee = $attendees->getItem();

        	$attendee->authkey = rand();
        	$attendee->save();

        	$f3->set('channel', $channel);
        
			

			$pusher = new \Pusher($item->{'pusher.public'}, $item->{'pusher.private'}, $item->{'pusher.app_id'});
			$data = array('route' => $f3->get('PARAMS.0'), 'msg' => $item->{'message'}, 'authkey' => $attendee->authkey);
			$pusher->trigger($channel, $item->{'action'}, $data);



    }

    public function login() {


    	
    }


}
?> 