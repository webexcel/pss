var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv", "xeditable"])

	app.controller('voucherCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http, $scope, $timeout) {
		
		
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
						$window.location.href = "cash.php"; //You should have http here.
						console.log(response);
					}).error(function(response) {
						console.log(response);
					});
				
			}
		
			$scope.saveVoucher = function() {
				if ($scope.myForm.$valid) {	
					$http({
						method: 'POST',
						url: "ajax/insertData/insert-cashvoucher.php",
						data: { voucher: $scope.voucher },
						//headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
						headers: { 'Content-Type': 'application/json' }
						
					}).then(function successCallback(response) {
						console.log(response);				
						$scope.response	=	response;
						location.reload();					
						$scope.getVoucher();
					}, function errorCallback(response) {
						console.log(response);
					});
				} else {
					alert("There are invalid fields");
					return false;	
				}
			};
				
			$scope.getVoucher = function() {
				$http({
					method: 'GET',
					url: 'ajax/selectData/getVoucher.php'
				}).then(function successCallback(response) {
					console.log(response);
					$scope.Vouchers = response.data;
					//$scope.Vouchers = response.data;				
					//$scope.totalItems = $scope.Voucher;
					$scope.page = 1;
				}, function errorCallback(response) {
					console.log(response);
				});			
			}
			$scope.getVoucher();
		

 }])



