<?php 
namespace Dash\Models\Event;

class Eventbase extends \Dsc\Models\Db\Mongo  
{
    protected $db = null; // the db connection object
    
    public function getDb()
    {
        if (empty($this->db))
        {   
            $f3 = \Base::instance();

           
            if(empty($f3->get('eventid'))) {
                $f3->set('eventid', $f3->get('PARAMS.eventid'));
            }
            $db_name = $f3->get('eventid');
         
            $this->db = new \DB\Mongo('mongodb://127.0.0.1:27017', $db_name);
        }
    
        return $this->db;
    }
}
?>