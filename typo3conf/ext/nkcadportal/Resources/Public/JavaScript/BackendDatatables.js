define('TYPO3/CMS/Nkcadportal/BackendDatatables', ['jquery', 'datatables'], function($) {

    var BackendDatatables = {};

    // Initialize dataTables
    BackendDatatables.initializeDataTables = function() {
            var ajaxMemberUrl = TYPO3.settings.ajaxUrls['nkcadportal_members'];
            $('#table-members').DataTable({
                ajax: {
                    url: ajaxMemberUrl,
                    cache: false
                },
                "columns": [
                    { "data": "edit" },
                    { "data": "option" },
                    { "data": "company" },
                    { "data": "fein" },
                    { "data": "address" },
                    { "data": "name" },
                    { "data": "telephone" },
                    { "data": "email" },
                    { "data": "cname"},
                    { "data": "cemail"},
                    { "data": "cphone"}
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    },
                    {
                        "bVisible": false, "aTargets": [ 8,9,10 ] 
                    }
                 ],
                 "order": [[ 2, "asc" ]],
                "initComplete": function(settings, json) {
                        insertTypeDropDownIntoDataTables();
                }
            });

            var ajaxMemShipUrl = TYPO3.settings.ajaxUrls['nkcadportal_membership'];
            $('#table-memberships').DataTable( {
                ajax: {
                    url: ajaxMemShipUrl,
                    cache: false
                },
                "columns": [
                    { "data": "edit" },
                    { "data": "option" },
                    { "data": "description" },
                    { "data": "membershiptype" },
                    { "data": "price" },
                    { "data": "term" },
                    { "data": "includednewsletters" }
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    }
                 ],
                 "order": [[ 2, "asc" ]]
            } );

            var ajaxNewsletterUrl = TYPO3.settings.ajaxUrls['nkcadportal_newsletter'];
            $('#table-newsletters').DataTable( {
                "ajax": ajaxNewsletterUrl,
                "columns": [
                    { "data": "edit" },
                    { "data": "option" },
                    { "data": "title" },
                    { "data": "newslettertype" },
                    { "data": "download" }
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    }
                 ],
                 "order": [[ 2, "asc" ]]
            } );

            var ajaxDocUrl = TYPO3.settings.ajaxUrls['nkcadportal_document'];
            $('#table-documents').DataTable( {
                "ajax": ajaxDocUrl,
                "columns": [
                    { "data": "edit" },
                    { "data": "option" },
                    { "data": "title" },
                    { "data": "download" }
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    }
                 ],
                 "order": [[ 2, "asc" ]]
            } );

            var ajaxRemUrl = TYPO3.settings.ajaxUrls['nkcadportal_reminder'];
            $('#table-reminders').DataTable( {
                "ajax": ajaxRemUrl,
                "columns": [
                    { "data": "edit" },
                    { "data": "option" },
                    { "data": "subject" },
                    { "data": "sendoptionsstring" },
                    { "data": "states" }
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    }
                 ],
                 "order": [[ 2, "asc" ]]
            } );

            var ajaxRepUrl = TYPO3.settings.ajaxUrls['nkcadportal_report'];
            $('#table-reports').DataTable( {
                "ajax": ajaxRepUrl,
                "columns": [
                    { "data": "edit" },
                    { "data": "option" },
                    { "data": "title" },
                    { "data": "csv" }
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    }
                 ],
                 "order": [[ 2, "asc" ]]
            } );

            var ajaxCodeUrl = TYPO3.settings.ajaxUrls['nkcadportal_discount'];
            $('#table-codes').DataTable( {
                "ajax": ajaxCodeUrl,
                "columns": [
                    { "data": "dollar" },
                    { "data": "option" },
                    { "data": "agency" },
                    { "data": "description" },
                    { "data": "code" },
                    { "data": "discount" }
                ],
                "aoColumnDefs": [
                    {
                            "bSortable": false,
                            "aTargets": ["sorting_disabled"]
                    }
                 ],
                 "order": [[ 2, "asc" ]]
            } );
    };
    
    BackendDatatables.filterDataTables = function(option) {
        
        var ajaxMemberUrl = TYPO3.settings.ajaxUrls['nkcadportal_members'];
        $('#table-members').DataTable({
            "destroy": true,
            ajax: {
                url: ajaxMemberUrl + '&option=' + option,
                cache: false,
            },
            "columns": [
                { "data": "edit" },
                { "data": "option" },
                { "data": "company" },
                { "data": "fein" },
                { "data": "address" },
                { "data": "name" },
                { "data": "telephone" },
                { "data": "email" },
                { "data": "cname"},
                { "data": "cemail"},
                { "data": "cphone"}
            ],
            "aoColumnDefs": [
                {
                        "bSortable": false,
                        "aTargets": ["sorting_disabled"]
                },
                {
                    "bVisible": false, "aTargets": [ 8,9,10 ] 
                }
             ],
             "order": [[ 2, "asc" ]],
             "initComplete": function(settings, json) {
                 insertTypeDropDownIntoDataTables();
              }
        });
    };
    $(document).ready(function() {
        BackendDatatables.initializeDataTables();
        $('#memseloption').on('change', function(){
            $('.beoverlay').show();
            BackendDatatables.filterDataTables($('#memseloption').val());
        })
    });
});