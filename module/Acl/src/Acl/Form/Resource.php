<?php
namespace Acl\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory;

class Resource extends Form
{
    protected $options;

    public function __construct($name='form-role', array $options = null)
    {
        parent::__construct('role');

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
                'label' => 'Name',
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
        return $inputFilter;
    }
}
