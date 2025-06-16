<?php

namespace App\Event;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use Cake\ORM\Locator\TableLocator;
use Utility\Event\ModelAuthUserId;

/**
 * Class EventListener
 *
 * @package App\Event
 */
class EventListener implements EventListenerInterface
{

    /**
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            'Controller.initialize'   => 'initialize',
            'Users.Controller.Users.Login.success' => 'afterLogin',
            'Users.Controller.Users.Token.success' => 'afterToken'
        ];
    }

    /**
     * @param \Cake\Event\Event $event
     */
    public function initialize(Event $event)
    {
        if ($event->getSubject() instanceof Controller) {
            /**
             * @var Controller $controller
             */
            $controller = $event->getSubject();
            $identity = $controller->getRequest()->getAttribute('identity');

            if ($identity) {
                /**
                 * Audit log event setup
                 */
                EventManager::instance()->on(new ModelAuthUserId($identity));
            }
        }
    }

    /**
     * @param Event $event
     */
    public function afterLogin(Event $event)
    {
        $this->createAuditLog($event, 'login');
    }

    /**
     * @param Event $event
     */
    public function afterToken(Event $event)
    {
        $this->createAuditLog($event, 'token');
    }

    /**
     * @param Event  $event
     * @param string $operation
     */
    protected function createAuditLog(Event $event, string $operation) {
        if ($event->getSubject() instanceof Controller) {
            if (isset($event->getData()['user'])) {
                $user = $event->getData()['user'];

                $AuditLogs = (new TableLocator())->get('Utility.AuditLogs');
                $AuditLogs->save($AuditLogs->newEntity([
                    'user_id'   => $user['id'],
                    'operation' => $operation,
                    'model'     => 'Users.Users'
                ]));
            }
        }
    }
}
