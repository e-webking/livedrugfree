$(function(){
	
	//Check for changes to any of the membership dropdowns in the purchase/renew tab:
	$("select.purchaserenewmembership").on("change", function(){
		$priceField = $(this).parent().next().next().find("span");
		if($(this).val() == '0'){
			$priceField.html('');
		}
		else{
			$price = $(this).find("option:selected").attr('data-price');
			$priceField.html($price);
		}
		//Update the total price:
		updatePurchaseTotal();		
	});
	
	//Check for changes in any of the renew (existing) membership checkboxes:
	$("#renewexistingform input[type='checkbox']").on("change", function(){
		$inputName = $(this).attr("name");
		$aInputNameTemp = $inputName.split("_");
		$stateUid = $(this).parent().parent().find(".existing-state").attr("data-uid");
		if($(this).prop("checked")){
			//Enable renewing this existing membership:
			$("#purchaserenewform input[name='"+$inputName+"']").val('1');
			//Find the first available membership "slot":
			$("select.purchaserenewmembership").each(function(){
				if($(this).val() == '0'){
					//Select the correct membership to renew:
					$(this).val($aInputNameTemp);
					//Select the correct state:
					$(this).parent().parent().find(".newmembership-state").val($stateUid);
					//Mark this membership row as containing a renewed membership:
					$(this).parent().parent().attr("data-renewed-membership", $inputName);
					//Trigger change event for the membership dropdown:
					$(this).trigger("change");
					//Exist "each"-iteration:
					return false;
				}
			});
		}
		else{
			//Disable renewing this existing membership:
			$("#purchaserenewform input[name='"+$inputName+"']").val('0');
			//Remove the marking for the membership row:
			$("#purchaserenewform tr[data-renewed-membership='"+$inputName+"'] select.purchaserenewmembership").val('0');
			$("#purchaserenewform tr[data-renewed-membership='"+$inputName+"'] select.newmembership-state").val('0');
			$("#purchaserenewform tr[data-renewed-membership='"+$inputName+"'] select.purchaserenewmembership").trigger("change");
			$("#purchaserenewform tr[data-renewed-membership='"+$inputName+"']").attr("data-renewed-membership", "");
		}
		//Update the total price:
		updatePurchaseTotal();		
	});
	
	//Check for changes to the donation dropdown in the purchase/renew tab:
	$("#donate").on("change", function(){
		//Update the total price:
		updatePurchaseTotal();
	});
	
	//Check for any changes to the discount code field in the purchase/renew tab:
	$("#discountcode").on("change", function(){
		$result = performAjaxCall('checkdiscountcode', $("#discountcode").val());
		$("#discountcode").attr("data-discountvalue", $result);
		//Update the total price:
		updatePurchaseTotal();
	});
	
	//Listen for #profile_change_pw on-click:
	$("#profile_change_pw").on("change", function(){
		if($(this).prop("checked") == true){
			$(".new_passw_wrapper").slideDown();
		}
		else{
			$(".new_passw_wrapper").slideUp();
		}
	});
        
        $('.nldown').on('click', function(){
            //Get the page uid to call:
            $ajaxUrl = $(this).attr("data-href");
            $.ajax({
                    url: $ajaxUrl,
                    type: "POST",
                    success: function () {
                         location.href = $ajaxUrl;
                    },
                    error: function () {
                        //Give an alert:
                        alert('There was an error getting the requested file.\n');
                    }
            });
        });
});

function checkProfileForm(){
	//Check if the passw change checkbox was checked, if so, make the two pw fields required:
	if($("#profile_change_pw").prop("checked") == true){
		if($("#oldpassword").val() == "" || $("input[name='tx_nkcadportal_nkcadportalfe[FrontendUser][password]']").val() == ""){
			alert("Please enter your current (old) and a new password...");
			return false;
		}
	}
	return true;
}

