<?php

$user_id = $_SESSION['usercreation_id'];
	 $page_add = get_roll_action_permission('state_master', 'add', $user_id);
	 $page_edit = get_roll_action_permission('state_master', 'edit', $user_id);
     $page_delete = get_roll_action_permission('state_master', 'delete', $user_id);
 ?>
<script language="javascript" type="text/javascript" src="state/state.js"></script>
<div class="page-header card">
<div class="row align-items-end">
<div class="col-lg-8">
<div class="page-header-title">
<div class="d-inline">
<h5>Manage <?php echo ucfirst($foldername); ?></h5>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class=" breadcrumb breadcrumb-title">
<li class="breadcrumb-item">
<a href="index.php"><i class="icon-home"></i></a>
</li>
<li class="breadcrumb-item">
	<?php if($page_add == '1')
	{ ?> 
<a href="index.php?file=state/create">Add New</a>
<?php } ?>
</li>
</ul>
</div>
</div>
</div>
</div> 


    <!-- Main content -->
         <section class="content">
      <div class="row">
        <div class="col-12">
         
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
				<div class="table-responsive">               
				  <table id="state" class="table table-bordered table-hover table-striped display nowrap margin-top-10 w-p100 datatable_without_options" width="100%">
					<thead>
						<tr>
							<th width="5%" class="text-center">#</th>
							<th width="35%">State Name</th>
							<th width="35%">State Code</th>
							<th width="20%">Status</th>							
                            <th width="5%">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 

						$state_details = state();
						$start =1;
						foreach($state_details as $value){
							$state_id = $value['state_id'];
							$state_name = $value['state_name'];
							$state_code = $value['state_code'];
							$active_status = $value['active_status'];
							
							global $pdo_conn;
                        
                          $sql = "SELECT * FROM tb_cities WHERE state_name='$state_id' and delete_status!='1' ORDER BY city_id DESC";
                          $prepare = $pdo_conn->prepare($sql);
                          $exc = $prepare->execute();
                          $state_count = $prepare->rowCount();
                          
                           $sql1 = "SELECT * FROM tb_customers WHERE state_name='$state_id' and delete_status!='1'";
                          $prepare1 = $pdo_conn->prepare($sql1);
                          $exc1 = $prepare1->execute();
                          $state_customer_count = $prepare1->rowCount();
                          
                          $sql2 = "SELECT * FROM tb_dealers WHERE state_name='$state_id' and delete_status!='1'";
                          $prepare2 = $pdo_conn->prepare($sql2);
                          $exc2 = $prepare2->execute();
                          $state_dealer_count = $prepare2->rowCount();
                          
                          $sql3 = "SELECT * FROM tb_vendors WHERE state_name='$state_id' and delete_status!='1'";
                          $prepare3 = $pdo_conn->prepare($sql3);
                          $exc3 = $prepare3->execute();
                          $state_vendor_count = $prepare3->rowCount();
						?>
						<tr>
							<td align="center"><?php echo $start; ?></td>
							<td><?php echo $state_name; ?></td>
							<td><?php echo $state_code; ?></td>
							<td><?php echo ucfirst($active_status); ?></td>
							<td align="left">
								<?php if($page_edit == '1')
	{ ?> 
						  <a href="index.php?file=state/update&state_id=<?php echo $state_id;?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<?php } ?>
						  	<?php if($page_delete == '1' && $state_count == '0' && $state_customer_count == '0' && $state_dealer_count == '0' && $state_vendor_count == '0')
	{ ?> 
                          <a href="#" onclick="del(<?php echo $state_id;?>)" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                      <?php } ?>
							</td>
						<?php 
						$start++;
					} ?>
						</tr>
						
					</tbody>				  
					
				</table>
				</div>              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
	<!-- /.content -->
