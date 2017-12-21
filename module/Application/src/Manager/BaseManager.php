<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 19/12/2017
 * Time: 15:03
 */

namespace Application\Manager;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;

/**
 * Class BaseManager
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
abstract class BaseManager
{
    /**
     * @var EntityManager $manager
     */
    private $manager;
    /**
     * @var Form $form
     */
    private $form;

    /**
     * BaseManager constructor.
     * @param EntityManager $manager
     * @param Form $form
     */
    public function __construct(EntityManager $manager, Form $form)
    {
        $this->manager = $manager;
        $this->form = $form;
    }

    /**
     * @return EntityManager
     */
    public function getManager(): EntityManager
    {
        return $this->manager;
    }

    /**
     * @return Form
     */
    public function getForm(): Form
    {
        return $this->form;
    }

    /**
     * @param object $entity
     * @return BaseManager
     */
    public function persistAndFlush($entity): BaseManager
    {
        $this->getManager()->persist($entity);
        $this->getManager()->flush();

        return $this;
    }
}
