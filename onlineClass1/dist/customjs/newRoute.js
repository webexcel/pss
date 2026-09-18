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
	
    app.controller('studentsCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location, $http, $scope, $timeout) {
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
		$scope.adno = $location.search().adno;
		$scope.name = $location.search().name;
		$scope.bal=0;
		$scope.classsec = $location.search().classsec;
		$scope.types = [{key: "",	value: "Select Type"}, {key: "Term1", value: "Term1"},{key: "Term2", value: "Term2"},{key: "Term3", value: "Term3"}];

		$http.get("ajax/selectData/sellang.php")
			.success(function(lang){
				$scope.lang = lang;
			})
			.error(function() {
				$scope.lang = "error in fetching data";
			}
		);
		
		
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
					$window.location.href = "vehicle_payfee.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		
		$scope.getAllroute = function() {		
				console.log($scope.adno);
				
				$http({
					method: "post",
					url: "ajax/selectData/getAllroute.php",
					data: { adno: $scope.adno },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					$scope.studmap = response;
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		$scope.getAllroute();
		
		
		$scope.getvanTransection = function() {		
				console.log($scope.adno);
				$http({
					method: "post",
					url: "ajax/selectData/getvanTransection.php",
					data: { aroute: $scope.adno },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					$scope.transection = response;
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		$scope.getvanTransection();
		
		
		$scope.payvanfee = function(aroute) {
			var amt = parseInt($scope.aroute.amount);
			var tot = parseInt(document.getElementById("tot_amt").value);
				//alert($tot);
				 
				if(tot >= amt && amt >0)
				{
					alert("Do You Want to Pay Amount!");
				}	
				else{
					alert("Please Enter Valid Amount!");
					return false;
				}
				
				
			if ($scope.myForm.$valid) {
				
				$scope.aroute.adno = $scope.adno;
				$scope.aroute.name = $scope.name;
				$scope.aroute.classsec = $scope.classsec;
				
				$http({
					method: "post",
					url: "ajax/insertData/insvanpayfee.php",
					data: {
						aroute: $scope.aroute
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					console.log(response);
					location.reload();
				}).error(function(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
		
		/*$scope.getRoute = function() {
			$http.get('ajax/selectData/getRoute.php')
			.success(function(response){
				console.log(response);
				$scope.route = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getRoute();*/
		
		
				
		/*$scope.showSection = function() {
			console.log($scope.busRoute);
			$http({
				method: "post",
				url: "ajax/selectData/selStage.php",
				
				data: {
					busRoute: $scope.aroute.busRoute,
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				
			}).success(function(response) {
				$scope.busStage = response;
				console.log(response);
			}).error(function(response) {
					console.log(response);
				});
					
		}*/
		
		/*$scope.payvanfee = function(aroute) {			
			if ($scope.myForm.$valid) {
				$scope.aroute.adno = $scope.adno;
				$scope.aroute.name = $scope.name;
				$scope.aroute.classsec = $scope.classsec;
				$http({
					method: "post",
					url: "ajax/insertData/insvanfee.php",
					data: {
						aroute: $scope.aroute
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					console.log(response);
					
					$scope.response	= response;
					$scope.aroute.adno = "";
					$scope.aroute.classs = "";
					$scope.aroute.name = "";
					$scope.aroute.route_name = "";
					$scope.aroute.stage_name = "";
					$scope.aroute.type = "";
					$scope.aroute.amount = "";
					$scope.aroute.date = "";
					$scope.getvanfee();
					
				}).error(function(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};*/


		/*$scope.saveStudent = function(aStudent) {
			
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
		};*/
		
		
		
		
		
		/*$scope.getAllroute = function() {
			console.log($scope.adno);
			$http.get('ajax/selectData/getAllroute.php')
			.success(function(response){
				console.log(response);
				$scope.Allroute = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getAllroute();*/
		
	
		
		/*$scope.confirmDeleteStudent = function() {
			$http({
				method: "post",
				url: "ajax/deleteData/deleteStudent.php",
				data: {
					dStudent: $scope.dStudent.dAdno
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#deleteStudentModal").modal('hide');
				$scope.getStudents();
			}).error(function(response) {
				console.log(response);
			});				
		}*/
		
		
		
		
	var formdata = new FormData();
		$scope.getTheFiles = function ($files) {
			angular.forEach($files, function (value, key) {
				formdata.append(key, value);
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
		
		$scope.balance = function(ta, pa) {
			return bal = parseInt(ta) - parseInt(pa);
		};
		
		
		

    }])



