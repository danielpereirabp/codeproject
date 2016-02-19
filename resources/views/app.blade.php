<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	@if(Config::get('app.debug'))
		<link href="{{ asset('build/css/font-awesome.css') }}" rel="stylesheet">
		<link href="{{ asset('build/css/flaticon.css') }}" rel="stylesheet">
		<!-- <link href="{{ asset('build/css/vendor/bootstrap-theme.min.css') }}" rel="stylesheet"> -->
		<link href="{{ asset('build/css/components.css') }}" rel="stylesheet">
		<link href="{{ asset('build/css/app.css') }}" rel="stylesheet">
	@else
		<link href="{{ elixir('css/all.css') }}" rel="stylesheet">
	@endif

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<load-template url="build/views/templates/menu.html"></load-template>

	<div ng-view></div>

	<!-- Scripts -->
	@if(Config::get('app.debug'))
		<script src="{{ asset('build/js/vendor/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-route.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-resource.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-animate.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-messages.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/ui-bootstrap-tpls.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/navbar.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-cookies.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/query-string.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/angular-oauth2.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/ng-file-upload.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/http-auth-interceptor.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/vendor/dirPagination.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/app.js') }}" type="text/javascript"></script>

		<!-- CONTROLLERS !-->
		<script src="{{ asset('build/js/controllers/login.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/loginModal.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/home.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/menu.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/client/clientDashboard.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/client/clientList.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/client/clientNew.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/client/clientEdit.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/client/clientRemove.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/project/projectDashboard.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project/projectList.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project/projectNew.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project/projectEdit.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project/projectRemove.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/project-note/projectNoteShow.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-note/projectNoteList.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-note/projectNoteNew.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-note/projectNoteEdit.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-note/projectNoteRemove.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/project-file/projectFileList.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-file/projectFileNew.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-file/projectFileEdit.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-file/projectFileRemove.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/project-task/projectTaskList.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-task/projectTaskNew.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-task/projectTaskEdit.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-task/projectTaskRemove.js') }}" type="text/javascript"></script>

		<script src="{{ asset('build/js/controllers/project-member/projectMemberList.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/controllers/project-member/projectMemberRemove.js') }}" type="text/javascript"></script>

		<!-- DIRECTIVES !-->
		<script src="{{ asset('build/js/directives/projectFileDownload.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/loginForm.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/loadTemplate.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/menuActivated.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/directives/tabProject.js') }}" type="text/javascript"></script>

		<!-- FILTERS !-->
		<script src="{{ asset('build/js/filters/date-br.js') }}" type="text/javascript"></script>

		<!-- SERVICES !-->
		<script src="{{ asset('build/js/services/url.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/oauthFixInterceptor.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/client.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/project.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectNote.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectFile.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectTask.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/projectMember.js') }}" type="text/javascript"></script>
		<script src="{{ asset('build/js/services/user.js') }}" type="text/javascript"></script>
	@else
		<script src="{{ elixir('js/all.js') }}" type="text/javascript"></script>
	@endif
</body>
</html>
