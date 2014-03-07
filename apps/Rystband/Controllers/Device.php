<?php 
namespace Rystband\Controllers;

class Device extends Base 
{   

    
     public function display()
    {
        \Base::instance()->set('pagetitle', 'Privacy Policy');
        \Base::instance()->set('subtitle', '');
                
        $view = new \Dsc\Template;
        echo $view->render('device/view.php');
    }


    public function tap() {
    	$f3 = \Base::instance();
    	$devices = new \Dash\Site\Models\Event\Devices;

		$id = $this->inputfilter->clean( $f3->get('PARAMS.id'), 'alnum' );
		$model = $devices->setState('filter.id', $id);
		



		try {
			$item = $model->getItem();

			$pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id'));
			$data = array('route' => $f3->get('PARAMS.0'), 'msg' => $f3->get('POST.msg'));
			$pusher->trigger($f3->get('event.db'), 'tapped', $data);
        

			echo 1;

		} catch ( \Exception $e ) {
			\Dsc\System::instance()->addMessage( "Invalid Item: " . $e->getMessage(), 'error');
			echo 0;
			return;
		}


    }
}
?> 