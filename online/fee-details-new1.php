<?php
//require_once('login/auth.php');
	error_reporting(0);
	$dt	=	date("d-m-Y");
session_start();
//unset($_SESSION["payDetails"]);
?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">
<head>
<style>
.selected {
	background-color:#307ecc !important;
	color:#FFFFFF;
	font-weight:bold;
}
table tr:hover {
	cursor:pointer;
}
ul li {
	cursor:pointer;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
	padding: 4px !important;
    vertical-align: middle !important;
}

.iframe-container {    
    padding-bottom: 60%;
    padding-top: 30px; height: 0; overflow: hidden;
}
 
.iframe-container iframe,
.iframe-container object,
.iframe-container embed{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

ul>li, a{cursor: pointer;}

.cur tbody tr {
	cursor:pointer
}
#simple-table1 tbody {
	cursor:default !important;
}
.page-header {
	padding-bottom: 6px;
}
.modal-header {
	padding:15px 10px 10px 15px !important
}
.font-20 {
	font-size:20px !important;
}
.panel-title {
      font-size: 13px;
}

label {
	font-weight:normal;
}
.col-centered {
    margin: 0 auto;
    float: none;
}
</style>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Fee Collection || Pay Fee</title>
<meta name="description" content="overview &amp; stats" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="css/style.css" />
<!-- bootstrap & fontawesome -->
<link rel="stylesheet" href="dist/css/bootstrap.min.css" />
<!-- ace styles -->
<link rel="stylesheet" href="dist/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
<link rel="stylesheet" href="css/angularjs-datetime-picker.css" />-->
<!-- ace styles -->
<script src="dist/js/ace-extra.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>-->
<script type="text/javascript">	try{ace.settings.loadState('main-container')}catch(e){} </script>
</head>
<body ng-controller="dbCtrl" class="no-skin">

	<!-- HEADER -->
	<?php include('navbar.php'); ?>  <!-- /.navbar-container --> 
	<!-- ./ HEADER -->	
	<div class="main-container ace-save-state" id="main-container"> 
		<div class="main-content">
			<div class="main-content-inner">
				</div>
				<div class="page-content">
					<div class="page-header">
						<h1>ONLINE FEES COLLECTION </h1>
					</div>
					<!-- /.page-header -->
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-2">
							<label for="form-field-select-3">Please Select Your Ward Name</label>
								<select class="chosen-select form-control" name="section" id="section" ng-model="section" ng-change="GetAdno()" ng-cloak>
									<option value="">Select</option>
									<option ng-repeat="data in list" value="{{data.ADMISSION_ID}}">{{data.NAME}}</option>
								</select>
							</div>
							<div class="col-md-9">
							</div>						</div>	
					</div>
					<div class="row">
						<div class="col-md-6" style="padding-top:17px;">
						
						<div class="row" ng-show="StudentList.ADMISSION_ID != NULL">
							<div class="col-md-6" style="padding-top:17px;">
								<form id="frm" name="frm" enctype="multipart/form-data">
								
									<table class="table table-bordered">
										<tbody>
										<tr><td  colspan="2" bgcolor="#307ecc"  style="color:#FFFFFF;"><b>Student Details</b></td></tr>
										<tr><td bgcolor="#307ecc"  style="color:#FFFFFF;">Name </td><td  style="color:#000;">{{ StudentList.NAME }}</td></tr>
										<tr><td  bgcolor="#307ecc" style="color:#FFFFFF;">Admission No </td><td  style="color:#000;">{{ StudentList.ADMISSION_ID }}</td></tr>
										<tr><td  bgcolor="#307ecc" style="color:#FFFFFF;">Class & section</td><td  style="color:#000;">{{ StudentList.CLASS_SECTION }}</td></tr>
										<tr ng-show="filtered.length == 0">
											<td colspan="8" class="text-center">No results found.</td>
										</tr>
									</tbody>
									</table>
											
								<!--</div>-->
								</form>
							</div>
						<div class="col-md-6" style="padding-top:17px;">
						<table class="table table-bordered">
								<tr bgcolor="#307ecc" style="color:#fff;" >
								<td colspan="3">Fees Description</td>
									<td>
									Select Items 
									</td>
								</tr>
								<tr ng-show="checkboxModel1.value1 != 3">
								
								<td colspan="3">INSTALMENT-1</td>
									<td>
										<span clss="center">
										<input type="checkbox" ng-change="chefun1(checkboxModel1.value1,checkboxModel2.value2)" ng-model="checkboxModel1.value1" ng-true-value="'1'" ng-false-value=" false" /></span> 
									</td>
								</tr>
								<tr ng-show="checkboxModel2.value2 != 4">
								
								<td colspan="3">INSTALMENT-2</td>								
									<td>
										<span class="center">
										<input type="checkbox" ng-change="chefun2(checkboxModel1.value1,checkboxModel2.value2)" ng-model="checkboxModel2.value2" ng-true-value="'2'" ng-false-value="false" /></span> 
									</td>
								</tr>
								
								<tr>
								<td colspan="3"></td>								
									<td>
										<button type="submit" ng-click="selStudent(StudentList.ADMISSION_ID,$scope.bill, checkboxModel1.value1,checkboxModel2.value2,checkboxModel3.value3,checkboxModel4.value4)" class="btn btn-xs btn-success"  >
											<b>Select to Pay</b>
										</button>
									</td>
								</tr>	
								</table>
								</div>
						
						</div>
						</div>
						<br>
						<br>
					   
								<div class="row" ng-show="StudentList.ADMISSION_ID != NULL">
									<div class="col-md-6">
											 
											
												<div class="profile-user-info profile-user-info-striped" >
												<div class="table-header table-header profile-user-info width mb-5"><b>FEES DETAILS</b></div>	
													<table class="table table-bordered">
														<thead>
															<th>#</th>
															<th>FEE HEAD</th>
															<!--<th>FEE TYPE</th>
															<th>GroupID</th>
															<th class="text-right">TOTAL AMOUNT</th>-->
															<th class="text-right">CON.AMT</td>
															<!--<th class="text-right">TOTAL PAID</th>-->
															<th class="text-right">AS OF BAL</th>
															
															
														</thead>
														<tbody>
															<tr ng-repeat="FDETAILS in FEE_DETAILS" ng-show="{{FDETAILS.AS_OF_AMOUNT != 0}}">
																<td ng-cloak>{{$index+1}}</td>
																<td ng-cloak>{{FDETAILS.FEE_HEAD}}</td>
																<!--<td ng-cloak class="text-right">{{FDETAILS.TOTAL_FEE }}</td>-->
																<td ng-cloak class="text-right">{{FDETAILS.CONCESSION_AMOUNT | currency:"" }}</td>
																<!--<td ng-cloak class="text-right">{{FDETAILS.PAID_FEE | currency:"" }}</td>-->
																<td ng-cloak class="text-right">{{FDETAILS.AS_OF_AMOUNT  }} </td>
																
																
																
															
															<tr>
																<td colspan="3" ng-cloak>&nbsp;</td>
																<!--<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'TOTAL_FEE' | currency:"" }}</td>
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'CONCESSION_AMOUNT' | currency:"" }}</td>
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'PAID_FEE' | currency:"" }}</td>-->
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'AS_OF_AMOUNT' }}</td>
															
															</tr>
																
													
															<tr>
															<td colspan="2"></td>
														<td ><div style="font-size:12; font-weight:bold; color:#FF0000;">{{user.payableAmount | currency:""  }} </div></td>

																<td >
																	<div ng-hide= "payableamt1 == false">
																	<input class="no-border btn btn-xs btn-danger" name="proceed" type="button" value="Click Here to Pay " ng-click="payFees(user, FEE_DETAILS);">
																	</div>
																</td>
															</tr>
														
														</tbody>
													</table>
												</div>
											</div>
										</div>
							</div> 
						<div class="col-md-5" ng-show="StudentList.ADMISSION_ID != NULL">
							
								<div class="table-header table-header profile-user-info width mb-5"><b>FEES PAID HISTORY</b></div>                
								
								<table class="table table-bordered">
								<thead>
									<th>Date</th>
									<th>RECEIPT_ID</th>
									<th>Amount</th>
									<th>Print</th>
								</thead>
								<tr ng-repeat="(key1, val1) in STU_FEE_HISTORY">
									<td>{{ val1[0].DATE }}</td>
									<td>{{ val1[0].PAY_ID }}</td>
									<td>{{val1 | sumOfValue:'PAID_AMOUNT' | currency:""}}</td>
									<td><a href='bills/pssenior.php?r={{val1[0].PAY_ID}}&adno={{user.ADNO}}&name={{user.NAME}}&fname={{user.FATHER_NAME}}&std={{user.STD}}&sec={{user.SEC}}&yearid={{val1[0].YEAR_ID}}' target='_blank' class="btn btn-minier btn-success no-border"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a></td>
								</tr>
								<tr>
									<td colspan='2'>Total</td>
									<td ><b>{{FEE_PAID_AMT}}</b></td>
									<td></td>
								</tr>
								</table>
							</div>	
								
					</div>
				
					<!-- scrool Up starts Here --> 
					<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i> </a>
					<!-- scrool Up ends Here --> 
					<div class="footer">
						<div class="footer-inner">
							<div class="footer-content"> <span class="bigger-120"> <span class="blue bolder">School Tree</span> &copy; 2020-2021 </span> &nbsp; &nbsp; <span class="action-buttons"> <a href="#"> <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i> </a> <a href="#"> <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i> </a> <a href="#"> <i class="ace-icon fa fa-rss-square orange bigger-150"></i> </a> </span> </div>
						</div>
					</div>
				</div> <!--	./	page-content -->
			</div><!-- ./main-content-inner -->
		</div><!-- /.main-content -->
	</div><!-- /.main-container -->

