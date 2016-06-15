
/**
 * A system to pull Fred Data into a WDC Tableau Connector.
 *
 * @author Derrick Austin <derrick.austin@interworks.com>
 */

window.cachedTableData;

var fredConnector = tableau.makeConnector();
fredConnector.init = function () {
	tableau.connectionName = 'EIA data';
	tableau.initCallback();
};

fredConnector.getColumnHeaders = function() {
	_getOurData(function(data) {
		tableau.headersCallback(
			window.cachedTableData['fieldNames'],
			window.cachedTableData['fieldTypes']
		);
	});
};

fredConnector.getTableData = function(lastRecordToken) {
	_getOurData(function(data) {
		tableau.dataCallback(
			window.cachedTableData['dataToReturn'],
			lastRecordToken,
			false
		);
	});
};

tableau.registerConnector(fredConnector);

function addWDC() {
	// Remove select text
	$('#select-text').html('');
	
	id = $('.seriesSelector').val();
	title = $('.seriesSelector option:selected').text();
	
	// Check if id already exists. If not, append it at the top.
	if ($('#wdc-list>div[data-id="' + id + '"]').length == 0) {
		$("#wdc-list").prepend("<div data-id=" + id + ">" + id + " - " + title + "</div>");
	}
	
	updateWDCList();
}

function updateWDCList()
{
	// Populate list from data attributes of divs
	list = $("#wdc-list>div").map(function() {
		return {
			id    : $(this).data("id"),
			title : $(this).html()
		};
	}).get();
	
	// Add select text if cleared
	if (!list || list == '' || list.length == 0) {
		$('#wdc-list').html('<span id="select-text">Select metrics using the selector above.</span>');
		$('#get-wdc').hide();
		$('#clear-wdc').hide();
		return;
	}
	
	// Insert vals into form input and show buttons
	$("#wdc-ids").val(JSON.stringify(list));
	$('#get-wdc').show();
	$('#clear-wdc').show();
}

function _getOurData(callback)
{
	if (!window.cachedTableData) {
		$.ajax({
			'url'  : 'wdc.php',
			'data' : {
				'wdc_ids' : tableau.connectionData
			}
		}).done(function (data) {
			window.cachedTableData = data;
			callback(window.cachedTableData);
		});
	} else {
		callback(window.cachedTableData);
	}
}

function _selectionCallback()
{
	var $el = $(this);
	if ($el.val() == '-1') {
		return;
	}
	
	$.ajax({
		'url'  : 'search.php',
		'data' : {
			'category' : $el.val()
		}
	}).done(function (data) {
		$el.nextAll().remove();
		$('.categorySelectorList').append(data);
		$('.categorySelector').change(_selectionCallback);
	});
}

$(function() {
	$('#clear-wdc').click(function() {
		$('#wdc-list').html('');
		$('#wdc-list').html('');
		updateWDCList();
	});
	
	$('#get-wdc').click(function () {
		tableau.connectionData = $('#wdc-ids').val();
		tableau.submit();
	});
	
	$('.categorySelector').change(_selectionCallback);
	
	if (typeof tableauVersionBootstrap  == 'undefined' || !tableauVersionBootstrap) {
		$('.warning-msg').show();
	} else {
		$('.warning-msg').hide();
	}
});