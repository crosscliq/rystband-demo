<?php 
namespace Rystband\Controllers;

class Tag extends BaseAuth 
{
    use \Dsc\Traits\Controllers\CrudItem;

    protected $list_route = '/admin/blog/posts';
    protected $create_item_route = '/admin/blog/post/create';
    protected $get_item_route = '/admin/blog/post/view/{id}';    
    protected $edit_item_route = '/admin/blog/post/edit/{id}';
    
    protected function getModel() 
    {
        $model = new \Blog\Admin\Models\Posts;
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
        $f3->set('pagetitle', 'Create Post');
        
        $model = new \Blog\Admin\Models\Categories;
        $categories = $model->getList();
        \Base::instance()->set('categories', $categories );
        \Base::instance()->set('selected', 'null' );

        $selected = array();
        $flash = \Dsc\Flash::instance();
        $input = $flash->old('category_ids');

        if (!empty($input)) 
        {
            foreach ($input as $id)
            {
                $id = $this->inputfilter->clean( $id, 'alnum' );
                $selected[] = array('id' => $id);
            }
        }
        
        $flash->store( $flash->get('old') + array('categories'=>$selected));        

        $all_tags = $this->getModel()->getTags();
        \Base::instance()->set('all_tags', $all_tags );
        
        $view = new \Dsc\Template;
        echo $view->render('Blog/Admin/Views::posts/create.php');
    }
    
    public function Tickets()
    {
        $f3 = \Base::instance();
        $f3->set('pagetitle', 'Edit Post');

        $view = new \Dsc\Template;
        echo $view->render('Blog/Admin/Views::posts/edit.php');
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