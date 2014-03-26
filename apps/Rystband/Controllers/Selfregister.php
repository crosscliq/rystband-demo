<?php 
namespace Rystband\Controllers;

class Selfregister extends Base 
{	

    use \Dsc\Traits\Controllers\CrudItem;

    protected $list_route = '/attendee';
    protected $create_item_route = '/attendee/create';
    protected $create_item_confirm_route = '/band/{id}/registerconfirm';
    protected $create_item_customer_route = '/attendee/customer/{id}';
    protected $get_item_route = '/attendee/view/{id}';    
    protected $edit_item_route = '/attendee/edit/{id}';
    
  	protected function getModel() 
    {
        $model = new \Rystband\Models\Attendees;
        return $model; 
    }
    
    protected function getItem() 
    {
        $f3 = \Base::instance();
        $id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );

        $model = $this->getModel()->setState('filter.id', $id);

        try {
            $item = $model->getItem(); 
        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
            $f3->reroute( $this->list_route );
            return;
        }

        return $item;
    }
    
    protected function displayCreate() 
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Activate Wristband');
        
        $f3->set('tagid',$f3->get('PARAMS.tagid'));
        $selected = array();
        $flash = \Dsc\Flash::instance();

        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/register.php');
    }

    protected function doAdd($data) 
    {    
        if (!isset($data['submitType'])) {
            $data['submitType'] = "save_confirm";
        }
        

        $f3 = \Base::instance();
        $flash = \Dsc\Flash::instance();
        $model = $this->getModel();
        
        // save
        try {

        	//FIRST WE NEED TO CREATE A TAG
        	$tagsmodel =  new \Rystband\Models\Tags();
            $tag = $tagsmodel->getPrefab();
            $tag->tagid = $f3->get('PARAMS.tagid');;
            $tag->eventid = $f3->get('event.db');
            $tag = $tagsmodel->create((array) $tag);
        	
        	$data['tagid'] = $tag->_id;


            $values = $data;
            unset($values['submitType']);
            //\Dsc\System::instance()->addMessage(\Dsc\Debug::dump($values), 'warning');
            $this->item = $model->create($values);




            if($this->item->tagid) {
                $tags = new \Rystband\Models\Tags();
                $tag = $tags->setState('filter.id',$this->item->tagid)->getItem();
                $tag->set('attendee.id',$this->item->_id);
                $tag->set('attendee.name',$this->item->first_name . ' ' .$this->item->last_name);
                $tag->save();
            }


        }
        catch (\Exception $e) {
          
            foreach ($model->getErrors() as $error)
            {   

                $error = (new \Dash\Helpers\Errors('attendee', $error))->getData();

                \Dsc\System::instance()->addMessage($error, 'error');
            }
            
            if ($f3->get('AJAX')) {
                // output system messages in response object
                return $this->outputJson( $this->getJsonResponse( array(
                        'error' => true,
                        'message' => \Dsc\System::instance()->renderMessages()
                ) ) );
            }
            
            // redirect back to the create form with the fields pre-populated
            \Dsc\System::instance()->setUserState('use_flash.' . $this->create_item_route, true);
            $flash->store($data);

            $this->setRedirect( $f3->get('PARAMS.0') );
                        
            return false;
        }
                
        // redirect to the editing form for the new item
        \Dsc\System::instance()->addMessage('Item saved');
        
        if (method_exists($this->item, 'cast')) {
            $this->item_data = $this->item->cast();
        } else {
            $this->item_data = \Joomla\Utilities\ArrayHelper::fromObject($this->item);
        }
        
        if ($f3->get('AJAX')) {
            return $this->outputJson( $this->getJsonResponse( array(
                    'message' => \Dsc\System::instance()->renderMessages(),
                    'result' => $this->item_data
            ) ) );
        }
        
        switch ($data['submitType']) 
        {
            case "save_new":
                $route = $this->create_item_route;
                break;
             case "save_customer":
                $flash->store($this->item_data);
                $id = $this->item->get( $this->getItemKey() );

                $route = str_replace('{id}', $id, $this->create_item_customer_route );   
                break;      
             case "save_confirm":
                $flash->store($this->item_data);
               $id = $this->item->get( $this->getItemKey() );
                
                $route = str_replace('{id}', $id, $this->create_item_confirm_route );   
                break;    
            case "save_close":
                $route = $this->list_route;
                break;
            default:
                $flash->store($this->item_data);
                $id = $this->item->get( $this->getItemKey() );
                $route = str_replace('{id}', $id, $this->edit_item_route );                
                break;
        }



        $this->setRedirect( $route );
        
        return $this;
    }

    protected function doUpdate(array $data, $key=null) 
    {
        
        if (!isset($data['submitType'])) {
            $data['submitType'] = "save_confirm";
        }
        
        $f3 = \Base::instance();
        $flash = \Dsc\Flash::instance();
        $model = $this->getModel();
        $this->item = $this->getItem();
        
        // save
        $save_as = false;
        try {
            $values = $data; 
            unset($values['submitType']);
   
                $this->item = $model->update($this->item, $values);
                        
                if($this->item->tagid) {
                $tags = new \Rystband\Models\Tags();
                $tag = $tags->setState('filter.id',$this->item->tagid)->getItem();
                $tag->set('attendee.id',$this->item->_id);
                $tag->set('attendee.name',$this->item->first_name . ' ' .$this->item->last_name);
                $tag->save();
                
            }      
            

        }
        catch (\Exception $e) {
            \Dsc\System::instance()->addMessage('Save failed with the following errors:', 'error');
            \Dsc\System::instance()->addMessage($e->getMessage(), 'error');
            foreach ($model->getErrors() as $error)
            {
                \Dsc\System::instance()->addMessage($error, 'error');
            }
            
            if ($f3->get('AJAX')) {
                // output system messages in response object
                return $this->outputJson( $this->getJsonResponse( array(
                        'error' => true,
                        'message' => \Dsc\System::instance()->renderMessages()
                ) ) );
            }
        
            // redirect back to the create form with the fields pre-populated
            $flash->store($data);
            $id = $this->item->get( $this->getItemKey() );
            $route = str_replace('{id}', $id, $this->edit_item_route );
            
            $this->setRedirect( $route );
            
            return false;           
        }
        
        // redirect to the editing form for the new item
        if (method_exists($this->item, 'cast')) {
            $this->item_data = $this->item->cast();
        } else {
            $this->item_data = \Joomla\Utilities\ArrayHelper::fromObject($this->item);
        }
        
        if ($f3->get('AJAX')) {
            return $this->outputJson( $this->getJsonResponse( array(
                    'message' => \Dsc\System::instance()->renderMessages(),
                    'result' => $this->item_data
            ) ) );
        }
        
        switch ($data['submitType']) 
        {
            case "save_new":
                $route = $this->create_item_route;
                break;
             case "save_customer":
                $flash->store($this->item_data);
                $id = $this->item->get( $this->getItemKey() );
                $route = str_replace('{id}', $id, $this->create_item_customer_route );   
                break;      
             case "save_confirm":
                 $flash->store($this->item_data);
                $id = $f3->get('PARAMS.tagid');
                $route = str_replace('{id}', $id, $this->create_item_confirm_route );   
                break;    
            case "save_close":
                $route = $this->list_route;
                break;
            default:
                $flash->store($this->item_data);
                $id = $this->item->get( $this->getItemKey() );
                $route = str_replace('{id}', $id, $this->edit_item_route );                
                break;
        }

        $this->setRedirect( $route );
        
        return $this;        
    }
    
    protected function displayEdit()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Wristband');

     
        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/edit.php');
    }


     public function registerconfirm() 
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Activate Wristband');
        
    
        $model = $this->getModel();

        $item = $this->getItem();

        $f3->set('item',$item);



        $selected = array();
        $flash = \Dsc\Flash::instance();

        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/selfconfirm.php');
    }

   

    public function signin() 
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Sign in');
        
        $f3->set('tagid',$f3->get('PARAMS.tagid'));

 
        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/selfsignin.php');
    }

     public function assign() 
    {   
        $f3 = \Base::instance();
        $model = new \Rystband\Models\Tags;
        $thisTag = $model->setState('filter.tagid', $f3->get('PARAMS.tagid'))->getItem();
	
	if(empty($thisTag)) {
            $tag = $model->getPrefab();
            $tag->tagid = $f3->get('PARAMS.tagid');
            $tag->eventid = $f3->get('PARAMS.eventid');
            $thisTag = $model->create((array) $tag);
        }        




	$model = new \Rystband\Models\Attendees;
        $model->setState('filter.first_name', $f3->get('POST.first_name'));
        $model->setState('filter.last_name', $f3->get('POST.last_name'));
        $model->setState('filter.phone', $f3->get('POST.phone'));

        $attendee = $model->getItem();

	 	if(@$attendee->tagid) {
            $model = new \Rystband\Models\Tags;
            $oldTag = $model->setState('filter.id',  $attendee->tagid)->getItem();
            $oldTag->previd = $oldTag->tagid;
            $oldTag->tagid = $thisTag->tagid;
            $oldTag->save();
            $model->delete($thisTag);
        } else {
		   \Dsc\System::instance()->addMessage('A band with that information doesn\'t exist', 'error');
            $f3->reroute('/self/signin/'.$f3->get('PARAMS.tagid'));

        }       
 
        if (method_exists($attendee, 'cast')) {
            $item  = $attendee->cast();
        } else {
            $item = \Joomla\Utilities\ArrayHelper::fromObject($attendee);
        }
   

        $f3->set('pagetitle', 'Sign in');
        
        $f3->set('item',$item);

        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/confirm.php');
    }

    public function selfsignin() 
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Sign in');
        
        $f3->set('tagid',$f3->get('PARAMS.tagid'));
        $model = new \Rystband\Models\Tags;
        $tagid = $f3->get('PARAMS.tagid');
        $model->setState('filter.tagid', $tagid);
    	
        $tag = $model->getItem();

        $f3->set('SESSION.tagid', $tagid);


    	
    	if(!empty($tag->attendee)) {
    		$f3->reroute('/band/'.$f3->get('PARAMS.tagid').'/alreadyregistered');
    	}
         $flash = \Dsc\Flash::instance();
         $f3->set('flash',$flash );

        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/selfregister.php');
    }

    public function alreadyregistered() 
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Sign in');
        
        $f3->set('tagid',$f3->get('PARAMS.tagid'));
        $model = new \Rystband\Models\Tags;
        $tagid = $f3->get('PARAMS.tagid');
        $model->setState('filter.tagid', $tagid);
    	
    	$tag = $model->getItem();

        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::attendee/alreadyregistered.php');
    }



    /**
     * This controller doesn't allow reading, only editing, so redirect to the edit method
     */
    protected function doRead(array $data, $key=null) 
    {
        $f3 = \Base::instance();
        $id = $this->getItem()->get( $this->getItemKey() );
        $route = str_replace('{id}', $id, $this->edit_item_route );
        $f3->reroute( $route );
    }
    
    protected function displayRead() {}

    public function socialauth() {

         try{
             \Hybrid_Endpoint::process();
          } catch( \Exception $e ){
            echo $e->getMessage();
            die();
          }
    }

    public function authenticatewith(  )
    {   $f3 = \Base::instance();
        $provider = $f3->get('PARAMS.provider');
        $hybridauth_config = (new \Rystband\Config\HybridConfig)->getConfig();
    
        try{
        // create an instance for Hybridauth with the configuration file path as parameter
            $hybridauth = new \Hybrid_Auth( $hybridauth_config );

        // try to authenticate the selected $provider
            $adapter = $hybridauth->authenticate( $provider );

        // grab the user profile
            $user_profile = $adapter->getUserProfile();



            $tag = $f3->get('SESSION.tag');

           

            $model = new \Rystband\Models\Attendees;
            $filter = 'social.'.$provider;
            //$model->setState($filter, $user_profile->identifier)->getItem();
        # 1 - check if user already have authenticated using this provider before
        //    $authentication_info = $authentication->find_by_provider_uid( $provider, $user_profile->identifier );

        # 2 - if authentication exists in the database, then we set the user as connected and redirect him to his profile page
        /*    if( $authentication_info ){
                // 2.1 - store user_id in session
                $_SESSION["user"] = $authentication_info["user_id"]; 

                // 2.2 - redirect to user/profile
                $this->redirect( "users/profile" );
            }

        # 3 - else, here lets check if the user email we got from the provider already exists in our database ( for this example the email is UNIQUE for each user )
            // if authentication does not exist, but the email address returned  by the provider does exist in database, 
            // then we tell the user that the email  is already in use 
            // but, its up to you if you want to associate the authentication with the user having the adresse email in the database
            if( $user_profile->email ){
                $user_info = $user->find_by_email( $user_profile->email );

                if( $user_info ) {
                    die( '<br /><b style="color:red">Well! the email returned by the provider ('. $user_profile->email .') already exist in our database, so in this case you might use the <a href="index.php?route=users/login">Sign-in</a> to login using your email and password.</b>' );
                }
            }
 */
        # 4 - if authentication does not exist and email is not in use, then we create a new user 
            //FIRST WE NEED TO CREATE A TAG
            $tagsmodel =  new \Rystband\Models\Tags();
            $tag = $tagsmodel->getPrefab();
            $tag->tagid = $f3->get('SESSION.tagid');
            $tag->eventid = $f3->get('event.db');
            $tag = $tagsmodel->create((array) $tag);
                

            $data = array();
            $data['tagid'] = $tag->id;
            $data['social'][$provider]['identifier'] = $user_profile->identifier;
            $data['email'] = $user_profile->email;
            $data['first_name'] = $user_profile->firstName;
            $data['last_name'] = $user_profile->lastName;
            $data['display_name'] = $user_profile->displayName;
            $data['website_url'] = $user_profile->webSiteURL;
            $data['social'][$provider]['profile_url'] = $user_profile->profileURL;
        
            $password      = rand( ) ; # for the password we generate something random




            // 4.1 - create new user
            $doc = $model->create($data);    


                $tags = new \Rystband\Models\Tags();
                $tag = $tags->setState('filter.id',$tag->id)->getItem();
                $tag->set('attendee.id',$doc->_id);
                $tag->set('attendee.name',$doc->first_name . ' ' .$doc->last_name);
                $tag->save();



            // 4.2 - creat a new authentication for him
            //$authentication->create( $new_user_id, $provider, $provider_uid, $email, $display_name, $first_name, $last_name, $profile_url, $website_url );
 
            // 4.3 - store the new user_id in session
             $f3->set('SESSION.user', $doc);
            // 4.4 - redirect to user/profile


             $f3->reroute('/welcome');
        }
        catch( \Exception $e ){
            // Display the recived error
            switch( $e->getCode() ){ 
                case 0 : $error = "Unspecified error."; break;
                case 1 : $error = "Hybriauth configuration error."; break;
                case 2 : $error = "Provider not properly configured."; break;
                case 3 : $error = "Unknown or disabled provider."; break;
                case 4 : $error = "Missing provider application credentials."; break;
                case 5 : $error = "Authentication failed. The user has canceled the authentication or the provider refused the connection."; break;
                case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again."; 
                         $adapter->logout(); 
                         break;
                case 7 : $error = "User not connected to the provider."; 
                         $adapter->logout(); 
                         break;
            } 

            // well, basically your should not display this to the end user, just give him a hint and move on..
            $error .= "<br /><br /><b>Original error message:</b> " . $e->getMessage(); 
            $error .= "<hr /><pre>Trace:<br />" . $e->getTraceAsString() . "</pre>"; 

            // load error view
            $data = array( "error" => $error ); 
            var_dump($data); die();
        }
    }




}
