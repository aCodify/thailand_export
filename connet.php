<?php  


define('DOCROOT', rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) . '/', '/'));
define('DOMAIN', 'http://' . $_SERVER['HTTP_HOST'] );
define('ABSURL', DOMAIN );

define('DATABASE_HOSTNAME', 'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', 'password');
define('DATABASE_NAM', 'AAA');



if ( is_file( DOCROOT.'/import_excel/inc/database/DB.php' ) ) 
{
	include DOCROOT.'/import_excel/inc/database/DB.php';
	include DOCROOT.'/import_excel/inc/model.php';

}


