<?php 
namespace Dash\Models;

class Base extends \Dsc\Models\Db\Mongo  
{
    protected $db = null; // the db connection object
    
    public function getDb()
    {
        if (empty($this->db))
        {
            $db_name = \Base::instance()->get('db.mongo.name');
            $this->db = new \DB\Mongo('mongodb://127.0.0.1:27017', $db_name);
        }
    
        return $this->db;
    }
}
?>