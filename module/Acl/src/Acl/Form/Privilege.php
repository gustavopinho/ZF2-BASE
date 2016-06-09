<?php
namespace Acl\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Privilege extends Form
{
    protected $options;

    public function __construct($name='form-privilege', array $options = null)
    {
        parent::__construct($name, $options);

        $this->options = $options;

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form');

        $this->addInput();
        $this->setInputFilter($this->inputFilter());
    }

    public function addInput()
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'Name',
            ),
            'options' => array(
                'label' => 'Name:',
            ),
        ));

        $this->add(array(
            'name' => 'role',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => "Role",
                'object_manager' => $this->options['em'],
                'target_class' => 'Acl\Entity\Role',
                'property' => 'name',
            ),
        ));

        $this->add(array(
            'name' => 'resource',
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'attributes' => array(
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => "Resource",
                'object_manager' => $this->options['em'],
                'target_class' => 'Acl\Entity\Resource',
                'property' => 'name',
            ),
        ));

        /*$this->add(array(
            'type' => '\Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));*/

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn btn-success'
            )
        ));
    }

    public function inputFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new Factory();

        $inputFilter->add(
            $factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )
        ));

        $inputFilter->add(array(
            'name' => 'role',
            'required' => true,
            'validators' => array(
                array('name'=>'NotEmpty')
            )
        ));

        $inputFilter->add(array(
            'name' => 'resource',
            'required' => true,
            'validators' => array(
                array('name'=>'NotEmpty')
            )
        ));
        return $inputFilter;
    }
}
