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
 * ReminderController
 */
class ReminderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * reminderRepository
     * 
     * @var \Netkyngs\Nkcadportal\Domain\Repository\ReminderRepository
     * @inject
     */
    protected $reminderRepository = NULL;
    
    /**
     * action list
     * 
     * @return void
     */
    public function listAction()
    {
        $reminders = $this->reminderRepository->findAll();
        $this->view->assign('reminders', $reminders);
    }
    
    /**
     * action show
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder
     * @return void
     */
    public function showAction(\Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder)
    {
        $this->view->assign('reminder', $reminder);
    }
    
    /**
     * action new
     * 
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Reminder $newReminder
     * @return void
     */
    public function createAction(\Netkyngs\Nkcadportal\Domain\Model\Reminder $newReminder)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->reminderRepository->add($newReminder);
        $this->redirect('list');
    }
    
    /**
     * action edit
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder
     * @ignorevalidation $reminder
     * @return void
     */
    public function editAction(\Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder)
    {
        $this->view->assign('reminder', $reminder);
    }
    
    /**
     * action update
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder
     * @return void
     */
    public function updateAction(\Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->reminderRepository->update($reminder);
        $this->redirect('list');
    }
    
    /**
     * action delete
     * 
     * @param \Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder
     * @return void
     */
    public function deleteAction(\Netkyngs\Nkcadportal\Domain\Model\Reminder $reminder)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->reminderRepository->remove($reminder);
        $this->redirect('list');
    }

}