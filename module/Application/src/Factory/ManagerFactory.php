<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 19/12/2017
 * Time: 14:55
 */

namespace Application\Factory;

use Application\Entity\Meetup;
use Application\Form\MeetupForm;
use Application\Manager\BaseManager;
use Application\Manager\MeetupManager;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ManagerFactory
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class ManagerFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return BaseManager
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var EntityManager $manager */
        $manager = $container->get('doctrine.entitymanager.orm_default');

        $form = null;
        $class = null;
        if ($requestedName === MeetupManager::class) {
            $class = Meetup::class;
            $form = new MeetupForm($manager);
        }

        return new $requestedName($manager, $form, $class);
    }
}
