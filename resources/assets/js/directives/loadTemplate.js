angular.module('app.directives')
	.directive('loadTemplate', [
		'$http', '$compile', 'OAuth', function ($http, $compile, OAuth) {
			return {
				restrict: 'E',
				link: function (scope, element, attr) {
					scope.$on('$routeChangeStart', function (event, next, current) {
						if (OAuth.isAuthenticated()) {
							if ('/login' !== next.$$route.originalPath && '/logout' !== next.$$route.originalPath) {
								if (! scope.isTemplateLoad) {
									scope.isTemplateLoad = true;
									$http.get(attr.url).then(function(response) {
										element.html(response.data);
										$compile(element.contents())(scope);
									});
								}
								return;
							}
						}

						resetTemplate();

						function resetTemplate() {
							scope.isTemplateLoad = false;
							element.html('');
						}
					});
				}
			};
		}
	]);