<!-- basic scripts --> 

<!--[if !IE]> 
<script src="dist/js/jquery-2.1.4.min.js"></script>-->
<!-- <![endif]--> 
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='dist/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script> 
<!--<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
<script src="dist/js/bootstrap-3.3.6.min.js"></script> 
<script src="dist/js/jquery.ui.touch-punch.min.js"></script>
<script src="dist/js/chosen.jquery.min.js"></script>
<script src="dist/js/date-time/bootstrap-datepicker.min.js"></script> 
<script src="dist/js/bootstrap-tag.min.js"></script> 

<script src="dist/js/angular.min.js"></script> 

<script src="dist/js/xeditable-0.1.12.min.js"></script>

<script src="dist/js/ui-bootstrap-tpls-0.10.0.min.js"></script>
<!--<script src="dist/js/ui-bootstrap-tpls-0.14.3.js"></script>-->
<script src="dist/js/angular-animate-1.5.5.min.js"></script>
<script src="dist/js/angular-aria-1.4.8.min.js"></script>
<script src="dist/js/angular-messages-1.4.8.min.js"></script>

<!-- ace scripts --> 
<script src="dist/js/ace.min.js"></script>
<script src="dist/js/ace-elements.min.js"></script>
<!-- inline scripts related to this page --> 

