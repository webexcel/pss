<?php 

session_start();
require_once('configi.php');
if(@$_SESSION['curapplicationid']){
	$applicationid=$_SESSION['curapplicationid'];
	$_SESSION['curapplicationid']="";
}else{
	$applicationid="";
}

$result = mysqli_query($dbconnect,"SELECT * FROM `application_prekg` WHERE id =".$_GET['id']);
$row 	= mysqli_fetch_assoc($result);
$id     = $row['id'];
$fno    = $row['fno'];
$name   = $row['name'];
$dob1	= $row['dob'];
$dob    = date("d-m-Y", strtotime($dob1));
$apply  = $row['applied'];
$mobile = $row['contact'];


?>
<!DOCTYPE html>


<style>
   .page-footer
    {
    padding:1px 0 !important;

    }

</style>


<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>


    <meta charset="utf-8">
    <title>Admission</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="" name="description">
    <meta content="" name="author">
    <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css">
    <!-- <link href="assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css">
    END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css"/>
    <link href="assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
    <!-- BEGIN PAGE LEVEL STYLES -->

    <link href="css/common.css"rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/select2/select2.css"/>
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css"/>
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css">
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" />



    <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" />

    <link href="assets/admin/pages/css/lock.css"rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-toastr/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
      <link rel="stylesheet" type="text/css" href="css/RegistrationLayout.css"/>

    <!-- END PAGE LEVEL STYLES -->
    <link href="css/custom.css" rel="stylesheet" />
    <link href="assets/global/plugins/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet"/>
    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
    
    

    <link href="assets/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="assets/global/css/plugins-md.css" rel="stylesheet" type="text/css"/>



    <link href="assets/admin/layout3/css/layout.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/layout3/css/themes/grey.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="assets/admin/layout3/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END THEME STYLES -->
    <style>
        .btnHeight {
            height: 40px;
        }
    </style>
    <link rel="shortcut icon" href="favicon.ico">
    
      
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-menu-fixed" class to set the mega menu fixed  -->
<!-- DOC: Apply "page-header-top-fixed" class to set the top menu fixed  -->
<body>
    <!-- DELETE MODAL -->
    <!-- Selected id for deletionL -->
    <input type="hidden" id="selectedid" />

    <div id="staticdelete" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-header">
            
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
            <p id="description">
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default" id="clearselectedid">No</button>
            <button type="button" id="confirmed" data-dismiss="modal" class="btn blue">Yes</button>
        </div>
    </div>


    <!-- BEGIN PAGE CONTAINER -->
    <div class="page-container" onclick="refreshSession()">
        <!-- BEGIN PAGE HEAD -->
       
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMB -->
               

<style type="text/css">
    /*gender color*/
    .btn-default:active, .btn-default.active {
        background-color: #2E9AFE;
        background-image: none;
    }

    .required.fNeme {
        float: right;
        margin-top: -25px;
    }

    .studPho {
        border: 1px solid #eff2f7;
        height: 175px;
        width: 135px;
    }

    .tblItem {
        width: 100%;
    }

    .form-group.tblItem {
        margin-left: 0;
    }


    .form-control.IsSameAddr {
        margin-top: -10px;
    }

    .radio-inline {
        margin-left: 35px;
    }


    .form-control {
        border-radius: 5px !important;
    }

    .form-wizard .steps > li > a.step > .desc {
        display: inline-block;
        font-size: 15px!important;
        font-weight: 300;
    }

    .form-wizard .steps > li > a.step > .number {
        background-color: #eee;
        border-radius: 50% !important;
        display: inline-block;
        font-size: 16px;
        font-weight: 300;
        height: 20px !important;
        margin-right: 10px;
        padding: 0 3px !important;
        text-align: center !important;
        width: 20px !important;
    }
</style>


<script type="text/javascript">
    var onloadCallback = function () {
        grecaptcha.render('html_element', {
            'sitekey': '6Le8xxUTAAAAALNPau3S5zjVstJDvw48Eysng59G'
        });
    };
    var correctCaptcha = function (response) {
        alert(response);
    };
</script>
<style>
table, th, td {
  border: 1px solid black;
  padding:5px;
}


@media print {
    #printbtn {
        display :  none;
    }
}

</style>

