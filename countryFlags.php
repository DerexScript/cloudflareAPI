<!doctype html>
<html lang="pt">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" crossorigin="anonymous">
    <title>CloudFlareAPI</title>
    <style>
    body {
    padding-bottom: 70px;
    }
    </style>
  </head>
  <body background="./assets/bg1.jpg">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FBAE40;">
      <a class="navbar-brand" href="./dns_records.php">
        <img src="./assets/brand/logo1.svg" width="30" height="30" class="d-inline-block align-top" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link" href="./">Home</a>
          <a class="nav-item nav-link" href="./dns_records.php">Dns Records</a>
          <a class="nav-item nav-link active" href="./countryFlags.php">Country Flags<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="./manageCloudflareFlags.php">Manage Cloudflare Flags</a>
        </div>
      </div>
    </nav>

    <div class="container mt-2">
      <div class="row">
        <div class="col-md-11">
          <form action="./functions/countryFlags.php" method="POST">
            Country Flag: <input type="text" name="addFlag">
            <input class="btn btn-primary" type="submit" value="Adicionar">
          </form>
        </div>
        <div class="col-md-1">
          <button class="btn btn-danger" id="truncateTable">Clear</button>
        </div>
      </div>
    </div>
    <!-- Ativos -->
    <div class="container mt-5">
      <div class="row justify-content-md-center">
        <div class="col-md-auto">
          <h2>Ativos</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="./functions/countryFlags.php" method="POST" >
            <select class="custom-select" name="inativeFlag[]" multiple size="6">
              <?php
              ini_set('display_errors', false);
              error_reporting(0);
              require_once("./functions/connection.php");
              try {
                $stmt = $conn->prepare("SELECT * FROM countryflags ORDER BY flags ASC");
                $result = $stmt->execute();
                $objFlags = $stmt->fetchAll(PDO::FETCH_OBJ);
                if(!$result){
                  http_response_code(500);
                  exit();
                }
                $c = 0;
                foreach ($objFlags as $key => $value) {
                  if($value->active == 1){
                    echo "<option value=\"{$value->id}\" name=\"{$value->flags}\">{$c} -> {$value->flags}</option>";
                    $c++;
                  }
                }

              } catch(PDOException $e) {
                echo "<option value=\"0\">Error: {$e->getMessage()}</option>";
              }
              ?>
            </select>
            <input type="submit" class="btn btn-primary mt-2" value="Desativar">
          </form>
        </div>
      </div>
      <!-- Inativos -->
      <div class="row justify-content-md-center">
        <div class="col-md-auto">
          <h2>Inativos</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="./functions/countryFlags.php" method="POST" >
            <select class="custom-select" name="activeFlag[]" multiple size="6">
              <?php
              ini_set('display_errors', false);
              error_reporting(0);
              var_dump($conn);
              try {
                $stmt = $conn->prepare("SELECT * FROM countryflags ORDER BY flags ASC");
                $result = $stmt->execute();
                $objFlags = $stmt->fetchAll(PDO::FETCH_OBJ);
                if(!$result){
                  http_response_code(500);
                  exit();
                }
                $conn = null;
                $c = 0;
                foreach ($objFlags as $key => $value) {
                  if($value->active == 0){
                    echo "<option value=\"{$value->id}\" name=\"{$value->flags}\">{$c} -> {$value->flags}</option>";
                    $c++;
                  }
                }

              } catch(PDOException $e) {
                echo "<option value=\"0\">Error: {$e->getMessage()}</option>";
              }
              ?>
            </select>
            <input type="submit" class="btn btn-primary mt-2" value="Ativar">
          </form>
        </div>
      </div>
    </div>

    <footer class="mt-auto">
      <div class="navbar fixed-bottom" style="background-color: #FBAE40;">
        <p style="text-align: center;">2019 © Copyright – Todos os Direitos Reservados</p>
      </div>
    </footer>

    <script>
      document.querySelector("#truncateTable").addEventListener("click", evt => {
        evt.preventDefault();
        let formData = "truncateTable=true";
        let xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            window.location.reload();
          } else if (this.readyState == 4 && this.status !== 200 && this.status !== 0) {
            console.log("Error: Verifique a permissão de acesso!");
            console.log("error: " + this.status);
          } else if (this.readyState == 4 && this.status == 0) {
            console.log("Error: desconhecido, Resposta do servidor: " + './functions/countryFlags.php' + ", não recebida.");
            console.log("Error: desconhecido, Resposta do servidor não recebida.");
          }
        }
        xmlhttp.open("POST", './functions/countryFlags.php', true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send(formData);
      });
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./js/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="./js/popper.min.js" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>