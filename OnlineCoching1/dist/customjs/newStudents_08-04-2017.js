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
		
		
		$scope.gender = [{key: "",	value: "Select Gender"}, {key: "Male", value: "Male"}, {key: "Female",	value: "Female"}];
		$scope.gender =  "";
		
		
  		$http.get("ajax/selectData/selType.php")
			.success(function(stuType){
				$scope.types = stuType;	
			})
			.error(function() {
				$scope.type = "error in fetching data";
			}
		);
		
		$http.get("ajax/selectData/sellang.php")
			.success(function(lang){
				$scope.lang = lang;
			})
			.error(function() {
				$scope.lang = "error in fetching data";
			}
		);

		$scope.saveStudent = function(aStudent) {
			
			if ($scope.myForm.$valid) {
			
				$http({
					method: "post",
					url: "ajax/insertData/insStudent.php",
					data: {
						aStudent: $scope.aStudent
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					console.log(response);
					$scope.getStudents();
					if(response.status == 1) {
						$scope.sAdno	=	response.message;
						$("#AdnoStudentModal").modal('show');
					} else {
						//$scope.msg	=	'New Student addition failled. Please try again...!';
						$scope.sAdno	=	'New Student addition failled. Please try again...!';
						$("#AdnoStudentModal").modal('show');
					}
					
					
				}).error(function(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
		
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
				console.log(response);
				$scope.classes = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
		
	
		$scope.getStudents = function() {
			var request = $http({
				method: "POST",
				url: "ajax/selectData/getAllStudent.php",
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
		
		$scope.editStudent = function(es) {
			$scope.eStudent = {
				eId: es.ST_ID,
				eOAdno : es.ADMISSION_ID,
				eNAdno : es.ADMISSION_ID,
				eEmisNo : es.EMIS_NO,
				eName : es.NAME,
				eFatherName : es.FATHER_NAME
			};
			$("#studentEditForm").modal('show');
		};
		
		$scope.modalEmisNo	=	function() {
			$("#modalEmisNoUpload").modal('show');
		};

		$scope.uploadEmisNo	=	function() {
			angular.element("input[type='text']").val(null);
			var request = {
				method: 'POST',
				url: "ajax/insertData/insEmisNoUpload.php",
				data: formdata,
				headers: {
					'Content-Type': undefined
				}
			};
		
			$http(request)
				.success(function (d) {
					console.log("Parasuraman M");
					console.log(d);			
					console.log("Muthaiyan N");
					$scope.EMISSuccess = {
						SUCCESS : d.SUCCESS,
						FAILURE : d.FAILURE
					};
					console.log($scope.EMISSuccess);
					$("#modalEmisNoUpload").modal('hide');
					$("#modalEmisNoUploadStatus").modal('show');
					
					$scope.getStudents();
				})
				.error(function () {
				
				});
	
		};
		
		$scope.updateStudent = function() {

			console.log($scope.eStudent);
			
			$http({
				method: "post",
				url: "ajax/updateData/updateStudentAllData.php",
				data: {
					uStudent: $scope.eStudent
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#studentEditForm").modal('hide');
				$scope.getStudents();
			}).error(function(response) {
				console.log(response);
			});
			
			
			/*
			$http({
				method: 'POST',
				url: "ajax/selectData/updateStudent.php",
				data: {
					uStudent: $scope.eStudent
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log(response);
			}, function errorCallback(response) {
				console.log(response);
			});
			*/
			
			/*$http({
				method: 'GET',
				url: '/someUrl'
			}).then(function successCallback(response) {
				
			}, function errorCallback(response) {
				
			});*/
			
			
		}
		
		
		var formdata = new FormData();
		$scope.getTheFiles = function ($files) {
			angular.forEach($files, function (value, key) {
				formdata.append(key, value);
			});
		};
		
		$scope.uploadFiles = function () {
			angular.element("input[type='text']").val(null);
			var request = {
				method: 'POST',
				url: "ajax/insertData/insStudentUpload.php",
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
		
		
		$scope.deleteStudent = function(ds) {
			$scope.dStudent = {
				dId: ds.ST_ID,
				dAdno : ds.ADMISSION_ID,
				dName : ds.NAME
			};
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.recpNo	=	function(rno) {
			while( rno.charAt( 0 ) === '#' )
    			rno = rno.slice( 1 );
			
			return parseInt(rno);
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
		
		$scope.balance = function(ta, pa) {
			return bal = parseInt(ta) - parseInt(pa);
		};
		

    }])



