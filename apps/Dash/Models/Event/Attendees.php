<?php 
namespace Dash\Models\Event;


Class Attendees Extends Eventbase {

    protected $collection = 'attendees';
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
        $prefab = New \Dash\Models\Prefabs\Attendee();
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


        $filter_profile_complete = $this->getState('filter.profile.complete');

        if (strlen($filter_profile_complete))
        {
            $this->filters['first_name'] = array('$ne' => null);
            $this->filters['last_name'] = array('$ne' => null);
            $this->filters['phone'] = array('$ne' => null);
        }


        $filter_eventid = $this->getState('filter.eventid');

        if (strlen($filter_eventid))
        {
            $this->filters['eventid'] = $filter_eventid;
        }

        $filter_ticket_id = $this->getState('filter.ticket_id');

        if (strlen($filter_eventid))
        {
            $this->filters['ticket.id'] = $filter_ticket_id;
        }

        $filter_slug = $this->getState('filter.slug');

        if (strlen($filter_slug))
        {
            $this->filters['slug'] = $filter_slug;
        }

         $filter_first_name = $this->getState('filter.first_name');

        if (strlen($filter_first_name))
        {
            $this->filters['first_name'] = $filter_first_name;
        }

        $filter_last_name = $this->getState('filter.last_name');

        if (strlen($filter_last_name))
        {
            $this->filters['last_name'] = $filter_last_name;
        }

        $filter_phone = $this->getState('filter.phone');

        if (strlen($filter_phone))
        {
            $this->filters['phone'] = $filter_phone;
        }

        $filter_email = $this->getState('filter.email');

        if (strlen($filter_email))
        {
            $this->filters['email'] = $filter_email;
        }

        $filter_offers_sms = $this->getState('filter.offers.sms');
        
        if (strlen($filter_offers_sms))
        {
         $this->filters['offers.sms'] = (string) 'on';
        }

         $filter_offers_email = $this->getState('filter.offers.email');
        
        if (strlen($filter_offers_email))
        {
         $this->filters['offers.email'] = 'on';
        }
    
        return $this->filters;
    }


        public function prepareItem($item) {
           
            $item->tickets = $this->hydrateTickets($item->tagid);

            return $item;

        }


    function hydrateTickets($tagid) {

        $model = new \Dash\Models\Event\Tickets;
        $model->setState('filter.tag.id',$tagid);
        $tickets = $model->getList();
	if(empty( $tickets)){
            $tickets = array();
        }
	else {
        foreach ($tickets as $key => $ticket) {
            $ticket = $ticket->cast();
        }
}

        return $tickets;



    }



       public function getList( $refresh=false )
    {
        $fields = $this->getFields();
        $filters = $this->getFilters();
        $options = $this->getOptions();
    
        $mapper = $this->getMapper();
        if (!empty($fields) && method_exists($mapper, 'select')) 
        {
            if (is_a($mapper, '\DB\Mongo\Mapper')) {
                $items = $mapper->select($fields, $filters, $options);
            } else {
                $f3 = \Base::instance();
                $items = $mapper->select($f3->csv($fields), $filters, $options);
            }            
        }
        else 
        {
            $items = $mapper->find($filters, $options);
        }                
        //TODO make the foreach conditional to avoid unneed preformance hog
        if($items) {
         
            foreach ($items as $key => $item) {
                $item = $this->prepareItem($item);
            }
        }
        
        return $items;
    }
    
    public function getItem( $refresh=false )
    {
        $filters = $this->getFilters();
        $options = $this->getOptions();
    
        $mapper = $this->getMapper();
        $item = $mapper->findone($filters, $options);
        
        //TODO make this conditional to avoid unneed preformance hog
        $item = $this->prepareItem($item);

        return $item;
    }


     public function getTotal()
    {
        
        $filters = $this->getFilters();
        $mapper = $this->getMapper();
        $count = $mapper->count($filters);
    
        return $count;
    }

    function getTotalCount() {
        $this->emptyState();
        return $this->getTotal();
    }

     /**
     *
     * @return unknown
     */
    public function paginate()
    {
        $filters = $this->getFilters();
        $options = $this->getOptions();
        $pos = $this->getState('list.offset', 0, 'int');
        $size = $this->getState('list.limit', 10, 'int');
    
        $pagination = $this->getMapper()->paginate($pos, $size, $filters, $options);
        
        //todo make this conditional
        foreach ($pagination['subset'] as $key => $item) {
        
        $item = $this->prepareItem($item);
        }
       


        return $pagination;
    }

}

?>
