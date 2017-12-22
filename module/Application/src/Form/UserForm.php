<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 21/12/2017
 * Time: 10:15
 */

namespace Application\Form;

use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class UserForm extends Form implements InputFilterProviderInterface
{
    /**
     * MeetupForm constructor.
     * @param EntityManager $entityManager
     * @param null $name
     * @param array $options
     */
    public function __construct(EntityManager $entityManager, $name = null, $options = [])
    {
        parent::__construct($name, $options);
        $hydrator = new DoctrineHydrator($entityManager, User::class);
        $this->setHydrator($hydrator);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'username',
            'options' => ['label' => 'Pseudo'],
            'attributes' => ['class' => 'form-control'],
        ])->add([
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => ['value' => 'Submit', 'class' => 'btn btn-default'],
        ])->add(new Csrf('security'));
    }


    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            'username' => [
                'required' => true,
                'validators' => [
                    ['name' => Validator\StringLength::class, 'options' => ['min' => 2, 'max' => 256]],
                ],
            ],
        ];
    }
}
