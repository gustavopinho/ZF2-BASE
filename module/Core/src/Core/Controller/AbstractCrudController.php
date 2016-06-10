<?php
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

abstract class AbstractCrudController extends AbstractActionController
{
    protected $service;
    protected $form;
    protected $route;
    protected $controller;

    public function indexAction()
    {
        $list = $this->service->getRepository()->findAll();

        $page = $this->params()->fromRoute('page');
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($page)
                    ->setDefaultItemCountPerPage(50);
        return new ViewModel([
            'data'=>$paginator,
            'page'=>$page
        ]);
    }

    public function registerAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $entity = $this->service
                        ->getRepository()
                        ->findOneById($id);

        $form = new $this->form('', array('id' => $id, 'em' => $this->service->getEntityManager()));
        if (!empty($entity))
            $form->setData($entity->toArray());

        $request = $this->getRequest();
        if ($request->isPost())
        {
            $form->setData($request->getPost());
            if ($form->isValid())
            {
                try {
                    $id = $id ? $id : $request->getPost('id', 0);

                    if ($this->service->persist($form->getData(), $id))
                    {
                        $this->flashMessenger()
                                ->addMessage('Registro salvo com sucesso!', 'success');
                    } else {
                        $this->flashMessenger()
                                ->addMessage('Não foi possível salvar o registro!', 'danger');
                    }
                } catch (\Exception $e) {
                    $this->flashMessenger()
                            ->addMessage('Ocorreu um erro ao salvar!', 'danger');
                }
                // Redireciona para o index onde são listados os registros
                return $this->redirect()
                                ->toRoute(
                                    $this->route,
                                    array('controller' => $this->controller));
            } else {
                $this->flashMessenger()
                        ->addMessage('Formulário inválido', 'danger');
            }
        }
        return new ViewModel([
            'form' => $form,
            'id' => $id
        ]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        $entity = $this->service
                        ->getRepository()
                        ->findOneById($id);

        if(!empty($entity)) {
            try {
                if ($this->service->delete()) {
                    $this->flashMessenger()
                            ->addMessage('Registro excluído com sucesso!', 'success');
                }
            } catch (\Exception $e) {
                $this->flashMessenger()
                        ->addMessage('Falha ao excluír registro!', 'danger');
            }
        } else {
            $this->flashMessenger()
                    ->addMessage('O registro não pode ser encontrado!', 'danger');
        }
        return $this->redirect()
                        ->toRoute(
                            $this->route,
                            array('controller'=>$this->controller));
    }
}
