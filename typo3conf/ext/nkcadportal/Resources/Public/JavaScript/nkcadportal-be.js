var pgStart = '0';
var moption = '';
var cname = '';
var fein = '';
var address = '';
var pcontact = '';
var pphone = '';
var email = '';

function rePolMember() {
    var ajaxMemberUrl = TYPO3.settings.ajaxUrls['nkcadportal_members'];
    $('#nkloader').show();
    $.ajax({
            url: ajaxMemberUrl,
            type: "POST",
            data: 'pageNo='+pgStart+'&option='+moption+'&company='+cname+'&fein='+fein+'&address='+address+'&name='+pcontact+'&phone='+pphone+'&email='+email,
            cache:false,
            success: function (response) {
                $('#nkloader').hide();
                $('#memberList').html(response.members);
                $('#memPg').html(response.paging)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#nkloader').hide();
                //Give an alert:
                alert('Error occured:\n'+textStatus);
            }
    });
}
        
$(document).ready(function(){
        
    $('#memseloption').on('change', function(){
        pgStart = 0;
        moption = $('#memseloption').val()?$('#memseloption').val():'';
        rePolMember();
    });

    $('#cname').on('keyup', function (e){
        cname = $('#cname').val();
        if ($(this).val().length > 2) {
            pgStart = 0;         
            rePolMember();
        } else {
            if (e.keyCode == 8) {
                pgStart = 0;
                rePolMember();
            }
        }
    });
    
    $('#fein').on('keyup', function (e){
        fein = $('#fein').val();
        if ($(this).val().length > 0) {
            pgStart = 0;
            rePolMember();
        } else {
            if (e.keyCode == 8) {
                pgStart = 0;
                rePolMember();
            }
        }
    });
    
    $('#address').on('keyup', function (e){
        address = $('#address').val();
        if ($(this).val().length > 2) {
            pgStart = 0;         
            rePolMember();
        } else {
            if (e.keyCode == 8) {
                pgStart = 0;
                rePolMember();
            }
        }
    });
    
    $('#pcontact').on('keyup', function (e){
        pcontact = $('#pcontact').val();
        if ($(this).val().length > 2) {
            pgStart = 0;         
            rePolMember();
        } else {
            if (e.keyCode == 8) {
                pgStart = 0;
                rePolMember();
            }
        }
    });
    
    $('#pphone').on('keyup', function (e){
        pphone = $('#pphone').val();
        if ($(this).val().length > 2) {
            pgStart = 0;         
            rePolMember();
        } else {
            if (e.keyCode == 8) {
                pgStart = 0;
                rePolMember();
            }
        }
    });
    
    $('#email').on('keyup', function (e){
        email = $('#email').val();
        if ($(this).val().length > 2) {
            pgStart = 0;         
            rePolMember();
        } else {
            if (e.keyCode == 8) {
                pgStart = 0;
                rePolMember();
            }
        }
    });
        
});

function _getPage(no) {
    pgStart = no;
    rePolMember();
}
function insertTypeDropDownIntoDataTables(){
        $('.temp-dropdown-holder').show();
        $('.beoverlay').hide();
}

function performAjaxAction($ajaxPID, $action, $uid, $needsConfirmation){
	$performAjaxCall = true;
	if($needsConfirmation){
		var r = confirm("Are you sure?");
		if (r == true) {
			$performAjaxCall = true;
		} else {
			$performAjaxCall = false;
		}
	}
	
	if ($performAjaxCall == true){
		//Set query parameters:
		$getData = '?id=' + $ajaxPID;
		$getData += '&action=' + $action;
		$getData += '&uid=' + $uid;

		//Perform AJAX request and populate content element:
		ajaxRequest = $.ajax({
			url: "/index.php" + $getData,
			type: "POST",
			data: "",
			success: function (data, textStatus, jqXHR) {
				switch($action){
					case "delete-member":
						alert("The member was deleted");
						break;
					case "hide-member":
						//To-do: Gray-out row in member table!
						alert("The member was hidden");
						break;
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//Give an alert:
				alert('There was an error removing this record. Please try again...\nError: '+textStatus);
			}
		});
	}
}