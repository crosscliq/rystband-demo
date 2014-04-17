<?php echo \Dsc\System::instance()->renderMessages(); ?>
    <?php if(@$SESSION['user']) {
      $user = $SESSION['user'];
    } ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=0" />
 <script src='/dash/js/jquery.js' type='text/javascript'></script>

  <link rel="stylesheet" href="/own/profile/css/profile.css">
  <link rel="stylesheet" href="/own/fancybox/jquery.fancybox.css">
<style type="text/css">
 .pop { color:#000!important; }
 #background {
     margin-left:-20px;
     margin-top:-20px;
     padding-right:30px;
     padding-bottom:30px;
     height:100%;
     width:100%;
     background:url(<?php echo(@$user->{'social.facebook.profile.photoURL'}); ?>) no-repeat;
     background-size:cover;
     
    -moz-filter: blur(14px);
    -o-filter: blur(14px);
    -ms-filter: blur(14px);
     filter: blur(14px);
     opacity: 0.6;
     z-index:0;
 }
 #photo {

	opacity:0;
	-webkit-transition: all .5s ease-in-out; 
	display:block;
	position:absolute;
	margin: 0;
	padding:0;

	-webkit-box-shadow:0 2px 5px rgba(0,0,0,0.5) , 0 6px 0 rgba(255,255,255,0.4) inset;
	-moz-box-shadow:0 2px 5px rgba(0,0,0,0.5) , 0 6px 0 rgba(255,255,255,0.4) inset;
	box-shadow:0 2px 5px rgba(0,0,0,0.5) , 0 6px 0 rgba(255,255,255,0.4) inset;	
	-webkit-box-shadow: inset 0px 0px 63px 3px rgba(101, 63, 90, 0.8);
	border:6px solid rgba(255,255,255,0.4);	
	-webkit-border-radius:100%;
	background-size:100%!important;
	background-position:center;
	background:rgba(255,255,255,.2);
       background:url('<?php echo(str_replace("150","250",@$user->{'social.facebook.profile.photoURL'}));?>') no-repeat;
       z-index:10;
 }
</style>


</head>
<body>

    <?php if(@$SESSION['user']) :?>

<audio id="beepsound" src="/own/profile/beep.mp3" preload="auto"></audio>
<audio id="loadsound" src="/own/profile/whoosh.mp3" preload="auto"></audio>
<div id="wrapper">
<div id="media" class="modal"><a href="#" class="navicon"><img src="/own/profile/images/home.png"></a><p class="title">Media</p>
<div class="modalbody">

<table width="100%" cellspacing="2" cellpadding="8" border="0">
	<tr>
		<th>Filename</th>
		<th>Type</th>
		<th>Options</th>
	</tr>
	<tr>
		<td>file.mp3</td>
		<td>Audio</td>
		<td> x y z</td>
	</tr>
	<tr>
		<td>file2.jpg</td>
		<td>Photo</td>
		<td> x y z</td>
	</tr>
	<tr>
		<td>file3.doc</td>
		<td>Document</td>
		<td> x y z</td>
	</tr>
</table>
</div>
</div>
<div id="hidden" style="display:none;"></div>
<div id="settings" class="modal"><a href="#" class="navicon"><img src="/own/profile/images/home.png"></a><p class="title">Settings</p><div class="modalbody">this is settings</div></div>
<div id="profile" class="modal"><a href="#" class="navicon"><img src="/own/profile/images/home.png"></a><p class="title">Profile</p><div class="modalbody"><a href="<?php echo $PARAMS[0] ?>/credits" class="fb">Manage Credits / Buy Credits</a></div></div>
<div id="connections" class="modal"><a href="#" class="navicon"><img src="/own/profile/images/home.png"></a><p class="title">Connections</p><div class="modalbody"><a href="http://google.com" class="fb">Share to Facebook</a></div></div>
<div id="glass"><p class="logo">RYST</p>
<p class="name"><?php echo(strtoupper(@$user->{'social.facebook.profile.firstName'})); ?> <?php echo(strtoupper(@$user->{'social.facebook.profile.lastName'})); ?><br/><small><?php echo(@$user->{'social.facebook.profile.region'});?></small></p>

</div>
<div id="photo">
	<div id="icons">
		<img src="/own/profile/images/media.png" class='icon itop' tar="#media">
		<img src="/own/profile/images/settings.png" class='icon ibottom' tar="#settings">
		<img src="/own/profile/images/connections.png" class='icon ileft' tar="#connections">
		<img src="/own/profile/images/profile.png" class='icon iright' tar="#profile">
	</div>
</div>

