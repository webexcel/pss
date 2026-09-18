<?php
/*
	$file_name1 = rand(1111,9999).time().$_FILES['file_name']['name'];
	$filenewpath1 = 'cropimg/'.$file_name1;
	move_uploaded_file($_FILES['file_name']['tmp_name'], $filenewpath1);
	
	$file_name2 = rand(1111,9999).time().$_FILES['file_name1']['name'];
	$filenewpath2 = 'cropimg/'.$file_name2;
	move_uploaded_file($_FILES['file_name1']['tmp_name'], $filenewpath2);
	
	$file_name3 = rand(1111,9999).time().$_FILES['file_name2']['name'];
	$filenewpath3 = 'cropimg/'.$file_name3;
	move_uploaded_file($_FILES['file_name2']['tmp_name'], $filenewpath3);*/
	
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
	
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
	
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
.test1{
	border:5px solid #005faf;
}
.test2{
	border:1px solid #3598dc;
	background-color:#ebada6;
}
.portlet.box.blue > .portlet-title {
	background-color:#0d77bf;
}


</style>
<form action="app-insert.php" enctype="multipart/form-data" id="frmRegistration" method="post" novalidate="novalidate">    
	<div class="row test1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="sticky-anchor"></div>

			<h2 class="regheading" style="text-align: center;">P.S.Senior Secondary School</h2>
                        <h4 class="block heading text-success" style="text-align: center;">
						<strong>ONLINE APPLICATION FORM FOR ADMISSION TO CLASSES I - IX (2026-2027)</strong></h4>
            
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <div class="form-horizontal form-row-sepe">
                        <div class="form-body test2">


                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                <div class="portlet blue box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-cogs"></i>PERSONAL INFORMATION : 
                                        </div>
                                     </div>
                                </div>

                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                NAME OF THE CHILD<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control" data-val="true" data-val-required="Please enter Name" id="StudentName" maxlength="48" name="StudentName" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this)" tabindex="2" type="text" value="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                GENDER <span class="required">* </span>
                                            </label>
											<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right ">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select Gender" id="Gender" name="Gender" tabindex="3"><option value="">-- SELECT --</option>
														<option value="MALE">MALE</option>
														<option value="FEMALE">FEMALE</option>
														<option value="OTHERS">OTHERS</option>
														
													</select>
                                                </div>
                                            </div>
                                           <!-- <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <div class="btn-group" data-toggle="buttons">
                                                        <label class="btn btn-default gender active">
                                                            <input Checked="checked" class="toggle" data-val="true" data-val-required="Please select Gender" id="Gender" name="Gender" tabindex="3" type="radio" value="MALE" /> MALE   
                                                        </label>
                                                        <label class="btn btn-default gender">
                                                            <input class="toggle" id="Gender" name="Gender" tabindex="4" type="radio" value="FEMALE" /> FEMALE
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                BLOOD GROUP
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right ">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" id="BloodGroup" name="BloodGroup" tabindex="4"><option value="">-- SELECT --</option>
													<option value="A+Ve">A+Ve</option>
													<option value="A-Ve">A-Ve</option>
													<option value="A1+Ve">A1+Ve</option>
													<option value="A1-Ve">A1-Ve</option>
													<option value="A1B+Ve">A1B+Ve</option>
													<option value="A1B-Ve">A1B-Ve</option>
													<option value="A2+Ve">A2+Ve</option>
													<option value="A2-Ve">A2-Ve</option>
													<option value="A2B+Ve">A2B+Ve</option>
													<option value="A2B-Ve">A2B-Ve</option>
													<option value="AB+Ve">AB+Ve</option>
													<option value="AB-Ve">AB-Ve</option>
													<option value="B+Ve">B+Ve</option>
													<option value="B-Ve">B-Ve</option>
													<option value="O+Ve">O+Ve</option>
													<option value="O-Ve">O-Ve</option>
													</select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                 CLASS FOR WHICH ADMISSION IS SOUGHT<span class="required">* </span>
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right ">
                                                        <i class="fa"></i>
                                                        <select class="form-control" data-val="true" data-val-required="Please select Applied Class" id="AppliedForKGS" name="AppliedForKGS" tabindex="5">
															<option value="">-- SELECT --</option>
															<option value="I">I</option>
															<option value="II">II</option>
															<option value="III">III</option>
															<option value="IV">IV</option>
															<option value="V">V</option>
															<option value="VI">VI</option>
															<option value="VII">VII</option>
															<option value="VIII">VIII</option>
															<option value="IX">IX</option>
															
														</select>
												
                                                    </div>
                                                </div>
                                        </div>                                           
                                                                                                                  
                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                DATE OF BIRTH<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">											
												<div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
													<input class="form-control" type="text" id="strDOB" name="strDOB" tabindex="6"/>
													<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												</div>
											</div>
                                        </div>
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                NATIONALITY  <span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select Nationality" id="drpNationality" name="drpNationality"  tabindex="7"><option value="">-- SELECT --</option>
													<option value="INDIAN">INDIAN</option>
													<option value="OTHERS">OTHERS</option>
													</select>
                                                </div>
                                            </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                               RELIGION<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right ">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select Religion" id="drpReligion" name="drpReligion"  tabindex="8"><option value="">-- SELECT --</option>
													<option value="HINDU">HINDU</option>
													<option value="CHRISTIAN">CHRISTIAN</option>
													<option value="MUSLIM">MUSLIM</option>
													<option value="OTHERS">OTHERS</option>
													</select>
                                                </div>
                                            </div>
                                        </div>
										
                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                COMMUNITY<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select Community" id="Community" name="Community" tabindex="9"><option value="">-- SELECT --</option>
														<option value="OC">OC</option>
														<option value="BC">BC</option>
														<option value="BCM">BCM</option>
														<option value="MBC">MBC</option>
														<option value="SC">SC</option>
														<option value="ST">ST</option>
														<option value="SCA">SCA</option>
													</select>
												</div>
                                            </div>
                                        </div>
										
										<div id="II_LANGUAGE_DIV"  class="form-group">										
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                SECOND LANGUAGE<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select II language" id="II_L" name="II_L" tabindex="9">
														<option value="">-- SELECT --</option>
														<option value="TAMIL">TAMIL</option>
														<option value="HINDI">HINDI</option>
														<option value="SANSKRIT">SANSKRIT</option>
													</select>
												</div>
                                            </div>
                                        </div>
										
										<div id="III_LANGUAGE_DIV"  class="form-group">
										<p style="color:red;text-align:center;">Either second language or third language should be Tamil.</p>
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                               THIRD LANGUAGE<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select III language" id="III_L" name="III_L" tabindex="9">
														<option value="">-- SELECT --</option>
														<option value="TAMIL">TAMIL</option>
														<option value="HINDI">HINDI</option>
														<option value="SANSKRIT">SANSKRIT</option>
													</select>
												</div>
                                            </div>
                                        </div>
										
										<div id="INT_COURSE"  class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                             INTEGRATED COURSE (Do you want to apply)<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select Integrated Course" id="int_course" name="int_course" tabindex="9">
														<option value="">-- SELECT --</option>
														<option value="YES">YES</option>
														<option value="NO">NO</option>
													</select>
												</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                               MOTHER TONGUE<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control" data-val="true" data-val-required="Please select Mother Tongue" id="drpMotherTongue" name="drpMotherTongue" tabindex="10"><option value="">-- SELECT --</option>
													<option value="TAMIL">TAMIL</option>
													<option value="ENGLISH">ENGLISH</option>
													<option value="TELUGU">TELUGU</option>
													<option value="HINDI">HINDI</option>
													<option value="MALAYALAM">MALAYALAM</option>
													<option value="KANNADA">KANNADA</option>
													<option value="PUNJABI">PUNJABI</option>
													<option value="GUJARATI">GUJARATI</option>
													<option value="BENGALI">BENGALI</option>
													<option value="OTHERS">OTHERS</option>
													</select>
                                                </div>
                                            </div>
                                        </div>
				 										
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                EMIS NUMBER 
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input class="form-control" data-val="true" data-val-required="Please enter Emis No" maxlength="16" id="EmisNo" name="EmisNo" onkeyup="ChangeCase(this);" tabindex="11" type="text" value="" />
                                                    </div>
                                                </div>
                                        </div>
																				
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                AADHAR NUMBER OF THE CHILD
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input class="form-control" data-val="true" data-val-required="Please enter AadharNo" maxlength="12" id="AadharNo" name="AadharNo" onkeyup="ChangeCase(this);" tabindex="12" type="text" value="" />
                                                    </div>
                                                </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                               LAND LINE NO.
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input class="form-control" data-val="true" id="MobileNo2" name="MobileNo2" tabindex="13" type="text" value="" />
                                                    </div>
                                                </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                               FATHER'S MOBILE  NO.<span class="required">* </span>
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input class="form-control" data-val="true" data-val-required="Please enter MobileNo" id="MobileNo" name="MobileNo" onkeyup="ChangeCase(this);" tabindex="14" type="text" value="" />
                                                    </div>
                                                </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                               MOTHER'S MOBILE NO.
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input class="form-control" data-val="true" id="MobileNo1" name="MobileNo1" tabindex="15" type="text" value="" />
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                EMAIL ID OF THE PARENT<span class="required">* </span>
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input class="form-control" data-val="true" data-val-required="Please enter Email_ID" id="Email_ID" maxlength="100" name="Email_ID" onchange="fnEmailValidate()" tabindex="16" type="text" value="" />
                                                        <span id="emailInValid" style="display: none; color: red;">Please enter valid email</span>
                                                    </div>
                                                </div>
                                        </div>
										
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12  text-right">
                                                NAME OF THE SCHOOL(LAST STUDIED)<span class="required">* </span>
                                            </label>
                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control" data-val="true" data-val-required="Please enter School Name" id="schoolName" name="schoolName" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this)" tabindex="17" type="text" value="" />
                                                </div>
                                            </div>
                                        </div>
										<!--<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                PERMANENT ADDRESS <span class="required">* </span>
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <textarea class="form-control" id="AddressP" maxlength="500" name="AddressP" onkeypress="return AddressValidate(event)" onkeyup="ChangeCase(this);" tabindex="17">
																	</textarea>
                                                    </div>
                                                </div>
                                        </div>-->
                                         <div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                RESIDENTIAL ADDRESS <span class="required">* </span>
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <textarea class="form-control" id="AddressR" maxlength="500" name="AddressR" onkeypress="return AddressValidate(event)" onkeyup="ChangeCase(this);" rows="2" tabindex="18">
																	</textarea>
                                                    </div>
                                                </div>
                                        </div>
										<!--<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                BIRTH CERTIFICATE 
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i><input type="file" name="file1" id="file1" tabindex="19">                                                       
                                                    </div>
                                                </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                ANY GOVT APPROVED ADDRESS PROOF(AADHAR OF THE PARENT)
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i><input type="file" name="file2" id="file2" tabindex="20">                                                       
                                                    </div>
                                                </div>
                                        </div>
										<div class="form-group">
                                            <label class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                                                REPORT CARD OF PREVIOUS YEAR CLASS
                                            </label>
                                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i><input type="file" name="file3" id="file3" tabindex="21">                                                       
                                                    </div>
                                                </div>
                                        </div>-->
										

								</div>											
									
                               
                            </div>
                        </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div class="portlet blue box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-cogs"></i>PARENT DETAILS:
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>DETAILS</th>
                                                    <th style="text-align: center;">FATHER</th>
                                                    <th style="text-align: center;">MOTHER</th>
                                                    <th style="text-align: center;">GUARDIAN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>NAME</td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please enter Father Name" id="FatherName" maxlength="48" name="FatherName" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" style="width:95%" tabindex="22" type="text" value="" />
                                                                <span class="required fNeme">* </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please enter Mother Name" id="MotherName" maxlength="48" name="MotherName" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" style="width:95%" tabindex="23" type="text" value="" />
                                                                <span class="required fNeme">* </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" id="GuardianName" maxlength="48" name="GuardianName" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" tabindex="24" type="text" value="" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>QUALIFICATION
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please select Father Qualification" id="FatherQualification" maxlength="48" name="FatherQualification"  onkeyup="ChangeCase(this);" style="width:95%" tabindex="25" type="text" value="" />
                                                                <span class="required fNeme">* </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please enter Mother Qualification" id="MotherQualification" maxlength="48" name="MotherQualification"  onkeyup="ChangeCase(this);" style="width:95%" tabindex="26" type="text" value="" />
                                                                <span class="required fNeme">* </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" id="GuardianQualification" maxlength="48" name="GuardianQualification" onkeyup="ChangeCase(this);" tabindex="27" type="text" value="" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>OCCUPATION
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <select class="form-control" data-val="true" data-val-required="Please enter Father Occupation" id="FatherOccupation" maxlength="150" name="FatherOccupation" style="width:95%" tabindex="27"><option value="">-- SELECT --</option>
																	<option value="AGRICULTURE SERVICES">AGRICULTURE SERVICES </option>
																	<option value="BUSINESS">BUSINESS</option>
																	<option value="DEFENCE SERVICE">DEFENCE SERVICE</option>
																	<option value="ENGINEERING SERVICE">ENGINEERING SERVICE</option>
																	<option value="PUBLIC / GOVT.SERVICE">PUBLIC / GOVT.SERVICE</option>
																	<option value="LAW PRACTICE">LAW PRACTICE</option>
																	<option value="MEDICAL SERVICE">MEDICAL SERVICE</option>
																	<option value="PRIVATE SERVICE">PRIVATE SERVICE</option>
																	<option value="SELF EMPLOYED">SELF EMPLOYED</option>
																	<option value="RETIRED">RETIRED</option>
																	<option value="LATE">LATE</option>
																	<option value="NONE(UNEMPLOYED)">NONE(UNEMPLOYED)</option>
																	<option value="OTHERS">OTHERS</option>
																	</select>
																	<span class="required fNeme">* </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <select class="form-control" data-val="true" data-val-required="Please enter Mother Occupation" id="MotherOccupation" maxlength="150" name="MotherOccupation" tabindex="28"><option value="">-- SELECT --</option>
																	<option value="AGRICULTURE SERVICES">AGRICULTURE SERVICES </option>
																	<option value="BUSINESS">BUSINESS</option>
																	<option value="DEFENCE SERVICE">DEFENCE SERVICE</option>
																	<option value="ENGINEERING SERVICE">ENGINEERING SERVICE</option>
																	<option value="PUBLIC / GOVT.SERVICE">PUBLIC / GOVT.SERVICE</option>
																	<option value="LAW PRACTICE">LAW PRACTICE</option>
																	<option value="MEDICAL SERVICE">MEDICAL SERVICE</option>
																	<option value="PRIVATE SERVICE">PRIVATE SERVICE</option>
																	<option value="SELF EMPLOYED">SELF EMPLOYED</option>
																	<option value="RETIRED">RETIRED</option>
																	<option value="LATE">LATE</option>
																	<option value="HOUSE WIFE">HOUSE WIFE</option>
																	<option value="NONE(UNEMPLOYED)">NONE(UNEMPLOYED)</option>
																	<option value="OTHERS">OTHERS</option>
																	</select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <select class="form-control" id="GuardianOccupation" maxlength="150" name="GuardianOccupation" tabindex="29"><option value="">-- SELECT --</option>
																	<option value="AGRICULTURE SERVICES">AGRICULTURE SERVICES </option>
																	<option value="BUSINESS">BUSINESS</option>
																	<option value="DEFENCE SERVICE">DEFENCE SERVICE</option>
																	<option value="ENGINEERING SERVICE">ENGINEERING SERVICE</option>
																	<option value="PUBLIC / GOVT.SERVICE">PUBLIC / GOVT.SERVICE</option>
																	<option value="LAW PRACTICE">LAW PRACTICE</option>
																	<option value="MEDICAL SERVICE">MEDICAL SERVICE</option>
																	<option value="PRIVATE SERVICE">PRIVATE SERVICE</option>
																	<option value="SELF EMPLOYED">SELF EMPLOYED</option>
																	<option value="RETIRED">RETIRED</option>
																	<option value="LATE">LATE</option>
																	<option value="HOUSE WIFE">HOUSE WIFE</option>
																	<option value="NONE(UNEMPLOYED)">NONE(UNEMPLOYED)</option>
																	<option value="OTHERS">OTHERS</option>
																	</select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
												<tr>
                                                    <td>DETAILS OF THE OCCUPATION (Employer Name / Address)</td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please enter FatherOccDetail" id="FatherOccDetail" name="FatherOccDetail" onkeyup="ChangeCase(this);" style="width:95%" tabindex="30" type="text" value="" />
                                                             
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please enter MotherOccDetail" id="MotherOccDetail"  name="MotherOccDetail" onkeyup="ChangeCase(this);" style="width:95%" tabindex="31" type="text" value="" />
                                                               
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" id="GuardianOccDetails"  name="GuardianOccDetails" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" tabindex="32" type="text" value="" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>ANNUAL INCOME (in Figures)
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" data-val="true" data-val-required="Please enter Father Annual Income" id="FatherAnnualIncome" maxlength="10" name="FatherAnnualIncome" onkeypress="return isNumberKey(event)" style="width:95%" tabindex="33" type="text" value="" />
                                                                <span class="required fNeme">* </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" id="MotherAnnualIncome" maxlength="10" name="MotherAnnualIncome" onkeypress="return isNumberKey(event)" tabindex="34" type="text" value="" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group tblItem">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control" id="GuardianAnnualIncome" maxlength="10" name="GuardianAnnualIncome" onkeypress="return isNumberKey(event)" tabindex="35" type="text" value="" />
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
												

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>                          

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                    <div class="portlet blue box">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="fa fa-cogs"></i>ADDTIONAL DETAILS :
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">                                                                                           
                                                 <div class="form-group">
                                                    <label class="col-lg-5 col-md-6 col-sm-5 col-xs-12 text-right">
                                                       DISTANCE (Home to School - in kms)  <span class="required">* </span>
                                                    </label>
                                                     <div class="col-lg-7 col-md-6 col-sm-7 col-xs-12">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control" data-val="true" data-val-required="Please enter Distance" id="Distance" maxlength="4" name="Distance" onkeypress="return isNumberKey(event)" tabindex="36" type="text" value="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           
                                                <div class="form-group">
                                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        
														ANY SIBLING STUDYING IN OUR SCHOOL <span class="required">* </span>
                                                    </label>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                                        <span class="radio-list">
                                                            <label class="  radio-inline">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input class="form-radioErrorcontrol  IsSiblings" data-val="true" data-val-required="Please select Sliblings Studied" id="SiblingStudied" name="SiblingStudied" tabindex="37" type="radio" value="Yes" /> YES 
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input Checked="checked" class="form-radioErrorcontrol IsSiblings" id="SiblingStudied" name="SiblingStudied" tabindex="38" type="radio" value="No" /> NO
                                                                </div>
                                                            </label>
                                                        </span>

                                                    </div>
                                                </div>
											</div>
                                        </div>
                                    </div>
									
									 <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           
                                                <div class="form-group">
                                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                        
														WHETHER THE PARENT IS AN ALIMNUS OF OUR SCHOOL<span class="required">* </span>
                                                    </label>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">

                                                        <span class="radio-list">
                                                            <label class="  radio-inline">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input class="form-radioErrorcontrol  IsSiblings1" data-val="true" data-val-required="Please select Sliblings Studied" id="SiblingStudied1" name="SiblingStudied1" tabindex="39" type="radio" value="Yes" /> YES 
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="input-icon right">
                                                                    <i class="fa"></i>
                                                                    <input Checked="checked" class="form-radioErrorcontrol IsSiblings1" id="SiblingStudied1" name="SiblingStudied1" tabindex="40" type="radio" value="No" /> NO
                                                                </div>
                                                            </label>
                                                        </span>

                                                    </div>
                                                </div>
											</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div id="dvSiblings" style="display: none">

                                                
                                                <div class="form-group">

                                                    <div class="col-lg-1 col-md-0 col-sm-0 col-xs-0"></div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="portlet box blue">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>SIBLING DETAILS :
                                                                </div>
                                                                <div class="tools">
                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>NAME
                                                                                </th>
                                                                                <th>ADMISSION NO
                                                                                </th>
                                                                                <th>CLASS
                                                                                </th>
                                                                                <th>SECTION
                                                                                </th>
                                                                                <th>ADD
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                                <tr id="SiblingsRecord0" style="display:none;">
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" data-val="true" data-val-required="Please enter SiblingsName" id="SiblingsName0" maxlength="48" name="SiblingsName1" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" tabindex="41" type="text" value="" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" data-val="true" data-val-required="Please enter SiblingsAdmissionNo" id="SiblingsAdmissionNo0" maxlength="7" name="SiblingsAdmissionNo1" onkeypress="return AlphaNumeric(event)" onkeyup="ChangeCase(this);" tabindex="42" type="text" value="" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <select class="form-control" data-val="true" data-val-required="Please select SiblingsClass" id="SiblingsClass0" maxlength="48" name="SiblingsClass1" tabindex="43"><option value="">-- SELECT --</option>
																							<option>PREKG</option>
																							<option>LKG</option>
																							<option>UKG</option>
																							<option>I</option>
																							<option>II</option>
																							<option>III</option>
																							<option>IV</option>
																							<option>V</option>
																							<option>VI</option>
																							<option>VII</option>
																							<option>VIII</option>
																							<option>IX</option>
																							<option>X</option>
																							<option>XI</option>
																							<option>XII</option>
																							</select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <select class="form-control" data-val="true" data-val-required="Please select SiblingsSection" id="SiblingsSection0" maxlength="20" name="SiblingsSection1" tabindex="44"><option value="">-- SELECT --</option>
																							<option>A</option>
																							<option>B</option>
																							<option>C</option>
																							<option>D</option>
																							<option>E</option>
																							
																							</select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input type="button" class="btn green" id="SiblingsAddRecord0" value="+" onclick="fnAddSiblings(this)"  />
                                                                                            <input type="button" class="btn red" id="SiblingsRemoveRecord0" value="x" onclick="fnRemoveSiblings(this)" style="display:none" />
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr id="SiblingsRecord1" style="display:none;">
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" data-val="true" data-val-required="Please enter SiblingsName" id="SiblingsName1" maxlength="48" name="SiblingsName2" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" tabindex="45" type="text" value="" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" data-val="true" data-val-required="Please enter SiblingsAdmissionNo" id="SiblingsAdmissionNo1" maxlength="7" name="SiblingsAdmissionNo2" onkeypress="return AlphaNumeric(event)" onkeyup="ChangeCase(this);" tabindex="46" type="text" value="" />
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <select class="form-control" data-val="true" data-val-required="Please select SiblingsClass" id="SiblingsClass1" maxlength="48" name="SiblingsClass2" tabindex="47"><option value="">-- SELECT --</option>
																							<option>PKG</option>
																							<option>LKG</option>
																							<option>UKG</option>
																							<option>I</option>
																							<option>II</option>
																							<option>III</option>
																							<option>IV</option>
																							<option>V</option>
																							<option>VI</option>
																							<option>VII</option>
																							<option>VIII</option>
																							<option>IX</option>
																							<option>X</option>
																							<option>XI</option>
																							<option>XII</option>
																							</select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <select class="form-control" data-val="true" data-val-required="Please select SiblingsSection" id="SiblingsSection1" maxlength="20" name="SiblingsSection2" tabindex="48"><option value="">-- SELECT --</option>
																							<option>A</option>
																							<option>B</option>
																							<option>C</option>
																							<option>D</option>
																							<option>E</option>
																							
																							</select>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input type="button" class="btn green" id="SiblingsAddRecord1" value="+" onclick="fnAddSiblings(this)"  />
                                                                                            <input type="button" class="btn red" id="SiblingsRemoveRecord1" value="x" onclick="fnRemoveSiblings(this)" style="display:none" />
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>                                                                              
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-1 col-md-0 col-sm-0 col-xs-0"></div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
									
									<div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div id="dvSiblings1" style="display: none">

                                                
                                                <div class="form-group">

                                                    <div class="col-lg-1 col-md-0 col-sm-0 col-xs-0"></div>

                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="portlet box blue">
                                                            <div class="portlet-title">
                                                                <div class="caption">
                                                                    <i class="fa fa-cogs"></i>ALIMNUS DETAILS :
                                                                </div>
                                                                <div class="tools">
                                                                </div>
                                                            </div>
                                                            <div class="portlet-body">
                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>NAME
                                                                                </th>
                                                                                <th>YEAR OF ADMISSION 
                                                                                </th>
																				<th>CLASS
                                                                                </th>
                                                                                <th>YEAR OF COMPLETION 
                                                                                </th>
                                                                                <th>CLASS
                                                                                </th>
                                                                               
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                                <tr id="AName" style="display:none;">
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" data-val="true" id="AName" maxlength="48" name="AName" onkeypress="return NameValidate(event)" onkeyup="ChangeCase(this);" type="text" value="" tabindex="49"/>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" data-val="true" id="YAdno" name="YAdno" onkeypress="return isNumberKey(event)" onkeyup="ChangeCase(this);" type="text" value="" tabindex="50"/>
                                                                                        </div>
                                                                                    </td>
																					<td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" id="YClass" name="YClass"  onkeyup="ChangeCase(this);" type="text" value="" tabindex="51"/>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" id="YCom" name="YCom" onkeypress="return isNumberKey(event)" onkeyup="ChangeCase(this);" type="text" value="" tabindex="52"/>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="input-icon right">
                                                                                            <i class="fa"></i>
                                                                                            <input class="form-control" id="CClass" name="CClass"  onkeyup="ChangeCase(this);" type="text" value="" tabindex="53"/>
                                                                                        </div>
                                                                                    </td>
                                                                                    
                                                                                </tr>
                                                                                                                                                              
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-1 col-md-0 col-sm-0 col-xs-0"></div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <!--<div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">

                                            <div class="col-lg-4 col-md-4 col-sm-3 col-xs-0"></div>
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                <div id="html_element"></div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-3 col-xs-0"></div>

                                        </div>
                                    </div>-->

                                    <div class="row">
                                        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11  text-right">
                                            <button type="button" id="btnSave1" class="btn default" onclick="fnSubmit()">Submit<i class="fa fa-check"></i></button>
                                            <button id="btnClear1" type="button" class="btn default" onclick="fnClear()">Reset<i class="fa fa-eraser"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div> 
