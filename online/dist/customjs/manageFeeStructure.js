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
	
	app.controller('feeStructureCtrl', ['$window','$location','$http', '$scope', '$timeout',  function ($window,$location,$http, $scope, $timeout) {
		
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
						$window.location.href = "manage-fees-structure.php"; //You should have http here.
						console.log(response);
					}).error(function(response) {
						console.log(response);
					});
				
			}
		
		
		$http({
			method: 'GET',
			url: 'ajax/selectData/getFeeGroup.php'
		}).then(function successCallback(response) {
			console.log(response);
			$scope.feeGroups = response.data;
			console.log($scope.feeGroups);
		}, function errorCallback(response) {
			console.log(response);
		});			
		
		
		$scope.changeFeeGroup = function() {
			$scope.feegroupText = $scope.feegroup;
			$http({
				method: 'POST',
				url: "ajax/selectData/getFeeStructure.php",
				data: {
					feeGroup: $scope.feegroup
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log(response);
				$scope.feeStructure	=	response.data
			}, function errorCallback(response) {
				console.log(response);
			});
			
		};

		$scope.updateFeesStructure = function(fGroupMapId, feeAmount) {
			
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
			
			
		}
		
		$http({
			method: 'GET',
			url: 'ajax/selectData/getClass.php'
		}).then(function successCallback(response) {
			$scope.classes	=	response.data;
		}, function errorCallback(response) {
			
		});
		
		/*
		$http({
			method: 'GET',
			url: 'ajax/selectData/getFeeHeads.php'
		}).then(function successCallback(response) {
			$scope.feeHeads	=	response.data;
			console.log($scope.feeHeads);
		}, function errorCallback(response) {
			
		});
		*/
		
		//$scope.feetype = [{ftype:"Annual"}, {ftype: "Monthly"}, {ftype: "Term"}];
		//$scope.feetype = [{ftype:"Book-1"}, {ftype: "Book-2"}, {ftype: "Book-3"}];

		$scope.feeGroupMapping = function() {
				$scope.bform = {
				feegroup : $scope.feegroup
			}
			$http({
				method: 'GET',
				url: 'ajax/selectData/getFeeHeads.php?fgid='+$scope.feegroup
			}).then(function successCallback(response) {
				$scope.feeHeads	=	response.data;
				console.log($scope.feeHeads);
			}, function errorCallback(response) {
				
			});			
			$("#modalGroupMapping").modal('show');
			$scope.saveBtnIsDisabled=false;
		};
		
		$scope.saveFeeGroupMapping = function() {
			$scope.saveBtnIsDisabled=true;

			console.log($scope.bform);
			$http({
				method: 'POST',
				url: "ajax/insertData/insertFeeStructure.php",
				
				data: $scope.bform,
				//data: {
				//	feeGroupMapId: fGroupMapId,
				//	feeAmount: feeAmount
				//},
				//data: { feeGroupMapId: fGroupMapId, feeAmount: feeAmount },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log(response)
				$("#modalGroupMapping").modal('hide');
				$scope.changeFeeGroup();
			}, function errorCallback(response) {
				console.log(response);
			});				
			
		};
		
		$scope.saveFeeGroupMappingStatus = function(id,GrpId,head,amt,sdate,ddate) {
			console.log($scope.feeStructure,"ko2");
			$http({
				method: 'POST',
				url: "ajax/insertData/insertfeeStatus.php",				
				data: {
				id:id,
				feegroup:GrpId,
				feeheadid:head,
				feeamount:amt,
				startdate:sdate,
				duedate:ddate
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log(response)
				$scope.changeFeeGroup();
			}, function errorCallback(response) {
				console.log(response);
			});				
			
		};
		
		$scope.saveFeeGroupMappingUpdate = function(Amount,id,GrpId,head,amt) {
			console.log(Amount);
			$http({
				method: 'POST',
				url: "ajax/updateData/updatefeegroupmappingStatus.php",				
				data: {
				Amount: Amount,
				id:id,
				feegroupId:GrpId,
				feeheadId:head,
				feeamount:amt
				},
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log(response)
				$scope.changeFeeGroup();
			}, function errorCallback(response) {
				console.log(response);
			});				
			
		};
		
		
		
		$scope.newFeeModal = function() {
			$scope.aform	=	{};
			$("#modalNewFee").modal('show');
			
		};
		
		$scope.saveNewFeeHead	=	function() {
			console.log($scope.aform);
			
			$scope.fHeadStatus	=	"";
			$http({
				method: 'POST',
				url: "ajax/insertData/insertFeeHead.php",
				
				data: $scope.aform,
				//data: {
				//	feeGroupMapId: fGroupMapId,
				//	feeAmount: feeAmount
				//},
				//data: { feeGroupMapId: fGroupMapId, feeAmount: feeAmount },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				
				$scope.aform	=	{};
				if( response.data.error == false ) {
					$scope.aform.fHeadStatus	=	"Fee Head saved successfully.";
					
				} else {
					$scope.aform.fHeadStatus	=	"Fee Head save failled. Please try again";
				}
				
			}, function errorCallback(response) {
				//$("#modalNewFee").modal('hide');
				console.log(response);
			});			
		};
		
		$scope.newFeeStructure = function() {
			console.log($scope.aform);
			$http({
				method: 'POST',
				url: "ajax/insertData/insertFeeStructure.php",
				
				data: $scope.aform,
				//data: {
				//	feeGroupMapId: fGroupMapId,
				//	feeAmount: feeAmount
				//},
				//data: { feeGroupMapId: fGroupMapId, feeAmount: feeAmount },
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			}).then(function successCallback(response) {
				console.log(response)
				$("#newFeesForm").modal('hide');
				$scope.changeFeeGroup();
			}, function errorCallback(response) {
				console.log(response);
			});				
		}


		$http({
			method: 'GET',
			//url: 'ajax/selectData/getAllClassFeeStructure.php'
			url: 'ajax/selectData/getStudentFeeStructure.php'
		}).then(function successCallback(response) {
			//console.log(response);
			$scope.temp = response.data;
			for(var i = 0; i < $scope.temp.length; i++){
				var varcoltotal = parseFloat('0.0');
				for (var j = 0; j<Object.keys($scope.temp[i]).length; j++)
				{
					//console.log(parseFloat( Object.values($scope.temp[i])[j]));
					if(parseFloat( Object.values($scope.temp[i])[j]) > 0)
					{
						varcoltotal = parseFloat(varcoltotal) + parseFloat(Object.values($scope.temp[i])[j]);
					}
					
				}
				$scope.temp[i].Total =varcoltotal;
				//console.log($scope.temp[i].coltotal);

			}
			$scope.allClassFeeStructure = $scope.temp;
			$scope.perPage = 20;
			$scope.maxSize = 5;
			$scope.setPage = function (pageNo) {
			$scope.currentPage = pageNo;
			};
			
		}, function errorCallback(response) {
			console.log(response);
		});

	
		$scope.getCSVHeader = function () {return ["CLASS_SECTION", "FEE_HEAD", "FEE_TYPE", "FEE_INTERVAL", "FEE_INSTALMENT", "FEE_AMOUNT"]};





		/*
		$scope.getStudents = function() {
			console.log("CLASS ID : "+ $scope.class);
			console.log("MONTH FROM : "+ $scope.monthFrom);
			console.log("MONTH TO : "+ $scope.monthTo);
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
				//return false;
				
				$scope.gridOptions4.data = response;
				
				$scope.students = response;
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
		*/
		/*
		$scope.getClass = function() {
			$http.get('ajax/selectData/getClass.php')
			.success(function(response){
				console.log("CLASS LIST : " + response);
				$scope.classes = response
			}).error(function(err){
				console.log(err);
			});
		}
		$scope.getClass();
		*/
		/*
		$http({
			method: 'GET',
			url: 'ajax/selectData/getMonth.php'
		}).then(function successCallback(response) {
			$scope.months = response.data;
		}, function errorCallback(response) {
			console.log(response);
		});		
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


    }])



