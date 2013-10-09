<?php
$DBhost ='';
$DBuser='';
$DBpassword='';
$DB='message_exchange';
$connection=mysqli_connect($DBhost, $DBuser, $DBpassword, $DB);
if (!$connection)
{
echo "Error with database";
exit;
}
mysqli_set_charset($connection, "utf8");