<?php 

include 'koneksi.php';

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$hostUrl = $protocol . '://' . $_SERVER['HTTP_HOST'];

session_start();

$usersession = $_SESSION['username'];
$sessionlevel = $_SESSION['level'];

$databg = "SELECT * FROM welcome_background";
$connectdatabg = mysqli_query($koneksi, $databg);



// update gambar welcome
if(isset($_POST['submit'])){
  $storage = $_FILES['gambar']['tmp_name'];
  $nama_file = 'welcome.png'; 
  $update = "UPDATE welcome_background set link_background = 'http://192.168.30.4/controlpanel/images/welcome.png' WHERE id = '0'";
  $connectupdate = mysqli_query($koneksi, $update);
  if(!empty($_FILES['gambar']['name'])){
    if(move_uploaded_file($storage, "./images/".$nama_file)){
      header("location:WelcomeScreen-setup.php");
    }
  }else{
    ?>
    <script type="text/javascript">
      setTimeout(function(){
        alert("kolom gambar tidak boleh kosong");
      },2000);
    </script>
    <?php 
  }
}


// update video welcome
$uploadSuccess = false;
if(isset($_POST['submit_video'])){
    if(!empty($_FILES['video']['name'])){
        if(move_uploaded_file($_FILES['video']['tmp_name'], "./images/video/welcome.mp4")){
            $uploadSuccess = true;
        }
    }
}

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>IPTV CMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/style_table.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
  </head>

  <?php 
  if($usersession){
    if($sessionlevel == 'marketing'){
      header("Location: ./marketing/service.php");
      exit();
    }
    ?>

  <body>
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="active">
				<h1><a href="index.html" class="logo"></a></h1>
        <ul class="list-unstyled components mb-5">
          <li>
            <a href="Room-list.php"><span class="fa fa-home"></span> Room</a>
          </li>
          <li>
            <a href="index.php"><span class="fa fa-list"></span> Channel</a>
          </li>

          <li>
            <a href="service.php"><span class="fa fa-list"></span> Service</a>
          </li>

          <li>
              <a href="facilities.php"><span class="fa fa-list"></span> fasilitas</a>
          </li>

          <li>
              <a href="information.php"><span class="fa fa-list"></span> Information</a>
          </li>
          <li>
            <a href="WelcomeScreen-setup.php"><span class="fa fa-tv"></span>Welcome Screen</a>
          </li>
          <li>
            <a href="promotion.php"><span class="fa fa-image"></span> Promotion</a>
          </li>
          <li>
            <a href="reflexology.php"><span class="fa fa-image"></span> Reflexology</a>
          </li>
          <li>
            <a href="about.php"><span class="fa fa-image"></span> About</a>
          </li>
          <li>
            <a href="User-list.php"><span class="fa fa-user"></span> User</a>
          </li>
    	</nav>
      <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" style="color: black;" href="#"></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="color: black;" href="#"></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="color: black;" href="#"></a>
                </li>
              </ul>
            </div>

          </div>
        </nav>
        <!-- Form Upload-->
       <form method="POST" enctype="multipart/form-data">
        <h2 class="mb-4">Setup Welcome Screen</h2>
        <div class="mb-3 w-75">
          <label for="formFile" class="form-label">Choose Image</label>
          <input class="form-control" type="file" id="formFile" name="gambar">
        </div>
        <div class="mb-3">
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
          <a class="btn btn-success" href="<?=$hostUrl?>/controlpanel/previews/welcomepreview.php" target="_blank">Preview</a>
        </div>
      </form>
        <!-- Video Preview -->
        <div class="mt-4">
            <h4>Current Welcome Video</h4>
            <video id="welcomeVideo" src="<?=$hostUrl?>/controlpanel/images/video/welcome.mp4" style="width:100%;max-width:640px;border-radius:8px" controls preload="metadata">
                Your browser does not support the video tag.
            </video>
        </div>

        <!-- Upload Video -->
        <div class="mt-4 pt-3 border-top">
            <h4>Upload Welcome Video</h4>
            <form id="videoForm" enctype="multipart/form-data">
                <div class="mb-3 w-75">
                    <input class="form-control" type="file" name="video" accept="video/mp4">
                </div>
                <div class="progress mb-3" id="progWrap" style="display:none;height:24px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="progBar" role="progressbar" style="width:0%">0%</div>
                </div>
                <button type="submit" class="btn btn-primary">Upload Video</button>
            </form>
            <div id="videoToast" style="position:fixed;top:20px;right:20px;z-index:9999"></div>
        </div>
		  </div>

<script>
$('#videoForm').submit(function(e){
    e.preventDefault();
    var fd = new FormData(this);
    fd.append('submit_video', '1');
    $.ajax({
        url: '',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        xhr: function(){
            var xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e){
                if(e.lengthComputable){
                    var p = Math.round(e.loaded / e.total * 100);
                    $('#progWrap').show();
                    $('#progBar').css('width', p + '%').text(p + '%');
                }
            });
            return xhr;
        },
        success: function(){
            var v = document.getElementById('welcomeVideo');
            v.src = v.src.split('?')[0] + '?t=' + Date.now();
            v.load();
            var t = '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                  + 'Video uploaded! <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
            $('#videoToast').html(t).fadeIn();
            setTimeout(function(){ $('.alert').alert('close'); }, 4000);
            $('#progWrap').hide();
            $('#progBar').css('width', '0%').text('0%');
            this.reset();
        }
    });
});
</script>
      <?php  
  }else{

  header("location:login.php");



  }
   ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
  </body>
</html>