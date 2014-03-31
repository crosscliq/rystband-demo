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
        
        // initialize Facebook class using your own Facebook App credentials
        // see: https://developers.facebook.com/docs/php/gettingstarted/#install
        $config = array();
        $config['appId'] = '108795075865055';
        $config['secret'] = '34bf0bfb1ede7a0f7cb5febf00c47ed0';
        $config['fileUpload'] = false; // optional
         
        $fb = new \Facebook($config);
         
        // define your POST parameters (replace with your own values)
        $params = array(
          "access_token" => "CAABi8tPZAqd8BACIO6UiSsCCneV6B4xemwuYfeUjlbhyRM3EswQ30aaQFHvPG7tH70IWcZCCJg3k9FsBYIcijo6S7GtsMD8jdvrtrbxZAFh3c0rmebycJX4Xvxm3jMU4ZAjSNBtlqM6CoTv61JGdH4mIaSDALqZBEMEFAGIvyCVuWVQDoM25yfqUFyhiQsO0ZD", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/
          "message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
          "link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
          "picture" => "http://i.imgur.com/lHkOsiH.png",
          "name" => "How to Auto Post on Facebook with PHP",
          "caption" => "www.pontikis.net",
          "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
        );
         
        // post to Facebook
        // see: https://developers.facebook.com/docs/reference/php/facebook-api/
        try {
          $ret = $fb->api('/chrissneakattack/feed', 'POST', $params);
          echo 'Successfully posted to Facebook';
        } catch(\Exception $e) {
          echo $e->getMessage();
        }
       
    }

    

    

}
?> 
