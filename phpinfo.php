<?php 

if(isset($_GET['goto']) && $_GET['goto'] == 'jinge')
	echo phpinfo();
else
	throw new Exception(404);