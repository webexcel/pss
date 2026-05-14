var app = angular.module('ngApp', ['ui.bootstrap','angularUtils.directives.dirPagination', "ngSanitize", "ngCsv", 'checklist-model'])

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
	

	app.controller('reportCtrl', ['$window','$location','$http','$scope','$timeout','$filter',  function ($window,$location,$http,$scope,$timeout,$filter) {
		// default values for pagination and filtering
		$scope.currentPage = 1;
		$scope.pageSize = 10;
		$scope.maxSize = 10;
		$scope.start = 0;
		$scope.end = 0;
		$scope.numOfPages = 5;
		$scope.filteredItems = [];
		$scope.startItems = [];
		$scope.pagedItems = [];
		$scope.data = null;
		$scope.query = {browser: ""};
		
		$scope.eStudent = [];
		$scope.dStudent = [];
		
		$scope.gridOptions4 = {
			data: [],
			urlSync: true
  		};
		$scope.selclass= 0;
		
		$scope.pageChangeHandler = function(num) {
		console.log('meals page changed to ' + num);
		};
		

		$scope.getStudents = function() {
			console.log("selclass "+ $scope.selclass);
			var request = $http({
				method: "POST",
				url: "ajax/selectData/getvanReport.php",
				//data: $scope.data.section,
				data: { selclass: $scope.selclass},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			});
			// Check whether the HTTP Request is Successfull or not. //
			request.success(function (response) {
				console.log(response);
				
				
				var CSVBody	= new Array();
				for( var j = 0; j < response.length; j++  ) {
					
					var sno 		= response[j]['SNO'];
					var adno 		= response[j]['ADNO'];
					var name 		= response[j]['NAME'];
					var classsec 	= response[j]['STD_SEC'];
					var fterm1		= response[j]['term1'];
					var fterm2 		= response[j]['term2'];
					var fterm3 		= response[j]['term3'];
					var ftot 		= response[j]['term3'];
					var tot_paid 	= response[j]['total_paid'];
					var balance 	= response[j]['balance'];

					CSVBody.push({"SNO":sno, 
					"ADMISSION_ID":adno, 
					"NAME":name, 
					"CLASS":classsec, 
					"TERM1":fterm1, 
					"TERM2":fterm2, 
					"TERM3":fterm3, 
					"TOTAL":ftot, 
					"PAID":tot_paid, 
					"BALANCE":balance});
				}
				
				$scope.gridOptions4.data = CSVBody;
				
				$scope.vanreport = response;
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



		$scope.getCSVHeader = function () {return ["SNO", "ADMISSION_ID","NAME","CLASS","TERM1", "TERM2", "TERM3","TOTAL","PAID","BALANCE"]};
		
		$scope.export = function(){
			html2canvas(document.getElementById('exportthis'), {
				onrendered: function (canvas) {
					
					var data = canvas.toDataURL();
					var docDefinition = {
						
						content: [{
							image: data,
							width: 500,	  
							pageSize: 'A5',
							pageOrientation: 'landscape',
							pageMargins: [ 40, 60, 40, 60 ],
						}]
						
					};
					pdfMake.createPdf(docDefinition).download("test.pdf");
				}
			});
		}	
	
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
				//console.log("CLASS LIST : " + response);
				$scope.classes = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
							
	
		$scope.checkAll = function () {
			if ($scope.selectedAll) {
				$scope.selectedAll = true;
			} else {
				$scope.selectedAll = false;
			}
			angular.forEach($scope.students, function (item) {
				item.checked = $scope.selectedAll;
			});
		
		};
	
		$scope.selectAllFriends = function() {
			angular.forEach($scope.students, function(student){
				student.checked = true;
			});
		};
		
		$scope.deSelectAllFriends = function() {
			angular.forEach($scope.students, function(student){
				student.checked = false;
			});
		};
		
		$scope.selectedFriends = function () {
			return $filter('filter')($scope.students, {checked: true});
		};

		$scope.saveSMS = function() {
			$scope.selStudent	=	[];
			
			angular.forEach($scope.students, function(student){
				if( student.checked == true ) {
					var adno = student.ADNO;
					var balance = student.TOT_BAL;
					$scope.selStudent.push({"ADNO":adno, "AMOUNT":balance});
				}
			});
			
			//console.log($scope.selStudent);
			<!--<pre><strong>{{selectedFriends().length}} selected with filter:</strong> {{students | filter:{checked:true} | json}}</pre>-->
			
			$http({
				method: 'POST',
				url: "ajax/insertData/insertPersonalizedMsg.php",
				data: {
					iStudent: $scope.selStudent
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log("Webexcel Technologies");
				console.log(response.data);
				$scope.MSGSuccess = {
					SUCCESS : response.data.success,
					FAILURE : response.data.failled
				};

				$("#SavePersonalizedMSGStatusModal").modal('show');
				$scope.getStudents();
				$scope.selStudent	=	[];
			}, function errorCallback(response) {
				console.log(response);
			});		
			
		}

	
		$scope.recpNo	=	function(rno) {
			while( rno.charAt( 0 ) === '#' )
    			rno = rno.slice( 1 );
			
			return parseInt(rno);
		};
		
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

		$scope.showDetail = function (u) {
			if ($scope.active != u.ADMISSION_ID) {
				$scope.active = u.ADMISSION_ID;
			} else {
				$scope.active = null;
			}
		};
		
		$scope.balance = function(ta, pa) {
			return bal = parseInt(ta) - parseInt(pa);
		};
		
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
					$window.location.href = "vehicle-feeReport.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
				
			}	

    }])



