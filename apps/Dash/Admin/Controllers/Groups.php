<?php 
namespace Dash\Admin\Controllers;

class Groups extends \Admin\Controllers\BaseAuth 
{   
     protected function getModel()
    {
        $model = new \Dash\Admin\Models\Groups;
        return $model;
    }

    public function index()
    {
       // parent::isAllowed( parent::getIdentity(), __CLASS__, __FUNCTION__ );
    
        $model = $this->getModel();
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
    
        $paginated = $model->paginate();
        \Base::instance()->set('paginated', $paginated );
    
        $view = \Dsc\System::instance()->get('theme');
        echo $view->render('Dash/Admin/Views::groups/list.php');
    }

    public function getCheckboxes()
    {
        $model = $this->getModel();
        $groups = $model->getList();
        \Base::instance()->set('groups', $groups );
    
        $selected = array();
        $data = \Base::instance()->get('REQUEST');
        
        $input = $data['groups_ids'];
        foreach ($input as $id) 
        {
            $id = $this->inputfilter->clean( $id, 'alnum' );
            $selected[] = array('id' => $id);
        }

        $flash = \Dsc\Flash::instance();
        $flash->store( array( 'metadata'=>array('groups'=>$selected) ) );
        \Base::instance()->set('flash', $flash );
        
        $view = \Dsc\System::instance()->get('theme');
        $html = $view->renderLayout('Dash/Admin/Views::groups/checkboxes.php');
    
        return $this->outputJson( $this->getJsonResponse( array(
                'result' => $html
        ) ) );
    
    }
}