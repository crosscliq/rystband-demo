<?php 
namespace Rystband\Controllers\Devices;

class Photo extends Base 
{   
    var $pusher = null;
    
    public function index($item) {
        $f3 = \Base::instance();
        $f3->set('item',$item );
       
        $view = new \Dsc\Template;
        echo $view->render('device/'.$item->type.'/index.php');

    }

    public function processImage() {


            $route = \Base::instance()->get('PARAMS[0]');
            $peices = explode('/', $route);
            $channel = end($peices);
            
            $tags = new \Rystband\Models\Tags;
            $tags->setState('filter.tagid', $channel);
            $tag = $tags->getItem();

            $attendees = new \Rystband\Models\Attendees;
            $attendees->setState('filter.id', $tag->{'attendee.id'});
            $attendee = $attendees->getItem();

            $overwrite = false; // set to true, to overwrite an existing file; Default: false
            $slug = true; // rename file to filesystem-friendly version
            
            $web = \Web::instance();
    
            $files = $web->receive(function($file){
                // maybe you want to check the file size
                if($file['size'] > (2 * 1024 * 1024)) // if bigger than 2 MB
                    return false; // this file is not valid, return false will skip moving it

                // everything went fine, hurray!
                return true; // allows the file to be moved from php tmp dir to your defined upload dir
            },
            $overwrite,
            $slug
        );

            $attendee->files = $files;

            $attendee->save();

            $f3->set('channel', $channel);
        
            

    }

    


    public function message($msg = null) {
		

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


}
?> 