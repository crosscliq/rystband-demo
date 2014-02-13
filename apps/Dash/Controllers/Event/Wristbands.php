<?php 
namespace Dash\Controllers\Event;

class Wristbands extends \Dash\Controllers\BaseAuth 
{
    
    public function display() {
        \Base::instance()->set('pagetitle', 'Wristbands');
        \Base::instance()->set('subtitle', '');
        
        $model = new \Dash\Models\Event\Wristbands;
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $list = $model->paginate();
     
        \Base::instance()->set('list', $list );
        
        $pagination = new \Dsc\Pagination($list['total'], $list['limit']);       
        \Base::instance()->set('pagination', $pagination );
        
        $view = new \Dsc\Template;
        $view->setLayout('event.php');
        echo $view->render('Dash/Views::event/wristbands/list.php');
    }

}


?>