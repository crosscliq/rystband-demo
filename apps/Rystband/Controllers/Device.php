<?php 
namespace Rystband\Controllers;

class Device extends Base 
{   

    
     public function display()
    {
        \Base::instance()->set('pagetitle', 'Privacy Policy');
        \Base::instance()->set('subtitle', '');
                
        $view = new \Dsc\Template;
        echo $view->render('device/view.php');
    }





    protected function createDevice($uid) {

    }

    //handles displays and public routes
    public function route() {

        $f3 = \Base::instance();
        $f3->set('eventid', $f3->get('event.db'));

        $devices = new \Dash\Site\Models\Event\Devices;

        $uid = $this->inputfilter->clean( $f3->get('PARAMS.name'), 'alnum' );
        $model = $devices->setState('filter.device_id', $uid);
        
        try {
            $item = $model->getItem();

         

            if($item) {
                $controller = new $item->controller;
                $action = $item->action;
                $controller->$action($item);
                

            } 


           /* $route = \Base::instance()->get('PARAMS[0]');
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

            */

        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
           
            return;
        }    


    }


    //handles crossboxes
    public function tap() {
    	$f3 = \Base::instance();
    	$devices = new \Dash\Site\Models\Event\Devices;

		$uid = $this->inputfilter->clean( $f3->get('POST.uid'), 'alnum' );
		$model = $devices->setState('filter.device_id', $uid);
		


		try {
			$item = $model->getItem();

            if($item) {

                $route = \Base::instance()->get('PARAMS[0]');
                $peices = explode('/', $route);
                $id = end($peices);
                
                $tags = new \Rystband\Models\Tags;
                $tags->setState('filter.tagid', $id);
                $tag = $tags->getItem();

                $controller = new $item->controller;
                $action = $item->action;
                $controller->$action($item, $tag);


            } else {
               $model->createDevice($uid);
            }


			
        
			

			$pusher = new \Pusher($item->{'pusher.public'}, $item->{'pusher.private'}, $item->{'pusher.app_id'});
			$data = array('route' => $f3->get('PARAMS.0'), 'msg' => $item->{'message'}, 'authkey' => $attendee->authkey);
			$pusher->trigger($channel, $item->{'action'}, $data);

			echo 1;

		} catch ( \Exception $e ) {
			\Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
            echo  $e->getMessage();
			echo 0;
			return;
		}


    }
}
?> 