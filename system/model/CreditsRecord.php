<?php namespace system\model;

/**
 * 积分记录
 * Class CreditsRecord
 * @package system\model
 * @author 向军
 */
class CreditsRecord extends Common {
	protected $table = 'credits_record';
	protected $allowFill = [ '*' ];
	protected $validate = [
	];
	protected $auto = [
		[ 'siteid', 'siteid', 'function', self::MUST_AUTO, self::MODEL_BOTH ],
		[ 'module', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH ],
		[ 'operator', 0, 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH ],
		[ 'createtime', 'time', 'function', self::NOT_EXIST_AUTO, self::MODEL_BOTH ],
		[ 'remark', '', 'string', self::NOT_EXIST_AUTO, self::MODEL_BOTH ],
	];

}