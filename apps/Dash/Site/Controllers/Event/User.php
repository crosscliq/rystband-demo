<?php 
namespace Dash\Site\Controllers\Event;

class User extends \Dash\Site\Controllers\BaseAuth  
{
    use \Dsc\Traits\Controllers\CrudItemCollection;
    
    protected $list_route = '/';
    protected $create_item_route = '/user/create';
    protected $get_item_route = '/user/view/{id}';    
    protected $edit_item_route = '/user/edit/{id}';
    
    public function __construct() {
        $f3 = \Base::instance();
        $this->list_route = '/'. $f3->get('PARAMS.eventid').'/users/';
        $this->create_item_route = '/'. $f3->get('PARAMS.eventid').'/user/create';
        $this->get_item_route = '/'. $f3->get('PARAMS.eventid').'/user/view/{id}';
        $this->edit_item_route = '/'. $f3->get('PARAMS.eventid').'/user/edit/{id}';

        parent::__construct();
    }
    
    protected function getModel($name='Users')
    {
        switch (strtolower($name)) 
        {
            case "group":
            case "groups":
                $model = new \Users\Models\Groups;
                break;
            default:
                $model = new \Users\Models\Users;
                break;              
        }
        
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
    
    protected function displayCreate()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Create User');

        $model = $this->getModel('groups');
        $groups = $model->getList();
        \Base::instance()->set('groups', $groups ); 

        $model = new  \Dash\Site\Models\Event\Roles;
        $roles = $model->getList();
         \Base::instance()->set('roles', $roles );

        //$view = \Dsc\System::instance()->get('theme');
        //$view->event = $view->trigger( 'onDisplayAdminUserEdit', array( 'item' => $this->getItem(), 'tabs' => array(), 'content' => array() ) );
        
        //echo $view->render('Users/Admin/Views::users/create.php');
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/users/create.php');

    }
    
    protected function displayEdit()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit User');
        
        $model = $this->getModel('groups');
        $groups = $model->getList();
        \Base::instance()->set('groups', $groups );     

        $model = new  \Dash\Site\Models\Event\Roles;
        $roles = $model->getList();
         \Base::instance()->set('roles', $roles );

        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/users/edit.php');


        //$view = \Dsc\System::instance()->get('theme');
        //$view->event = $view->trigger( 'onDisplayAdminUserEdit', array( 'item' => $this->getItem(), 'tabs' => array(), 'content' => array() ) );
                
        //echo $view->render('Users/Admin/Views::users/edit.php');
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

