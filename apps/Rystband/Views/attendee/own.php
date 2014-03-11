
    <div class="container">
  
    <div class="grid">
      <div class="row">
        <div class="span12" style="text-align:center;">
           <h1 class="fg-white"><?php echo @$SESSION['event']->name;?></h1>
		<hr/>
            <h2 class="fg-white"><?php echo @$SESSION['event']->dates['start_date'];?></h2>
        </div>
      </div>
    </div>

    <?php if(@$SESSION['dash']['user']) {
      $user = $SESSION['dash']['user'];

      echo ' Thanks for Loggin in : ';
      echo $user->first_name .' ' . $user->last_name;
      
    } ?>

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
 <script src="http://js.pusher.com/2.1/pusher.min.js" type="text/javascript"></script>
  <script type="text/javascript">
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
  </script>