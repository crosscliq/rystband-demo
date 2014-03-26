<?php 
namespace Rystband\Controllers;

class Auth extends \Users\Site\Controllers\Auth {

    
    protected $list_route = '/admin/users';
    protected $create_item_route = '/admin/user';
    protected $get_item_route = '/admin/user/{id}';
    protected $edit_item_route = '/{username}/edit';
    protected $default_login_redirect = '/roles';
    protected $default_signup_redirect = '/roles';
    protected $default_loggedin_redirect = '/roles';
    

    function beforeRoute() {

	$f3 = \Base::instance();

        $session = \Base::instance()->get('SESSION.user');
        
        if(@$session->_id) {
        \Base::instance()->reroute($this->default_loggedin_redirect);    
        }       
    
    }

    protected function getModel()
    {
        $model = new \Rystband\Models\Users;
        return $model;
    }
    
    protected function getItem()
    {
        $f3 = \Base::instance();
        $id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );
        $model = $this->getModel()
        ->setState('filter.id', $id);
        
        try {
            $item = $model->getItem();
        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
            $f3->reroute( $this->list_route );
            return;
        }
    
        return $item;
    }
    
    function showSignup()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Sign up');

        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::auth/register.php');
    }
    
    function showLogin()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Login');
        
        $view = new \Dsc\Template;
        echo $view->render('Rystband/Views::auth/login.php');
    }

    function doCrypt($pass) {
        
        return password_hash($pass, PASSWORD_BCRYPT);
    }
    function doCryptVerify($password, $hash) {
       
        return password_verify($password, $hash);
    }


    function doSignup() {

        //TODO add validations and such to this event
        $model = new \Rystband\Models\Users;
        $user = $model->getMapper();    
        $user->copyFrom('POST');

        //DO the check to make sure the passwords are the same.
        $user->password = $user->password1;
        
        $user->password = $this->doCrypt($user->password1);
        unset($user->password1);
        unset($user->password2);
        $user->save();

        $event = new \Joomla\Event\Event( 'onUserSignup' );
        $event->addArgument('user', $user);
        \Dsc\System::instance()->getDispatcher()->triggerEvent($event); 

        \Base::instance()->set('SESSION.user', (object) $user->cast());

        // TODO otherwise, reroute to login with error message
        \Dsc\System::instance()->addMessage('Sign up Success', 'msg');
        
        \Base::instance()->reroute($this->default_signup_redirect);

    }

    function doLogin() {
        //get the login vars
        $username_input = $this->input->get('email','', 'string');
        $password_input = $this->input->get('password','', 'string');
        
        $model = new \Rystband\Models\Users;

         $model->setFilter('email', strtolower($username_input));
        
        $user = $model->getItem();
       
        if(!empty($user)) {
        //WHY USE AUTH
        //supporting 3rd login, instead of only using the users 
        //collection we could use smtp jig, or whatever
        /*$model = new \Users\Admin\Models\Users;
        $user = $model->getMapper();
        //TODO support a config of setting the username or email or somehow support both.
        $auth = new \Auth($user, array('id'=>'email', 'pw'=>'password'));
        */
        
        $authenticated =  $this->doCryptVerify((string) $password_input, (string) $user->password);
          
            if ($authenticated) 
            {   
	session_set_cookie_params ( time()+36000, '/' , 'ontario.msft.cc' );
                   
                \Base::instance()->set('SESSION.user', (object) $user->cast());	 
		setcookie("id", session_id(), time()+36000, '/', 'ontario.msft.cc');


		$redirect = $this->input->get('login-redirect','', 'string');
                if($redirect) {
                 $this->default_login_redirect = base64_decode($redirect);  
                }


                  $event = new \Joomla\Event\Event( 'onUserLogin' );
                  $event->addArgument('user', $user);
                  \Dsc\System::instance()->getDispatcher()->triggerEvent($event); 



                \Base::instance()->reroute($this->default_login_redirect);
                return;
            }
        }
       
        // TODO otherwise, reroute to login with error message
        \Dsc\System::instance()->addMessage('Login failed', 'error');
        
        \Base::instance()->reroute("/login");
    }

    public function logout()
    {
        \Base::instance()->clear('SESSION');
        \Base::instance()->reroute('/');
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
}
