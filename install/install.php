<?php
session_start();
error_reporting( 0 );
set_time_limit( 0 );
header( "Content-type:text/html;charset=utf-8" );
$action = isset( $_GET['a'] ) ? $_GET['a'] : 'copyright';
//软件包地址
define( 'HDCMS_DOWNLOAD_URL', 'http://dev.hdcms.com/archive.zip' );
//版权信息
if ( $action == 'copyright' ) {
	$content = isset( $copyright ) ? $copyright : file_get_contents( 'copyright.html' );
	echo $content;
	exit;
}
//环境检测
if ( $action == 'environment' ) {
	//系统信息
	$data['PHP_OS']              = PHP_OS;
	$data['SERVER_SOFTWARE']     = $_SERVER['SERVER_SOFTWARE'];
	$data['PHP_VERSION']         = PHP_VERSION;
	$data['upload_max_filesize'] = get_cfg_var( "upload_max_filesize" ) ? get_cfg_var( "upload_max_filesize" ) : "不允许上传附件";
	$data['max_execution_time']  = get_cfg_var( "max_execution_time" ) . "秒 ";
	$data['memory_limit']        = get_cfg_var( "memory_limit" ) ? get_cfg_var( "memory_limit" ) : "0";
	//运行环境
	$data['h_PHP_VERSION'] = PHP_VERSION;
	$data['h_mysql']       = extension_loaded( 'mysql' ) ? '<i class="fa fa-check-circle fa-1x alert-success"></i>' : '<i class="fa fa-times-circle alert-danger"></i>';
	$data['h_Pdo']         = extension_loaded( 'Pdo' ) ? '<i class="fa fa-check-circle fa-1x alert-success"></i>' : '<i class="fa fa-times-circle alert-danger"></i>';
	$data['h_Gd']          = extension_loaded( 'Gd' ) ? '<i class="fa fa-check-circle fa-1x alert-success"></i>' : '<i class="fa fa-times-circle alert-danger"></i>';
	$data['h_curl']        = extension_loaded( 'curl' ) ? '<i class="fa fa-check-circle fa-1x alert-success"></i>' : '<i class="fa fa-times-circle alert-danger"></i>';
	$data['h_openSSL']     = extension_loaded( 'openSSL' ) ? '<i class="fa fa-check-circle fa-1x alert-success"></i>' : '<i class="fa fa-times-circle alert-danger"></i>';
	//目录状态
	$data['d_root'] = is_writable( '.' ) ? '<i class="fa fa-check-circle fa-1x alert-success"></i>' : '<i class="fa fa-times-circle alert-danger"></i>';
	$content        = isset( $environment ) ? $environment : file_get_contents( 'environment.html' );
	foreach ( $data as $t => $v ) {
		$content = str_replace( "{hd:{$t}}", $v, $content );
	}
	echo $content;
	exit;
}
//执行安装
if ( $action == 'database' ) {
	if ( ! empty( $_POST ) ) {
		$_SESSION['config'] = $_POST;
		//使用原生MYSQL操作
		if ( function_exists( 'mysql_connect' ) ) {
			$link = @mysql_connect( $_SESSION['config']['host'], $_SESSION['config']['user'], $_SESSION['config']['password'] );
			if ( ! $link ) {
				echo json_encode( [ 'valid' => 0, 'message' => '数据库连接失败,请检测帐号/密码是否正确' ] );
			} else {
				if ( ! @mysql_select_db( $_SESSION['config']['database'], $link ) ) {
					if ( mysql_query( "CREATE DATABASE IF NOT EXISTS {$_SESSION['config']['database']} CHARSET UTF8 " ) ) {
						echo json_encode( [ 'valid' => 1, 'message' => '连接成功' ] );
					} else {
						echo json_encode( [ 'valid' => 0, 'message' => '数据库连接失败,请检测帐号/密码及数据库是否存在' ] );
					}
				} else {
					echo json_encode( [ 'valid' => 1, 'message' => '连接成功' ] );
				}
			}
		} else {
			//使用PDO操作数据库
			$dsn      = "mysql:host={$_SESSION['config']['host']};dbname={$_SESSION['config']['database']}";
			$username = $_SESSION['config']['user'];
			$password = $_SESSION['config']['password'];
			try {
				$pdo = new Pdo( $dsn, $username, $password );
				echo json_encode( [ 'valid' => 1, 'message' => '连接成功' ] );
			} catch ( PDOException $e ) {
				echo json_encode( [ 'valid' => 0, 'message' => '数据库连接失败,请检测帐号/密码及数据库是否存在' ] );
			}
		}
		exit;
	}
	$content = isset( $database ) ? $database : file_get_contents( 'database.html' );
	echo $content;
}
//环境检测
if ( $action == 'download' ) {
	$content = isset( $download ) ? $download : file_get_contents( 'download.html' );
	echo $content;
	exit;
}

//远程下载文件
if ( $action == 'downloadFile' ) {
	if ( is_dir( 'web' ) ) {
		//已经下载过
		echo 1;
	} else {
		//下载软件包
		$d = curl_get( HDCMS_DOWNLOAD_URL );
		if ( strlen( $d ) < 2787715 ) {
			//下载失败
			exit;
		}
		$zipFile = 'hdcms2.0.zip';
		file_put_contents( $zipFile, $d );
		//解包
		get_zip_originalsize( $zipFile, './' );
		echo 1;
	}
	exit;
}

