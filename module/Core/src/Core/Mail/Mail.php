<?php
namespace Core\Mail;

use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Message;
use Zend\View\Model\ViewModel;
use Zend\Mime\Message as MineMessage;
use Zend\Mime\Part as MinePart;

class Mail
{
    protected $transport;
    protected $view;
    protected $body;
    protected $message;
    protected $subject;
    protected $to;
    protected $data;
    protected $page;

    public function __construct(SmtpTransport $transport, $view, $page)
    {
        $this->transport    = $transport;
        $this->view         = $view;
        $this->page         = $page;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function renderView($page, array $data)
    {
        $model = new ViewModel;
        $model->setTemplate("mailer/{$page}.phtml");
        $model->setOption('has_parent', true);
        $model->setVariable('data', $data);

        return $this->view->render($model);
    }

    public function prepare()
    {
        $html = new MinePart($this->renderView($this->page, $this->data));
        $html->type = "text/html";

        $body = new MineMessage();
        $body->setParts(array($html));
        $this->body = $body;

        $config = $this->transport->getOptions()->toArray();

        $this->message = new Message();
        $this->message->setEncoding("UTF-8");
        $this->message->addFrom($config['connection_config']['from'])
                        ->addTo($this->to)
                        ->setSubject($this->subject)
                        ->setBody($this->body);
        return $this;
    }

    public function send()
    {
        try {
            $this->transport->send($this->message);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            throw $ex;
        }
    }
}
