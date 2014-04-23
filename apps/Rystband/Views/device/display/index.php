<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rystband Display</title>
  <link rel="stylesheet" href="/display/css/superslides.css">
  <link rel="stylesheet" href="/display/css/jquery.toastmessage.css" />

</head>
<body id="" style="background:url('../../photo/assets/img/bg2.jpg') no-repeat; background-size:cover; background-position:top center;">

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
	    str = data.attendee.first_name + ' ' + data.attendee.last_name + ' <br/>Has checked in.';

        	$().toastmessage('showToast', {
     	        	text     : str,
   	  	       sticky   : false,
   		       position : 'top-right',
   	         	//badge     : data.attendee.badge,
			badge    : 'winner'
   	     	});
 
	  });

	  channel.bind('post', function(data) {
		

		    str = data.attendee.first_name + ' ' + data.attendee.last_name + ' Rated this car.';
        	$().toastmessage('showToast', {
     	        	text     : str,
   	  	       sticky   : false,
   		       position : 'top-right',
   	         	badge     : 'rate-' + data.feature,

   	     	});

	  });

    	  channel.bind('game_spin', function(data) {
		console.log('game!');
		console.log(data);

	  });

  </script>
</body>
</html>

