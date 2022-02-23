<?php
require "../config.php";
$link_addres = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if(isset($link_addres)){
  $url = rtrim($link_addres,"/");
  $url = filter_var($url,FILTER_SANITIZE_URL);
  $url = explode("/",$url);
  // echo $url[5];
  if(!isset($url[5])){
    header("Location: ../");
    
  }
  else{
    $id=$url[5];
    $query = mysqli_query($conn,"SELECT * FROM post WHERE id_post = $id");
    $data = mysqli_fetch_array($query);
  }
}

if(isset($_POST['submit_comment'])){
  $is_validate = true;
  foreach ($_POST as $key) {
    if($key == ""){
      $is_validate = false;
      break;
    }
  }
  if($is_validate){
    var_dump($_POST);
    $query_post = mysqli_query($conn,"INSERT INTO comment VALUES(0,$id,'$_POST[nama_penginput]','$_POST[comment]')");
    header("Refresh:0");
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
  <link rel="stylesheet" href="../style/bootstrap5/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style/style.css">
  <style>
    .nav-bottom-bar{
      cursor: pointer;
      margin-bottom: 5px;
    }
    .nav-bottom-bar:hover{
      background-color: rgb(145, 189, 240);
      color: white;   
    }
    .nav-bottom-bar svg,.nav-bottom-bar p {
      margin: auto;
    }
    .form-comment{
      cursor: pointer;
      z-index: 9999;
      width: 100%;
      height: 100vh;
      position: fixed;
      display: flex;
      flex-direction: column;
      justify-content: center;
      /* background-color: rgba(0, 0, 0, 0.5); */
    }
    .form-comment .form-floating{
      margin: auto;
    }
    .form-comment .form-background{
      width: 100%;
      height: 100vh;
      position: absolute;
      background-color: rgba(0, 0, 0, 0.8);
      
    }
    .container .card{
      cursor:unset
    }
    .container .card:hover{
      background-color: rgba(0,0,0,0);
    }
  </style>
</head>
<body>
  <form action="" method="POST" >
    <div id="formComment" class="form-comment" style="display: none;" ">
      <div class="form-background" onclick="hideFormComment()">
        
      </div>
      
      <input name="nama_penginput" type="text" class="form-control" placeholder="Nama Penginput" style="z-index: 100;margin:0.3cm;width:92%">
      <div class="form-floating" style="margin:0.3cm;margin-top:0cm">
        <textarea name="comment" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 80vh"></textarea>
        <label for="floatingTextarea2">Tuliskan Komentar anda</label>
        <button type="submit" name="submit_comment" value="submit" style="margin: auto;width:100%" class="btn btn-primary">Kirim</button>
      </div>
      
    </div>
  </form>
  

  
    <br>
  <div class="container">
    <div class="nav-bottom-bar" onclick="showFormComment()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
              <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>

              
            </svg>
            <p>Tulis Komentar anda</p>
    </div>
    

    <div class="card">
      <nav style="display: flex;">
        <a href="../">
          <svg style="margin-right: 10px;color:black" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
          </svg>  
        </a>
        
        <h1><?= $data['title'] ?></h1>
      </nav>
      
      <img style="width: 100%; height:auto" src="../img/<?= $data['img']?>" alt=""><br>
      <p><?= $data['section'] ?></p>
      <center style="display: flex;justify-content:space-between">
        <div class="comment">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>

            <p><?php
            $query_count = mysqli_query($conn,"SELECT COUNT(*) FROM comment where id_post = $id");
            $jumlah_comment = mysqli_fetch_array($query_count);
            echo $jumlah_comment[0]
            ?></p>
          </svg>
        </div>

        <?php
        if($data['status'] == false){ ?>
          <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
              <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
            </svg>
              <p>Belum ditangangi</p>
          </div>
        <?php
        }
        else{ ?>
          <div>
                <svg style="color: green;display:block" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                  <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                </svg>
                <p>Sudah Ditangani</p>
          </div>
        <?php
        }
        ?>
        
        
      
      
      </center>

      <?php
      $query_comment = mysqli_query($conn,"SELECT * FROM comment WHERE id_post = $id ORDER BY id_comment DESC");
      while($data = mysqli_fetch_array($query_comment)){ ?>
        <div class="card">
          <h5><?= $data['nama'] ?></h5>
          <p><?= $data['comment'] ?></p>
        </div>
      <?php
      }
      ?>
    </div>

  <br><br><br>
   
  </div>


  

  
  <script src="../style/bootstrap5/js/bootstrap.min.js"></script>
  <script src="../style/script.js"></script>
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