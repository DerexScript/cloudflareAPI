<!doctype html>
<html lang="pt">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./css/bootstrap.min.css" crossorigin="anonymous">
  <title>CloudFlareAPI</title>
</head>
<body background="./assets/bg1.jpg">
  <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FBAE40;">
    <a class="navbar-brand" href="./">
      <img src="./assets/brand/logo1.svg" width="30" height="30" class="d-inline-block align-top" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link" href="./">Home</a>
        <a class="nav-item nav-link" href="./dns_records.php">Dns Records</a>
        <a class="nav-item nav-link" href="./countryFlags.php">Country Flags</a>
        <a class="nav-item nav-link active" href="./manageCloudflareFlags.php">Manage Cloudflare Flags<span class="sr-only">(current)</span></a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div id="status">
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-5 mb-5">
    <div class="row">
      <div class="col-md-12" id="time"></div>
    </div>
    <div class="row justify-content-md-center">
      <div class="col-md-auto">
        <h2>Adicionar Flags Ao CloudFlare</h2>
        <h6>Flags Ativas</h6>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <form action="./functions/manageCloudflareFlags.php" method="POST" >
          <select class="custom-select" name="flags[]" id="selectflags" multiple size="6">
            <?php
            require_once("./functions/connection.php");
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
                if($value->active == 1){
                  echo "<option value=\"{$value->flags}\">{$c} -> {$value->flags}</option>";
                  $c++;
                }
              }
            } catch(PDOException $e) {
              echo "<option value=\"0\">Error: {$e->getMessage()}</option>";
            }
            ?>
          </select>
          <button type="button" id="select_all" class="btn btn-outline-primary">Selecrionar Todos</button> 
          <button type="button" id="unselect_all" class="btn btn-outline-secondary">Remover Seleções</button>
          <div class="input-group mb-3 mt-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Zone ID: </span>
            </div>
            <input type="text" class="form-control" name="zoneid" placeholder="19078982268e69064d2e44900ed75e32" aria-label="ZoneID" aria-describedby="basic-addon1">
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Auth Key: </span>
            </div>
            <input type="text" class="form-control" name="authKey" placeholder="8d4d6b16e4dd9819e779edc803198d8032809" aria-label="AuthKey" aria-describedby="basic-addon1">
          </div> 
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">Auth Email: </span>
            </div>
            <input type="text" class="form-control" name="authemail" placeholder="email@email.com" aria-label="AuthEmail" aria-describedby="basic-addon1">
          </div>
          
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="typerecord">Type</label>
            </div>
            <select class="custom-select" id="typerecord" name="typerecord">
              <option selected>CNAME</option>
              <option>A</option>
            </select>
          </div>
          <div class="input-group mb-3">
            <div class="input-group-prepend" id="ipOrDns">
              <span class="input-group-text" id="basic-addon1">DNS: </span>
            </div>
            <div class="col-md-5" id="ipOrDns">
              <input type="text" class="form-control" style="margin-left: -16px;" name="dns" placeholder="Ex: domain.com" aria-label="dns" aria-describedby="basic-addon1">
            </div>
            <div class="input-group-prepend" >
              <label class="input-group-text" for="proxied_Select">Proxied</label>
            </div>
            <div class="col-md-5">
              <select class="custom-select" style="margin-left: -16px;" id="proxied_Select" name="proxied">
                <option value="true" selected>TRUE</option>
                <option value="false">FALSE</option>
              </select>
            </div>
          </div>

          <input type="submit" class="btn btn-primary mt-2" name="addflags" id="addflags" value="Adicionar">
          <input type="submit" class="btn btn-danger mt-2" name="removeflags" id="removeflags" value="Remover">
        </form>
      </div>
    </div>
  </div>

  <footer class="mt-auto">
    <div class="navbar" style="background-color: #FBAE40;">
      <p style="text-align: center;">2019 © Copyright – Todos os Direitos Reservados</p>
    </div>
  </footer>

  <script>
    const getQueryParams = (url) => {
      let queryParams = {};
      //create an anchor tag to use the property called search
      let anchor = document.createElement('a');
      //assigning url to href of anchor tag
      anchor.href = url;
      //search property returns the query string of url
      let queryStrings = anchor.search.substring(1);
      let params = queryStrings.split('&');
      for (var i = 0; i < params.length; i++) {
        var pair = params[i].split('=');
        queryParams[pair[0]] = decodeURIComponent(pair[1]);
      }
      if(pair == "") return "undefined";
      return queryParams;
    };

    window.onload = () => {

      document.querySelector("#typerecord").addEventListener("change", evt => {
        evt.preventDefault();
        if(document.querySelector("#typerecord").value == "A"){
          document.querySelectorAll("#ipOrDns")[0].innerHTML = `<span class="input-group-text" id="basic-addon1">IP: </span>`;
          document.querySelectorAll("#ipOrDns")[1].innerHTML = `<input type="text" class="form-control" style="margin-left: -16px;" name="ip" placeholder="Ex: 192.121.32.12" aria-label="IP" aria-describedby="basic-addon1">`;
        }else{
          document.querySelectorAll("#ipOrDns")[0].innerHTML = `<span class="input-group-text" id="basic-addon1">DNS: </span>`;
          document.querySelectorAll("#ipOrDns")[1].innerHTML = `<input type="text" class="form-control" style="margin-left: -16px;" name="dns" placeholder="Ex: domain.com" aria-label="dns" aria-describedby="basic-addon1">`;
        }
      });
      
      [...document.querySelectorAll("#selectflags>option")].map((element, indice, array)=>{
        element.selected = true;
      });
      let p = getQueryParams(window.location.href);
      if (p != "undefined"){
        if(p.status == "The record already exists.") {
          document.querySelector("#status").innerHTML = `
          <div class="alert alert-info" role="alert">
            Alguns dos registros informados já existe!.
          </div>
          `;
        setTimeout(()=>{
          window.location.href = "./manageCloudflareFlags.php";
        },3000);
        }
      }
    }
    document.querySelector("#select_all").addEventListener("click", evt => {
      evt.preventDefault();
      [...document.querySelectorAll("#selectflags>option")].map((element, indice, array)=>{
        element.selected = true;
      });
    });
    document.querySelector("#unselect_all").addEventListener("click", evt => {
      evt.preventDefault();
      [...document.querySelectorAll("#selectflags>option")].map((element, indice, array)=>{
        element.selected = false;
      })
    });
    document.querySelector("#addflags").addEventListener("click", evt => {
      let t=0;
      let selectedFlags = 0;
      [...document.querySelectorAll("#selectflags>option")].map((element, indice, array)=>{
        if (element.selected == true) selectedFlags++;
      });
      t = Math.floor(parseInt(selectedFlags*Math.floor((79000/215)))/1000);
      let intervalID = setInterval(()=>{
        document.querySelector("#time").innerText = "Tempo Estimado: "+t--;
        if(t < 0){
          clearInterval(intervalID);
          setTimeout(()=>{document.querySelector("#time").innerText = "";},2000);
        }
      }, 1000);
    });

    document.querySelector("#removeflags").addEventListener("click", evt => {
      let t=0;
      let selectedFlags = 0;
      [...document.querySelectorAll("#selectflags>option")].map((element, indice, array)=>{
        if (element.selected == true) selectedFlags++;
      });
      t = Math.floor(parseInt(selectedFlags*Math.floor((110000/215)))/1000);
      let intervalID = setInterval(()=>{
        document.querySelector("#time").innerText = "Tempo Estimado: "+t--;
        if(t < 0){
          clearInterval(intervalID);
          setTimeout(()=>{document.querySelector("#time").innerText = "";},2000);
        }
      }, 1000);
    });
  </script>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./js/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="./js/popper.min.js" crossorigin="anonymous"></script>
  <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>