define('TYPO3/CMS/Nkcadportal/BackendNkDate', ['jquery', 'TYPO3/CMS/Nkcadportal/jquery-ui.min'], function($) {
    'use strict';
    var BackendNkDate = {};
    
    BackendNkDate.initialize = function () {
      $('.nkdatepicker').datepicker({ dateFormat: "mm/dd/yy"});
    };
    
    BackendNkDate.checkEmpty = function (el) {
        var tid = el.attr('id');
        var hiddenFld = el.attr('data-formengine-input-name');
        
        if ($('#' + tid).val() == '') {
            $('input[name="' + hiddenFld + '"]').val(0);
        };
    };
    
    $(function() {
         BackendNkDate.initialize();
         $(".nkdatepicker").on('blur',function(){
             BackendNkDate.checkEmpty($(this));
         });
    });
});