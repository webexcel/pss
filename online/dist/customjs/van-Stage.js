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
	
    app.controller('studentsCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http,$scope, $timeout) {
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
					$window.location.href = "vehicle_stage.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
				
		}
		
		$scope.showSection = function() {
			$http.get('ajax/selectData/getRoutetype.php')
			.success(function(response){
				console.log(response);
				$scope.routetype = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.showSection();
		
		$scope.getStageMapping = function() {
			$http.get('ajax/selectData/getStageMapping.php')
			.success(function(response){
				console.log(response);
				$scope.getNewStages = response;
				$scope.list = response;
				$scope.currentPage = 1; //current page
				$scope.entryLimit = 10; //max no of items to display in a page
				$scope.filteredItems = $scope.list.length; //Initially for no filter  
				$scope.totalItems = $scope.list.length;	
				
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getStageMapping();
		
		$scope.save1 = function() {
			console.log($scope.newstage);
			if ($scope.myForm.$valid) {
				$http({
					method: 'POST',
					url: "ajax/insertData/insvanstage.php",					
					data: $scope.newstage,
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).then(function successCallback(response) {
					console.log(response)
					$scope.newstage.busRoute = "";
					$scope.newstage.stage = "";
					$scope.newstage.amount1 = "";
					$scope.newstage.amount2 = "";
					$scope.newstage.amount3 = "";
					location.reload();
					//$("#stageMappingModel").modal('hide');
				}, function errorCallback(response) {
					console.log(response);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}	
		};
		
		$scope.stageMapping = function() {
			$("#stageMappingModel").modal('show');
			$scope.getStageMapping();
		};
			
		$scope.stagedelete = function(id) {
			//alert(id);
			$scope.delid = id;
			$("#delmodal").modal('show');
			
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



