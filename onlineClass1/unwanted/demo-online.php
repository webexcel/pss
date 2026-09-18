<?php
session_start();
$dbconnect = new  mysqli('localhost','root','webexcel@123','demosch'); 
if($dbconnect->connect_error){
	die('error'.$dbconnect->connect_error);
}

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
/*
.modal.in .modal-dialog {
  transform: none; //translate(0px, 0px);
}

.modal-backdrop {
    z-index: 1040 !important;
}
.modal-dialog {
    margin: 2px auto;
    z-index: 1100 !important;
}
.modal-backdrop {
    
    display: none;    // bug fix - no overlay 
}
*/
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
.modal-footer {
    padding-top: 6px !important;
    padding-bottom: 6px !important;
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
<link rel="stylesheet" href="dist/css/xeditable.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="dist/css/select2.min.css" />
<link rel="stylesheet" href="dist/css/chosen.min.css" />
<link rel="stylesheet" href="dist/css/bootstrap-datepicker3.min.css" />
<!-- page specific plugin styles -->
<!-- text fonts -->
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

<!--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.css">-->

<link rel="stylesheet" href="css/angularjs-datetime-picker.css" />

<!-- ace styles -->
<script src="dist/js/ace-extra.min.js"></script>
<link rel="stylesheet" href="css/jquery.Wload.css">
<script src="https://code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
<script src="js/jquery.Wload.js"></script>

<script type="text/javascript">	try{ace.settings.loadState('main-container')}catch(e){} </script>
<script type="text/javascript">	try{ace.settings.loadState('sidebar')}catch(e){} </script>




</head>
<body ng-controller="dbCtrl" class="no-skin">



	<!-- HEADER -->
	<?php include('navbar.php'); ?>  <!-- /.navbar-container --> 
	<!-- ./ HEADER -->	
	
	
	<div class="main-container ace-save-state" id="main-container"> 

		<!-- LEFT NAV -->
		<div id="sidebar" class="sidebar sidebar-fixed responsive ace-save-state"> 
			<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
					<button class="btn btn-success"> <i class="ace-icon fa fa-signal"></i> </button>
					<button class="btn btn-info"> <i class="ace-icon fa fa-pencil"></i> </button>
					<button class="btn btn-warning"> <i class="ace-icon fa fa-users"></i> </button>
					<button class="btn btn-danger"> <i class="ace-icon fa fa-cogs"></i> </button>
				</div>
				<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini"> <span class="btn btn-success"></span> <span class="btn btn-info"></span> <span class="btn btn-warning"></span> <span class="btn btn-danger"></span> </div>
			</div> <!-- /.sidebar-shortcuts -->
		

			<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse"> <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i> </div>
		</div>
		<!-- ./ LEFT NAV -->

		<div class="main-content">
			<div class="main-content-inner">
				<!--<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li> <i class="ace-icon fa fa-home home-icon"></i> <a href="#">Home</a> </li>
						<li class="active">Fees Management</li>
					</ul> <!-- /.breadcrumb -->
        
					<!--<div class="nav-search" id="nav-search">
						<form class="form-search">
							<span class="input-icon"><input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" /><i class="ace-icon fa fa-search nav-search-icon"></i> </span>
						</form>
					</div> <!-- /.nav-search --> 
				</div>
				<div class="page-content">
					<div class="page-header">
						<h1>ONLINE COLLECT FEES </h1>
					</div>
					<!-- /.page-header -->
					
					<div class="row">
						<div class="col-md-8" style="padding-top:17px;">							
							<div class="row">
								<form id="frm" name="frm" enctype="multipart/form-data">
								<!--<div class="col-md-12" ng-show="filteredItems > 0">-->
									<table class="table table-bordered">
										<tr bgcolor="#307ecc">
											<th  style="color:#FFFFFF;">SNO </th>
											<th  style="color:#FFFFFF;"> CLASS &nbsp;</th>
											<th  style="color:#FFFFFF;"> ADMISSION NO </th>
											<th  style="color:#FFFFFF;"> NAME &nbsp; <a ng-click="sort_by('addressLine1');"><i class="glyphicon glyphicon-sort"></i></a></th>
											<th  style="color:#FFFFFF;"> INITIAL&nbsp;</th>
											<th bgcolor="#307ecc" style="color:#FFFFFF;">CON</th>
											<th bgcolor="#307ecc" style="color:#FFFFFF;">TOT.CON</th>
										</tr>
									<tbody>
										
								<tr title="Click Here to SEE FEE DETAILS" ng-repeat="data in filtered = (list | filter:search | orderBy : predicate :reverse) | startFrom:(currentPage-1)*entryLimit | limitTo:entryLimit" ng-class="{'selected':$index == selectedRow}" ng-click="selStudent($index, data.ADMISSION_ID,$scope.bill,$scope.acdemicid)">
										
											<td ng-cloak>{{ $index + 1 }}</td>
											<td ng-cloak>{{ data.CLASS_SECTION }}</td>
											<td ng-cloak>{{ data.ADMISSION_ID }}</td>
											<td ng-cloak>{{ data.NAME }}</td>
											<td ng-cloak>{{ data.FATHER_NAME }}</td>
											<td ng-cloak><a href="javascript: void(0);" ng-click="addConcession( data.ADMISSION_ID, data.CLASS_ID ); $event.stopPropagation();">Conces</a>&nbsp; <span ng-show="data.CONCESSION_AMOUNT != null " style="color:#ff1493; font-size:14px; "> [ {{ data.CONCESSION_AMOUNT | currency:"" }} ] </span>&nbsp;</td>
											<td ng-cloak><a href="javascript: void(0);" ng-click="addConcession1( data.ADMISSION_ID, data.CLASS_ID ); $event.stopPropagation();">Conces</a>&nbsp; <span ng-show="data.CONCESSION_AMOUNT != null " style="color:#ff1493; font-size:14px; "> [ {{ data.CONCESSION_AMOUNT | currency:"" }} ] </span>&nbsp;</td>
											<!--<td ng-cloak>
												<div ng-show="{{data.res.Config_Value = 0}}">											
													<a href="javascript: void(0);" ng-click="addConcession( data.ADMISSION_ID, data.CLASS_ID ); $event.stopPropagation();">Conces</a>&nbsp; <span ng-show="data.CONCESSION_AMOUNT != null " style="color:#ff1493; font-size:14px; "> [ {{ data.CONCESSION_AMOUNT | currency:"" }} ] </span>&nbsp;
												</div>
											</td>	
											<td ng-cloak>
												<div ng-show="{{data.res.Config_Value = 0}}">	
													<a href="javascript: void(0);" ng-click="addConcession1( data.ADMISSION_ID, data.CLASS_ID ); $event.stopPropagation();">Conces</a>&nbsp; <span ng-show="data.CONCESSION_AMOUNT != null " style="color:#ff1493; font-size:14px; "> [ {{ data.CONCESSION_AMOUNT | currency:"" }} ] </span>&nbsp;
												</div>
											</td>-->
										</tr>
										<tr ng-show="filtered.length == 0">
											<td colspan="6" class="text-center">No results found.</td>
										</tr>
									</tbody>
									</table>
								<!--</div>-->
								<div style="text-align:right;" class="col-md-12" ng-show="filteredItems > 0">    
									<div pagination="" style="margin:0;" page="currentPage" on-select-page="setPage(page)" boundary-links="true" total-items="filteredItems" items-per-page="entryLimit" class="pagination-small" max-size= "5" previous-text="&laquo;" next-text="&raquo;"></div>
								</div>
								</form>
								</div>
								<br>
								<br>
					   
								<div class="row">
									<div class="col-md-12">
											<div class="table-header table-header profile-user-info width mb-5"><b>FEES DETATILS</b></div> 
											
												<div class="profile-user-info profile-user-info-striped" ng-show="selectedRow != null">
														<div class="row">  
														<div class="col-sm-12">
															<table class="table table-bordered">
																<thead>
																	<tr>
																		<th>ADNO</th>
																		<th>NAME</th>
																		<th>FATHER NAME</th>
																		<th>BILL TYPE</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td ng-cloak><b>{{ user.ADNO || '' }} </b></td>
																		<td ng-cloak><b>{{ user.NAME || '' }} </b></td>
																		<td ng-cloak><b>{{ user.FATHER_NAME || '' }}</b></td>
																		<!--<td ng-cloak><b>{{ user.SECTION || '' }}</b></td>-->
																		<td ng-cloak><b>
																		<select name="bill" id="bill" class="form-control selectpicker" ng-model="bill" ng-change="billtypechange()">
																			<option value="">Select</option>
																			<option ng-repeat="billtype in billtypes"  value="{{billtype.billBookId}}">{{billtype.BillBookName}}</option>																		  
																		</select>
																		
																		</b></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentmode"> Mode of Payment
																</label>
																<select class="form-control" name="payment_mode" id="payment_mode" ng-model="paymentMode.payment_mode" ng-options="pmode.id as pmode.name for pmode in paymentMode.values" ng-change="fnPaymentMode()"></select>
																
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentdate">Payment Date :</label>
																<input class="form-control" ng-model="user.payment_date" datetime-picker date-format="dd-MM-yyyy" date-only ng-readonly="true" />
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentremarks">Payment Remarks :</label>
																<input class="form-control" type="text" name="payment_remarks" id="payment_remarks" ng-model="user.payment_remarks" />
															</div>
														</div>
													</div>
													<div class="row" ng-show="payModeCheck">
														<div class="col-sm-4">
															
															<div class="form-group">
																<label for="paymentmode">Cheque No. :</label>
																<input class="form-control" type="text" name="chequeno" id="chequeno" ng-model="user.cheque_no" />
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentmode">Bank Name :</label>
																<input class="form-control" type="text" name="chequebank" id="chequebank" ng-model="user.cheque_bank" />
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentmode">Amount :</label>
																<input class="form-control" type="text" name="chequeamount" id="chequeamount" ng-model="user.cheque_amount" />
															</div>
														</div>
													</div>
													<div class="row" ng-show="payModeDD">
														<div class="col-sm-4">
															
															<div class="form-group">
																<label for="paymentmode">DD No. :</label>
																<input class="form-control" type="text" name="chequeno" id="chequeno" ng-model="user.cheque_no" />
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentmode">Bank Name :</label>
																<input class="form-control" type="text" name="chequebank" id="chequebank" ng-model="user.cheque_bank" />
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label for="paymentmode">Amount :</label>
																<input class="form-control" type="text" name="chequeamount" id="chequeamount" ng-model="user.cheque_amount" />
															</div>
														</div>
													</div>
													<table class="table table-bordered">
														<thead>
															<th>#</th>
															<th>FEE HEAD</th>
															<!--<th>FEE TYPE</th>
															<th>GroupID</th>-->
															<th class="text-right">TOTAL AMOUNT</th>
															<th class="text-right">CON.AMT</td>															
															<th class="text-right">TOTAL PAID</th>
															<th class="text-right">AS OF BAL</th>
															<th>
																
																<span class="pull-right"><input type="checkbox" ng-model="checkboxModel.value1" ng-click="fnGetReAmount()" min="1" ng-checked="false" /></span> 
															</th>
														</thead>
														<tbody>
															<tr ng-repeat="FDETAILS in FEE_DETAILS">
																<td ng-cloak>{{$index+1}} <span style="display:none;">{{FDETAILS.FSID}} {{FDETAILS.INSTALMENT}}</span></td>
																<td ng-cloak>{{FDETAILS.FEE_HEAD}}</td>
																<!--<td ng-cloak>{{FDETAILS.FEE_TYPE}}</td>
																<td ng-cloak>{{FDETAILS.FEE_GROUP}}</td>-->
																<td ng-cloak class="text-right">{{FDETAILS.TOTAL_FEE }}</td>
																<td ng-cloak class="text-right">{{FDETAILS.CONCESSION_AMOUNT | currency:"" }}</td>
																<td ng-cloak class="text-right">{{FDETAILS.PAID_FEE | currency:"" }}</td>
																<td ng-cloak class="text-right">{{ FDETAILS.AS_OF_AMOUNT  }} </td>
																<td ng-cloak class="text-center">
																	<div ng-show="{{FDETAILS.AS_OF_AMOUNT > 0}}">
																		 <input style="width:75px;" name="amount[]" id="amount{{$index}}" ng-model="FDETAILS.AS_OF_BALANCE" numbers-only  /> 
																	</div>
																</td>
															</tr>
															<tr>
																<td colspan="2" ng-cloak>&nbsp;</td>
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'TOTAL_FEE' | currency:"" }}</td>
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'CONCESSION_AMOUNT' | currency:"" }}</td>
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'PAID_FEE' | currency:"" }}</td>
																<td ng-cloak class="text-right">{{FEE_DETAILS | sumOfValue:'AS_OF_AMOUNT' }}</td>
																<td ><div style="font-size:12; font-weight:bold; color:#FF0000;">{{ amtTotal()  | currency:""  }} </div></td>
															</tr>
															<tr>
																<td colspan="6" ng-cloak class="text-right">Enter Amount Here : <div style="font-size:12;  color:#FF0000; display:none;" id="totpay"> TOTAL PAYABLE AMOUNT : Rs. {{ amtAfConTotal()  | currency:""  }}   <!--TOTAL PAYABLE AMOUNT : Rs. {{ user.payableAmount | currency:""  }}--> </div>
																<input style="width:75px;" type="text" name="totalam" id="totalam" ng-model="totalam" numbers-only  ng-keyup="calc(totalam)" /> 
																</td>
																<td class="text-center">
																	<button type="button" class="btn btn-xs btn-primary" ng-click="confirmPayFees(user, FEE_DETAILS)"><b> &nbsp;&nbsp;&nbsp; Pay &nbsp;&nbsp;&nbsp; </b></button>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<!--<div class="row" ng-show="filteredItems == 0">
													<div class="row">
														<h4>No customers found</h4>
													</div>
												</div>-->
											</div>
										</div>
							</div> 
						   `         
                
						<div class="col-md-4">
							
								<div class="table-header table-header profile-user-info width mb-5"><b>FEES PAID HISTORY - [ TOTAL : {{FEE_PAID_AMT}} ]</b></div>                
								<div class="profile-user-info1 profile-user-info-striped1 " ng-show="filteredItems > 0" >
														<!-- -->
									<div id="accordion" class="accordion-style1 panel-group">
										<div class="panel panel-default" ng-repeat="(key1, val1) in FEE_HISTORY">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a class="accordion-toggle collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}">
														<i class="bigger-110 ace-icon fa fa-angle-right" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
															{{ val1[0].DATE }} [Receipt ID: {{ key1 }}],Receipt No: {{ val1[0].RECPNO }}, Paid Amount:{{val1 | sumOfValue:'PAID_AMOUNT' | currency:""}}
													</a>
												</h4>													
											</div>

															<div class="panel-collapse collapse" id="collapse{{$index}}">
																<div class="panel-body">
																<div class="row">
																	<div >
																		<!--<a href="javascript:void(0);" role="button" ng-click="cancelReceipt(key1)" class="btn btn-xs btn-primary"><b>Cancel Receipt</b></a>-->
																			<button class="btn btn-minier btn-danger no-border" ng-click="cancelReceipt(key1)"><i class="fa fa-ban fa-fw fa-ban"></i>&nbsp;Cancel</button>
																			<a href='bills/{{user.U_PDF}}.php?r={{ key1 }}&adno={{user.ADNO}}&name={{user.NAME}}&fname={{user.FATHER_NAME}}&std={{user.STD}}&sec={{user.SEC}}' target='_blank' class="btn btn-minier btn-success no-border"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;Print</a>
																			<!--<div class="col-xs-6 align-right">
																				<button class="btn btn-minier btn-primary no-border" ng-click="editReceipt( user, val1 )"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</button>
																			</div>-->
																	</div>
																	<table class="table table-bordered">
																			<thead style="display:none;">
																				<th>FEE HEAD</th>
																				<th>FEE TYPE</th>
																				<th class="text-right">AMOUNT</th>
																				<!--<th>&nbsp;</th>-->
																			</thead>
																			<tbody>
																				<tr ng-repeat="vals in val1">
																					<td>{{$index+1}}</td>															
																					<td ng-cloak>{{ vals.FEE_HEAD }}</td>
																					<td ng-cloak>{{ vals.FEE_TYPE }}</td>
																					<td ng-cloak class="text-right">{{ vals.PAID_AMOUNT | currency:"" }}</td>
																					<!--<td ng-cloak class="text-center">
																						<button class="btn btn-minier btn-pink no-border" ng-click="confirmDeleteReceipt( vals )"><i class="fa fa-trash-o fa-fw"></i>&nbsp;Delete</button>
																					</td>-->
																				</tr>
																				<tr>
																					<td colspan="3" class="text-right"><b>TOTAL AMOUNT</b></td>
																					<td class="text-right">{{val1 | sumOfValue:'PAID_AMOUNT' | currency:""}}</td>
																					<!--<td>&nbsp;</td>-->
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														<!-- PANNEL THREE -->
														
														<!--	./ PANNEL THREE -->
														
										</div>
										<div class="row" ng-show="filteredItems == 0">
											<h4>No customers found</h4>
										</div>
									</div>
								</div>
							</div>	
								
					</div>
				
					<!-- scrool Up starts Here --> 
					<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i> </a>
					<!-- scrool Up ends Here --> 
					<div class="footer">
						<div class="footer-inner">
							<div class="footer-content"> <span class="bigger-120"> <span class="blue bolder">School Tree</span> &copy; 2016-2017 </span> &nbsp; &nbsp; <span class="action-buttons"> <a href="#"> <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i> </a> <a href="#"> <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i> </a> <a href="#"> <i class="ace-icon fa fa-rss-square orange bigger-150"></i> </a> </span> </div>
						</div>
					</div>
				</div> <!--	./	page-content -->
			</div><!-- ./main-content-inner -->
  		
 
  
  <!-- Modal -->  
<div class="modal fade" id="printViewModal" data-backdrop="false" background="false">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="smaller lighter blue no-margin">Pay Fees</h3>
			</div>
			<div class="modal-body">
				<object type="application/pdf" embedded=true data="{{url}}" width="100%" height="500" style="height: 85vh;">No Support</object>
			</div>
			<div class="modal-footer">
				&nbsp;&nbsp;&nbsp;
				<button class="btn btn-xs btn-default" data-dismiss="modal">
					<b>Close</b>
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myModal" role="dialog">
	<form name="form" id="form" method="post" enctype="multipart/form-data">
	<div class="modal-dialog"> 
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="smaller lighter blue no-margin">Pay Fees</h3>
			</div>
			<div class="modal-body">
				<h4>Your Total Payment is : {{ FEE_DETAILS.SUM_AMOUNT }}</h4>
			</div>
			<div class="modal-footer">
				<input class="no-border btn btn-xs btn-primary" name="proceed" type="button" value="Confirm" ng-disabled="payConfirmIsDisabled" ng-click="payFees(user, FEE_DETAILS);">
				&nbsp;&nbsp;&nbsp;
				<button class="no-border btn btn-xs btn-pink" data-dismiss="modal" ng-click="selStudent()">
					Close
				</button>
			</div>
		</div>
	</div>
	</form>
</div>

<div class="modal fade" id="myConfirmModal" role="dialog">
	<div class="modal-dialog"> 
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="smaller lighter blue no-margin">Are You sure to delete?</h3>
			</div>
			<div class="modal-body">
				<div class="modal-content">
					<br />
					<h4>&nbsp;&nbsp;Receipt Number : {{ RECP.FEE_REC_DET_ID }}</h4>
					<br />
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-xs btn-primary" name="proceed" type="button" value="Yes" ng-click="delFeeHistory( RECP );">
				<button class="btn btn-xs btn-pink" data-dismiss="modal">
					No
				</button>&nbsp;&nbsp;&nbsp;
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myConfirmModal1" role="dialog">
	<div class="modal-dialog"> 
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="smaller lighter blue no-margin">Are You sure to delete?</h3>
			</div>
			<div class="modal-body">
				<div class="modal-content">
					<br />
					<h4>&nbsp;&nbsp;Receipt Number : {{ RID }}</h4>
					<br />
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-xs btn-primary" name="proceed" type="button" value="Yes" ng-click="confirmCancelReceipt( RID );">
				<button class="btn btn-xs btn-pink" data-dismiss="modal">
					No
				</button>&nbsp;&nbsp;&nbsp;
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editModal" role="dialog">
	<div class="modal-dialog"> 
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn-minier" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 class="smaller lighter blue no-margin">Are You sure to delete?</h3>
			</div>
			<div class="modal-body">
				<div class="modal-content">
					<table class="table table-bordered">
						<thead>
							<th>#</th>
							<th>FEE HEAD</th>
							<th>FEE TYPE</th>
							<th>AMOUNT</th>
						</thead>
						<tbody>
							<tr ng-repeat="editFeeReceipt in eReceiptDetails">
								<td>{{$index+1}}</td>															
								<td ng-cloak>{{ editFeeReceipt.FeeTransHead }}</td>
								<td ng-cloak>{{ editFeeReceipt.FeeTransHeadType }}</td>
								<td ng-cloak>
									<!--{{ editFeeReceipt.PAID_AMOUNT | currency:"" }}-->
									<!--
									<input type="hidden" name="editrid" id="editrid{{$index}}" ng-model="editFeeReceipt.FEE_REC_DET_ID" />
									<input style="width:75px;" type="text" name="editamount[]" id="editamount{{$index}}" ng-model="editFeeReceipt.PAID_AMOUNT" numbers-only />
									-->
									<input type="hidden" name="editrid" id="editrid{{$index}}" ng-model="editFeeReceipt.FeeTransID"  />
									<input style="width:75px;" type="text" name="editamount[]" id="editamount{{$index}}" ng-model="editFeeReceipt.FeeTransAmount" numbers-only />
									
								</td>
							</tr>
							<tr>
								<td colspan="3" class="text-right"><b>TOTAL AMOUNT</b></td>
								<td>{{ amtTotal1() | currency:""  }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<input class="btn btn-xs btn-primary no-border" name="proceed" type="button" value="Update" ng-click="updateReceipt(eReceiptDetails);">
				<button class="btn btn-xs btn-default no-border" data-dismiss="modal">
					Cancel
				</button>&nbsp;&nbsp;&nbsp;
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalConcession" role="dialog">
	<div class="modal-dialog" role="document">
		<form class="form-horizontal" role="form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close font-20" ng-click="updateconcesstioninfo()" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 class="blue no-margin">Discount</h3>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">AD No.</label>
							<div class="col-sm-6">
								<label for="adno" class="bolder col-sm-3 control-label">{{ modalConcession.adno }}</label>
								<input ng-model="modalConcession.adno" type="hidden" id="oadno" name="oadno" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Fee Head</label>
							<div class="col-sm-6">
								<select name="newFees" id="newFees" ng-change="concesstion()" class="form-control" ng-model="modalConcession.feehead">
									<option value="">Fee Head</option>
									<option ng-repeat="fhead in modalConcession.feeheads" value="{{ fhead.feeheadId }}">{{ fhead.feehead }} - {{ fhead.Balance_Amount }}</option>
								</select>
							</div>
						</div>

						
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Discount Amount</label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.disAmount" type="number"  id="disAmount" name="disAmount" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Approved By</label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.approvedby" type="text" id="approvedby" name="approvedby" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Remarks </label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.remarks" type="text" id="remarks" name="remarks" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">&nbsp;</label>
							<div class="col-sm-6">
								<p style="color:#ff0088;">{{ modalConcession.status }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="no-border btn btn-xs btn-primary" ng-click="saveDiscount()">
						Save
					</button>
					&nbsp;&nbsp;&nbsp;
					<button class="no-border btn btn-xs btn-default" data-dismiss="modal" ng-click="updateconcesstioninfo()">
						Cancel
					</button>
				</div>
			</div><!-- /.modal-content -->
		</form>		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="totmodalConcession" role="dialog">
	<div class="modal-dialog" role="document">
		<form class="form-horizontal" role="form">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close font-20" ng-click="updateconcesstioninfo()" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 class="blue no-margin">Total Discount</h3>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">AD No.</label>
							<div class="col-sm-6">
								<label for="adno" class="bolder col-sm-3 control-label">{{ modalConcession.adno }}</label>
								<input ng-model="modalConcession.adno" type="hidden" id="oadno" name="oadno" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Fee Head</label>
							<div class="col-sm-6">
								<select name="newFees" id="newFees" ng-change="concesstion()" class="form-control" ng-model="modalConcession.feehead">
									<option value="">Fee Head</option>
									<option ng-repeat="fhead in modalConcession.feeheads" value="{{ fhead.feeheadId }}">{{ fhead.feehead }}-{{ fhead.Balance_Amount }}</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="amt" class="bolder col-sm-3 control-label align-right">Total Fees</label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.total" value ="{{modalConcession.total}}" type="text" id="total" name="total" class="form-control" disabled />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Discount Percentage</label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.disPer" type="text" id="disPer" name="disPer" ng-keyup="disconcesstion()" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Discount Amount</label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.disAmount" type="number"  id="disAmount" name="disAmount" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Approved By</label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.approvedby" type="text" id="approvedby" name="approvedby" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">Remarks </label>
							<div class="col-sm-6">
								<input ng-model="modalConcession.remarks" type="text" id="remarks" name="remarks" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<label for="adno" class="bolder col-sm-3 control-label align-right">&nbsp;</label>
							<div class="col-sm-6">
								<p style="color:#ff0088;">{{ modalConcession.status }}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="no-border btn btn-xs btn-primary" ng-click="saveDiscount()">
						Save
					</button>
					&nbsp;&nbsp;&nbsp;
					<button class="no-border btn btn-xs btn-default" data-dismiss="modal" ng-click="updateconcesstioninfo()">
						Cancel
					</button>
				</div>
			</div><!-- /.modal-content -->
		</form>		
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

				

  
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


<!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-aria.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-messages.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.0/angular-material.min.js"></script>
-->

<script>
	$(function(){
		$('body').Wload({text:' Loading'})
		$('body').Wload('hide',{time:1000})
	})
</script>
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
		
		
			////////////////////////////////////////////////
		
		$scope.checkboxModel = {
       		value1 : false
     	};
		$scope.checkboxModel1 = {
       		value1 : true
     	};
		
		
		$scope.getTotal = function(){
			var total = 0;
			for(var i = 0; i < $scope.FEE_DETAILS.length; i++){
				var product = $scope.FEE_DETAILS[i].amount;
				total += FEE_DETAILS.amount;
			}
			//console.log('GET TOTAL : ' + total);
			return total;
		}
		
		$scope.amtTotal1 = function() {			
			var total = 0;
			var amt	=	0;
			var qty	=	1;
			angular.forEach($scope.eReceiptDetails, function(editFeeReceipt) {
				if( parseInt(editFeeReceipt.FeeTransAmount) > 0 ) {
					total = parseInt(total) + parseInt(editFeeReceipt.FeeTransAmount) * parseInt(qty);
				}
				
			})
			//console.log('TOTAL : ' + total);
			return total;
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
			return total;
		}
		
		$scope.amtAfConTotal = function() {
			var total = 0;
			var amt	=	0;
			var qty	=	1;
			angular.forEach($scope.FEE_DETAILS, function(FDETAILS) {
				if( parseInt(FDETAILS.AS_OF_BALANCE) > 0 ) {
					total = parseInt(total) + parseInt(FDETAILS.AS_OF_BALANCE) * parseInt(qty);
				}
			})
			
			return total - $scope.concessionAmount;
		}
		
		$scope.concessionAmount = 0;
		$scope.billtypechange = function (){
			console.log("BILL CHANGE" + $scope.bill + $scope.SELADNO );
			$scope.selStudent($scope.selectedRow,$scope.SELADNO,$scope.bill);
			
		};
		$scope.selStudent = function(index,id,Billbookid=1,yearid,) {
			$scope.loading = true;
			$scope.selectedRow = index;
			$scope.SELADNO = id;
			$scope.academicname = yearid;
			//console.log("Bill Book new="+Billbookid);
			//console.log("New YearId"+yearid);
			$http({
				method  :	'POST',
				url     :	'ajax/selectData/selFeeDetailsNew1.php',
				data    :	{ adno : id , billBookId:Billbookid}, //forms user object
				cache	: 	false,
				headers :	{'Content-Type': 'application/x-www-form-urlencoded'} 
			 })
			.success(function(sdata){
				//console.log("Parent Alert............!");
				//console.log(sdata);
				
				var conamt	=	parseInt(sdata.CONCESSION_AMOUNT);
				$scope.concessionAmount	=	conamt;
				var payableamt	=	0;
				var tr = 0;
				
					
				if(typeof sdata.FEE_DETAILS.length !== 'undefined')
				{
					for( z=0; z<sdata.FEE_DETAILS.length; z++ ) {
						//tr	=	parseInt(sdata.FEE_DETAILS[z].REMAINING_FEE);
						//tr += tr
						tr = tr + parseInt(sdata.FEE_DETAILS[z].AS_OF_BALANCE);
					}
					var totrem	=	tr;
					if( conamt > 0 ) {
						payableamt = totrem-conamt;
					} else {
						payableamt = totrem;
					}					
					$scope.paymentMode = {};					
					$scope.paymentMode.payment_mode = "CASH";
					$scope.paymentMode.values = [{id: "CASH",name: "CASH"}, {id: "CHEQUE",name: "CHEQUE"}, {id: "DD", name: "DD"}, { id: "ONLINE",name: "ONLINE"}];												
					$scope.user = sdata;
					$scope.user.payment_date = sdata.CURR_DATE;
					$scope.user.payableAmount	=	payableamt;
					$scope.FEE_DETAILS = sdata.FEE_DETAILS;
					$scope.FEE_PAID_AMT = sdata.TOT_HISTORY;
					$scope.FEE_HISTORY = sdata.FEE_HISTORY;
					$scope.billtypes = sdata.billtypes;
					$scope.bill = Billbookid;
					$scope.fnGetReAmount();
					
				
				}
				else{
					$scope.user = "No DATA";
				}
				$scope.loading = false;
				
				
				
			})
			.error(function() {
				$scope.user = "error in fetching data";
			}); 
			$scope.changeAcademic();
		 };
		$scope.changeAcademic();
		
		
		$scope.opened = {};

		$scope.open = function($event, elementOpened) {
			$event.preventDefault();
			$event.stopPropagation();
			
			$scope.opened[elementOpened] = !$scope.opened[elementOpened];
		};
		
		//select Class and Section
		$scope.classes = [];
		//Standard

  
		$scope.$watch('user.CLASS_ID', function(newVal, oldVal) {
			if (newVal !== oldVal) {
				var selected = $filter('filter')($scope.classes, {id: $scope.user.CLASS_ID});
				$scope.user.classec = selected.length ? selected[0].text : null;
			}
		});
  
		$scope.groups = [];
		$scope.loadgroup = function() {
			return $scope.groups.length ? null : $http.get('ajax/selectData/selgroup.php').success(function(data) {
				$scope.groups = data;
			});
		};
   
   <!-- dropdown complete  -->
	$scope.loadclass();
	console.log($scope.tempclasses);

		$scope.fillTextbox=function(string){
			$scope.country=string;
			$scope.filterCountry=null;
		}
		
   
		$scope.$watch('user.grp', function(newVal, oldVal) {
			if (newVal !== oldVal) {
				var selected = $filter('filter')($scope.groups, {id: $scope.user.grp});
				$scope.user.grpp = selected.length ? selected[0].text : null;
			}
		}); 

		$scope.language = [];
		$scope.loadlang = function() {
			return $scope.language.length ? null : $http.get('ajax/selectData/sellang.php').success(function(data) {
				$scope.language = data;
			});
		};
   
		$scope.$watch('user.IILanguage', function(newVal, oldVal) {
			if (newVal !== oldVal) {
				var selected = $filter('filter')($scope.language, {id: $scope.user.IILanguage});
				$scope.user.langg = selected.length ? selected[0].text : null;
			}
		}); 

		$http.get('ajax/selectData/selectClassSection.php')
		.success(function(data){
			$scope.data = data;	
		})
		.error(function() {
			$scope.class = "error in fetching data";
		});
	
		$scope.fnAmount	=	function(remaingamount, curamount) {
			//console.log(curamount-remaingamount);			
		}
		
		$scope.confirmDeleteReceipt	=	function(rpid) {
			$scope.RECP = rpid;
			$("#myConfirmModal").modal('show');
		}
		
		$scope.cancelReceipt = function(rid) {
			$scope.RID = rid;
			$("#myConfirmModal1").modal('show');
		}
		
		$scope.confirmCancelReceipt = function(id) {
			var rpid = id;
			var ADNO = $scope.user.ADNO;
			
			var request = $http({
				method: "post",
				url: "ajax/deleteData/cancelFeeReceipt.php",
				data: { recpid : rpid },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				
				if(data.status=="success") {
					$("#myConfirmModal1").modal('hide')
					$scope.selStudent($scope.selectedRow, ADNO);
				}
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
		}
		
		$scope.fnPaymentMode = function () {

			if( $scope.paymentMode.payment_mode == "CHEQUE" ) {
				 $scope.payModeCheck = true;
				 $scope.payModeDD = false; 
			} else if( $scope.paymentMode.payment_mode == "DD" ) {
				$scope.payModeDD = true;  
				$scope.payModeCheck = false;
			} else {
				$scope.payModeCheck = false; 
				$scope.payModeDD = false;
			}

		}
		
		$scope.delFeeHistory = function(recpid) {
			var rpid = recpid.FEE_REC_DET_ID;
			var ADNO = $scope.user.ADNO;
			
			var request = $http({
				method: "post",
				url: "ajax/deleteData/delFeeReceipt.php",
				data: { recpid : rpid },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				
				if(data.status=="success") {
					$("#myConfirmModal").modal('hide')
					$scope.selStudent($scope.selectedRow, ADNO);
				}
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}
		
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
						var fasofbal =	FEE_DETAILS[i].AS_OF_BALANCE;
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
			//console.log(user);
			$scope.payConfirmIsDisabled = true;
			
			var stuFeeDetails	=	new Array();
			var stuFeeDetails1	=	new Array();			
			var fadno	=	user.ADNO;
			var fcid	=	user.CLASS_ID;
			var name	=	user.NAME;
			var classsec=	user.SECTION;
			var mobile	=	user.contact;
			var pmode	=	$scope.paymentMode.payment_mode;
			var pdate	=	user.payment_date;
			var premarks=	user.payment_remarks;
			var cheNo	=	user.cheque_no;
			var cheBank	=	user.cheque_bank;
			var cheBAmt	=	user.cheque_amount;
			var TotAmt	=	feeDetails.SUM_AMOUNT;
			//console.log("Tests",TotAmt);
			//stuFeeDetails1.push({"PAYMENT_MODE":pmode, "PAYMENT_DATE":pdate, "PAYMENT_REMARKS":premarks, "CHEQUE_NO":cheNo, "CHEQUE_BANK":cheBank, "CHEQUE_AMOUNT":cheBAmt, "ADNO":fadno, "CLASS_ID":fcid,"contact":mobile,"name":name,"classsec":classsec,"TotAmt":TotAmt});
			stuFeeDetails1.push({ "PAYMENT_MODE":pmode,"PAYMENT_DATE":pdate, "ADNO":fadno,"PAYMENT_REMARKS":premarks, "CHEQUE_NO":cheNo, "CHEQUE_BANK":cheBank, "CHEQUE_AMOUNT":cheBAmt, "CLASS_ID":fcid,"contact":mobile,"name":name,"classsec":classsec,"TotAmt":TotAmt});
			console.log("Tests",stuFeeDetails1);
			for(var i=0; i<feeDetails.length; i++) {
				var stuFeeDetail	=	new Array();
				var fsid	=	feeDetails[i].FSID;
				var fhid	=	feeDetails[i].FEE_HEAD_ID;
				var fhead	=	feeDetails[i].FEE_HEAD;
				var fgrid	=	feeDetails[i].FEE_GROUP;
				var ftype	=	feeDetails[i].FEE_TYPE;
				var ftotamt =	feeDetails[i].TOTAL_FEE;
				var fpaidamt =	feeDetails[i].PAID_FEE;
				var fasofbal =	feeDetails[i].AS_OF_BALANCE;
				var checkAmt =  parseFloat(fpaidamt) + parseFloat(fasofbal);
				var fprebal	=	feeDetails[i].PRE_BALANCE;
				var finterval=	feeDetails[i].INTERVAL;
				var finstal	=	feeDetails[i].INSTALMENT;
				var lastpaid=	feeDetails[i].LAST_PAID;
				console.log("Total : "+ftotamt);
				console.log("Paid : "+checkAmt);
				
				if( fasofbal != "undefined" && fasofbal != null && fasofbal > 0 && fasofbal != "" ) {
					//stuFeeDetails.push({"PAYMENT_MODE":pmode, "PAYMENT_DATE":pdate, "PAYMENT_REMARKS":premarks, "CHEQUE_NO":cheNo, "CHEQUE_BANK":cheBank, "CHEQUE_AMOUNT":cheBAmt, "ADNO":fadno, "CLASS_ID":fcid, "FHeadID":fhid, "FTypeID":ftid, "FAmount":famt});
					stuFeeDetails.push({"FSID" : fsid, "FgroupId":fgrid, "FHeadID":fhid,"FEE_HEAD":fhead, "FType":ftype, "FPreBalance":fprebal, "FAsofBalance" : fasofbal, "Finstalment" : finstal, "Finterval" : finterval, "lastpaid" : lastpaid});
					//stuFeeDetails.push({"FSID" : fsid, "FHeadID":fhid, "FType":ftype, "FPreBalance":fprebal, "FAsofBalance" : fasofbal, "Finstalment" : finstal, "Finterval" : finterval, "lastpaid" : lastpaid});
				}
				
			}
			
			var request = $http({
				
				method: "post",
				url: "ajax/insertData/insFeeReceiptNew1.php",
				data: {stuFeeDetails:stuFeeDetails, stuFeeDetails1:stuFeeDetails1,billbookid:$scope.bill},
				/*
				data: {
					FHeadID : data.FEE_HEAD_ID,
					FTypeID : data.FEE_TYPE_ID,
					ADNO : user.ADNO,
					CLASS_ID : user.CLASS_ID,
					AMOUNT : amount
					
				},*/
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				//console.log("sdfaafa"+data)
				if(data.success==1) {
					$("#myModal").modal('hide');					
					$scope.selStudent($scope.selectedRow, user.ADNO);
					
				}
			});
			request.error(function (data) {
				
				$scope.message = "From PHP file : "+data;
			});
		}
		
		//$scope.selStudent();
		
		$scope.fnGetReAmount = function() {
			var chval = $scope.checkboxModel.value1;
			if(chval === true){
				for(var i=0; i<$scope.FEE_DETAILS.length; i++) {
					$amt = $scope.FEE_DETAILS[i].AS_OF_AMOUNT;
					$scope.FEE_DETAILS[i].AS_OF_BALANCE = parseInt($amt);
					
				}
			} else {
				for(var i=0; i<$scope.FEE_DETAILS.length; i++) {
					$scope.FEE_DETAILS[i].AS_OF_BALANCE = '';
				}
			}
		}
		
		$scope.discount = function() {			
			var chval1 = $scope.checkboxModel1.value1;
			if(chval1 === true){
				for(var i=0; i<$scope.FEE_DETAILS.length; i++) {
					$amt = $scope.FEE_DETAILS[i].AS_OF_AMOUNT;
					$discount = (parseInt($amt)*5)/100;
					//$scope.FEE_DETAILS[i].AS_OF_BALANCE = parseInt($amt)-$discount;
					console.log("discount",$discount);
				}
			} else {
				for(var i=0; i<$scope.FEE_DETAILS.length; i++) {
					$scope.FEE_DETAILS[i].AS_OF_BALANCE = '';
				}
			}
		}
		
		$scope.calc = function(totalam) {
			var newtot	= 	0;
			var amt	= 	0;
			var totamt = totalam;
			
			for(var i=0; i<$scope.FEE_DETAILS.length; i++) {
				
				amt = parseInt($scope.FEE_DETAILS[i].AS_OF_AMOUNT);
				if(totamt >= amt){
				totamt = totamt - amt;
				//console.log("new", totamt);
				$scope.FEE_DETAILS[i].AS_OF_BALANCE = amt;
				
				}
				else{
					//console.log("new", totamt);
				$scope.FEE_DETAILS[i].AS_OF_BALANCE = totamt;
				totamt = 0;
				}
				
			}
			return totamt; 
		}
		
		
		$scope.showSection = function() {
			var request = $http({
				method: "post",
				url: "ajax/selectData/online-studentList.php",
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				
				//var data = [];
				if(data['status'] == false) {
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
				}
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}
	
		$scope.showSection();
		
		$scope.balValidation = function(val1, val2) {

			if( val2 == 0 ) {
				alert("Please enter valid amount");
				return false;
			}
			
			else{

				alert("Accept pay amount");
				return true;
			}
		};
		
		$scope.lastPaid = function(type, str) {
			var returnStr = "";
			if( type == 'Annual' ) {
				returnStr = str.replace(str, "");
			} else if( type == 'Term' ) {
				returnStr = str.replace("T", "Term ");
			} else if( type == 'Monthly' ) {
				returnStr = str.replace(str, str);			
			}
			
			return returnStr;
		}
	
		$scope.setPage = function(pageNo) {
			$scope.currentPage = pageNo;
		};
		$scope.filter = function() {
			$timeout(function() { 
				$scope.filteredItems = $scope.filtered.length;
			}, 10);
		};
		$scope.sort_by = function(predicate) {
			$scope.predicate = predicate;
			$scope.reverse = !$scope.reverse;
		};
		
		$scope.viewPdf = function(filename, r, adno, name, fname, std, sec) {
			var url	=	"bills/"+filename+"-view.php?r="+r+"&adno="+adno+"&name="+name+"&fname="+fname+"&std="+std+"&sec="+sec;
			alert(url);
			var request = $http({
				method: "get",
				url: url,
				//data: $scope.data.section,
				/*data: {
					section: $scope.section,
				},*/
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				//console.log("FILE NAME DEMO :  "+data+ " FILE NAME")
				$scope.url = data;
				$("#printViewModal").modal('show');
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});			
		};
		
		
		$scope.editReceipt = function(u, efv) {
			$scope.eReceiptDetails	=	[];
			$scope.eRADNO = u.ADNO;
				
			var editRepDetails	=	new Array();
			for(var z = 0; z < efv.length; z++ ) {
				var fee_trans_id	=	efv[z].FEE_REC_DET_ID;
				var fee_trans_amount=	efv[z].PAID_AMOUNT;
				var fee_trans_head	=	efv[z].FEE_HEAD;
				var fee_trans_type	=	efv[z].FEE_TYPE;
				
				editRepDetails.push({"FeeTransID":fee_trans_id, "FeeTransHead":fee_trans_head, "FeeTransHeadType":fee_trans_type, "FeeTransAmount":fee_trans_amount});
			}
			
			$scope.eReceiptDetails = editRepDetails;
			
			$("#editModal").modal('show');
		};
		
		$scope.updateReceipt = function(efv1) {
			var updateRepDetails	=	new Array();
			
			for(var z = 0; z < efv1.length; z++ ) {
				var fee_trans_id	=	 efv1[z].FeeTransID;
				var fee_trans_amount=	 efv1[z].FeeTransAmount;
				updateRepDetails.push({"FeeTransID":fee_trans_id, "FeeTransAmount":fee_trans_amount});
			}
			
			var request = $http({
				method: "post",
				url: "ajax/updateData/updFeeReceipt.php",
				data: {uRepceiptDetails:updateRepDetails},
				/*
				data: {
					FHeadID : data.FEE_HEAD_ID,
					FTypeID : data.FEE_TYPE_ID,
					ADNO : user.ADNO,
					CLASS_ID : user.CLASS_ID,
					AMOUNT : amount
					
				},*/
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (data) {
				$("#editModal").modal('hide');
				$scope.selStudent($scope.selectedRow, $scope.eRADNO);
				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}
		
		
		$scope.addConcession	=	function(adno, class_id) {			

			$http({
				method: 'POST',
				url: "ajax/selectData/getFeeGroupByClassId.php",
				data: {
					class_id: class_id, adno:adno
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				//console.log(response);
				//var resdata	=	response.data;
				$scope.modalConcession = {
					adno : adno,					
					feeheads : response.data
				};
				$scope.modalConcession.total = 0;
				$scope.modalConcession.feeheads.forEach(function(feehead){				
					$scope.modalConcession.total =  parseFloat(feehead.feeAmount) + parseFloat($scope.modalConcession.total);				
				});
				$("#modalConcession").modal("show");
			}, function errorCallback(response) {
				//var resdata	=	 response.data;
			});
			
		};
		
		
		$scope.addConcession1	=	function(adno, class_id) {			
			$http({
				method: 'POST',
				url: "ajax/selectData/getFeeGroupByClassId.php",
				data: {
					class_id: class_id, adno:adno
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				$scope.modalConcession = {
					adno : adno,					
					feeheads : response.data
				};
				$scope.modalConcession.total = 0;
				$scope.modalConcession.feeheads.forEach(function(feehead){				
				$scope.modalConcession.total =  parseFloat(feehead.Balance_Amount) + parseFloat($scope.modalConcession.total);
				
			});
				$("#totmodalConcession").modal("show");
			}, function errorCallback(response) {
			});
			
		};
		
		
		$scope.saveDiscount = function () {	
		//console.log($scope.modalConcession.total);
			if(!$scope.modalConcession.feehead)
			{
				$scope.modalConcession.status = "select Feehead";
				return 0;
			}
			else
			{
			//console.log($scope.modalConcession);
				$scope.modalConcession.status = '';
				$scope.fConcession = {
					adno : $scope.modalConcession.adno,
					feehead: $scope.modalConcession.feehead,
					disPer: $scope.modalConcession.disPer,
					disAmount: $scope.modalConcession.disAmount,
					approvedby: $scope.modalConcession.approvedby,
					remarks: $scope.modalConcession.remarks
				};

												
					$http({
						method: 'POST',
						url: "ajax/insertData/insFeeConcession.php",
						data: $scope.fConcession,
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
					}).then(function successCallback(response) {
					
						if( response.data.success == 1 ) {
							$scope.fConcession = {};
							$scope.modalConcession.disPer = "";
							$scope.modalConcession.disAmount = "";
							$scope.modalConcession.approvedby = "";
							$scope.modalConcession.remarks = "";
							$scope.modalConcession.status = "Discount saved failled. Please try again ";
						} else {
							$scope.fConcession = {};
							$scope.modalConcession.disPer = "";
							$scope.modalConcession.disAmount = "";
							$scope.modalConcession.approvedby = "";
							$scope.modalConcession.remarks = "";
							$scope.modalConcession.status = "Discount saved successfully ";
						}
						
					}, function errorCallback(response) {
						console.log(response);
					});
			}
										
		};

		$scope.disconcesstion = function () {	
			//console.log($scope.modalConcession.disPer);
			$scope.modalConcession.disAmount = parseFloat($scope.modalConcession.total) * parseFloat($scope.modalConcession.disPer) / 100;														
		};
		
		$scope.updateconcesstioninfo = function () {	
				$scope.selStudent(0,$scope.modalConcession.adno,1);									
		};
	
});	

</script>


</body>
</html>
