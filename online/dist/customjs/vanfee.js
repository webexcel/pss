var fetch = angular.module('myApp', ["xeditable", "ui.bootstrap", "angularjs-datetime-picker"]);
	
	fetch.directive('loading', function () {
	  return {
		restrict: 'E',
		replace:true,
		template: '<div class="loading"><img src="images/ajax-loader.gif" width="20" height="20" />LOADING...</div>',
		link: function (scope, element, attr) {
			  scope.$watch('loading', function (val) {
				  if (val)
					  $(element).show();
				  else
					  $(element).hide();
			  });
		}
	  }
	});
	

	fetch.filter('startFrom', function() {
		return function(input, start) {
			if(input) {
				start = +start; //parse to int
				return input.slice(start);
			}
			return [];
		}
	});
	
	fetch.filter('sumOfValue', function () {
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
	
	fetch.filter('total', function() {
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


	fetch.controller('dbCtrl', function($window,$location,$scope,$filter, $http, $timeout, $modal) {

		///////////////////////////////////////////
		$scope.changeAcademic = function() {
			$http.get('ajax/selectData/getAcademicyear.php')
			.success(function(response){
				//console.log(response);
				$scope.academicname = response;
				$scope.itemSelected = $scope.academicname[0];
				console.log($scope.itemSelected);
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
					$window.location.href = "vehicle-fee.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		////////////////////////////////////////////////

		$scope.classes = [];
		$scope.tempclasses = [];
		$scope.loadclass = function() {
			return $scope.classes.length ? null : $http.get('ajax/selectData/selclass.php').success(function(data) {
				$scope.classes = data;
				
				for(var i=0;i<$scope.classes.length;i++){
					$scope.tempclasses.push($scope.classes[i].Standard)
				}
				
			});
			
		};

		$http.get('ajax/selectData/selectClassSection.php')
		.success(function(data){
			$scope.data = data;	
		})
		.error(function() {
			$scope.class = "error in fetching data";
		});


		$scope.showSection = function() {
			var request = $http({
				method: "post",
				url: "ajax/selectData/getAllVanStudent.php",
				data: {
					section: $scope.section,
					year:$scope.year,
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			request.success(function (data) {
				if(data['status'] == false) {
					$scope.students = '';
					$scope.currentPage = 1; //current page
					$scope.entryLimit = 10; //max no of items to display in a page
					$scope.filteredItems = $scope.students.length; //Initially for no filter  
					$scope.totalItems = $scope.students.length;
				} else {
					$scope.students = data;
					$scope.currentPage = 1; //current page
					$scope.entryLimit = 10; //max no of items to display in a page
					$scope.filteredItems = $scope.students.length; //Initially for no filter  
					$scope.totalItems = $scope.students.length;
					console.log(data)
				}
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}	
		$scope.showSection();
								
			//// ***** Route mapping ***///
			
			$scope.getRouteMapping = function() {
				$http.get('ajax/selectData/getRouteMapping.php')
				.success(function(response){
					console.log(response);
					$scope.getNewroute = response;
					
				}).error(function(err){
					console.log(err);
				});
			}
			$scope.getRouteMapping();
									
			$scope.save = function() {
				console.log($scope.newroute1);
				$http({
					method: 'POST',
					url: "ajax/insertData/insvanroute.php",					
					data: $scope.newroute1,
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).then(function successCallback(response) {
					console.log(response)
					$("#routeMappingModel").modal('hide');
				}, function errorCallback(response) {
					console.log(response);
				});				
			};	
			
			$scope.routeMapping = function() {
				$("#routeMappingModel").modal('show');
				$scope.getRouteMapping();
			};
			
			$scope.getRoutetype = function() {
				$http.get('ajax/selectData/getRoutetype.php')
				.success(function(response){
					console.log(response);
					$scope.routetype = response
				}).error(function(err){
					console.log(err);
				});
			}
			$scope.getRoutetype();
			
			//// ***** Stage mapping ***///
			
			$scope.getStageMapping = function() {
				$http.get('ajax/selectData/getStageMapping.php')
				.success(function(response){
					console.log(response);
					$scope.getNewStage = response;
					
				}).error(function(err){
					console.log(err);
				});
			}
			$scope.getStageMapping();
			
			$scope.save1 = function() {
				console.log($scope.newstage);
				$http({
					method: 'POST',
					url: "ajax/insertData/insvanstage.php",					
					data: $scope.newstage,
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).then(function successCallback(response) {
					console.log(response)
					$("#stageMappingModel").modal('hide');
				}, function errorCallback(response) {
					console.log(response);
				});				
			};
			
			$scope.stageMapping = function() {
				$("#stageMappingModel").modal('show');
				$scope.getStageMapping();
			};
			
			//// **** end **** ////
			
			$scope.viewdetail = function(adno,classs,section,name){
				//alert(adno + classs + section + name);
				$window.location.href = "vehicle_payfee.php#?adno="+ adno +"&classsec="+ classs +"-"+ section +"&name="+ name; //You should have http here.
			}
			
			$scope.studentmapping = function(adno,classs,section,name){
				//alert(adno + classs + section + name);
				$window.location.href = "vehicle_student_mapping.php#?adno="+ adno +"&classsec="+ classs +"-"+ section +"&name="+ name; //You should have http here.
			}

			$scope.routedelete = function(id) {
				//alert(id);
				$scope.delid = id;
				$("#delmodal").modal('show');
				
			};

	
});