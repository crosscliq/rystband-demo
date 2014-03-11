<?php 
namespace Rystband\Controllers;

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
    
    

    public function sysauth() {
        $key = $this->input->getString('key');

        $model = new \Rystband\Models\Attendees;
        $model->setState('filter.authkey', $key);

        try {
            $item = $model->getItem();

            if ($item)
            {
                \Base::instance()->set('SESSION.dash.user', $item);

                $model = new \Rystband\Models\Tags;
                $model->setState('filter.id', $item->tagid);
                $tag = $model->getItem();
                \Base::instance()->reroute('/band/'.$tag->tagid);
                return;            
            }

        } catch ( \Exception $e ) {
            \Dsc\System::instance()->addMessage("Invalid User: " . $e->getMessage(), 'error');
            
            return;
        }
        
        
    }
    
    public function logout()
    {
        \Base::instance()->clear('SESSION');
        \Base::instance()->reroute('/login');
    }

}
?> 