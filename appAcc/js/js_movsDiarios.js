

function decode(){
    var texto = document.getElementById('txt1').value;
    alert('decoding..' + hex2a(texto));
}

function hex2a(hexx) {
    var hex = hexx.toString();//force conversion
    var str = '';
    for (var i = 0; i < hex.length; i += 2)
        str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    return str;
}
var appM = angular.module('appMain', []);

appM.controller('appControl1', function($scope,$http) {
    $scope.cMovs = true;
    $scope.cConsPDA = false;
    $scope.vArr_cuentas = [];

    $scope.switchMenu = function(vM){
        switch(vM){
            case 1:                
                window.location.href = "../../main.html";
            break;
            case 2:
            break;
            case 99:
                $scope.dvInicio = false;
                $scope.dvStaff = false;
                $scope.dvPersonalOp = true;
            break;
            default:
                return;
        }
        if(vM!=99){
            $("#wrapper").toggleClass("toggled");
        }
    }

    $scope.f_switchTab = function(vTab){
    	switch(vTab){
    		case 1:
    			$scope.cMovs = true;
    			$scope.cConsPDA = false;
    		break;
    		case 2:
    			$scope.cMovs = false;
    			$scope.cConsPDA = true;
    		break;
    	}
    	clearRegs();
    }

    $scope.f_buscar = function(){
    	$http.post("../../server/svrConsultas.php", {op:2}).then(function(rData){
    		//alert(rData.data);
    		$scope.arr_registros = rData.data;
		});
    }

    $scope.f_clearRegs = function(){
    	clearRegs();
    }

    $scope.f_removeCta = function(vevent){
        removeCta(event.target.id);
    }

    $scope.f_savePDA = function(){
    	var valDebe = 0;
    	var valHaber = 0;
    	var vJS_PDA = {};
    	if($scope.vArr_cuentas.length>1){
    		for(i=0; i<$scope.vArr_cuentas.length; i++){
	            valDebe += parseFloat($scope.vArr_cuentas[i].debe);
	            valHaber += parseFloat($scope.vArr_cuentas[i].haber);
	        }
	        if(valDebe.toFixed(2) == valHaber.toFixed(2)){
	        	if($scope.vComment.length>8){
	        		vJS_PDA = {"date":$scope.vDate,"sumDebit":valDebe, "sumCredit":valHaber, "concept":$scope.vComment, "user":"NA"};

	        		$http.post("../../server/svrTransacciones.php", {op:1, jsn_pda:vJS_PDA, arrCtas:$scope.vArr_cuentas}).then(function(rData){
		    			var temStr = "";
		    			temStr = rData.data.split(',');
		    			if(temStr[0]==1){
		    				alert('Registro Ingresado Exitosamente..');
		    				clearRegs();
		    			}else{
		    				alert(rData.data);
		    			}
		    		});

	        	}else{
	        		alert("Debe ingresar un comentario..");
	        	}
	        }else{
	        	alert("Valores de partida desiguales..");
	        }
    	}else{
    		alert("Cuentas insuficientes para crear registro..");
    	}
    }

    $scope.f_addctas = function(){
    	var vDebe = 0;
    	var vHaber = 0;
    	var vFlag = 0;

    	if($scope.vCod_cta.length>0 && $scope.vCta.length>0 && parseFloat($scope.vMonto)>0){
    		for(i=0; i<$scope.vArr_cuentas.length; i++){
	            if($scope.vArr_cuentas[i].cod == $scope.vCod_cta){
	                alert('Cuenta Existente..');
	                vFlag =1;
	                break;
	            }
	        }
	        if(vFlag == 0){
    			if(parseInt($scope.vType) == 0){
    				vDebe = $scope.vMonto;
    				vHaber = 0;
    			}else{
    				vDebe = 0;
    				vHaber = $scope.vMonto;
    			}
        		$scope.vArr_cuentas.push({"cod":$scope.vCod_cta, "cta_name":$scope.vCta, "debe":vDebe.toFixed(2), "haber":vHaber.toFixed(2)});
        		clearCta();
        	}
    	}
    }

    $scope.f_showModal = function(){
    	showModal();
    }

    $scope.pressEvent = function(vEvent){
    	$scope.vCta = "";
    	if(vEvent.keyCode == 13){
    		$http.post("../../server/svrConsultas.php", {op:1, codCta:$scope.vCod_cta}).then(function(rData){
    			var resStr = rData.data.split(',');
    			if(parseInt(resStr[0])==1){
    				$scope.vCta = resStr[1];
    			}else{
    				alert(resStr[1]);
    			}
    		});
    	}
    }

    function showModal(){
    	$("#myModal").modal("show");
    }

    function removeCta(vIdCta){
        var vArrTemp = [];
        for(i=0; i<$scope.vArr_cuentas.length; i++){
            if($scope.vArr_cuentas[i].cod != vIdCta){
                vArrTemp.push({"cod":$scope.vArr_cuentas[i].cod, 
                    "cta_name":$scope.vArr_cuentas[i].cta_name, 
                    "debe":$scope.vArr_cuentas[i].debe, 
                    "haber":$scope.vArr_cuentas[i].haber});
            }
        }
        $scope.vArr_cuentas = vArrTemp;

    }

    function clearRegs(){
    	$scope.vDate = new Date;
    	$scope.vArr_cuentas = [];
    	$scope.vComment = "";    	
    	clearCta();
    }

    function clearCta(){
    	$scope.vCod_cta = "";
    	$scope.vType = "0";
    	$scope.vCta = "";
    	$scope.vMonto = 0;
    }

    clearRegs();
});

function getParams(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;    
    }
    return vars;
}

$("#btn_menu").click(function(e) {
     e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
$("#btn_close_menu").click(function(){
    $("#wrapper").toggleClass("toggled");
 });

$(document).ready(function(){
	//alert('Document Ready');
});
