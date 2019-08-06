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

/**
 * ContactController
 */
class ContactController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * contactRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\ContactRepository
     * @inject
     */
    protected $contactRepository = NULL;
	
	/**
	* @var \Netkyngs\Nkcadportal\Domain\Repository\CustomFrontendUserRepository
	* @inject
	*/
	protected $customFrontendUserRepository;
	
	/**
	* @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
	* @inject
	*/
	protected $frontendUserGroupRepository;
	
	//Global vars:
	protected $aFormErrors = [];
	
	/**
     * initialize action
     * 
     * @return void
     */
    public function initializeAction() {
		//Init query/storage settings:
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
		$this->frontendUserGroupRepository->setDefaultQuerySettings($querySettings);
		$this->customFrontendUserRepository->setDefaultQuerySettings($querySettings);
		$this->contactRepository->setDefaultQuerySettings($querySettings);
	}
	
	
	/**
     * action dwfregistrationform
     * 
     * @return void
     */
    public function dwfregistrationformAction()
    {		
	
		//Check for submitted form action:
		if(isset($_GET['addusergrouptonewuser']) && (int)$_GET['addusergrouptonewuser'] == "1"){
			//Add the usergroup to the new user:
			$newUserUid = (int)$_GET['useruid'];
			$newUserGroupUid = (int)$_GET['usergroupuid'];
			$this->customFrontendUserRepository->findByUid($newUserUid)->addUsergroup($this->frontendUserGroupRepository->findByUid($newUserGroupUid));
			$this->customFrontendUserRepository->update($this->customFrontendUserRepository->findByUid($newUserUid));
			
			//Permantently save all database (model) changes:
			$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
			$persistenceManager->persistAll();
			
			//Forward to registration page:
			$registrationPagePid = $this->settings['registrationcomfirmationpid'];
			header("Location: /index.php?id=$registrationPagePid");die();
		}
		
		elseif ($action = filter_input(INPUT_POST, "formAction", FILTER_SANITIZE_SPECIAL_CHARS)) {
					
			if($action == "new_DFW_Registration"){
				if($newUserUid = $this->createNewUser("DFW")){
					//Send required emails:
					$this->sendEmailsAfterAccountCreation("DFW");
					
					//Reload page and store usergroup (required to reload page!):
					$newUserGroupUid = $this->frontendUserGroupRepository->findByTitle("DFW")->getFirst()->getUid();
					$formpid = $this->settings['formpid'];
					header("Location: /index.php?id=$formpid&addusergrouptonewuser=1&useruid=$newUserUid&usergroupuid=$newUserGroupUid");
				}
				else{
					//There was an input error ($this->aFormErrors) - Load page (form) as normal, include error array and filled out values:
					$this->view->assign('formErrors', $this->aFormErrors);
					$this->view->assign('formValues', $_POST);
				}
			}
		}
		
        //Add CSS and JS:
		$this->addCssAndJsToFE();
		
		//Add ReCaptcha JS To page:
		$this->addReCaptchaToFE();
    }
	
	/**
     * action dotregistrationform
     * 
     * @return void
     */
    public function dotregistrationformAction()
    {
		//Check for submitted form action:
		if(isset($_GET['addusergrouptonewuser']) && (int)$_GET['addusergrouptonewuser'] == "1"){
			//Add the usergroup to the new user:
			$newUserUid = (int)$_GET['useruid'];
			$newUserGroupUid = (int)$_GET['usergroupuid'];
			$this->customFrontendUserRepository->findByUid($newUserUid)->addUsergroup($this->frontendUserGroupRepository->findByUid($newUserGroupUid));
			$this->customFrontendUserRepository->update($this->customFrontendUserRepository->findByUid($newUserUid));
			
			//Permantently save all database (model) changes:
			$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
			$persistenceManager->persistAll();
			
			//Forward to registration page:
			$registrationPagePid = $this->settings['registrationcomfirmationpid'];
			header("Location: /index.php?id=$registrationPagePid");die();
		}
		
		elseif ($action = filter_input(INPUT_POST, "formAction", FILTER_SANITIZE_SPECIAL_CHARS)) {
			
			if($action == "new_DOT_Registration"){
				if($newUserUid = $this->createNewUser("DOT")){
					//Send required emails:
					$this->sendEmailsAfterAccountCreation("DOT");
					
					//Reload page and store usergroup (required to reload page!):
					$newUserGroupUid = $this->frontendUserGroupRepository->findByTitle("DOT")->getFirst()->getUid();
					$formpid = $this->settings['formpid'];
					header("Location: /index.php?id=$formpid&addusergrouptonewuser=1&useruid=$newUserUid&usergroupuid=$newUserGroupUid");
				}
				else{
					//There was an input error ($this->aFormErrors) - Load page (form) as normal, include error array and filled out values:
					$this->view->assign('formErrors', $this->aFormErrors);
					$this->view->assign('formValues', $_POST);
				}
			}			
		}
		
        //Add CSS and JS:
		$this->addCssAndJsToFE();
		
		//Add ReCaptcha JS To page:
		$this->addReCaptchaToFE();
    }
	
	public function sendEmailsAfterAccountCreation($type){
		
		//Create email body:
		$aInputDataLimited = [];
		$aInputData = $_POST;
		foreach($aInputData as $key => $value){
			if($key == "title"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "firstname"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "lastname"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "email"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "company"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "address1"){
				$aInputDataLimited['address'] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "additionaladdress"){
				$aInputDataLimited['address2'] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "city"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "state"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "zip"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			elseif($key == "telephone"){
				$aInputDataLimited[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		}
		
		$body = "<table><tbody>";
		foreach($aInputDataLimited as $key => $value){
			$body .= "<tr>";
			$body .= "<td>".ucfirst($key).":</td>";
			$body .= "<td>$value</td>";
			$body .= "</tr>";
		}		
		$body .= "</tbody></table>";
		
		//Set some variables: 
		$adminName = $this->settings['form_Fromname'];
		$adminFromEmail = $this->settings['form_Fromemail'];
		$adminToEmail = $this->settings['form_adminToemail'];
		$requestedUsername = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
		$hostname = "https://".$_SERVER['HTTP_HOST'];
		$memberName = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS)." ".filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
		$memberEmail = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
		$emailSignature = "<br/><br/>Kind regards,<br/>$adminName";
		
		//**********************************************
		//Send the email (to Admin):
		$subject = "$memberName created a new \"$type\" membership";
		$bodyPre = "<h3>$memberName created a new \"$type\" account with username \"$requestedUsername\".</h3><br/>The following details were submitted:</p><br/>";
		$bodyPost = "<p>Note: the member's password has been stored in the 'Staff Comments' field in the member's backend user record.</p>";
		$recipientArray = [];
		$recipientArray[0] = []; $recipientArray[0]['toEmail'] = $adminToEmail;
		
		foreach($recipientArray as $recipient){
			$mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
			$mail->setFrom(array($adminFromEmail => $adminName));
			$mail->setReplyTo (array($adminToEmail => $adminName));
			$mail->setTo(array($recipient['toEmail'] => $adminName));
			$mail->setSubject($subject);
			$mail->setBody($bodyPre.$body.$bodyPost.$emailSignature, 'text/html');
			$mail->send();
		}
		//**********************************************
		
		//**********************************************
		//Send the email (to New USER):
		$subject = "Your \"$type\" account was created";
		$bodyPre = "<h2>Your new \"$type\" account is ready.</h2><h3>Welcome to the Council on Alcohol and Drugs $type program.</h3><p>Your username is: $requestedUsername<br/>Your password is the one you entered during the sign-up process.</p><p>To login, please visit this link: <a href=\"$hostname/member-login\">Member login</a></p>";
		$toName = $memberName;
		$toEmail = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);

		$mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$mail->setFrom(array($adminFromEmail => $adminName));
		$mail->setReplyTo (array($adminToEmail => $adminName));
		$mail->setTo(array($memberEmail => $$memberName));
		$mail->setSubject($subject);
		$mail->setBody($bodyPre.$emailSignature, 'text/html');
		$mail->send();
		//**********************************************
	}
	
	public function createNewUser($type){
		
		//Check for input errors / duplicate database entries:
		/* Fein */
		$inputFein = filter_input(INPUT_POST, "fein", FILTER_SANITIZE_SPECIAL_CHARS);
		if($this->customFrontendUserRepository->findForTesting("fein", $inputFein)->count() > 0) {
			$aTempError = [];
			$aTempError['field'] = "fein";
			$aTempError['error'] = "This FEIN number already exists in our database.";
			$this->aFormErrors['fein'] = $aTempError;
		}
		/* Email */
		$inputEmail = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
		if($this->customFrontendUserRepository->findForTesting("email", $inputEmail)->count() > 0) {
			$aTempError = [];
			$aTempError['field'] = "email";
			$aTempError['error'] = "This email address already exists in our database.";
			$this->aFormErrors['email'] = $aTempError;
		}
		/* Username */
		$inputUsername = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
		if($this->customFrontendUserRepository->findForTesting("username", $inputUsername)->count() > 0) {
			$aTempError = [];
			$aTempError['field'] = "username";
			$aTempError['error'] = "This username already exists in our database.";
			$this->aFormErrors['username'] = $aTempError;
		}
		//Return false if already existing entry found:
		if(!empty($this->aFormErrors)){
			return false;
		}

		//All good! - Pre-define some variables
		$completeName = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS)." ".filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS);
		$requestedUsername = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
		$password = $this->saltPassword(filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS));
		
		//Create new frontend user obect:
		$newFrontendUser = new \Netkyngs\Nkcadportal\Domain\Model\CustomFrontendUser();
		$newFrontendUser->setPid(18);
		$newFrontendUser->setUsername($requestedUsername);
		$newFrontendUser->setPassword($password);
		$newFrontendUser->setFirstname(filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setLastname(filter_input(INPUT_POST, "lastname", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setName($completeName);
		$newFrontendUser->setCompany(filter_input(INPUT_POST, "company", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setTitle(filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setZip(filter_input(INPUT_POST, "zip", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setTelephone(filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setFax(filter_input(INPUT_POST, "fax", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setEmail(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setAddress(filter_input(INPUT_POST, "address1", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setAdditionaladdress(filter_input(INPUT_POST, "additionaladdress", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setCity(filter_input(INPUT_POST, "city", FILTER_SANITIZE_SPECIAL_CHARS));	
		
		//Add the custom field values to the new user:
		$newFrontendUser->setNumberofemployees(filter_input(INPUT_POST, "number_of_employees", FILTER_SANITIZE_NUMBER_INT));
		$newFrontendUser->setNumberofcdldrivers(filter_input(INPUT_POST, "number_of_CDL_drivers", FILTER_SANITIZE_NUMBER_INT));
		$newFrontendUser->setState(filter_input(INPUT_POST, "state", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setCellphone(filter_input(INPUT_POST, "cell-phone", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setFein(filter_input(INPUT_POST, "fein", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setBusinesstype(filter_input(INPUT_POST, "business_type", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setInsurancecarrier(filter_input(INPUT_POST, "Workers_Comp_Insurance_Carrier", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setInsuranceagent(filter_input(INPUT_POST, "Insurance_Agent", FILTER_SANITIZE_SPECIAL_CHARS));
		$newFrontendUser->setHearaboutus(ucwords(filter_input(INPUT_POST, "hearfrom", FILTER_SANITIZE_SPECIAL_CHARS)));
		$newFrontendUser->setStaffcomments("User password: ".filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS));
		
		//Store the new frontend user:
		$this->customFrontendUserRepository->add($newFrontendUser);
		
		//Permantently save all database (model) changes:
		$persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
		$persistenceManager->persistAll();
		
		//Return the new user's uid:
		if((int)$newFrontendUser->getUid() == 0){
			die("User could not be saved -- Permanent error. Please consult IT support.");
		}
		else{
			return $newFrontendUser->getUid();
		}
	}
	
	/**
     * action donationform
     * 
     * @return void
     */
    public function donationformAction()
    {
		
        //Add CSS and JS:
		$this->addCssAndJsToFE();
		
		//Add ReCaptcha JS To page:
		$this->addReCaptchaToFE();
    }
	
	/* Function that add the required ReCaptcha v2 script to the page */
	public function addReCaptchaToFE(){
		//Add Extension's JS file(s)
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . 'https://www.google.com/recaptcha/api.js' . '"></script>');
	}
	
	/* Function that adds the FE CSS and JS required by this extension to the FD */
	public function addCssAndJsToFE(){
		//Add Extension's JS file(s)
		$this->response->addAdditionalHeaderData('<script type="text/javascript" src="' . 'typo3conf/ext/nkcadportal/Resources/Public/JavaScript/forms.js' . '"></script>');

		//Add Extension's CSS file(s):
		$this->response->addAdditionalHeaderData('<link type="text/css" rel="stylesheet" href="typo3conf/ext/nkcadportal/Resources/Public/Css/forms.css" />');
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


}