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
	<link href="http://bootstrapdocs.com/v3.2.0/docs/examples/dashboard/dashboard.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/flatly.min.css">
	<link rel="stylesheet" href="/dscan/css/custom.css">
	<!-- Optional theme -->
	<!-- Latest compiled and minified JavaScript -->
</head>
<?php
include("functions.php");
$key = $_GET['key'];

saveHit();

if(!isset($key)) {
	$result = "No scan given";
} else {
	$ds = getDscan($key);
	$obs = getDscanObjects($key);
	$citas = getDscanShipTypesCitadels($key);
	$ships = getDscanShips($key);
	$caps = getDscanShipTypesCaps($key);
	$subs = getDscanShipTypesSubs($key);
	$mass = getDscanShipsMass($key);
	$volume = getDscanShipsVolume($key);
}

//Location
$location = getDscanLocation($key);
if($location != null) {
	
	$loc = $location;
	//Check if it's a wormhole system
	if(preg_match("/^[jJ][0-9]{6}$/", $loc['systemName'], $matches) == 1) {
		//J-Space
		$location = "<a href=\"http://wh.pasta.gg/" . $loc['systemName'] . "\">" . $loc['systemName'] . "</a> &lt; " .
			$loc['constellationName'] . " &lt; " .
			$loc['regionName'] . "</a>";
	} else {
		//K-Space
		$regionName = str_replace(" ", "_", $loc['regionName']);
		$constellationName = str_replace(" ", "_", $loc['constellationName']);
		$systemName = str_replace(" ", "_", $loc['systemName']);
		$location = "<a href=\"http://evemaps.dotlan.net/map/" . $regionName . "/" . $loc['systemName'] . "\">" . $loc['systemName'] . "</a> &lt; " .
			"<a href=\"http://evemaps.dotlan.net/map/" . $regionName . "/" . $constellationName . "\">" . $loc['constellationName'] . "</a> &lt; " .
			"<a href=\"http://evemaps.dotlan.net/map/" . $regionName . "\">" . $loc['regionName'] . "</a>";
	}
} else {
	$location = "Unknown";
}

//Tower
$towerurl = getDscanTower($key);
$towerdata = towerChecker($key);
if($towerurl == null) {
	$tower = "No tower detected";
} else {
	$tower = "<a class=\"btn btn-success\" style=\"margin-bottom: 10px;\" href=\"".$towerurl."\">Tower Detected On-grid</a>";
}
?>
<body>

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
          </button>
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
        <div class="sidebar">
			<iframe height="685" width="250" frameborder="0" src="https://auth.entosis.link/en/nav/"></iframe>
        </div>
			<div class="col-sm-12 col-md-offset-2 main">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong>Location:</strong> <?php echo $location; ?>
					<span class="pull-right"><strong>Created:</strong> <?php echo date("d/m/y H:i", $ds['created']); ?> EVE Time</span>
				</div>
				
				<div class="panel-body">
					<div class="col-lg-6">
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Ships (<?php echo dscanListObjectsCount($ships); ?>)</strong></div>
							
							<div class="panel-body">
								<div class="bs-component">
									<ul class="list-group">
										<?php echo dscanListObjects($ships);?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="col-lg-6">					
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Subcaps (<?php echo dscanListObjectsCount($subs); ?>)</strong></div>
							
							<div class="panel-body">
								<?php echo dscanListObjects($subs); ?>
							</div>
						</div>
						
						
						<?php if(count($caps) > 0) { ?>
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Capitals (<?php echo dscanListObjectsCount($caps); ?>)</strong></div>
							
							<div class="panel-body">
								<?php echo dscanListObjects($caps); ?>
							</div>
						</div>
						<?php } ?>
						
						<?php if(count($citas) > 0) { ?>
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Citadels (<?php echo dscanListObjectsCount($citas); ?>)</strong></div>
							
							<div class="panel-body">
								<?php echo dscanListObjects($citas); ?>
							</div>
						</div>
						<?php } ?>
						
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Info</strong></div>
							
							<div class="panel-body">
								<?php if(true) {
									$titfuel = $mass * 0.000000001 * ((1000) - (1000 * 0.10 * 5)) * 5;
									$blopsfuel = $mass * 0.00000018 * ((300) - (300 * 0.10 * 5)) * 8;
									?>
									<strong>Est. Fleet Mass :</strong> <?php echo number_format($mass); ?> kg<br />
									<strong>Est. Fleet Volume (excl. Supers):</strong> <?php echo number_format($volume); ?> m3<br />
									<strong>Est. Isotopes to Bridge 5ly (Titan):</strong> <?php echo number_format($titfuel); ?> isotopes<br />
									<strong>Est. Isotopes to Bridge 8ly (Black Ops):</strong> <?php echo number_format($blopsfuel); ?> isotopes<br />
									<span style="font-size: 0.9em;" class="text-muted"><i>Doesn't account for active MWD/ABs or rigs<br>Mass excludes capital jump drive ships</span></i>
									<?php //echo $_SERVER['HTTP_REFERER'] . "<br />" . $_SERVER["REQUEST_URI"]; ?>
								<?php } else { ?>
									
								<?php } ?>
							</div>
						</div>
					
						<?php if($towerurl != null || $towerdata['towers'] > 0) { ?>
						<div class="panel panel-default">
							<div class="panel-heading"><strong>Control Towers</strong></div>
							
							<div class="panel-body">
							<?php if($towerurl != null) { ?>
								<?php echo $tower; ?><br />
							<?php } ?>
							
							<?php if($towerdata['towers'] > 0) { ?>
								<strong>Towers Detected:</strong> <? echo $towerdata['towers']; ?><br />
								<strong>Force Fields Detected:</strong> <? echo $towerdata['forcefields']; ?><br />
								<strong>Offline Towers:</strong> <? echo ($towerdata['towers'] - $towerdata['forcefields']); ?>
							<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://bootstrapdocs.com/v3.2.0/docs/dist/js/bootstrap.min.js"></script>
    <script src="http://bootstrapdocs.com/v3.2.0/docs/assets/js/docs.min.js"></script>
</body>
</html>