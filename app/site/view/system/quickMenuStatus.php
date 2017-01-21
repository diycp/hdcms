<extend file="resource/view/site"/>
<block name="content">
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="#">更新站点缓存</a></li>
	</ul>
	<div class="alert alert-info">
		<i class="fa fa-info-circle"></i> 快捷菜用于将常用菜单放在页面底部,但不建议放置太多。<br>
		<i class="fa fa-info-circle"></i> 每个管理员都有自己独立的菜单配置。<br>
	</div>
	<form action="" method="post" role="form" class="form-horizontal">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">更改快捷菜单状态</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">菜单状态</label>
					<div class="col-sm-10">
						<label class="checkbox-inline">
							<input type="radio" value="1" name="status" {{$status?'checked':''}}> 开启
						</label>
						<label class="checkbox-inline">
							<input type="radio" value="0" name="status" {{$status?'':'checked'}}> 关闭
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-2">
			<button type="submit" class="btn btn-success col-sm-offset-0">保存更改</button>
		</div>
	</form>
</block>