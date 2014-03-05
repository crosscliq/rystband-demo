<?php 
namespace Dash\Site\Controllers;

class Login extends Base 
{
    public function index()
    {
        $user = \Base::instance()->get('SESSION.dash.user');

        if(!empty($user)){
            \Base::instance()->reroute('/login');
        }
      
        $view = new \Dsc\Template;
        echo $view->render('Dash/Site/Views::auth/login.php');

        //echo \Dsc\System::instance()->get('theme')->setVariant('login')->renderTheme('Dash/Views::common/login.php');
    }
    
    public function auth()
    {
        $username_input = $this->input->getString('email');
        $password_input = $this->input->getString('password');
        

        if (empty($username_input) || empty($password_input)) 
        {
            \Dsc\System::instance()->addMessage('Login failed - Incomplete Form', 'error');
            \Base::instance()->reroute("/login");
            return;
        }
         
        // TODO Fire the authentication Listeners, or let an auth model handle that?
        
        $model = new \Dash\Site\Models\Customers;
        $model->setState('filter.email', $username_input);

        try {
            $item = $model->getItem();

        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage("Invalid User: " . $e->getMessage(), 'error');
            \Base::instance()->reroute("/login");
            return;
        }
        
        if (password_verify($password_input, $item->password))
        {
            \Base::instance()->set('SESSION.dash.user', $item);
            \Base::instance()->reroute("/");
            return;            
        }
        
        \Dsc\System::instance()->addMessage('Login failed', 'error');
        \Dsc\System::instance()->addMessage('Invalid Password', 'error');
        \Base::instance()->reroute("/login");
        return;            
    }
    
    public function logout()
    {
        \Base::instance()->clear('SESSION');
        \Base::instance()->reroute('/login');
    }

}
?> 