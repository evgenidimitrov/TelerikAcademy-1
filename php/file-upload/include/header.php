<?php
session_name("file-upload");
session_set_cookie_params(3600,'/',$_SERVER["HTTP_HOST"],false, true);
session_start();
?>
<!DOCTYPE html>
<head>
<title>File upload</title>
<link type="text/css" href="styles/style.css" rel="stylesheet">
</head>
<body>
<div id="wrapper">