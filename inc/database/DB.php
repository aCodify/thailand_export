<?php


//TODO:Fix call to get_instance() to use library separtely from Codeigniter environment , try search for "get_instance" in directory
//TODO:Change DB class initiation as OOP manner not a function
//TODO:Change function log_message() and show_error() as class method not a global function


define('DB_LIB_BASEPATH' , dirname(__FILE__) . '/');
define('DB_LIB_LOGGING' , FALSE);
define('DB_LIB_DEBUG' , FALSE);
define('DB_LIB_LOGFILE' , DB_LIB_BASEPATH . 'db_lib.log');


function &DB($params = '', $active_record_override = FALSE)
{
	if (is_string($params))
	{
		
		/* parse the URL from the DSN string
		*  Database settings can be passed as discreet
	 	*  parameters or as a data source name in the first
	 	*  parameter. DSNs must have this prototype:
	 	*  $dsn = 'driver://username:password@hostname/database';
		*/
	
		if (($dns = @parse_url($params)) === FALSE)
		{
			show_error('Invalid DB Connection String');
		}
		
		$params = array(
							'dbdriver'	=> $dns['scheme'],
							'hostname'	=> (isset($dns['host'])) ? rawurldecode($dns['host']) : '',
							'username'	=> (isset($dns['user'])) ? rawurldecode($dns['user']) : '',
							'password'	=> (isset($dns['pass'])) ? rawurldecode($dns['pass']) : '',
							'database'	=> (isset($dns['path'])) ? rawurldecode(substr($dns['path'], 1)) : ''
						);
		
		// were additional config items set?
		if (isset($dns['query']))
		{
			parse_str($dns['query'], $extra);

			foreach($extra as $key => $val)
			{
				// booleans please
				if (strtoupper($val) == "TRUE")
				{
					$val = TRUE;
				}
				elseif (strtoupper($val) == "FALSE")
				{
					$val = FALSE;
				}

				$params[$key] = $val;
			}
		}
	}
	
	// No DB specified yet?  Beat them senseless...
	if ( ! isset($params['dbdriver']) OR $params['dbdriver'] == '')
	{
		show_error('You have not selected a database type to connect to.');
	}

	// Load the DB classes.  Note: Since the active record class is optional
	// we need to dynamically create a class that extends proper parent class
	// based on whether we're using the active record class or not.
	// Kudos to Paul for discovering this clever use of eval()
	
	if ($active_record_override == TRUE)
	{
		$active_record = TRUE;
	}
	
	require_once(DB_LIB_BASEPATH.'DB_driver.php');

	if ( ! isset($active_record) OR $active_record == TRUE)
	{
		require_once(DB_LIB_BASEPATH.'DB_active_rec.php');
		
		if ( ! class_exists('CI_DB'))
		{
			eval('class CI_DB extends CI_DB_active_record { }');
		}
	}
	else
	{
		if ( ! class_exists('CI_DB'))
		{
			eval('class CI_DB extends CI_DB_driver { }');
		}
	}
			
	require_once(DB_LIB_BASEPATH.'drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php');

	// Instantiate the DB adapter
	$driver = 'CI_DB_'.$params['dbdriver'].'_driver';
	$DB = new $driver($params);
	
	if ($DB->autoinit == TRUE)
	{
		$DB->initialize();
	}
	
	return $DB;
}	



//function show_error($message)
//{
//	$message = 'DB_LIB_ERROR : ' . $message;
//	log_message('error' , $message);
//	die($message);
//}
//
//function log_message($level , $message)
//{
//	if ( ! DB_LIB_LOGGING)
//	{
//		return FALSE;
//	}
//	
//	if ( ! file_exists(DB_LIB_LOGFILE) OR ! is_writable(DB_LIB_LOGFILE))
//	{
//		return FALSE;
//	}
//	
//	if ($level == 'debug' AND ! DB_LIB_DEBUG)
//	{
//		return FALSE;
//	}
//	
//	$message = date('Y-m-d H:i:s') . ' - ' . $level . ' - ' . $message;
//	
//	@file_put_contents($message);
//	
//}
