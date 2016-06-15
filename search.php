<?php
/**
 * A system to pull EIA Data into a WDC Tableau Connector.
 * 
 * @author Derrick Austin <derrick.austin@interworks.com>
 */
require_once('libs/api.php');

if (isset($_GET['category'])) {
	$api = api::factory();
	$results = $api->category(array(
		'category_id' => $_GET['category']
	));
	
	if (!empty($_GET['debug'])) {
		dar($results);
	}
}
?>

<?php if (isset($_GET['category']) && !empty($results->category->childcategories)): ?>
	<select class="categorySelector">
		<option value="-1">Select a Subcategory</option>
		<?php foreach ($results->category->childcategories as $result): ?>
			<option value="<?php echo $result->category_id; ?>"><?php echo $result->name; ?></option>
		<?php endforeach; ?>
	</select>
<?php endif; ?>

<?php if (!empty($_GET['category']) && !empty($results->category->childseries)): ?>
	<select class="seriesSelector">
		<option value="-1">Select a Series</option>
		<?php foreach ($results->category->childseries as $result): ?>
			<option value="<?php echo $result->series_id; ?>"><?php echo $result->name . ' (' . $result->units . ')' ?></option>
		<?php endforeach; ?>
	</select>
	<button class="btn" onclick="addWDC();">Add</button>
<?php endif; ?>