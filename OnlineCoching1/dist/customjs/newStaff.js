var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv"])

	app.filter('startFrom', function() {
		return function(input, start) {
			if(input) {
				start = +start; //parse to int
				return input.slice(start);
			}
			return [];
		}
	});

	app.filter('sumOfValue', function () {
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
	
	
	app.directive('ngFiles', ['$parse', function ($parse) {
    	function fn_link(scope, element, attrs) {
        	var onChange = $parse(attrs.ngFiles);
            element.on('change', function (event) {
            	onChange(scope, { $files: event.target.files });
            });
		};

		return {
			link: fn_link
		}
		
	}]);
	
    app.controller('studentsCtrl', ['$http', '$scope', '$timeout',  function ($http, $scope, $timeout) {
		// default values for pagination and filtering
		$scope.pageSize = 10;
		$scope.maxSize = 10;
		$scope.start = 0;
		$scope.end = 0;
		$scope.currentPage = 0;
		$scope.numOfPages = 5;
		$scope.filteredItems = [];
		$scope.startItems = [];
		$scope.pagedItems = [];
		$scope.data = null;
		$scope.query = {browser: ""};
		
		$scope.eStudent = {};
		$scope.dStudent = {};
		
		
		$scope.gender = [{key: "",	value: "Select Gender"}, {key: "Male", value: "Male"}, {key: "Female", value: "Female"}];
		$scope.types = [{key: "",	value: "Select Type"}, {key: "Teaching", value: "Teaching"}, {key: "Non-Teaching", value: "Non-Teaching"}];				
		
		$scope.changeAcademic = function() {
			$http.get('ajax/selectData/getAcademicyear.php')
			.success(function(response){
				console.log(response);
				$scope.academicname = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.changeAcademic();
		
		$scope.myFunc = function(YearId) {	
			var AcademicYearId = YearId;
			$http({
				method: "post",
				url: "ajax/selectData/getAcademicyearSession.php",
				data: {
					academic : AcademicYearId
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$window.location.href = "new-staff.php"; //You should have http here.
				console.log(response);
			}).error(function(response) {
				console.log(response);
			});			
		};
		
		
		
		
		
		$scope.getDepart = function() {
			$http.get('ajax/selectData/getDepartment.php')
			.success(function(response){
				$scope.depart = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getDepart();
		
		$scope.saveDepart = function(aStudent) {			
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insStaff.php",
					data: {
						aStudent: $scope.aStudent
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					$scope.response	= response;
					$scope.aStudent.name = "";
					$scope.aStudent.fatherName = "";
					$scope.aStudent.gender = "";
					$scope.aStudent.department = "";
					$scope.aStudent.qualification = "";
					$scope.aStudent.dob = "";
					$("#AdnoStudentModal").modal('show');
					//location.reload();
				}).error(function(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
	
		$scope.getAllStaff = function() {
			var request = $http({
				method: "POST",
				url: "ajax/selectData/getAllStaff.php",
				//data: { section: $scope.section },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (response) {
				$scope.students = response;
				$scope.list = response;
				$scope.currentPage = 1; //current page
				$scope.entryLimit = 10; //max no of items to display in a page
				$scope.filteredItems = $scope.list.length; //Initially for no filter  
				$scope.totalItems = $scope.list.length;				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}	
		$scope.getAllStaff();
/*		
		
		$scope.editStudent = function(es) {
			$scope.eStudent = {
				eCode : es.staff_code,
				eName : es.staff_name,
				eDept : es.department,
				eQuali : es.qualification
			};
			$("#studentEditForm").modal('show');
		};

		$scope.modalEmisNo	=	function() {
			$("#modalEmisNoUpload").modal('show');
		};
		

		$scope.updateStudent = function() {			
			$http({
				method: "post",
				url: "ajax/updateData/updateStaffAllData.php",
				data: {
					uStudent: $scope.eStudent
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#studentEditForm").modal('hide');
				$scope.getStudents();
			}).error(function(response) {
				console.log(response);
			});
		}
*/
		var formdata = new FormData();
		$scope.getTheFiles = function ($files) {
			angular.forEach($files, function (value, key) {
				formdata.append(key, value);
			});
		};				
		
		$scope.deleteStudent = function(ds) {
			$scope.dStudent = {
				dId: ds.ST_ID,
				dAdno : ds.ADMISSION_ID,
				dName : ds.NAME
			};
			$("#deleteStudentModal").modal('show');
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

		$scope.showDetail = function (u) {
			if ($scope.active != u.ADMISSION_ID) {
				$scope.active = u.ADMISSION_ID;
			} else {
				$scope.active = null;
			}
		};
		

}])



