var app = angular.module('ngApp', ['ui.bootstrap', 'dataGrid', 'pagination'])

    app.controller('studentsCtrl', ['$window','$location','$http', '$scope', '$timeout' ,function ($window,$location,$http, $scope,$timeout) {
	

		
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
					$window.location.href = "cash-datewise.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		};
			
		
		$scope.gridOptions1 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions1	=	{};
		
		$scope.gridOptions2 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions2	=	{};

		////////////////////////////////////
		$scope.getcashDateWise	=	function() {
			
			var dateFrom	=	$scope.dateFrom;
			var dateTo		=	$scope.dateTo;
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getcashDateWise.php',
				data	: { dateFrom : dateFrom, dateTo : dateTo },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			.success(function(response) {
				console.log(response);
				$scope.gridOptions1.data = response;
			}).error(function(err){
				console.log(err);
			});
		}

}])



