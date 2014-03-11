 <header class="bg-dark border" data-load="/header"></header>
    <div class="container">

        <div class="grid">
          <div class="row">
            <div class="span12">
               <?php echo \Dsc\System::instance()->renderMessages(); ?>
             <br/>
                <form method="post" action="<?php echo $PARAMS[0]?>" autocomplete="off" >
                        <fieldset>
                                <legend>Customer Profile</legend>
                                             <div class="input-control select">
                                        <label>Gender</label>
                                                <select name="gender" >
                                                        <option>Male</option>
                                                        <option>Female</option>
                                                </select>
                                             </div><br/><br/>
                                             <div class="input-control range">
                                        <label>Age Estimate ( 10 - 80 )</label>
                                             <span id="ageval"></span>
                                             <input type="range" name="age" min="10" max="80" step="5" value="<?php echo $flash->old('age'); ?>" onchange="updateRange(value)">
                                             </div><br/>
                                            <div class="input-control select">
                                        <label>How did you hear about this event?</label>
                                                <select name="howdidyouhear" >
                                                        <option>Word of Mouth</option>
                                                        <option>Radio</option>
                                                        <option>Mall Signage</option>
                                                        <option>Social Media</option>
                                                        <option>Friend/Family</option>
                                                        <option>Online</option>
                                                        <option>Community Event</option>
                                                        <option>Newspaper</option>
                                                        <option>News</option>
                                                        <option>Other</option>
                                                </select>
                                             </div><br/>
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
     <br>
                                             <br/><br/>
                                        <input type="hidden" name="tagid" value="<?=$tagid?>">
                                        <input type="hidden" name="submitType" value="save_customer">
                                        <input type="submit" value="Register" class="btn large inverse">
						<br/><br/>
					     <a href="/attendee/signin/<?=$tagid?>" class="button large warning">Already Registered?</a>
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
 <script type="text/javascript">
        
                function updateRange(e)  {
                        $('#ageval').text(e);
                };
        
        </script>
