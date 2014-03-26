<?php 
namespace Dash\Site\Controllers\Event;

class Devices extends \Dash\Site\Controllers\BaseAuth 
{
    
    public function index() {
        \Base::instance()->set('pagetitle', 'Devices');
        \Base::instance()->set('subtitle', '');
        
        $model = new \Dash\Site\Models\Event\Devices;
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $list = $model->paginate();
     
        \Base::instance()->set('list', $list );
        
        $pagination = new \Dsc\Pagination($list['total'], $list['limit']);       
        \Base::instance()->set('pagination', $pagination );
        
        $view = new \Dsc\Template;
        $view->setLayout('event.php');
        echo $view->render('Dash/Views::event/devices/list.php');
    }

}


?>