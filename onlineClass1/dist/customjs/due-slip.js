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
	
    app.controller('defaultCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http, $scope, $timeout) {
		
		// default values for pagination and filtering
		$scope.active = true;
		$scope.active1 = true;
		$scope.selectedRow = null;
		$scope.currentPage = 1;
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
		
		$scope.pageChangeHandler = function(num) {
			console.log('page changed to ' + num);
		};
		
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
						$window.location.href = "due-slip.php"; //You should have http here.
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
		
		$scope.getPaidStudents = function() {
			var request = $http({
				method: "GET",
				url: "ajax/selectData/feeDefault.php?mode=paid",
				//data: $scope.data.section,
				/*data: { mode: 'paid' },*/
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (response) {
				console.log(response);
				$scope.paidStudents = response;
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
		$scope.getPaidStudents();
		
		
		$scope.confirmPayFees = function(user, FEE_DETAILS) {
			$scope.user = user;
			$scope.FEE_DETAILS = FEE_DETAILS;
			if($scope.SUBTOTAL > 0 ) {
				$scope.FEE_DETAILS.SUM_AMOUNT = $scope.SUBTOTAL;
			} else {
				$scope.FEE_DETAILS.SUM_AMOUNT = $scope.amtTotal();
			}
			
			$("#myModal").modal('show');

		}
		
		
		$scope.dueSlip1 = function(id) {
				
			var request = $http({
				method: "POST",
				url: "ajax/selectData/dueSlipNew.php",
				//data: $scope.data.section,
				data: { adno: id },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (response) {
				$scope.FEE_DETAILS = response;
				$("#dueModal1").modal('show');
				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});

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
		
		$scope.balance = function(ta, pa) {
			return bal = parseInt(ta) - parseInt(pa);
		};
    }])		
		
		
	app.controller('defaultCtrl2', ['$http', '$scope', '$timeout',  function ($http, $scope, $timeout) {
		
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
		
		$scope.getPaidStudents = function() {
			var request = $http({
				method: "GET",
				url: "ajax/selectData/feeDefault.php?mode=nonpaid",
				//data: $scope.data.section,
				/*data: { mode: 'paid' },*/
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (response) {
				console.log(response);
				$scope.nonPaidStudents = response;
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
		$scope.getPaidStudents();
		
		$scope.dueSlip2 = function(id) {
				
			var request = $http({
				method: "POST",
				url: "ajax/selectData/dueSlipNew.php",
				//data: $scope.data.section,
				data: { adno: id },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			/* Check whether the HTTP Request is Successfull or not. */
			request.success(function (response) {
				$scope.FEE_DETAILS = response;
				$("#dueModal2").modal('show');
				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});

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
		
		$scope.balance = function(ta, pa) {
			return bal = parseInt(ta) - parseInt(pa);
		};
		

    }])



