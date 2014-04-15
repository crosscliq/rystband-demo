<?php 
namespace Rystband\Controllers;

class Tags extends Base 
{	

	 protected function getModel() 
    {
        $model = new \Rystband\Models\Tags;
        return $model; 
    }



    public function action($f3)
    {
        $tagid = $f3->get('PARAMS.tagid');
        $model = $this->getModel()->setState('filter.tagid', $tagid);
    	$tag = $model->getItem();

    	$role = $f3->get('SESSION.active_role');
    	switch ($role) {
    		//Attendee Registration, we check to see if the tag is assigned to a user and bring up an new / edit form.
    		case 'attendee_registration':

    			//If the tag doesn't exist lets create a new empty tag
//    			if(empty($tag)) {
    				$tag = $this->getModel()->getPrefab();
    				$tag->tagid = $tagid;
    				$tag->eventid = $f3->get('PARAMS.eventid');
    				$tag = $model->create((array) $tag);
  //  			}

    			$this->attendeeRegistration($tag, $tagid, $role);
    			break;
    		//Ticketing is  after they are in line they go inside and their ticket is actived
    		case 'ticketing':
    			$this->ticketing($tag, $tagid, $role);
    			break;
    		//
    		case 'prize_patrol':
    			$this->prizePatrol($tag, $tagid, $role);
    			break;
    		case 'meet_greet':
    			$this->meetGreet($tag, $tagid, $role);
    			break;
    		case 'gate_keeper':
    			$this->gateKeeper($tag, $tagid, $role);
    			break;
            case 'band_transfer':
                $this->bandTransfer($tag, $tagid, $role);
                break;
             case 'mc':
                $this->notallowed($tag, $tagid, $role);
                break;
            case 'processcart':
                $this->processCart($tag, $tagid, $role);
                break;   
    		default:
           
    			$this->attendeeTapper($tag, $tagid, $role);
    			break;
    	}
    }
   
    protected function bandTransfer($tag,$tagid,$role) {
        $f3 =  \Base::instance();

        if(!empty($tag->_id) && empty($f3->get('SESSION.transfer'))) {
            $f3->reroute('/transfer/origin/'.$tag->_id);
        }
        if(empty($tag->_id) && !empty($f3->get('SESSION.transfer'))) {
            $f3->reroute('/transfer/destination/'.$tagid);
        }
        if(!empty($tag->_id) && !empty($f3->get('SESSION.transfer'))) {
            $f3->reroute('/transfer/notempty/'.$tagid);
        }


        if(empty($tag->_id)) {
            \Base::instance()->reroute('/transfer/empty/'.$tagid);
        }

        
    }

    //Attendee Registration, we check to see if the tag is assigned to a user and bring up an new / edit form.
    protected function attendeeRegistration($tag,$tagid,$role) {

    	if(empty($tag->attendee)) {
    		\Base::instance()->reroute('/attendee/create/'.$tag->_id);
    	} else {
    		\Base::instance()->reroute('/attendee/edit/'.$tag->attendee['id']);	
    	}
    	
    }

     //Attendee Registration, we check to see if the tag is assigned to a user and bring up an new / edit form.
    protected function processCart($tag,$tagid,$role) {

        \Base::instance()->reroute('/checkout/'.$tag->{'attendee.id'});

        
    }
    //Ticketing is  after they are in line they go inside and their ticket is actived
    protected function ticketing($tag, $tagid, $role) {
          $f3 = \Base::instance();
        

        /*
        If the Tag is Empty, we need to create it here as well.
        */
        if(empty($tag)) {
            $tag = $this->getModel()->getPrefab();
            $tag->tagid = $tagid;
            $tag->eventid = $f3->get('PARAMS.eventid');
            $tag = $this->getModel()->create((array) $tag);
        }
        $ticketModel = new \Rystband\Models\Tickets;
        if(empty($tag->ticket)) {

        $ticket = $ticketModel->getPrefab();
        $ticket->tag = array('tagid' => $tag->tagid , "id" => $tag->_id );
        $ticket = $ticketModel->create((array) $ticket);
       
        $model = $this->getModel( );
        $model->update($tag, array('ticket' => array( "id" => $ticket->_id, "status" => $ticket->status)));


        } else {
         $ticket = $ticketModel->setState('filter.id',$tag->ticket['id'])->getItem();   

        }


        \Base::instance()->reroute('/ticketing/confirm/'.$ticket->_id);

    
    }

    //Ticketing is  after they are in line they go inside and their ticket is actived
    protected function prizePatrol($tag, $tagid, $role) {
        $this->emptyTag($tag);
    }

    //
    protected function meetGreet($tag, $tagid, $role) {
        $this->emptyTag($tag);
    }

