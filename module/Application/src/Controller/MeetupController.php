<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 21/12/2017
 * Time: 10:12
 */

namespace Application\Controller;

use Application\Entity\Meetup;
use Application\Manager\MeetupManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
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

    /**
     * @return Response|ViewModel
     */
    public function createAction()
    {
        $form = $this->meetupManager->getForm();
        $meetup = new Meetup();
        $form->bind($meetup);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $this->meetupManager->persistAndFlush($meetup);
                /** @var FlashMessenger $flashMessenger */
                $flashMessenger = $this->flashMessenger();

                $flashMessenger->addSuccessMessage('Thanks for your support !');

                return $this->redirect()->toRoute('contact', ['action' => 'thankYou']);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
}
