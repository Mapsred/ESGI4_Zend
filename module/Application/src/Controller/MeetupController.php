<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 21/12/2017
 * Time: 10:12
 */

namespace Application\Controller;

use Application\Manager\MeetupManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MeetupController extends AbstractActionController
{
    /**
     * @var MeetupManager
     */
    private $meetupManager;

    public function __construct(MeetupManager $meetupManager)
    {
        $this->meetupManager = $meetupManager;
    }

    public function createAction()
    {
        return new ViewModel();
    }
}