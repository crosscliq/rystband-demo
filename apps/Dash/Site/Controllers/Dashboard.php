<?php 
namespace Dash\Site\Controllers;

class Dashboard extends BaseAuth 
{
    public function index($f3) {


    	$model = new \Dash\Site\Models\Events;
        $state = $model->populateState()->getState();
        $model->setState('list.limit', 50);

        $list = $model->getList();
        \Base::instance()->set('list', $list );

    	$view = new \Dsc\Template;
        echo $view->render('Dash/Views::dashboard/home.php');
    }
}
?>