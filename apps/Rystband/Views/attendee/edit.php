

<header class="bg-dark border" data-load="/header-cust"></header>
    <div class="container">
  
    <div class="grid">
      <div class="row">
        <div class="span12">
                 <br/>
        <form method="post" action="/attendee/customer/update/<?php echo $item->_id; ?>" autocomplete="off" >
            <fieldset>
                <legend>Customer Info ( required )</legend><br>
                                        <label>First Name</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="first_name" type="text" placeholder="First name" value="<?php echo $flash->old('first_name'); ?>">
                                        </div>
                                        <label>Last Name</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="last_name" type="text" placeholder="Last name" value="<?php echo $flash->old('last_name'); ?>"  >
                                        </div>
                                        <label>Email</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="email" type="email" placeholder="Email Address" autofocus="" value="<?php echo $flash->old('email'); ?>">
                                        </div>
                                        <label>Phone</label>
                                        <div class="input-control text" data-role="input-control">
                                            <input name="phone" type="tel" placeholder="Phone" value="<?php echo $flash->old('phone'); ?>" >
                                        </div>  
        <br/><br/>
           <legend></legend>
            
                                       <label>Receive offers/updates from Microsoft? <small>( <a href="/privacy/policy" target="_BLANK" class="fg-white tiny">Privacy Policy</a> )</small></label>
                                        <div class="input-control checkbox">
                                            <input name="offers[email]" type="checkbox" checked>
                          <span class="check"></span>email
                                        </div>  <br/>
                                        <div class="input-control checkbox">
                                            <input name="offers[sms]" type="checkbox" checked>
                          <span class="check"></span>sms
                                        </div><br/><br/>                
                                        <input type="hidden" name="submitType" value="save_confirm";>      
                                        <input type="submit" value="Register" class="inverse large">
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

 