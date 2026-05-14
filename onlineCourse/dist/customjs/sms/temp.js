var fetch = angular.module('myApp', ["xeditable", "ui.bootstrap"]);
		


	fetch.filter('startFrom', function() {
		return function(input, start) {
			if(input) {
				start = +start; //parse to int
				return input.slice(start);
			}
			return [];
		}
	});
	
	fetch.controller('dbCtrl', function($window,$location,$scope, $filter, $http, $timeout) {
		
		$scope.reguser = [];
		
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
				$window.location.href = "temp.php"; //You should have http here.
				console.log(response);
			}).error(function(response) {
				console.log(response);
			});			
		}
				

		
		$http.get('ajax/selectData/getAcademicyear.php')
		.success(function(data){
			$scope.yearname = data;	
		})
		.error(function() {
			$scope.class = "error in fetching data";
		});
		
		
		$scope.saveStudent = function(saveValues) {
			console.log($scope.mobile);
			console.log($scope.message);
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/sms/temp/insTemp.php",
					data: { mobile : $scope.mobile , message : $scope.message },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {
					console.log(response);	
					location.reload();
				}).error(function(response) {
					console.log(response);
					
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
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
	
});	
