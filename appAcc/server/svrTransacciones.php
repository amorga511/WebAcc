
<?php

	$POST_DATA = file_get_contents("php://input");
	$vPost = json_decode($POST_DATA);

	switch ((int)$vPost->op) {
		case 1:
			insert_pda($vPost->jsn_pda, $vPost->arrCtas);
			break;		
		default:
			# code...
			break;
	}
function insert_pda($obPDA, $ctas){
	include 'dblink.php';
	$numPDA = 0;

	$strSQL = "select num from tbl_correlativos where status=1";
	if($res = $con->query($strSQL)){
		while($rRes = $res->fetch_array()){
			$numPDA = (int)$rRes[0] + 1;
		}
	}

	$strSQL = "insert into tbl_acc_head_daily(id, date,sum_debit,sum_credit,concept,status,acc_period,user_create)";
	$strSQL .=" values(". $numPDA .",'". $obPDA->date ."',". $obPDA->sumDebit .",".$obPDA->sumCredit .",'". $obPDA->concept ."',1,'NA','". $obPDA->user ."')";

	if($con->query($strSQL)){
		for($i=0;$i<count($ctas);$i++){
			$strSQL = "insert into tbl_acc_det_daily(id, num_pda, account_id, debit, credit, status)";
			$strSQL .=" values(0,". $numPDA .",". $ctas[$i]->cod .",".$ctas[$i]->debe .",". $ctas[$i]->haber .",1)";

			$con->query($strSQL);
		}
		echo '1,Success';		
	}else{
		echo '0,' . $con->error;
	}
}
?>










