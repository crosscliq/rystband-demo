<?php 

namespace Dash\Models\Event;

Class Event {


	function getAllEventInfo($event_id, $collection = null) {
	$f3 = \Base::instance();

	$event = array();

        $model = new \Dash\Models\Events;
        $model->setFilter('event_id', $event_id);
        $event['details'] = $model->getItem();

        $f3->set('eventid',  $event['details']->event_id);

        $model = new \Dash\Models\Event\Attendees;
        $event['attendees'] = $model->paginate();
        $model = new \Dash\Models\Event\Attendees;
        $model->emptyState();
        $model->setState('filter.offers.sms', true);
        $event['smsoptin'] = $model->getTotal();
        $model = new \Dash\Models\Event\Attendees;
        $model->emptyState();
        $model->setState('filter.offers.email', 'on');
        $event['emailoptin'] = $model->getTotal();

        $model = new \Dash\Models\Event\Wristbands;
        
        $event['wristbands'] = array();
        $event['wristbands']['withTicketsOnly'] = (int) $model->withTicketsOnly();
        $event['wristbands']['withAttendeesOnly'] = (int) $model->withAttendeesOnly();
        $event['wristbands']['withAttendeesAndTickets'] = (int) $model->withAttendeesAndTickets();
        $event['wristbands']['withNOAttendeesAndTickets'] = (int) $model->withNOAttendeesAndTickets();
        $event['wristbands']['total'] =  $event['details']->wristbands['ordered'];
        $event['wristbands']['used'] = $event['wristbands']['withTicketsOnly'] + $event['wristbands']['withAttendeesOnly'] + $event['wristbands']['withAttendeesAndTickets'] + $event['wristbands']['withNOAttendeesAndTickets'];
        $event['wristbands']['available'] = (int) $event['wristbands']['total'] - (int) $event['wristbands']['used'];



        //$model = new \Dash\Models\Event\Prizes;
        //$event['prizes'] = $model->paginate();

        //$model = new \Dash\Models\Event\Users;
        //$event['users'] = $model->paginate();
	

        $model = new \Dash\Models\Event\Tickets;
        
        $event['tickets'] = array();
        $model->setState('filter.status', 'active');
        $event['tickets']['active'] = $model->getTotal();
        $model->setState('filter.status', 'redeemed');
        $event['tickets']['redeemed'] = $model->getTotal();
        $event['tickets']['total'] = $model->getTotalCount();

       
        $model = new \Dash\Models\Event\Activities;
	 $model->setState('list.limit', 100);
        $paginated = $model->paginate();
        $list = array();
        foreach ($paginated['subset'] as $activity ) {
           $helper = new \Dash\Helpers\Activity($activity);
          $list[] = $helper->getData();      
        }
        $paginated['subset'] = $list;
         $event['activities'] =$paginated;
        


        return $event;



	}







}
