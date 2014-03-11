

<header class="bg-dark border" data-load="/header-cust"></header>
    <div class="container">
  
	<div class="grid">
	  <div class="row">
	    <div class="span12">
	<?php echo \Dsc\System::instance()->renderMessages(); ?>

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
         <label>Do you own any Microsoft products?</label>
                                         <div class="checkbox">
                                            <input name="products[xboxone]" type="checkbox">
                          <span class="check"></span>Xbox One
                                        </div>  <br/>
                                        <div class="checkbox">
                                            <input name="products[xbox360]" type="checkbox">
                          <span class="check"></span>Xbox 360
                                        </div><br/>
                                        <div class="checkbox">
                                            <input name="products[kinect]" type="checkbox">
                          <span class="check"></span>Kinect
                                        </div><br/>
                                        <div class="checkbox">
                                            <input name="products[surface]" type="checkbox">
                          <span class="check"></span>Surface
                                        </div><br/>
                                        <div class="checkbox">
                                            <input name="products[pc]" type="checkbox" >
                          <span class="check"></span>PC
                                        </div><br/>
                                        <div class="checkbox">
                                            <input name="products[windowsphone]" type="checkbox" >
                          <span class="check"></span>Windows Phone
                                        </div><br/>
                                        <div class="checkbox">
                                            <input name="products[office]" type="checkbox" >
                          <span class="check"></span>Office
                                        </div><br/>
 

           <legend></legend>
            
                                        <label>Receive offers/updates from Microsoft? <small>( <a href="/privacy/policy" target="_BLANK" class="fg-white tiny">Privacy Policy</a> )</small></label>
                                        <div class="checkbox">
                                            <input name="offers[email]" type="checkbox" checked>
                          <span class="check"></span>email
                                        </div>  <br/>
                                        <div class="checkbox">
                                            <input name="offers[sms]" type="checkbox" checked>
                                <span class="check"></span>sms
                                        </div><br/><br/>    

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
                                                     <small>Data collected by Crosscliq on behalf of Microsoft retail stores</small>

            </div>
        </div>
    </div>
