<?php 
namespace Dash\Site\Controllers;

class Events extends BaseAuth 
{
    
    public function display() {
        \Base::instance()->set('pagetitle', 'Events');
        \Base::instance()->set('subtitle', '');
        
        $model = new \Dash\Site\Models\Events;
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $list = $model->paginate();
        \Base::instance()->set('list', $list );
        
        $pagination = new \Dsc\Pagination($list['total'], $list['limit']);       
        \Base::instance()->set('pagination', $pagination );
        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::events/list.php');
    }

}


?>