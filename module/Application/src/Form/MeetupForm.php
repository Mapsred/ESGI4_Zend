<?php
/**
 * Created by PhpStorm.
 * User: francois.mathieu
 * Date: 21/12/2017
 * Time: 10:15
 */

namespace Application\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Validator;

class MeetupForm extends Form implements InputFilterProviderInterface
{
    /**
     * MeetupForm constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

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
            'type' => 'Zend\Form\Element\Date',
            'name' => 'start_date',
            'options' => ['label' => 'Date de début', 'format' => 'd/m/Y'],
            'attributes' => ['class' => 'form-control date_picker'],

        ])->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'end_date',
            'options' => ['label' => 'Date de fin', 'format' => 'd/m/Y'],
            'attributes' => ['class' => 'form-control date_picker'],
            'format' => 'd/m/Y'
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
