<div class="well">

<form id="detail-form" action="" class="form-horizontal" method="post">

    <div class="row">
        <div class="col-md-12">
        
            <div class="clearfix">

                <div class="pull-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <input id="primarySubmit" type="hidden" value="save_edit" name="submitType" />
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a onclick="document.getElementById('primarySubmit').value='save_close'; document.getElementById('detail-form').submit();" href="javascript:void(0);">Save & Close</a>
                            </li>
                        </ul>
                    </div>

                    &nbsp;
                    <a class="btn btn-default" href="./admin/customers">Cancel</a>
                </div>

            </div>
            <!-- /.form-actions -->
            
            <hr />
        
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab-basics" data-toggle="tab"> Basics </a>
                </li>
                <li>
                    <a href="#tab-groups" data-toggle="tab"> Groups </a>
                </li>
                <?php foreach ((array) $this->event->getArgument('tabs') as $key => $title ) { ?>
                <li>
                    <a href="#tab-<?php echo $key; ?>" data-toggle="tab"> <?php echo $title; ?> </a>
                </li>
                <?php } ?>
            </ul>
            
            <div class="tab-content">

                <div class="tab-pane active" id="tab-basics">
                
                    <div class="form-group">
                        <label class="col-md-3">Username</label>
        
                        <div class="col-md-7">
                            <input type="text" name="username" value="<?php echo $flash->old('username'); ?>" class="form-control" />
                        </div>
                        <!-- /.col -->
        
                    </div>
                    <!-- /.form-group -->
        
                    <div class="form-group">
        
                        <label class="col-md-3">First Name</label>
        
                        <div class="col-md-7">
                            <input type="text" name="first_name" value="<?php echo $flash->old('first_name'); ?>" class="form-control" />
                        </div>
                        <!-- /.col -->
        
                    </div>
                    <!-- /.form-group -->
        
                    <div class="form-group">
        
                        <label class="col-md-3">Last Name</label>
        
                        <div class="col-md-7">
                            <input type="text" name="last_name" value="<?php echo $flash->old('last_name'); ?>" class="form-control" />
                        </div>
                        <!-- /.col -->
        
                    </div>
                    <!-- /.form-group -->
        
                    <div class="form-group">
        
                        <label class="col-md-3">Email Address</label>
        
                        <div class="col-md-7">
                            <input type="text" name="email" value="<?php echo $flash->old('email'); ?>" class="form-control" />
                        </div>
                        <!-- /.col -->
        
                    </div>
                    <!-- /.form-group -->
                    
                    <div class="form-group">
        
                        <label class="col-md-3">New Password</label>
        
                        <div class="col-md-7">
                            <input type="password" name="new_password" class="form-control" autocomplete="off" />
                        </div>
                        <!-- /.col -->
        
                    </div>
                    <!-- /.form-group -->
                    
                    <div class="form-group">
        
                        <label class="col-md-3">Confirm New Password</label>
        
                        <div class="col-md-7">
                            <input type="password" name="confirm_new_password" class="form-control" autocomplete="off" />
                        </div>
                        <!-- /.col -->
        
                    </div>
                    <!-- /.form-group -->
                                 
                </div>
                <!-- /.tab-pane -->
                
                <div class="tab-pane" id="tab-groups">
                
                    <?php if (!empty($groups)) { ?>
        
                    <div class="portlet">
        
                        <div class="portlet-header">
        
                            <h3>Groups</h3>
        
                        </div>
                        <!-- /.portlet-header -->
        
                        <div class="">
                            <div id="groups" class="list-group">
                                <div id="groups-checkboxes">
                                <?php echo $this->renderLayout('Dash/Admin/Views::groups/checkboxes.php'); ?>
                                </div>
                                <script>
                                    Dsc.refreshCategories = function(r) {
                                        console.log('trying to get groups');
                                        var form_data = new Array();
                                        jQuery.merge( form_data, jQuery('#groups-checkboxes').find(':input').serializeArray() );
                                        jQuery.merge( form_data, [{ name: "groups_ids[]", value: r.result._id['$id'] }] );
        
                                        var request = jQuery.ajax({
                                            type: 'post', 
                                            url: './admin/users/groups/checkboxes',
                                            data: form_data
        
                                        }).done(function(data){
                                            var lr = jQuery.parseJSON( JSON.stringify(data), false);
                                            if (lr.result) {
                                                 console.log(lr.result);
                                                jQuery('#groups-checkboxes').html(lr.result);
                                                App.initICheck();
                                            }
                                        });
                                    }
                                    </script>
        
                            </div>
                        </div>
                        <!-- /.portlet-content -->
        
                    </div>
                    
                    <?php } else { ?>
                    
                        No groups exist.  Please create one first.
                    
                    <?php } ?>
                
                </div>
                <!-- /.tab-pane -->
                
                <?php foreach ((array) $this->event->getArgument('content') as $key => $content ) { ?>
                <div class="tab-pane" id="tab-<?php echo $key; ?>">
                    <?php echo $content; ?>
                </div>
                <?php } ?>
                
            </div>
            <!-- /.tab-content -->
        </div>
    </div>

</form>

</div>