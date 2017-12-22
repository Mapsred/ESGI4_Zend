<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 19/12/2017
 * Time: 14:59
 */

namespace Application\Factory;

use Application\Controller;
use Application\Manager;
use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ControllerManagerFactory
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 */
class ControllerManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AbstractActionController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $manager = null;
        if ($requestedName === Controller\MeetupController::class) {
            $manager = $container->get(Manager\MeetupManager::class);
        }
        if ($requestedName === Controller\UserController::class) {
            $manager = $container->get(Manager\UserManager::class);
        }

        return new $requestedName($manager);
    }
}
