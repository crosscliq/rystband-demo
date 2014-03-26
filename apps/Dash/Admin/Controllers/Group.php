<?php 
namespace Dash\Admin\Controllers;

class Group extends \Admin\Controllers\BaseAuth 
{
    use \Dsc\Traits\Controllers\CrudItemCollection;
    
    protected $list_route = '/admin/customers/groups';
    protected $create_item_route = '/admin/customers/group/create';
    protected $get_item_route = '/admin/customers/group/read/{id}';
    protected $edit_item_route = '/admin/customers/group/edit/{id}';
    
    protected function getModel()
    {
        $model = new \Dash\Admin\Models\Groups;
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
        $f3->set('pagetitle', 'Create Group');
    
        $view = \Dsc\System::instance()->get('theme');
		$view->event = $view->trigger( 'onDisplayAdminGroupEdit', array( 'item' => $this->getItem(), 'tabs' => array(), 'content' => array(), 'identifier' => $this->create_item_route, 'isNew' => true ) );
		$view->additional_tabs = !empty( $view->event->getArgument( 'tabs' ) );		
        echo $view->render('Dash/Admin/Views::groups/create.php');
    }
    
    protected function displayEdit()
    {
		$item = $this->getItem();
    	$identifier = preg_replace('/\{id\}/', $item->get( $this->getModel()->getItemKey() ), $this->edit_item_route);
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit Group');
    
        $view = \Dsc\System::instance()->get('theme');
		$view->event = $view->trigger( 'onDisplayAdminGroupEdit', array( 'item' => $item, 'tabs' => array(), 'content' => array(), 'identifier' => $identifier, 'isNew' => false ) );
		$view->additional_tabs = !empty( $view->event->getArgument( 'tabs' ) );
        echo $view->render('Dash/Admin/Views::groups/edit.php');
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