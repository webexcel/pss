var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv", "xeditable"])
	/*
	app.run(function(editableOptions) {
		editableOptions.theme = 'bs3';
	});
	*/
	app.controller('bonafideCtrl', ['$http', '$scope', '$timeout',  function ($http, $scope, $timeout) {
		
		$scope.saveBonafide = function() {
			$scope.bonafide.name	=	$scope.selectedStudent.NAME;
			$scope.bonafide.class	=	$scope.selectedStudent.CLASS
			//console.log('Save Bonafide');
			//console.log($scope.bonafide);
			//console.log("End..........!");
			$http({
				method: 'POST',
				url: "ajax/insertData/insert-bonafide-certificate.php",
				data: {
					bonafide: $scope.bonafide
				},
				//headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				headers: { 'Content-Type': 'application/json' }
				
			}).then(function successCallback(response) {
				console.log(response);
				
				$scope.response	=	response;
				$scope.bonafide.cdate = "";
				$scope.bonafide.name = "";
				$scope.bonafide.class = "";
				$scope.bonafide.dob = "";
				$scope.bonafide.discription = "";
				$scope.selectedStudent = [];
				//$("#AdnoStudentModal").modal('show');
				
				$scope.getBonafide();
			}, function errorCallback(response) {
				console.log(response);
			});
		};
		
		
		
		
		$scope.getBonafide = function() {
			$http({
				method: 'GET',
				url: 'ajax/selectData/getBonafide.php'
			}).then(function successCallback(response) {
				console.log(response);
				$scope.student = response.data;
				console.log($scope.student);
				
				$scope.totalItems = $scope.student;
				$scope.page = 1;
			}, function errorCallback(response) {
				console.log(response);
			});			
		}
		$scope.getBonafide();


		$scope.getStudents = function() {
			$http({
				method: 'GET',
				url: 'ajax/selectData/getStudents.php'
			}).then(function successCallback(response) {
				console.log("Parasuraman Muthaiyan");
				console.log(response);
				$scope.allStudent = response.data;
				console.log($scope.allStudent);
				console.log("Parasuraman Muthaiyan");
			}, function errorCallback(response) {
				console.log(response);
			});			
		}
		$scope.getStudents();		

		/*
		getCountries();
		function getCountries() {  
			$http.get("ajax/getCountries.php").success(function(data){
				$scope.countries = data;
			});
		};
		*/
		
		
		





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



