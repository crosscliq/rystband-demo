<?php 
namespace Dash\Controllers\Event;

class Role extends \Dash\Controllers\BaseAuth
{
    use \Dsc\Traits\Controllers\CrudItem;

    protected $list_route = '/';
    protected $create_item_route = '/role/create';
    protected $get_item_route = '/role/view/{id}';    
    protected $edit_item_route = '/role/edit/{id}';
    
    protected function getModel() 
    {
        $model = new \Dash\Models\Event\Roles;
        return $model; 
    }
    public function __construct() {
        $f3 = \Base::instance();
        $this->list_route = '/'. $f3->get('PARAMS.eventid').'/roles/';
        $this->create_item_route = '/'. $f3->get('PARAMS.eventid').'/role/create';
        $this->get_item_route = '/'. $f3->get('PARAMS.eventid').'/role/view/{id}';
        $this->edit_item_route = '/'. $f3->get('PARAMS.eventid').'/role/edit/{id}';

        parent::__construct();
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
        $f3->set('pagetitle', 'Create Role');
        
        $selected = array();
        $flash = \Dsc\Flash::instance();
       
        
        $flash->store( $flash->get('old') );        

        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/roles/create.php');
    }
    
     protected function displayEdit()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit Role');
        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/roles/edit.php');
    }

    //reroute this to  the \Dash\
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

    
    protected function displayRead() {

        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit Role');
        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/roles/edit.php');
    }
}