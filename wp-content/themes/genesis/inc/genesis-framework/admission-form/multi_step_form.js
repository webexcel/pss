$(document).ready(function () {
	var count = 0;
	$("#cnationality").change(function () {
		var cnationality = $(this).val();
		$(".child-label span").detach();
		if (cnationality != "IND" && cnationality != "") {
			$(".child-label").append("<span>*</span>");
		} else {
			$(".child-label span").detach();
		}
	});
	$("#currentClass").attr("disabled", "disabled");
	$("#applyGrade").change(function () {
		$("#currentClass").val($("#currentClass option:first").val());
		var getVal = $(this).val();
		var getSel = $(this).prop('selectedIndex');
		var length_of_options = $(this).find('option').length - 1;
		if (getVal != "") {
			$("#currentClass").removeAttr("disabled");
		}
		if (getVal == "") {
			$("#currentClass").attr("disabled", "disabled");
		}
		$("#currentClass option").each(function () {
			$(this).removeAttr("disabled", "disabled");
			$(this).removeClass("opt-disabled");
		});
		$("#currentClass option").each(function () {
			if ($(this).index() > getSel - 1) {
				$(this).attr("disabled", "disabled");
				$(this).addClass("opt-disabled");
			}
		});
	});
	$(".next_btn").click(function () {
		var error = 0;
		$('body').removeClass("invalid");
		$('body').removeClass("browse-invalid");
		$('body').find("span.err").detach();
		$('body').find("span.browse-err").detach();
		var get_current_fieldset = $(this).parent().attr("id");
		if (get_current_fieldset != "") {
			if (get_current_fieldset == "first") {
				var is_learnSupport = $('input[name=learnSupport]:checked').val();
				var studentname = $("#" + get_current_fieldset + " #studentname").val();
				var applyGrade = $("#" + get_current_fieldset + " #applyGrade").val();
				var Studentdob = $("#" + get_current_fieldset + " #Studentdob").val();
				var get_stu_nationality = $("#cnationality").val();
				var is_cbse = $('input[name=cbseAffliation]:checked').val();
				var whether_any_siblings = $('input[name=siblingGgs]:checked').val();
				var classSession = $(".classSession").val();
				var get_facility = $(".facility").val();
				if (classSession == "") {
					error = error + 1;
					$('.classSession').addClass("invalid");
					$('.classSession').parent().append("<span class='err'>This field is required</span>");
				}
				if (is_learnSupport == "Yes") {
					var learn = $(".learn").val();
					if (learn == "") {
						error = error + 1;
						$('.learn').addClass("invalid");
						$('.learn').parent().append("<span class='err'>This field is required</span>");
					}
				} else {
					$(".learn").val('');
				}
				if (get_facility == "") {
					error = error + 1;
					$('.facility').addClass("invalid");
					$('.facility').parent().append("<span class='err'>This field is required</span>");
					$(".local_gardution").css("display", "none");
				}
				if (get_facility != "" && get_facility != "7-day-hostel") {
					$(".local_gardution").css("display", "none");
				}
				if ((get_facility != "") && (get_facility == "7-day-hostel")) {
					$(".local_gardution").css("display", "block");
				}
				if (is_cbse == "No") {
					var name_of_board = $(".name-of-board").val();
					if (name_of_board == "") {
						error = error + 1;
						$('.name-of-board').addClass("invalid");
						$('.name-of-board').parent().append("<span class='err'>This field is required</span>");
					}
				}
				if (whether_any_siblings == "Yes") {
					var full_name_sib = $(".full-name-sib").val();
					var drop_studying = $(".drop-studying").val();
					if (full_name_sib == "") {
						error = error + 1;
						$('.full-name-sib').addClass("invalid");
						$('.full-name-sib').parent().append("<span class='err'>This field is required</span>");
					}
					if (drop_studying == "") {
						error = error + 1;
						$('.drop-studying').addClass("invalid");
						$('.drop-studying').parent().append("<span class='err'>This field is required</span>");
					}
				}
				if (studentname == "") {
					error = error + 1;
					$('#studentname').addClass("invalid");
					$('#studentname').parent().append("<span class='err'>This field is required</span>");
				}
				if (applyGrade == "") {
					error = error + 1;
					$('#applyGrade').addClass("invalid");
					$('#applyGrade').parent().append("<span class='err'>This field is required</span>");
				}
				if (Studentdob == "") {
					error = error + 1;
					$('#Studentdob').addClass("invalid");
					$('#Studentdob').parent().append("<span class='err'>This field is required</span>");
				}
				if (get_stu_nationality == "") {
					error = error + 1;
					$('#cnationality').addClass("invalid");
					$('#cnationality').parent().append("<span class='err'>This field is required</span>");
				}
				var applyGrade = $("#applyGrade").val();
				var gradeArray = ["Reception", "Nursery", "KG", "Grade1", "Grade2", "Grade3", "Grade4", "Grade5", "Grade6", "Grade7", "Grade8"];
				var prev_year_doc_Array = ["Grade2", "Grade3", "Grade4", "Grade5", "Grade6", "Grade7", "Grade8", "Grade9", "Grade10", "Grade11", "Grade12"];
				if ($.inArray(applyGrade, gradeArray) != -1) {
					$("#birthCert").css("display", "block");
				} else {
					$("#birthCert").css("display", "none");
				}
				if ($.inArray(applyGrade, prev_year_doc_Array) != -1) {
					$("#midtermReport").css("display", "block");
				} else {
					$("#midtermReport").css("display", "none");
				}
				if (error == 0) {
					$(this).parent().next().fadeIn('slow');
					$(this).parent().css({
						'display': 'none'
					});
					$('.current').next().addClass('current');
				} else {
					$('.globalErrMsg').find("span.err").detach();
					$('.globalErrMsg').append("<span class='err'>Please fill all the mandatory fields(*)</span>");
				}
			}
			if (get_current_fieldset == "second") {
				var motherName = $("#motherName").val();
				var motherDob = $("#motherDob").val();
				var motherOccupation = $("#motherOccupation").val();
				var motherPremanentAddress = $("#motherPremanentAddress").val();
				var motherPresentAddress = $("#motherPresentAddress").val();
				var motherMobileNo = $("#motherMobileNo").val();
				var fatherOfficeTel = $(".fatherOfficeTel").val();
				var motherOfficeTel = $(".motherOfficeTel").val();
				var localGuardianNumber = $(".localGuardianNumber").val();
				var motherEmail = $("#motherEmail").val();
				var fatherName = $("#fatherName").val();
				var fatherDOB = $("#fatherDOB").val();
				var fatherOccupation = $("#fatherOccupation").val();
				var fatherPremanentAddress = $("#fatherPremanentAddress").val();
				var fatherPresentAddress = $("#fatherPresentAddress").val();
				var fatherMobileNo = $("#fatherMobileNo").val();
				var fatherEmail = $("#fatherEmail").val();
				var get_fat_nationality = $("#pfnationality").val();
				var get_mot_nationality = $("#ppnationality").val();
				var get_facility = $(".facility").val();
				var localGuardianName = $(".localGuardianName").val();
				var localGuardianNumber = $(".localGuardianNumber").val();
				if (get_facility != "7-day-hostel") {
					$(".local_gardution").css("display", "none");
				}
				if (get_facility == "7-day-hostel") {
					$(".local_gardution").css("display", "block");
					if (localGuardianName == "") {
						error = error + 1;
						$('.localGuardianName').addClass("invalid");
						$('.localGuardianName').parent().append("<span class='err'>This field is required</span>");
					}
					if (localGuardianNumber == "") {
						error = error + 1;
						$('.localGuardianNumber').addClass("invalid");
						$('.localGuardianNumber').parent().append("<span class='err'>This field is required</span>");
					}
				} else {
					$('.localGuardianName').val('');
					$('.localGuardianNumber').val('');
				}
				if (motherName == "") {
					error = error + 1;
					$('#motherName').addClass("invalid");
					$('#motherName').parent().append("<span class='err'>This field is required</span>");
				}
				if (get_mot_nationality == "") {
					error = error + 1;
					$('#ppnationality').addClass("invalid");
					$('#ppnationality').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherDob == "") {
					error = error + 1;
					$('#motherDob').addClass("invalid");
					$('#motherDob').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherDob != "") {
					var day = motherDob.split('/')[0];
					var month = motherDob.split('/')[1];
					var year = motherDob.split('/')[2];
					var age = 20;
					var mydate = new Date();
					mydate.setFullYear(year, month - 1, day);
					var currdate = new Date();
					var setDate = new Date();
					setDate.setFullYear(mydate.getFullYear() + age, month - 1, day);
					if ((currdate - setDate) > 0) {} else {
						error = error + 1;
						$('#motherDob').addClass("invalid");
						$('#motherDob').parent().append("<span class='err'>Please check your age.</span>");
					}
				}
				if (motherOccupation == "") {
					error = error + 1;
					$('#motherOccupation').addClass("invalid");
					$('#motherOccupation').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherPremanentAddress == "") {
					error = error + 1;
					$('#motherPremanentAddress').addClass("invalid");
					$('#motherPremanentAddress').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherPresentAddress == "") {
					error = error + 1;
					$('#motherPresentAddress').addClass("invalid");
					$('#motherPresentAddress').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherMobileNo == "") {
					error = error + 1;
					$('#motherMobileNo').addClass("invalid");
					$('#motherMobileNo').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherMobileNo != "") {
					var is_name = motherMobileNo;
					if (is_name == "") {
						error = error + 1;
						$('#motherMobileNo').removeClass("invalid");
						$('#motherMobileNo').parent().find("span.err").detach();
						$('#motherMobileNo').addClass("invalid");
						$('#motherMobileNo').parent().append("<span class='err'>This field is required</span>");
					}
					if (is_name.length < 10 && is_name != "") {
						error = error + 1;
						$('#motherMobileNo').removeClass("invalid");
						$('#motherMobileNo').parent().find("span.err").detach();
						$('#motherMobileNo').addClass("invalid");
						$('#motherMobileNo').parent().append("<span class='err'>Please enter a valid contact number</span>");
					}
					if (is_name.length == 10) {
						$('#motherMobileNo').removeClass("invalid");
						$('#motherMobileNo').parent().find("span.err").detach();
					}
				}
				if (motherEmail == "") {
					error = error + 1;
					$('#motherEmail').addClass("invalid");
					$('#motherEmail').parent().append("<span class='err'>This field is required</span>");
				}
				if (motherEmail != "") {
					var re = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
					var is_email = re.test(motherEmail);
					if (!is_email) {
						error = error + 1;
						$('#motherEmail').addClass("invalid");
						$('#motherEmail').parent().append("<span class='err'>Please enter a valid email</span>");
					}
				}
				if (fatherName == "") {
					error = error + 1;
					$('#fatherName').addClass("invalid");
					$('#fatherName').parent().append("<span class='err'>This field is required</span>");
				}
				if (get_fat_nationality == "") {
					error = error + 1;
					$('#pfnationality').addClass("invalid");
					$('#pfnationality').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherDOB == "") {
					error = error + 1;
					$('#fatherDOB').addClass("invalid");
					$('#fatherDOB').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherDOB != "") {
					var day = fatherDOB.split('/')[0];
					var month = fatherDOB.split('/')[1];
					var year = fatherDOB.split('/')[2];
					var age = 20;
					var mydate = new Date();
					mydate.setFullYear(year, month - 1, day);
					var currdate = new Date();
					var setDate = new Date();
					setDate.setFullYear(mydate.getFullYear() + age, month - 1, day);
					if ((currdate - setDate) > 0) {} else {
						error = error + 1;
						$('#fatherDOB').addClass("invalid");
						$('#fatherDOB').parent().append("<span class='err'>Please check your age.</span>");
					}
				}
				if (fatherOccupation == "") {
					error = error + 1;
					$('#fatherOccupation').addClass("invalid");
					$('#fatherOccupation').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherPremanentAddress == "") {
					error = error + 1;
					$('#fatherPremanentAddress').addClass("invalid");
					$('#fatherPremanentAddress').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherPresentAddress == "") {
					error = error + 1;
					$('#fatherPresentAddress').addClass("invalid");
					$('#fatherPresentAddress').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherMobileNo == "") {
					error = error + 1;
					$('#fatherMobileNo').addClass("invalid");
					$('#fatherMobileNo').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherMobileNo != "") {
					var is_name = fatherMobileNo;
					if (is_name == "") {
						error = error + 1;
						$('#fatherMobileNo').removeClass("invalid");
						$('#fatherMobileNo').parent().find("span.err").detach();
						$('#fatherMobileNo').addClass("invalid");
						$('#fatherMobileNo').parent().append("<span class='err'>This field is required</span>");
					}
					if (is_name.length < 10 && is_name != "") {
						error = error + 1;
						$('#fatherMobileNo').removeClass("invalid");
						$('#fatherMobileNo').parent().find("span.err").detach();
						$('#fatherMobileNo').addClass("invalid");
						$('#fatherMobileNo').parent().append("<span class='err'>Please enter a valid contact number</span>");
					}
					if (is_name.length == 10) {
						$('#fatherMobileNo').removeClass("invalid");
						$('#fatherMobileNo').parent().find("span.err").detach();
					}
				}
				if (fatherEmail == "") {
					error = error + 1;
					$('#fatherEmail').addClass("invalid");
					$('#fatherEmail').parent().append("<span class='err'>This field is required</span>");
				}
				if (fatherEmail != "") {
					var re = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
					var is_email = re.test(fatherEmail);
					if (!is_email) {
						error = error + 1;
						$('#fatherEmail').addClass("invalid");
						$('#fatherEmail').parent().append("<span class='err'>Please enter a valid email</span>");
					}
				}
				if (error == 0) {
					$(this).parent().next().fadeIn('slow');
					$(this).parent().css({
						'display': 'none'
					});
					$('.current').next().addClass('current');
				} else {
					$('.globalErrMsg').find("span.err").detach();
					$('.globalErrMsg').append("<span class='err'>Please fill all the mandatory fields(*)</span>");
				}
			}
			if (get_current_fieldset == "third") {
				var file6 = $("#file6").val();
				var file10 = $("#file10").val();
				var file1 = $("#file1").val();
				var file4 = $("#file4").val();
				var file9 = $("#file9").val();
				var file13 = $("#file13").val();
				var cnationality = $("#cnationality").val();
				var ppnationality = $("#ppnationality").val();
				var pfnationality = $("#pfnationality").val();
				$(".child-label span").detach();
				if (cnationality != "IND" && cnationality != "") {
					$(".child-label").append("<span>*</span>");
					if (file4 == "") {
						error = error + 1;
						$('#file4').addClass("browse-invalid");
						$('#file4').parent().append("<span class='browse-err'>This field is required</span>");
					}
				} else {
					$(".child-label span").detach();
				}
				var file7 = $('#file7').val();
				if (file7 == "") {
					error = error + 1;
					$('#file7').addClass("browse-invalid");
					$('#file7').parent().append("<span class='browse-err'>This field is required</span>");
				}
				var file11 = $('#file11').val();
				if (file11 == "") {
					error = error + 1;
					$('#file11').addClass("browse-invalid");
					$('#file11').parent().append("<span class='browse-err'>This field is required</span>");
				}
				if (file1 == "") {
					error = error + 1;
					$('#file1').addClass("browse-invalid");
					$('#file1').parent().append("<span class='browse-err'>This field is required</span>");
				}
				if (file6 == "") {
					error = error + 1;
					$('#file6').addClass("browse-invalid");
					$('#file6').parent().append("<span class='browse-err'>This field is required</span>");
				}
				if (file10 == "") {
					error = error + 1;
					$('#file10').addClass("browse-invalid");
					$('#file10').parent().append("<span class='browse-err'>This field is required</span>");
				}
				var applyGrade = $("#applyGrade").val();
				var file3 = $("#file3").val();
				var file5 = $("#file5").val();
				var prev_year_doc_Array = ["Grade2", "Grade3", "Grade4", "Grade5", "Grade6", "Grade7", "Grade8", "Grade9", "Grade10", "Grade11", "Grade12"];
				if ($.inArray(applyGrade, prev_year_doc_Array) != -1) {
					$("#midtermReport").css("display", "block");
					if (file3 == "") {
						error = error + 1;
						$('#file3').addClass("browse-invalid");
						$('#file3').parent().append("<span class='browse-err'>This field is required</span>");
					}
					if (file5 == "") {
						error = error + 1;
						$('#file5').addClass("browse-invalid");
						$('#file5').parent().append("<span class='browse-err'>This field is required</span>");
					}
				} else {
					$("#midtermReport").css("display", "none");
				}
				var get_stu_nationality = $("#cnationality").val();
				var get_fat_nationality = $("#pfnationality").val();
				var get_mot_nationality = $("#ppnationality").val();
				var applyGrade = $("#applyGrade").val();
				var file2 = $("#file2").val();
				var gradeArray = ["Reception", "Nursery", "KG", "Grade1", "Grade2", "Grade3", "Grade4", "Grade5", "Grade6", "Grade7", "Grade8"]
				if ($.inArray(applyGrade, gradeArray) != -1) {
					$("#birthCert").css("display", "block");
					if (file2 == "") {
						error = error + 1;
						$('#file2').addClass("browse-invalid");
						$('#file2').parent().append("<span class='browse-err'>This field is required</span>");
					}
				} else {
					$("#birthCert").css("display", "none");
				}
				if (error == 0) {
					$(this).parent().next().fadeIn('slow');
					$(this).parent().css({
						'display': 'none'
					});
					$('.current').next().addClass('current');
				} else {
					$('.globalErrMsg').find("span.err").detach();
					$('.globalErrMsg').append("<span class='err'>Please fill all the mandatory fields(*)</span>");
				}
			}
		}
	});
	$('.localGuardianNumber').on('keypress keyup', function (eventxx) {
		var error = 0;
		var input = $(this);
		var is_name = input.val();
		if (is_name != '') {
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
			$(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((eventxx.which < 48 || eventxx.which > 57)) {
				if (eventxx.which != 8) {
					$(this).removeClass("invalid");
					$(this).parent().find("span.err").detach();
					$(this).addClass("invalid");
					$(this).parent().append("<span class='err'>Please enter a valid contact number</span>");
					eventxx.preventDefault();
					eventxx.preventDefault();
				}
			}
		}
	});
	$('.motherOfficeTel').on('keypress keyup', function (eventxx) {
		var error = 0;
		var input = $(this);
		var is_name = input.val();
		if (is_name != '') {
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
			$(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((eventxx.which < 48 || eventxx.which > 57)) {
				if (eventxx.which != 8) {
					$(this).removeClass("invalid");
					$(this).parent().find("span.err").detach();
					$(this).addClass("invalid");
					$(this).parent().append("<span class='err'>Please enter a valid contact number</span>");
					eventxx.preventDefault();
					eventxx.preventDefault();
				}
			}
		}
	});
	$('.fatherOfficeTel').on('keypress keyup', function (eventxx) {
		var error = 0;
		var input = $(this);
		var is_name = input.val();
		if (is_name != '') {
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
			$(this).val($(this).val().replace(/[^\d].+/, ""));
			if ((eventxx.which < 48 || eventxx.which > 57)) {
				if (eventxx.which != 8) {
					$(this).removeClass("invalid");
					$(this).parent().find("span.err").detach();
					$(this).addClass("invalid");
					$(this).parent().append("<span class='err'>Please enter a valid contact number</span>");
					eventxx.preventDefault();
					eventxx.preventDefault();
				}
			}
		}
	});
	$('#motherMobileNo , #fatherMobileNo, #phone').on('input', function () {
		var error = 0;
		var input = $(this);
		var is_name = input.val();
		if (is_name == "") {
			error = error + 1;
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
			input.addClass("invalid");
			input.parent().append("<span class='err'>This field is required</span>");
		}
		if (is_name.length < 10 && is_name != "") {
			error = error + 1;
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
			input.addClass("invalid");
			input.parent().append("<span class='err'>Please enter a valid contact number</span>");
		}
		if (is_name.length == 10) {
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
		}
		if (is_name != '') {
			input.removeClass("invalid");
			input.parent().find("span.err").detach();
			$("#motherMobileNo , #fatherMobileNo, #phone").on("keypress keyup blur", function (eventx) {
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if ((eventx.which < 48 || eventx.which > 57)) {
					if (eventx.which != 8) {
						$(this).removeClass("invalid");
						$(this).parent().find("span.err").detach();
						$(this).addClass("invalid");
						eventx.preventDefault();
						event.preventDefault();
					}
				} else {
					if (is_name.length < 10 && is_name != "") {
						error = error + 1;
						$(this).removeClass("invalid");
						$(this).parent().find("span.err").detach();
						$(this).addClass("invalid");
						$(this).parent().append("<span class='err'>Phone number seems invalid</span>");
					}
					if (is_name.length == 10) {
						$(this).removeClass("invalid");
						$(this).parent().find("span.err").detach();
					}
				}
			});
		}
	});
	$("#amount , #firstname , #email , #phone").keyup(function () {
		$("body").removeClass("invalid");
		$("body").find("span.err").detach();
		var amount = $('#amount').val();
		var firstname = $('#firstname').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		var error = 0;
		if (amount == "") {
			error = error + 1;
			$('#amount').addClass("invalid");
			$('#amount').parent().append("<span class='err'>This field is required</span>");
		}
		$('#amount').keypress(function (event) {
			$("body").removeClass("invalid");
			$("body").find("span.err").detach();
			if (event.which < 46 || event.which > 59) {
				if (event.which != 8) {
					event.preventDefault();
					error = error + 1;
					$('#amount').addClass("invalid");
					$('#amount').parent().append("<span class='err'>Please enter valid amount</span>");
					$("#amount").val('');
				}
			}
			if (event.which == 46 && $(this).val().indexOf('.') != -1) {
				event.preventDefault();
				error = error + 1;
				$('#amount').addClass("invalid");
				$('#amount').parent().append("<span class='err'>Please enter valid amount</span>");
			}
		});
		if (firstname == "") {
			error = error + 1;
			$('#firstname').addClass("invalid");
			$('#firstname').parent().append("<span class='err'>This field is required</span>");
		}
		if (email == "") {
			error = error + 1;
			$('#email').addClass("invalid");
			$('#email').parent().append("<span class='err'>This field is required</span>");
		}
		if (email != "") {
			var re = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
			var is_email = re.test(email);
			if (!is_email) {
				error = error + 1;
				$('#email').addClass("invalid");
				$('#email').parent().append("<span class='err'>Please enter a valid email</span>");
			}
		}
		if (phone == "") {
			error = error + 1;
			$('#phone').addClass("invalid");
			$('#phone').parent().append("<span class='err'>This field is required</span>");
		}
		if (phone != "") {
			var is_name = phone;
			if (is_name == "") {
				error = error + 1;
				$('#phone').removeClass("invalid");
				$('#phone').parent().find("span.err").detach();
				$('#phone').addClass("invalid");
				$('#phone').parent().append("<span class='err'>This field is required</span>");
			}
			if (is_name.length < 10 && is_name != "") {
				error = error + 1;
				$('#phone').removeClass("invalid");
				$('#phone').parent().find("span.err").detach();
				$('#phone').addClass("invalid");
				$('#phone').parent().append("<span class='err'>Please enter  a valid contact number</span>");
			}
			if (is_name.length == 10) {
				$('#phone').removeClass("invalid");
				$('#phone').parent().find("span.err").detach();
			}
		}
		if (error == 0) {
			$(".submit_btn").removeAttr("disabled");
			$(".submit_btn").removeClass("sub_blurr");
			$('.current').next().addClass('current');
		} else {
			$(".submit_btn").attr("disabled", "disabled");
			$(".submit_btn").addClass("sub_blurr");
		}
	});
	$(".pre_btn").click(function () {
		$(this).parent().prev().fadeIn('slow');
		$(this).parent().css({
			'display': 'none'
		});
		$('.current:last').removeClass('current');
	});
	$(".gen_radio_button input").click(function () {
		if ($(this).attr('id') == 'r5') {
			$('.specify_board').show();
		} else {
			$('.specify_board').hide();
		}
	});
	$(".learning_radio_button > input").click(function () {
		if ($(this).attr('id') == 'r7') {
			$('.yes-detail').show();
		} else {
			$('.yes-detail').hide();
		}
	});
	$(".sibling_radio_button input").click(function () {
		if ($(this).attr('id') == 'r10') {
			$('.siblings_info').show();
		} else {
			$('.siblings_info').hide();
		}
	});
	$('div[id*="Fstatus"]').html('<p class="img_loded successfull">Choose a file: <span class="load_status"><img  http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/upload.svg" class="img-responsive"></span></p>');
	$("#file1").change(function () {
		var Fsize = document.getElementById("file1").files[0].size;
		var Fname = document.getElementById("file1").files[0].name;
		if (Fsize / 1024 / 1024 <= 1) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file1").val("");
				$("#file1").addClass("browse-invalidx");
				$("#file1").val("");
				document.getElementById("Fstatus1").innerHTML = "";
				document.getElementById("Fstatus1").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus1").append("<span class='browse-err'>Please upload image only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus1").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus1").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file1").addClass("browse-invalidx");
					$("#Fstatus1").append("<span class='browse-err'>Please upload image only</span>");
				}
			}
		} else {
			$("#file1").val("");
			document.getElementById("Fstatus1").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file1").addClass("browse-invalidx");
			$("#Fstatus1").append("<span class='browse-err'>Please upload image less than 1Mb</span>");
		}
	});
	$("#file2").change(function () {
		var Fsize = document.getElementById("file2").files[0].size;
		var Fname = document.getElementById("file2").files[0].name;
		if (Fsize / 1024 / 1024 <= 2) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file2").val("");
				$("#file2").addClass("browse-invalidx");
				$("#file2").val("");
				document.getElementById("Fstatus2").innerHTML = "";
				document.getElementById("Fstatus2").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus2").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus2").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus2").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file2").addClass("browse-invalidx");
					$("#Fstatus2").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
				}
			}
		} else {
			$("#file2").val("");
			document.getElementById("Fstatus2").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file2").addClass("browse-invalidx");
			$("#Fstatus2").append("<span class='browse-err'>Please upload file less than 2 MB</span>");
		}
	});
	$("#file3").change(function () {
		var Fsize = document.getElementById("file3").files[0].size;
		var Fname = document.getElementById("file3").files[0].name;
		if (Fsize / 1024 / 1024 <= 2) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file3").val("");
				$("#file3").addClass("browse-invalidx");
				$("#file3").val("");
				document.getElementById("Fstatus3").innerHTML = "";
				document.getElementById("Fstatus3").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus3").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus3").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus3").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file3").addClass("browse-invalidx");
					$("#Fstatus3").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
				}
			}
		} else {
			$("#file3").val("");
			document.getElementById("Fstatus3").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file3").addClass("browse-invalidx");
			$("#Fstatus3").append("<span class='browse-err'>Please upload file less than 2 MB</span>");
		}
	});
	$("#file4").change(function () {
		var Fsize = document.getElementById("file4").files[0].size;
		var Fname = document.getElementById("file4").files[0].name;
		if (Fsize / 1024 / 1024 <= 2) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file4").val("");
				$("#file4").addClass("browse-invalidx");
				$("#file4").val("");
				document.getElementById("Fstatus4").innerHTML = "";
				document.getElementById("Fstatus4").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus4").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus4").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus4").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file4").addClass("browse-invalidx");
					$("#Fstatus4").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
				}
			}
		} else {
			$("#file4").val("");
			document.getElementById("Fstatus4").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file4").addClass("browse-invalidx");
			$("#Fstatus4").append("<span class='browse-err'>Please upload file less than 2 MB</span>");
		}
	});
	$("#file5").change(function () {
		var Fsize = document.getElementById("file5").files[0].size;
		var Fname = document.getElementById("file5").files[0].name;
		if (Fsize / 1024 / 1024 <= 2) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file5").val("");
				$("#file5").addClass("browse-invalidx");
				$("#file5").val("");
				document.getElementById("Fstatus5").innerHTML = "";
				document.getElementById("Fstatus5").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus5").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus5").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus5").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file5").addClass("browse-invalidx");
					$("#Fstatus5").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
				}
			}
		} else {
			$("#file5").val("");
			document.getElementById("Fstatus5").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file5").addClass("browse-invalidx");
			$("#Fstatus5").append("<span class='browse-err'>Please upload file less than 2 MB</span>");
		}
	});
	$("#file6").change(function () {
		var Fsize = document.getElementById("file6").files[0].size;
		var Fname = document.getElementById("file6").files[0].name;
		if (Fsize / 1024 / 1024 <= 1) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file6").val("");
				$("#file6").addClass("browse-invalidx");
				$("#file6").val("");
				document.getElementById("Fstatus6").innerHTML = "";
				document.getElementById("Fstatus6").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus6").append("<span class='browse-err'>Please upload image only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus6").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus6").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file6").addClass("browse-invalidx");
					$("#Fstatus6").append("<span class='browse-err'>Please upload image only</span>");
				}
			}
		} else {
			$("#file6").val("");
			document.getElementById("Fstatus6").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file6").addClass("browse-invalidx");
			$("#Fstatus6").append("<span class='browse-err'>Please upload image less than 1 MB</span>");
		}
	});
	$("#file7").change(function () {
		var Fsize = document.getElementById("file7").files[0].size;
		var Fname = document.getElementById("file7").files[0].name;
		if (Fsize / 1024 / 1024 <= 2) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file7").val("");
				$("#file7").addClass("browse-invalidx");
				$("#file7").val("");
				document.getElementById("Fstatus7").innerHTML = "";
				document.getElementById("Fstatus7").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus7").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus7").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus7").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file7").addClass("browse-invalidx");
					$("#Fstatus7").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
				}
			}
		} else {
			$("#file7").val("");
			document.getElementById("Fstatus7").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file7").addClass("browse-invalidx");
			$("#Fstatus7").append("<span class='browse-err'>Please upload file less than 2 MB</span>");
		}
	});
	$("#file10").change(function () {
		var Fsize = document.getElementById("file10").files[0].size;
		var Fname = document.getElementById("file10").files[0].name;
		if (Fsize / 1024 / 1024 <= 1) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["jpg", "jpeg", "png", "bmp", "gif"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file10").val("");
				$("#file10").addClass("browse-invalidx");
				$("#file10").val("");
				document.getElementById("Fstatus10").innerHTML = "";
				document.getElementById("Fstatus10").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus10").append("<span class='browse-err'>Please upload image only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus10").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus10").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file10").addClass("browse-invalid");
					$("#Fstatus10").append("<span class='browse-err'>Please upload image only</span>");
				}
			}
		} else {
			$("#file10").val("");
			document.getElementById("Fstatus10").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file10").addClass("browse-invalid");
			$("#Fstatus10").append("<span class='browse-err'>Please upload image less than 1 MB</span>");
		}
	});
	$("#file11").change(function () {
		var Fsize = document.getElementById("file11").files[0].size;
		var Fname = document.getElementById("file11").files[0].name;
		if (Fsize / 1024 / 1024 <= 2) {
			var error = 0;
			var file = Fname;
			var ext = file.split(".");
			ext = ext[ext.length - 1].toLowerCase();
			var arrayExtensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
			if (arrayExtensions.lastIndexOf(ext) == -1) {
				error = error + 1;
				$("#file11").val("");
				$("#file11").addClass("browse-invalidx");
				$("#file11").val("");
				document.getElementById("Fstatus11").innerHTML = "";
				document.getElementById("Fstatus11").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
				$("#Fstatus11").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
			} else {
				if (Fsize != 0) {
					document.getElementById("Fstatus11").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Upload Successful<span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/success.png' class='img-responsive'></span></p>";
				} else {
					document.getElementById("Fstatus11").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
					error = error + 1;
					$("#file11").addClass("browse-invalidx");
					$("#Fstatus11").append("<span class='browse-err'>Please upload pdf/jpg/jpeg only</span>");
				}
			}
		} else {
			$("#file11").val("");
			document.getElementById("Fstatus11").innerHTML = "<p class='img_type'>" + Fname + "</p><p class='img_loded successfull'>Choose a file: <span class='load_status'><img  src='http://www.genesisglobalschool.edu.in/wp-content/themes/genesis/inc/genesis-framework/admission-form/images/upload.svg' class='img-responsive'></span></p>";
			error = error + 1;
			$("#file11").addClass("browse-invalidx");
			$("#Fstatus11").append("<span class='browse-err'>Please upload file less than 2 MB</span>");
		}
	});
	$(".form-control").hover(function () {
		$(this).parent().find("span.err").detach();
		$(this).removeClass("invalid");
	});
	$(".browse").hover(function () {
		$(this).parent().find("span.browse-err").detach();
		$(this).removeClass("browse-invalid");
	});
});
$(function () {
	$('#regform .pre_btn, #regform .next_btn').click(function () {
		if ($('.form-control').hasClass('invalid')) {
			$('body,html').animate({
				scrollTop: $('.form-control.invalid').first().offset().top - 340
			}, 800);
		} else {
			$('body,html').animate({
				scrollTop: 340
			}, 800);
		}
	});
});