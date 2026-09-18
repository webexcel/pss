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
	

	app.controller('reportCtrl', ['$window','$location','$http', '$scope', '$timeout', '$filter',  function ($window,$location,$http, $scope, $timeout, $filter) {
		// default values for pagination and filtering
		$scope.pageSize = 10;
		$scope.maxSize = 10;
		$scope.start = 0;
		$scope.end = 0;
		$scope.currentPage = 1;
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
		
		$scope.pageChangeHandler = function(num) {
			console.log('page changed to ' + num);
		};
		
		/*
		$http({
			method: 'POST',
			url: "ajax/selectData/getReports.php",
			data: {
				data: ''
			},
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
		}).then(function successCallback(response) {
			console.log(response);

			$scope.students = response;
			$scope.list = response;
			$scope.currentPage = 1; //current page
			$scope.entryLimit = 10; //max no of items to display in a page
			$scope.filteredItems = $scope.list.length; //Initially for no filter  
			$scope.totalItems = $scope.list.length;	
			
		}, function errorCallback(response) {
			console.log(response);
		});		
		*/
		
		/*
		$http({
			method: 'GET',
			url: 'ajax/selectData/getReports.php'
		}).then(function successCallback(response) {

			console.log(response);
			
			$scope.students = response;
			$scope.list = response;
			$scope.currentPage = 1; //current page
			$scope.entryLimit = 10; //max no of items to display in a page
			$scope.filteredItems = $scope.list.length; //Initially for no filter  
			$scope.totalItems = $scope.list.length;	
			
		}, function errorCallback(response) {
			console.log(response);
		});		
		*/
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
					$window.location.href = "reports.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
				
			}
		
		$scope.getStudents = function() {
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
				
				
				var CSVBody	= new Array();
				for( var j = 0; j < response.length; j++  ) {
					
					var sno = response[j]['SNO'];
					var adno = response[j]['ADNO'];
					var name = response[j]['NAME'];
					
					var fname = response[j]['FATHER_NAME'];
					var classsec = response[j]['STD_SEC'];
					var tot_amt = response[j]['TOT_AMT'];
					var tot_paid = response[j]['TOT_PAID'];
					var balance = response[j]['TOT_BAL'];

					CSVBody.push({"SNO": sno, "ADMISSION_ID":adno, "NAME":name, "FATHER_NAME":fname, "SECTION": classsec, "TOT_AMT": tot_amt, "TOT_PAID": tot_paid, "BALANCE": balance});
				}
				
				$scope.gridOptions4.data = CSVBody;
				
				$scope.students = response;
				$scope.list = response;
				
				$scope.currentPage = 1; //current page
				$scope.entryLimit = 20; //max no of items to display in a page
				$scope.filteredItems = $scope.list.length; //Initially for no filter  
				$scope.totalItems = $scope.list.length;
				
				
				/*
				$scope.totalItems = 100; //this needs to be changed to represent the total of filtered parks after a search is done and NOT a static number.
				$scope.currentPage = 1;
				$scope.maxSize = 8;
				$scope.itemsPerPage = 10;
				*/
				
			});
			request.error(function (data) {
				$scope.message = "From PHP file : "+data;
			});
			
		}	
		$scope.getStudents();
		$scope.getCSVHeader = function () {return ["SNO", "ADMISSION_ID", "NAME", "FATHER_NAME", "SECTION","TOT_AMT","TOT_PAID", "BALANCE"]};
		
		$scope.export = function(){
			html2canvas(document.getElementById('exportthis'), {
				onrendered: function (canvas) {
					//var blob = new Blob([document.getElementById('exportthis').innerHTML])
					var data = canvas.toDataURL();
					var docDefinition = {
						//content: []
						
						/*content: [{
							image: data,
							width: 500,
						}]*/
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
				$scope.classes = response;
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
		
		/*
		$http({
			method: 'GET',
			url: 'ajax/selectData/getClass.php'
		}).then(function successCallback(response) {
			$scope.classes = response.data;
			console.log("CLASS")
			console.log($scope.classes);
			console.log("CLASS")
		}, function errorCallback(response) {
			console.log(response);
		});	
		*/
		
		$http({
			method: 'GET',
			url: 'ajax/selectData/getMonth.php'
		}).then(function successCallback(response) {
			$scope.months = response.data;
		}, function errorCallback(response) {
			console.log(response);
		});		
	
	
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
			/*
			for(var i=0; i<$scope.students.length; i++) {
				if( $scope.students[i].checked == true ) {
					var adno = $scope.students[i].ADNO;
					var balance = $scope.students[i].TOT_BAL;
					$scope.selStudent.push({"ADNO":adno, "AMOUNT":balance});
				}
			}
			*/
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
		
		
		
	
		
	
		
		
		
		
		/*
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
				console.log(response);
				$scope.classes = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
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
		

    }])



