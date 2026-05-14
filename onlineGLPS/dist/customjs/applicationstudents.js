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

	
    app.controller('applicationCtrl', ['$http', '$scope', '$timeout',  function ($http, $scope, $timeout) {
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
		

		$scope.saveStudent = function(aStudent) {
			
			if ($scope.myForm.$valid) {
			
				$http({
					method: "post",
					url: "ajax/insertData/newapplication.php",
					data: {
						aStudent: $scope.aStudent
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					console.log(response);
					
					$scope.response	=	response;
					$scope.aStudent.name = "";
					$scope.aStudent.fatherName = "";
					$scope.aStudent.classId = "";
					$scope.aStudent.type = "";
					$scope.aStudent.secondlanguage = "";
					$scope.aStudent.dob = "";
					
					$("#AdnoStudentModal").modal('show');
					$scope.getStudents();
					
				}).error(function(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
		
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClassapplication.php')
			.success(function(response){
				console.log(response);
				$scope.classes = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
		
		$scope.update = function(){
			for(var i=0 ; i< $scope.classes.length; i++)
			{
				if($scope.classes[i].class_id =$scope.aStudent.classId )
				{
					$scope.aStudent.amount = $scope.classes[i].amount;
					$scope.aStudent.class_name = $scope.classes[i].class_name;
				}				
			
			}
			
		 };

		$scope.getStudents = function() {
			var request = $http({
				method: "POST",
				url: "ajax/selectData/getallapplication.php",
				//data: $scope.data.section,
				data: { section: $scope.section },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (response) {
				//console.log(response);
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
		$scope.getStudents();		
		var formdata = new FormData();		
		$scope.uploadFiles = function () {
			angular.element("input[type='text']").val(null);
			var request = {
				method: 'POST',
				url: "ajax/insertData/newapplication.php",
				data: formdata,
				headers: {
					'Content-Type': undefined
				}
			};
		
			$http(request)
				.success(function (d) {
					console.log(d);			   
					$scope.bSuccess = {
						SUCCESS : d.SUCCESS,
						FAILURE : d.FAILURE
					};
					$("#bulkUploadStatusModal").modal('show');
					$scope.getStudents();
				})
				.error(function () {
				
				});
		};
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