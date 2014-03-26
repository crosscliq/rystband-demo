<?php 
namespace Rystband\Controllers;

class Gatekeeper extends BaseAuth 
{

    
    public function display()
    {
        \Base::instance()->set('pagetitle', 'Settings');
        \Base::instance()->set('subtitle', '');
        
        $view = new \Dsc\Template;
        echo $view->render('gatekeeper/home.php');
    }

    public function ok()
    {   $f3 = \Base::instance();

        $f3->set('pagetitle', 'Ticket OK');
        $f3->set('subtitle', '');
        
        $attendee = new \Rystband\Models\Attendees;
        $f3->set('attendee', $attendee->setState('filter.ticket_id', $f3->get('PARAMS.ticketid'))->getItem());

        $view = new \Dsc\Template;
        echo $view->render('gatekeeper/ok.php');
    }

    public function bad()
    {   $f3 = \Base::instance();

       $f3->set('pagetitle', 'Ticket BAD');
       $f3->set('subtitle', '');
        
        $attendee = new \Rystband\Models\Attendees;
        $f3->set('attendee', $attendee->setState('filter.ticket_id', $f3->get('PARAMS.ticketid'))->getItem());
    

        $view = new \Dsc\Template;
        echo $view->render('gatekeeper/bad.php');
    }

      public function noTicket()
    {
        \Base::instance()->set('pagetitle', 'No Ticket');
        \Base::instance()->set('subtitle', '');
        
        $view = new \Dsc\Template;
        echo $view->render('gatekeeper/no.php');
    }




    
}