<?php
	//ob_start();
	session_start();

	// Set Timezone
	date_default_timezone_set('Europe/Athens');

	// Do not use browser cache
	header('Cache-Control: no-cache, must-revalidate');

	// User Interface
	$WB_GUI_TITLE = "Pireias Home Supplier Sync";
	$WB_GUI_CLIENT_USERNAME = "peiraiashome";
	$WB_GUI_CLIENT_PASSWORD = "4281598";
	$WB_GUI_SESSION_TIMEOUT = 10*60;					// Session expired after. Default 10 min

	// Get Data
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$logout = intval($_POST['logout']);

	if (!isset($_SESSION["login"])) {
		$_SESSION["login"] = 0;
	}

	if (!isset($_SESSION["login_timestamp"])) {
		$_SESSION["login_timestamp"] = 0;	
	}

	// Logout user 
	if ($logout==1 || time()-intval($_SESSION["login_timestamp"]) > $WB_GUI_SESSION_TIMEOUT) {
		//session_unset();
		//session_destroy();
		$_SESSION['login'] = 0;
		$_SESSION["login_timestamp"] = 0;
	}


	// Login User
	if ($_SESSION['login']==false && $username==$WB_GUI_CLIENT_USERNAME && $password==$WB_GUI_CLIENT_PASSWORD) {
		$_SESSION['login'] = 1;
		$_SESSION["login_timestamp"] = time();
	}

	// Refresh login time
	if ($_SESSION['login'] == 1) {
		$_SESSION["login_timestamp"] = time();
	}


	// Get last run for each import
	$log_file = file_get_contents("logs/import_run.log");
	$log_lines =  explode("\n", $log_file);
	$lastrun = array();

	foreach ($log_lines as $run) {
		$job = json_decode($run, true);
		if ($job['mode'] == 'live') {
			if ($job['supplier'] == 'adamhome') $lastrun['adamhome'] = $job['timestamp'];
			if ($job['supplier'] == 'borea') $lastrun['borea'] = $job['timestamp'];
			if ($job['supplier'] == 'dimcol') $lastrun['dimcol'] = $job['timestamp'];
			if ($job['supplier'] == 'homeline') $lastrun['homeline'] = $job['timestamp'];
			if ($job['supplier'] == 'linohome') $lastrun['linohome'] = $job['timestamp'];
			if ($job['supplier'] == 'makistselios') $lastrun['makistselios'] = $job['timestamp'];
			if ($job['supplier'] == 'omegahome') $lastrun['omegahome'] = $job['timestamp'];
			if ($job['supplier'] == 'palamaiki') $lastrun['palamaiki'] = $job['timestamp'];
			if ($job['supplier'] == 'teoran') $lastrun['teoran'] = $job['timestamp'];
			if ($job['supplier'] == 'vamvax') $lastrun['vamvax'] = $job['timestamp'];
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<title>Imports - <?php echo $WB_GUI_TITLE; ?></title>
	<link rel="stylesheet/less" type="text/css" href="ui/styles.less" />
	<script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>
<body>
	<div id="header">
		<img src="ui/logo.png" />
		<h2>Supplier Sync Backend</h2>
		<hr/>
	</div>

	<?php
		if ($_SESSION['login'] == 1) {
	?>

	<div id="main">
		<p>Choose the Supplier to update eshop products</p>

		<ul>
			<li>
				<a href="import_adamhome.php" target="_blank">Adam Home</a>
				<?php
					if (isset($lastrun['adamhome'])) {
						echo '<br/><span>Last import: ' . $lastrun['adamhome'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_borea.php" target="_blank">Borea</a>
				<?php
					if (isset($lastrun['borea'])) {
						echo '<br/><span>Last import: ' . $lastrun['borea'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_dimcol.php" target="_blank">Dimcol</a>
				<?php
					if (isset($lastrun['dimcol'])) {
						echo '<br/><span>Last import: ' . $lastrun['dimcol'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_homeline.php" target="_blank">Homeline</a>
				<?php
					if (isset($lastrun['homeline'])) {
						echo '<br/><span>Last import: ' . $lastrun['homeline'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_linohome.php" target="_blank">Lino Home</a>
				<?php
					if (isset($lastrun['linohome'])) {
						echo '<br/><span>Last import: ' . $lastrun['linohome'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_makistselios.php" target="_blank">Makis Tselios</a>
				<?php
					if (isset($lastrun['makistselios'])) {
						echo '<br/><span>Last import: ' . $lastrun['makistselios'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_omegahome.php" target="_blank">Omega Home</a>
				<?php
					if (isset($lastrun['omegahome'])) {
						echo '<br/><span>Last import: ' . $lastrun['omegahome'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_palamaiki.php" target="_blank">Palamaiki</a>
				<?php
					if (isset($lastrun['palamaiki'])) {
						echo '<br/><span>Last import: ' . $lastrun['palamaiki'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_teoran.php" target="_blank">Teoran</a>
				<?php
					if (isset($lastrun['teoran'])) {
						echo '<br/><span>Last import: ' . $lastrun['teoran'] . '</span>';
					}
				?>
			</li>
			<li>
				<a href="import_vamvax.php" target="_blank">VAMVAX (Guy Laroche, Saint Clair)</a> <!-- <sup>INACTIVE</sup> -->
				<?php
					if (isset($lastrun['vamvax'])) {
						echo '<br/><span>Last import: ' . $lastrun['vamvax'] . '</span>';
					}
				?>
			</li>
		</ul>
		
		<form action="index.php" name="logout" method="post">
			<input type="hidden" name="logout" value="1" />
			<input type="submit" value="Logout" />
		</form>
		
	</div>


	<?php
		} else {
	?>

		<div id="login">
			<form action="index.php" method="post">
				Username <input type="text" name="username" /><br/><br/>
				Password <input type="password" name="password" /><br/><br/>
				<input type="submit" value="Login" />
			</form>
		</div>

	<?php
		}
	?>
</body>
</html>