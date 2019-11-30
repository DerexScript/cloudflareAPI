<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	if(isset($_POST['zoneID']) && isset($_POST['authEmail']) && isset($_POST['authKey']) && isset($_POST['nPage'])){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/{$_POST['zoneID']}/dns_records?page={$_POST['nPage']}&per_page=20&order=type&direction=asc");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'X-Auth-Key: '.$_POST['authKey'];
		$headers[] = "X-Auth-Email: {$_POST['authEmail']}";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		header("Content-Type: application/json; charset=utf-8");
		echo $result;
	}else{
		echo "you have no permissions";
	}
}else{
	echo "you have no permissions";
}
?>