</form>

<script type="text/javascript">

    //initial load
    $(document).ready(function () {
        var msg = '';
        var cls = '';
        if (msg != "") {
            toastr.options = {
                closeButton: true
            };
            var $toast = toastr[cls](msg, 'Registration');
        }
    });

    // DataPicker
    $(function () {
        $('.date-picker').datepicker({
            format: 'dd/mm/yyyy',
            rtl: Metronic.isRTL(),
            orientation: "left",
            autoclose: true
        });
    });
	
	//date-picker
	
	$(function () {
		$("#datepicker").datepicker({ 
			autoclose: true, 
			todayHighlight: true
		}).datepicker('update', new Date());
	});

    // to upper case
    function ChangeCase(elem) {
        elem.value = elem.value.toUpperCase();
    }

    // Remove hidden class
    function RemoveCssClass(input) {
        var icon = $(input).parent('.input-icon').children('i');
        icon.removeClass("fa-warning");
    }

    // clear all field data
    function fnClear() {
        $(':text').val("");
        $('textarea').val("");
        $('Select').val('');
    }

</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const sel = document.getElementById('AppliedForKGS');
  const divII = document.getElementById('II_LANGUAGE_DIV');
  const divIII = document.getElementById('III_LANGUAGE_DIV');
  const divINT = document.getElementById('INT_COURSE');

  if (!sel) {
    console.warn('AppliedForKGS select not found in DOM.');
    return;
  }

  // helper to safely show/hide
  const show = el => { if (el) el.style.display = 'block'; };
  const hide = el => { if (el) el.style.display = 'none'; };

  // ensure all start hidden
  [divII, divIII, divINT].forEach(hide);

  function updateVisibility() {
    const value = (sel.value || '').toString().trim().toUpperCase();

    // VI / VII / VIII => show II_LANGUAGE and III_LANGUAGE
    if (['VI', 'VII', 'VIII'].includes(value)) {
      show(divII);
      show(divIII);
      hide(divINT);
      return;
    }

    // IX => show II_LANGUAGE and INT_COURSE, hide III_LANGUAGE
    if (value === 'IX') {
      show(divII);
      hide(divIII);
      show(divINT);
      return;
    }

    // default: hide all
    [divII, divIII, divINT].forEach(hide);
  }

  // attach and run once on load (handles preselected value)
  sel.addEventListener('change', updateVisibility);
  updateVisibility();
});
</script>




