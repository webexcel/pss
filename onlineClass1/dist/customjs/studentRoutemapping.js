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
		
		/*$scope.eStudent = {};
		$scope.dStudent = {};*/
		$scope.adno = $location.search().adno;
		$scope.name = $location.search().name;
		$scope.classsec = $location.search().classsec;
		$scope.types = [{key: "",	value: "Select Type"}, {key: "Term1", value: "Term1"},{key: "Term2", value: "Term2"},{key: "Term3", value: "Term3"}];

		
		
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
				$window.location.href = "vehicle_student_mapping.php"; //You should have http here.
				console.log(response);
			}).error(function(response) {
				console.log(response);
			});
					
		}

		$scope.viewdetail = function(adno,classs,name){
			//alert(adno + classs + name);
			$window.location.href = "vehicle_payfee.php#?adno="+ adno +"&classsec="+ classs +"&name="+ name; //You should have http here.
		}
		

		
		$scope.getRoute = function() {
			$http.get('ajax/selectData/getRoute.php')
			.success(function(response){
				console.log(response);
				$scope.route = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getRoute();
		
		
				
		$scope.showSection = function() {
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
					
		}
		
		$scope.studentmapping = function() {
		console.log($scope.aroute.stageid)			
			if ($scope.myForm.$valid) {
				$scope.aroute.adno = $scope.adno;				
				$http({
					method: "post",
					url: "ajax/insertData/insvanstudentmapping.php",
					data: {
						aroute: $scope.aroute
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					console.log(response);
					$scope.response	= response;
					location.reload();
				}).error(function(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};

		$scope.getAllroute = function() {		
				console.log($scope.adno);
				$http({
					method: "post",
					url: "ajax/selectData/getAllroute.php",
					data: {
						adno: $scope.adno
					},
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					$scope.studmap = response;
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		$scope.getAllroute();


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