<div id="background">
</div>
</div>




<?php //easy mode ?>
<form action="/sysauth" method="post" id="sysform">
  <input id="key" type="hidden" name="authkey">
</form>
 

 <script src="/own/fancybox/jquery.fancybox.js" type="text/javascript"></script>
 <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  
<script type="text/javascript">


				




		$(window).load(function() {
			if ($(document).width() <= $(document).height() ) {
				var size=$(document).width();
			} else {
				var size=$(document).height();       
			}

			$('#photo').css('height',size-100);
			$('#photo').css('width',size-100);


			var pW=(size-100)/2;
			var dW=$(document).width()/2
			var leftL=(dW-pW)-10;

			var pH=(size-100)/2;
			var dH=$(document).height()/2
			var topL=(dH-pH);

			$('#photo').css('top',topL);
			$('#photo').css('left',leftL);
			$('#photo').css('opacity',1);
			$('#icons').css('opacity','0.9');
			$('.icon').css('opacity','0.9');
			setTimeout( function () { document.getElementById('loadsound').play(); } , 700);
			$('#background').blurjs({ 
				source: '#photo',
				draggable: false,
				offset: {
					x:50,
					y:0
				},
				radius:30
			});

			$('#background').css('opacity',1);
			window.scroll(0,0);	
		});



	$(document).ready(function() {
$(window).resize(function() {

			if ($(document).width() <= $(window).height() ) {
				var size=$(window).width();
			} else {
				var size=$(window).height();       
			}	
			$('#photo').css('height',size-100);
			$('#photo').css('width',size-100);

		
			var pW=(size-100)/2;
			var dW=$(document).width()/2
			var leftL=(dW-pW)-10;


			var pH=(size-100)/2;
			var dH=$(document).height()/2
			var topL=(dH-pH);


			$('#photo').css('top',topL);
			$('#photo').css('left',leftL);

});


function goAway() { 
				document.getElementById('beepsound').play();	
			 	$('#photo').toggleClass('hidden');
				 $('.name').toggleClass('blurtext');
				 $('.logo').toggleClass('blurtext');
				$('.modal').fadeOut();
			}
			$('.fb').click( function(e) {
				e.preventDefault();
				window.location.href="/share/facebook";
			});

			$('.title').click( function(e) {
				e.preventDefault();
				goAway();
			});
			$('.navicon').click( function(e) {
				e.preventDefault();
				goAway();
			});
			$('.icon').on({ 'touchend' : function(e){ 		
				document.getElementById('beepsound').play();	
				 e.preventDefault();
				 $('#photo').toggleClass('hidden');
				 $('.name').toggleClass('blurtext');
				 $('.logo').toggleClass('blurtext');
				 $( $(this).attr('tar')).show(); 
				 $(this).toggleClass('selected');
			}});

			$('.icon').click( function(e){ 		
				document.getElementById('beepsound').play();	
				 e.preventDefault();
				 $('#photo').toggleClass('hidden');
				 $( $(this).attr('tar')).delay(400).fadeIn(); 
				 $('.name').toggleClass('blurtext');
				 $('.logo').toggleClass('blurtext');
				 $(this).toggleClass('selected');
			});




		$(".fancybox").fancybox();
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

      $('#key').val(data.authkey);
      $('#sysform').submit();
    });
    channel.bind('content', function(data) {

  	var thePage = data.content;

     $('#hidden').load(thePage, function(){
       var theData = $('#hidden').html(); 
       $.fancybox(theData);
    });

    });
    channel.bind('index', function(data) {
      str = data.attendee.first_name + ' ' + data.attendee.last_name + ' Would you like to sign up for sweet offer?';
      confirm(str);
    });

    channel.bind('social', function(data) {
      $.fancybox('You shared this on Facebook!');

    });



  </script>

<?php else :  ?>

<?php if(@$showselfregister) : ?>
<div class="pushdown">

            <div id="role" style="text-align:center;">
            <a href="/band/<?php echo $tagid; ?>/selfsignup" class="btn" style="">Register your wristband</a>
            </div><br>
            <div id="role" style="text-align:center;">
            <a href="/self/signin/<?php echo$tagid; ?>" class="btn" style="">Already Registered?</a>
            </div>
</div>
 <div id="glass"><p class="logo">RYST</p>            
<?php else : ?>
This Band has been activated but you are not logged in.<br/>

 <fieldset>
            <legend></legend>
          
            <a class="btn" href="/attendee/social/auth/facebook">Sign-in with Facebook</a>
            <br>
          

        </fieldset>


<?php endif; ?>



<?php endif; ?>

</body>