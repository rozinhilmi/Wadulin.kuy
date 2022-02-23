<?php
require 'config.php';
require 'component/component.php';
$message = '';
$link_addres = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(isset($link_addres)){
  $url = rtrim($link_addres,"/");
  $url = filter_var($url,FILTER_SANITIZE_URL);
  $url = explode("/",$url);

if(isset($url[4])){
  $id=$url[4];
  if($id == "BelumDitangani"){
    $query = mysqli_query($conn,"SELECT * FROM post WHERE status = 0 order by id_post desc");
  }
  else if( $id == "SudahDitangani"){
    $query = mysqli_query($conn,"SELECT * FROM post WHERE status = 1 order by id_post desc");
  }
  else{
    $query = mysqli_query($conn,"SELECT * FROM post order by id_post desc");
  }
  
}
else{
  $query = mysqli_query($conn,"SELECT * FROM post order by id_post desc");
}
// else{
//   $id=$url[5];
//   $query = mysqli_query($conn,"SELECT * FROM post WHERE id_post = $id");
//   $data = mysqli_fetch_array($query);
// }
}



function uploadImg(){
  

  $conn = mysqli_connect("localhost","root","","wadulinkuy");  
  $query = mysqli_query($conn,'SELECT id_post FROM post ORDER BY id_post DESC LIMIT 1');
  $get_last_id = mysqli_fetch_all($query);
  $get_last_id = $get_last_id[0][0];
  $get_last_id+=1;

  
  $imgName = $_FILES['img_upload']['name'];
  $error = $_FILES['img_upload']['error'];
  $size = $_FILES['img_upload']['size'];
  $locationUp = $_FILES['img_upload']['tmp_name'];
  $formatFile = $_FILES['img_upload']['type'];
  
  $format = "";
  $formatFix = "";
  for ($i = strlen($imgName)-1; $i>=0; $i--){
    $format .= $imgName[$i];
    if ($imgName[$i] == ".") {
      break;
    }
  }
  for ($i=strlen($format)-1;$i>=0;$i--){
    $formatFix .= $format[$i];
  }
  
  $nameFix = ucwords("img".$get_last_id.$formatFix);
  
  if ($error == 0 ){
    if ($size < 200000000000){
      // echo $formatFile;
      if($formatFile == 'image/jpeg' || $formatFile == 'image/png'){
        // echo $formatFile;
        $absolute_path = realpath($_SERVER["DOCUMENT_ROOT"])."/Wadulin.kuy";

        // echo $absolute_path.'/img/'.$nameFix;
        $success = move_uploaded_file($locationUp,$absolute_path.'/img/'.$nameFix);
        // echo $locationUp;
        
        $query = mysqli_query($conn,"INSERT INTO post VALUES(0,'$_POST[judul]','$_POST[nama_penginput]','$nameFix','$_POST[komentar]',0)");
        // echo "INSERT INTO post VALUES(0,'$_POST[judul]','$_POST[nama_penginput]','$nameFix','$_POST[komentar]',0)";

        header("Refresh:0");
        // $_SESSION['pop_display'] = 'flex';  

      }
      else{
        echo  '
        <div style="position:fixed;z-index:1000;width:100%;bottom:30px" class="alert alert-danger" style:"position: fixed;" role="alert">
          format file harus jpg/png
        </div>';
      }
    }
    else{
      echo  '
          <div style="position:fixed;z-index:1000;width:100%;bottom:30px" class="alert alert-danger" style:"position: fixed;" role="alert">
          ukuran file terlalu besar
          </div>';
    }
  }
  else{
    echo  '
          <div style="position:fixed;z-index:1000;width:100%;bottom:30px" class="alert alert-danger" style:"position: fixed;" role="alert">
          file kegedean
          </div>';
  }
  
  // echo $validate;
  // die();



  
}
if(isset($_POST['input_post'])){
  $is_validate = true;
  foreach ($_POST as $key) {
    if($key == ""){
      $is_validate = false;
      break;
    }
  }
  if($is_validate){
    if(isset($_FILES)){
      if($_FILES['img_upload']['name'] != ""){
        uploadImg();
        // var_dump($_POST);
        // var_dump($_FILES);
      } 
    }
  }
  else{
    echo  '
    <div style="position:fixed;z-index:1000;width:100%;bottom:30px" class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Form Harus Terisi Semua!</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wadulin Kuy</title>
  <link rel="stylesheet" href="style/bootstrap5/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/style.css">
  <style>
    
    .form-comment{
      cursor: pointer;
      z-index: 10000000000;
      width: 100%;
      height: 100vh;
      position: fixed;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .form-comment .form-background{
      width: 100%;
      height: 100vh;
      position: absolute;
      background-color: rgba(0, 0, 0, 0.8);
      
    }
  </style>
</head>
<body>
  <div id="root">
    <form action="" method="POST" enctype="multipart/form-data">
      <div id="formComment" class="form-comment" style="display: none;" ">
        <div class="form-background" onclick="hideFormComment()">
          
        </div>
          
        <input name="nama_penginput" type="text" class="form-control" placeholder="Nama Penginput" style="z-index: 100;">
        <input name="judul" type="text" class="form-control" placeholder="judul" style="z-index: 100;">
        <div style="z-index: 100;display:flex;background-color:white;justify-content:space-between;width:100%">
          <label style="z-index: 100;" for="img">unggah gambar</label>
          <input type="file" name='img_upload' style="font-size: 12px;z-index: 100;">
        </div>
        
        <div class="form-floating">
          <textarea name="komentar" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 30vh"></textarea>
          <label for="floatingTextarea2">Tuliskan Komentar anda</label>
          <button name="input_post" value="true" type="submit" style="margin: auto;width:100%" class="btn btn-primary">Kirim</button>
        </div>
        
        
      </div>
    </form>
    <br>


    <div class="float-button" onclick="showFormComment()">
      <h1>+</h1>
    </div>
    

    </div>

    


    <div class="container">
      <center>
      <div class="nav-bottom-bar">
        <a href="http://localhost/Wadulin.kuy" class="route" style="display: flex;">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
          </svg>
          <?php
            if(!isset($url[4])){
              echo "<h4>Beranda</h4>";
            }
          ?>
        </a>
        <a href="http://localhost/Wadulin.kuy/BelumDitangani" class="route">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
              <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
            </svg>
            <?php
            if(isset($url[4])){
              if($url[4] == "BelumDitangani"){
                echo "<h4>Belum Ditangani</h4>";
              }
            }
            ?>

            
        </a>
        <a href="http://localhost/Wadulin.kuy/SudahDitangani" class="route">
          <svg style="color: green;display:block" xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                
              </svg>
          <?php
            if(isset($url[4])){
              if($url[4] == "SudahDitangani"){
                echo "<h4>Sudah Ditangani</h4>";
              }
            }
          ?>
        </a>
      </div>
      </center>

      <?php
      
      while($data = mysqli_fetch_assoc($query)){
        $query_count = mysqli_query($conn,"SELECT COUNT(*) FROM comment where id_post = $data[id_post]");
        $jumlah_comment = mysqli_fetch_array($query_count);
        card($data['title'],$data['nama_pengirim'],'img/'.$data['img'],$jumlah_comment[0],$data['status'],$data['id_post'],$data['section']);
      }
      ?>
      
      <br><br><br><br><br><br><br><br>
    
    </div>

  </div>
  
  
  
  <script src="style/bootstrap5/js/bootstrap.min.js"></script>
  <script src="style/script.js"></script>
  <script>
    const formComment = document.getElementById("formComment");
    function showFormComment(){
      formComment.style.display = "flex";
    }
    function hideFormComment(){
      formComment.style.display = "none";
    }
    
  </script>
</body>
</html>