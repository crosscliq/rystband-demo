<?php 
namespace Dash\Controllers\Event;

class Activity extends \Dash\Controllers\BaseAuth 
{
    
    public function display() {
        \Base::instance()->set('pagetitle', 'Attendees');
        \Base::instance()->set('subtitle', '');
        
        $model = new \Dash\Models\Event\Attendees;
        $model->setState('filter.profile.complete', 1);
        $state = $model->populateState()->getState();
        \Base::instance()->set('state', $state );
        
        $list = $model->paginate();
     
        \Base::instance()->set('list', $list );
        
        $pagination = new \Dsc\Pagination($list['total'], $list['limit']);       
        \Base::instance()->set('pagination', $pagination );
        
        $view = new \Dsc\Template;
        $view->setLayout('event.php');
        echo $view->render('Dash/Views::event/attendees/list.php');
    }


    public function movetoattendee() {

    	$array = array();
    	$array[] = 'Word of Mouth';
    	$array[] = 'Radio';
    	$array[] = 'Mall Signage';
    	$array[] = 'Social Media';
    	$array[] = 'Friend/Family';
    	$array[] = 'Community Event';
    	$array[] = 'Newspaper';
    	$array[] = 'News';
    	$array[] = 'Other';


    	foreach ($array as $key => $value) {
    		# code...
    	}
    	$model = new \Dash\Models\Event\Attendees;
        $model->setFilter('howdidyouhear', $value);
      
        $count = $model->getTotal();

      	echo $value .' : '.$count;

    }

}


?>