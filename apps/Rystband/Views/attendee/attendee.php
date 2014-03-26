



<header class="bg-dark border" data-load="/header-cust"></header>
    <div class="container">
  
    <div class="grid">
      <div class="row">
        <div class="span12">
    <?php echo \Dsc\System::instance()->renderMessages(); ?>

                 <br/>
               <form method="post" action="/attendee/customer/update/<?php echo $item->_id; ?>" autocomplete="off" >

            <fieldset>
                <legend>Customer Info </legend><br>
                            <label>First Name <span class="required">*</span></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="first_name" type="text" placeholder="First name" value="<?php echo $flash->old('first_name');?>">
                                        </div>
                                        <label>Last Name <span class="required">*</span></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="last_name" type="text" placeholder="Last name" value="<?php echo $flash->old('last_name');?>"  >
                                        </div>
                                        <label>Email </label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="email" type="email" placeholder="Email Address" autofocus="" value="<?php echo $flash->old('email');?>">
                                        </div>
                                        <label>Phone <span class="required">*</span></label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="phone" type="tel" placeholder="Phone" value="<?php echo $flash->old('phone');?>" ><br>
                                            <small>(Min last 4 required for raffle entry.)</small>
                                       
                                        </div>
                                        <label>Zip Code </label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="zipcode" type="text" placeholder="Zipcode" value="<?php echo $flash->old('zipcode');?>" >
                                            <small>*Minimum information needed for raffle entry</small>
                                        </div>  

                    
        <br/><br/>
                                        </div>
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
                                        <input type="submit" value="Register" class="inverse large">

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
