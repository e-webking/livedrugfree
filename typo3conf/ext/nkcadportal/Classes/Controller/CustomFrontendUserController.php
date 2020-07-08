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

use \TYPO3\CMS\Backend\Utility\BackendUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

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
     *
     * @var int 
     */
    protected $limit = 50;

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
        $contact = 'tx_nkcadportal_domain_model_contact';
        $foreign = 'fe_users';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $queryBuilder->getRestrictions()->removeAll();
        $expr = $queryBuilder->expr();
        
        $andCond = $queryBuilder->expr()->andx();
        $andCond->add($expr->eq('foreign.deleted', 0));
        
        //Get members:
        $rows = $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contactbl.firstname','contactbl.lastname','contactbl.phone as cphone','contactbl.email as cemail','contactbl.deleted as cdel','contactbl.hidden as chid')
                                    ->from($foreign, 'foreign')
                                    ->leftJoin('foreign', $contact, 'contactbl', $queryBuilder->expr()->eq('contactbl.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond)
                                    ->orderBy('foreign.company', 'ASC')
                                    ->setFirstResult(0)
                                    ->setMaxResults($this->limit )
                                    ->execute()
                                    ->fetchAll();

        $rows = array_map("unserialize", array_unique(array_map("serialize", $rows)));
        $filteredRow = [];
        
        foreach($rows as $rec) {
            
            if ($rec['cdel']==1 || $rec['chid']==1) {
                $rec['firstname'] = '';
                $rec['lastname'] = '';
                $rec['cphone'] = '';
                $rec['cemail'] = '';
            }
            
            $filteredRow[] = $rec;
        }
        
        $filteredRow = array_map("unserialize", array_unique(array_map("serialize", $filteredRow)));
        $count = count($filteredRow);
        $this->view->assign('members', $filteredRow);
        $this->view->assign('mempaging', $this->pagingStr($count));
    }
    
    /**
     * 
     * @param int $count
     * @param int $act
     */
    protected function pagingStr($count, $act = 1) {
        $i = 1;
        $ret = '';
        if (intval($count) > $this->limit) {
            $pageNo = ceil($count/$this->limit);
             while ($i <= $pageNo) {
                $ret .= '<a class="nkpg'. ($i==$act?" act":"") .'" href="javascript:void(0);" onclick="_getPage('. ($i-1) .');" data-num="'. ($i-1) .'">'.$i++.'</a>';
            }
        }
       
        return $ret;
    }

    public function listmshiptplAction () {
        //Get membershiptemplates:
        $membershiptemplates = $this->membershipTemplateRepository->findAll();
        $this->view->assign('membershiptemplates', $membershiptemplates);	
    }
    
    public function initializeListnewsletterAction () {

        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_newsletter']['ctrl']['enablecolumns']['starttime']);
        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_newsletter']['ctrl']['enablecolumns']['endtime']);
        
    }

    public function listnewsletterAction() {

        
        //Get the newsletters:
        $newsletters = $this->newsletterRepository->findAll();

        foreach($newsletters as $newsletter){
            try {
                $fileObj = $newsletter->getFile();
                if (!is_null($fileObj)) {
                    $publicUrl = $newsletter->getFile()->getOriginalResource()->getPublicUrl();
                    $aPublicUrlTmp = explode("/", $publicUrl);
                    $newsletter->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
                }
            } catch(\Exception $e) {}
        }
        
        $this->view->assign('newsletters', $newsletters);
    }
    
    public function initializeListdocsletterAction () {

        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_document']['ctrl']['enablecolumns']['starttime']);
        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_document']['ctrl']['enablecolumns']['endtime']);
        
    }
    
    public function listdocsAction() 
    {
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
        $this->view->assign('documents', $documents);
    }
    
    public function listremAction() 
    {
        //Get the reminders:
        $reminders = $this->reminderRepository->findAll();
        foreach($reminders as $reminder){
                $reminder->sendoptionsstring = $reminder->getDaysspan()." days ".$reminder->getWhentosend()." ".$reminder->getFieldcondition()." ".$reminder->getSendtogroup();
        }
        $this->view->assign('reminders', $reminders);
    }
    
    public function listrptAction()
    {
        //Get reports:
        $reports = $this->reportRepository->findAll();
        $this->view->assign('reports', $reports);
    }

    public function listcodesAction()
    {
        $codes = $this->discountcodeRepository->findAll();
        $this->view->assign('codes', $codes);
    }

    /**
     * AJAX action get members
     * @param array $params
     * @param  \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj
     */
    public function getMembersAction(\Psr\Http\Message\ServerRequestInterface $request,
    \Psr\Http\Message\ResponseInterface $response) {
        
        $params = $request->getParsedBody();
        
        $pageNo = GeneralUtility::_GP('pageNo');
        $pageStart = ($pageNo > 0)?($pageNo * $this->limit + 1):0;
        
        $qsearch = urldecode(GeneralUtility::_GP('qsearch'));
        $option = GeneralUtility::_GP('option');
        $foreign = 'fe_users';
        $local = 'tx_nkcadportal_domain_model_membership';
        $contact = 'tx_nkcadportal_domain_model_contact';
            
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        $queryBuilder->getRestrictions()->removeAll();
        
        $andCond = $queryBuilder->expr()->andx();
        $orCond = $queryBuilder->expr()->orx();

        
        $andCond->add($expr->eq('foreign.deleted', 0));
        
        if (trim($qsearch)!= '') {
            
            if (strpos($qsearch, '@') > 0) {
                
                $orCond->add($expr->like('foreign.company', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($qsearch).'%')));

                $orCond->add($expr->like('foreign.username', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($qsearch).'%')));
              
                $orCond->add($expr->like('foreign.email', $queryBuilder->createNamedParameter('%' .$queryBuilder->escapeLikeWildcards($qsearch).'%')));
    
                $orCond->add($expr->like('contact.email', $queryBuilder->createNamedParameter('%' .$queryBuilder->escapeLikeWildcards($qsearch).'%')));
             
            } else {
                
                $orCond->add($expr->like('foreign.first_name', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($qsearch) . '%')));
          
                $orCond->add($expr->like('foreign.last_name', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($qsearch) . '%')));

