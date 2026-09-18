angular.module('demoApp', ['ui.bootstrap', 'dataGrid', 'pagination','angularUtils.directives.dirPagination'])
    .controller('demoCtrl', ['$window','$location','$http','$scope', function ($window,$location,$http,$scope) {
		
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		
		$scope.pageChangeHandler = function(num) {
			console.log('page changed to ' + num);
		};

		$scope.data = {};
		
		
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
						$window.location.href = "fee-reports.php"; //You should have http here.
						console.log(response);
					}).error(function(response) {
						console.log(response);
					});
				
		}	
		

		$scope.getFeeHeads = function() {
			$http.get('ajax/selectData/getFeeHead.php')
			.success(function(response){
				$scope.data = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getFeeHeads();
		
		$scope.selection=[];
		$scope.toggleSelection = function toggleSelection(employeeName) {
			var idx = $scope.selection.indexOf(employeeName);
			if (idx > -1) {
			  $scope.selection.splice(idx, 1);
			}
			else {
			  $scope.selection.push(employeeName);
			}
		};
		
		$scope.getFeeHeadReport	=	function() {
			
			var dateFrom	=	$scope.dateFrom;
			var dateTo		=	$scope.dateTo;
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnFeeHead.php',
				data	: {dateFrom : dateFrom, dateTo : dateTo , headId : $scope.selection },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			.success(function(response) {
				console.log(response);
				$scope.headtype = response
			}).error(function(response) {
				console.log(response);
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



