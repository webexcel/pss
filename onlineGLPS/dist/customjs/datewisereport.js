angular.module('demoApp', ['ui.bootstrap', 'dataGrid', 'pagination'])
    .controller('demoCtrl', ['$window','$location','$http','$scope', function ($window,$location,$http,$scope) {
		$scope.isCollapsed = true;
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
					$window.location.href = "fee-reports.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
				
		};	
		

		
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
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


	
		$scope.selection=[];
		$scope.toggleSelection = function toggleSelection(employeeName) {
			var idx = $scope.selection.indexOf(employeeName);
			if (idx > -1) {
			  $scope.selection.splice(idx, 1);
			}
			else {
			  $scope.selection.push(employeeName);
			}
		};

		$scope.custom = true;
		$scope.toggleCustom = function(id) {
			$scope.custom = $scope.custom === false ? true: false;
		};
	
		$scope.toggleDetail = function($index) {
			$scope.activePosition = $scope.activePosition == $index ? -1 : $index;
		};
	
		$scope.onChangeClass = function() {		
			$http({
					method  : 'POST',
					url     : 'ajax/selectData/getRepOnClass1.php',
					data	: { classId : $scope.data2.CLASS_ID },
					cache: false,
					headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
				}) 
				.success(function(response) {
					console.log(response);
					$scope.data3 = response;				
					$scope.gridOptions3.data = response;
				}).error(function(err){
					console.log(err);
				});		
		};
	
		$scope.selUser=function(s){			
			$http({
					method  : 'POST',
					url     : 'ajax/selectData/getRepOnClass1.php',
					data	: { adno : s.ADMISSION_ID },
					cache: false,
					headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
				}) 
				.success(function(response) {
					console.log(response);
					$scope.data3 = response;
				}).error(function(err){
					console.log(err);
				});
			
			
		}
	
		$scope.isSelected=function(s){
			return $scope.selected_user===s;
		}
		
		$scope.getReportClassWise	=	function() {			
			var dateFrom	=	$scope.dateFrom;
			var dateTo		=	$scope.dateTo;				
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnClass.php',
				data	: { dateFrom : dateFrom, dateTo : dateTo ,classId : $scope.selection },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			.success(function(response) {
				var rs	=	response;
				console.log('Log Start.............!');
				console.log(rs);
				console.log('Log End.............!');		
				$scope.data3 = response;
				return false;

			}).error(function(err){
				console.log(err);
			});
		}

		$scope.onChangeFeeHead	=	function() {			
			angular.element(document.querySelector("#div1")).addClass("border");			
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnFeeHead.php',
				data	: { feeHeadId : $scope.datas.FEE_HEAD_ID },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			.success(function(response) {
				$scope.gridOptions1.data  = angular.copy(response);	

			}).error(function(err){
				console.log(err);
			});
		}

		$scope.onChangeFeeHeadType	=	function() {
			$http({
				method  : 'POST',
				url     : 'ajax/selectData/getRepOnFeeHeadType.php',
				data	: { feeHeadTypeId : $scope.datas1.FEE_HEAD_TYPE_ID },
				cache: false,
				headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
			}) 
			.success(function(response) {				
				$scope.gridOptions2.data = response;	
			}).error(function(err){
				console.log(err);
			});
		}


}])