//                $orCond->add($expr->like('foreign.name', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($qsearch) . '%')));

                $orCond->add($expr->like('foreign.company', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($qsearch).'%')));

                $orCond->add($expr->like('foreign.fein',  $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($qsearch). '%')));

                $orCond->add($expr->like('foreign.address', $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards($qsearch).'%')));

                $orCond->add($expr->like('foreign.telephone', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($qsearch).'%')));
          
                $orCond->add($expr->like('foreign.email', $queryBuilder->createNamedParameter('%' .$queryBuilder->escapeLikeWildcards($qsearch).'%')));
           
                $orCond->add($expr->like('contact.firstname', $queryBuilder->createNamedParameter( $queryBuilder->escapeLikeWildcards($qsearch) . '%')));
  
                $orCond->add($expr->like('contact.lastname', $queryBuilder->createNamedParameter( $queryBuilder->escapeLikeWildcards($qsearch) . '%')));

                $orCond->add($expr->like('contact.phone', $queryBuilder->createNamedParameter($queryBuilder->escapeLikeWildcards($qsearch).'%')));
                
                $orCond->add($expr->like('contact.email', $queryBuilder->createNamedParameter('%' .$queryBuilder->escapeLikeWildcards($qsearch).'%')));
            }
            
            $andCond->add($orCond);
        }
        
            
        switch ($option) {
            
            case 'current':
                
                $andCond->add($expr->eq('foreign.disable', 0));
                $andCond->add($expr->eq('local.deleted', 0));
                $andCond->add($expr->eq('local.hidden', 0));
                $andCond->add($expr->gt('local.endtimecustom', time()));
                
                $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign,'foreign')
                                    ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid', 'local.customfrontenduser'))
                                    ->leftJoin('foreign',$contact,'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond);
        
                break;
            case 'expiringthismonth':
                
               $month = date("M", time());
               $ldTs = strtotime('last day of ' . $month);
               
               $andCond->add($expr->eq('foreign.disable', 0));
               $andCond->add($expr->eq('local.deleted', 0));
               $andCond->add($expr->eq('local.hidden', 0));
               $andCond->add($expr->gt('local.endtimecustom', time()));
               $andCond->add($expr->lt('local.endtimecustom', $ldTs));
              
                
               $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign,'foreign')
                                    ->innerJoin('foreign', $local, 'local', $expr->eq('local.customfrontenduser','foreign.uid'))
                                    ->leftJoin('foreign',$contact,'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond);
                                    
                break;
            case 'expiringnextmonth':
               $month = date("M", strtotime("+1 month"));
               $ldNextMnTs = strtotime('last day of ' . $month);
               
               $andCond->add($expr->eq('foreign.disable', 0));
               $andCond->add($expr->eq('local.deleted', 0));
               $andCond->add($expr->eq('local.hidden', 0));
               $andCond->add($expr->gt('local.endtimecustom', time()));
               $andCond->add($expr->lt('local.endtimecustom', $ldNextMnTs));
                
               $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign, 'foreign')
                                    ->innerJoin('foreign', $local, 'local', $expr->eq('local.customfrontenduser','foreign.uid'))
                                    ->leftJoin('foreign',$contact,'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond);
                                    
                break;
            case 'expiredwithinxdays':
               $sixtyDayTs = strtotime("+2 months");
                
               $andCond->add($expr->eq('foreign.disable', 0));
               $andCond->add($expr->eq('local.deleted', 0));
               $andCond->add($expr->eq('local.hidden', 0));
               $andCond->add($expr->gt('local.endtimecustom', time()));
               $andCond->add($expr->lt('local.endtimecustom', $sixtyDayTs));
               
               $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign,'foreign')
                                    ->innerJoin('foreign', $local ,'local', $expr->eq('local.customfrontenduser','foreign.uid'))
                                    ->leftJoin('foreign',$contact,'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                   ->andWhere($andCond);
                                    
                break;
            case 'expired':
                
               $andCond->add($expr->eq('foreign.disable', 0));
               $andCond->add($expr->eq('local.deleted', 0));
               $andCond->add($expr->eq('local.hidden', 0));
               $andCond->add($expr->lt('local.endtimecustom', time()));  
               
               $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign,'foreign')
                                    ->innerJoin('foreign', $local, 'local', $expr->eq('local.customfrontenduser','foreign.uid'))
                                    ->leftJoin('foreign',$contact,'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond);
                                              
                break;
             case 'suspendedandnew':
                 
               $andCond->add($expr->isNull('local.customfrontenduser'));
               $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign,'foreign')
                                    ->leftJoin('foreign',$local,'local', $expr->eq('local.customfrontenduser','foreign.uid'))
                                    ->leftJoin('foreign',$contact,'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond);                              
                break;
            default:
//                $andCond->add($expr->eq('foreign.disable', 0));
                $queryBuilder->select('foreign.uid','foreign.company','foreign.fein','foreign.address','foreign.first_name','foreign.last_name','foreign.telephone','foreign.email','contact.firstname','contact.lastname','contact.phone as cphone','contact.email as cemail','contact.deleted as cdel','contact.hidden as chid')
                                    ->from($foreign, 'foreign')
                                    ->leftJoin('foreign', $contact, 'contact', $expr->eq('contact.customfrontenduser','foreign.uid'))
                                    ->andWhere($andCond);
        }
        
        //echo $queryBuilder->setFirstResult($pageStart)->setMaxResults($this->limit)->getSQL();
        //exit;
        

        
        $rows = $queryBuilder->orderBy('foreign.company', 'ASC')
                        ->setFirstResult($pageStart)
                            ->setMaxResults($this->limit)
                            ->execute()
                            ->fetchAll();
        $rows = array_map("unserialize", array_unique(array_map("serialize", $rows)));
        
        $filteredRow = [];
        
        foreach($rows as $rec) {
            
            if ($rec['cdel']==1 || $rec['chid']==1) {
                $rec['firstname'] = '';
                $rec['lastname'] = '';
                $rec['cphone'] = '';
                $rec['cemail'] = '';
            }
            $filteredRow[] = $rec;
        }
        
        $filteredRow = array_map("unserialize", array_unique(array_map("serialize", $filteredRow)));
        $count = count($filteredRow);
        
        
        $memHtml = '';
        
        if ($count > 0) {
            
            foreach ($filteredRow as $data) {
                
                $memHtml .= '<tr>'
                        .'<td><i class="fa fa-user"></i></td>'
                        .'<td style="white-space: nowrap">'.$this->getMemberEditUrl($data['uid']).' '.$this->getMemberOptionUrl($data['uid']).'</td>'
                        .'<td>'.$data['company'].'</td>'
                        .'<td>'.$data['fein'].'</td>'
                        .'<td>'.$data['address'].'</td>'
                        .'<td>'.$data['first_name'].' '.$data['last_name'].'</td>'
                        .'<td>'.$data['telephone'].'</td>'
                        .'<td><a href="mailto:'.$data['email'].'">'.$data['email'].'</a></td>'
                        .'<td>'.$data['firstname'].' '.$data['lastname'].'</td>'
                        .'<td>'.$data['cphone'].'</td>'
                        .'<td><a href="mailto:'.$data['cemail'].'">'.$data['cemail'].'</a></td>'
                        . '</tr>';
            }

        }
        
        $arr['members'] = $memHtml;
        $arr['paging'] = $this->pagingStr($count, $pageNo+1);
        
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        //echo $json;
        
        return $response;
    }
    
    /**
     * 
     * @param int $feuser
     * @return mixed
     */
    protected function getContactData($feuser)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_contact');
        $queryBuilder->getRestrictions()->removeAll();
        $expr = $queryBuilder->expr();
        $rows =  $queryBuilder->select('firstname','lastname','email', 'phone')
                    ->from('tx_nkcadportal_domain_model_contact')
                    ->where(
                        $expr->eq('deleted', 0),
                        $expr->eq('hidden', 0),
                        $expr->eq('customfrontenduser', $feuser)
                    )->execute()->fetchAll();

        if (count($rows) > 0) {
           return $rows;
        }
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getMemberEditUrl($uid)
    {
        $editUserAccountUrl = BackendUtility::getModuleUrl('record_edit', array('edit[fe_users][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUserAccountUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getMemberOptionUrl($uid) {
        
        return '<i class="fa fa-eye-slash" onclick="performAjaxAction(\'36\', \'hide-member\', \''. $uid .'\', true);"></i> <i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-member\', \''. $uid .'\', true);"></i>';
    }
    
    /**
     * AJAX action get members
     * @param array $params
     * @param  \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj
     */
    public function getMembershipAction(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
         $params = $request->getParsedBody();
         
        $memArr = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_membershiptemplate');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('uid','description','membershiptype','price','term')
            ->from('tx_nkcadportal_domain_model_membershiptemplate')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->orderBy('sorting', 'ASC')
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $data) {
                $memArr[] = [
                        'uid' => $data['uid'],
                        'edit' => $this->getMembershipEditUrl($data['uid']),
                        'option' => $this->getMembershipOptionUrl($data['uid']),
                        'description' => $data['description'],
                        'membershiptype' => $data['membershiptype'],
                        'price' => $data['price'],
                        'term' => $data['term'],
                        'includednewsletters' => $this->getIncludedNewsletters($data['uid'])
                    ];
            }
        }
        $arr['data'] = $memArr;
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getMembershipEditUrl($uid)
    {
        $editUrl = BackendUtility::getModuleUrl('record_edit', array('edit[tx_nkcadportal_domain_model_membershiptemplate][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getMembershipOptionUrl($uid) {
        
        return '<i class="fa fa-eye-slash" onclick="performAjaxAction(\'36\', \'hide-membership\', \''. $uid .'\', true);"></i> <i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-membership\', \''. $uid .'\', true);"></i>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getIncludedNewsletters($uid) {
        
        $return = '';
        
        $foreign = 'tx_nkcadportal_domain_model_newslettertype';
        $mm = 'tx_nkcadportal_membershiptemplate_newslettertype_mm';
        $local = 'tx_nkcadportal_domain_model_membershiptemplate';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('foreign.name')
            ->from($foreign, 'foreign')
            ->innerJoin('foreign', $mm, 'mm', $expr->eq('foreign.uid','mm.uid_foreign'))
            ->innerJoin('mm', $local, 'local', $expr->eq('mm.uid_local', 'local.uid'))
            ->where(
                $expr->eq('local.uid', $uid)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $ndata) {
                 $return .= $ndata['name'].'<span class="comma-seperator">,</span> ';
            }
        }
        
        return $return;
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function getNewsletterAction(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $newsArr = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_newsletter');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('uid','title','file','newslettertype')
            ->from('tx_nkcadportal_domain_model_newsletter')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $data) {
                $newsArr[] = [
                        'uid' => $data['uid'],
                        'edit' => $this->getNlEditUrl($data['uid']),
                        'option' => $this->getNlOptionUrl($data['uid']),
                        'title' => $data['title'],
                        'newslettertype' => $this->getNewsletterType($data['newslettertype']),
                        'download' => $this->getNlDownload($data['uid'])
                    ];
            }
        }

        $arr['data'] = $newsArr;
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
        
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getNewsletterType($uid) {
        
        $return = '';
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_newslettertype');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('name')
            ->from('tx_nkcadportal_domain_model_newslettertype')
            ->where(
                $queryBuilder->expr()->eq('uid', $uid)
            )
            ->execute()
            ->fetchAll();
        return $rows[0]['name'];
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getNlEditUrl($uid)
    {
        $editUrl = BackendUtility::getModuleUrl('record_edit', array('edit[tx_nkcadportal_domain_model_newsletter][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getNlOptionUrl($uid) {
        
        return '<i class="fa fa-eye-slash" onclick="performAjaxAction(\'36\', \'hide-newsletter\', \''. $uid .'\', true);"></i> <i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-newsletter\', \''. $uid .'\', true);"></i>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string 
     */
    protected function getNlDownload($uid) {
        
        $return = '';
        
        $foreign = 'sys_file_reference';
        $local = 'tx_nkcadportal_domain_model_newsletter';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('foreign.uid_local')
            ->from($foreign, 'foreign')
            ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid_foreign','local.uid'))
            ->where(
                $expr->eq('local.uid', $uid),
                $expr->eq('foreign.deleted', 0),
                $expr->eq('foreign.hidden', 0),
                $expr->eq('foreign.tablenames', $queryBuilder->createNamedParameter($local)),
                $expr->eq('foreign.fieldname', $queryBuilder->createNamedParameter('file'))
            )
            ->execute()
            ->fetchAll();
        
        if (count($rows) > 0) {
            
            $fdata = $rows[0];
            $resFac = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
            $fileObj = $resFac->getFileObject($fdata['uid_local']);
            
            if (!is_null($fileObj)) {
                
                $url = $fileObj->getPublicUrl();
                $fname = $fileObj->getName();
                
                $return = '<a href="/index.php?id=36&action=serve-download&filepath='. $url .'&friendlyfilename='. $fname.'">'.$fname.'</a>';
            }
        }
        
        return $return;
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getDocumentAction(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $docArr = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_document');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('uid','title','file')
            ->from('tx_nkcadportal_domain_model_document')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $data) {
                $docArr[] = [
                        'uid' => $data['uid'],
                        'edit' => $this->getDocEditUrl($data['uid']),
                        'option' => $this->getDocOptionUrl($data['uid']),
                        'title' => $data['title'],
                        'download' => $this->getDocDownload($data['uid'])
                    ];
            }
        }
        $arr['data'] = $docArr;
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
        
    }

    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getDocEditUrl($uid)
    {
        $editUrl = BackendUtility::getModuleUrl('record_edit', array('edit[tx_nkcadportal_domain_model_document][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getDocOptionUrl($uid) {
        
        return '<i class="fa fa-eye-slash" onclick="performAjaxAction(\'36\', \'hide-document\', \''. $uid .'\', true);"></i> <i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-document\', \''. $uid .'\', true);"></i>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string 
     */
    protected function getDocDownload($uid) {
        
        $return = '';
        
        $foreign = 'sys_file_reference';
        $local = 'tx_nkcadportal_domain_model_document';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('foreign.uid_local')
            ->from($foreign, 'foreign')
            ->innerJoin('foreign', $local, 'local', $expr->eq('foreign.uid_foreign','local.uid'))
            ->where(
                $expr->eq('local.uid', $uid),
                $expr->eq('foreign.deleted', 0),
                $expr->eq('foreign.hidden', 0),
                $expr->eq('foreign.tablenames', $queryBuilder->createNamedParameter($local)),
                $expr->eq('foreign.fieldname', $queryBuilder->createNamedParameter('file'))
            )
            ->execute()
            ->fetchAll();
        
        if (count($rows) > 0) {
            
            $fdata = $rows[0];
            $resFac = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
            $fileObj = $resFac->getFileObject($fdata['uid_local']);
            
            if (!is_null($fileObj)) {
                
                $url = $fileObj->getPublicUrl();
                $fname = $fileObj->getName();
                
                $return = '<a href="/index.php?id=36&action=serve-download&filepath='. $url .'&friendlyfilename='. $fname.'">'.$fname.'</a>';
            }
        }
        
        return $return;
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getReminderAction(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $remArr = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_reminder');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('uid','daysspan','whentosend','fieldcondition','sendtogroup','subject')
            ->from('tx_nkcadportal_domain_model_reminder')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $data) {
                $remArr[] = [
                        'uid' => $data['uid'],
                        'edit' => '<i class="fa fa-bell"></i>',
                        'option' => $this->getRemEditUrl($data['uid']).' '.$this->getRemOptionUrl($data['uid']),
                        'subject' => $data['subject'],
                        'sendoptionsstring' => $data['daysspan'].' days '.$data['whentosend'].' '.$data['fieldcondition'].' '.$data['sendtogroup'],
                        'states' => $this->getRemStates($data['uid'])
                    ];
            }
        }
        $arr['data'] = $remArr;
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
        
    }
    

    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getRemEditUrl($uid)
    {
        $editUrl = BackendUtility::getModuleUrl('record_edit', array('edit[tx_nkcadportal_domain_model_reminder][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getRemOptionUrl($uid) {
        
        return '<i class="fa fa-eye-slash" onclick="performAjaxAction(\'36\', \'hide-reminder\', \''. $uid .'\', true);"></i> <i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-reminder\', \''. $uid .'\', true);"></i>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getRemStates($uid) {
        
        $return = '';
        
        $foreign = 'tx_nkcadportal_domain_model_state';
        $mm = 'tx_nkcadportal_reminder_state_mm';
        $local = 'tx_nkcadportal_domain_model_reminder';
        
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($foreign);
        $expr = $queryBuilder->expr();
        
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('foreign.state')
            ->from($foreign, 'foreign')
            ->innerJoin('foreign', $mm, 'mm', $expr->eq('foreign.uid','mm.uid_foreign'))
            ->innerJoin('mm', $local, 'local', $expr->eq('mm.uid_local', 'local.uid'))
            ->where(
                $expr->eq('local.uid', $uid)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $ndata) {
                 $return .= $ndata['state'].'<span class="comma-seperator">,</span> ';
            }
        }
        
        return $return;
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getReportAction(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $remArr = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_report');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('uid','title')
            ->from('tx_nkcadportal_domain_model_report')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $data) {
                $remArr[] = [
                        'uid' => $data['uid'],
                        'edit' => '<i class="fa fa-bell"></i>',
                        'option' => $this->getRepEditUrl($data['uid']).' '.$this->getRepOptionUrl($data['uid']),
                        'title' => $data['title'],
                        'csv' => $this->getRepCsv($data['uid'])
                    ];
            }
        }
        $arr['data'] = $remArr;
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getRepEditUrl($uid)
    {
        $editUrl = BackendUtility::getModuleUrl('record_edit', array('edit[tx_nkcadportal_domain_model_report][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getRepOptionUrl($uid) {
        
        return '<i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-report\', \''. $uid .'\', true);"></i>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getRepCsv($uid)
    {
         
        return '<a href="/index.php?id=36&action=serve-csv-report&uid='.$uid.'"><i class="fa fa-file"></i></a>';
    }
    
    /**
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getDiscountAction(\Psr\Http\Message\ServerRequestInterface $request,
        \Psr\Http\Message\ResponseInterface $response) {
        
        $codeArr = [];
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_nkcadportal_domain_model_discountcode');
        $queryBuilder->getRestrictions()->removeAll();
        $rows = $queryBuilder->select('uid','agency','code','description','discount')
            ->from('tx_nkcadportal_domain_model_discountcode')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->execute()
            ->fetchAll();
        if (count($rows) > 0) {
            foreach ($rows as $data) {
                $codeArr[] = [
                        'uid' => $data['uid'],
                        'dollar' => '<i class="fa fa-dollar"></i>',
                        'option' => $this->getCodeEditUrl($data['uid']).' '.$this->getCodeOptionUrl($data['uid']),
                        'agency' => $data['agency'],
                        'description' => $data['description'],
                        'code' => $data['code'],
                        'discount' => '$'.number_format($data['discount'], 2, '.', ',')
                    ];
            }
        }
        $arr['data'] = $codeArr;
        $json = $this->array2Json($arr);
        $response->getBody()->write($json);
        $response->withHeader('Cache-Control', 'no-cache, must-revalidate');
        $response->withHeader('Content-Type', 'application/json;charset=utf-8');
        
        return $response;
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getCodeEditUrl($uid)
    {
        $editUrl = BackendUtility::getModuleUrl('record_edit', array('edit[tx_nkcadportal_domain_model_discountcode][' . $uid . ']' => 'edit', 'returnUrl' => BackendUtility::getModuleUrl('web_NkcadportalNkcadportalbe')));
         
        return '<a href="'.$editUrl.'"><i class="fa fa-pencil"></i></a>';
    }
    
    /**
     * 
     * @param int $uid
     * @return string
     */
    protected function getCodeOptionUrl($uid) {
        
        return '<i class="fa fa-eye-slash" onclick="performAjaxAction(\'36\', \'hide-code\', \''. $uid .'\', true);"></i> <i class="fa fa-trash" onclick="performAjaxAction(\'36\', \'delete-code\', \''. $uid .'\', true);"></i>';
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

                                //Get the friendly filename:
                                $friendlyfilename = filter_input(INPUT_GET, "friendlyfilename", FILTER_SANITIZE_SPECIAL_CHARS);
                                if (empty($friendlyfilename)) {
                                    $friendlyfilename = 'newsletter.pdf';
                                }
                                
                                header("Cache-Control: must-revalidate, post-check=0, pre-check=0, max-age=0, public");
                                header('Content-Description: File Transfer');
                                header("Content-Type: application/octet-stream");
                                header('Content-Disposition: attachment; filename="'.$friendlyfilename.'"');
                                header('Content-Transfer-Encoding: binary');
                                //Get the actual file path:
                                $filePath = filter_input(INPUT_GET, "filepath", FILTER_SANITIZE_SPECIAL_CHARS);
                                if ( isset($filePath)) {
                                    header('Content-Length: ' . filesize($filePath));
                                    flush(); 
                                    readfile($filePath);
                                    die();
                                } else {
                                    http_response_code(404);
                                        die();
                                }
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
	
    
//    public function initializeShowAction () {
//
//        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_document']['ctrl']['enablecolumns']['starttime']);
//        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_document']['ctrl']['enablecolumns']['endtime']);
//        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_newsletter']['ctrl']['enablecolumns']['starttime']);
//        unset($GLOBALS['TCA']['tx_nkcadportal_domain_model_newsletter']['ctrl']['enablecolumns']['endtime']);
//        
//    }
    
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
        if (isset($_POST['tx_nkcadportal_nkcadportalfe'])){
                if(isset($_POST['tx_nkcadportal_nkcadportalfe']['formaction'])){
                        switch($_POST['tx_nkcadportal_nkcadportalfe']['formaction']){

                                case "createcontact":
                                        $this->createContact();
                                        break;
                                case "updatecontact":
                                        $this->updateContact();
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
        //Get the logged in FE User:
        $feUserUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        if (!$feUserUid > 0) { 
            die('Invalid user information');
        }
        $frontendUser = $this->frontendUserRepository->findByUid($feUserUid);
        if (is_null($frontendUser)) {
            exit('Some error occured while parsing your membership records. Please contact the administration');
        }
        // get contact details of the user
        //$addContacts = $this->contactRepository->findByCustomfrontenduser($feUserUid);
        //Add the accessible documents to the $frontendUser object:
        $frontendUser = $this->addDocumentsToUser($frontendUser);

        try {
            //Add download path data to the documents:
             if (is_array($frontendUser->documents)) {
                foreach($frontendUser->documents as $document){
                    $docFile = $document->getFile();
                    if(is_object($docFile)) {
                        $publicUrl = $docFile->getOriginalResource()->getPublicUrl();
                        $aPublicUrlTmp = explode("/", $publicUrl);
                        $document->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
                    }
                }
             }

            //Add the accessible newsletters to the $frontendUser object:
            $frontendUser = $this->addNewslettersToUser($frontendUser);

            //Add download path data to the newsletters:
            if (is_array($frontendUser->newsletters)) {
                foreach($frontendUser->newsletters as $newsletter){
                    $nlFile =  $newsletter->getFile();
                    if(is_object($nlFile)) {
                        $publicUrl = $nlFile->getOriginalResource()->getPublicUrl();
                        $aPublicUrlTmp = explode("/", $publicUrl);
                        $newsletter->fileName = $aPublicUrlTmp[count($aPublicUrlTmp)-1];
                    }
                }
            }
        } catch (\Exception $e){}

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
	
    /**
     * 
     * @param object $frontendUser
     * @return type
     */
	public function addDocumentsToUser($frontendUser)
	{
            if (is_null($frontendUser)) {
                die('User information not available');
            }
            //Get all states this user has a membership for:
            $aUserStates = [];
            foreach($frontendUser->getMemberships() as $membership){
                $aUserStates[$membership->getState()->getUid()] = $membership->getState();
            }
            //Get the single $oAllStates state object:
            $oAllStates = $this->stateRepository->findByUid(1);

            //Collect the documents for a) the membership usergroups this user belongs to and b) the state this user has a membership for:
            $frontendUser->documents = [];

            $collectedDocuments = $this->documentRepository->findByUsergroups($frontendUser->getUsergroup());

            foreach($collectedDocuments as $document){
                foreach($document->getStates() as $documentState){
                    if ($documentState->getUid() == $oAllStates->getUid()){
                        $frontendUser->documents[] = $document;
                        continue(2);
                    } else{
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
                        $nlTypeArr = $membershipTemplate->getIncludednewsletters();
                        if (count($nlTypeArr) > 0) {
                            foreach ($nlTypeArr as $newsletterType){
                                     $aUserNewsletterTypes[$newsletterType->getUid()] = $newsletterType;
                            }
                        }
		}
	
		//Collect the newsletters that the user's memberships provide access to:
		if (!empty($aUserNewsletterTypes)){
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
                
                if ($changePW == 1){
                        //Check if the provided old (plain) password matches the stored (salted) password:
                        if ($this->testSaltedPasswordAgainstStoredValue($oldPWValue, $frontendUser->getPassword())){
                                //Provided old password correct - Continue and Salt the new password:
                            $newPwdValue = $aFormData['password'];
                            $newPassword = $this->saltPassword($newPwdValue);
                            $frontendUser->setPassword($newPassword);
                            
                        } else {
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
                
                $frontendUser->setFirstName($aFormData['firstname']);
                $frontendUser->setLastName($aFormData['lastname']);
                $frontendUser->setName($aFormData['firstname'].' '.$aFormData['lastname']);
                $frontendUser->setTitle($aFormData['title']);
                $frontendUser->setCompany($aFormData['company']);
                $frontendUser->setNumberofemployees($aFormData['numberofemployees']);
                $frontendUser->setNumberofcdldrivers($aFormData['numberofcdldrivers']);
                $frontendUser->setAddress($aFormData['address']);
                $frontendUser->setAdditionaladdress($aFormData['additionaladdress']);
                $frontendUser->setCity($aFormData['city']);
                $frontendUser->setState($aFormData['state']);
                $frontendUser->setZip($aFormData['zip']);
                $frontendUser->setTelephone($aFormData['phone']);
                $frontendUser->setCellphone($aFormData['cellphone']);
                $frontendUser->setFax($aFormData['fax']);
                $frontendUser->setFein($aFormData['fein']);
                $frontendUser->setBusinesstype($aFormData['businesstype']);
                $frontendUser->setInsurancecarrier($aFormData['insurancecarrier']);
                $frontendUser->setInsuranceagent($aFormData['insuranceagent']);
                $frontendUser->setHearaboutus($aFormData['hearaboutus']);
                $frontendUser->setEmail($aFormData['email']);

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
		if ($contactAlreadyExists == 0) {
                        $phone = $this->formatPhone($aFormData['phone']);
			//Create the new contact:
			$newContact = new \Netkyngs\Nkcadportal\Domain\Model\Contact();
			$newContact->setFirstname(trim($aFormData['firstname']));
			$newContact->setLastname(trim($aFormData['lastname']));
			$newContact->setTitle(trim($aFormData['title']));
			$newContact->setEmail(trim($aFormData['email']));
			$newContact->setPhone($phone);
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
    
    /**
     * function createContact
     * 
     * @return void
     */
    public function updateContact()
    {
		
        //Get the form input data:
        $aInputArray = filter_input(INPUT_POST, 'tx_nkcadportal_nkcadportalfe', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $aFormData = $aInputArray['newContact'];
        
        if ($aFormData['cuid'] != '') {
            
            $phone = $this->formatPhone($aFormData['phone']);
            
            $contactObj = $this->contactRepository->findByUid($aFormData['cuid']);
            $contactObj->setFirstname(trim($aFormData['firstname']));
            $contactObj->setLastname(trim($aFormData['lastname']));
            $contactObj->setTitle(trim($aFormData['title']));
            $contactObj->setEmail(trim($aFormData['email']));
            $contactObj->setPhone($phone);
            $contactObj->setContacttype($aFormData['contacttype']);
            
            $this->contactRepository->update($contactObj);
            
            $this->addFlashMessage(
				'Contact update successful', //Message
				'Contact saved', //Title
				$severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::OK,
				FALSE //storeInSession?
			);
            $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
            $persistenceManager->persistAll();
            
        } else {
            $this->addFlashMessage(
					'Contact data not found... Nothing added.', //Message
					'Contact data', //Title
					$severity = \TYPO3\CMS\Core\Messaging\AbstractMessage::WARNING,
					FALSE //storeInSession?
				);
        }
		
    }
	
    /**
     * 
     * @param string $phone
     * @return string
     */
    protected function formatPhone($phone) 
    {
        if (isset($phone)) {
            
            $trimmedPh = preg_replace('/[^0-9]/', '', $phone);
            $phArr = str_split($trimmedPh, 3);
            
            if (count($phArr) > 2) {
                $formattedPhone = $phArr[0].'-'.$phArr[1].'-';
                for($i=2; $i < count($phArr); $i++) {
                    $formattedPhone .= $phArr[$i];
                }
                
                if (strlen($formattedPhone) > 12) { //extension
                    $phExtArr = str_split($formattedPhone, 12);
                    
                    return $phExtArr[0].'('. $phExtArr[1] .')';
                    
                } else {
                    
                    return $formattedPhone;
                }
            }
        }
        
        return $phone;
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
            if (\TYPO3\CMS\Saltedpasswords\Utility\SaltedPasswordsUtility::isUsageEnabled('FE')) {
                $objSalt = \TYPO3\CMS\Saltedpasswords\Salt\SaltFactory::getSaltingInstance(NULL);
                if (is_object($objSalt)) {
                    $saltedPassword = $objSalt->getHashedPassword($password);
                }
            }
            if ($saltedPassword != ''){
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


        /**
         * 
         * @param array $arr
         * @return string
         */
         protected function array2Json($arr)
         {
           return json_encode($arr);
         }
 
 }