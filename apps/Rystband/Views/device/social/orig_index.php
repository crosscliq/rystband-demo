<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Rystband-TV Autoshow Demo</title>
  <link rel="stylesheet" href="/display/css/superslides.css">
  <link rel="stylesheet" href="/display/css/jquery.toastmessage.css" />

</head>
<body>
    <div id="logo" style="position:absolute; top:20px;text-align:center; width:100%; z-index: 1000;">
      <div id="img" style="margin:0 auto; width: 974px; height:86px; background:url(/display/images/Imports_logo.png) no-repeat;"></div>
    </div>
  <div id="slides" style="z-index: 900;">
    <div class="slides-container">
      <img src="/display/images/TV_1.jpg" width="1024" height="768" alt="Lambo">
      <img src="/display/images/TV_2.jpg" width="1024" height="768" alt="R8">
      <img src="/display/images/TV_3.jpg" width="1024" height="768" alt="Bugatti">
      <img src="/display/images/TV_4.jpg" width="1024" height="768" alt="Aston">
    </div>

    
  </div>

					    <h2>   </h2>

  <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  <script src="/display/javascripts/jquery.easing.1.3.js"></script>
  <script src="/display/javascripts/jquery.animate-enhanced.min.js"></script>
  <script src="/display/javascripts/jquery.toastmessage.js"></script>
  <script src="/display/javascripts/jquery.superslides.min.js" type="text/javascript" charset="utf-8"></script>
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



    $(function() {
      $('#slides').superslides({
        hashchange: true,
                               animate: 'fade',
                              
        play:8000
      });

      $('#slides').on('mouseenter', function() {
        $(this).superslides('stop');
        console.log('Stopped')
      });
      $('#slides').on('mouseleave', function() {
        $(this).superslides('start');
        console.log('Started')
      });
    });
  </script>
</body>
</html>

