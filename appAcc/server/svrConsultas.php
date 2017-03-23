
<?php

	$POST_DATA = file_get_contents("php://input");
	$vPost = json_decode($POST_DATA);

	switch ((int)$vPost->op) {
		case 1:
			consulta_ctas($vPost->codCta);
			break;
		case 2:
			consulta_pdas($vPost->fechIni, $vPost->fechFin);
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

function consulta_pdas($fini, $ffin){
	include 'dblink.php';

	$tempArr = array();
	$arrAcc = array();
	$arrHead = array();

	$arrFinal  = array();
	$numPDA = 0;

	$strSQL ="";
	$strSQL .="SELECT	a.id,";
	$strSQL .="		a.date,";
	$strSQL .="		a.sum_debit,";
	$strSQL .="		a.concept,";
	$strSQL .="		b.account_id,";
	$strSQL .="		c.name,";
    $strSQL .="     b.debit,";
    $strSQL .="     b.credit ";
	$strSQL .="FROM	tbl_acc_head_daily a";
    $strSQL .="        left join tbl_acc_det_daily b on (a.id=b.num_pda)";
    $strSQL .="        left join tbl_acc_accounts c on (b.account_id=c.id) ";
    $strSQL .="where a.date between '". substr($fini, 0,10) ."' and '" . substr($ffin,0,10) ."' ";
    $strSQL .="order by id desc, debit desc";
    //echo $strSQL;
	if($res = $con->query($strSQL)){
		if((int)$res->num_rows>0){
			while($rows = $res->fetch_assoc()){
				array_push($tempArr, array("num"=>$rows["id"], "fecha"=>$rows["date"], "monto"=>$rows["sum_debit"], "concept"=>$rows["concept"],
											"idCta"=>$rows["account_id"], "nameCta"=>$rows["name"],"debit"=>$rows["debit"],"credit"=>$rows["credit"]));
			}
		}else{
			echo '0,No Data Found';
		}
		
	}else{
		echo '0,' . $con->error;
	}

	for($i=0;$i<count($tempArr);$i++){
		if($i==0){
			$numPDA = $tempArr[$i]["num"];
			$arrHead = array("num"=>$tempArr[$i]["num"], "fecha"=>$tempArr[$i]["fecha"], "monto"=>$tempArr[$i]["monto"], "concept"=>$tempArr[$i]["concept"],"ctas"=>array());		
		}
		
		if($numPDA != $tempArr[$i]["num"]){
			for($j=0;$j<count($arrAcc);$j++){				
				array_push($arrHead["ctas"], $arrAcc[$j]);
			}
			array_push($arrFinal, $arrHead);

			$numPDA = $tempArr[$i]["num"];
			$arrHead = array("num"=>$tempArr[$i]["num"], "fecha"=>$tempArr[$i]["fecha"], "monto"=>$tempArr[$i]["monto"], "concept"=>$tempArr[$i]["concept"],"ctas"=>array());
			$arrAcc = array();
		}else{
			array_push($arrAcc, array("id"=>$tempArr[$i]["idCta"], "name"=>$tempArr[$i]["nameCta"],"debit"=>$tempArr[$i]["debit"],"credit"=>$tempArr[$i]["credit"]));	
		}
	}
	//print_r($arrFinal);
	echo json_encode($arrFinal);
}
?>










