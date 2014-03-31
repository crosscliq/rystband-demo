

<header class="bg-dark border" data-load="/header-cust"></header>
    <div class="container">
  
	<div class="grid">
	  <div class="row">
	    <div class="span12">
	<?php echo \Dsc\System::instance()->renderMessages();


    //echo $SESSION['tagid']; ?>


            <br>
        <fieldset>
            <legend>Use service</legend>
          
            &nbsp;&nbsp;<a class="button large inverse fg-white" href="/attendee/social/auth/facebook">Sign-in with Facebook</a><br />
            <br>
            &nbsp;&nbsp;<a class="button large inverse fg-white" href="/attendee/social/auth/twitter">Sign-in with Twitter</a><br />  

        </fieldset>
	    	     <br/>
		<form method="post" action="<?php echo $PARAMS[0]; ?>">
			<fieldset>
                <legend>Customer Info </legend><br>
                            <label>First Name <span class="required">*</span></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="first_name" type="text" placeholder="First name" value="">
                                        </div>
                                        <label>Last Name <span class="required">*</span></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="last_name" type="text" placeholder="Last name" value=""  >
                                        </div>
                                        <label>Email </label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="email" type="email" placeholder="Email Address" autofocus="" value="">
                                        </div>
                                        <label>Phone <span class="required">*</span></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="phone" type="tel" placeholder="Phone" value="" ><br>
                                            <small>(Min last 4 required for raffle entry.)</small>
                                       
                                        </div>
                                        <label>Zip Code </label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="zipcode" type="text" placeholder="Zipcode" value="" >
                                            <small>*Minimum information needed for raffle entry</small>
                                        </div>  

                    
        <br/><br/>
                                        </div>
                                         <legend></legend>
          

					               		 <input type="hidden" name="selfregistered" value="true"> 
                                        <input type="hidden" name="submitType" value="save_confirm">      
                                        <input type="submit" value="Activate New Band" class="inverse large">
                                   

                                    </fieldset>
                                </form>
	    </div>
	  </div>
	</div>
   

        <div class="page-footer">
            <div class="page-footer-content" style="text-align:center;"><br>
                                                     <small>Data collected by Crosscliq.com</small>

            </div>
        </div>
    </div>
