<?php
namespace system\middleware;

use system\model\Site;

/**
 * CMS系统初始中间件
 * Class Initialize
 * @package system\middleware
 */
class Initialize {
	//执行中间件
	public function run() {
		//异步时隐藏父模板
		IS_AJAX and c( 'view.blade', FALSE );
		//初始用户信息
		$this->initUserInfo();
		//加载系统配置项,对是系统配置不是站点配置
		$this->loadConfig();
		//初始站点数据
		$this->siteInitialize();
		//初始模块数据
		$this->moduleInitialize();
	}

	//初始用户信息
	protected function initUserInfo() {
		//前台访问
		$user                        = [ ];
		$user['system']['user_type'] = isset( $_GET['t'] ) && $_GET['t'] == 'web' ? 'member' : 'admin';
		switch ( $user['system']['user_type'] ) {
			case 'member':
				//前台用户
				if ( isset( $_SESSION['member_uid'] ) ) {
					$user['user'] = Db::table( 'member' )->find( $_SESSION['member_uid'] );
					v( 'user', $user );
				}
				break;
			case 'admin':
				//后台用户
				if ( isset( $_SESSION['admin_uid'] ) ) {
					$user['user']                 = Db::table( 'user' )->find( $_SESSION['admin_uid'] )->toArray();
					$group                        = Db::table( 'user_group' )->where( 'id', $user['groupid'] )->first();
					$user['group']                = $group ? $group->toArray() : [ ];
					$user['system']['super_user'] = $user['group']['id'] == 0;
					v( 'user', $user );
				}
				break;
		}
	}

	//加载系统配置项
	protected function loadConfig() {
		$config             = Db::table( 'config' )->field( 'site,register' )->find( 1 )->toArray();
		$config['site']     = json_decode( $config['site'], TRUE );
		$config['register'] = json_decode( $config['register'], TRUE );
		v( 'config', $config );
	}

	//模块初始化
	protected function moduleInitialize() {
		if ( $name = q( 'get.m' ) ) {
			v( 'module', Db::table( 'modules' )->where( 'name', $name )->first() );
		}
		//扩展模块访问
		if ( ! empty( $_GET['a'] ) ) {
			$_GET['s'] = 'site/module/entry';
		}
	}

	//站点信息初始化
	protected function siteInitialize() {
		$siteModel = new Site();
		//缓存站点数据
		$siteid = q( 'get.siteid', Session::get( 'siteid' ), 'intval' );
		if ( $siteid ) {
			if ( $siteModel->find( $siteid )->toArray() ) {
				Session::set( 'siteid', $siteid );
				define( 'SITEID', $siteid );
				//加载站点缓存
				$siteModel->loadSite();
			} else {
				message( '你访问的站点不存在', 'back', 'error' );
			}
		}
	}
}