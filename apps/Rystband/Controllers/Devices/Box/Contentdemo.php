<?php 
namespace Rystband\Controllers\Devices\Box;

class Contentdemo extends \Rystband\Controllers\Devices\Base 
{   
    var $pusher = null;

    public function index($device, $tag) {
	
	 if(empty($tag)) {

          echo ' This band has no wristband tag in the tags collection'. "\n";
          return;
        }


        $f3 = \Base::instance();
       
       	$attendees = new \Rystband\Models\Attendees;
  	    $attendees->setState('filter.id', $tag->{'attendee.id'});
  	    $attendee = $attendees->getItem();
        	//trigger screen

        if(@$device->display)  {
        		$displays = new \Dash\Site\Models\Event\Devices;
        		$display = $displays->setState('filter.device_id', $device->display)->getItem();
	        	$pusher = new \Pusher($display->{'pusher.public'}, $display->{'pusher.private'}, $display->{'pusher.app_id'});
    			$data = array('device' => (array) $device->cast(), 'tag' => (array) $tag->cast(), 'attendee' => (array) $attendee->cast());
    			$pusher->trigger($display->{'pusher.channel'}, $display->{'action'}, $data);
                
                $displays = new \Dash\Site\Models\Event\Devices;
                $display = $displays->setState('filter.device_id', $device->display)->getItem();
                $pusher = new \Pusher($display->{'pusher.public'}, $display->{'pusher.private'}, $display->{'pusher.app_id'});
                $data = array('device' => (array) $device->cast(), 'tag' => (array) $tag->cast(), 'attendee' => (array) $attendee->cast(), 'game' => (array) $this->gamePlay());
                $pusher->trigger($display->{'pusher.channel'}, 'game_spin', $data);

        }

        // trigger phone 
            $pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id'));
		    $data = array('device' => (array) $device->cast(), 'tag' => (array) $tag->cast(), 'attendee' => (array) $attendee->cast(), 'content' => '/content/car' );
		
		    $pusher->trigger($tag->tagid, 'content', $data);

    }

    protected function gamePlay() {

        $rand = rand(1, 10); 

        switch ( $rand) {
          case  ($rand < "5"):
            $array = array('status' => 'winner', 'prize' => array('name' => 'Prize name', 'prize_id' => 122, 'prize_image' => 'http://placehold.it/350x350?text=Awesome+Prize'));
                break;
            default:
              $array = array('status' => 'loser', 'prize' => array());
                break;
        }	
	return $array;
    }


    

    

}
?> 
