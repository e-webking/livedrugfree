<?php
namespace Netkyngs\Nkcadportal\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2018 Roel Krottje <roel@netkyngs.com>, Netkyngs
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

if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('armpdfkit')) {
    require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('armpdfkit').'Classes/Pdf/Pdf.php');
}

/**
 * CustomFrontendUserController
 */
class CustomFrontendUserController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
	
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;
	
    /**
     * contactRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\ContactRepository
     * @inject
     */
    protected $contactRepository = NULL;
	
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
     * discountcodeRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\DiscountcodeRepository
     * @inject
     */
    protected $discountcodeRepository = NULL;
	
    /**
     * documentRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\DocumentRepository
     * @inject
     */
    protected $documentRepository = NULL;
	
    /**
     * newsletterRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\NewsletterRepository
     * @inject
     */
    protected $newsletterRepository = NULL;
	
    /**
     * reminderRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\ReminderRepository
     * @inject
     */
    protected $reminderRepository = NULL;
	
    /**
     * reportRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;
    
    /**
     * membershipRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\MembershipRepository
     * @inject
     */
    protected $membershipRepository = NULL;
	
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
        $this->discountcodeRepository->setDefaultQuerySettings($querySettings);
        $this->documentRepository->setDefaultQuerySettings($querySettings);
        $this->newsletterRepository->setDefaultQuerySettings($querySettings);
        $this->frontendUserRepository->setDefaultQuerySettings($querySettings);
        $this->reminderRepository->setDefaultQuerySettings($querySettings);
        $this->reportRepository->setDefaultQuerySettings($querySettings);
    }

    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
		
	//Get members:
        $members = $this->frontendUserRepository->findAll();
        $this->view->assign('members', $members);
		
		//Get membershiptemplates:
		$membershiptemplates = $this->membershipTemplateRepository->findAll();
        $this->view->assign('membershiptemplates', $membershiptemplates);
		
		//Get the newsletters:
		$newsletters = $this->newsletterRepository->findAll();
		foreach($newsletters as $newsletter){
                        $fileObj = $newsletter->getFile();
                        if (!is_null($fileObj)) {
                            $publicUrl = $newsletter->getFile()->getOriginalResource()->getPublicUrl();
                            $aPublicUrlTmp = explode("/", $publicUrl);
                            $newsletter->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
                        }
		}
        $this->view->assign('newsletters', $newsletters);
		
		//Get the documents:
		$documents = $this->documentRepository->findAll();
		foreach($documents as $document){
                    $fileObj = $document->getFile();
                    if (!is_null($fileObj)) {
                        $publicUrl = $document->getFile()->getOriginalResource()->getPublicUrl();
                        $aPublicUrlTmp = explode("/", $publicUrl);
                        $document->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
                    }
		}
        //$this->view->assign('documents', $documents);
		
		//Get the reminders:
		$reminders = $this->reminderRepository->findAll();
		foreach($reminders as $reminder){
			$reminder->sendoptionsstring = $reminder->getDaysspan()." days ".$reminder->getWhentosend()." ".$reminder->getFieldcondition()." ".$reminder->getSendtogroup();
		}
        $this->view->assign('reminders', $reminders);
		
		//Get reports:
		$reports = $this->reportRepository->findAll();
        $this->view->assign('reports', $reports);
		
		//Get discount codes:
		$codes = $this->discountcodeRepository->findAll();
        $this->view->assign('codes', $codes);
		
    }
	
	/**
     * action ajaxbe
     * 
     * @return void
     */
    public function ajaxbeAction()
    {
        if ($action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_SPECIAL_CHARS)) {

                //Get some more vars:
                $uid = filter_input(INPUT_GET, "uid", FILTER_SANITIZE_NUMBER_INT);

                //Switch actions:
                switch($action){

                        case "delete-member":

                                $feUserToDelete = $this->frontendUserRepository->findByUid($uid);
                                $this->frontendUserRepository->remove($feUserToDelete);

                                break;

                        case "hide-member":

                                $feUserToHide = $this->frontendUserRepository->findByUid($uid);
                                $feUserToHide->setHidden(1);
                                $this->frontendUserRepository->update($feUserToHide);

                                break;

                        case "unhide-member":

                                $feUserToUnHide = $this->frontendUserRepository->findByUid($uid);
                                $feUserToUnHide->setHidden(0);
                                $this->frontendUserRepository->update($feUserToUnHide);

                                break;

                        case "serve-download":

                                // We'll be outputting a PDF
                                //header('Content-type: application/pdf');

                                //Get the friendly filename:
                                $friendlyfilename = filter_input(INPUT_GET, "friendlyfilename", FILTER_SANITIZE_SPECIAL_CHARS);
                                header('Content-Disposition: attachment; filename="'.$friendlyfilename.'"');

                                //Get the actual file path:
                                $filePath = filter_input(INPUT_GET, "filepath", FILTER_SANITIZE_SPECIAL_CHARS);
                                readfile($filePath);

                                break;
                            
                        case "serve-csv-report":
                            
                            //Report download
                            $reportObj = $this->reportRepository->findByUid($uid);
                            $filename = ($reportObj->getFilename() != '') ? $reportObj->getFilename() : 'report_'.$uid.'.csv';
                            $sqlQuery = $reportObj->getSqlquery();
                            
                            $results = $GLOBALS['TYPO3_DB']->sql_query($sqlQuery);
                            while($prop = $results->fetch_field()) {
                                $header .= $prop->name.",";
                            }
                            
                            $data = substr($header, 0, -1)."\n";
                            while( $row = $results->fetch_row())
                            {
                                $line = '';
                                foreach( $row as $value )
                                {                                            
                                    if ( ( !isset( $value ) ) || ( $value == "" ) )
                                    {
                                        $value = ",";
                                    }
                                    else
                                    {
                                        $value = str_replace( '"' , '""' , $value );
                                        $value = '"' . $value . '"' . ",";
                                    }
                                    $line .= $value;
                                }
                                $data .= trim(substr($line,0,-1)) . "\n";
                            }
                            $data = str_replace( "\r" , "" , $data );
                            
                            header("Content-type: application/octet-stream");
                            header("Content-Disposition: attachment; filename=$filename");
                            header("Pragma: no-cache");
                            header("Expires: 0");
                            
                            print "$data";
                            exit;
                            break;

                }

                //Permantently save all database (model) changes:
                $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
                $persistenceManager->persistAll();
        }
        
    }
	
	
    
    /**
     * action show
     * 
     * @return void
     */
    public function showAction()
    {
		
        if (isset($_REQUEST['paymentformerror'])) {
            $this->addFlashMessage($_REQUEST['paymentformerror'], '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
        //Check if a form was submitted:
        if(isset($_POST['tx_nkcadportal_nkcadportalfe'])){
                if(isset($_POST['tx_nkcadportal_nkcadportalfe']['formaction'])){
                        switch($_POST['tx_nkcadportal_nkcadportalfe']['formaction']){

                                case "createcontact":
                                        $this->createContact();
                                        break;

                                case "updatefrontenduser":
                                        $this->updateFrontendUser();
                                        break;
                        }
                }
        }

        //Check if an AJAX request was made:
        if ($action = filter_input(INPUT_GET, "action", FILTER_SANITIZE_SPECIAL_CHARS)) {
                $this->performAjaxRequest($action);
                die();
        }

        //Add CSS and JS:
        $this->addCssAndJsToFE();

        //Get the logged in FE User:
        $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $frontendUser = $this->frontendUserRepository->findByUid($feUserUid);

        //Add the accessible documents to the $frontendUser object:
        $frontendUser = $this->addDocumentsToUser($frontendUser);

        //Add download path data to the documents:
        foreach($frontendUser->documents as $document){
                $publicUrl = $document->getFile()->getOriginalResource()->getPublicUrl();
                $aPublicUrlTmp = explode("/", $publicUrl);
                $document->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
        }

        //Add the accessible newsletters to the $frontendUser object:
        $frontendUser = $this->addNewslettersToUser($frontendUser);

        //Add download path data to the newsletters:
        foreach($frontendUser->newsletters as $newsletter){
                $publicUrl = $newsletter->getFile()->getOriginalResource()->getPublicUrl();
                $aPublicUrlTmp = explode("/", $publicUrl);
                $newsletter->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
        }

        //Prepare profile form hearboutusoptions array:
        $aHearaboutusoptions = array(
                "Chamber"=>"Chamber",
                "Chuck"=>"Chuck",
                "Drug Free Workplace Help Website"=>"Drug Free Workplace Help Website",
                "INSURANCE COMPANY"=>"Insurance Company",
                "Karen"=>"Karen",
                "MAILER"=>"Mailer",
                "Noy"=>"Noy",
                "POSTCARD"=>"Postcard",
                "REFERRAL"=>"Referal",
                "Renewal"=>"Renewal",
                "Staci"=>"Staci",
                "WEB"=>"Web",
                "OTHER"=>"Other"
        );

        //Prepare contact form contacttypes array:
        $aContacttypes = array("DFW"=>"DFW", "DOT"=>"DOT", "Billing"=>"Billing", "Random"=>"Random");

        //Prepare form data:
        $aFormdata = array(
                "hearaboutusoptions"=>$aHearaboutusoptions,
                "contacttypes"=>$aContacttypes
        );

        //Get all states:
        $allStates = $this->stateRepository->findByShowinfestatelist(1);

        //Get all memberships:
        $allMemberships = $this->membershipTemplateRepository->findAll();
		
		//Assign the required variables to the template:
        $this->view->assign('frontendUser', $frontendUser);
		$this->view->assign('formdata', $aFormdata);
		$this->view->assign('allStates', $allStates);
		$this->view->assign('allMemberships', $allMemberships);
		$this->view->assign('feUserMembershipsCount', $frontendUser->getMemberships()->count());
		$this->view->assign('feMessage', $feMessage);
    }
    
    /**
     * Certificate downalod
     */
    public function certdwnAction() {
        
        if ($this->request->hasArgument('membership')) {
            
            $membershipUid = $this->request->getArgument('membership');
            $membership = $this->membershipRepository->findByUid($membershipUid);
            
            if ($membership instanceof \Netkyngs\Nkcadportal\Domain\Model\Membership) {
                
                $startTime = $membership->getStarttimecustom()->format('F d, Y');
                $endTime = $membership->getEndtimecustom()->format('F d, Y');
                
                $memTpl = $membership->getMembershiptemplate();
                $state = $membership->getState();
                $fname = 'DFWCertificate_'.$state->getState().'.pdf';
                $srcFile = PATH_site.'uploads/tx_nkcadportal/'.$state->getPdftpl();
                
                if (file_exists($srcFile) && is_file($srcFile)) {
                    
                    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('armpdfkit')) {

                        $pdf = $this->objectManager->get('ARM\\Armpdfkit\\Pdf\\Pdf');
                        $pdf::initFpdi('L');
                        

                         //Copy the invoice
                        $pdf::$fpdi->SetY(0);
                        $pdf::$fpdi->setSourceFile($srcFile);
                        $tplIdx = $pdf::$fpdi->importPage(1);
                        $pdf::$fpdi->useTemplate($tplIdx, 0, 0, 0, 0, true);
                        
                        $pdf::$fpdi->SetFont('helvetica','B',20);
                        $pdf::$fpdi->SetY(45);
                        $pdf::$fpdi->Cell(280,20, $GLOBALS['TSFE']->fe_user->user['company'],0,0,"C");
                        $pdf::$fpdi->SetFont('helvetica','',16);
                        $pdf::$fpdi->SetY(95);
                        $pdf::$fpdi->Cell(280,14, $startTime.' - '.$endTime,0,0,'C');
                        
                        $fileCert = PATH_site . 'uploads/tx_nkcadportal/' . $fname;
                        
                        $pdf::$fpdi->Output($fname, 'D');
                    }
                }
            }
        }
        
        exit;
    }
	
	public function addDocumentsToUser($frontendUser)
	{
		//Get all states this user has a membership for:
		$aUserStates = [];
		foreach($frontendUser->getMemberships() as $membership){
			$aUserStates[$membership->getState()->getUid()] = $membership->getState();
		}
		
		//Get the single $oAllStates state object:
		$oAllStates = $this->stateRepository->findByUid(1);

		//Collect the documents for a) the usergroup this user belongs to and b) the state this user has a membership for:
		$collectedDocuments = $this->documentRepository->findByUsergroups($frontendUser->getUsergroup());
		$frontendUser->documents = [];
		foreach($collectedDocuments as $document){
			foreach($document->getStates() as $documentState){
				if($documentState->getUid() == $oAllStates->getUid()){
					$frontendUser->documents[] = $document;
					continue(2);
				}
				else{
					foreach($aUserStates as $userState){
						if($documentState->getUid() == $userState->getUid()){
							$frontendUser->documents[] = $document;
							continue(3);
						}
					}
				}
			}
		}
		
		//Return the updated user object:
		return $frontendUser;
	}
	
	public function addNewslettersToUser($frontendUser)
	{

		//Get all newsletter-types this user has access to:
		$aUserNewsletterTypes = [];
		foreach($frontendUser->getMemberships() as $membership){
			$membershipTemplate = $membership->getMembershiptemplate();
			foreach($membershipTemplate->getIncludednewsletters() as $newsletterType){
				 $aUserNewsletterTypes[$newsletterType->getUid()] = $newsletterType;
			}
		}
	
		//Collect the newsletters that the user's memberships provide access to:
		if(!empty($aUserNewsletterTypes)){
			$frontendUser->newsletters = $this->newsletterRepository->findByNewslettertypes($aUserNewsletterTypes);
		}

		//Return the updated user object:
		return $frontendUser;
	}
	
	public function performAjaxRequest($action)
	{		
	
		$providedValue = trim(filter_input(INPUT_GET, "value", FILTER_SANITIZE_SPECIAL_CHARS));
	
		switch($action)
		{
			case "checkdiscountcode":
				
				//Find the discount code:
				$discountCode = $this->discountcodeRepository->findByCode($providedValue)->getFirst();
				if($discountCode != null){
					echo number_format($discountCode->getDiscount(), "2");
				}
				else {
					echo 0;
				}
				break;
				
			case "removecontact":
			
				$contactToRemove = $this->contactRepository->findByUid((int)$providedValue);
				$this->contactRepository->remove($contactToRemove);
				echo "OK";
			
				break;
		}
		
		//Permantently save all database (model) changes:
		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
		$persistenceManager->persistAll();
		
		//Exit/die immediately:
		die();
		
	}
	
	function updateFrontendUser()
	{
		//Get the form input data:
		$aInputArray = filter_input(INPUT_POST, 'tx_nkcadportal_nkcadportalfe', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		$aFormData = $aInputArray['FrontendUser'];
		$changePW = filter_input(INPUT_POST, 'profile_change_pw', FILTER_SANITIZE_NUMBER_INT);
		$oldPWValue = filter_input(INPUT_POST, 'oldpassword', FILTER_SANITIZE_SPECIAL_CHARS);
		
		//Get the logged in FE User:
		$feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
		$frontendUser = $this->frontendUserRepository->findByUid($feUserUid);

		//Update the property values:
		$currentPassword = "";
		foreach($aFormData as $formField => $formValue){
			//Some exceptions/alterations:
			if($formField == "phone") { $formField = "telephone"; }
			if($formField == "password") {
				if($changePW == 1){
					//Check if the provided old (plain) password matches the stored (salted) password:
					if($this->testSaltedPasswordAgainstStoredValue($oldPWValue, $frontendUser->getPassword())){
						//Provided old password correct - Continue and Salt the new password:
						$newPassword = $this->saltPassword($formValue);
						$formValue = $newPassword;
					}
					else{
						//Old password incorrect -- Set the flash message & Completely exist the profile update function::
						$this->addFlashMessage(
							'The current/old password you entered was incorrect - Nothing updated...! Please re-enter your current password and the new password you would like to change it to.', //Message
							'Profile saving error', //Title
							$severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR,
							FALSE //storeInSession?
						);
						return false;
					}
				}
				else{
					//Skip password change:
					continue;
				}
			}
			//Define the function to call:
			$setFunction = "set".ucfirst($formField);
			$frontendUser->$setFunction($formValue);
		}
        $this->frontendUserRepository->update($frontendUser);
		
		//Set the flash message:
		$this->addFlashMessage(
			'Your profile was successfully updated.', //Message
			'Profile saved', //Title
			$severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
			FALSE //storeInSession?
		);
		
		//Permantently save all database (model) changes:
		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
		$persistenceManager->persistAll();
	}
	
	/**
     * function createContact
     * 
     * @return void
     */
    public function createContact()
    {
		
		//Set variables:
		$contactAlreadyExists = 0;
		
		//Get the form input data:
		$aInputArray = filter_input(INPUT_POST, 'tx_nkcadportal_nkcadportalfe', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
		$aFormData = $aInputArray['newContact'];
		
		//Get the logged in FE User:
		$feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
		$frontendUser = $this->frontendUserRepository->findByUid($feUserUid);
		
		//First - Check if this contact doesn't already exist for this user...
		foreach($frontendUser->getContacts() as $existingContact){
			if($existingContact->getFirstname() == trim($aFormData['firstname']) && $existingContact->getLastname() == trim($aFormData['lastname'])){
				//Set the flash message:
				$this->addFlashMessage(
					'This contact already exists... Nothing added.', //Message
					'Contact already exists', //Title
					$severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
					FALSE //storeInSession?
				);
				$contactAlreadyExists = 1;
				break;
			}
		}
		
		//Continue only if contact doesnt exist yet...
		if($contactAlreadyExists == 0){
		
			//Create the new contact:
			$newContact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();
			$newContact->setFirstname(trim($aFormData['firstname']));
			$newContact->setLastname(trim($aFormData['lastname']));
			$newContact->setTitle(trim($aFormData['title']));
			$newContact->setEmail(trim($aFormData['email']));
			$newContact->setPhone(trim($aFormData['phone']));
			$newContact->setContacttype($aFormData['contacttype']);
			$newContact->setPid($this->settings['contactspid']);
			$this->contactRepository->add($newContact);
			
			//Set the flash message:
			$this->addFlashMessage(
				'The new contact was successfully stored', //Message
				'Contact saved', //Title
				$severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
				FALSE //storeInSession?
			);			
			
			//Add the contact to the FE user:
			$frontendUser->addContact($newContact);
			$this->frontendUserRepository->update($frontendUser);
			
			//Permantently save all database (model) changes:
			$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
			$persistenceManager->persistAll();
		
		}
		
    }
	
	/* Function that adds the FE CSS and JS required by this extension to the FD */
	public function addCssAndJsToFE(){
		//Add Extension's JS file(s)
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . 'typo3conf/ext/nkcadportal/Resources/Public/JavaScript/datatables.min.js' . '"></script>');
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . 'typo3conf/ext/nkcadportal/Resources/Public/JavaScript/nkcadportal.js' . '"></script>');

		//Add Extension's CSS file(s):
		$this->response->addAdditionalHeaderData('<link type="text/css" rel="stylesheet" href="typo3conf/ext/nkcadportal/Resources/Public/Css/datatables.min.css" />');
		$this->response->addAdditionalHeaderData('<link type="text/css" rel="stylesheet" href="typo3conf/ext/nkcadportal/Resources/Public/Css/nkcadportal.css" />');
	}
	
	/* Functiuon that salts a provided, "plain" password */
	public function saltPassword($password){
		$saltedPassword = '';
		$objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
		if (is_object($objSalt)) {
			$saltedPassword = $objSalt->getHashedPassword($password);
		}
		if($saltedPassword != ''){
			$password = $saltedPassword;
		}
		return $password;
	}
	
	/* Functiuon that tests a provided, "plain" password against a provided salted password */
	public function testSaltedPasswordAgainstStoredValue($plainpassword, $saltedPassword){
		$result = false;
		if (\TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility::isUsageEnabled('FE')) {
			$objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance($saltedPassword);
			if (is_object($objSalt)) {
					$result = $objSalt->checkPassword($plainpassword, $saltedPassword);
			}
		}
		return $result;
	}

}