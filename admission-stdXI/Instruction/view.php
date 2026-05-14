<?php 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
    <!-- BEGIN HEADER -->
    <div class="page-header">
        <!-- BEGIN HEADER TOP -->
        <div class="page-header-top2 header-height">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-9 col-xs-9 ">
                        <div class="right-heading">
							 <span>P.S.Senior Secondary School</span>                         
                         </div>
                    </div>
					 
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                        <div class="right-heading">
							<span>ONLINE</span>
							<span>APPLICATION</span>
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
    <div class="page-container">
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

<style>
    .action-box {
        display: flex;
        justify-content: flex-end; /* align to right */
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        padding-right: 10px; /* space from right */
    }

    .status {
        padding: 6px 12px;
        border: 1px solid #888;
        border-radius: 5px;
        font-size: 14px;
    }

    .btn-submit {
        padding: 6px 16px;
        font-size: 14px;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }
</style>


	<div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div id="sticky-anchor"></div>

						<div class="container">
							<div class="row">
								<div class="col-md-12 text-right">
								<table  class="datatable table table-hover table-bordered">
									<thead> 
										<tr>
											<th>CLASS</th>
											<th>Download</th>
										</tr>
									</thead>																	
									<tbody style="border-top:#585454;">										
										<tr>
											<td style="text-align:center"><b>Full Database</b></td>	 
											<td style="text-align:center"><a href="full-db.php" alt="home" target="_blank" class="btn btn-primary">Download</a></td>
										</tr>			
									</tbody>   
									</table>
								</div>
							</div>
							
							<div class="row">   						
								<table  class="datatable table table-hover table-bordered">
									<thead> 
										<tr>
											<th>Class</th>
											<th>Total</th>
											<th>Select Count</th>
											<th>Wait Count</th>
											<th>submit Count</th>
											<th>Moved Schooltree</th>
										</tr>
									</thead>
									<tbody style="border-top:#585454;">	
									<?php 
									$result = mysqli_query($dbconnect,"SELECT CONCAT( `applied` ) AS applied, COUNT( `applied` ) AS total,
									count(CASE WHEN `sel_list` = 1 THEN 1 END) as selected, 
									count(CASE WHEN `sel_list` = 3 THEN 1 END) as Wait, 
									count(CASE WHEN `form_sub` = 'Y' THEN 1 END) as fsubmit,
									count(CASE WHEN `sel_list` = 2 THEN 1 END) as moved FROM `application_xi` GROUP BY `applied`");
									while($row 	= mysqli_fetch_assoc($result))
									{
										$name 	= $row['applied'];
										$total  = $row['total'];
										$selected  = $row['selected'];
										$wait  = $row['Wait'];
										$moved  = $row['moved'];
									?>
									
										<tr>
											
											<td> <?php echo $name; ?> </td>	 
											<td> <?php echo $total; ?> </td>
											<td> <?php echo $selected; ?> </td>
											<td> <?php echo $wait; ?> </td>
											<td> <?php echo $row['fsubmit']; ?> </td>
											<td> <?php echo $moved; ?> </td>
										</tr>
									<?php  
									}
									?>				
									 </tbody>   
								</table>
							</div>
                            
                            <div class="action-box">
                                <select class="status" id="status">
                                    <option value="">select option</option>
                                    <option value="1">Selected</option>
                                    <option value="3">Wait</option>
                                    <option value="4">Call Interview</option>
                                    <option value="0">Not Select</option>
                                </select>

                                <button type="button" class="btn-submit" onclick="submitAll()">Submit All</button>
                            </div>


                                
							<div class="row">   						
								<table  class="datatable table table-hover table-bordered">
									<thead> 
										<tr>
											<th>SNo</th>
											<th>AppNo</th>
											<th>Applied</th>
											<th>Name</th>
											<th>Dob</th>
											<th>Father name</th>													
											<th>Download</th>	
											<th>Type</th>
                                            <th>Date</th>
											<th>Apply</th>	
											<th>Form Submit</th>	
											<th>Submit Date</th>										
										</tr>
									</thead>
									<tbody style="border-top:#585454;">	
										<?php 
										
										$countrow = 1;
										$result = mysqli_query($dbconnect,"select * from application_xi where status = '0'");
										while($row = mysqli_fetch_assoc($result))
										  {
											$id           = $row['id'];
											$fno          = $row['fno'];
											$name         = $row['name'];
											$originalDate = $row['dob'];
											$dob  		  = date("d-m-Y", strtotime($originalDate));
											$fname	  	  = $row['fname'];
											$addressP	  = $row['addressP'];
											$contact	  = $row['contact'];											
											$group        = $row['applied'];
											$photo        = $row['photo'];
											$fphoto       = $row['fphoto'];
											$adno         = $row['adno1'];
											$sel_list	  = $row['sel_list'];
                                            $sel_date	  = $row['sel_date'];
											$form_date	  = $row['form_date'];
											if($sel_list == 1){
												$sel_list1 = 'Selected';
											}elseif($sel_list == 2){
												$sel_list1 = 'Completed';
											}elseif($sel_list == 3){
												$sel_list1 = 'Wait List';
											}elseif($sel_list == 4){
												$sel_list1 = 'Call Interview';
											}else{
												$sel_list1 = 'Not Selected';
											}
											$fsubmit	  = $row['form_sub'];											
										   ?>
										   <tr>
												<td> <?php echo $countrow++; ?> </td>
												<td> <?php echo $fno; ?> </td>
												<td> <?php echo $group; ?> </td>												
												<td> <?php echo $name; ?> </td>
												<td> <?php echo $dob; ?> </td>
												<td> <?php echo $fname; ?> </td>
												<td>
													<a target = "_blank" href="bills/pss.php?r=<?php echo $id; ?>">Download</a>
												</td>
												<td> <?php echo $sel_list1; ?> </td>
                                                <td> <?php echo $sel_date; ?> </td>
                                                <td><input type="checkbox" class="chk" data-id="<?php echo $id; ?>"></td>
												
                                                <!--<td>
													<form action="selectlist.php" method="post">
														<select name="sel" id="sel">
															<option value="">Options</option>
															<option value="1">Selected</option>
															<option value="3">Waitlist</option>
															<option value="0">Not Select</option>
														</select>
														<input type="hidden" id="idsel" name="idsel" value="<?php echo $id; ?>">
														<input type="submit" value="submit">
													</form>
												</td>-->
												 <td>
													<?php echo $fsubmit; ?>
													<button class="status-btn" 
													data-id="<?php echo $id; ?>"  
													data-status="Y" <?php echo ($fsubmit == 'Y') ? 'disabled' : ''; ?> >Active</button>
												</td>
												<style>
												.status-btn[disabled] {
												  background-color: #ccc;
												  cursor: not-allowed;
												  opacity: 0.6;
												}
												
												</style>
												<td> <?php echo $form_date; ?> </td>
											</tr>
										<?php  
										}
										?> 
								
										 
									 </tbody>   
								</table>
								
						

							</div><!--/.row-->
						</div><!--/.container-->
                       
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
						2020 &copy; webexcel Technologies
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

<!-- jQuery & Bootstrap JS (if not already included)-->

<script type="text/javascript" language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>	
	<script src="//cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
	<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
	
	
	
	
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


<script type="text/javascript">

    var dataTable = $('.datatable').DataTable({
            buttons: [
            {
                extend: 'excel',
                text: 'Export to Excel',
                className: 'btn-sm btn-flat',
            },
            ],
            dom: "<'row'<'col-md-3'l><'col-md-6 text-center'B><'col-md-3'f>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
            drawCallback: function(settings) {
            if (!$('.datatable').parent().hasClass('table-responsive')) {
                $('.datatable').wrap("<div class='table-responsive'></div>");
            }
            }
        });

        dataTable.columns().every(function() {
            var column = this;

            $('.filter-column', this.footer()).on('keyup change', function() {
            if (column.search() !== this.value) {
                column
                .search(this.value)
                .draw();
                this.focus();
            }
            });
        });
			
</script>	
        <!--	
		<script type="text/javascript">		
			function showappid(rowid){								
				$("#exampleModal").modal('show');
				var catval = rowid;
				$("#hiddencat").val(catval);
				}							
		</script>
		-->


<script>
    $(document).ready(function () {
        // Delegate the click event to the table for dynamically created buttons
        $('table').on('click', '.status-btn', function () {
            let button = $(this);
            let status = button.data('status'); // Current status
            let id = button.data('id');         // Associated ID

            // Make an AJAX request
            $.ajax({
                url: 'form_status.php', // PHP script to handle the request
                type: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function (response) {
                    let parsedResponse = JSON.parse(response);
                    if (parsedResponse.new_status) {
                        let newStatus = parsedResponse.new_status === 'N' ? 'inactive' : 'Y';
                        button.data('status', newStatus);
                        button.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                    } else {
                        alert('Failed to update status');
                    }
                },
                error: function () {
                    alert('Error occurred while changing status');
                }
            });
        });
    });
</script>


<script>
function submitAll() {
    const sel = document.getElementById('status').value;

    // 1. Collect all checked checkboxes
    const checked = document.querySelectorAll('.chk:checked');
    const ids = [];

    checked.forEach(cb => {
        // IMPORTANT: use data-id, not value
        const id = cb.getAttribute('data-id'); // or cb.dataset.id
        if (id) {
            ids.push(id);
        }
    });

    console.log("Selected IDs:", ids); // debug

    if (ids.length === 0) {
        alert("Please select at least one application.");
        return;
    }

    // 2. Confirm before update
    if (!confirm("Update status for " + ids.length + " application(s)?")) {
        return;
    }

    // 3. Send to select.php via AJAX
    const formData = new FormData();
    formData.append('sel', sel);

    // send as idsel[]
    ids.forEach(id => formData.append('idsel[]', id));


    fetch('selectlist.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(text => {
        alert("Server response: " + text); // see what PHP sends
        // if OK, redirect or reload
        if (text.indexOf("OK") !== -1) {
            window.location.href = "view.php";
        }
    })
    .catch(err => {
        alert("Error: " + err);
    });
}
</script>

 <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>