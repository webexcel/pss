var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv", "xeditable"])
/*
app.run(function(editableOptions) {
	editableOptions.theme = 'bs3';
});
*/

app.filter('sumOfValue', function () {
	return function (data, key) {        
		if (angular.isUndefined(data) || angular.isUndefined(key))
			return 0;        
		var sum = 0;        
		angular.forEach(data,function(value){
			sum = sum + parseInt(value[key]);
		});        
		return sum;
	}
});

app.filter('total', function() {
	return function(data, key) {
		if (typeof(data) === 'undefined' || typeof(key) === 'undefined') {
			return 0;
		}

		var sum = 0;
		for (var i = data.length - 1; i >= 0; i--) {
			sum += parseInt(data[i][key]);
		}

		return sum;
	};
});

app.controller('bonafideCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http, $scope, $timeout) {
	
	
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
					$window.location.href = "view-strength-details.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
	
	$scope.getStudents = function() {
		
		$http({
			method: 'GET',
			url: 'ajax/selectData/getStudentStrength.php'
		}).then(function successCallback(response) {
			//console.log(response);
			$scope.strengthh = response.data;
			$scope.strength = $scope.strengthh.str;
			//$scope.len = $scope.strength.length;
			console.log("dsgtfsdg",$scope.strength);
			$scope.tot = $scope.strengthh.Total;

		}, function errorCallback(response) {
			//console.log(response);
		});			
	}
	$scope.getStudents();

	$http.get("ajax/selectData/group.php")
	.success(function(classsec){
		$scope.group = classsec;
	})
	.error(function() {
		$scope.group = "error in fetching data";
	});
	
	/*
	$scope.getStudents = function() {
		console.log("CLASS ID : "+ $scope.class);
		console.log("MONTH FROM : "+ $scope.monthFrom);
		console.log("MONTH TO : "+ $scope.monthTo);
		var request = $http({
			method: "POST",
			url: "ajax/selectData/getReports.php",
			//data: $scope.data.section,
			data: { section: $scope.class , FMonth : $scope.monthFrom, TMonth : $scope.monthTo },
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});
		// Check whether the HTTP Request is Successfull or not. //
		request.success(function (response) {
			console.log(response);
			//return false;
			
			$scope.gridOptions4.data = response;
			
			$scope.students = response;
			$scope.list = response;
			
			$scope.currentPage = 1; //current page
			$scope.entryLimit = 20; //max no of items to display in a page
			$scope.filteredItems = $scope.list.length; //Initially for no filter  
			$scope.totalItems = $scope.list.length;
			
			
		});
		request.error(function (data) {
			$scope.message = "From PHP file : "+data;
		});
		
	}	
	$scope.getStudents();
	*/
	/*
	$scope.getClass = function() {
		$http.get('ajax/selectData/getClass.php')
		.success(function(response){
			console.log("CLASS LIST : " + response);
			$scope.classes = response
		}).error(function(err){
			console.log(err);
		});
	}
	$scope.getClass();
	*/
	/*
	$http({
		method: 'GET',
		url: 'ajax/selectData/getMonth.php'
	}).then(function successCallback(response) {
		$scope.months = response.data;
	}, function errorCallback(response) {
		console.log(response);
	});		
	*/
	
	
	
		

	
	/*
	$http({
		method: 'POST',
		url: "ajax/selectData/updateStudent.php",
		data: {
			uStudent: $scope.eStudent
		},
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function successCallback(response) {
		console.log(response);
	}, function errorCallback(response) {
		console.log(response);
	});
	*/
	
	/*
	$http({
		method: 'GET',
		url: '/someUrl'
	}).then(function successCallback(response) {
		
	}, function errorCallback(response) {
		
	});
	*/


}])



