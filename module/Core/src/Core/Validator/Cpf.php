<?php
/**
 * Classe foi implementada com base no tutorial da School Of Net
 * Seu objetivo é a validação de CPF e CNPJ
 *
 * @see http://www.schoolofnet.com/2015/04/como-validar-cpf-e-cnpj-usando-zend-framework-2/
 */
namespace Base\Validator;

class Cpf extends CgcAbstract
{

    /**
     * Tamanho do Campo
     * @var int
     */
    protected $size = 11;

    /**
     * Modificadores de Dígitos
     * @var array
     */
    protected $modifiers = [
        [10, 9, 8, 7, 6, 5, 4, 3, 2],
        [11, 10, 9, 8, 7, 6, 5, 4, 3, 2]
    ];
}
