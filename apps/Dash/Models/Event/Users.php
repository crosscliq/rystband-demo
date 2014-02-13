<?php 
namespace Dash\Models\Event;


Class Users Extends \Users\Admin\Models\Users {

    public function setIndexes() {
        $collection = $this->getCollection;


    }

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


    public function create( $values, $options=array() )
    {
        if (empty($values['password'])) {
            $this->auto_password = $this->generateRandomString( 10 ); // save this for later emailing to the user, if necessary
            $values['password'] =  password_hash($this->auto_password, PASSWORD_BCRYPT);

        } else {
            $values['password'] =  password_hash($values['password'], PASSWORD_BCRYPT);
        }

                
        return $this->save( $values, $options );
    }
    
    public function update( $mapper, $values, $options=array() )
    {
        if (!empty($values['new_password'])) 
        {
            if (empty($values['confirm_new_password']))
            {
                $this->setError('Must confirm new password');
            }
            
            if ($values['new_password'] != $values['confirm_new_password'])
            {
                $this->setError('New password and confirmation value do not match');
            }
            
            $values['password'] = password_hash($values['new_password'], PASSWORD_BCRYPT);
        }
            else 
        {
            $values['password'] = $mapper->password;
        }

        unset($values['new_password']);
        unset($values['confirm_new_password']);
        
        return $this->save( $values, $options, $mapper );
    }
    
    public function save( $values, $options=array(), $mapper=null )
    {
        if (empty($options['skip_validation']))
        {
            $this->validate( $values, $options, $mapper );
        }
        
        if (empty($values['username'])) {
            $values['username'] = $values['email'];
        }
        
        $values['username'] = $this->inputfilter->clean( $values['username'], 'ALNUM' );
        
        if (!empty($values['groups'])) 
        {
            $groups = array();
            foreach ($values['groups'] as $key => $id) 
            {
                $item = (new \Users\Admin\Models\Groups)->setState('filter.id', $id)->getItem();
                $groups[] = array("id" =>  $item->id, "name" => $item->name);
        
            }
            $values['groups'] = $groups;
        }  

        if (!empty($values['roles'])) 
        {
            $roles = array();
            foreach ($values['roles'] as $key => $id) 
            {
                $item = (new \Dash\Models\Event\Roles)->setState('filter.id', $id)->getItem();
                $roles[] = array("id" =>  $item->id, "name" => $item->name, "type" => $item->type );
        
            }
            $values['roles'] = $roles;
        }      
        
        $options['skip_validation'] = true; // we've already done it above, so stop the parent from doing it
    
        return parent::save( $values, $options, $mapper );
    }
	
}



?>