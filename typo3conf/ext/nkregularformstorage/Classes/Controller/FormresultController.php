<?php
namespace Netkyngs\Nkregularformstorage\Controller;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Roel Krottje <roel@netkyngs.com>, Netkyngs
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * FormresultController
 */
class FormresultController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected $frontendUserGroupRepository;
	
    /**
     * stateRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\StateRepository
     * @inject
     */
    protected $stateRepository = NULL;
	
    /**
     * membershipTemplateRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\MembershipTemplateRepository
     * @inject
     */
    protected $membershipTemplateRepository = NULL;
	
	/**
     * membershipRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\MembershipRepository
     * @inject
     */
    protected $membershipRepository = NULL;
	
	/**
     * discountcodeRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\DiscountcodeRepository
     * @inject
     */
    protected $discountcodeRepository = NULL;

    /**
     * formresultRepository
     *
     * @var \Netkyngs\Nkregularformstorage\Domain\Repository\FormresultRepository
     * @inject
     */
    protected $formresultRepository = NULL;
	
	
    protected $confirmationPage = 0;
    protected $failedReturnPage = 0;
    protected $redirectToFullUrl = 0;
    protected $selectedPackage = 0;
    protected $selectedPaymentType = 0;
    protected $storagePage = 37;
    protected $membersStoragePage = 0;
    protected $form = '';
    protected $senderAssociation = '';
    protected $aNewPaidMemberships = [];
    protected $frontendUser = null;
	
    /**
     * initialize action
     * 
     * @return void
     */
    public function initializeAction() {
		//Init query/storage settings:
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $this->stateRepository->setDefaultQuerySettings($querySettings);
		$this->membershipTemplateRepository->setDefaultQuerySettings($querySettings);
		$this->frontendUserRepository->setDefaultQuerySettings($querySettings);
		$this->frontendUserGroupRepository->setDefaultQuerySettings($querySettings);
		$this->formresultRepository->setDefaultQuerySettings($querySettings);
		$this->membershipRepository->setDefaultQuerySettings($querySettings);
		$this->discountcodeRepository->setDefaultQuerySettings($querySettings);
	}
    
    /**
     * action process
     *
     * @return void
     */
    public function processAction()
    {
        //Check if any payment/order data was provided:
        if (!empty($_POST)){					
            //Determine the formType:
            $formType = "membership";
            
            if (isset($_POST['formType'])){
                $formType = addSlashes($_POST['formType']);
            } else {
                //Get the logged in FE User:
                $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
                $this->frontendUser = $this->frontendUserRepository->findByUid($feUserUid);
            }

            //ReCaptcha v3 Validation Start:
			if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
				
				// Make and decode POST request:
				$data = array(
					'secret' => '6Leuc70UAAAAAHk_YSFxyVefaQck-lRFNmf-tkb4',
					'response' => $_POST['recaptcha_response']
				);
				$verify = curl_init();
				curl_setopt($verify, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
				curl_setopt($verify, CURLOPT_POST, true);
				curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
				$jsonresponse = json_decode(curl_exec($verify));

				// Take action based on the score returned:
				if ($jsonresponse->score >= 0.5) {
					// Verified.... Continue.
				} else {
					die("ReCaptcha Test Failed... Please go back and try again.<br/><br/><a href=\"javascript:history.back();\">Return to form</a>");
				}
			}
			//ReCaptcha v3 Validation End

            //Create form config array from POST array:
            $formConfigArray = $_POST;

            //Check for presence of POST->confirmationpage
            if(isset($_POST['confirmationpage'])){
                $this->confirmationPage = $_POST['confirmationpage'];
            }

            //Check for presence of POST->failedReturnFullPageLink
            if(isset($_POST['failedReturnFullPageLink'])){
                $this->failedReturnPage = $_POST['failedReturnFullPageLink'];
            }

            //Check for presence of POST->storagepage
            if (isset($_POST['storagepage'])){
                $this->storagePage = $_POST['storagepage'];
            }

            //Set some more variables:
            $this->selectedPaymentType = $formConfigArray['payment-option'];
            $trxID = '';
            $trxMessage = 'Unknown error'; 

            if ($formType == "newDonation"){
                //Single/isolated Donation type:
                $calculatedPrice = number_format((float)$formConfigArray['amount'], "2", ".", "");
                
            } else {
                //Membership -- Calculate the total price ($calculatedPrice) and collect any new membership purchases or membership renewals:
                $calculatedPrice = 0;
                $donationAmount = (int)$formConfigArray['donate'];
                $calculatedPrice += $donationAmount;

                //Check which memberships have been submitted for renewal:
                $aRenewals = [];
                
                for ($i=1; $i <= 6; $i++){
                        if ((string)$formConfigArray["newmembership-$i"] != '0') {
                                $membershipTemplateUid = (int)$formConfigArray["newmembership-$i"];
                                if(isset($formConfigArray["renew_$membershipTemplateUid"]) && (int)$formConfigArray["renew_$membershipTemplateUid"] == 1){
                                        $aRenewals[$membershipTemplateUid] = "formfield_newmembership-$i";
                                }
                        }
                }

                //Process input/provided form (membership) values for NEW memberships (not renewals!):
                foreach ($formConfigArray as $fieldname => $fieldvalue) {
                    if (strpos($fieldname, "newmembership-") !== FALSE) {
                        if (trim($fieldvalue) !== '' && (int)$fieldvalue != 0) {
                            $membershipTemplate = $this->membershipTemplateRepository->findByUid((int)$fieldvalue);
                            $calculatedPrice += $membershipTemplate->getPrice();
                            $this->aNewPaidMemberships[(int)$fieldvalue] = [];
                            $this->aNewPaidMemberships[(int)$fieldvalue]['uid'] = $membershipTemplate->getUid();
                            $this->aNewPaidMemberships[(int)$fieldvalue]['description'] = $membershipTemplate->getDescription();
                            $this->aNewPaidMemberships[(int)$fieldvalue]['renewal'] = 0;
                            $this->aNewPaidMemberships[(int)$fieldvalue]['type'] = $membershipTemplate->getMembershiptype();
                            list(,$newMembershipFieldItem) = explode("-", $fieldname);
                            $this->aNewPaidMemberships[(int)$fieldvalue]['stateUid'] = $formConfigArray["newmembershipstate-$newMembershipFieldItem"];
                            //Check whether this user already had this membership (which makes this a renewal)
                            foreach ($this->frontendUser->getMemberships() as $feUsersMembership){
                                if ($feUsersMembership->getMembershiptemplate()->getUid() == $membershipTemplate->getUid()){
                                    $this->aNewPaidMemberships[(int)$fieldvalue]['renewal'] = 1;
                                    $this->aNewPaidMemberships[(int)$fieldvalue]['membership_uid_for_renewal'] = $feUsersMembership->getUid();
                                    $this->aNewPaidMemberships[(int)$fieldvalue]['description'] = $this->aNewPaidMemberships[(int)$fieldvalue]['description']." (RENEWAL)";
                                    $this->aNewPaidMemberships[(int)$fieldvalue]['type'] = $membershipTemplate->getMembershiptype();
                                }
                            }
                        }
                    }
                }
            }
			
			if(($calculatedPrice * 1) < 1){
				die("<strong>Fraudulent Price/Amount Detected... Processing of payment was cancelled.</strong>");
			}

            $testmode = false; 
            $ptype = 0;
            $pstatus = 0;

            if ($this->selectedPaymentType == "creditcard"){
                //---------------------------------
                //Mode is direct credit cad payment
                //---------------------------------
                //Dertermine if this is a test:
                if($formConfigArray['paymentForm']['Card_Name'] == "Testmode123"){
                        $testmode = true;
                }

                //Process the payment:
                $response = $this->processCreditcardPayment($testmode, $calculatedPrice, $formType);
                $trxApprovalResult = $response[0];			
                $trxMessage = $response[3];
                
                if ($trxApprovalResult == 1) {
                        //Sale approved..
                        $pstatus = 1;
                        $trxID = date('Y')."00".$this->formresultRepository->findAll()->count();
                        
                        if ($formType == "membership"){
                                //Add (re)new(ed) memberships to the FE user:
                                $this->enableNewMemberships();
                        }
                } else {
                        //Sale declined, redirect back to form..
                        $pstatus = -1;
                        $this->addFlashMessage($trxMessage, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                        header("Location: /index.php?id=".$this->failedReturnPage."&paymentformerror=$trxMessage");
                        die("forwarded");
                }

            } else {

                /*
                 * Payment mode is invoice
                 */
                $ptype = 1;
                //-------------------------------------
                //Mode is send/print me an invoice/bill
                //-------------------------------------
                $trxID = date('Y')."00".$this->formresultRepository->findAll()->count();
                if ($formType == "membership"){
                    //Add (re)new(ed) memberships to the FE user:
                    $this->enableNewMemberships();
                }
            }
            $cardno = $formConfigArray['paymentForm']['Card_Number'];
            if (strlen($cardno) > 0) {
                $cardno = $formConfigArray['paymentForm']['cardtype'].' '.substr($cardno, 0,4).'xxxxxxxx'.substr($cardno, -4);
            }

            //Get the form data:
            $aFormData = $formConfigArray;
            unset($aFormData['paymentForm']['Card_Number']);
            unset($aFormData['paymentForm']['CCV_CVV_Code']);
            if ($formType == "membership"){
                $aSelectedMembershipsStringArray = [];
                foreach($this->aNewPaidMemberships as $paidMembership){
                        $aSelectedMembershipsStringArray[] = $paidMembership['description'];
                }
                $payDesc = $aFormData['Memberships_Paid_For'] = implode(", ", $aSelectedMembershipsStringArray);

            }
            $implodedFormResults = "";
            foreach($aFormData as $key => $val){
                $implodedFormResults .= ($key." = ".$val."\n");
            }

            //Determine the user's email and the company name:
            if ($formType == "membership"){
                $userCompany = $this->frontendUser->getCompany();
                $userName = $this->frontendUser->getName();
                $userEmail = $this->frontendUser->getEmail();
            } elseif($formType == "newDonation") {
                $userCompany = addSlashes($_POST['company']);
                $userName = addSlashes($_POST['firstname'])." ".addSlashes($_POST['lastname']);
                $userEmail = addSlashes($_POST['email']);
                $payDesc = 'Donation';
            }

            //Add a new formresult record:
            $newPaymentRecord = new \Netkyngs\Nkregularformstorage\Domain\Model\Formresult();
            $newPaymentRecord->setName($userCompany." ".($userName));
            $newPaymentRecord->setEmail($userEmail);
            $newPaymentRecord->setTrxid($trxID);
            $newPaymentRecord->setCardno($cardno);
            $newPaymentRecord->setInvoiceid($trxID);
            $newPaymentRecord->setTrxamount(number_format((float)$calculatedPrice, 2, '.', ''));
            $newPaymentRecord->setPstatus($pstatus);
            $newPaymentRecord->setPtype($ptype);
            $newPaymentRecord->setDescription($payDesc);
            $newPaymentRecord->setForm($implodedFormResults."\n"."Browser/Device information:\n".$this->getDeviceInformation());
            $newPaymentRecord->setFormserialized(serialize($aFormData));
            $newPaymentRecord->setCustomtstamp(time());
            $newPaymentRecord->setFeuseruid($GLOBALS['TSFE']->fe_user->user['uid']);
            $newPaymentRecord->setPid($this->storagePage);
            $this->formresultRepository->add($newPaymentRecord);

            //Permantently save all database (model) changes:
            $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
            $persistenceManager->persistAll();

            //Send an email to the admin:
            $fromName = $this->settings['adminname'];
            $fromEmail = $this->settings['fromemail'];
            $replyToEmail = $this->settings['adminemail'];

            //Create and send the admin notification mail:
            $body = "";

            if($formType == "membership"){
                    $bodyPre = "<h2>A new membership payment was received</h2>A new membership payment was received from {$this->frontendUser->getCompany()} ({$this->frontendUser->getName()}). The following information was provided:<br/><br/>";
                    $subject = "New Membership Payment Received";
            } elseif($formType == "newDonation"){
                    $bodyPre = "<h2>A new donation was received</h2>A new donation was received from ".$_POST['firstname']." ".$_POST['lastname'].". The following information was provided:<br/>";
                    $subject = "New donation has been received";
            }
            $body .= "<table style=\"font-family: Arial;\"><tbody>"; 

            foreach($aFormData as $key => $val) {

                if($key == 'confirmationpage'){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'storagepage'){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'failedReturnFullPageLink'){
                        unset($aFormData[$key]);
                        continue;
                }
                if(strpos($key, "newmembership") !== FALSE){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'submit'){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'paymentForm'){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'action'){
                        unset($aFormData[$key]);
                        continue;
                }
                if(strpos($key, "renew") !== FALSE){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'donate' && ($val == "" || (int)$val == 0)){
                        unset($aFormData[$key]);
                        continue;
                }
                elseif($key == 'donate'){
                        $key = "Donated";
                }
                if($key == 'discountcode' && $val == ""){
                        unset($aFormData[$key]);
                        continue;
                }
                if($key == 'Memberships_Paid_For'){
                        $body .= "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                        $key = "Ordered / Renewed Memberships";
                        $val = implode("<br/>", $aSelectedMembershipsStringArray);
                }
                $body .= "<tr>";
                $body .= "<td style=\"vertical-align: top; background-color: #e6e6e6;\">".ucfirst($key).":</td>";
                $body .= "<td style=\"vertical-align: top; background-color: #e6e6e6;\">$val</td>";
                $body .= "</tr>";
            }
            $body .= "</tbody></table>";  

            //Add price to body:
            $body .= "<br/><strong>Total Payment: $".number_format((float)$calculatedPrice, 2, '.', '')."</strong><br/>Payment method: ".$this->selectedPaymentType."<br/>";

            //Add additional information:
            $adminAdditionalBody = "";
            if($this->selectedPaymentType != "creditcard"){
                    $adminAdditionalBody .= "<br/>AWAITING PAYMENT / PAYMENT STILL NEEDS TO BE CONFIRMED.<br/>";
            }

            //Define recipients:
            $recipientArray = [];
            $recipientArray[0] = []; $recipientArray[0]['toEmail'] = $replyToEmail;

            //Send mail to ADMIN(s):
            foreach($recipientArray as $recipient) {

                $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
                $mail->setFrom(array($fromEmail => $fromName));
                $mail->setReplyTo (array($replyToEmail => $fromName));
                $mail->setTo(array($recipient['toEmail'] => $fromName));
                $mail->setSubject($subject);
                $mail->setBody($bodyPre.$body.$adminAdditionalBody, 'text/html');
                $mail->send();
            }

            //Send mail to new member:
            //Add Check payment information:
            if ($formType == "membership"){
                    $bodyPre = "<h2>Thank you for your Membership order / renewal</h2><p>The following information was submitted:</p><br/>";
            } elseif($formType == "newDonation") {
                    $bodyPre = "<h2>Thank you for your donation!</h2><p>Thank you so much for your donation. The following information was submitted:</p><br/>";
            }
            $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
            $mail->setFrom(array($fromEmail => $fromName));
            $mail->setReplyTo(array($replyToEmail => $fromName));
            $mail->setTo(array($userEmail => $userCompany));
            $mail->setSubject($subject);
            $mail->setBody($bodyPre.$body, 'text/html');
            $mail->send();

            if ($this->selectedPaymentType == "creditcard"){
                    header("Location: /index.php?id=".$this->confirmationPage);
            }else{
                //Don't forward, just show custom (plugin) thank you / confirmation page and automatically open PDF for download/printing:
                $this->view->assign('settings', $this->settings);
                $this->view->assign('currenPage', $GLOBALS['TSFE']->id);
                $this->view->assign('printInvoice', 1);
                $this->view->assign('paymentUid', $newPaymentRecord->getUid());
            }
        }		
        //Else, check for another requested action:
        elseif(filter_input(INPUT_GET, "action", FILTER_SANITIZE_SPECIAL_CHARS)) {
            if(filter_input(INPUT_GET, "action", FILTER_SANITIZE_SPECIAL_CHARS) == "printinvoice"){
                //Print invoice (PDF) action:
                $paymentUid = filter_input(INPUT_GET, "paymentuid", FILTER_SANITIZE_NUMBER_INT);
                $this->printInvoice($paymentUid);
            }
        }
    }
	
    //Function that prints an invoice based on a provided array:
    public function printInvoice($paymentUid){

            //Get the logged in User / Uid:
            $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];

            //Get the payment record:
            $oPayment = $this->formresultRepository->findByUid($paymentUid);

            //Get the (unserialized) payment Form Array:
            $aPaymentFormArray = unserialize($this->formresultRepository->findByUid($paymentUid)->getFormserialized());

            //Prepare the PDF field population array:
            $aFields = array(
                    'date'   				=> date('m/d/Y', $oPayment->getCustomtstamp()),
                    'ordernumber' 			=> $oPayment->getInvoiceid(),
                    'invoicename'    		=> $GLOBALS['TSFE']->fe_user->user['first_name'].", ".$GLOBALS['TSFE']->fe_user->user['last_name'],
                    'invoicecompany'   		=> $GLOBALS['TSFE']->fe_user->user['company'],
                    'invoiceaddress'   		=> $GLOBALS['TSFE']->fe_user->user['address'],
                    'invoiceaddress2'   	=> $GLOBALS['TSFE']->fe_user->user['additionaladdress'],
                    'invoicecitystatezip'   => $GLOBALS['TSFE']->fe_user->user['city'].", ".$GLOBALS['TSFE']->fe_user->user['state'].". ".$GLOBALS['TSFE']->fe_user->user['zip'],
                    'discountcodetext'   	=> $aPaymentFormArray['discountcode'] != '' ? "Discount code {$aPaymentFormArray['discountcode']}" : '',
                    'discountamount'  		=> $aPaymentFormArray['discountcode'] != '' ? "$".$this->discountcodeRepository->findByCode($aPaymentFormArray['discountcode'])->getFirst()->getDiscount() : '',
                    'donationtext'   		=> $aPaymentFormArray['donate'] != '' ? 'Donation amount' : '',
                    'donationamount'   		=> $aPaymentFormArray['donate'] != '' ? '$'.number_format($aPaymentFormArray['donate'], "2") : '',
                    'invoiceamount'			=> $aPaymentFormArray['purchasetotal'],
                    'paymenttype'			=> ($aPaymentFormArray['payment-option'] == "printinvoice" ? "Check" : "Credit card"),
            );

            //Calculate/determine the renewals array:
            $aRenewals = [];
            foreach($aPaymentFormArray as $inputField => $inputValue){
                    if(strpos($inputField, "renew_") !== FALSE){
                            $aInputTemp = explode("_", $inputField);
                            $aRenewals[$aInputTemp[1]] = $aInputTemp[1];
                    }
            }

            //Process all membership rows:		
            for($i=1; $i <= 6; $i++){
                    if($aPaymentFormArray["newmembership-$i"] != 0){
                            $oNewsletters = $this->membershipTemplateRepository->findByUid($aPaymentFormArray["newmembership-$i"])->getIncludednewsletters();
                            $aNewsletters = [];
                            foreach($oNewsletters as $oNewsletter){
                                    $aNewsletters[] = $oNewsletter->getName();
                            }
                            if(isset($aRenewals[$aPaymentFormArray["newmembership-$i"]])){
                                    $aFields["membershipplan_$i"] 		= $this->membershipTemplateRepository->findByUid($aPaymentFormArray["newmembership-$i"])->getDescription()." (RENEWAL)";
                            }
                            else{
                                    $aFields["membershipplan_$i"] 		= $this->membershipTemplateRepository->findByUid($aPaymentFormArray["newmembership-$i"])->getDescription();
                            }
                            $aFields["membershiptype_$i"] 		= $this->frontendUserGroupRepository->findByUid($this->membershipTemplateRepository->findByUid($aPaymentFormArray["newmembership-$i"])->getMembershiptype())->getTitle();
                            $aFields["membershipnewsletters_$i"] = implode(", ", $aNewsletters);
                            $aFields["membershipstate_$i"] 		= $this->stateRepository->findByUid($aPaymentFormArray["newmembershipstate-$i"])->getStateshort();
                            $aFields["membershipprice_$i"] 		= "$".$this->membershipTemplateRepository->findByUid($aPaymentFormArray["newmembership-$i"])->getPrice();
                    }
            }

            //Generate and server the PDF:
            require($_SERVER['DOCUMENT_ROOT'].'/fpdm-pdf/fpdm.php');
            $pdf = new \FPDM($_SERVER['DOCUMENT_ROOT']."/typo3conf/ext/nkcadportal/Resources/Public/Assets/cad_invoice_template.pdf");
            $pdf->Load($aFields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
            $pdf->Merge();
            $pdf->Output("D", "invoice.pdf");
	}
	
	//Payment function:
	public function processCreditcardPayment($testmode, $calculatedPrice, $formType){

            $nameoncard = $_POST['paymentForm']['Card_Name'];
            $billingaddress = $_POST['paymentForm']['Address'];
            $city = $_POST['paymentForm']['City'];
            $state = $_POST['paymentForm']['State'];
            $zip = $_POST['paymentForm']['ZIP'];
            $cardnumber = $_POST['paymentForm']['Card_Number'];
            $securitycode = $_POST['paymentForm']['CCV_CVV_Code'];
            $cc_exp_month = trim($_POST['paymentForm']['Card_Expiration_Month']);
            $cc_exp_year = trim($_POST['paymentForm']['Card_Expiration_Year']);
            
            if (strlen($cc_exp_month) < 1){
                $cc_exp_month = "0".(string)$cc_exp_month;
            }
            if (strlen($cc_exp_year) == 4){
                $cc_exp_year = substr($cc_exp_year, -2);
            }
            if ($formType == "membership"){
                $userEmail = $this->frontendUser->getEmail();
            } elseif($formType == "newDonation"){
                $userEmail = addSlashes($_POST['email']);
            }
            
            $data['name'] = $nameoncard;
            $data['cardno'] = $cardnumber;
            $data['cvv'] = $securitycode;
            $data['expmn'] = $cc_exp_month;
            $data['expyr'] = $cc_exp_year;
            $data['amount'] = $calculatedPrice;
            $data['address'] = $billingaddress;
            $data['zip'] = $zip;
            $data['email'] = $userEmail;


            return $this->makeTransaction($data, $testmode);
		
	}
	
	public function getDeviceInformation(){
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
        /**
         * Add memberships
         */
	public function enableNewMemberships(){

            foreach($this->aNewPaidMemberships as $aMembershipTemplate){
                //Get the current date and time object:
                $currentDateTimeObject = $this->getDatetimeObjectNow();
                //Distinguish DOT type (12 months membership duration) from DFT type (11 months membership duration):
                if ($aMembershipTemplate['type'] == "DOT"){
                        $expirationDateTimeObject = $this->getDatetimeObjectNow()->modify('+12 months');
                }
                else{
                        $expirationDateTimeObject = $this->getDatetimeObjectNow()->modify('+11 months');
                }
                //Get the actual membershipTemplate record:
                $oMembershipTemplateRecord = $this->membershipTemplateRepository->findByUid($aMembershipTemplate['uid']);

                if ($aMembershipTemplate['renewal'] == 1) {
                        //Renewal
                        $renewalMembership = $this->membershipRepository->findByUid($aMembershipTemplate['membership_uid_for_renewal']);

                        if ($renewalMembership instanceof \Netkyngs\Nkcadportal\Domain\Model\Membership) {
                            /*
                             * Check whether expired membership or active
                             * If expired, then act as new memebership
                             * if active, new membership to activate after the current expires
                             */
                            $expiryDate = $renewalMembership->getEndtimecustom();
                            $interval = $currentDateTimeObject->diff($expiryDate);

                            $newMembership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();
                            $newMembership->setMembershiptemplate($oMembershipTemplateRecord);
                            $newMembership->setState($this->stateRepository->findByUid($aMembershipTemplate['stateUid']));

                            /*
                             * Check if expired
                             */
                            if ($interval->format("%R%d") == '-') { 
                                // Add new subscription from today
                                $newMembership->setStarttimecustom($currentDateTimeObject);
                                $newMembership->setEndtimecustom($expirationDateTimeObject);

                            } else {
                                $newMembership->setStarttimecustom($expiryDate);
                                $cpExpDate = clone $expiryDate;
                                //Start date will be a day after the expiry date
                                if ($aMembershipTemplate['type'] == "DOT"){
                                   $cpExpDate->add(new \DateInterval('P12M'));
                                } else{
                                   $cpExpDate->add(new \DateInterval('P11M'));
                                }
                                $newMembership->setEndtimecustom($cpExpDate);
                            }
                            
                            $newMembership->setPid($this->settings['membersPID']);
                            $this->frontendUser->addMembership($newMembership);
                            $this->frontendUserRepository->update($this->frontendUser);
                        }
                        
                } else {
                        //New
                        $newMembership = new \Netkyngs\Nkcadportal\Domain\Model\Membership();
                        $newMembership->setMembershiptemplate($oMembershipTemplateRecord);
                        $newMembership->setState($this->stateRepository->findByUid($aMembershipTemplate['stateUid']));
                        $newMembership->setStarttimecustom($currentDateTimeObject);
                        $newMembership->setEndtimecustom($expirationDateTimeObject);
                        $newMembership->setPid($this->settings['membersPID']);
                        $this->frontendUser->addMembership($newMembership);
                        $this->frontendUserRepository->update($this->frontendUser);
                }

                //Permantently save all database (model) changes:
                $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
                $persistenceManager->persistAll();
            }
	}
	
        /**
         * 
         * @return \DateTime
         */
	public function getDatetimeObjectNow() {
		$tz_object = new \DateTimeZone('America/New_York');
		$datetime = new \DateTime();
		$datetime->setTimezone($tz_object);
		return $datetime;
	}
        
        /**
         * 
         * @param array $data
         * @param bool $testmode
         * @return string
         */
        protected function makeTransaction($data,$testmode=false)
        {
            $calculatedPrice = $data['amount'];
            $cc_exp_month = $data['expmn'];
            $cc_exp_year = $data['expyr'];
            $billingaddress = $data['address'];
            $zip = $data['zip'];
            $nameoncard = $data['name'];
            $cardnumber = $data['cardno'];
            $securitycode = $data['cvv'];
            $userEmail = $data['email'];
            
            $authnet_values = array(
			'x_invoice_num' => time(),
			'x_amount' => $calculatedPrice,
			'x_exp_date' => $cc_exp_month.$cc_exp_year,
			'x_address' => $billingaddress,
			'x_zip' => $zip,
			'x_first_name' => '',
			'x_last_name' => $nameoncard,
			'x_relay_response' => false,
			'x_type' => 'AUTH_CAPTURE',
			'x_method' => 'CC',
			'x_login' => $this->settings['APILogin'],
			'x_tran_key' => $this->settings['APITrxKey'],
			'x_card_num' => $cardnumber,
			'x_card_code' => $securitycode,
			'x_delim_data' => true,
			'x_delim_char' => '|',
			'x_relay_response' => false,
			'x_test_request' => $testmode,
			'x_email' => $userEmail,
			'x_customer_ip' => $_SERVER["REMOTE_ADDR"]
		 );
		 
		 //Distinguish DEV from LIVE:
		 if ($testmode == true) {
			//DEV
			$authnet_values['x_login'] = '4Eh49TG7yb';
			$authnet_values['x_tran_key'] = '9etDm4A2227Um7JF';
			$url = 'https://test.authorize.net/gateway/transact.dll';			
		 } else {
			//PROD/LIVE
			$url = 'https://secure.authorize.net/gateway/transact.dll';
		 }

		 $postString = ''; 
		 foreach ($authnet_values as $key => $value){
			$postString .= $key.'='.urlencode($value).'&';
		 }
		 $postString = trim($postString, '&');


		 $request = curl_init($url);
		 curl_setopt($request, CURLOPT_HEADER, 0);
		 curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
		 curl_setopt($request, CURLOPT_POSTFIELDS, $postString);
		 curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
		 curl_setopt($request, CURLOPT_SSL_VERIFYHOST, false);
		 $postResponse = curl_exec($request);
		 curl_close($request);

		 $response = explode('|', $postResponse);
		 if (!isset($response[7]) || !isset($response[3]) || !isset($response[9])){
			$msg = 'Authorize.net returned a malformed response, aborted';
			if (isset($response[7])){
				$msg .= ' '.(int)$response[7];
			}
			die($msg);
		}
		
		return $response;
        }


        /**
         * List all the payments in BE
         */
        public function txnlistAction() 
        {
            $payments = $this->formresultRepository->findAll();
            $this->view->assign('payments', $payments);
            
        }
        
        /**
         * Charge a credit card
         */
        public function chargecardAction() {
          
        }
        
        /**
         * BE processing to charge credit card
         */
        public function capturepayAction() {
            //Validate the form
            $msg = '';

            $arguments = $this->request->getArguments();
            if (trim($arguments['name']) == '' && isset($arguments['name'])) {
                $msg .= "Please enter Name on Card\n";
            }
            if (trim($arguments['amount']) == '' && isset($arguments['amount'])) {
                $msg .= "Please enter Amount\n";
            }
            if (trim($arguments['cardno']) == '' && isset($arguments['cardno'])) {
                $msg .= "Please enter Credit Card number\n";
            }
            if (trim($arguments['expdate']) == '' && isset($arguments['expdate'])) {
                $msg .= "Please enter Card Expiry date\n";
                
            } else {
                
                $dtArr = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode('/', $arguments['expdate']);
                
                if(count($dtArr) != 2) {
                     $msg .= "Please enter Card Expiry date in MM/YY format\n";
                } else {
                    $cc_exp_month = $dtArr[0];
                    $cc_exp_year = $dtArr[1];
                    
                    if (strlen($cc_exp_month) < 1){
                        $cc_exp_month = "0".(string)$dtArr[0];
                    }
                    if (strlen($cc_exp_year) == 4){
                        $cc_exp_year = substr($cc_exp_year, -2);
                    }
                }
            }
            if (trim($arguments['code']) == '' && isset($arguments['code'])) {
                $msg .= "Please enter Card security code (CVV)\n";
            }
            
            if ($msg != '') {
                
                $this->addFlashMessage($msg,'Validation Error', 
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
                $this->forward('chargecard');
                
            } else {
                $formData = $arguments;
                $form = '';
                unset($formData['cardno']);
                unset($formData['code']);
                unset($formData['btnsub']);
                unset($formData['expdate']);
                
                foreach($formData as $elem=>$val) {
                    $form .= $elem .": ".$val."\n";
                }
                
                //Get the userid by email
                $users = $this->frontendUserRepository->findByEmail($arguments['email']);
                
                if ($users->count() > 0) {
                    
                    $user = $users->getFirst(); 
                    
                    if ($user instanceof \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser) {
                        
                        $data['name'] = $arguments['name'];
                        $data['cardno'] = $arguments['cardno'];
                        $data['cvv'] = $arguments['code'];
                        $data['expmn'] = $cc_exp_month;
                        $data['expyr'] = $cc_exp_year;
                        $data['amount'] = $arguments['amount'];
                        $data['address'] = $arguments['address'];
                        $data['zip'] = $arguments['zip'];
                        $data['email'] = $arguments['email'];

                        if ($arguments['name'] == "Testmode123"){
                            $testmode = true;
                        }

                        $response = $this->makeTransaction($data, $testmode);

                        $trxApprovalResult = $response[0];			
                        $trxMessage = $response[3];

                        if ($trxApprovalResult == 1){
                            //Sale approved..
                            $pstatus = 1;
                            $trxID = date('Y')."00".$this->formresultRepository->findAll()->count();
                            $this->addFlashMessage('Credit card payment successful','Transaction', 
                            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK, FALSE);

                        } else {
                            //Sale declined, redirect back to form..
                            $pstatus = -1;
                            $this->addFlashMessage($trxMessage,'Transaction', 
                            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
                        }

                         //Add a new formresult record:
                        $newPaymentRecord = new \Netkyngs\Nkregularformstorage\Domain\Model\Formresult();
                        $newPaymentRecord->setName($user->getCompany()." ".$user->getUsername());
                        $newPaymentRecord->setEmail($data['email']);
                        $newPaymentRecord->setTrxid($trxID);
                        $newPaymentRecord->setCardno($data['cardno']);
                        $newPaymentRecord->setInvoiceid($trxID);
                        $newPaymentRecord->setTrxamount(number_format((float)$data['amount'], 2, '.', ''));
                        $newPaymentRecord->setPstatus($pstatus);
                        $newPaymentRecord->setPtype(0);
                        $newPaymentRecord->setDescription($arguments['description']);
                        $newPaymentRecord->setForm($form);
                        $newPaymentRecord->setFormserialized(serialize($form));
                        $newPaymentRecord->setCustomtstamp(time());
                        $newPaymentRecord->setFeuseruid($user->getUid());
                        $newPaymentRecord->setPid($this->storagePage);

                        $this->formresultRepository->add($newPaymentRecord);
                        $this->addFlashMessage('Card successfuly charged','Transaction Status', 
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::OK, FALSE);
                        
                        $this->redirect('txnlist');
                    
                    } else {
                        $this->addFlashMessage('Member data could be determined','Validation Error', 
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
                        $this->forward('chargecard');
                    }
                
                } else {
                     $this->addFlashMessage('User could be detected with email provided','Validation Error', 
                        \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR, FALSE);
                        $this->forward('chargecard');
                }
               
            }
        }

}