    //This goes to inside of the event
    protected function gateKeeper($tag, $tagid, $role) {
        /*  $f3 = \Base::instance();
         
-         if(empty($tag)) {
+        if(empty($tag)) {
             $tag = $this->getModel()->getPrefab();
             $tag->tagid = $tagid;
             $tag->eventid = $f3->get('PARAMS.eventid');
             $tag = $this->getModel()->create((array) $tag);
         }
        
-   if(empty($tag->ticket)) {   
         $ticketModel = new \Rystband\Models\Tickets;    
         $ticket = $ticketModel->getPrefab();
         $ticket->tag = array('tagid' => $tag->tagid , "id" => $tag->_id );
         $ticket = $ticketModel->create((array) $ticket);
-       
-        $model = $this->getModel( );
-        $model->update($tag, array('ticket' => array( "id" => $ticket->_id, "status" => $ticket->status)));
-}
- 
-        
-        if(empty($tag->ticket)) {
-            \Base::instance()->reroute('/gatekeeper/ticket/no/');
-        } else {
-
-
-         $ticketModel = new \Rystband\Models\Tickets;
-         $ticket = $ticketModel->setState('filter.id',$tag->ticket['id'])->getItem();
-             if(empty($ticket)) {
-                \Base::instance()->reroute('/gatekeeper/ticket/no/');
-             }  else {
-                if($ticket->redeemed) {
-                   \Base::instance()->reroute('/gatekeeper/ticket/bad/'.$ticket->_id);  
-                } else {
-                    $redeemed = \Dsc\Mongo\Metastamp::getDate('now');
-                    $status = 'redeemed';
+            
+         $redeemed = \Dsc\Mongo\Metastamp::getDate('now'); 
+         $status = 'redeemed';
+         $save =  $ticketModel->update($ticket, array('redeemed' => $redeemed, 'status' => $status ));
                     
-
-                    
-                   $save =  $ticketModel->update($ticket, array('redeemed' => $redeemed, 'status' => $status ));
-                    
-                    if($save) {
-                        $activity = new \Rystband\Models\Activity;
-                        $activity->create(array('type'=> 'ticket', 'action' => 'redeemed', 'object' => $save->cast()));
-                    }
-
-                    $tag->{'ticket.status'} = 'redeemed';
-                    $tag->save();  
-
-                    
-
-                   \Base::instance()->reroute('/gatekeeper/ticket/ok/'.$ticket->_id);
-                }
-
-
-             }
-
+        if($save) {
+            $activity = new \Rystband\Models\Activity;
+            $activity->create(array('type'=> 'ticket', 'action' => 'redeemed', 'object' => $save->cast()));
         }
 
-
+         \Base::instance()->reroute('/gatekeeper/ticket/ok/'.$ticket->_id);
+    

*/
         $f3 = \Base::instance();
        
        if(empty($tag)) {
            $tag = $this->getModel()->getPrefab();
            $tag->tagid = $tagid;
            $tag->eventid = $f3->get('PARAMS.eventid');
            $tag = $this->getModel()->create((array) $tag);
        }
		
        $ticketModel = new \Rystband\Models\Tickets;    
        $ticket = $ticketModel->getPrefab();
        $ticket->tag = array('tagid' => $tag->tagid , "id" => $tag->_id );
        $ticket = $ticketModel->create((array) $ticket);
            
         $redeemed = \Dsc\Mongo\Metastamp::getDate('now'); 
         $status = 'redeemed';
         $save =  $ticketModel->update($ticket, array('redeemed' => $redeemed, 'status' => $status ));
                    
        if($save) {
            $activity = new \Rystband\Models\Activity;
            $activity->create(array('type'=> 'ticket', 'action' => 'redeemed', 'object' => $save->cast()));
        }

         \Base::instance()->reroute('/gatekeeper/ticket/ok/'.$ticket->_id);
     
    }
    
    protected function attendeeTapper($tag, $tagid, $role) {
        $f3 =  \Base::instance();
        $f3->set('tag', $tag);
        $f3->set('tagid', $tagid);
         $route = \Base::instance()->get('PARAMS[0]');
         $peices = explode('/', $route);
        $channel = end($peices);
        $f3->set('channel', $channel);
       
        $model = $this->getModel()->setState('filter.tagid', $tagid);
        $tag = $model->getItem();
        if(empty($tag->attendee)) {
            $f3->set('showselfregister', true);
            $view = new \Dsc\Template;
	 $view->setLayout('content.php');        
    echo $view->render('Rystband/Views::attendee/own.php');
        } else {
             $f3->set('showselfregister', false);
            $view = new \Dsc\Template;
	 $view->setLayout('content.php');
            echo $view->render('Rystband/Views::attendee/own.php');
        }

       
    }

    //if there is an empty tag on a route that reqires a tag what do we do? error page or  what?
    protected function emptyTag($tag) {
        if(empty($tag)) {
           \Base::instance()->reroute('/empty');  
        }
    }

    //if there is an empty tag on a route that reqires a tag what do we do? error page or  what?
    public function notallowed($tag, $tagid, $role) {
        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::tags/notallow.php');
    }

    public function displayEmpty() {
        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::tags/empty.php');
    }

}
