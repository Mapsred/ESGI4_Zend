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

/**
 * Class MeetupController
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 * @method FlashMessenger flashMessenger()
 */
class MeetupController extends AbstractActionController
{
    /**
     * @var MeetupManager $meetupManager
     */
    private $meetupManager;

    public function __construct(MeetupManager $meetupManager)
    {
        $this->meetupManager = $meetupManager;
    }

    public function indexAction(): ViewModel
    {
        return parent::indexAction();
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

                return $this->redirect()->toRoute('meetup');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * @return Response|ViewModel
     */
    public function listAction()
    {
        $meetups = $this->meetupManager->getRepository()->findAll();

        return new ViewModel([
            'meetups' => $meetups
        ]);
    }

    /**
     * @return Response|ViewModel
     */
    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');
        if (null === $meetup = $this->meetupManager->getRepository()->findOneBy(['id' => $id])) {
            return $this->redirect()->toRoute('meetup');
        }

        return new ViewModel([
            'meetup' => $meetup,
        ]);
    }

    /**
     * @return Response|ViewModel
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        if (null === $meetup = $this->meetupManager->getRepository()->findOneBy(['id' => $id])) {
            return $this->redirect()->toRoute('meetup');
        }

        $form = $this->meetupManager->getForm();
        $form->bind($meetup);
        $form->bindDates();

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $this->meetupManager->persistAndFlush($meetup);
                $flashMessenger = $this->flashMessenger();

                $flashMessenger->addSuccessMessage('Thanks for your support !');

                return $this->redirect()->toRoute('meetup');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * @return Response
     */
    public function deleteAction(): Response
    {
        $id = $this->params()->fromRoute('id');
        if (null === $meetup = $this->meetupManager->getRepository()->findOneBy(['id' => $id])) {
            return $this->redirect()->toRoute('meetup');
        }

        $this->meetupManager->removeEntity($meetup);
        $flashMessenger = $this->flashMessenger();
        $flashMessenger->addSuccessMessage(sprintf('Meetup %s successfully removed !', $meetup->getTitle()));

        return $this->redirect()->toRoute('meetup');
    }

}
