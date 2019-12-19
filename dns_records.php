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
          <a class="nav-item nav-link active" href="./dns_records.php">Dns Records <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="./countryFlags.php">Country Flags</a>
          <a class="nav-item nav-link" href="./manageCloudflareFlags.php">Manage Cloudflare Flags</a>
        </div>
      </div>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <form id="form_dns_records">
            <br>
            <div class="form-group row">
              <label for="inputZoneID" class="col-sm-2 col-form-label">Zone ID</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="inputZoneID" placeholder="19078982268e69064d2e44900ed75e32">
              </div>
              <div class="col-sm-5">Saiba como obter o ZoneID, <a href="./tips.php?tip=ZoneID">Click Aqui</a></div>
            </div>
            <div class="form-group row">
              <label for="inputAuthEmail" class="col-sm-2 col-form-label">Auth Email</label>
              <div class="col-sm-5">
                <input type="email" class="form-control" id="inputAuthEmail" placeholder="email@email.com">
              </div>
              <div class="col-sm-5">Informe o mesmo e-mail da sua conta no CloudFlare</div>
            </div>
            <div class="form-group row">
              <label for="inputAuthKey" class="col-sm-2 col-form-label">Auth Key</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="inputAuthKey" placeholder="8d4d6b16e4dd9819e779edc803198d8032809">
              </div>
              <div class="col-sm-5">Saiba como obter o Auth Key, <a href="./tips.php?tip=AuthKey">Click Aqui</a></div>
            </div>
            <div class="form-group row">
              <label for="inputPage" class="col-sm-2 col-form-label">Page</label>
              <div class="col-sm-2">
                <input type="number" class="form-control" id="inputPage" value="1">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Get</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div id="dns_records_response"></div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div id="textareaCopy"></div>
        </div>
      </div>
    </div>
    <footer class="mt-auto">
      <div class="navbar fixed-bottom" style="background-color: #FBAE40;">
        <p style="text-align: center;">2019 © Copyright – Todos os Direitos Reservados</p>
      </div>
    </footer>
    <script>
      let request = (url, formData) => new Promise((resolve, reject) => {
        let xmlhttp;
        if (window.XMLHttpRequest) {
          xmlhttp = new XMLHttpRequest();
        } else {
          xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            resolve(this.responseText);
          } else if (this.readyState == 4 && this.status !== 200 && this.status !== 0) {
            console.log("Error: Verifique a permissão de acesso!");
            reject("error: " + this.status);
          } else if (this.readyState == 4 && this.status == 0) {
            console.log("Error: desconhecido, Resposta do servidor: " + url + ", não recebida.");
            reject("Error: desconhecido, Resposta do servidor não recebida.");
          }
        }
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send(formData);
      });
      document.querySelector("#form_dns_records").addEventListener("submit", async evt =>{
        evt.preventDefault();
        const zoneID = document.querySelector("#inputZoneID").value;
        const authEmail = document.querySelector("#inputAuthEmail").value;
        const authKey = document.querySelector("#inputAuthKey").value;
        const nPage = document.querySelector("#inputPage").value;
        const formData = "zoneID="+zoneID+"&authEmail="+authEmail+"&authKey="+authKey+"&nPage="+nPage;
        let respAPI;
        try {
          respAPI = JSON.parse(await request("./functions/dns_records_func.php", formData));
        } catch (e) {
          console.log(e);
        }
        let str;
        if(respAPI.hasOwnProperty("success") && respAPI.success == true && respAPI.result.length > 0){
          document.querySelector("#dns_records_response").setAttribute("style", "overflow-x:auto; border: 4px solid red;");
          str = `<table class="table table-hover table-dark">
          <thead>
          <tr>
          <th scope="col">id</th>
          <th scope="col">zone_id</th>
          <th scope="col">type</th>
          <th scope="col">name</th>
          <th scope="col">content</th>
          <th scope="col">proxiable</th>
          <th scope="col">proxied</th>
          <th scope="col">zone_name</th>
          <th scope="col">ttl</th>
          <th scope="col">created_on</th>
          <th scope="col">modified_on</th>
          <th scope="col">locked</th>
          <th scope="col">Copy</th>
          </tr>
          </thead>
          <tbody>
          `;
          for(let i = 0; i < respAPI.result.length; i++){
            str += `<tr>
            <th scope="row">${respAPI.result[i].id}</th>
            <td>${respAPI.result[i].zone_id}</td>
            <td>${respAPI.result[i].type}</td>
            <td>${respAPI.result[i].name}</td>
            <td>${respAPI.result[i].content}</td>
            <td>${respAPI.result[i].proxiable}</td>
            <td>${respAPI.result[i].proxied}</td>
            <td>${respAPI.result[i].zone_name}</td>
            <td>${respAPI.result[i].ttl}</td>
            <td>${respAPI.result[i].created_on}</td>
            <td>${respAPI.result[i].modified_on}</td>
            <td>${respAPI.result[i].locked}</td>
            <td><input type="button" value="Copy Curl" id="btn_${i}" /></td>
            </tr>`;
          }
          str += `</tbody>
          </table>`;
        }else{
          str = "<h1>Not Found!</h1>";
        }
        document.querySelector("#dns_records_response").innerHTML = str;
        if(respAPI.hasOwnProperty("success") && respAPI.success == true && respAPI.result.length > 0){
          for(let i = 0; i < respAPI.result.length; i++){
            document.querySelector("#btn_"+i).addEventListener("click", function(evt1){
              evt1.preventDefault();
              let str1 = `<textarea id="copyContentTextArea">curl -X PUT "https://api.cloudflare.com/client/v4/zones/${respAPI.result[i].zone_id}/dns_records/${respAPI.result[i].id}" \\
              -H "X-Auth-Email: ${authEmail}" \\
              -H "X-Auth-Key: ${authKey}" \\
              -H "Content-Type: application/json" \\
              --data '{"type":"${respAPI.result[i].type}","name":"${respAPI.result[i].name}","content":"'$IP'","ttl":${respAPI.result[i].ttl},"proxied":${respAPI.result[i].proxied}}'</textarea>`;
              document.querySelector('#textareaCopy').innerHTML = str1;
              document.querySelector("#copyContentTextArea").select();
              document.execCommand("copy");
              document.querySelector('#textareaCopy').innerHTML = ``;
            });
          }
        }
      });
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./js/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="./js/popper.min.js" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js" crossorigin="anonymous"></script>
  </body>
</html>