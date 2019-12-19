<?php
function requestCURL($zoneid, $authemail, $authKey, $method="POST", $param, $url=""){
	$ch = curl_init();
	$headers = array();
	array_push($headers, "X-Auth-Email: {$authemail}");
	array_push($headers, "X-Auth-Key: {$authKey}");
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if ($method == "POST") {
		curl_setopt($ch, CURLOPT_POST, 1);
		array_push($headers, "Content-Type: application/x-www-form-urlencoded");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	}
	if ($method == "POST_J") {
		curl_setopt($ch, CURLOPT_POST, 1);
		array_push($headers, "Content-Type: application/json");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
	}
	if ($method == "DELETE"){
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		array_push($headers, "Content-Type: application/json");
	}
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		if($method == "DELETE" || $method == "POST_J"){
			return ['Error' => curl_error($ch), 'url' => $url];
		}else{
			echo 'Error: '.curl_error($ch);
			exit();
		}
	}
	curl_close($ch);
	return $result;
}
if(isset($_POST['flags']) && isset($_POST['zoneid']) && isset($_POST['authKey']) && isset($_POST['authemail']) && isset($_POST['typerecord']) && isset($_POST['proxied']) && $_SERVER['REQUEST_METHOD'] === 'POST' ){
	
	$ipOrDns;
	if(isset($_POST['ip'])){
		$ipOrDns = $_POST['ip'];
	}else if(isset($_POST['dns'])){
		$ipOrDns = $_POST['dns'];
	}

	if(isset($_POST['removeflags'])){
		set_time_limit(300);
		ini_set('max_execution_time', 300);
		$arrRemove = array();
		$err = array();
		$url = str_replace("manageCloudflareFlags.php", "", "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}")."dns_records_func.php";
		$p = "zoneID={$_POST['zoneid']}&authEmail={$_POST['authemail']}&authKey={$_POST['authKey']}&nPage=0";
		$totPages = json_decode(requestCURL($_POST['zoneid'], $_POST['authemail'], $_POST['authKey'], "POST", $p, $url))->result_info->total_pages;
		//obter ID, de todos paises!
		for ($i=0; $i <= $totPages; $i++) { 
			$p = "zoneID={$_POST['zoneid']}&authEmail={$_POST['authemail']}&authKey={$_POST['authKey']}&nPage={$i}";
			$obj = json_decode(requestCURL($_POST['zoneid'], $_POST['authemail'], $_POST['authKey'], "POST", $p, $url))->result;
			foreach ($obj as $key => $value) {
				if(in_array(strtoupper(substr($value->name, 0, strpos($value->name, "."))), $_POST['flags'])){
					array_push($arrRemove, $value->id);
				}
			}
		}
		//remover DNS de todos paises encontrado acima!
		$idRemove = array_unique($arrRemove);
		foreach ($idRemove as $key => $value) {
			$url = "https://api.cloudflare.com/client/v4/zones/{$_POST['zoneid']}/dns_records/{$value}";
			$resp = requestCURL($_POST['zoneid'], $_POST['authemail'], $_POST['authKey'], "DELETE", "", $url);
			if(isset($resp['Error']) || !json_decode($resp)->success){
				array_push($err, $resp);
			}
		}
		if(count($err) > 0){
			echo "<br>Error: ";
			var_dump($err);
			echo "<br>";
			exit();
		}
		if(count($arrRemove) == 0){
			echo "Não Houve Dominios Para Remover!";
		}
		set_time_limit(30);
		ini_set('max_execution_time', 30);
		header("Location: ../manageCloudflareFlags.php");
	}else if(isset($_POST['addflags'])){
		set_time_limit(300);
		ini_set('max_execution_time', 300);
		$flags;
		$err = array();
		$url = "https://api.cloudflare.com/client/v4/zones/{$_POST['zoneid']}/dns_records";
		$ret = "";
		if(count($_POST['flags']) > 1){
			$flags = $_POST['flags'];
		}else if(count($_POST['flags']) == 1){
			$flags = $_POST['flags'];
		}
		foreach ($flags as $key => $value) {
			$p = json_encode(["type" => "{$_POST['typerecord']}","name"=>"{$value}.vhostmain.com","content"=>"{$ipOrDns}","ttl"=>1,"priority"=>10,"proxied"=> (boolean)json_decode(strtolower($_POST['proxied']))]);
			$resp = requestCURL($_POST['zoneid'], $_POST['authemail'], $_POST['authKey'], "POST_J", $p, $url);
			if(isset($resp['Error']) || !json_decode($resp)->success){
				array_push($err, $resp);
			}
		}
		if(count($err) > 0){
			if(isset(json_decode($err[0])->errors[0]->code) && json_decode($err[0])->errors[0]->code == 81057){
				echo "The record already exists.";
				$ret = "?status=The record already exists.";
			}else{
				echo "<br> Error: ";
				var_dump($err);
				echo "<br>";
				exit();	
			}
		}
		set_time_limit(30);
		ini_set('max_execution_time', 30);
		header("Location: ../manageCloudflareFlags.php{$ret}");
	}
}else{
	header("Location: ../manageCloudflareFlags.php");
}
?>