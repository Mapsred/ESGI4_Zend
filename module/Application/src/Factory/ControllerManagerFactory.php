<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 19/12/2017
 * Time: 14:59
 */

namespace Application\Factory;

use Application\Controller\MeetupController;
use Application\Manager\MeetupManager;
use Interop\Container\ContainerInterface;
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
     * @return MeetupController
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $manager = null;
        if ($requestedName === MeetupController::class) {
            $manager = $container->get(MeetupManager::class);
        }

        return new MeetupController($manager);
    }
}
