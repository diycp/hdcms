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

class SiteWechat extends Common {
	protected $table = 'site_wechat';
	protected $validate = [
		[ 'siteid', 'required', '站点编号不能为空', self::MUST_VALIDATE, self::MODEL_INSERT ],
		[ 'wename', 'required', '微信名称不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
		[ 'account', 'required', '公众号帐号不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
		[ 'original', 'required', '原始ID不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
		[ 'appid', 'required', 'appid不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
		[ 'appsecret', 'required', 'appsecret不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
		[ 'token', 'required', 'token不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
		[ 'encodingaeskey', 'required', 'encodingaeskey不能为空', self::EXIST_VALIDATE, self::MODEL_INSERT ],
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH ],
		[ 'level', 1, 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'qrcode', '', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'icon', 'resource/images/hd.png', 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'is_connect', 0, 'string', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'token', 'autoToken', 'method', self::EMPTY_AUTO, self::MODEL_INSERT ],
		[ 'encodingaeskey', 'autoEncodingaeskey', 'method', self::EMPTY_AUTO, self::MODEL_INSERT ],
	];

	protected function autoToken() {
		return substr( md5( time() ), 0, 18 );
	}

	protected function autoEncodingaeskey() {
		return substr( md5( time() ) . md5( time() ), 0, 43 );
	}
}