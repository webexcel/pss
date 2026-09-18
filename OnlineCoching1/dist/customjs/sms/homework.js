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
				$window.location.href = "homework.php"; //You should have http here.
				console.log(response);
			}).error(function(response) {
				console.log(response);
			});			
		}

		$scope.getsmscount = function() {
			$http.get('ajax/sms/getTotalsms.php')
			.success(function(response){
				console.log(response);
				$scope.totalsms = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getsmscount();
				
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
		
	/*	$scope.selectclass = function(selectclass) {
			console.log(selectclass);
			/*var request = $http({
				method: "post",
				url: "ajax/sms/homework/getHWClass.php",
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
			
		};*/
		$scope.showSection = function() {
			var request = $http({
				method: "post",
				url: "ajax/sms/homework/getHWClass.php",
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
		
		
		$scope.saveHomework = function(saveValues) {
			console.log($scope.section);
			console.log($scope.list);			
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/sms/homework/insHomework.php",
					data: { section : $scope.section , message : $scope.message },
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
		}
		
		$scope.getHomeworklist = function() {
			var request = $http({
				method: "post",
				url: "ajax/sms/homework/getHomeworklist.php",
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (response) {
				console.log(response);
				$scope.students = response;
				//$scope.data = response;
				$scope.currentPage = 1; 
				$scope.entryLimit = 10;
				$scope.filteredItems = $scope.students.length;
				$scope.totalItems = $scope.students.length;
			});
			request.error(function (response) {
				$scope.message = "From PHP file : "+response;
			});
			
		}	
		$scope.getHomeworklist();
		
		$scope.sendAll = function() {
			console.log($scope.students);			
			$scope.Group_name = []; 
            var values = $scope.students;
            angular.forEach(values, function (value, key) { 
				$scope.Group_name.push(value.Group_name); 
				console.log($scope.Group_name);
			});  	
			
			$http({
				method: "post",
				url: "ajax/sms/homework/sendAllHomework.php",
				data: { uStud: $scope.Group_name },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				location.reload();
			}).error(function(response) {
				console.log(response);
			});	


		};
		
		$scope.deletelist = function(ds) {
			$scope.dStudent = {				
				dId: ds.ID				
			};
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.delHomework = function() {
			console.log($scope.dStudent);							
			$http({
				method: "post",
				url: "ajax/sms/homework/delHomework.php",
				data: {
					uStudent: $scope.dStudent
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#deleteStudentModal").modal('hide');
				location.reload();				
			}).error(function(response) {
				console.log(response);
			});	
		}
		
		$scope.sendlist = function(ps) {
			$scope.dStud = {				
				pId: ps.Group_name				
			};			
			$("#sendStudentModal").modal('show');
		}
		
		$scope.sendHomework = function() {
			console.log($scope.dStud);							
			$http({
				method: "post",
				url: "ajax/sms/homework/sendHomework.php",
				data: {
					uStud: $scope.dStud
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#sendStudentModal").modal('hide');
				location.reload();
			}).error(function(response) {
				console.log(response);
			});	
		}

		$scope.editlist = function(ps) {
			$scope.eStud = {				
				pId : ps.ID	,
				psms : ps.message		
			};			
			$("#editStudentModal").modal('show');
		}

		
		$scope.editHomework = function() {
			console.log($scope.eStud);			
			$http({
				method: "post",
				url: "ajax/sms/homework/editHomework.php",
				data: {
					uStudent: $scope.eStud
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				console.log(response);
				$("#editStudentModal").modal('hide');	
				location.reload();		
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
	
});	
