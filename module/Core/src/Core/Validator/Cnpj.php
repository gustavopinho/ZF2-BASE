<?php
/**
 * Classe foi implementada com base no tutorial da School Of Net
 * Seu objetivo é a validação de CPF e CNPJ
 *
 * @see http://www.schoolofnet.com/2015/04/como-validar-cpf-e-cnpj-usando-zend-framework-2/
 */
namespace Base\Validator;

/**
 * Description of Cgc
 *
 * @author Luiz Carlos
 */
class Cnpj extends CgcAbstract
{

    /**
     * Tamanho do Campo
     * @var int
     */
    protected $size = 14;

    /**
     * Modificadores de Dígitos
     * @var array
     */
    protected $modifiers = [
        [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2],
        [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2]
    ];
}
