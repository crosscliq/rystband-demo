<?php 
namespace Dash\Models\Event;


Class Wristbands Extends Eventbase {

    protected $collection = 'tags';
    protected $default_ordering_direction = '1';
    protected $default_ordering_field = 'type';

    public function __construct($config=array())
    {
        $config['filter_fields'] = array(
            'name', 'start_date', 'end_date'
        );
        $config['order_directions'] = array('1', '-1');
        
        parent::__construct($config);
    }

    public function getPrefab() {
        $prefab = New \Dash\Models\Prefabs\Wristband();
        return $prefab;
    }
    
    protected function fetchFilters()
    {   
       
        $filter_keyword = $this->getState('filter.keyword');
        if ($filter_keyword && is_string($filter_keyword))
        {
            $key =  new \MongoRegex('/'. $filter_keyword .'/i');
    
            $where = array();
            $where[] = array('name'=>$key);
            $where[] = array('slug'=>$key);
            $where[] = array('event_id'=>$key);
            $where[] = array('start_date'=>$key);
            $where[] = array('end_date'=>$key);
  
    
            $this->filters['$or'] = $where;
        }
    
        $filter_id = $this->getState('filter.id');
        
        if (strlen($filter_id))
        {
            $this->filters['_id'] = new \MongoId((string) $filter_id);
        }

        $filter_tagid = $this->getState('filter.tagid');
        
        if (strlen($filter_tagid))
        {
            $this->filters['tagid'] = $filter_tagid;
        }


        $filter_eventid = $this->getState('filter.eventid');

        if (strlen($filter_eventid))
        {
            $this->filters['eventid'] = $filter_eventid;
        }


        $filter_slug = $this->getState('filter.slug');

        if (strlen($filter_slug))
        {
            $this->filters['slug'] = $filter_slug;
        }

        $filter_keyword = $this->getState('filter.keyword');


         if ($filter_keyword && is_string($filter_keyword))
        {
            $key =  new \MongoRegex('/'. $filter_keyword .'/i');
    
            $where = array();
            $where[] = array('name'=>$key);
            $where[] = array('slug'=>$key);
            $where[] = array('event_id'=>$key);
            $where[] = array('start_date'=>$key);
            $where[] = array('end_date'=>$key);
  
    
            $this->filters['$or'] = $where;
        }
        

        $filter_has_ticket = $this->getState('filter.has.ticket');
        

        if (strlen($filter_has_ticket))
        {
         $this->filters['ticket'] = array( '$ne' => array() );
        }

        $filter_has_attendee = $this->getState('filter.has.attendee');

        if (strlen($filter_has_attendee))
        {
        $this->filters['attendee'] = array( '$ne' => array() );

        }

        $filter_no_ticket = $this->getState('filter.no.ticket');
        
        if (strlen($filter_no_ticket))
        {
         $this->filters['ticket'] = array( '$size' => 0 );
        
        }

        $filter_no_attendee = $this->getState('filter.no.attendee');
        
        if (strlen($filter_no_attendee))
        {
         $this->filters['attendee'] =array( '$size' => 0 );
        
        }

    
        return $this->filters;
    }

 function getTotalCount() {
        $this->emptyState();
        return $this->getTotal();
    }

    function withTicketsOnly() {
        $this->emptyState();
        $this->setState('filter.no.attendee', '1');
        $this->setState('filter.has.ticket', '1');
        return $this->getTotal();
    }

    function withAttendeesOnly() {
        $this->emptyState();
        $this->setState('filter.has.attendee', '1');
        $this->setState('filter.no.ticket', '1');
        return $this->getTotal();
    }

    function withAttendeesAndTickets() {
        $this->emptyState();
        $this->setState('filter.has.attendee', '1');
        $this->setState('filter.has.ticket', '1');
        return $this->getTotal();
    }

    function withNOAttendeesAndTickets() {
        $this->emptyState();
        $this->setState('filter.no.attendee', '1');
        $this->setState('filter.no.ticket', '1');
        return $this->getTotal();
    }


     public function getTotal()
    {
        
        $filters = $this->getFilters();
        $mapper = $this->getMapper();
        $count = $mapper->count($filters);
    
        return $count;
    }

}

?>
