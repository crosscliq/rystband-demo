<?php 
namespace Rystband\Controllers;

class Checkout extends Base 
{   
    var $pusher = null;
    var $products = array( 'pretzel' => array('name' => 'Pretzel', 'price' => 5.00),
    'burger' => array('name' => 'Burger', 'price' => 7.00) 

        );



    public function cart() {
        $f3 = \Base::instance();
       
        $view = new \Dsc\Template;
        $view->setLayout('content.php');
        echo $view->render('checkout/cart.php');

    }

    public function saveCart() {
        $f3 = \Base::instance();
        
        $products_ids = explode(',', $f3->get('POST.products'));

        $products = array();
        foreach ($products_ids as $key => $value) {
            if(is_array($this->products[$value])){
                $products[] = $this->products[$value];
            }
        }

        $f3->set('SESSION.products', $products);

        $f3->reroute('/checkout'); 
       
    }

     public function checkout() {
        $f3 = \Base::instance();
        $products =  $f3->get('SESSION.products');
        $f3->set('products', $products);

        $view = new \Dsc\Template;
        $view->setLayout('content.php');
        echo $view->render('checkout/checkout.php');

    }


    public function doCheckout() {
        $f3 = \Base::instance();
        $products =  $f3->get('SESSION.products');
        $f3->set('products', $products);

        $tagid = $f3->get('PARAMS.tagid');
        $tags = new \Rystband\Models\Tags;
        $tags->setState('filter.tagid', $tagid);
        $tag = $tags->getItem();

        $attendees = new \Rystband\Models\Attendees;
        $attendees->setState('filter.id', $tag->{'attendee.id'});
        $attendee = $attendees->getItem();

        $pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id'));
        $data = array('feature' => $f3->get('POST.feature'), 'attendee' => (array) $attendee->cast() );
        $pusher->trigger('tvdevice1', 'post', $data);
        
        $f3->set('tag', $tag);
        $f3->set('tagid', $tagid);

        $route = \Base::instance()->get('PARAMS[0]');
        $peices = explode('/', $route);
        $channel = end($peices);
       
        $f3->set('channel', $channel);
      
        if(empty($tag->attendee)) {
            $f3->set('showselfregister', true);
            $view = new \Dsc\Template;
            echo $view->render('Msft/Views::attendee/own.php');
        } else {
             $f3->set('showselfregister', false);
            $view = new \Dsc\Template;
            echo $view->render('Msft/Views::attendee/own.php');
        }

    }

    public function addProduct() {
       
        
        echo 1;

        die();

    }

    public function external() {
           $view = new \Dsc\Template;
        $view->setLayout('content.php');
        echo $view->render('checkout/externaldisplay.php');

    }


}


?> 
