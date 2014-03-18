<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rystband-TV Autoshow Demo</title>
  <link rel="stylesheet" href="/display/css/superslides.css">
  <link rel="stylesheet" href="/display/css/jquery.toastmessage.css" />

</head>
<body id="car">

  <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  <script src="/display/javascripts/jquery.easing.1.3.js"></script>
  <script src="/display/javascripts/jquery.animate-enhanced.min.js"></script>
  <script src="/display/javascripts/jquery.toastmessage.js"></script>

  <script>

	
	 // Enable pusher logging - don't include this in production
				   

	var pusher = new Pusher("<?php echo $item->{'pusher.public'}; ?>");
	var channel = pusher.subscribe("<?php echo $item->{'pusher.channel'}; ?>");
	  channel.bind('index', function(data) {
	    console.log(data);
	    str = data.attendee.first_name + ' ' + data.attendee.last_name + '<p class="bottom"> Has checked in.<p>';

        	$().toastmessage('showToast', {
     	        	text     : str,
   	  	       sticky   : false,
   		       position : 'top-right',
   	         	badge     : data.attendee.badge,

   	     	});
 
	  });

	  channel.bind('post', function(data) {

        	$().toastmessage('showToast', {
     	        	text     : data.feature,
   	  	       sticky   : false,
   		       position : 'top-right',
   	         	badge     : 'rate-' + data.feature,

   	     	});

	  });

    

  </script>
</body>
</html>

