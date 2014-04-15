<?php


// THIS THE PRODUCTS PAGE ?>
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
  <ul class="items">
     <li>    
       <a href="#" class="btn item" data-name="Burger" data-items="1">Burger</a>
     </li>
     <li>    
       <a href="#" class="btn item" data-name="Hotdog" data-items="1">Hotdog</a>
     </li>
     <li>    
       <a href="#" class="btn item" data-name="Pretzel" data-items="1">Pretzel</a>
     </li>
     <li>    
       <a href="#" class="btn item" data-name="SM Soda" data-items="1">SM Soda</a>
     </li>
     <li>    
       <a href="#" class="btn item" data-name="MED Soda" data-items="1">MED Soda</a>
     </li>
     <li>    
       <a href="#" class="btn item" data-name="LRG Soda" data-items="1">LRG Soda</a>
     </li>
   </ul>
   <div class="bottom">
    <a href="#" class="confirm btn green lrg">Confirm Order</a>
   </div>
  </div>
<form action="" method="POST" enctype="multipart/form-data" id="frm">
	<input type="hidden" id="products" name="products[]">
</form>
  <script>
    $(document).ready(function(){
      var items= [];
      
      $('.confirm').click(function(e){
	 e.preventDefault();
	      if (items.length !==0 ) {
		$('#frm').submit();
	      }
	});


      $('.item').click(function(e){
	 e.preventDefault();
	if ( $(this).hasClass('active')  ) {
		$(this).data('items', $(this).data('items') + 1);
		$(this).html( $(this).data('name') + '<small> x' + $(this).data('items') + '</small>');
	}
	$(this).addClass('active');
	 items.push($(this).data('name'));

			$('#products').val(items);
	$.each(items, function(index, val) {
	    console.log(val);
	});

      });
      

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