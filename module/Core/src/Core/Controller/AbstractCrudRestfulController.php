<?php
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

abstract class AbstractCrudRestfulController extends AbstractRestfulController
{
    /**
     * Service padrão do controller
     * @var Core/Service/ServiceInterface
     */
    protected $service;

    /**
     * Form
     * @var {model}/Form/{name}
     */
    protected $form;

    /**
     * Resposta padrão
     * @var array
     */
    protected $response;

    public function __construct()
    {
        $this->response = [
            'messages' => [], // ['ns' => '', 'text' => '']
            'data' => [],
        ];
    }

    /**
     * Method: GET
     * Retorna uma lista de elementos
     *
     * @return JsonModel
     */
    public function getList()
    {
        $page = $this->params()->fromRoute('page', 1);

        $list = $this->service->getRepository()->findAll();

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                    ->setDefaultItemCountPerPage(20);

        $this->response['data'] = [
            'entities' => iterator_to_array($paginator->getCurrentItems(), false),
            'pages' => get_object_vars($paginator->getPages()),
        ];
        return new JsonModel($this->response);
    }

    /**
     * Method: GET
     * Retorna o elemento correspondente ao id especificado
     *
     * @param intenger/string $id
     * @return JsonModel
     */
    public function get($id)
    {
        $entity = $this->service->getRepository()->findOneById($id);

        if(empty($entity))
        {
            array_push(
                $this->response['messages'],
                [
                    'ns' => 'warning',
                    'message' => 'Registro não encontrado!'
                ]
            );
        } else {
            array_push(
                $this->response['data'],
                ['entity' => $entity]
            );
        }
        return new JsonModel($this->response);
    }

    /**
     * Method: POST
     * Cria um resgitro com os dados recebidos em $data
     *
     * @param array $data
     * @return JsonModel
     */
    public function create($data)
    {
        return new JsonModel($this->response);
    }

    /**
     * Method: PUT
     * Atualiza um resgistro de acordo com o $id passado e o array $data
     *
     * @param  intenger/string $id
     * @param  array $data
     * @return JsonModel
     */
    public function update($id, $data)
    {
        return new JsonModel($this->response);
    }

    /**
     * Method: DELETE
     * Exclui um elemento de acordo com o $id passado
     *
     * @param  integer/string $id
     * @return JsonModel
     */
    public function delete($id)
    {
        return new JsonModel($this->response);
    }
}
