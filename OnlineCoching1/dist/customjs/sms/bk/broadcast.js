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

		$scope.dStudent = {};

		
		$scope.sendBroadcast = function(aStudent) {			
			console.log($scope.aStudent);								
			$http({
				method: "post",
				url: "ajax/sms/sendBroadcast.php",
				data: { aStudent: $scope.aStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {					
				$scope.response	= response;	
				$scope.getBroadcast();			
			}).error(function(response) {
				console.log(response);
			});
			
		}
				
	
		$scope.getBroadcast = function() {
			var request = $http({
				method: "POST",
				url: "ajax/sms/getBroadcast.php",
				//data: $scope.data.section,
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (response) {
				//console.log(response);
				$scope.students = response;
				$scope.list = response;
				$scope.currentPage = 1; 
				$scope.entryLimit = 10; 
				$scope.filteredItems = $scope.list.length; 
				$scope.totalItems = $scope.list.length;				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}	
		$scope.getBroadcast();
			

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

    }])



