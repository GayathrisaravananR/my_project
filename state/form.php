<script language="javascript" type="text/javascript" src="state/state.js"></script>
<?php 
		$state_name='';
		$state_code=''; 
    $active_status = 1;
		if($_GET['state_id'] !='')
		{

        $updateresult = state($_GET['state_id']);
			  $state_name =$updateresult[0]['state_name'];
			  $state_code=$updateresult[0]['state_code'];
        $active_status = $updateresult[0]['active_status'];
		}  
?> 

<div class="card-block">
        <form class="was-validated" method="post" id="state" name="state" autocomplete="off" novalidate>
        <div class="row">
         <div class="col-md-4">
              <div class="form-group">
				   <label for="state_name">State Name  <sup>*</sup></label>          
				   <div class="controls">
                   
                    <input type="text" name="state_name" id="state_name" class="form-control"  value="<?php echo $state_name ;?>" required autofocus="">
                    
					</div>
			  </div>
			  
            </div>
             <div class="col-md-4">
             	<div class="form-group">
				       <label for="state_code">State Code  <sup>*</sup></label>
				        <div class="controls">
					         <input type="number" name="state_code" id="state_code" class="form-control" value="<?php echo $state_code ;?>" required>
                      
				        </div>
			       </div>
             </div>
          
            <div class="col-md-4">
              <div class="form-group">
               <label for="active_status">Active Status  </label>
               <div class="controls">
                   <select name="active_status" id="active_status" class="form-control" required>
                      <option value="active" <?php if($active_status=="active"){ echo "selected"; } ?>>Active</option>
                      <option value="inactive" <?php if($active_status=="inactive"){ echo "selected"; } ?>>Inactive</option>
                   </select>
                  
              </div>
              </div>
        
            </div>
			
			
            </div>
         
          <?php if($updateresult==''){?>
		  <button type="button" class="float-right btn btn-success" onclick="state_cu('','Add')">Save</button>
          <?php }else{?>
          <button type="button" class="float-right btn btn-success" onclick="state_cu('<?php echo $updateresult[0]['state_id']?>','Update')">Update</button>
          <?php }?>
           <a href="index.php?file=state/list" class="float-left btn btn-primary">Cancel</a>
		   
          </form>
</div>

<script>
$('#input_starttime').pickatime({
// 12 or 24 hour
twelvehour: true,
});
</script>