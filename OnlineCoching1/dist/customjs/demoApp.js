angular.module('demoApp', ['ui.bootstrap', 'dataGrid', 'pagination'])
    .controller('demoCtrl', ['$http', '$scope', function ($http, $scope) {
		
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
		
		$scope.data = {};
			
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

	
	$scope.selection=[];
	
	$scope.toggleSelection = function toggleSelection(employeeName) {
	    var idx = $scope.selection.indexOf(employeeName);

	    // is currently selected
	    if (idx > -1) {
	      $scope.selection.splice(idx, 1);
	    }

	    // is newly selected
	    else {
	      $scope.selection.push(employeeName);
	    }
	  };

	$scope.custom = true;
	$scope.toggleCustom = function(id) {
		$scope.custom = $scope.custom === false ? true: false;
	};
	
	$scope.toggleDetail = function($index) {
        //$scope.isVisible = $scope.isVisible == 0 ? true : false;
        $scope.activePosition = $scope.activePosition == $index ? -1 : $index;
    };
	$scope.onChangeClass = function() {
		
		$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnClass1.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { classId : $scope.data2.CLASS_ID },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				console.log(response);
				$scope.data3 = response;
				
				$scope.gridOptions3.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});		
	};
	
	$scope.selUser=function(s){
		
		$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnClass1.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { adno : s.ADMISSION_ID },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			//$http.get('ajax/selectData/detail.php')
			.success(function(response) {
				console.log(response);
				$scope.data3 = response;
				
				//$scope.gridOptions.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});
		
		
	}
	
	$scope.isSelected=function(s){
		return $scope.selected_user===s;
	}

	$scope.getReportClass	=	function() {
			console.log($scope.selection);
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
				console.log(response);
				$scope.data3 = response;
				
				//$scope.gridOptions.data = response;
				//$scope.gridOptions1.data  = angular.copy(response);	
			}).error(function(err){
				console.log(err);
			});
		}

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
				url     : 'ajax/selectData/getRepOnFeeHeadType.php',
				//data    : $scope.datas.FEE_HEAD_ID,
				data	: { feeHeadTypeId : $scope.datas1.FEE_HEAD_TYPE_ID },
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





	

    }])



