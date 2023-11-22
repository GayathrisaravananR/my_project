<?php
session_start();

require_once('../inc/dbConnect.php');
require_once('../inc/commonfunction.php');


/************************************* INSERT ********************************************/
$action =$_POST['action'];
$user_id = $_SESSION['usercreation_id'];
$ip_address = get_client_ip();

switch ($action) {
	case 'Add':
		$select_state=$pdo_conn->prepare("SELECT COUNT(state_id) FROM tb_states WHERE delete_status !='1' AND state_name ='".$_POST['state_name']."' OR state_code='".$_POST['state_code']."' ");
    $select_state->execute();
    $state = $select_state->fetchAll();
	if($state[0]['COUNT(state_id)']==0)
	{
		$sql = "INSERT INTO tb_states (state_name,state_code,active_status,created_by,ip_address) VALUES (:state_name,:state_code,:active_status,:created_by,:ip_address)";
		$pdo_statement = $pdo_conn->prepare($sql);
			
		$result = $pdo_statement->execute(array(':state_name'=>$_POST['state_name'],':state_code'=>$_POST['state_code'],':active_status'=>$_POST['active_status'],':created_by'=>$user_id,':ip_address'=>$ip_address));
	if ($result == True){
	   $msg = "Successfully Created";
	}
	}
	else
	{
		$msg = "3";
	}
       echo json_encode(array('msg'=>$msg));

		break;
	case 'Update':
		$select_state=$pdo_conn->prepare("SELECT COUNT(state_id) FROM tb_states WHERE (state_name='".$_POST['state_name']."' OR state_code='".$_POST['state_code']."') AND state_id!='".$_POST['state_id']."' AND delete_status='0'");
    $select_state->execute();
    $state = $select_state->fetchAll();
	if($state[0]['COUNT(state_id)']==0)
	{
	   $pdo_statement=$pdo_conn->prepare("UPDATE tb_states SET state_name='".$_POST['state_name']."',state_code='".$_POST['state_code']."',active_status='".$_POST['active_status']."', modify_by='".$user_id."' WHERE state_id=".$_POST['state_id']);
	   $result = $pdo_statement->execute();
	   	if($result==True) {
		 $msg = "Sucessfully Updated";
	}
	}
	else
	{
		$msg = "3";
	}

          echo json_encode(array('msg'=>$msg));

		break;
		case 'Delete':
			
	$pdo_statement="UPDATE tb_states SET delete_status='1', modify_by='".$user_id."' WHERE  state_id=".$_POST['state_id'];
	$result=$pdo_conn->exec($pdo_statement);
	if($result==True) {
		 $msg = "delete";
	}

	echo json_encode(array('msg'=>$msg));

			break;
	default:
		# code...
		break;
}

