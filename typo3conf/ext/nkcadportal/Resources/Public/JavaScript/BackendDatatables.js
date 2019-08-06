define('TYPO3/CMS/Nkcadportal/BackendDatatables', ['jquery', 'datatables'], function($) {

	var BackendDatatables = {};

	// Initialize dataTables
	BackendDatatables.initializeDataTables = function() {
		$('.datatable').DataTable({
			"aoColumnDefs": [
			   {
				   "bSortable": false,
				   "aTargets": ["sorting_disabled"]
			   }
			],
			"order": [[ 2, "asc" ]],
			"initComplete": function(settings, json) {
				insertTypeDropDownIntoDataTables();
			}
		});
	};

	$(document).ready(function() {
		// Initialize the view
		BackendDatatables.initializeDataTables();
	});

});