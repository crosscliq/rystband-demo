<html>
  <head>
    <meta charset="utf-8">
    <title>Success</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  
  <link rel="stylesheet" href="/carts/css/style.css" />
  </head>
  <body>
  <div style="wrapper"><br/><br/>
<h1 class="callout total">Thanks!, <br/>Your Transaction<br/> Is Complete!</h1>
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