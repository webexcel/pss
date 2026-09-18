var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv", "xeditable"])

	app.filter('startFrom', function() {
		return function(input, start) {
			if(input) {
				start = +start; //parse to int
				return input.slice(start);
			}
			return [];
		}
	});

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
	app.run(function(editableOptions) {
		editableOptions.theme = 'bs3';
	});
	
	app.controller('feeReceiptsCtrl', ['$http', '$scope', '$timeout',  function ($http, $scope, $timeout) {
			
		/*
		var request = $http({
			method: "POST",
			url: "ajax/updateData/updateFeeStructure.php",
			//data: $scope.data.section,
			data: { feeGroupMapId: fGroupMapId, feeAmount: feeAmount },
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});
		// Check whether the HTTP Request is Successfull or not. //
		request.success(function (response) {
			console.log(response);
		});
		request.error(function (data) {
			$scope.message = "From PHP file : "+data;
		});		
		*/
		/*
		$http({
			method: 'POST',
			url: "ajax/updateData/updateFeeStructure.php",
			data: {
				feeGroupMapId: fGroupMapId,
				feeAmount: feeAmount
			},
			//data: { feeGroupMapId: fGroupMapId, feeAmount: feeAmount },
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		}).then(function successCallback(response) {
			$scope.feeStructure	=	response.data
			$scope.changeFeeGroup();
			
		}, function errorCallback(response) {
			console.log(response);
		});	

		$http({
			method: 'GET',
			url: 'ajax/selectData/getClass.php'
		}).then(function successCallback(response) {
			$scope.classes	=	response.data;
		}, function errorCallback(response) {
			
		});
		*/



    }])



