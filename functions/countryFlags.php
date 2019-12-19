<?php
require_once("./connection.php");
function getUserIP() {
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
    $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_FORWARDED']))
    $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if(isset($_SERVER['REMOTE_ADDR']))
    $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
    $ipaddress = 'UNKNOWN';
  return $ipaddress;
}
if(isset($_POST['addFlag'])){
  if(preg_match("/\s/", $_POST['addFlag']) ){
    $addFlag = preg_split('/\s/', $_POST['addFlag']);
  }else{
    $addFlag = [0 => $_POST['addFlag']];
  }
  foreach ($addFlag as $value) {
    try {
      //verifica se já existe!
      $stmt = $conn->prepare("SELECT * FROM countryflags WHERE flags=:flags");
      $stmt->bindParam(':flags', $value);
      $stmt->execute();
      if($stmt->rowCount() == 0 && !empty($value)){
        $stmt = null;
        //Se não existir, adiciona!
        $stmt = $conn->prepare("INSERT INTO countryflags(flags, who_added, time_it_was_added, active) VALUES (:flags, :who_added, :time_it_was_added, :active)");
        $stmt->bindParam(':flags', $value, PDO::PARAM_STR);
        $stmt->bindValue(':who_added', getUserIP(), PDO::PARAM_STR);
        $stmt->bindValue(':time_it_was_added', date("d/m/Y H:i:s"), PDO::PARAM_STR);      
        $stmt->bindParam(':active', intval(1), PDO::PARAM_INT);     
        $stmt->execute();
        header('Location: ./countryFlags.php');
      }else{
        echo "Flag Já Existe!";
      }  
    } catch(PDOException $e) {
      echo 'ERROR: ' . $e->getMessage();
    }
  }
  header("Location: ../countryFlags.php");
} else if(isset($_POST['inativeFlag']) || isset($_POST['activeFlag']) ){
  $obj = isset($_POST['inativeFlag']) == 1 ? $_POST['inativeFlag'] : $_POST['activeFlag'];
  foreach ($obj as $flagID){
    try {
      $stmt = $conn->prepare("UPDATE countryflags SET active = :active WHERE id = :id");
      $stmt->bindParam(':id', intval($flagID), PDO::PARAM_INT);
      if (isset($_POST['inativeFlag'])) 
        $stmt->bindParam(':active', intval(0), PDO::PARAM_INT);
      else
        $stmt->bindParam(':active', intval(1), PDO::PARAM_INT);
      $stmt->execute();
      header('Location: ./countryFlags.php');
    } catch(PDOException $e) {
      echo 'Não foi possivel apagar!<br>ERROR: ' . $e->getMessage();
    }
  }
  header("Location: ../countryFlags.php");
}else if(isset($_POST['truncateTable'])){
	try {
		$stmt = $conn->prepare("TRUNCATE TABLE countryflags");
		$stmt->execute();
	} catch (Exception $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
}
$conn = null;
?>