<script>

    // Hide - Show Event

    /*$('.IsAppliedFor').change(function () {

        $('#dvAgecriteria').hide();
        $('#AgeCriteriaMsg').html('');

        var isAppliedFor = $(this).filter(':checked').val();


       /* if (isAppliedFor == "KGS") {
            $('#AppliedForKGS').val('');
            $('#PreviousKGS').val('');
            $('#PreviousPrimary').val('');
            $('#AppliedForPrimary').val('');
            $('#strDOB').val('');
            $('#Age').val('');

            $("#dvKGS").show();
            $('#AppliedForKGS').removeClass('hidden');

            $('#dvPrimary').hide();
            $('#dvPrimarySchoolDetail').hide();
            $('#dvMarkSheet').hide();
            $('#dvOthers').hide();    

            $("#PreviousPrimary ,#LastSchoolStudied ,#drpMediumOfInstruction,#MediumOfInstruction").addClass('hidden');
            var icon = $("#PreviousPrimary ,#LastSchoolStudied ,#drpMediumOfInstruction,#MediumOfInstruction ").parent('.input-icon').children('i');
            icon.removeClass("fa-warning");
            $('#drpMediumOfInstruction').val('');

        }
    });*/

		
	
 /*   $("#strDOB").change(function () {

        try {
			
            var Dob = $('#strDOB').val();
            if (Dob.length > 0) {
                var AppliedFor = $('.IsAppliedFor').filter(':checked').val();
                if (AppliedFor == undefined) {
                    $('#strDOB').val('');
                    $('#Age').val('');
                    $('#RegType').focus();
                    throw "Please Select Applied For First";
                }

                else {
                    fnAgeCalculation();
                }
            }
        }
        catch (ExceptionMsg) {
            toastr.clear();
            toastr.options = {
                "positionClass": "toast-top-right",
                closeButton: true
            };
            var $toast = toastr['error'](ExceptionMsg, 'Registration');

        }

    });*/
	

    function fnNationality() {
        var selVal = $("#drpNationality").val();

        if (selVal == "Others") {
            $('#Nationality').removeClass('hidden');
            $('#dvNationality').show();
            $('#Nationality').val("");
        }
        else {
            $('#dvNationality').hide();
            $('#Nationality').addClass('hidden');
            var icon = $('#Nationality').parent('.input-icon').children('i');
            icon.removeClass("fa-warning");
            $('#Nationality').val(selVal);
        }
    }

    function fnReligion() {
        var selVal = $("#drpReligion").val();
        if (selVal == "Others") {
            $('#Religion').removeClass('hidden');
            $('#dvReligion').show();
            $('#Religion').val("");
        }
        else {
            $('#dvReligion').hide();
            $('#Religion').addClass('hidden');
            var icon = $('#Religion').parent('.input-icon').children('i');
            icon.removeClass("fa-warning");
            $('#Religion').val(selVal);
        }
    }

    function fnCommunity() {
        var community = $('#Community').val();
        if (community.length > 0) {
            $('#CommunityCertificateNo').removeClass('hidden');
            $('#Caste').removeClass('hidden');
            $('#dvCommunity').show();
            $('#CommunityCertificateNo').val("");
            $('#Caste').val("");
        }
        else {
            $('#dvCommunity').hide();
            $('#CommunityCertificateNo').addClass('hidden');
            var icon = $('#CommunityCertificateNo').parent('.input-icon').children('i');
            icon.removeClass("fa-warning");
            $('#Caste').addClass('hidden');
            var icon = $('#Caste').parent('.input-icon').children('i');
            icon.removeClass("fa-warning");
            $('#CommunityCertificateNo').val("");
            $('#Caste').val("");
        }

    }

    function fnMotherTongue() {
        var selVal = $("#drpMotherTongue").val();
        if (selVal == "Others") {
            $('#MotherTongue').removeClass('hidden');
            $('#dvMotherTongue').show();
            $('#MotherTongue').val("");
        }
        else {
            $('#dvMotherTongue').hide();
            $('#MotherTongue').addClass('hidden');
            var icon = $('#MotherTongue').parent('.input-icon').children('i');
            icon.removeClass("fa-warning");
            $('#MotherTongue').val(selVal);
        }
    }

    $('.IsSiblings').change(function () {
        var IsSiblings = $(this).filter(':checked').val();
        if (IsSiblings == "Yes") {
            $("#dvSiblings").show();
            $("#SiblingsRecord0").show();
        }
        else if (IsSiblings == "No") {
            $("#dvSiblings").hide();
        }
    });
	
	 $('.IsSiblings1').change(function () {
        var IsSiblings = $(this).filter(':checked').val();
        if (IsSiblings == "Yes") {
            $("#dvSiblings1").show();
            $("#AName").show();
        }
        else if (IsSiblings == "No") {
            $("#dvSiblings1").hide();
        }
    });

    function fnAddSiblings(elem) {
        var elemId = $(elem).attr("id");
        var siblingsRecordNo = elemId[elemId.length - 1];

        try {
            if ($("#SiblingsName" + siblingsRecordNo).val() == "") {
                $('#SiblingsName' + siblingsRecordNo).focus();
                throw "Please enter Siblings Name";
            }
            if ($("#SiblingsAdmissionNo" + siblingsRecordNo).val() == "") {
                $('#SiblingsAdmissionNo' + siblingsRecordNo).focus();
                throw "Please enter Siblings AdmissionNo";
            }
            var SiblingsClass = $("#SiblingsClass" + siblingsRecordNo).val();

            if (SiblingsClass.length == "0") {
                $('#SiblingsClass' + siblingsRecordNo).focus();
                throw "Please Select Siblings Class";
            }
            var Section = $("#SiblingsSection" + siblingsRecordNo).val();

            if (Section.length == "0") {
                $('#SiblingsSection' + siblingsRecordNo).focus();
                throw "Please Select Siblings Section";
            }

            if (siblingsRecordNo != "8") {
                var nextRecord = siblingsRecordNo;
                nextRecord++;

                var currentAddRecord = "SiblingsAddRecord" + siblingsRecordNo;
                var currentRemoveRecord = "SiblingsRemoveRecord" + siblingsRecordNo;
                var nextRecord = "SiblingsRecord" + nextRecord;
                siblingsRecordNo--;
                var previosRemoveRecord = "SiblingsRemoveRecord" + siblingsRecordNo;

                $('#' + nextRecord).show();
                $('#' + currentAddRecord).hide();
                $('#' + currentRemoveRecord).show();
                $('#' + previosRemoveRecord).hide();
            }
            else {

                var nextRecord = siblingsRecordNo;
                nextRecord++;
                var currentAddRecord = "SiblingsAddRecord" + siblingsRecordNo;
                var currentRemoveRecord = "SiblingsRemoveRecord" + siblingsRecordNo;
                var nextRecord = "SiblingsRecord" + nextRecord;
                siblingsRecordNo--;
                var previosRemoveRecord = "SiblingsRemoveRecord" + siblingsRecordNo;
                $('#' + nextRecord).show();
                $('#SiblingsAddRecord9').hide();
                $('#SiblingsRemoveRecord9').show();
                $('#' + currentAddRecord).hide();
                $('#' + currentRemoveRecord).hide();
                $('#' + previosRemoveRecord).hide();

            }
        }
        catch (ExceptionMsg) {
            toastr.clear();
            toastr.options = {
                "positionClass": "toast-top-right",
                closeButton: true
            };
            var $toast = toastr['error'](ExceptionMsg, 'Registration');

        }
    }

    function fnRemoveSiblings(elem) {
        var elemId = $(elem).attr("id");
        var siblingsRecordNo = elemId[elemId.length - 1];

        if (siblingsRecordNo == "9") {

            $('#SiblingsName' + siblingsRecordNo).val('');
            $('#SiblingsAdmissionNo' + siblingsRecordNo).val('');
            $('#SiblingsClass' + siblingsRecordNo).val('');
            $('#SiblingsSection' + siblingsRecordNo).val('');

            $('#SiblingsRecord9').hide();
            $('#SiblingsAddRecord8').show();
            $('#SiblingsRemoveRecord8').hide();
            $('#SiblingsAddRecord7').hide();
            $('#SiblingsRemoveRecord7').show();
        }
        else {
            var nextRecord = siblingsRecordNo;
            nextRecord++;

            var NextRecord = "SiblingsRecord" + nextRecord;
            $('#' + NextRecord).hide();

            $('#SiblingsName' + nextRecord).val('');
            $('#SiblingsAdmissionNo' + nextRecord).val('');
            $('#SiblingsClass' + nextRecord).val('');
            $('#SiblingsSection' + nextRecord).val('');

            var currentRemoveRecord = "SiblingsRemoveRecord" + siblingsRecordNo;
            $('#' + currentRemoveRecord).hide();

            var currentAddRecord = "SiblingsAddRecord" + siblingsRecordNo;
            $('#' + currentAddRecord).show();

            var previousRecord = siblingsRecordNo;
            previousRecord--;

            var previousRemoveRecord = "SiblingsRemoveRecord" + previousRecord;
            $('#' + previousRemoveRecord).show();

            var previousAddRecord = "SiblingsAddRecord" + previousRecord;
            $('#' + previousAddRecord).hide();
        }
    }

