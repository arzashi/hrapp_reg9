<?php
	@session_start();
	
	if(!$_SESSION['username'] || !$_SESSION['checkpwa']) {
		$LoginScript = "http://www.pwa.co.th/login.php";
		$redirecturl .= "http://reg1.pwa.co.th/intranet/HRApp";
		$redirecturl = base64_encode($redirecturl);
		header("Location: $LoginScript?mylink=$redirecturl");
		exit;
	}else
	{
		$website = "http://reg1.pwa.co.th/intranet/HRApp";
		header("Location: $website");
	}
?>