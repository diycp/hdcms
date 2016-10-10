<?php
<<<<<<< HEAD
return [
	//服务提供者
	'providers' => [
		'system\service\UtilProvider'
=======

return [
	//服务提供者
	'providers' => [
		'hdphp\alipay\AlipayProvider',
		'hdphp\arr\ArrProvider',
		'hdphp\backup\BackupProvider',
		'hdphp\cache\CacheProvider',
		'hdphp\cart\CartProvider',
		'hdphp\code\CodeProvider',
		'hdphp\config\ConfigProvider',
		'hdphp\cookie\CookieProvider',
		'hdphp\crypt\CryptProvider',
		'hdphp\curl\CurlProvider',
		'hdphp\data\DataProvider',
		'hdphp\db\DbProvider',
		'hdphp\dir\DirProvider',
		'hdphp\log\LogProvider',
		'hdphp\error\ErrorProvider',
		'hdphp\html\HtmlProvider',
		'hdphp\image\ImageProvider',
		'hdphp\lang\LangProvider',
		'hdphp\mail\MailProvider',
		'hdphp\page\PageProvider',
		'hdphp\qq\QqProvider',
		'hdphp\rbac\RbacProvider',
		'hdphp\request\RequestProvider',
		'hdphp\response\ResponseProvider',
		'hdphp\route\RouteProvider',
		'hdphp\session\SessionProvider',
		'hdphp\string\StringProvider',
		'hdphp\upload\UploadProvider',
		'hdphp\url\UrlProvider',
		'hdphp\validate\ValidateProvider',
		'hdphp\auto\AutoProvider',
		'hdphp\view\ViewProvider',
		'hdphp\weixin\WeixinProvider',
		'hdphp\xml\XmlProvider',
		'hdphp\zip\ZipProvider',
		'hdphp\middleware\MiddlewareProvider',
		'hdphp\hook\HookProvider',
		'hdphp\form\FormProvider',
		'hdphp\tool\ToolProvider',
		'hdphp\cloud\CloudProvider',
>>>>>>> d191ef7fd2db8f578f2e53e41b319d65713d9c79
	],

	//服务外观
	'facades'   => [
<<<<<<< HEAD
		'Util' => 'system\service\UtilFacade'
=======
		'App'        => 'hdphp\kernel\AppFacade',
		'Alipay'     => 'hdphp\alipay\ZipFacade',
		'Arr'        => 'hdphp\arr\ArrFacade',
		'Backup'     => 'hdphp\backup\BackupFacade',
		'Cache'      => 'hdphp\cache\CacheFacade',
		'Cart'       => 'hdphp\cart\CartFacade',
		'Code'       => 'hdphp\code\CodeFacade',
		'Config'     => 'hdphp\config\ConfigFacade',
		'Cookie'     => 'hdphp\cookie\CookieFacade',
		'Crypt'      => 'hdphp\crypt\CryptFacade',
		'Curl'       => 'hdphp\curl\CurlFacade',
		'Data'       => 'hdphp\data\DataFacade',
		'Db'         => 'hdphp\db\DbFacade',
		'Dir'        => 'hdphp\dir\DirFacade',
		'Log'        => 'hdphp\log\LogFacade',
		'Error'      => 'hdphp\error\ErrorFacade',
		'Html'       => 'hdphp\html\HtmlFacade',
		'Image'      => 'hdphp\image\ImageFacade',
		'Lang'       => 'hdphp\lang\LangFacade',
		'Mail'       => 'hdphp\mail\MailFacade',
		'Page'       => 'hdphp\page\PageFacade',
		'Qq'         => 'hdphp\qq\QqFacade',
		'Rbac'       => 'hdphp\rbac\RbacFacade',
		'Request'    => 'hdphp\request\RequestFacade',
		'Response'   => 'hdphp\response\ResponseFacade',
		'Route'      => 'hdphp\route\RouteFacade',
		'Session'    => 'hdphp\session\SessionFacade',
		'String'     => 'hdphp\string\StringFacade',
		'Upload'     => 'hdphp\upload\UploadFacade',
		'Url'        => 'hdphp\url\UrlFacade',
		'Validate'   => 'hdphp\validate\ValidateFacade',
		'Auto'       => 'hdphp\auto\AutoFacade',
		'View'       => 'hdphp\view\ViewFacade',
		'Weixin'     => 'hdphp\weixin\WeixinFacade',
		'Xml'        => 'hdphp\xml\XmlFacade',
		'Zip'        => 'hdphp\zip\ZipFacade',
		'Middleware' => 'hdphp\middleware\MiddlewareFacade',
		'Hook'       => 'hdphp\hook\HookFacade',
		'Form'       => 'hdphp\form\FormFacade',
		'Tool'       => 'hdphp\tool\ToolFacade',
		'Cloud'      => 'hdphp\cloud\CloudFacade',
>>>>>>> d191ef7fd2db8f578f2e53e41b319d65713d9c79
	],
];