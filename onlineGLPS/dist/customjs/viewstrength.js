var app = angular.module('myApp', ['ui.bootstrap']);

    app.controller('dbCtrl', ['$window','$location','$scope', '$http', 
		function ($window,$location,$scope, $http) {
			
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
						$window.location.href = "new-student1.php"; //You should have http here.
						console.log(response);
					}).error(function(response) {
						console.log(response);
					});
				
			}
					
			$http.get("ajax/selectData/selclass.php")
            .success(function(classsec){
            $scope.class = classsec;
            })
            .error(function() {
            $scope.class = "error in fetching data";
            });
			
			
			 //$scope.user = {};
			$scope.selStudent = function() {
				
				$http({
				  method  : 'POST',
				  url     : 'ajax/selectData/classwise_list.php',
				  data    : $scope.user, //forms user object
				  cache: false,
				  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
				 })
                .success(function(data){                   

				    $scope.data = data;
                })
                .error(function() {
                    $scope.data = "error in fetching data";
                });
			}
				
			$scope.rollno = function() {
				console.log($scope.user)			
				//return false;
				//$scope.loading = false;
				$http({
				  method  : 'POST',
				  url     : 'ajax/updateData/updaterollno.php',
				  data    : $scope.user, //forms user object
				  cache: false,
				  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
				 })
                .success(function(data){
                    $scope.selStudent();
                })
                .error(function() {
                    $scope.data = "error in fetching data";
                });
				
			}
		////// Deactivate Student Here////////////////////		
					
				
				
        }])



