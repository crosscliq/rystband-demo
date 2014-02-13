<?php 
namespace Dash\Models;


Class Events Extends Base {

    protected $collection = 'events';
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

    protected function createDb()
    {
        $db_name = \Base::instance()->get('db.mongo.name');

        $this->db = new \DB\Mongo('mongodb://127.0.0.1:27017', $db_name);
        

        return $this;
    }

    public function getPrefab() {
        $prefab = New \Dash\Models\Prefabs\Event();
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

        $filter_eventid = $this->getState('filter.eventid');

        if (strlen($filter_eventid))
        {
            $this->filters['event_id'] = $filter_eventid;
        }


        $filter_slug = $this->getState('filter.slug');

        if (strlen($filter_slug))
        {
            $this->filters['slug'] = $filter_slug;
        }

         
        return $this->filters;
    }

        /**
     * An alias for the save command
     * 
     * @param unknown_type $values
     * @param unknown_type $options
     */
    public function create( $values, $options=array() ) 
    { 
        
        $save =  $this->save( $values, $options );
        if($save) {
             $event = new \Joomla\Event\Event( 'onAfterCreateDashModelsEvents' );
             $event->addArgument('model', $this)->addArgument('mapper', $save);
             $event = \Dsc\System::instance()->getDispatcher()->triggerEvent($event);
                if ($event->hasArgument('mapper')) {
                  $save = $event->getArgument('mapper');
                }
        }
        return $save;


    }



    //if all checks pass lets process values
   public function processEventID($event_id){

    $id = str_replace(' ', '', $event_id);
    $id = strtolower($id);
    return $id;

    }

      public function validate( $values, $options=array(), $mapper=null ) 
    {   
        if(empty($values['event_id'])){
            $this->setError('Event ID is required, it is used as the collection name and as the sub domain');
        } else {
            $values['event_id'] = $this->processEventID($values['event_id']);
        }
        

        return $this->checkErrors();
    }

}

?>