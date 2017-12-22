<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 21/12/2017
 * Time: 10:12
 */

namespace Application\Manager;

use Application\Form\UserForm;
use Application\Repository\UserRepository;

/**
 * Class UserManager
 *
 * @author François MATHIEU <francois.mathieu@livexp.fr>
 * @method UserForm getForm()
 * @method UserManager persistAndFlush($entity)
 * @method UserManager removeEntity($entity)
 * @method UserRepository getRepository()
 */
final class UserManager extends BaseManager
{
}
