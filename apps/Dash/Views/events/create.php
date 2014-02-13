<?php //echo \Dsc\Debug::dump( $flash->get('old'), false ); ?>

<div class="row">
 <div class="col-lg-6">
   <div class="widget">
    <div class="widget-header"> <i class="icon-plus-sign"></i><h3>Create Event</h3></div>
    <div class="widget-content">
  
       <form id="detail-form" action="" class="form" method="post">
		<div class="row">
                  <div class="col-md-3">
                    <label for="normal-field" class="control-label">Event Name</label>
                    </div>
                    <div class="col-md-9">
                    <div class="form-group">
			 <input type="text" name="name" placeholder="Event Name" value="<?php echo $flash->old('name'); ?>" class="form-control"> 
                    </div>
                    </div>
        </div>
		<div class="row">
                 <div class="col-md-3">
                    <label for="normal-field" class="control-label">Event ID</label>
                 </div>
                    <div class="col-md-9">
                    <div class="form-group">
			 <input type="text" name="event_id" placeholder="Event ID" value="<?php echo $flash->old('event_id'); ?>"  class="form-control"> 
                    </div>
                    </div>
        </div>
		<div class="row">

                  <div class="col-md-3">
                    <label for="normal-field" class="control-label">Dates</label>
                  </div>

                  <div class="col-md-4">
		     <div class="input-group"> <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" placeholder="Start Date" value="<?php echo $flash->old('dates.start_date' ); ?>" size="16" class="form-control datepicker" id="dates[start_date]" data-inputmask="'alias': 'date'">
                   </div>
                  </div>
                 <div class="col-md-4">
		     <div class="input-group"> <span class="input-group-addon"><i class="icon-calendar"></i></span>
                    <input type="text" placeholder="End Date" value="<?php echo $flash->old('dates.end_date' ); ?>" size="16" class="form-control datepicker" id="dates[end_date]" data-inputmask="'alias': 'date'">
                   </div>
                  </div>
	</div>
	<div class="control-group">
	
		<div class="row">
                  <div class="col-md-3"><br/>
                    <label for="normal-field" class="control-label">Category</label>
                  </div>

                  <div class="col-md-8">
				<br/>
				<?php $categories =  array('NSO'=> 'New Store Opening', 'XBOX'=> 'Xbox Event', 'HR'=> 'Human Resources', ); ?>
				<select name="category" class="form-control">
				  <?php foreach ($categories as $value => $text) : ?>
				  <option value="<?=$value?>" <?php if($value == $flash->old('category')){ echo 'selected="selected"';} ;?> > <?=$text?>
				  <?php endforeach; ?>
				</select>
		     
                  </div>
		</div>
		<div class="row">
                  <div class="col-md-3"><br/>
                    <label for="normal-field" class="control-label">Address</label>
                  </div>
                  <div class="col-md-3"><br/>
                    <input type="text" class="form-control" name="address[street]" placeholder="Street" value="<?php echo $flash->old('address.street') ?>" >
                  </div>
                  <div class="col-md-3"><br/>
                    <input type="text" class="form-control"  name="address[city]" placeholder="City" value="<?php echo $flash->old('address.city'); ?>" >
                  </div>
                  <div class="col-sm-2"><br/>
                    <input type="text" class="form-control"  name="address[state]" placeholder="State" value="<?php echo $flash->old('address.state'); ?>" >
                  </div>
		</div>
		<div class="row">
                  <div class="col-md-3"><br/>
                    <label for="normal-field" class="control-label"></label>
                  </div>	
                  <div class="col-sm-2"><br/>
                    <input type="text" class="form-control" name="address[zip]" placeholder="Zip" value="<?php echo $flash->old('address.zip'); ?>" >
                  </div>	
                  <div class="col-sm-2"><br/>
                    <input type="text" class="form-control"  name="address[country]" placeholder="Country" value="<?php echo $flash->old('address.country'); ?>" >
                  </div>
                  <div class="col-sm-4"><br/>
                    <input type="text" class="form-control" name="address[zip]" placeholder="Zip" value="<?php echo $flash->old('address.zip'); ?>" >
                  </div>
		</div>
		<div class="row">
		    <div class="col-md-3"><br/>
                    <label for="normal-field" class="control-label">Wristbands</label>
                  </div>
                  <div class="col-md-3"><br/>
                    <input type="text" class="form-control" name="wristbands[ordered]" placeholder="wristbands" value="<?php echo $flash->old('wristbands.ordered'); ?>" >
                  </div>
		</div>
		<div class="row">
		    <div class="col-md-3"><br/>
                    <label for="normal-field" class="control-label">Attendees</label>
                  </div>
                  <div class="col-md-3"><br/>
                    <input type="text" class="form-control" name="attendees" placeholder="Attendee Limit" value="<?php echo $flash->old('attendees'); ?>" >
                  </div>
		</div>
	           
                    <div><br/>
   			  <input class="btn btn-primary pull-right" type="submit" type="hidden" name="submitType" value="Save">      
                    </div>
             






		</div>

   
	</form>
   
   </div>
 </div>
</div>


