$(document).ready(function(){
	
	//Make topnav clickable:
	$("ul.cad-portal-be-topnav li a").on("click", function(e){
		e.preventDefault();
		$target = $(this).attr("data-link");
		$("ul.cad-portal-be-topnav li a").removeClass("active");
		$(this).addClass("active");
		$(".dataTables_wrapper").hide();
		$("#"+$target+"_wrapper").show();
                if($target != 'table-members') {
                    $('.temp-dropdown-holder').hide();
                } else {
                    $('.temp-dropdown-holder').show();
                    
                }
	});
        
});


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
	
	if($performAjaxCall == true){
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
						$("#table-members tr[data-row-id='"+$uid+"']").slideUp();
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