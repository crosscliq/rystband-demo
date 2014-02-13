<?php 

function format_telephone($phone_number)
{
    $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
   if(strlen($cleaned) > 4) {	
    preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);
    return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
 } else {
	return $cleaned;
}
}

?>


 <header class="bg-dark border" data-load="/header"></header>
    <div class="container">
  
    <div class="grid">
      <div class="row">
        <div class="span12" style="padding-top:45px;">
		<legend>Winner</legend>
     
                <div id="role" style="text-align:center;">
			
			<h2 class="fg-white"><?php echo $game["winner"]["first_name"]; ?> <?php echo $game["winner"]["last_name"]; ?></h2>
			<br/>PHONE: <?php echo format_telephone($game["winner"]["phone"]); ?><br/>
<form action="/games/raffle/play" method="post">
<button type="submit"  class="button large inverse fg-white" style="width:80%; margin-bottom:25px;background:rgba(0,0,0,0.6)!important">Play Again</button>
</form>
		
                </div>


             

        </div>
      </div>
    </div>
   
        <div class="page-footer">
            <div class="page-footer-content">

                <!--<div data-load="header.html"></div>-->
            </div>
        </div>
    </div>

