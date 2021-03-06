<?php 
namespace Dash\Site\Models\Event;


Class Activities Extends Eventbase {

    protected $collection = 'activities';
    protected $default_ordering_direction = '-1';
    protected $default_ordering_field = '_id';

    public function __construct($config=array())
    {
        $config['filter_fields'] = array('_id', 'timestamp.id'
        );
        $config['order_directions'] = array('1', '-1');
        
        parent::__construct($config);
    }

    public function prefab( $source=array(), $options=array() )
    {
        $prefab = new \Dash\Site\Models\Prefabs\Activity($source, $options);
        
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

        $filter_type = $this->getState('filter.type');
        
        if (strlen($filter_type))
        {
            $this->filters['type'] = $filter_type;
        }


        $filter_action = $this->getState('filter.action');
        
        if (strlen($filter_action))
        {
            $this->filters['action'] = $filter_action;
        }


        $filter_slug = $this->getState('filter.slug');

        if (strlen($filter_slug))
        {
            $this->filters['slug'] = $filter_slug;
        }

        return $this->filters;
    }



    /**
* An alias for the save command, used only for creating a new object
*
* @param array $values
* @param array $options
*/
    public function create( $values, $options=array() )
    {
        $values = $this->prefab( $values, $options )->cast();

        return $this->save( $values, $options );
    }

    


}

?>