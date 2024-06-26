<?php

/**
 * @package     Joomla.Users
 * @subpackage  Webservices.users
 *
 * @copyright   (C) 2019 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Plugin\WebServices\Users\Extension;

use Joomla\CMS\Event\Application\BeforeApiRouteEvent;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\SubscriberInterface;

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

/**
 * Web Services adapter for com_users.
 *
 * @since  4.0.0
 */
final class Users extends CMSPlugin implements SubscriberInterface
{
    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   5.1.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onBeforeApiRoute' => 'onBeforeApiRoute',
        ];
    }

    /**
     * Registers com_users's API's routes in the application
     *
     * @param   BeforeApiRouteEvent  $event  The event object
     *
     * @return  void
     *
     * @since   4.0.0
     */
    public function onBeforeApiRoute(BeforeApiRouteEvent $event): void
    {
        $router = $event->getRouter();

        $router->createCRUDRoutes(
            'v1/users',
            'users',
            ['component' => 'com_users']
        );

        $this->createFieldsRoutes($router);

        $router->createCRUDRoutes(
            'v1/users/groups',
            'groups',
            ['component' => 'com_users']
        );

        $router->createCRUDRoutes(
            'v1/users/levels',
            'levels',
            ['component' => 'com_users']
        );
    }

    /**
     * Create fields routes
     *
     * @param   ApiRouter  &$router  The API Routing object
     *
     * @return  void
     *
     * @since   4.0.0
     */
    private function createFieldsRoutes(&$router): void
    {
        $router->createCRUDRoutes(
            'v1/fields/users',
            'fields',
            ['component' => 'com_fields', 'context' => 'com_users.user']
        );

        $router->createCRUDRoutes(
            'v1/fields/groups/users',
            'groups',
            ['component' => 'com_fields', 'context' => 'com_users.user']
        );
    }
}
