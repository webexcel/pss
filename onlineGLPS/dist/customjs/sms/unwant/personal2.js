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
				$window.location.href = "personalized.php"; //You should have http here.
				console.log(response);
			}).error(function(response) {
				console.log(response);
			});			
		}
				
		$http.get('ajax/selectData/selectClassSection.php')
		.success(function(data){
			$scope.data = data;	
		})
		.error(function() {
			$scope.class = "error in fetching data";
		});
		
		$http.get('ajax/selectData/getAcademicyear.php')
		.success(function(data){
			$scope.yearname = data;	
		})
		.error(function() {
			$scope.class = "error in fetching data";
		});
		
	
/*
		$scope.showSection = function() {
			var request = $http({
				method: "post",
				url: "ajax/sms/getSmsStudent.php",
				data: { section: $scope.section },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function(response) {
				console.log(response);
				$scope.list = response;
			});
			request.error(function (response) {
				$scope.message = "From PHP file : "+response;
			});
			
		};
		
		
		$scope.moveStudentPromo = function(moveStudent) {
			console.log(moveStudent);
			angular.forEach(moveStudent, function(value, key) {		
				if($scope.reguser.indexOf(value)  == -1){
					$scope.reguser.push(value);
					console.log($scope.reguser);				
				}
			});	
		};
		
		$scope.removeStudentPromo = function (saveValues) {						
			angular.forEach(saveValues, function(value, key) {	
			console.log("dddd",value);
			var index = $scope.reguser.indexOf(value);	
			console.log("dddd",index);	
			$scope.reguser.splice(index, 1);
			});
		 
		};
		

		$scope.saveStudent = function(saveValues) {
			//console.log($scope.reguser);
			//console.log($scope.message);
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/sms/personal/insPersonal.php",
					data: { adno : $scope.reguser , message : $scope.message  },
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
		
		$scope.getPersonallist = function() {
			var request = $http({
				method: "post",
				url: "ajax/sms/personal/getPersonallist.php",
				//data: { students: $scope.section },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (response) {
				console.log(response);
				$scope.students = response;
				$scope.currentPage = 1; 
				$scope.entryLimit = 10;
				$scope.filteredItems = $scope.students.length;
				$scope.totalItems = $scope.students.length;
			});
			request.error(function (response) {
				$scope.message = "From PHP file : "+response;
			});
			
		}	
		$scope.getPersonallist();

				
		$scope.deletelist = function(ds) {
			$scope.dStudent = {				
				dId: ds.ID				
			};
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.deletelate = function() {
			console.log($scope.dStudent);							
			$http({
				method: "post",
				url: "ajax/sms/delLatecomers.php",
				data: {
					uStudent: $scope.dStudent
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#deleteStudentModal").modal('hide');
				$scope.getlatecomerslist();
			}).error(function(response) {
				console.log(response);
			});	
		}
		
		$scope.sendlist = function(ps) {
			$scope.dStud = {				
				pId: ps.ID				
			};			
			$("#sendStudentModal").modal('show');
		}
		
		$scope.sendlatecomers = function() {
			console.log($scope.dStud);							
			$http({
				method: "post",
				url: "ajax/sms/sendLatecomers.php",
				data: {
					uStud: $scope.dStud
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#sendStudentModal").modal('hide');
				$scope.getlatecomerslist();
			}).error(function(response) {
				console.log(response);
			});	
		}
		*/
	
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
