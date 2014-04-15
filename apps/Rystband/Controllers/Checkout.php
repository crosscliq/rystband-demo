<?php 
namespace Rystband\Controllers;

class Checkout extends Base 
{   
    var $pusher = null;
	   var $products = array( 
        'Pretzel' => array('name' => 'Pretzel', 'price' => 5.00),
        'MED Soda' => array('name' => 'MED Soda', 'price' => 6.00),
        'LRG Soda' => array('name' => 'LRG Soda', 'price' => 7.00),
        'SM Soda' => array('name' => 'SM Soda', 'price' => 8.00),
        'Hotdog' => array('name' => 'Hotdog', 'price' => 9.00),
        'Burger' => array('name' => 'Burger', 'price' => 10.00) 

        );


    public function cart() {
        $f3 = \Base::instance();
       
        $view = new \Dsc\Template;
        $view->setLayout('content.php');
        $f3->set('channel', 'cart');
        echo $view->render('checkout/cart.php');

        
    }

    public function saveCart() {
        $f3 = \Base::instance();
        $f3->set('channel', 'cart');
        $products_ids = explode(',',$f3->get('POST.products')[0]);
	

        $products = array();
        foreach ($products_ids as $key => $value) {
            if(@is_array($this->products[$value])){
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

        $f3->get('SESSION.active_role', 'processcart');
    
         $f3->set('channel', 'cart');
        echo $view->render('checkout/checkout.php');

    }
    public function showPayment() {
        $f3 = \Base::instance();
        $view = new \Dsc\Template;
        $view->setLayout('content.php');

        $attendee = (new \Rystband\Models\Attendees)->setState('filter.id', $f3->get('PARAMS.id'))->getItem();

        $f3->set('SESSION.active_role', 'processcart');
        $f3->set('channel', 'cart');
          $products =  $f3->get('SESSION.products');
          $total = 0;
          foreach ($products as $key => $product) {
              $total = $total + $product['price'];     
             }

        $f3->set('attendee',$attendee);
        $f3->set('total', $total);
        $f3->set('availCredits', $total * 3);
             

        echo $view->render('checkout/showpayment.php');
    }

    public function doCheckout() {
        $f3 = \Base::instance();
        $products =  $f3->get('SESSION.products');
        $f3->set('products', $products);

        $attendee = (new \Rystband\Models\Attendees)->setState('filter.id', $f3->get('PARAMS.id'))->getItem();


        $pusher = new \Pusher($f3->get('pusher_key'), $f3->get('pusher_secret'), $f3->get('pusher_app_id'));
        $data = array('attendee' => (array) $attendee->cast() );
        $pusher->trigger('tvdevice1', 'post', $data);
        
     
       
        $view = new \Dsc\Template;
        $view->setLayout('content.php');
        $f3->set('channel', 'cart');
        echo $view->render('checkout/success.php');
    }

    public function addProduct() {
       
        
        echo 1;

        die();

    }

    public function external() {
           $view = new \Dsc\Template;
        $view->setLayout('content.php');
        $f3->set('channel', 'cart');
        echo $view->render('checkout/externaldisplay.php');

    }


}


?> 