</script>

<script>

    // phone number mask text box     
    $(function () {
        $('#MobileNo').inputmask("mask", { 
            "mask": "9999999999",
        });
    });
	
	

    //email validation
    function fnEmailValidate() {
        var email = $('#Email_ID').val();
        var validEmail = validateEmail(email);
        if (validEmail == false) {
            $('#Email_ID').focus();
            $('#emailInValid').show();
        }
        else {
            $('#emailInValid').hide();
        }
    }
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }

    //On Key Press Validation
    function NameValidate(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode == 46) || (charCode == 8) || (charCode == 73) || (charCode == 13) || (charCode == 27) || (charCode == 32))
            return true;
        else
            return false;
    }
    function checkSpecialKeys(e) {
        if (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40)
            return false;
        else
            return true;
    }
    function AddressValidate(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || (charCode > 42 && charCode < 59) || (charCode == 46) || (charCode == 8) || (charCode == 73) || (charCode == 95) || (charCode == 13) || (charCode == 27) || (charCode == 32) || (charCode == 35))
            return true;
        else
            return false;

    }
    function AlphaNumeric(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode == 8))
            return true;
        else
            return false;

    }
    function AlphaNumericslash(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode == 8) || (charCode == 47) || (charCode == 92))
            return true;
        else
            return false;

    }
    function AlphaNumericWithDotandSpace(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode == 8) || (charCode == 46) || (charCode == 32))
            return true;
        else
            return false;

    }
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31
          && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    function isDecimal(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode >= 48 && charCode < 58) || (charCode == 46) || (charCode == 8))
            return true;
        else
            return false;
    }
    function textLimit(field, maxlen) {

        if (field.value.length > maxlen + 1)
            alert('Your Text Limit  is Maximum!');
        if (field.value.length > maxlen)
            field.value = field.value.substring(0, maxlen);
    }
    function TextValidate(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || (charCode == 8) || (charCode == 46) || (charCode == 32))
            return true;
        else
            return false;
    }

    // file upload validation

    // get uploaded file size
    function GetFileSize(fileid) {
        try {
            var fileSize = 0;
            //for IE
            if ($.browser.msie) {
                //before making an object of ActiveXObject, 
                //please make sure ActiveX is enabled in your IE browser
                var objFSO = new ActiveXObject("Scripting.FileSystemObject"); var filePath = $("#" + fileid)[0].value;
                var objFile = objFSO.getFile(filePath);
                var fileSize = objFile.size; //size in kb
                fileSize = fileSize / 1048576; //size in mb 
            }
                //for FF, Safari, Opeara and Others
            else {
                fileSize = $("#" + fileid)[0].files[0].size //size in kb
                fileSize = fileSize / 1048576; //size in mb 
            }
            return fileSize;
        }
        catch (e) {
            //alert("Error is :" + e);
        }
    }

    //get file path from client system
    function getNameFromPath(strFilepath) {
        var objRE = new RegExp(/([^\/\\]+)$/);
        var strName = objRE.exec(strFilepath);

        if (strName == null) {
            return null;
        }
        else {
            return strName[0];
        }
    }

    // upload file validation
    function fnFileValidation(selectFile, RemoveFile) {
        var file = $('#' + selectFile).val();
        if (file != null || file != "") {
            var size = GetFileSize(selectFile);
            if (size == 0 || size == null) { }
            else {
                if (size > 3) {
                    // $("#spanfile").text("You can upload file up to 3 MB");
                    var message = "";
                    message += "<b>You can upload file upto 3 MB.</b>";
                    toastr.clear();
                    toastr.options = {
                        "positionClass": "toast-top-right",
                        closeButton: true
                    };
                    var $toast = toastr['error'](message, '');

                    $('#' + RemoveFile).click();
                    //return false;
                }
                else if (file != null) {
                    var extension = file.substr((file.lastIndexOf('.') + 1));
                    switch (extension) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'gif':
                        case 'pdf':
                        case 'doc':
                        case 'docx':
                        case 'JPG':
                        case 'JPEG':
                        case 'PNG':
                        case 'GIF':
                        case 'PDF':
                        case 'DOC':
                        case 'DOCX':
                            flag = true;
                            break;
                        default:
                            flag = false;
                    }
                    if (flag == false) {
                        //$("#spanfile").text("You can upload only jpg,png,gif,pdf extension file");
                        var message = "";
                        message += "<b>You can upload only jpg,jpeg,png,pdf,gif,doc,docx extension file.</b>";
                        toastr.clear();
                        toastr.options = {
                            "positionClass": "toast-top-right",
                            closeButton: true
                        };
                        var $toast = toastr['error'](message, '');

                        $('#' + RemoveFile).click();
                        //return false;
                    }
                    else {
                        $("#spanfile").text("");
                        //return true;
                    }
                }
            }
        }
    }

