<header class="bg-dark border"></header>
<div class="container">
  
	<div class="grid"><br>
		  <div class="row">
		    <div class="span12 text-center">
			     <?php echo $item->{'device'}; ?>
		    </div>
		  </div>
		  <div class="row">
		    <div class="span12 text-center">
					<div class="notice marker-on-top bg-black">
					    <h2>   </h2>
					</div>
		    </div>
		  </div>



	</div>
   

        <div class="page-footer">
            <div class="page-footer-content">
                 <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
				  
				  <script type="text/javascript">
				    // Enable pusher logging - don't include this in production
				   

				    var pusher = new Pusher("<?php echo $item->{'pusher.public'}; ?>");
				    var channel = pusher.subscribe("<?php echo $item->{'pusher.channel'}; ?>");
				    channel.bind('index', function(data) {
				    	console.log(data);
				    	alert(data.attendee.first_name);
				    	str = data.attendee.first_name + ' ' + data.attendee.last_name + ' Has tapped their band  to the crossbox';
				     	$('h2').html(str);
				    });

				  </script>
            </div>
        </div>
</div>