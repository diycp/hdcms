<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace system\model;

/**
 * 站点配置管理
 * Class SiteSetting
 * @package system\model
 */
class SiteSetting extends Common {
	protected $table = 'site_setting';
	protected $allowFill = [ '*' ];
	protected $validate = [ ];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH ],
		[ 'grouplevel', 1, 'string', self::NOT_EXIST_AUTO, self::MODEL_INSERT ],
		[ 'default_template', 1, 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'welcome', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'default_message', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'smtp', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH ],
		[ 'pay', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH ],
		[ 'creditnames', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH ],
		[ 'creditbehaviors', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH ],
		[ 'register', 'json_encode', 'function', self::EXIST_AUTO, self::MODEL_BOTH ],
	];
}