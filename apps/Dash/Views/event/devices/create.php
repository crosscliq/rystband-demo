<?php // echo \Dsc\Debug::dump( $flash->get('old'), false ); ?>



<form id="detail-form" action="" class="form" method="post">
<div class="form-actions clearfix">
          <!-- /.form-actions -->
    <div class="row">
         <div class="col-md-9">
            <div class="form-group">
                <input type="text" name="device" placeholder="Device Name" value="<?php echo $flash->old('device'); ?>" class="form-control" />
                
            </div>
        </div>
         <div class="col-md-9">
            <div class="form-group">
                <input type="text" name="device_id" placeholder="device_id" value="<?php echo $flash->old('device_id'); ?>" class="form-control" />
                
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
            <select name="type">
                <option value="tv">TV</option>
                <option value="kiosk">Kiosk</option>
                <option value="phone">Phone</option>
            </select>
               
                
            </div>
        </div>
         <div class="col-md-9">
            <div class="form-group">

             <select name="action">
                <option value="game">Game</option>
                <option value="playlist">Playlist</option>
                <option value="something">Something Else</option>
            </select>
                       
            </div>
        </div>
        

       
    </div>

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
                    <a class="btn btn-default" href="./<?php echo $PARAMS['eventid'] ?>/devices">Cancel</a>
                </div>

            </div>
  </form>