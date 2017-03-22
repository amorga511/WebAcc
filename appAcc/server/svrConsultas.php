
<?php

	$POST_DATA = file_get_contents("php://input");
	$vPost = json_decode($POST_DATA);

	switch ((int)$vPost->op) {
		case 1:
			consulta_ctas($vPost->codCta);
			break;
		case 2:
			consulta_pdas(0);
			break;			
		default:
			# code...
			break;
	}
function consulta_ctas($idCta){
	include 'dblink.php';

	$strSQL ="SELECT name FROM tbl_acc_accounts where status=1 and id=" . $idCta;

	if($res = $con->query($strSQL)){
		if((int)$res->num_rows>0){
			while($rows = $res->fetch_array()){
				echo '1,' . $rows[0];
			}
		}else{
			echo '0,No Data Found';
		}
		
	}else{
		echo '0,' . $con->error;
	}
}

function consulta_pdas($idPDA){
	include 'dblink.php';

	$tempArr = array();
	$strSQL ="SELECT * FROM tbl_acc_head_daily order by id desc";

	if($res = $con->query($strSQL)){
		if((int)$res->num_rows>0){
			while($rows = $res->fetch_assoc()){
				array_push($tempArr, array("num"=>$rows["id"], "fecha"=>$rows["date"], "monto"=>$rows["sum_debit"], "concept"=>$rows["concept"]));
			}
		}else{
			echo '0,No Data Found';
		}
		
	}else{
		echo '0,' . $con->error;
	}
	echo json_encode($tempArr);
}
?>










