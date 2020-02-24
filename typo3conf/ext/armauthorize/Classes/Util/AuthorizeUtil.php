<?php
namespace ARM\Armauthorize\Util;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require __DIR__.'/../Library/Autoload.php'; 
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AuthorizeUtil {
    
    /**
     *
     * @var string
     */
    private $apiLogin;
    
    /**
     *
     * @var string 
     */
    private $apiKey;
    
    /**
     *
     * @var string 
     */
    protected $refId;
    
    /**
     *
     * @var string
     */
    protected $clientId;

    /**
     *
     * @var object
     */
    protected $merchAuthentication;
    
    /**
     *
     * @var AnetAPI\PaymentType 
     */
    protected $payment;
    
    /**
     *
     * @var AnetAPI\CustomerAddressType 
     */
    protected $billingAddress;

    /**
     *
     * @var array 
     */
    protected $lineItems = array();

    /**
     *
     * @var AnetAPI\CreateTransactionRequest 
     */
    protected $request;
    
    /**
     *
     * @var AnetAPI\AnetApiResponseType 
     */
    protected $response;


    /**
     *
     * @var bool
     */
    public $testMode = TRUE;


    /**
     * @param string $login
     * @param string $key
     */
    public function __construct($login, $key) {
        
        $this->apiLogin = $login;
        $this->apiKey = $key;
    }
    
    public function initializeMerchant() {
        $this->merchAuthentication = new AnetAPI\MerchantAuthenticationType();
        $this->merchAuthentication->setName($this->apiLogin);
        $this->merchAuthentication->setTransactionKey($this->apiKey);
        $this->refId = 'ref'.time();
    }
    
    /**
     * Make LIVE transaction
     */
    public function makeLive() {
        $this->testMode = FALSE;
    }
    
    /**
     * 
     * @param int $ccno
     * @param string $expiry yyyy-mm
     * @param string $cvv
     * @return AnetAPI\PaymentType
     */
    public function addCreditCard($ccno,$expiry,$cvv) {
        
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($ccno);  
        $creditCard->setExpirationDate( $expiry );
        $creditCard->setCardCode($cvv);
        
        $this->payment = new AnetAPI\PaymentType();
        $this->payment->setCreditCard($creditCard);
        
        return $this;
    }
    
    /**
     * 
     * @param string $id
     * @param string $title
     * @param float $price
     * @param string $description
     */
    public function createLineItem($id, $title, $price, $description='') {
        
        $lineItem = new AnetAPI\LineItemType();
        $lineItem->setItemId($id);
        $lineItem->setName($title);
        $lineItem->setUnitPrice($price);
        $lineItem->setQuantity(1);
        $lineItem->setDescription($description);
        
        $this->lineItems[] = $lineItem;
    }
    
    /**
     * 
     * @param float $amount
     * @param string $type
     * @param string $profile
     * @param string $payprofile
     * @return AnetAPI\AnetApiResponseType 
     */
    public function makeTransaction($amount, $type='authCaptureTransaction', $profile='', $payprofile='') {
        
        if ($profile != '' && $payprofile != '') {
            $trnType = $this->createProfileTransactionType($profile, $payprofile, $type, $amount);
        } else {
            $trnType = $this->createTransactionType($type, $amount);
        }
        $this->createTransRequest($trnType);
        
        $controller = new AnetController\CreateTransactionController($this->request);
        
        if ($this->testMode) {
            $this->response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        } else {
            $this->response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }
        
        return $this->response;
    }
    
    /**
     * 
     * @return array
     */
    public function processResponse() {
        
        $status = FALSE;
        
        if ($this->response != null) {
            
            if ($this->response->getMessages()->getResultCode() == 'Ok') {
                $trnResponse = $this->response->getTransactionResponse();

                if ($trnResponse != null && $trnResponse->getMessages() != null && $trnResponse->getResponseCode() == "1") {
                    
                    $status = TRUE;
                    $trnId = $trnResponse->getTransId();
                    $message = $trnResponse->getMessages()[0]->getDescription();

                } else {
                    
                    if ($trnResponse->getErrors() != null) {
                        $error = '['.$trnResponse->getErrors()[0]->getErrorCode().'] ' . $trnResponse->getErrors()[0]->getErrorText();
                    }
                }
                
            } else {
                
                $trnResponse = $this->response->getTransactionResponse();

                if ($trnResponse != null && $trnResponse->getMessages() != null) {
                    $error = '['.$trnResponse->getErrors()[0]->getErrorCode().'] ' . $trnResponse->getErrors()[0]->getErrorText();
                } else {
                    $error = '['.$this->response->getMessages()->getMessage()[0]->getCode().'] ' .  $this->response->getMessages()->getMessage()[0]->getText();
                }

            }
        } else {
            $error = 'No response';

        }
            
        return ['trnId' => $trnId, 'status' => $status, 'message'=> $message, 'error' => $error];
    }
    
    /**
     * 
     * @param string $type
     * @param float $amount
     * @return AnetAPI\TransactionRequestType
     */
    public function createTransactionType($type, $amount) {
        
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType($type);   
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($this->payment);
        
        if (count($this->lineItems) > 0) {
            $transactionRequestType->setLineItems($this->lineItems);
        }
        
        return $transactionRequestType;
    }
    
    /**
     * 
     * @param string $profile
     * @param $paymentprofile
     * @param string $type
     * @param float $amount
     * @return AnetAPI\TransactionRequestType
     */
    public function createProfileTransactionType($profile, $paymentprofile, $type, $amount) {
        
        $paymentProfile = new AnetAPI\PaymentProfileType();
        $paymentProfile->setPaymentProfileId($paymentprofile);
        
        $profileToCharge = new AnetAPI\CustomerProfilePaymentType();
        $profileToCharge->setCustomerProfileId($profile);
        $profileToCharge->setPaymentProfile($paymentProfile);
        
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType($type);   
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setProfile($profileToCharge);
        
        return $transactionRequestType;
    }
    
    /**
     * 
     * @param AnetAPI\TransactionRequestType $transaction
     */
    public function createTransRequest(AnetAPI\TransactionRequestType $transaction)
    {
        $this->request = new AnetAPI\CreateTransactionRequest();
        $this->request->setMerchantAuthentication($this->merchAuthentication);
        $this->request->setRefId($this->refId);
        $this->request->setTransactionRequest($transaction);
    }
    
    /**
     * 
     * @param string $trnxId
     * @param string $email
     * @param string $company
     * @param int $feuserId
     * @return AnetAPI\CreateCustomerProfileResponse
     */
    public function createCustomerProfileFromTransaction($trnxId, $email, $company='', $feuserId=0) {
        
        
        $customerProfile = new AnetAPI\CustomerProfileBaseType();
        if ($feuserId > 0) {
            $customerProfile->setMerchantCustomerId($feuserId);
        }
        $customerProfile->setEmail($email);
        
        $customerProfile->setDescription("Customer $company [$email]");

        $request = new AnetAPI\CreateCustomerProfileFromTransactionRequest();
        $request->setMerchantAuthentication($this->merchAuthentication);
        $request->setTransId($trnxId);
        $request->setCustomer($customerProfile);

        $controller = new AnetController\CreateCustomerProfileFromTransactionController($request);

        if ($this->testMode) {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        } else {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }
        
        return $response;
    }
    
    /**
     * 
     * @param AnetAPI\CreateCustomerProfileResponse $response Description
     * @return array
     */
    public function processProfileCreateResponse(AnetAPI\CreateCustomerProfileResponse $response) {

        $status = FALSE;
        $customerProfileId = NULL;
        $paymentProfileId = NULL;
        $error = '';
        
        if ($response != null) {
            
//            $cusProfRes = $this->response->getProfileResponse();
            
            if ($response->getMessages()->getResultCode() == 'Ok') {
                $status = TRUE;
                $customerProfileId  = $response->getCustomerProfileId();
                $paymentProfileId   = $response->getCustomerPaymentProfileIdList()[0];
            } else {
                $error = 'No response';
            }
            
        } else {
            $error = 'No response';
        }
        
        return ['status'=> $status, 'customerProfileId' => $customerProfileId, 'paymentProfileId' => $paymentProfileId, 'error' => $error];
    }
    
    /**
     * 
     * @param int $feuserId
     * @param string $email
     * @param string $fname
     * @param string $lname
     * @param string $phone
     * @param string $company
     * @param string $address
     * @param string $city
     * @param string $state
     * @param string $zip
     * @param string $country
     * @return AnetAPI\AnetApiResponseType
     */
    public function createCustomerProfile($feuserId='', $email, $fname, $lname='', $phone, $company='',$address='',$city='',$state='',$zip='',$country='USA') {
        
        $billTo = new AnetAPI\CustomerAddressType();
        $billTo->setFirstName($fname);
        $billTo->setLastName($lname);
        $billTo->setCompany($company);
        $billTo->setAddress($address);
        $billTo->setCity($city);
        $billTo->setState($state);
        $billTo->setZip($zip);
        $billTo->setCountry($country);
        $billTo->setPhoneNumber($phone);
    
        
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment($this->payment);
        $paymentProfile->setDefaultpaymentProfile(true);
        $paymentProfiles[] = $paymentProfile;
        
        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("Customer $company [$email]");
        
        if ($feuserId != '') {
            $customerProfile->setMerchantCustomerId($feuserId);
        }
        $customerProfile->setEmail($email);
        $customerProfile->setpaymentProfiles($paymentProfiles);
        
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($this->merchAuthentication);
        $request->setRefId($this->refId);
        $request->setProfile($customerProfile);
        
        $controller = new AnetController\CreateCustomerProfileController($request);
        if ($this->testMode) {
            $this->response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        } else {
            $this->response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }
        
        return $this->response;
    }
}