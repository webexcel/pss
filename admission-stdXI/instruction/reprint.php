<?php 
session_start();
require_once('configi.php');

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

    

    <!-- BEGIN HEADER -->
    <div class="page-header">
        <!-- BEGIN HEADER TOP -->
        <div class="page-header-top2 header-height">
            <div class="container">
                <div class="row">

                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <div class="right-heading">
							 <span>PS Senior Secondary School</span>                         
                         </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <div class="right-heading">
							<span>ONLINE</span>
							<span>REGISTRATION</span>
							<span>PORTAL (2026 - 27)</span>                                                      
                       </div>
                    </div>
                </div><!-- END ROW -->
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
    </div>
    <!-- END HEADER -->


    <!-- BEGIN PAGE CONTAINER -->
    <div class="page-container" onclick="refreshSession()">
        <!-- BEGIN PAGE HEAD -->
       
        <!-- END PAGE HEAD -->
        <!-- BEGIN PAGE CONTENT -->
        <div class="page-content">
            <div class="container">
                <!-- BEGIN PAGE BREADCRUMB -->
                <ul class="page-breadcrumb breadcrumb">
                    

                </ul>
                <!-- END PAGE BREADCRUMB -->
                <!-- BEGIN PAGE CONTENT INNER -->
                

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
  
	<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="sticky-anchor"></div>

            <div id="dvHeader" class="portlet box green">
                <div class="tools">

                </div>
            </div>

            <div class="portlet box green">


            <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                <div class="form-horizontal form-row-sepe">
					<div class="form-body">


                            
					<form name="form"  method="post" id="contactform" action="bills/reprint.php" enctype="multipart/form-data">
                        <p class="form_status text-center" style="width: 100%; padding-top:10px;"></p>
							<div class="portlet blue box">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cogs"></i>STD-XI Admission Form Re-Print
                                     </div>
                                </div>
                            </div>
						
							<div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">                                                                                           
                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-6 col-sm-5 col-xs-12 text-right">
                                                Application No  <span class="required">* </span>
                                            </label>
											<div class="col-lg-7 col-md-6 col-sm-7 col-xs-12">
												<div class="input-icon right">
													<i class="fa"></i>
														<input type="text" id="fno" name="fno" class="form-control" placeholder="" value="" required/>
												</div>
											</div>
										</div>
                                     </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">                                                                                           
                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-6 col-sm-5 col-xs-12 text-right">
                                                Date of birth  <span class="required">* </span>
                                            </label>
											<div class="col-lg-7 col-md-6 col-sm-7 col-xs-12">
												<div class="input-icon right">
													<i class="fa"></i>
													<input type="date" class="form-control" type="text" id="dob" name="dob" date-format="dd-mm-yyyy" required/>												
												</div>
											</div>
										</div>
                                     </div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11  text-right">
                                    <input type="submit" id="submit" class="btn default" value="Re-Print"/>
                                           
                                </div>
                            </div>
					</form>
                            

                    </div>
                </div>
            </div>

            </div>

        </div>
    </div> 


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
    
	
<script type="text/javascript">	
	$(document).ready(function(){
		$("#submit").click(function(){			        
		    var phone = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
			
            var success = 1;
			if($("#fno").val() ==""){
                $(".form_status").html('Enter Form Number').css('color','red');				  
                success =0;
				$("#fno").focus();
                return false;
			}
			

			if($("#dob").val() ==""){
                $(".form_status").html('Enter the valid DOB').css('color','red');
                success =0;
				$("#dob").focus();
                return false;
				
            }

			if(success==1){
				$(".form_status").html("");
				$("#exampleModal1").modal('show');
				$("#contactform").submit();
			}
			else{
				$(".form_status").html('Please check your fields').css('color','red');
			}
			  
		});
	});	
	

</script>
	
	
	
	<script>
        var sessionInterval = "";
        jQuery(document).ready(function () {

            var themeStyle = 'rounded';
            var themeColor = 'grey';
            var Layouts = 'Fluid';
            var topMenu = 'dark';
            var MegaMenuStyle = 'dark';
            var topMenuMode = 'fixed';
            var MegaMenuMode = 'fixed';
            $("select[name=ddlThemeStyle]").val(themeStyle);
            $('.theme-colors li.active').removeClass('active');
            $('li[data-theme="' + themeColor + '"').addClass('active')

            if (Layouts == 'fluid') {
                $('.container').addClass('container-fluid').removeClass('container');
            }
            if (topMenu == 'light') {
                $(".top-menu li:visible").removeClass('dropdown-dark')
                $("select[name=ddlTopMenu]").val(topMenu);
            }

            if (MegaMenuStyle == 'light') {
                $(".hor-menu").addClass('hor-menu-light')
                $("select[name=ddlMegaMenuStyle]").val(MegaMenuStyle);
            }

            if (topMenuMode == 'fixed' && MegaMenuMode == 'fixed') {
                MegaMenuMode = 'not-fixed';
            }

            if (topMenuMode == 'fixed') {
                $('body').addClass('page-header-top-fixed');
                $("select[name=ddlTopMenuMode]").val(topMenuMode);
            }

            if (MegaMenuMode == 'fixed') {
                $('body').addClass('page-header-menu-fixed');
                $("select[name=ddlMegaMenuMode]").val(MegaMenuMode);
            }


            refreshSession();

          
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            Demo.init(); // init demo(theme settings page)
            QuickSidebar.init(); // init quick sidebar
            Index.init(); // init index page
            Tasks.initDashboardWidget(); // init tash dashboard widget

            //setThemeStyle('boxed');
            Demo.init();


        });


        function KeepSessionAlive() {
            var url = '' + 'ConfigurationSettings/keepSessionAlive';
            jQuery.get(url, null, function () {

            }, "json");
        };



        var interval;
        function refreshSession() {

            clearInterval(interval);
            clearInterval(sessionInterval);


            var sessionMilSec = 0;
            var lockTime = 0;
            var sessionTimeOut = 0;
            var appsessiontime = 0;

            sessionMilSec = '1500';
            appsessiontime = sessionMilSec;
            lockTime = '2000';


            var Lock = sessionMilSec - lockTime;
            //sessionMilSec = 1000; 

            interval = setInterval(function () {

                var defaultsessiontime = 1180;//1200 secs (20 mins) default session time
                var KeepSessioninterval = 0
                KeepSessioninterval = appsessiontime - defaultsessiontime;


                if (KeepSessioninterval > 0) {
                    sessionInterval = setInterval("KeepSessionAlive", 1180);
                }

                if (sessionMilSec < Lock) {

                    if (sessionMilSec < 1) {
                        clearInterval(interval);
                        clearInterval(sessionInterval);
                        window.location = '' + "Admission/Instruction";
                    }

                    else {

                        $('#spnSessionTimer').text('');
                        $('#spnSessionTimer').text(sessionMilSec--);

                        var min = Math.floor(sessionMilSec / (60), 2);
                        var sec = Math.floor((sessionMilSec - (min * 60)), 2);
                        $('#spnTimer').text(min + " : " + ('0' + sec).slice(-2));

                     

                    }
                }
                else {
                    //$('#spnSessionTimer').text(sessionMilSec-- + ' sec.');

                    sessionMilSec--;

                    $('#spnSessionTimer').text('');
                    $('#spnSessionTimer').text(sessionMilSec);


                    var min = Math.floor(sessionMilSec / (60), 2);
                    var sec = Math.floor((sessionMilSec - (min * 60)), 2);
                    $('#spnTimer').text(min + " : " + ('0' + sec).slice(-2));


                }
            }, 1000);
        };



    </script>
     
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
