var fetch = angular.module('myApp', []);

		fetch.filter('startFrom', function() {
			return function(input, start) {
				if(input) {
					start = +start; //parse to int
					return input.slice(start);
				}
				return [];
			}
		});
		
		fetch.filter('sumOfValue', function () {
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
		
		fetch.directive('ngFiles', ['$parse', function ($parse) {
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


        fetch.controller('dbCtrl', ['$window','$location','$scope', '$http', 
			function ($window,$location, $scope, $http) {
			$scope.pageSize = 10;
			$scope.maxSize = 10;
			$scope.start = 0;
			$scope.end = 0;
			$scope.currentPage = 0;
			$scope.numOfPages = 5;
			$scope.filteredItems = [];
			$scope.startItems = [];
			$scope.pagedItems = [];
						
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
						$window.location.href = "vehicle_route.php"; //You should have http here.
						console.log(response);
					}).error(function(response) {
						console.log(response);
					});
					
			}

								
			//// ***** Route mapping ***///
			
			$scope.getRouteMapping = function() {
				$http.get('ajax/selectData/getRouteMapping.php')
				.success(function(response){
					console.log(response);
					$scope.getNewroute = response;
					//$scope.list = response;
					$scope.currentPage = 1; //current page
					$scope.entryLimit = 5; //max no of items to display in a page
					$scope.filteredItems = $scope.getNewroute.length; //Initially for no filter  
					$scope.totalItems = $scope.getNewroute.length;					
				}).error(function(err){
					console.log(err);
				});
			}
			$scope.getRouteMapping();
									
			$scope.save = function() {
				console.log($scope.newroute1);
				if ($scope.myForm.$valid) {	
					$http({
						method: 'POST',
						url: "ajax/insertData/insvanroute.php",					
						data: $scope.newroute1,
						headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
					}).then(function successCallback(response) {
						console.log(response)
						$scope.newroute1.route = "";
						location.reload();
						//$("#routeMappingModel").modal('hide');
					}, function errorCallback(response) {
						console.log(response);
					});				
				} else {
					alert("There are invalid fields");
					return false;	
				}
			};
			
			$scope.routeMapping = function() {
				$("#routeMappingModel").modal('show');
				$scope.getRouteMapping();
			};
			
			$scope.getRoutetype = function() {
				$http.get('ajax/selectData/getRoutetype.php')
				.success(function(response){
					console.log(response);
					$scope.routetype = response
				}).error(function(err){
					console.log(err);
				});
			}
			$scope.getRoutetype();
			
			
			$scope.routedelete = function(id) {
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
				}, 5);
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
	
}]);