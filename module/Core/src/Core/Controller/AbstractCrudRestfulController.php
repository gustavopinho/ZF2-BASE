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
     * Method: GET
     * Retorna uma lista de elementos
     *
     * @return JsonModel
     */
    public function getList()
    {
        $page = $this->params()->fromRoute('page', 1);

        $list = $this->service
                        ->getRepository()
                        ->findAll();

        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                    ->setDefaultItemCountPerPage(20);

        $entities = [];
        // Verificar essa parte do código para uma solução melhor
        foreach ($paginator->getCurrentItems() as $key => $value)
        {
            array_push($entities, $value->toArray());
        }
        return new JsonModel([
            'messages' => [],
            'data' => [
                'entities' => $entities,
                'pages' => get_object_vars($paginator->getPages()),
            ]
        ]);
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
        $entity = $this->service
                        ->getRepository()
                        ->findOneById($id);

        if(empty($entity))
        {
            $return = [
                'messages' => [
                    [
                        'ns' => 'warning',
                        'message' => 'Registro não encontrado!'
                    ]
                ],
                'data' => []
            ];
        } else {
            $return = [
                'messages' => [],
                'data' => [
                    'entity' => $entity->toArray()
                ]
            ];
        }
        return new JsonModel($return);
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
        $form = new $this->form('', ['em' => $this->service->getEntityManager()]);
        $form->setData($data);

        $return = ['messages' => [], 'data' => []];

        if($form->isValid())
        {
            try {
                $entity = $this->service->persist($form->getData());
                if(!empty($entity))
                {
                    $return = [
                        'messages' => [
                            [
                                'ns' => 'success',
                                'message' => 'Registro inserido com sucesso!'
                            ]
                        ],
                        'data' => [
                            'entity' => $entity->toArray()
                        ]
                    ];
                } else {
                    $return = [
                        'messages' => [
                            [
                                'ns' => 'danger',
                                'message' => 'Não foi possível inserir o registro!'
                            ]
                        ],
                        'data' => []
                    ];
                }

            } catch (\Exception $e) {
                $return = [
                    'messages' => [
                        [
                            'ns' => 'danger',
                            'message' => 'Exception - ocorreu um erro!'
                        ]
                    ],
                    'data' => []
                ];
            }
        } else {
            foreach ($form->getMessages() as $key => $messages) {
                foreach ($messages as $key2 => $message) {
                    array_push(
                        $return['messages'],
                        ['ns' => 'danger', 'message' => $key.' - '.$message]
                    );
                }
            }
        }
        return new JsonModel($return);
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
        $entity = $this->service
                        ->getRepository()
                        ->findOneById($id);
        $return = ['messages' => [], 'data' => []];

        if(!empty($entity))
        {
            $form = new $this->form('', ['em' => $this->service->getEntityManager()]);
            $form->setData($data);

            if($form->isValid())
            {
                try {
                    $entity = $this->service->persist($form->getData(), $entity->getId());
                    if(!empty($entity))
                    {
                        $return = [
                            'messages' => [
                                [
                                    'ns' => 'success',
                                    'message' => 'Registro atualizado com sucesso!'
                                ]
                            ],
                            'data' => [
                                'entity' => $entity->toArray()
                            ]
                        ];
                    } else {
                        $return = [
                            'messages' => [
                                [
                                    'ns' => 'danger',
                                    'message' => 'Não foi possível atualizar o registro!'
                                ]
                            ],
                            'data' => []
                        ];
                    }

                } catch (\Exception $e) {
                    $return = [
                        'messages' => [
                            [
                                'ns' => 'danger',
                                'message' => 'Exception - ocorreu um erro!'
                            ]
                        ],
                        'data' => []
                    ];
                }
            } else {
                foreach ($form->getMessages() as $key => $messages) {
                    foreach ($messages as $key2 => $message) {
                        array_push(
                            $return['messages'],
                            ['ns' => 'danger', 'message' => $key.' - '.$message]
                        );
                    }
                }
            }
        } else {
            $return = [
                'messages' => [
                    [
                        'ns' => 'danger',
                        'message' => 'O registro não pode ser encontrado!'
                    ]
                ],
                'data' => []
            ];
        }
        return new JsonModel($return);
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
        $entity = $this->service
                        ->getRepository()
                        ->findOneById($id);
        $return = ['messages' => [], 'data' => []];

        if(!empty($entity))
        {
            $id = $this->service->delete($entity->getId());
            if(!empty($id)) {
                $return = [
                    'messages' => [
                        [
                            'ns' => 'success',
                            'message' => 'Registro excluído com sucesso!'
                        ]
                    ],
                    'data' => [
                        'id' => $id
                    ]
                ];
            } else {
                $return = [
                    'messages' => [
                        [
                            'ns' => 'danger',
                            'message' => 'Não foi possível excluír o registro!'
                        ]
                    ],
                    'data' => []
                ];
            }
        } else {
            $return = [
                'messages' => [
                    [
                        'ns' => 'danger',
                        'message' => 'O registro não pode ser encontrado!'
                    ]
                ],
                'data' => []
            ];
        }
        return new JsonModel($return);
    }
}
