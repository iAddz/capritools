<?php
include("posdscan.class.php");
include("functions.php");	

saveHit();

if(isset($_POST['dscan'])) {
	$dscan = $_POST['dscan'];

	$objects = parseDscan($dscan);
	$key = saveDscan($objects);
	
	//Save to file
	file_put_contents("scans/".$key, $dscan);
	
	header('Location: /dscan/'.$key);
	//print_r($objects);
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Alliance Auth</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>

	<!-- Latest compiled and minified CSS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="/dscan/css/custom.css">
	<link href="http://bootstrapdocs.com/v3.2.0/docs/examples/dashboard/dashboard.css" rel="stylesheet">
	<!-- Optional theme -->
	<!-- Latest compiled and minified JavaScript -->
	
	<!-- Custom Page CSS -->
	<script>
	  function resizeIframe(obj) {
		obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
	  }
	</script>
</head>
<body>
	
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand">inPanic</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          </ul>
        </div>
      </div>
    </div>
	
	<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
			<iframe height="685" width="250" frameborder="0" src="https://auth.entosis.link/en/nav/"></iframe>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main"><br>
          <h1 class="page-header">DScan Tool</h1>
			<form method="POST">
				<fieldset>
				  <h4><i>Paste your dscan into the box below</i></h4>
				  <div class="form-group">
						<textarea id="dscan" name="dscan" class="form-control" rows="8"><?php if(isset($_POST['dscan'])) { echo $_POST['dscan']; } ?></textarea><br />
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</fieldset>
			</form>


          
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://bootstrapdocs.com/v3.2.0/docs/dist/js/bootstrap.min.js"></script>
    <script src="http://bootstrapdocs.com/v3.2.0/docs/assets/js/docs.min.js"></script>
</body>
</html>
