var app = angular.module('ngApp', ['ui.bootstrap', 'dataGrid', "ngSanitize", "ngCsv"])

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


    app.controller('concessionCtrl', ['$http', '$scope',  function ($http, $scope) {
		
		$http.get('ajax/selectData/selectClassSection.php')
		.success(function(data){
			$scope.classSection = data;	
		})
		.error(function() {
			$scope.class = "error in fetching data";
		});
		
		$scope.showSection = function() {
			var request = $http({
				method: "post",
				url: "ajax/selectData/studentList.php",
				data: {
					section: $scope.section,
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			// Check whether the HTTP Request is Successfull or not. 
			request.success(function (data) {
				$scope.list = data;
				$scope.currentPage = 1; //current page
				$scope.entryLimit = 10; //max no of items to display in a page
				$scope.filteredItems = $scope.list.length; //Initially for no filter  
				$scope.totalItems = $scope.list.length;
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}		
		
		$scope.showSection();
	
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
		


		/*$scope.opened = {};

		$scope.open = function($event, elementOpened) {
			$event.preventDefault();
			$event.stopPropagation();
			
			$scope.opened[elementOpened] = !$scope.opened[elementOpened];
		};*/
		/*
		$scope.gridOptions1 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions1	=	{};
		
		$scope.gridOptions2 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions2	=	{};
		
		$scope.gridOptions3 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions3	=	{};
		
		$scope.gridOptions4 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions4	=	{};
		$scope.gridOptions22 = {
			data: [],
			urlSync: true
  		};
		$scope.gridActions22	=	{};
		
		$scope.data = {};
			

		
		$scope.getFeeHeads = function() {
			$http.get('ajax/selectData/getFeeHead.php')
			.success(function(response){
				$scope.data = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getFeeHeads();
		
		$scope.getFeeHeadTypes = function() {
			$http.get('ajax/selectData/getFeeHeadType.php')
			.success(function(response){
				$scope.data1 = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getFeeHeadTypes();


		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
				console.log(response);
				$scope.data2 = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();

		$scope.onChangeFeeHead	=	function() {
			
			angular.element(document.querySelector("#div1")).addClass("border");
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnFeeHead.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { feeHeadId : $scope.datas.FEE_HEAD_ID },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				//$scope.gridOptions.data = response;
				$scope.gridOptions1.data  = angular.copy(response);	

			}).error(function(err){
				console.log(err);
			});
		}

		$scope.onChangeFeeHeadType	=	function() {
			var csvdetail2 = new Array();
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getFeeDefByFHeadType.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { feeHeadTypeId : $scope.datas1.FEE_HEAD_TYPE_ID },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				var len = response.length;
				for( var i=0; i<len; i++ ) {
					var SNO = response[i].SNO;
					var ADMISSION_ID = response[i].ADMISSION_ID;
					var NAME = response[i].NAME;
					var FATHER_NAME = response[i].FATHER_NAME;
					var GENDER = response[i].GENDER;
					var STANDARD = response[i].STANDARD;
					var SECTION = response[i].SECTION;
					var DOB = response[i].DOB;
					
					csvdetail2.push({"SNO":SNO, "ADMISSION_ID":ADMISSION_ID, "NAME":NAME, "FATHER_NAME":FATHER_NAME, "GENDER":GENDER, "STANDARD":STANDARD, "SECTION":SECTION, "DOB":DOB});
				}
				$scope.gridOptions22.data = csvdetail2;
				$scope.gridOptions2.data = response;
				//$scope.gridOptions2.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});
		}
		
		$scope.onChangeClass	=	function(da1, da2) {
			//var type_id		=	$scope.datas1.FEE_HEAD_TYPE_ID;
			//var class_id	=	$scope.datas2.CLASS_ID;
			var type_id		=	da1.FEE_HEAD_TYPE_ID;
			var class_id	=	da2.CLASS_ID;
			
			alert(type_id + " " + class_id);
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getFeeDefByFHeadType.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { feeHeadTypeId : type_id, feeClassId : class_id},
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				$scope.gridOptions2.data = response;
				//$scope.gridOptions2.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});
		}



		$scope.selection=[];
		$scope.toggleSelection = function toggleSelection(employeeName) {
		    var idx = $scope.selection.indexOf(employeeName);

	    	// is currently selected
	    	if (idx > -1) {
	      		$scope.selection.splice(idx, 1);
	    	} else {
	      		$scope.selection.push(employeeName);
	    	}
	  	};
		
		$scope.getCSVHeader = function () {return ["SNO", "ADMISSION_ID", "NAME", "FATHER_NAME", "GENDER", "STANDARD", "SECTION", "DOB"]};
		$scope.getFeeDefaltByClass = function(type_id, choice) {
 			
			var details = [];
			angular.forEach(choice, function (value, key) {
				if (choice[key].checked) {
					//alert(choice[key].CLASS_ID)
					details.push(choice[key].CLASS_ID);
				}
			});
			console.log(details);
			
			var csvdetail	=	new Array();
			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getFeeDefByClass.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { feeClassId : details, feeTypeId : type_id },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
							  
				var len = response.length;
				for( var i=0; i<len; i++ ) {
					console.log(response[i].SNO)
					var SNO = response[i].SNO;
					var ADMISSION_ID = response[i].ADMISSION_ID;
					var NAME = response[i].NAME;
					var FATHER_NAME = response[i].FATHER_NAME;
					var GENDER = response[i].GENDER;
					var STANDARD = response[i].STANDARD;
					var SECTION = response[i].SECTION;
					var DOB = response[i].DOB;
					
					csvdetail.push({"SNO":SNO, "ADMISSION_ID":ADMISSION_ID, "NAME":NAME, "FATHER_NAME":FATHER_NAME, "GENDER":GENDER, "STANDARD":STANDARD, "SECTION":SECTION, "DOB":DOB});
				}
				$scope.gridOptions4.data = csvdetail;
				$scope.gridOptions3.data = response;
				//$scope.gridOptions2.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});			
		};
		
		$scope.getReportClass	=	function() {

			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnClass.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { classId : $scope.selection },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				//$scope.data3 = response;
				
				$scope.gridOptions3.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});
		}


		$scope.checkAll = function () {
			if ($scope.selectedAll) {
				$scope.selectedAll = true; 
				
			} else {
				$scope.selectedAll = false; 
			} 
			angular.forEach($scope.data2.CLASS, function (item) {
				item.checked = $scope.selectedAll; 
			}); 
		};
		
		*/
		

    }])



