<a class="btn btn-success pull-right" href="./<?php echo $PARAMS['eventid']?>/role/create">New Role</a>

<br clear="both"><br>
<form id="searchForm" action="" method="post">

    <div class="row datatable-header">
        <div class="col-sm-6">
            <div class="row row-marginless">
                <?php if (!empty($list['subset'])) { ?>
                <div class="col-sm-4">
                    <?php echo $pagination->getLimitBox( $state->get('list.limit') ); ?>
                </div>
                <?php } ?>
                <?php if (!empty($list['count']) && $list['count'] > 1) { ?>
                <div class="col-sm-8">
                    <?php echo $pagination->serve(); ?>
                </div>
                <?php } ?>
            </div>
        </div>    
        <div class="col-sm-4 pull-right">
            <div class="input-group">
                <input class="form-control" type="text" name="filter[keyword]" placeholder="Keyword" maxlength="200" value="<?php echo $state->get('filter.keyword'); ?>"> 
                <span class="input-group-btn">
                    <input class="btn btn-primary" type="submit" onclick="this.form.submit();" value="Search" />

                </span>
            </div>
        </div>
    </div>
    
    <input type="hidden" name="list[order]" value="<?php echo $state->get('list.order'); ?>" />
    <input type="hidden" name="list[direction]" value="<?php echo $state->get('list.direction'); ?>" />
    
    <br/><br/>

    <div class="table-responsive datatable">
    
    <table class="table table-striped table-bordered table-hover table-highlight table-checkable">
		<thead>
			<tr>
		
				<th data-sortable="name">Name</th>
				<th>Type</th>
				<th>Group</th>
			     <th></th>
			</tr>
		</thead>
		<tbody>    
    
        <?php if (!empty($list['subset'])) { ?>
    
        <?php foreach ($list['subset'] as $item) { ?>
            <tr>
               
                            
                <td class="">
                    <h5>
                    <a href="./<?php echo $PARAMS['eventid'] ?>/role/edit/<?php echo $item->id; ?>">
                    <?php echo $item->{'name'}; ?>
                    </a>
                    </h5>
                    
                                       
                </td>
                
                <td class=""> <p class="help-block">
                    <?php echo $item->{'type'}; ?>
                    </p>
               
                </td>
                <td class=""> <p class="help-block">
                    <?php echo $item->{'group'}; ?>
                    </p>
               
                </td>
              
                                
                <td class="text-center">
                    <a class="btn btn-success btn-secondary" href="./<?php echo $PARAMS['eventid'] ?>/role/edit/<?php echo $item->id; ?>">
                        <i class="icon-edit"></i>
                    </a>
                    &nbsp;
                    <a class="btn  btn-danger" data-bootbox="confirm" href="./<?php echo $PARAMS['eventid'] ?>/role/delete/<?php echo $item->id; ?>">
                        <i class="icon-trash"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
        
        <?php } else { ?>
            <tr>
            <td colspan="100">
                <div class="">No items found.</div>
            </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
    
    </div>
    
    <div class="row datatable-footer">
        <?php if (!empty($list['count']) && $list['count'] > 1) { ?>
        <div class="col-sm-10">
            <?php echo (!empty($list['count']) && $list['count'] > 1) ? $pagination->serve() : null; ?>
        </div>
        <?php } ?>
        <div class="col-sm-2 pull-right">
            <div class="datatable-results-count pull-right">
            <?php echo $pagination ? $pagination->getResultsCounter() : null; ?>
            </div>
        </div>        
    </div>

</form>