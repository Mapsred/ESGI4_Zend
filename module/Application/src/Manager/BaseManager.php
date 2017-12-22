<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 19/12/2017
 * Time: 15:03
 */

namespace Application\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
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
     * @var string $class
     */
    private $class;

    /**
     * BaseManager constructor.
     * @param EntityManager $manager
     * @param Form $form
     * @param string $class
     */
    public function __construct(EntityManager $manager, Form $form, string $class)
    {
        $this->manager = $manager;
        $this->form = $form;
        $this->class = $class;
    }

    /**
     * @return EntityManager
     */
    public function getManager(): EntityManager
    {
        return $this->manager;
    }

    /**
     * @return ObjectRepository|EntityRepository
     */
    public function getRepository()
    {
        return $this->manager->getRepository($this->class);
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
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

    public function removeEntity($entity): BaseManager
    {
        $this->getManager()->remove($entity);
        $this->getManager()->flush();

        return $this;
    }
}
