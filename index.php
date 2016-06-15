<?php
require_once('libs/api.php');
$api = api::factory();
$results = $api->category(array(
	'category_id' => 371
));
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>EIA WDC</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="/resources/tableauwdc-1.1.1.js" type="text/javascript"></script>
	<script type="text/javascript" src="resources/eia.js"></script>
	<script type="text/javascript" src="/resources/tableau-output.js"></script>
	<link rel="stylesheet" href="resources/eia.css" />
	<link rel="stylesheet" href="/resources/wdc.css" />
</head>

<body>
	<div class="navbar navbar-default">
		<a class="navbar-wdc" href="/">
			<img id="wdc-logo-left" src="/resources/WDC_Logo.png" />
			<div id="wdc-logo-right">
				<img src="/resources/WDC_Logo_Header.png" />
				<span>U.S. ENERGY DATA</span>
			</div>
		</a>
		<a class="navbar-brand" href="http://www.interworks.com">
			<img src="https://www.interworks.com/logo/images/logo.png" />
		</a>
		<div class="navbar-border">
			<img src="/resources/WDC_Border.png" />
		</div>
	</div>
	<div class="container">
		<div class="alert alert-danger warning-msg">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<b>Whoa!</b> We've detected you are loading this in a browser window.<br/>Please load this window from Tableau to use the
			<a href="http://onlinehelp.tableau.com/current/pro/online/windows/en-us/help.htm#examples_web_data_connector.html" target="_blank">Web Data Connector</a>.
		</div>

		<div class="container">
			<div class="container">
				<img src="resources/US_Energy_Data_Text.png" />
				<div class="categorySelectorList">
					<select class="categorySelector">
						<option value="-1">Select a Category</option>
						<?php foreach ($results->category->childcategories as $result): ?>
							<option value="<?php echo $result->category_id; ?>"><?php echo $result->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<br/>
			<div class="container">
				<div class="selected-header">
					<img src="resources/Selected_Data.png" />
					<a href="javascript:void(0);" id="clear-wdc">Clear</a>
				</div>
				<div id="wdc-list"><span id="select-text">Select metrics using the selector above.</span></div>
				<button type="button" class="btn" id="get-wdc">Get Data</button>
				<input type="hidden" name="wdc-ids" id="wdc-ids" />
			</div>
		</div>
		<div id="search-results"></div>
	</div>
	<footer class="footer">
		<div class="navbar-border">
			<img src="/resources/WDC_Border.png" />
		</div>
		<div class="container">
			<p class="text-muted">All data is &copy;<a href="http://www.eia.gov/" target="_blank">U.S. Energy Information Administration</a>. Please refer to the <a href="http://www.eia.gov/about/copyrights_reuse.cfm" target="_blank">TOS</a> for usage terms.</p>
		</div>
	</footer>
</body>

</html>
