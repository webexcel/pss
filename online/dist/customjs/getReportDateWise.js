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
					$window.location.href = "fee-dashboard.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
			
		
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
		
		$scope.getCollection = function() {
			$http.get('ajax/selectData/getCollection.php')
			.success(function(response){
				$scope.collection = response
			}).error(function(err){
				console.log(err);
			});
		};
		$scope.getCollection();
		
		$scope.getCollection1 = function() {
			$http.get('ajax/selectData/getSectionCollection.php')
			.success(function(response){
				console.log(response);
				$scope.secCollection = response
			}).error(function(err){
				console.log(err);
			});
		};
		$scope.getCollection1();
		//////////////////////////////////
	
		
		////////////////////////////////////
		$scope.getReportDateWise	=	function() {
			
			var dateFrom	=	$scope.dateFrom;
			var dateTo		=	$scope.dateTo;
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnDateWise.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { dateFrom : dateFrom, dateTo : dateTo },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				console.log(response);
				$scope.gridOptions1.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	

			}).error(function(err){
				console.log(err);
			});
		}
		
		

		$scope.getReportDateWiseCon	=	function() {
			
			var dateFrom2	=	$scope.dateFrom2;
			var dateTo2		=	$scope.dateTo2;
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnDateWiseCon.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { dateFrom2 : dateFrom2, dateTo2 : dateTo2 },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				console.log(response);
				$scope.gridOptions2.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	

			}).error(function(err){
				console.log(err);
			});
		}



	

    }])



