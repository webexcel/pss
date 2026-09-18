var app = angular.module('feeDefaultApp', ['ui.bootstrap', 'dataGrid', 'pagination'])
	app.directive('exportToCsv',function(){
  	return {
    	restrict: 'A',
    	link: function (scope, element, attrs) {
    		var el = element[0];
	        element.bind('click', function(e){
	        	var table = e.target.nextElementSibling;
	        	var csvString = '';
	        	for(var i=0; i<table.rows.length;i++){
	        		var rowData = table.rows[i].cells;
	        		for(var j=0; j<rowData.length;j++){
	        			csvString = csvString + rowData[j].innerHTML + ",";
	        		}
	        		csvString = csvString.substring(0,csvString.length - 1);
	        		csvString = csvString + "\n";
			    }
	         	csvString = csvString.substring(0, csvString.length - 1);
	         	var a = $('<a/>', {
		            style:'display:none',
		            href:'data:application/octet-stream;base64,'+btoa(csvString),
		            download:'emailStatistics.csv'
		        }).appendTo('body')
		        a[0].click()
		        a.remove();
	        });
    	}
  	}
	});

    app.controller('feeDefaultCtrl', ['$http', '$scope', function ($http, $scope) {
		
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
				console.log(response);
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
		
		
		$scope.getFeeDefaltByClass = function(type_id) {
 
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getFeeDefByClass.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { feeClassId : $scope.selection, feeTypeId : type_id },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
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
				$scope.data3 = response;
				
				//$scope.gridOptions.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});
		}




	

    }])



