<?php 
namespace Dash\Site\Models\Event;


Class Users Extends \Users\Models\Users {

  
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