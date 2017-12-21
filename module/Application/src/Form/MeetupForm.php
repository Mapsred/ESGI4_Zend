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
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
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
            'name' => [
                'validators' => [
                    [
                        'title' => Validator\StringLength::class,
                        'options' => ['min' => 2, 'max' => 256]
                    ],
                    [
                        'description' => Validator\StringLength::class,
                        'options' => ['min' => 2, 'max' => 65555]
                    ],

                ],
            ],
        ];

    }
}