<style>* { color: #fff !important;}</style>
  <link rel="stylesheet" href="/display/css/superslides.css">
  <link rel="stylesheet" href="/own/fancybox/jquery.fancybox.css">

    <div class="container">
    <div id="hidden" style="display:none;"><a class="fancybox"></a></div>
    <div class="grid">
      <div class="row">
        <div class="span12" style="text-align:center;">
           <h1 class="fg-white"><?php echo @$SESSION['event']->name;?></h1>
		<hr/>
            <h2 class="fg-white"><?php echo @$SESSION['event']->dates['start_date'];?></h2>
        </div>
      </div>
    </div>

    <?php if(@$SESSION['user']) {
      $user = $SESSION['user'];

      echo ' Thanks for Loggin in : ';
      echo $user->first_name .' ' . $user->last_name;
      
    } ?>

    <?php if(!empty($user->{'social.facebook.profile'})) :?>
    <h1>Facebook</h1>
    <?php foreach($user->{'social.facebook.profile'} as $key => $value) :?>
    <?php echo $key ?> : <?php echo $value; ?> <br>
    <?php endforeach;?>
    <?php endif; ?>




        <div class="page-footer">
            <div class="page-footer-content">
            <?php if(@$showselfregister) : ?>
            <div id="role" style="text-align:center;">
            <a href="/band/<?php echo $tagid; ?>/selfsignup" class="button large inverse fg-white" style="width:80%; margin-bottom:25px;background:rgba(229,10,10,0.6)!important">Register your wristband</a>
            </div><br><br>
            <div id="role" style="text-align:center;">
            <a href="/self/signin/<?php echo$tagid; ?>" class="button large warning">Already Registered?</a>
            </div>
             
            <?php endif; ?>
            </div>
        </div>
    </div>
<?php //easy mode ?>
<form action="/sysauth" method="post" id="sysform">
  <input id="key" type="hidden" name="authkey">
</form>
 <script src="/own/fancybox/jquery.fancybox.js" type="text/javascript"></script>
 <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  <script type="text/javascript">

	$(document).ready(function() {
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





  </script>