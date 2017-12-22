<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 21/12/2017
 * Time: 10:15
 */

namespace Application\Form;

use Application\Entity\Meetup;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelect;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class MeetupForm extends Form implements InputFilterProviderInterface
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
        $hydrator = new DoctrineHydrator($entityManager, Meetup::class);
        $this->setHydrator($hydrator);

        $this->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'title',
            'options' => ['label' => 'Titre du Meetup'],
            'attributes' => ['class' => 'form-control'],
        ])->add([
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'description',
            'options' => ['label' => 'Description'],
            'attributes' => ['class' => 'form-control'],
        ])->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'start_date',
            'options' => ['label' => 'Date de début', 'format' => 'd/m/Y'],
            'attributes' => ['class' => 'form-control date_picker', 'value' => ''],

        ])->add([
            'type' => 'Zend\Form\Element\Text',
            'name' => 'end_date',
            'options' => ['label' => 'Date de fin', 'format' => 'd/m/Y'],
            'attributes' => ['class' => 'form-control date_picker'],
            'format' => 'd/m/Y'
        ])->add([
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => ['value' => 'Submit', 'class' => 'btn btn-default'],
        ])->add([
            'type' => ObjectSelect::class,
            'name' => 'user',
            'options' => [
                'label' => 'Organisateur',
                'object_manager' => $entityManager,
                'target_class' => User::class,
                'property' => 'username',
                'is_method' => true,
                'find_method' => ['name' => 'findAll'],
            ],
            'empty_option' => "Select..",
            'attributes' => ['value' => 'Submit', 'class' => 'btn btn-default'],
        ])->add(new Csrf('security'));
    }

    /**
     * Used to bind the \DateTime objects to the Value of the Date Elements
     */
    public function bindDates()
    {
        /** @var Meetup $meetup */
        $meetup = $this->getObject();
        $this->get('start_date')->setValue($meetup->getStartDate()->format("d/m/Y"));
        $this->get('end_date')->setValue($meetup->getEndDate()->format("d/m/Y"));
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
            'title' => [
                'required' => true,
                'validators' => [
                    ['name' => Validator\StringLength::class, 'options' => ['min' => 2, 'max' => 256]],
                ],
            ],
            'description' => [
                'required' => true,
                'validators' => [
                    ['name' => Validator\StringLength::class, 'options' => ['min' => 2, 'max' => 65555]],
                ]
            ],

            'start_date' => [
                'required' => true,
                'validators' => [
                    ['name' => Validator\Callback::class, 'options' => [
                        'callback' => [$this, 'verifyDate']
                    ]]
                ]
            ]
        ];
    }

    /**
     * @param string $value
     * @param array $context
     * @return bool
     */
    public function verifyDate(string $value, array $context): bool
    {
        $startDate = \DateTime::createFromFormat("d/m/Y", $value);
        $endDate = \DateTime::createFromFormat('d/m/Y', $context['end_date']);

        return $endDate > $startDate;
    }
}
