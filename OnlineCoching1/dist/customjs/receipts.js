var app = angular.module('ngApp', ['ui.bootstrap', 'angularUtils.directives.dirPagination', "ngSanitize", "ngCsv"])

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
	
    app.controller('receiptsCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http, $scope, $timeout) {
		
		$scope.names = [];
		$scope.names =	[
							{"fname": "PARASURAMAN 1", "lname": "MUTHAIYAN 1"},
							{"fname": "PARASURAMAN 2", "lname": "MUTHAIYAN 2"},
							{"fname": "PARASURAMAN 3", "lname": "MUTHAIYAN 3"},
							{"fname": "PARASURAMAN 4", "lname": "MUTHAIYAN 4"},
							{"fname": "PARASURAMAN 5", "lname": "MUTHAIYAN 5"}
						];
		
		console.log($scope.names);
		
		
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
					$window.location.href = "receipts.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
				
		}
		
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
				//console.log(response);
				$scope.classes = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
		
		
		
		/*$scope.currentPage = 1;
		$scope.pageSize = 10;*/
		
		$scope.getStudents = function() {
			var request = $http({
				method: "POST",
				url: "ajax/selectData/getReceipts.php",
				//data: $scope.data.section,
				data: { section: $scope.section },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (response) {
				console.log(response);
				$scope.students = response;
				$scope.list = response;
				$scope.currentPage = 1; //current page
				$scope.entryLimit = 10; //max no of items to display in a page
				$scope.filteredItems = $scope.list.length; //Initially for no filter  
				$scope.totalItems = $scope.list.length;
				console.log("Student Details: "+JSON.stringify($scope.students));
				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}	
		$scope.getStudents();
		
	
		$scope.recpNo	=	function(rno) {
			while( rno.charAt( 0 ) === '#' )
    			rno = rno.slice( 1 );
			
			return parseInt(rno);
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
		
		$scope.balance = function(ta, pa ,CON) {
			return bal = (parseInt(ta) - parseInt(CON) ) - parseInt(pa);
		};
		

    }])