//安装完成,添加数据
if ( $action == 'table' ) {
	//添加数据表
	$dsn      = "mysql:host={$_SESSION['config']['host']};dbname={$_SESSION['config']['database']}";
	$username = $_SESSION['config']['user'];
	$password = $_SESSION['config']['password'];
	$pdo      = new Pdo( $dsn, $username, $password, [ PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'" ] );
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$sql = file_get_contents( 'install.sql' );
	//替换表前缀
	$sql    = str_replace( '`hd_', '`' . $_SESSION['config']['prefix'], $sql );
	$result = preg_split( '/;(\r|\n)/is', $sql );
	foreach ( (array) $result as $r ) {
		try {
			$pdo->exec( $r );echo $r.'<br/>';
		} catch ( PDOException $e ) {
			die( 'SQL执于失败:' . $r . '. ' . $e->getMessage() );
		}
	}
	//设置管理员帐号
	$user     = $pdo->query( "select * from {$_SESSION['config']['prefix']}user where uid=1" );
	$row      = $user->fetchAll( PDO::FETCH_ASSOC );
	$password = md5( $_SESSION['config']['upassword'] . $row[0]['security'] );
	$pdo->exec( "UPDATE {$_SESSION['config']['prefix']}user SET password='{$password}' WHERE uid=1" );
	//修改配置文件
	$data = array_merge( include 'system/config/database.php', $_SESSION['config'] );
	file_put_contents( 'system/config/database.php', '<?php return ' . var_export( $data, TRUE ) . ';?>' );
	header( 'Location:?a=finish' );
}
if ( $action == 'finish' ) {
	//清除运行数据
	is_file( 'hdcms2.0.zip' ) and unlink( 'hdcms2.0.zip' );
	is_file( 'install.sql' ) and unlink( 'install.sql' );
	//显示界面
	$content = isset( $finish ) ? $finish : file_get_contents( 'finish.html' );
	echo $content;
	exit;
}
//编译install.php安装文件,主要是将模板整合进来
if ( $action == 'compile' ) {
	$tpl     = [ 'copyright', 'environment', 'database', 'download', 'finish' ];
	$content = substr( file_get_contents( 'install.php' ), 5 );
	foreach ( $tpl as $t ) {
		$content = '$' . $t . "=<<<str\n" . file_get_contents( $t . '.html' ) . "\nstr;\n" . $content;
	}
	file_put_contents( '../install.php', "<?php \n" . $content );
	echo "<h1>编译成功</h1>";
}

function curl_get( $url ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );

	if ( ! curl_exec( $ch ) ) {
		$data = '';
	} else {
		$data = curl_multi_getcontent( $ch );
	}
	curl_close( $ch );

	return $data;
}

/**
 * 解压zip包
 *
 * @param string $filename 文件名
 * @param string $path 路径 如:./
 *
 * @return bool
 * 例 get_zip_originalsize( '20131101.zip', 'temp/' );
 */
function get_zip_originalsize( $filename, $path ) {
	//先判断待解压的文件是否存在
	if ( ! file_exists( $filename ) ) {
		die( "文件 $filename 不存在！" );
	}
	$starttime = explode( ' ', microtime() ); //解压开始的时间

	//将文件名和路径转成windows系统默认的gb2312编码，否则将会读取不到
	$filename = iconv( "utf-8", "gb2312", $filename );
	$path     = iconv( "utf-8", "gb2312", $path );
	//打开压缩包
	$resource = zip_open( $filename );
	$i        = 1;
	//遍历读取压缩包里面的一个个文件
	while ( $dir_resource = zip_read( $resource ) ) {
		//如果能打开则继续
		if ( zip_entry_open( $resource, $dir_resource ) ) {
			//获取当前项目的名称,即压缩包里面当前对应的文件名
			$file_name = $path . zip_entry_name( $dir_resource );
			//以最后一个“/”分割,再用字符串截取出路径部分
			$file_path = substr( $file_name, 0, strrpos( $file_name, "/" ) );
			//如果路径不存在，则创建一个目录，true表示可以创建多级目录
			if ( ! is_dir( $file_path ) ) {
				mkdir( $file_path, 0777, TRUE );
			}
			//如果不是目录，则写入文件
			if ( ! is_dir( $file_name ) ) {
				//读取这个文件
				$file_size = zip_entry_filesize( $dir_resource );
				//最大读取6M，如果文件过大，跳过解压，继续下一个
				if ( $file_size < ( 1024 * 1024 * 6 ) ) {
					$file_content = zip_entry_read( $dir_resource, $file_size );
					file_put_contents( $file_name, $file_content );
				} else {
					echo "<p> " . $i ++ . " 此文件已被跳过，原因：文件过大， -> " . iconv( "gb2312", "utf-8", $file_name ) . " </p>";
				}
			}
			//关闭当前
			zip_entry_close( $dir_resource );
		}
	}
	//关闭压缩包
	zip_close( $resource );

	return TRUE;
}
