<?php 
namespace Rystband\Controllers\Devices\Box;

class Social extends \Rystband\Controllers\Devices\Base 
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


    public function facebook() {
        // require Facebook PHP SDK
        
        $f3 = \Base::instance();

        $user = $f3->get('SESSION.user');

                if(!empty($user->{'social.facebook.profile'})) {
                // initialize Facebook class using your own Facebook App credentials
                // see: https://developers.facebook.com/docs/php/gettingstarted/#install
                $config = array();
                $config['appId'] = '108795075865055';
                $config['secret'] = '34bf0bfb1ede7a0f7cb5febf00c47ed0';
                $config['fileUpload'] = false; // optional
                 
                $fb = new \Facebook($config);
                 
                // define your POST parameters (replace with your own values)
                $params = array(
                  "access_token" => $user->{'social.facebook.access_token.access_token'}, // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
                  "message" => "Rystband tap to share demo, NFC powered wristband sharing facebook status #Rystband #facebook",
                  "link" => "http://www.rystband.com/",
                  "picture" => "http://www.rystband.com/sales/img/image2.png",
                  "name" => "Rystband tap to share demo",
                  "caption" => "www.rystband.com",
                  "description" => "Using Rystband nfc wristbands to tap and share  via the Crossbox from Crosscliq.com"
                );
                 
                // post to Facebook
                // see: https://developers.facebook.com/docs/reference/php/facebook-api/
                        try {
                          $ret = $fb->api('/'.$user->{'social.facebook.profile.username'}.'/feed', 'POST', $params);
                         
                          \Dsc\System::instance()->addMessage( 'Successfully posted to facebook!', 'message');

                        } catch(\Exception $e) {
                       
                           \Dsc\System::instance()->addMessage( $e->getMessage(), 'error');
                        }
                        finally {
                            $f3->reroute('/welcome');
                        }

                }


       
       
    }

    

    

}
?> 
