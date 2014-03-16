<?php 
namespace Rystband\Controllers\Devices\Box;

class Demoaction extends \Rystband\Controllers\Devices\Base 
{   
    var $pusher = null;


 
    public function index($device, $tag) {
        $f3 = \Base::instance();
       	
       	$attendees = new \Rystband\Models\Attendees;
	    $attendees->setState('filter.id', $tag->{'attendee.id'});
	    $attendee = $attendees->getItem();
      	//trigger screen
        if($device->display)  {

        		$displays = new \Dash\Site\Models\Event\Devices;
        		$display = $displays->setState('filter.device_id', $device->display)->getItem();
				
				
	        	

	        	$pusher = new \Pusher($display->{'pusher.public'}, $display->{'pusher.private'}, $display->{'pusher.app_id'});

				$data = array('device' => (array) $device->cast(), 'tag' => (array) $tag->cast(), 'attendee' => (array) $attendee->cast());
				$pusher->trigger($display->{'pusher.channel'}, $display->{'action'}, $data);
        }

        // trigger phone 
        $pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id'));
		$data = array('device' => (array) $device->cast(), 'tag' => (array) $tag->cast(), 'attendee' => (array) $attendee->cast());
		
		$pusher->trigger($tag->tagid, 'index', $data);




    }

    

}
?> 