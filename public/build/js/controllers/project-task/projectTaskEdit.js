angular.module('app.controllers')
	.controller('ProjectTaskEditController', [
		'$scope', '$location', '$routeParams', 'ProjectTask', 'appConfig',
		function($scope, $location, $routeParams, ProjectTask, appConfig) {
			$scope.projectTask = ProjectTask.get({
				id: $routeParams.id,
				idTask: $routeParams.idTask
			});

			$scope.status = appConfig.projectTask.status;

			$scope.start_date = {
				status: {
					opened: false
				}
			};

			$scope.due_date = {
				status: {
					opened: false
				}
			};

			$scope.openStartDate = function ($event) {
				$scope.start_date.status.opened = true;
			};

			$scope.openDueDate = function ($event) {
				$scope.due_date.status.opened = true;
			};

			$scope.save = function () {
				if ($scope.form.$valid) {
					ProjectTask.update({
						id: $scope.projectTask.project_id,
						idTask: $scope.projectTask.id
					}, $scope.projectTask, function () {
						$location.path('/project/'+$routeParams.id+'/tasks');
					});
				}
			}
		}
	]);