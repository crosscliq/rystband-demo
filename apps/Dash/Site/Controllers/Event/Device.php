<?php 
namespace Dash\Site\Controllers\Event;

class Device extends \Dash\Site\Controllers\BaseAuth 
{
    use \Dsc\Traits\Controllers\CrudItem;

    protected $list_route = '/';
    protected $create_item_route = '/device/create';
    protected $get_item_route = '/device/view/{id}';    
    protected $edit_item_route = '/device/edit/{id}';
    
    protected function getModel() 
    {
        $model = new \Dash\Site\Models\Event\Devices;
        return $model; 
    }
    public function __construct() {
        $f3 = \Base::instance();
        $this->list_route = '/'. $f3->get('PARAMS.eventid').'/devices/';
        $this->create_item_route = '/'. $f3->get('PARAMS.eventid').'/device/create';
        $this->get_item_route = '/'. $f3->get('PARAMS.eventid').'/device/view/{id}';
        $this->edit_item_route = '/'. $f3->get('PARAMS.eventid').'/device/edit/{id}';

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
        $f3->set('pagetitle', 'Create Devices');
        
        $selected = array();
        $flash = \Dsc\Flash::instance();
       
        
        $flash->store( $flash->get('old') );        

        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/devices/create.php');
    }
    
     protected function displayEdit()
    {   

        
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit Devices');
        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/devices/edit.php');
    }

    //reroute this to  the \Dash\Site\
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
        $f3->set('pagetitle', 'Edit Devices');
        
        $view = new \Dsc\Template;
        echo $view->render('Dash/Views::event/devices/edit.php');
    }
}