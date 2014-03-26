<?php 
namespace Dash\Admin\Controllers;

class Customers extends \Admin\Controllers\BaseAuth 
{
    public function index()
    {
      ///  parent::isAllowed( parent::getIdentity(), __CLASS__, __FUNCTION__ );
        
        $model = new \Dash\Admin\Models\Customers;
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
    
        $paginated = $model->paginate();
        \Base::instance()->set('paginated', $paginated );
        
        $model = new \Dash\Admin\Models\Groups;
        $groups = $model->getList();
        \Base::instance()->set('groups', $groups );
        
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Dash/Admin/Views::customers/list.php');
    }
}