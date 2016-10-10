<extend file="resource/view/system"/>
<block name="content">
	<ol class="breadcrumb">
		<li><i class="fa fa-home"></i></li>
		<li><a href="?s=system/manage/menu">系统</a></li>
		<li class="active">一键更新</li>
	</ol>
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="#">系统更新</a></li>
	</ul>
	<form action="" class="form-horizontal ng-cloak" id="form" ng-cloak ng-controller="ctrl">
		<div class="panel panel-default" ng-if="error==''">
			<div class="panel-heading">
				温馨提示
			</div>
			<div class="panel-body">
				<p style="margin: 0px;">
					正在更新数据表...
				</p>
			</div>
		</div>
		<div class="alert alert-info">
			<p>Release版本: Build {{$data['data']['version'][0]['releaseCode']}}</p>
		</div>
	</form>
</block>
<script>
	require(['angular', 'util'], function (angular, util) {
		angular.module(['myApp'], []).controller('ctrl', ['$scope', '$http', function ($scope, $http) {
			$scope.error = '';
			$scope.success = '';
			$scope.upgrade = function () {
				//执行更新
				$.post("{{__URL__}}", function (res) {
					if (res.valid == 2) {
						location.href = "{{u('upgrade',['action'=>'finish'])}}";
					}
					$scope.$apply();
				}, 'json');
			}
			$scope.upgrade();
		}]);
		angular.bootstrap(document.getElementById('form'), ['myApp']);
	})
</script>