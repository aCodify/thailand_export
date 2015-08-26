<?php

function check_username_not_unique($user_name = '')
{
	$sql = "SELECT COUNT(username) as num FROM the_user WHERE username='".trim($user_name)."'";
	$query = mysql_query($sql) or die("ERROR : ".mysql_error()."$sql<br>");
	$row = mysql_fetch_assoc($query);
	$total = $row['num'];
	
	if($total > 0)
	{
		return FALSE;	
	}
	else
	{
		return TRUE;
	}
}

?>