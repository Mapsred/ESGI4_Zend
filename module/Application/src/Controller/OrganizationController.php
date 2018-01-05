<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 22/12/2017
 * Time: 12:17
 */

namespace Application\Controller;

use Application\Entity\Organization;
use Application\Manager\OrganizationManager;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;
use Zend\View\Model\ViewModel;

/**
 * Class OrganizationController
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 * @method FlashMessenger flashMessenger()
 * @method Request getRequest()
 */
final class OrganizationController extends AbstractActionController
{
    /**
     * @var OrganizationManager $organizationManager
     */
    private $organizationManager;

    /**
     * OrganizationController constructor.
     * @param OrganizationManager $organizationManager
     */
    public function __construct(OrganizationManager $organizationManager)
    {
        $this->organizationManager = $organizationManager;
    }

    /**
     * @return Response|ViewModel
     */
    public function createAction()
    {
        $form = $this->organizationManager->getForm();
        $organization = new Organization();
        $form->bind($organization);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $this->organizationManager->persistAndFlush($organization);

                $flashMessenger = $this->flashMessenger();
                $flashMessenger->addSuccessMessage(sprintf('Organization %s is successfully created', $organization->getName()));

                return $this->redirect()->toRoute('organization');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * @return ViewModel
     */
    public function listAction(): ViewModel
    {
        $organizations = $this->organizationManager->getRepository()->findAll();

        return new ViewModel([
            'organizations' => $organizations
        ]);
    }

    /**
     * @return ViewModel|Response
     */
    public function detailAction()
    {
        $id = $this->params()->fromRoute('id');
        if (null === $organization = $this->organizationManager->getRepository()->findOneBy(['id' => $id])) {
            return $this->redirect()->toRoute('organization');
        }

        return new ViewModel([
            'organization' => $organization,
        ]);
    }

    /**
     * @return Response|ViewModel
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id');
        if (null === $organization = $this->organizationManager->getRepository()->findOneBy(['id' => $id])) {
            return $this->redirect()->toRoute('organization');
        }

        $form = $this->organizationManager->getForm();
        $form->bind($organization);

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);

            if ($form->isValid()) {
                $this->organizationManager->persistAndFlush($organization);

                $flashMessenger = $this->flashMessenger();
                $flashMessenger->addSuccessMessage(sprintf('Organization %s is successfully updated', $organization->getName()));

                return $this->redirect()->toRoute('organization');
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
        if (null === $organization = $this->organizationManager->getRepository()->findOneBy(['id' => $id])) {
            return $this->redirect()->toRoute('organization');
        }

        $flashMessenger = $this->flashMessenger();
        $this->organizationManager->removeEntity($organization);
        $flashMessenger->addSuccessMessage(sprintf('Organization %s successfully removed !', $organization->getName()));

        return $this->redirect()->toRoute('organization');
    }
}
