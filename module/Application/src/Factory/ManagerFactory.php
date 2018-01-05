<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 19/12/2017
 * Time: 14:55
 */

namespace Application\Factory;

use Application\Entity;
use Application\Form;
use Application\Manager;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ManagerFactory
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
final class ManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return Manager\BaseManager
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManager $manager */
        $manager = $container->get('doctrine.entitymanager.orm_default');

        $form = null;
        $class = null;
        if ($requestedName === Manager\MeetupManager::class) {
            $class = Entity\Meetup::class;
            $form = new Form\MeetupForm($manager);
        }

        if ($requestedName === Manager\UserManager::class) {
            $class = Entity\User::class;
            $form = new Form\UserForm($manager);
        }

        if ($requestedName === Manager\OrganizationManager::class) {
            $class = Entity\Organization::class;
            $form = new Form\OrganizationForm($manager);
        }

        return new $requestedName($manager, $form, $class);
    }
}
