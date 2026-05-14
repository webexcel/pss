var app = angular.module('ngApp', ['ui.bootstrap', "ngSanitize", "ngCsv"])

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
	
	
	app.directive('ngFiles', ['$parse', function ($parse) {
    	function fn_link(scope, element, attrs) {
        	var onChange = $parse(attrs.ngFiles);
            element.on('change', function (event) {
            	onChange(scope, { $files: event.target.files });
            });
		};

		return {
			link: fn_link
		}
		
	}]);
	
    app.controller('studentsCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http,$scope, $timeout) {
		// default values for pagination and filtering
		$scope.pageSize = 10;
		$scope.maxSize = 10;
		$scope.start = 0;
		$scope.end = 0;
		$scope.currentPage = 0;
		$scope.numOfPages = 5;
		$scope.filteredItems = [];
		$scope.startItems = [];
		$scope.pagedItems = [];
		$scope.data = null;
		$scope.query = {browser: ""};		
		$scope.eStudent = {};
		$scope.dStudent = {};				
		

		//<---------------------------   Academic Year ---------------------------------------->//
		
		$scope.saveacademic = function(aStudent) {
			var $response = [];					
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insAcademic.php",
					data: { md: $scope.md },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {				
					$scope.response	=	response;
					$scope.md.year = "";
					$("#AdnoStudentModal").modal('show');
					$scope.getAcademic();					
				}).error(function(response) {
					console.log(response.academic);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
			
		$scope.getAcademic = function() {
			$http.get('ajax/selectData/getAcademic.php')
			.success(function(response){
				console.log(response);
				$scope.Academic = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getAcademic();

		$scope.editStudent = function(es) {
			$scope.eStudent = {
				eid : es.YearId,
				eYear : es.AcademicYear 
			};
			$("#studentEditForm").modal('show');
		};		
		$scope.updateStudent = function() {
			console.log($scope.eStudent);			
			$http({
				method: "post",
				url: "ajax/updateData/updateAcademic.php",
				data: { uStudent: $scope.eStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#studentEditForm").modal('hide');
				$scope.getAcademic();
			}).error(function(response) {
				console.log(response);
			});
		}
		
		$scope.delStudent = function(ds) {
			$scope.dStudent = { dAcad : ds.AcademicYear };
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.deleteStudent = function() {
			console.log('aaaaa'+$scope.dStudent);							
			$http({
				method: "post",
				url: "ajax/deleteData/deleteAcademic.php",
				data: {
					uStudent: $scope.dStudent
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#deleteStudentModal").modal('hide');
				$scope.getAcademic();
			}).error(function(response) {
				console.log(response);
			});				
		}

		//<---------------------------   end ---------------------------------------->//
		
		//<---------------------------  Class and Section ---------------------------------------->//
		
		$scope.saveClasssec = function(aStudent) {
			var $response = [];					
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insClasssec.php",
					data: { md: $scope.md },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {				
					$scope.response	=	response;
					$scope.md.mclass = "";
					$scope.md.msec = "";
					$scope.md.madno = "";
					$("#AdnoStudentModal").modal('show');
					$scope.getClasssec();					
				}).error(function(response) {
					//console.log(response.academic);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
			
		$scope.getClasssec = function() {
			$http.get('ajax/selectData/getClasssec.php')
			.success(function(response){
				console.log(response);
				$scope.classsec = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClasssec();

		$scope.editClasssec = function(es) {
			$scope.eStudent = {
				eCid : es.CLASS_ID,
				eClass : es.Standard,
				eSec : es.Section,
				eAdnosuff : es.AdnoSuffix
			};
			$("#studentEditForm").modal('show');
		};
		
		$scope.updateClasssec = function() {
			console.log($scope.eStudent);			
			$http({
				method: "post",
				url: "ajax/updateData/updateClasssec.php",
				data: { uStudent: $scope.eStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#studentEditForm").modal('hide');
				$scope.getClasssec();
			}).error(function(response) {
				console.log(response);
			});
		}
		
		//<---------------------------   end ---------------------------------------->//
		
		//<---------------------------   Fee Group Name ---------------------------------------->//
		
		$scope.saveGroup = function(aStudent) {
			var $response = [];					
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insGroupname.php",
					data: { md: $scope.md },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {				
					$scope.response	=	response;
					$scope.md.gname = "";
					$("#AdnoStudentModal").modal('show');
					$scope.getgroupname();					
				}).error(function(response) {
					//console.log(response.academic);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
			
		$scope.getgroupname = function() {
			$http.get('ajax/selectData/getGroupname.php')
			.success(function(response){
				console.log(response);
				$scope.Groupname = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getgroupname();

		$scope.editgroup = function(es) {
			$scope.eStudent = {
				eGid : es.feeGroupId,
				eGroup : es.feeGroup 
			};
			$("#studentEditForm").modal('show');
		};		
		$scope.updategroup = function() {
			console.log($scope.eStudent);			
			$http({
				method: "post",
				url: "ajax/updateData/updateGroupname.php",
				data: { uStudent: $scope.eStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#studentEditForm").modal('hide');
				$scope.getgroupname();
			}).error(function(response) {
				console.log(response);
			});
		}
		
		$scope.delgroup = function(ds) {
			$scope.dStudent = { 
				Gid : ds.feeGroupId,					
				Gname : ds.feeGroup,
				Gyearid : ds.Year_Id			
			};
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.deletegroup = function() {							
			$http({
				method: "post",
				url: "ajax/deleteData/deleteAcademic.php",
				data: {
					uStudent: $scope.dStudent
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#deleteStudentModal").modal('hide');
				$scope.getgroupname();
			}).error(function(response) {
				console.log(response);
			});				
		}

		//<---------------------------   end ---------------------------------------->//
		
		//<---------------------------   Bill Book Name ---------------------------------------->//
		
		$scope.saveBillbook = function(aStudent) {
			var $response = [];					
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insBillbook.php",
					data: { md: $scope.md },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {				
					$scope.response	=	response;
					$scope.md.bname = "";
					$scope.md.btype = "";
					$("#AdnoStudentModal").modal('show');
					$scope.getBillbook();					
				}).error(function(response) {
					//console.log(response.academic);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
			
		$scope.getbillbook = function() {
			$http.get('ajax/selectData/getbillbook.php')
			.success(function(response){
				console.log(response);
				$scope.Billbookname = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getbillbook();

		$scope.editBillbook = function(es) {
			$scope.eStudent = {
				eBno : es.billBookId,
				eBname : es.BillBookName, 
				eBtype : es.SerialCode
			};
			$("#studentEditForm").modal('show');
		};		
		$scope.updatebillbook = function() {
			console.log($scope.eStudent);			
			$http({
				method: "post",
				url: "ajax/updateData/updatebillbook.php",
				data: { uStudent: $scope.eStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#studentEditForm").modal('hide');
				$scope.getbillbook();
			}).error(function(response) {
				console.log(response);
			});
		}
		
		
		//<---------------------------   end ---------------------------------------->//
		
		
		//<---------------------------  Language Name ---------------------------------------->//
		
		$scope.savelang = function(aStudent) {
			var $response = [];					
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insLangname.php",
					data: { md: $scope.md },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {				
					$scope.response	=	response;
					$scope.md.Lname = "";
					$("#AdnoStudentModal").modal('show');
					$scope.getlangname();					
				}).error(function(response) {
					//console.log(response.academic);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
			
		$scope.getlangname = function() {
			$http.get('ajax/selectData/getLangname.php')
			.success(function(response){
				console.log(response);
				$scope.Langname = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getlangname();

		$scope.editlang = function(es) {
			$scope.eStudent = {
				eLid : es.langId,
				elang : es.langName
			};
			$("#studentEditForm").modal('show');
		};
		
		$scope.updatelang = function() {
			console.log($scope.eStudent);			
			$http({
				method: "post",
				url: "ajax/updateData/updateLangname.php",
				data: { uStudent: $scope.eStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				$("#studentEditForm").modal('hide');
				$scope.getlangname();
			}).error(function(response) {
				console.log(response);
			});
		}
		
		$scope.dellang = function(ds) {
			$scope.dStudent = { 
				Lid : ds.langId,	
				Lname : ds.langName	
				
			};
			$("#deleteStudentModal").modal('show');
		}
		
		$scope.deleteLang = function() {							
			$http({
				method: "post",
				url: "ajax/deleteData/deleteLangname.php",
				data: {
					uStudent: $scope.dStudent
					},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#deleteStudentModal").modal('hide');
				$scope.getlangname();
			}).error(function(response) {
				console.log(response);
			});				
		}

		//<---------------------------   end ---------------------------------------->//
		
		//<---------------------------   Academic Year ---------------------------------------->//
		
		$scope.saveHeadname = function(aStudent) {
			var $response = [];					
			if ($scope.myForm.$valid) {			
				$http({
					method: "post",
					url: "ajax/insertData/insHeadname.php",
					data: { md: $scope.md },
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
				}).success(function(response) {				
					$scope.response	=	response;
					$scope.md.head = "";
					$("#AdnoStudentModal").modal('show');
					$scope.getOtherfeeheads();					
				}).error(function(response) {
					//console.log(response.academic);
				});
			} else {
				alert("There are invalid fields");
				return false;	
			}
		};
		
			
		$scope.getOtherfeeheads = function() {
			$http.get('ajax/selectData/getOtherfeeheads.php')
			.success(function(response){
				console.log(response);
				$scope.head = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getOtherfeeheads();

		$scope.edithead = function(es) {
			$scope.eStudent = {
				eid : es.fid,
				efeehead : es.feetype 
			};
			$("#studentEditForm").modal('show');
		};		
		$scope.updateHeads = function() {
			console.log($scope.eStudent);			
			$http({
				method: "post",
				url: "ajax/updateData/updateHeadname.php",
				data: { uStudent: $scope.eStudent },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).success(function(response) {
				//console.log(response);
				$("#studentEditForm").modal('hide');
				$scope.getOtherfeeheads();
			}).error(function(response) {
				console.log(response);
			});
		}


		//<---------------------------   end ---------------------------------------->//
		
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
					$window.location.href = "md-class.php"; //You should have http here.
					console.log(response);
				}).error(function(response) {
					console.log(response);
				});
			
		}
		

    }])



