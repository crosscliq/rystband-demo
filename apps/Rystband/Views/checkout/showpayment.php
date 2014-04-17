<html>
  <head>
    <meta charset="utf-8">
    <title>Tap Band</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="/carts/css/patternlock.css"/>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  <script src="/carts/js/patternlock.js"></script>

  <link rel="stylesheet" href="/carts/css/style.css" />
  </head>
<body ondragstart="return false;" ondrop="return false;">
  <div style="wrapper">
	<h3 class="callout">
<?php echo $attendee->first_name; ?>,<br/><small>This transaction will deduct <span class="total"><?php echo $total; ?></span> from your balance of <span class="total"><?php echo $availCredits; ?></span></small> 
	</h3>

<form method="post" onsubmit="return submitform()">
<h4 class="sub">Swipe to confirm</h4>

<div >
<input type="password" id="password" name="password" class="patternlock" />
<input type="submit" value="login"/>
</div>
</form>

	</div>

  <script type="text/javascript">

function submitform(){
	//alert("You entered " + document.getElementById("password").value);
	return true;
}
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