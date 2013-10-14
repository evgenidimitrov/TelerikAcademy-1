<?php
function sanitizeString($var)
{
	if (get_magic_quotes_gpc())
		$var = stripslashes($var);
	$var = htmlentities($var, ENT_QUOTES, 'UTF-8'));
	$var = strip_tags($var);
	return $var;
}