<script src="js/angularjs-datetime-picker.js"></script>
<!--[if !IE]> -->


<script type="text/javascript">


//var fetch = angular.module('myApp', ["xeditable", "ui.bootstrap", "angularjs-datetime-picker", 'ngMaterial','ngMessages']);
var fetch = angular.module('myApp', ["xeditable", "ui.bootstrap", "angularjs-datetime-picker"]);
	
	fetch.directive('loading', function () {
	  return {
		restrict: 'E',
		replace:true,
		template: '<div class="loading"><img src="images/ajax-loader.gif" width="20" height="20" />LOADING...</div>',
		link: function (scope, element, attr) {
			  scope.$watch('loading', function (val) {
				  if (val)
					  $(element).show();
				  else
					  $(element).hide();
			  });
		}
	  }
	})
	fetch.directive('numbersOnly', function () {
		return {
			require: 'ngModel',
			link: function (scope, element, attr, ngModelCtrl) {
				function fromUser(text) {
					if (text) {
						var transformedInput = text.replace(/[^0-9]/g, '');

						if (transformedInput !== text) {
							ngModelCtrl.$setViewValue(transformedInput);
							ngModelCtrl.$render();
						}
						return transformedInput;
					}
					return undefined;
				}            
				ngModelCtrl.$parsers.push(fromUser);
			}
		};
	});
	
	fetch.run(function(editableOptions) {
		editableOptions.theme = 'bs3';
	});

	fetch.filter('startFrom', function() {
		return function(input, start) {
			if(input) {
				start = +start; //parse to int
				return input.slice(start);
			}
			return [];
		}
	});
	
	fetch.filter('sumOfValue', function () {
		return function (data, key) {        
			if (angular.isUndefined(data) || angular.isUndefined(key))
				return 0;        
			var sum = 0;        
			angular.forEach(data,function(value){
				sum = sum + parseInt(value[key]);
			});        
			return sum;
		}
	});
	
	fetch.filter('total', function() {
		return function(data, key) {
			if (typeof(data) === 'undefined' || typeof(key) === 'undefined') {
				return 0;
			}

			var sum = 0;
			for (var i = data.length - 1; i >= 0; i--) {
				sum += parseInt(data[i][key]);
			}

			return sum;
		};
	});


	fetch.controller('dbCtrl', function($window,$location,$scope,$filter, $http, $timeout, $modal) {
        $scope.active = true;
        $scope.active1 = true;
		$scope.SUBTOTAL = 0;
		$scope.user = {};
		$scope.bill ='1' ;
		$scope.eRADNO	=	"";
		$scope.setClickedRow = function(index){
		$scope.selectedRow = index;
		}
		
		///////////////////////////////////////////
		$scope.SessConfirmIsdisabled = false;
		////////////////////////////////////////////////
		$scope.checkboxModel1 = {
       		value1 : false
     	};
		$scope.checkboxModel2 = {
       		value2 : false
     	};

	
		$scope.chefun1 = function(chkbox1,chkbox2,chkbox3,chkbox4){
			if(chkbox1 === false && chkbox2 !== false ){
				//alert("Pleas");
				$scope.checkboxModel2.value2 = false
				
			}
		}
		$scope.chefun2 = function(chkbox1,chkbox2){
			console.log("term1",chkbox1);
			console.log("term2",chkbox2);
			if(chkbox1 === false && chkbox2 !== false || chkbox2 === false ){
				alert("You cannot do that !! ");
				$scope.checkboxModel2.value2 = false
				
			}
			
		}

		
		$scope.checktrue = function(){
			if($scope.STU_FEE_DETAILS[0].INTERVAL == 1 && $scope.STU_FEE_DETAILS[0].AS_OF_AMOUNT == 0){
			$scope.checkboxModel1.value1 = 3;
			console.log("term1",$scope.checkboxModel1.value1);
			}
			if($scope.STU_FEE_DETAILS[1].INTERVAL == 2 && $scope.STU_FEE_DETAILS[1].AS_OF_AMOUNT == 0){
				$scope.checkboxModel2.value2 = 4;
				console.log("term2",$scope.checkboxModel2.value2);
			}
		}
		
		
		////////////////////////////////////////
		$scope.selStudent = function(id,Billbookid=1,chkbox1,chkbox2) {

			console.log("term1",chkbox1);
			console.log("term2",chkbox2);
			
			if(chkbox1 === false && chkbox2 === false){
				alert("Please Select fee details");
			}
			
			var chkid = new Array();
			
				chkid.push({"chkbox1":chkbox1,"chkbox2":chkbox2});
			
			$scope.loading = true;
			$scope.SELADNO = id;

			$http({
				method  :	'POST',
				url     :	'ajax/selectData/selFeeDetailsNew1.php',
				data    :	{ adno : id , billBookId:Billbookid, chkid:chkid}, //forms user object
				cache	: 	false,
				headers :	{'Content-Type': 'application/x-www-form-urlencoded'} 
			 })
			.success(function(sdata){
				var conamt	=	parseInt(sdata.CONCESSION_AMOUNT);
				$scope.concessionAmount	=	conamt;
				var payableamt	=	0;
				var tr = 0;
				
				if(typeof sdata.FEE_DETAILS.length !== 'undefined')
				{
					for( z=0; z<sdata.FEE_DETAILS.length; z++ ) {
					tr = tr + parseInt(sdata.FEE_DETAILS[z].AS_OF_AMOUNT);
				}
				var totrem	=	tr;
				console.log("Tot11",totrem);
					if( conamt > 0 ) {
						payableamt = totrem-conamt;
					} else {
						payableamt = totrem;
					}

					var payableamt1 = 0;
					if(payableamt > 0 ){
					
						$scope.payableamt1 = true;
						
					}
					else{
						$scope.payableamt1 = false;
					}
					
					$scope.paymentMode = {};					
					$scope.paymentMode.payment_mode = "CASH";
					$scope.paymentMode.values = [{id: "CASH",name: "CASH"}, {id: "CHEQUE",name: "CHEQUE"}, {id: "DD", name: "DD"}, { id: "ONLINE",name: "ONLINE"}];												
					$scope.user = sdata;
					$scope.user.payment_date = sdata.CURR_DATE;
					$scope.user.payableAmount	=	payableamt;
					$scope.FEE_DETAILS = sdata.FEE_DETAILS;
					//console.log("FEE DETAILS-NEW",$scope.FEE_DETAILS);
					$scope.FEE_DETAILSddd = $scope.FEE_DETAILS[0].AS_OF_AMOUNT;
					console.log("FEE DETAILS-NEW",$scope.FEE_DETAILSddd);
					$scope.FEE_TOTAL = totrem;
					$scope.FEE_TOTAL1 = sdata.TOT;
					$scope.FEE_PAID_AMT = sdata.TOT_HISTORY;
					$scope.FEE_HISTORY = sdata.FEE_HISTORY;
					$scope.billtypes = sdata.billtypes;
					$scope.bill = Billbookid;
					//$scope.options[$index] = true;
					console.log("Tot",$scope.options[$index]);
				}
				else{
					$scope.user = "No DATA";
				}
				$scope.loading = false;
			})
			.error(function() {
			$scope.user = "error in fetching data";
			}); 
		 };
		 
		
		//select Class and Section
		$scope.confirmPayFees = function(user, FEE_DETAILS) {			
				if($scope.amtTotal() <=0 )
				{
					alert("Enter Valid Amountsss");
				}
				else
				{
					var flag =true;
					for(var i=0; i<FEE_DETAILS.length; i++) 
					{
						var ftotamt  =	FEE_DETAILS[i].TOTAL_FEE;
						var cons     =  FEE_DETAILS[i].CONCESSION_AMOUNT;
						var fpaidamt =	FEE_DETAILS[i].PAID_FEE;										
						var fasofbal =	FEE_DETAILS[i].AS_OF_AMOUNT;
						var totpaid  =  parseFloat(cons) +  parseFloat(fpaidamt)
						var checkAmt =  parseFloat(totpaid) + parseFloat(fasofbal);
						console.log("Total : "+ftotamt);
						console.log("Paid : "+checkAmt);
							if(isNaN(checkAmt))
							{
								checkAmt =0;
							}						
								if( ftotamt >= checkAmt && flag )
								{
								flag =true;
								}
								else
								{
									flag = false;
									alert("Enter Valid Amount");									
									break;
								}	
					}
					if(flag)
					{
						$scope.user = user;
						$scope.FEE_DETAILS = FEE_DETAILS;
						$scope.FEE_DETAILS.AMOUNT_AF_CONCESSION = $scope.amtAfConTotal();
						$scope.FEE_DETAILS.AMOUNT_CONCESSION = $scope.concessionAmount;
							if($scope.SUBTOTAL > 0 ) {
								$scope.FEE_DETAILS.SUM_AMOUNT = $scope.SUBTOTAL;
							}
							else {
								$scope.FEE_DETAILS.SUM_AMOUNT = $scope.amtTotal();
							}
						$scope.payConfirmIsDisabled = false;
						$("#myModal").modal('show');
					}
				}
		}
		$scope.payConfirmIsDisabled = true;
		
		$scope.payFees	=	function(user, feeDetails) {						
			console.log(user);
			console.log(feeDetails);
			var stuFeeDetails	=	new Array();
			var stuFeeDetails1	=	new Array();			
			var fadno	=	user.ADNO;
			var fcid	=	user.CLASS_ID;
			var name	=	user.NAME;
			var classsec=	user.SECTION;
			var mobile	=	user.contact;
			var Year_Id	=	user.Year_Id;
			var instal	=	user.instalment;
			var TotAmt	=	$scope.FEE_TOTAL;
			console.log("Tests",TotAmt);

			//stuFeeDetails1.push({"PAYMENT_MODE":pmode, "PAYMENT_DATE":pdate, "PAYMENT_REMARKS":premarks, "CHEQUE_NO":cheNo, "CHEQUE_BANK":cheBank, "CHEQUE_AMOUNT":cheBAmt, "ADNO":fadno, "CLASS_ID":fcid,"contact":mobile,"name":name,"classsec":classsec,"TotAmt":TotAmt});
			stuFeeDetails1.push({  "ADNO":fadno,"CLASS_ID":fcid,"contact":mobile,"name":name,"classsec":classsec,"TotAmt":TotAmt,"instal":instal,"Year_Id":Year_Id});
			console.log("Testsqqq",stuFeeDetails1);
			for(var i=0; i<feeDetails.length; i++) {
				console.log("chkj : ", feeDetails[i].AS_OF_AMOUNT);
				var stuFeeDetail	=	new Array();
				var fsid	=	feeDetails[i].FSID;
				var fhid	=	feeDetails[i].FEE_HEAD_ID;
				var fhead	=	feeDetails[i].FEE_HEAD;
				var fgrid	=	feeDetails[i].FEE_GROUP;
				var ftype	=	feeDetails[i].FEE_TYPE;
				var ftotamt =	feeDetails[i].TOTAL_FEE;
				var fpaidamt =	feeDetails[i].PAID_FEE;
				var fasofbal =	feeDetails[i].AS_OF_AMOUNT;
				var checkAmt =  parseFloat(fpaidamt) + parseFloat(fasofbal);
				var fprebal	=	feeDetails[i].PRE_BALANCE;
				var finterval =	feeDetails[i].INTERVAL;
				var faccount =	feeDetails[i].ACCOUNT;
				var finstal	=	feeDetails[i].INSTALMENT;
				var lastpaid=	feeDetails[i].LAST_PAID;
				console.log("Total : "+ftotamt);
				console.log("Paid : "+checkAmt);
				
				if( fasofbal != "undefined" && fasofbal != null && fasofbal > 0 && fasofbal != "" ) {					
					stuFeeDetails.push({"FSID" : fsid, "FgroupId":fgrid, "FHeadID":fhid,"FEE_HEAD":fhead, "FType":ftype, "FPreBalance":fprebal, "FAsofBalance" : fasofbal, "Finstalment" : finstal, "Finterval" : finterval,"FAccount" : faccount, "lastpaid" : lastpaid});					
				
				}
				
			}
			
			var request = $http({				
				method: "post",
				url: "ajax/insertData/insFeeReceiptNew2.php",
				data: {stuFeeDetails:stuFeeDetails, stuFeeDetails1:stuFeeDetails1,billbookid:$scope.bill},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (data) {
				$scope.payConfirmIsDisabled = false;
				console.log("sdf",data);
				$window.location.href = 'pay.php';
				$scope.SessConfirmIsdisabled = true;
			});
			request.error(function (data) {
				
				$scope.message = "From PHP file : "+data;
			});
		}
		
		//$scope.selStudent();
		
		$scope.GetAdno = function() {
			$scope.adnoss =  $scope.section;			
			var myArray = $scope.list;
			var StudentList1 = myArray.filter(function(item) {
			  return item.ADMISSION_ID === $scope.adnoss;
			})[0];
			console.log(StudentList1);
			$scope.StudentList = StudentList1;

			var request = $http({
				method: "post",
				url: "ajax/selectData/selFeeDetailsNew2.php",
				data: {
					adno : $scope.section					
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (data1) {
				$scope.StufeeDetails = data1;
				$scope.STU_FEE_DETAILS = $scope.StufeeDetails.FEE_DETAILS;
				$scope.STU_FEE_HISTORY = $scope.StufeeDetails.FEE_HISTORY;
				$scope.user = data1;
				/*if($scope.STU_FEE_DETAILS.INTERVAL == 0 && $scope.STU_FEE_DETAILS.AS_OF_AMOUNT == 0){					
					$scope.intervals = true;					
				}
				else{
					$scope.intervals = false;
				}*/
				
				$scope.checktrue();
				console.log($scope.STU_FEE_DETAILS);	
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});		
		};	
		//$scope.GetAdno();
		
		$scope.showSection = function() {
			var request = $http({
				method: "post",
				url: "ajax/selectData/studentListWithConcession.php",
				data: {
					section: $scope.section,
					year: $scope.year,
					
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				$scope.list = data;
				//var data = [];
				/*if(data['status'] == false) {
					$scope.list = '';
					$scope.currentPage = 1; //current page
					$scope.entryLimit = 5; //max no of items to display in a page
					$scope.filteredItems = $scope.list.length; //Initially for no filter  
					$scope.totalItems = $scope.list.length;
				} else {
					$scope.list = data;
					$scope.currentPage = 1; //current page
					$scope.entryLimit = 5; //max no of items to display in a page
					$scope.filteredItems = $scope.list.length; //Initially for no filter  
					$scope.totalItems = $scope.list.length;
					console.log(data)
				}*/
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}
	
		$scope.showSection();
		
		
		
		$scope.fnGetReAmount = function() {
			var chval = $scope.checkboxModel.value2;
			console.log("test",chval);
			if(chval === true){
				console.log("testttt");
				
				
			}			
		}
		
		$scope.amtTotal = function() {			
			var total = 0;
			var amt	=	0;
			var qty	=	1;
			angular.forEach($scope.FEE_DETAILS, function(FDETAILS) {
				if( parseInt(FDETAILS.AS_OF_BALANCE) > 0 ) {
			total = parseInt(total) + parseInt(FDETAILS.AS_OF_BALANCE) * parseInt(qty);
				}
			})
			var payableamt1 = 0;
					if(total > 0 ){
						$scope.payableamt1 = true;
					}
					else
					{
						$scope.payableamt1 = false;
					}
			return total;
		}
		/////////////////////////
		$scope.viewPdf = function(filename, r, adno, name, fname, std, sec) {
			var url	=	"bills/"+filename+"-view.php?r="+r+"&adno="+adno+"&name="+name+"&fname="+fname+"&std="+std+"&sec="+sec;
			alert(url);
			var request = $http({
				method: "get",
				url: url,
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (data) {
				$scope.url = data;
				$("#printViewModal").modal('show');
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});			
		};
});	

</script>
</body>
</html>
