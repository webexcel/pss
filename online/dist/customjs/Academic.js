var app = angular.module('ngApp', ['ui.bootstrap'])
	
	app.controller('studentsCtrl', ['$window','$location','$http', '$scope', function ($window,$location,$http,$scope) {

		
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
					$window.location.href = "dashboard.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		

    }])