function updatePurchaseTotal(){
	//Define the total variable:
	$total = 0;
	//Check if at least one of the .purchaserenewmembership dropdowns has a membership selected (that has data-alreadyactive attr set to 'no')...
	$skipBecauseNoMembershipSelected = true;
	$(".purchaserenewmembership").each(function(){
		$selectedOptionAlreadyActiveValue = $(this).find("option:selected").attr('data-alreadyactive');
		if($(this).val() != '0' && $selectedOptionAlreadyActiveValue == 'no'){
			$skipBecauseNoMembershipSelected = false;
			//break for-each loop:
			return false;
		}
	});
	//Get the discount value:
	$discountAmount = $("#discountcode").attr("data-discountvalue") * 1;
	//Apply memberships costs and discount amount:
	if($skipBecauseNoMembershipSelected == false){
		//Add the membership costs:
		$("span.membership-cost").each(function(){
			if($(this).html() != ''){
				$total += ($(this).html() * 1);
			}
		});
		//Subtract any discount code:
		$total -= $discountAmount;
	}
	//Add the donation value:
	$total += ($("#donate").val() * 1);
	//Hide or show the discount amount section based on the discount given:
	if($discountAmount > 0){
		$("#discountamount").removeClass("hidden").find("span").html($discountAmount);
	}
	else{
		$("#discountamount").addClass("hidden").find("span").html('');
	}
	//Show or hide the payment form:
	if($total > 0){
		$("form.membershipform div.purchasenewform-paymentsection").show();
	}
	else{
		$("form.membershipform div.purchasenewform-paymentsection").hide();
	}
	//Update the total field:
	$("#purchasetotal").val("$"+$total);
}

function performAjaxCall($requestType, $requestValue){
	var returnValue = "";
	
	//Get the page uid to call:
	$ajaxPID = $("div#ajaxpid").attr("data-pid");
	
	//Set query parameters:
	$getData = '?id=' + $ajaxPID;
	$getData += '&action=' + $requestType;
	$getData += '&value=' + $requestValue;

	//Perform AJAX request and populate content element:
	ajaxRequest = $.ajax({
		url: "/index.php" + $getData,
		type: "POST",
		async : false,
		data: "",
		success: function (data, textStatus, jqXHR) {
			returnValue = data;
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//Give an alert:
			alert('There was an error getting the requested data. Please try again...\nError: '+textStatus);
		}
	});
	
	//Return the acquired data:
	return returnValue;
}



function editContact($contactUid){
	
}

function removeContact($contactUid){
	//Make the ajax request:
	$returnedValue = performAjaxCall('removecontact', $contactUid);
	//Check result:
	if($returnedValue.trim() == "OK"){
		//Remove was successfull - Remove the table row for this contact:
		$(".contact-list-table tr[data-contact-uid='"+$contactUid+"']").fadeOut('normal', function(){
			alert("The contact was successfully removed.");
		});
		
	}
	else{
		alert("The contact could not be removed. Please try again...");
	}
}

function switchPurchasenewPaymentOption(){
	$selectedOption = $("select#payment-option").val();
	//Hide all payment-options:
	$(".payment-option").hide();
	//Show only selected payment-option:
	$(".payment-option."+$selectedOption).show();
}

function checkMembershipPaymentForm(){
	$selectedOption = $("select#payment-option").val();
	if($selectedOption == "creditcard"){
		var errors = "";
		$("input[type='text'][name*='paymentForm']").each(function(){
			if($(this).val() == ''){
				$fieldIdentifier = $(this).attr("placeholder");
				errors += ("Enter a value in the "+$fieldIdentifier+"-field.\n");
			}
		});
		$ccExpMonth = $("#Card_Expiration_Month").val();
		$ccExpYear = $("#Card_Expiration_Year").val();
		if($ccExpYear.length != 4){
			errors += ("Enter the card expiration year value in 4 digit-format, like: 2020.\n");
		}
		if($ccExpMonth.length != 2){
			errors += ("Enter the card expiration month value in 2 digit-format, like: 02.\n");
		}
		
		//Return false in case of form errors:
		if(errors != ""){
			alert("There were one or more errors in your form:\n\n"+errors);
			return false;
		}
		else{
			return true;
		}	
	}
}