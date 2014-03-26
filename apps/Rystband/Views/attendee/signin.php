

<header class="bg-dark border" data-load="/header-cust"></header>
    <div class="container">
  
	<div class="grid">
	  <div class="row">
	    <div class="span12">
	<?php echo \Dsc\System::instance()->renderMessages(); ?>

	    	     <br/>
		<form method="post" action="/attendee/assign/tag/<?php echo $PARAMS['tagid']; ?>">
			<fieldset>
                <legend>Customer Info </legend><br>
                                        <label>First Name</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="first_name" type="text" placeholder="First name" >
                                        </div>
                                        <label>Last Name</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="last_name" type="text" placeholder="Last name"   >
                                        </div>
                        
                                        <label>Phone</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="phone" type="text" placeholder="Phone"  >
                                        </div>	
		<br/><br/>
		                                
                                        <input type="hidden" name="submitType" value="save_confirm";>      
                                        <input type="submit" value="Activate New Band" class="inverse large">
                                    </fieldset>
                                </form>
	    </div>
	  </div>
	</div>
   

        <div class="page-footer">
            <div class="page-footer-content">
                <!--<div data-load="header.html"></div>-->
            </div>
        </div>
    </div>