<form action="" enctype="multipart/form-data" id="frmRegistration" method="post" novalidate="novalidate">    
	<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="sticky-anchor"></div>
				<h2 class="regheading" style="text-align: center;">P.S.Senior Secondary School</h2>
				<h4 class="block heading text-success" style="text-align: center;"><strong>ONLINE APPLICATION (2026-2027)</strong></h4>
            

            <div class="portlet box green">


            <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                <div class="form-horizontal form-row-sepe">
					<div class="form-body">


                            
					<div class="row">													
						<div class="col-md-10 register-right">							
							<div class="row">
								<div class="col-md-3">
								</div>
								<div class="col-md-9" style="padding-top:40px;">
								<!--<h4>Application For VI Standard</h4>-->
								<br>
									<table>
									  <tbody>
										<tr>
										  <td style="width:50%; font-size:24px;">Acknowledgement No</td>
										  <td style="width:50%; font-size:24px;">&nbsp<?php echo $row['id']; ?></td>
										</tr>
										<tr>
										  <td style="width:50%; font-size:24px;">Application No</td>
										  <td style="width:50%; font-size:24px;">&nbsp<?php echo $row['fno']; ?></td>
										</tr>
										<tr>
										  <td style="width:50%; font-size:24px;">Student Name</td>
										  <td style="width:50%; font-size:24px;">&nbsp<?php echo $row['name']; ?></td>
										</tr>
										<tr>
										  <td style="width:50%; font-size:24px;">Applied For</td>
										  <td style="width:50%; font-size:24px;">&nbsp<?php echo $row['applied']; ?></td>
										</tr>
									  </tbody> 
									</table>
									<br>
									<a id="printbtn" class="btn btn-primary" href="bills/pss.php?r=<?php echo $id; ?>">Print</a>
									<a href="../index.html" class="btn btn-primary"> Back </a>
									<br>
									<p style="font-size:20px;"><b>Note:</b> This Form is necessary during the time of Admission </p>
								</div>
							</div>	
						</div>	
					</div>
			
		
						<!----- modelbox----->   
						<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<form action="" method="post">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Application No</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Successfully Created Your Application</p>
											<p>Application No : <span class="applicationdynid"></span></p>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-success" style="width:20%">Ok</button>						
										</div>
									</div>
								</form>
							</div>
						</div>

                       

                            

                    </div>
                </div>
            </div>

            </div>

        </div>
    </div> 
</form>

           <!-- END PAGE CONTENT INNER -->
            </div>

            <!-- BEGIN QUICK SIDEBAR -->
            <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-login"></i></a>
            <div class="page-quick-sidebar-wrapper">
                <div class="page-quick-sidebar">
                    <div class="nav-justified">
                        
                        <div class="tab-content">
                           
                        </div>
                    </div>
                </div>
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
    <!-- BEGIN PRE-FOOTER -->
   
    <!-- END PRE-FOOTER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
		<div class="page-footer">      
			<div class="container">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="page-footer-inner">
						2025 &copy; webexcel Technologies
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" align="right">
					<span class="Footercenter" id="spnSessionTimer"></span>
				</div>
			</div>
		</div>
    </div>

    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>

    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
<script src="~/assets/global/plugins/respond.min.js"></script>
<script src="~/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
    <script src="assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>

      <script src="assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript" ></script>
    <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" ></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
    <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
    <!--<script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>-->
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="Scripts/common.js"></script>
    <script type="text/javascript" src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
    <script type="text/javascript" src="assets/global/plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
    <script type="text/javascript" src="assets/global/plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="assets/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js"></script>
    <script type="text/javascript" src="assets/global/plugins/bootstrap-markdown/lib/markdown.js"></script>
    <script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="assets/global/scripts/metronic.js" type="text/javascript"></script>
    <script src="assets/admin/layout3/scripts/layout.js" type="text/javascript"></script>
    <script src="assets/admin/layout2/scripts/quick-sidebar.js" type="text/javascript"></script>
    <script src="assets/admin/layout3/scripts/demo.js" type="text/javascript"></script>
    <script src="assets/admin/pages/scripts/index3.js" type="text/javascript"></script>
    <script src="assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
    <script src="assets/admin/pages/scripts/form-validation.js" type="text/javascript"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
    <script src="assets/global/plugins/jcrop/js/jquery.Jcrop.min.js"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <script src="assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
    <script src="assets/admin/pages/scripts/ui-toastr.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

     
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
