<?php
namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Controller\Plugin\FlashMessenger as Messenger;

class FlashMessenger extends AbstractHelper
{
    protected $flashMessenger;

    public function __construct(Messenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    public function __invoke()
    {
        $namespaces = array('danger', 'success', 'info', 'warning');

        $messageString = '';

        foreach ($namespaces as $ns) {
            $messages = array_merge(
                $this->flashMessenger->getMessagesFromNamespace($ns),
                $this->flashMessenger->getCurrentMessagesFromNamespace($ns)
            );
            $this->flashMessenger->setNamespace($ns)->clearMessages();
            $messages = array_unique($messages);

            if (!$messages) {
                continue;
            }
            $messageString .= "<div class='flashmessages alert alert-$ns'>"
                               .'<a class="close" data-dismiss="alert" href="#">×</a>'
                               .implode('<br />', $messages)
                               .'</div>';
        }
        return $messageString;
    }
}
