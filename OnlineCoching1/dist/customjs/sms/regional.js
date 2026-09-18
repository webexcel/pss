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
				$window.location.href = "regional.php"; //You should have http here.
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
			console.log($scope.reguser);
			console.log($scope.message);
			
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/sms/regional/insregional.php",
					data: { classsec : $scope.reguser , message : $scope.message },
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
		
		$scope.getregionallist = function() {
			var request = $http({
				method: "post",
				url: "ajax/sms/regional/getregionallist.php",
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
		$scope.getregionallist();
		
		$scope.sendAll = function() {
			console.log($scope.students);			
			$scope.ID = []; 
            var values = $scope.students;
            angular.forEach(values, function (value, key) { 
				$scope.ID.push(value.absID); 
				console.log($scope.ID);
			});  	
			
			$http({
				method: "post",
				url: "ajax/sms/regional/sendAllregional.php",
				data: { uStud: $scope.ID },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//$("#sendStudentModal").modal('hide');
				location.reload();
			}).error(function(response) {
				console.log(response);
			});	


		};
		
		$scope.deletelist = function(ds) {
			$scope.dStudent = {				
				dId: ds.absID				
			};
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.delregional = function() {
			console.log($scope.dStudent);							
			$http({
				method: "post",
				url: "ajax/sms/regional/delregional.php",
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
				pId : ps.absID				
			};			
			$("#sendStudentModal").modal('show');
		}
		
		$scope.sendregional = function() {
			console.log($scope.dStud);							
			$http({
				method: "post",
				url: "ajax/sms/regional/sendregional.php",
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
		/*

		$scope.editlist = function(ps) {
			$scope.eStud = {				
				pId : ps.absID	,
				psms : ps.Message		
			};			
			$("#editStudentModal").modal('show');
		}

		
		$scope.editregional = function() {
			console.log("hai");			
			console.log($scope.eStud);			
			$http({
				method: "post",
				url: "ajax/sms/regional/editregional.php",
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
