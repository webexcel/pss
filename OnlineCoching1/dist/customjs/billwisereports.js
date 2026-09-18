var app = angular.module('ngApp', ['ui.bootstrap', 'dataGrid', 'pagination','angularUtils.directives.dirPagination'])
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
    app.controller('studentsCtrl', ['$window','$location','$http', '$scope', '$timeout', '$filter',  function ($window,$location,$http, $scope, $timeout, $filter) {
		
		
		$scope.active = true;
		$scope.active1 = true;
		$scope.selectedRow = null;
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		
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
						$window.location.href = "fee-dashboard.php"; //You should have http here.
						console.log(response);
					}).error(function(response) {
						console.log(response);
					});
				
			}
		
		$scope.getbillname = function() {
			$http.get('ajax/selectData/getBillname.php')
			.success(function(response){
				$scope.names = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getbillname();
		
		////////////////////////////////////
		$scope.getReportBillWise	=	function() {
			var billname	=	$scope.billname;
			var dateFrom	=	$scope.dateFrom;
			var dateTo		=	$scope.dateTo;
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnBillWise.php',
				data	: {billname : billname, dateFrom : dateFrom, dateTo : dateTo },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			.success(function(response) {
				console.log(response.result[0]);
				$scope.billnames = response;
			}).error(function(err){
				console.log(err);
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

		
	

    }])



