<html>
  <head>
    <meta charset="utf-8">
    <title>Order</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  
  <link rel="stylesheet" href="/carts/css/style.css" />
  </head>
  <body>
  <div style="wrapper">
<ul class="sum">
 <?php 

//we are for eaching the Array we posting to /cart
setlocale(LC_MONETARY, 'en_US');
$total=0;
foreach($products as $product) {
	$total=$total+$product['price'];	
//	var_dump($product);
	echo "<li>".$product['name']."<span>".$product['price']."</span></li>";
}?>
</ul>
<h3 class="total">Total: <?php echo  $total; ?></h3>
<h1 class="callout">Tap Band <br/><small>to</small><br/> Complete<br/>Transaction</h1>
  <form action="" method="post" enctype="">


  </form>
  </div>

  <script type="text/javascript">

     $(document).ready(function(){

      // Enable pusher logging - don't include this in production
    Pusher.log = function(message) {
      if (window.console && window.console.log) {
        window.console.log(message);
      }
    };

    var pusher = new Pusher('<?php echo $pusher_key; ?>');
    var channel = pusher.subscribe('<?php echo $channel; ?>');
    

    channel.bind('message', function(data) {

    });



     });
</script>
</body>
</html>