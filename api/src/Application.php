<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use App\Routing\Middleware\LocaleMiddleware;
use Authorization\Policy\MapResolver;
use Authorization\Policy\ResolverCollection;
use Cake\Core\Configure;
use Cake\Core\Exception\MissingPluginException;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\I18n\Middleware\LocaleSelectorMiddleware;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use ERP\Model\Table\OrdersTable;
use Helms\Policy\MyOrdersTablePolicy;
use Helms\Policy\OrdersTablePolicy;
use Psr\Http\Message\ServerRequestInterface;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use Users\Authenticator\JwtAuthenticator;
use Utility\Controller\Api\PrintContentController;
use Utility\Policy\PrintContentControllerPolicy;

/**
 * Application setup class.
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface, AuthorizationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     *
     * @return void
     */
    public function bootstrap(): void
    {

        // Call parent to load bootstrap from files.
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        }

        /*
         * Only try to load DebugKit in development mode
         * Debug Kit should not be installed on a production system
         */
        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
            Configure::write('DebugKit.ignoreAuthorization', true);
        }

        /**
         * Load Authorization
         */
        $this->addPlugin('Authorization');

    }

    /**
     * Setup the middleware queue your application will use.
     *
     * @param \Cake\Http\MiddlewareQueue $middlewareQueue The middleware queue to setup.
     *
     * @return \Cake\Http\MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            // @todo DISABLED 2022/07/07 - made unauthenticated requests fail when unit testing, doesn't appear to affect the app
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            //->add(new ErrorHandlerMiddleware(Configure::read('Error')))

            // Handle plugin/theme assets like CakePHP normally does.
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))

            // Add routing middleware.
            // If you have a large number of routes connected, turning on routes
            // caching in production could improve performance. For that when
            // creating the middleware instance specify the cache config name by
            // using it's second constructor argument:
            // `new RoutingMiddleware($this, '_cake_routes_')`
            ->add(new RoutingMiddleware($this))

            // @todo makes this settable from config
            ->add(new LocaleMiddleware())

            // Parse various types of encoded request bodies so that they are
            // available as array through $request->getData()
            // https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
            ->add(new BodyParserMiddleware())

            /**
             * Authentication
             */
            ->add(new AuthenticationMiddleware($this))

            /**
             * Authorization
             */
            ->add(new AuthorizationMiddleware($this));

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        $fields = [
            'username' => 'email',
            'password' => 'password'
        ];

        $service->loadAuthenticator(JwtAuthenticator::class, [
            'secretKey'     => file_get_contents(CONFIG . '/jwt.pem'),
            'algorithms'    => ['RS256'],
            'returnPayload' => false
        ]);

        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
        ]);

        $service->loadIdentifier('Authentication.JwtSubject');

        $service->loadIdentifier('Authentication.Password', [
            'returnPayload' => false,
            'fields'        => $fields,
        ]);

        return $service;
    }

    /**
     * @todo Check how plugins can add new mappings
     *
     */
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $ormResolver = new OrmResolver();

        $mapResolver = new MapResolver();
        $mapResolver->map(PrintContentController::class, PrintContentControllerPolicy::class);

        // @todo Trying to add custom policy, this does not work for scoped query policy
        // $mapResolver->map(OrdersTable::class, MyOrdersTablePolicy::class);

        $resolver = new ResolverCollection([
            $mapResolver,
            $ormResolver
        ]);

        return new AuthorizationService($resolver);
    }

    /**
     * Bootrapping for CLI application.
     * That is when running commands.
     *
     * @return void
     */
    protected function bootstrapCli(): void
    {
        try {
            $this->addPlugin('Bake');
        } catch (MissingPluginException $e) {
            // Do not halt if the plugin is missing
        }

        $this->addPlugin('Migrations');

        // Load more plugins here
    }
}
