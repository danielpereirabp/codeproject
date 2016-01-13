angular.module('app.controllers')
	.controller('ProjectFileNewController', [
		'$scope', '$location', '$routeParams', 'appConfig', 'Url', 'Upload',
		function($scope, $location, $routeParams, appConfig, Url, Upload) {
			
			$scope.save = function () {
				if ($scope.form.$valid) {
					var url = appConfig.baseUrl + Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
						id: $routeParams.id,
						idFile: ''
					});
					Upload.upload({
			            url: url,
			            data: {
			            	file: $scope.projectFile.file,
			            	'name': $scope.projectFile.name,
			            	'description': $scope.projectFile.description
			            }
			        }).then(function (resp) {
			            console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
			            $location.path('/project/' + $routeParams.id + '/files');
			        }, function (resp) {
			            console.log('Error status: ' + resp.status);
			        }, function (evt) {
			            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
			            console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
			        });
				}
			}
	}]);