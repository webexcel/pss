//var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv"])
var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv", 'ngTouch', 'ui.grid', 'ui.grid.pagination', 'ui.grid.selection', 'ui.grid.exporter']);

//app.controller('customFilterCtrl', ['$http', '$scope', '$timeout',  function ($http, $scope, $timeout) {
app.controller('customFilterCtrl', ['$scope', '$http', 'uiGridConstants', function($scope, $http, uiGridConstants) {
	
	
	
$scope.gridOptions4 = {
			data: [],
			urlSync: true
  		};
 
  $scope.gridOptions = {
    columnDefs: [],
    enableGridMenu: true,
    enableSelectAll: true,
    exporterCsvFilename: 'myFile.csv',
    exporterPdfDefaultStyle: {fontSize: 9},
    exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
    exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
    //exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
    exporterPdfFooter: function ( currentPage, pageCount ) {
      return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
    },
    exporterPdfCustomFormatter: function ( docDefinition ) {
      docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
      docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
      return docDefinition;
    },
    exporterPdfOrientation: 'portrait',
    exporterPdfPageSize: 'LETTER',
    exporterPdfMaxGridWidth: 500,
    exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
    onRegisterApi: function(gridApi){
      $scope.gridApi = gridApi;
    }
  };
 
 /*
  $http.get('ajax/selectData/getClass.php')
  .success(function(data) {
    $scope.gridOptions.data = data;
  });
  */
  
	
	
	
	
	$scope.getClass = function() {
		$http.get('ajax/selectData/getClass.php')
		.success(function(response){
			//console.log(response);
			$scope.classes = response;
		}).error(function(err){
			console.log(err);
		});
	}
	$scope.getClass();
	
	$scope.form	=	{};
	$scope.fSearch = function(frmdata) {
		console.log("Parasuraman ")
		console.log($scope.form);
		console.log("Parasuraman ")
		
		var fdata	=	$scope.form;
		console.log(fdata);
		var request = $http({
			method: "POST",
			url: "ajax/selectData/getCustomFilters.php",
			//data: $scope.data.section,
			data: { fdatas : fdata },
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		});
		// Check whether the HTTP Request is Successfull or not. //
		request.success(function (response) {
			console.log(response);
			$scope.gridOptions.data	= response;
		});
		
	};
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	


		
		
		
		
		
		
		
		
	
	
		
		
		
		$scope.updateStudent = function() {

			console.log($scope.eStudent);
			
			$http({
				method: "post",
				url: "ajax/updateData/updateStudentAllData.php",
				data: {
					uStudent: $scope.eStudent
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#studentEditForm").modal('hide');
				$scope.getStudents();
			}).error(function(response) {
				console.log(response);
			});
			
			
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
			
			/*$http({
				method: 'GET',
				url: '/someUrl'
			}).then(function successCallback(response) {
				
			}, function errorCallback(response) {
				
			});*/
			
			
		}
		
		
		

    }])





