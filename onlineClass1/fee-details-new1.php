<?php
//require_once('login/auth.php');
	error_reporting(0);
	$dt	=	date("d-m-Y");
session_start();
unset($_SESSION["payDetails"]);
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
						<h1>COACHING CLASS FEES COLLECTION</h1>
					</div>
					<!-- /.page-header -->
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-2">
							<label for="form-field-select-3">Please Select Your Ward Name</label>
								<select class="chosen-select form-control" name="section" id="section" ng-model="section" ng-change="GetAdno()" ng-cloak>
									<option value="">Select</option>
									<option ng-repeat="data in list" value="{{data.adno}}">{{data.name}}</option>
								</select>
							</div>
							<div class="col-md-9">
							</div>						
						</div>	
					</div>
					<div class="row" ng-show="user.ADNO != NULL">
						<div class="col-md-6" style="padding-top:17px;">
						
						<div class="row">
							<div class="col-md-6" style="padding-top:17px;">
								<form id="frm" name="frm" enctype="multipart/form-data">
								
									<table class="table table-bordered">
										<tbody>
										<tr><td  colspan="2" bgcolor="#307ecc"  style="color:#FFFFFF;"><b>Student Details</b></td></tr>
										<tr><td bgcolor="#307ecc"  style="color:#FFFFFF;">Name </td><td  style="color:#000;">{{ user.NAME }}</td></tr>
										<tr><td  bgcolor="#307ecc" style="color:#FFFFFF;">Admission No </td>
										<td  style="color:#000;">{{ user.ADNO }}</td></tr>
										<tr><td  bgcolor="#307ecc" style="color:#FFFFFF;">Class & section</td>
										<td  style="color:#000;">{{ user.SECTION }}</td></tr>
										<tr ng-show="filtered.length == 0">
											<td colspan="8" class="text-center">No results found.</td>
										</tr>
										</tbody>
									</table>
											
								</form>
							</div>
							<form id="myForm" name="myForm" method="post" enctype="multipart/form-data">
							<div class="col-md-6" style="padding-top:17px;">
									<table class="table table-bordered">
									<tr bgcolor="#307ecc" style="color:#fff;" >
									<td colspan="3">Fees Description</td>
										<td>Select Items </td>
									</tr>
									<tr><td colspan="3">Select Game</td>
										<td>
											<select ng-model="game" id="game" required class="form-control">
												<option value="">Select</option>
												<option value="ATHLETICS">ATHLETICS</option>
												<option value="BASKETBALL">BASKETBALL</option>
												<!--<option value="CHESS">CHESS</option>-->
												<option value="CRICKET">CRICKET</option>
											<!--	<option value="FOOTBALL">FOOTBALL</option>-->
											    <option value="TABLE TENNIS">TABLE TENNIS</option>
												
												
											</select>
										</td>
									</tr>
									<tr>
									
									<td colspan="3">Fees Amount</td>								
										<td>
											<span style="color:red">RS . 3500</span><!--Change Here amount -->
										</td>
									</tr>
									
									<tr>
									<td colspan="3"></td>								
										
										<td ng-show="user1.pay_id == null">
											<button type="submit" ng-click="payFees(user,game)" class="btn btn-xs btn-success">
												<b>Select to Pay</b>
											</button>
										</td>
									</tr>	
									</table>
							</div>
							</form>
							</div>
							</div>
					  
							<div class="col-md-6" style="padding-top:17px;" ng-show="user1.pay_id != null">
							<!--<div class="col-md-6" style="padding-top:17px;" ng-repeat="(key1, val1) in user2">	-->							
								<div class="table-header table-header profile-user-info width mb-5"><b>FEES PAID HISTORY</b></div>                
								
									<table class="table table-bordered">
									<thead>
										<th>Date</th>
										<th>Pay_Id</th>
										<th>Game</th>
										<th>Amount</th>
										<th>Print</th>
									</thead>
									<tr>
										<td>{{ user1.date }}</td>
										<td>{{ user1.pay_id }}</td>
										<td>{{ user1.game }}</td>
										<td>{{ user1.amount | currency:""}}</td>
										<td><a href='bills/pssenior.php?r={{user1.pay_id}}&adno={{user.ADNO}}&name={{user.NAME}}&game={{user1.game}}&date={{user1.date}}&classsec={{user.SECTION}}&yearid=4' target='_blank' class="btn btn-minier btn-success no-border"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a></td>
									</tr>
									<tr>
										<td colspan='2'>Total</td>
										<td ><b>{{FEE_PAID_AMT}}</b></td>
										<td></td>
									</tr>
									</table>
							</div>	
										
							
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
		
	
		$scope.payFees	=	function(user, game) {						
			console.log(user);
			console.log(game);
			if ($scope.myForm.$valid) {	
				var stuFeeDetails1	=	new Array();			
				var fadno		=	user.ADNO;
				var name		=	user.NAME;
				var classsec	=	user.SECTION;
				var mobile		=	user.contact;
				var gametype	=	game;

				stuFeeDetails1.push({  "ADNO":fadno,"contact":mobile,"name":name,"classsec":classsec,"gametype":gametype});
				console.log("Testsqqq",stuFeeDetails1);
				
				var request = $http({				
					method: "post",
					url: "ajax/insertData/insFeeReceiptNew2.php",
					data: {stuFeeDetails1:stuFeeDetails1},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				});
				request.success(function (data) {
					$scope.payConfirmIsDisabled = false;
					$window.location.href = 'pay.php';
					$scope.SessConfirmIsdisabled = true;
				});
				request.error(function (data) {
					
					$scope.message = "From PHP file : "+data;
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		}
		
		
		$scope.GetAdno = function() {
			$scope.adnoss =  $scope.section;			
			var request = $http({
				method: "post",
				url: "ajax/selectData/selFeeDetailsNew2.php",
				data: {
					adno : $scope.section					
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (data1) {
				$scope.user = data1;
				//$scope.user2 = data1.FEE_HISTORY;
				$scope.user1 = data1.TOT_HISTORY;
				console.log("welcome",$scope.user2);
				
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
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}
	
		$scope.showSection();

});	

</script>
</body>
</html>