</script>

<script type="text/javascript">

    // submit action  
    function fnSubmit() {

        try {

            // calling form all field validation
            fnFormValidation();

        }
        catch (ExceptionMsg) {
            toastr.clear();
            toastr.options = {
                "positionClass": "toast-top-right",
                closeButton: true
            };
            var $toast = toastr['error'](ExceptionMsg, 'Registration');

        }

    }

    // form validation    
    function fnFormValidation() {

        var form = $('#frmRegistration');
        var error = $('.alert-danger', form);
        var success = $('.alert-success', form);
        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: ".hidden",  // validate all fields including form hidden input
            rules: {
                RegType: {
                    required: true
                },
                StudentName: {
                    required: true
                },
                Gender: {
                    required: true
                },
                /*BloodGroup: {
                    required: true
                },*/
                AppliedForKGS: {
                    required: true
                },
                PreviousPrimary: {
                    required: true
                },				                
				
				strDOB: {
                    required: true
                },
                drpNationality: {
                    required: true
                },
                Nationality: {
                    required: true
                },
                //TransportRequired: {
                //    required: true
                //},
                drpReligion: {
                    required: true
                },
                Religion: {
                    required: true
                },
                Community: {
                    required: true
                },
                //CommunityCertificateNo: {
                //    required: true
                //},
                Caste: {
                    required: true
                },
                drpMotherTongue: {
                    required: true
                },
                MotherTongue: {
                    required: true
                },

                FatherName: {
                    required: true
                },
                FatherQualification: {
                    required: true
                },
                FatherMobileNo: {
                    required: true
                },
                FatherOccupation: {
                    required: true
                },
                FatherAnnualIncome: {
                    required: true
                },
                MotherName: {
                    required: true
                },
                MotherQualification: {
                    required: true
                },
                MotherMobileNo: {
                    required: true
                },
                LivingWithFather: {
                    required: true
                },
                /*AddressP: {
                    required: true
                },*/
				AddressR: {
                    required: true
                },
                District: {
                    required: true
                },
                Pincode: {
                    required: true
                },

                Email_ID: {
                    email: true,
                    required: true
                },
                ConfirmEmail_ID: {
                    required: true,
                    equalTo: "#Email_ID"
                },
                MobileNo: {
                    required: true
                },
                BirthCertificateNo: {
                    required: true
                },
                schoolName: {
                    required: true
                },
                Distance: {
                    required: true
                },
                LastSchoolStudied: {
                    required: true
                },

                drpMediumOfInstruction: {
                    required: true
                },
                MediumOfInstruction: {
                    required: true
                },
                FitnessOfHealth: {
                    required: true
                },
                FitnessOfHealthReason: {
                    required: true
                },
                SiblingStudied: {
                    required: true
                },

                //BirthCertificatefile: {
                //    required: true
                //},
                //MSfile: {
                //    required: true
                //},


                //SiblingsName: {
                //    required: true
                //},
                //SiblingsAdmissionNo: {
                //    required: true
                //},
                //SiblingsClass: {
                //    required: true
                //},
                //SiblingsSection: {
                //    required: true
                //},

            },


            invalidHandler: function (event, validator) {
                success.hide();
                error.show();
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                var icon = $(element).parent('.input-icon').children('i');
                icon.removeClass('fa-check').addClass("fa-warning");
                icon.attr("data-original-title", error.text()).tooltip({ 'container': 'body' });
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
            },
            unhighlight: function (element) { // revert the change done by hightlight

            },
            success: function (label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass("fa-warning").addClass("fa-check");
            }
        });

        if (form.valid()) {
            error.hide();
            fnSiblingsValidation();
        }
        else {
            var message = "";
            message += "<b>Please correct below errors.</b>" + "<br/>" + "<ul>";
            $(".fa-warning").each(function (idx, va) {
                message += "<li>" + $(this).parent().find('.form-control, .form-radioErrorcontrol').data('val-required') + "</li>";
            });
            message += "</ul>"
            toastr.clear();
            toastr.options = {
                "positionClass": "toast-top-right",
                closeButton: true
            };
            var $toast = toastr['error'](message, '');
        }
    }

    // siblings and file validation
    function fnSiblingsValidation() {

        try {
            var MobileNo = $("#MobileNo").val().replace('_', '');
            if (MobileNo.length != 10) {
                $('#MobileNo').focus();
                throw "Please enter valid Mobile No";
            }

            var IsSiblings = $('.IsSiblings').filter(':checked').val();

            if (IsSiblings == "Yes") {

                if ($("#SiblingsName0").val() == "") {
                    $('#SiblingsName0').focus();
                    throw "Please enter Siblings Name";
                }
                if ($("#SiblingsAdmissionNo0").val() == "") {
                    $('#SiblingsAdmissionNo0').focus();
                    throw "Please enter Siblings AdmissionNo";
                }
                var SiblingsClass = $("#SiblingsClass0").val();

                if (SiblingsClass.length == "0") {
                    $('#SiblingsClass0').focus();
                    throw "Please Select Siblings Class";
                }
                var Section = $("#SiblingsSection0").val();

                if (Section.length == "0") {
                    $('#SiblingsSection0').focus();
                    throw "Please Select Siblings Section";
                }

            }

            
			
// if (grecaptcha.getResponse() == "") {
//throw "Please Select I'm Not Robot Captcha";
//}

            // Submit the form to post action
            $('#frmRegistration').submit();
        }
        catch (ExceptionMsg) {
            toastr.clear();
            toastr.options = {
                "positionClass": "toast-top-right",
                closeButton: true
            };
            var $toast = toastr['error'](ExceptionMsg, 'Registration');

        }

    }

</script>
<!--
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer> 
</script>-->

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
						2023 &copy; webexcel Technologies
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
