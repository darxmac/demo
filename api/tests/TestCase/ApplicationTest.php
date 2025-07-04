<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Test\TestCase;

use App\Application;
use Cake\Core\Configure;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use InvalidArgumentException;

/**
 * ApplicationTest class
 */
class ApplicationTest extends TestCase
{

    use IntegrationTestTrait;

    /**
     * testBootstrap
     *
     * @covers \App\Application::bootstrap
     *
     * @return void
     */
    public function testBootstrap()
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $app->bootstrap();

        if (Configure::read('debug')) {
            $expected = [
                'Utility',
                'Bake',
                'Migrations',
                'DebugKit',
                'Authorization',
                'Users',
                'ERP',
                'TenFour'
            ];
        } else {
            $expected = [
                'Utility',
                'Bake',
                'Migrations',
                'Authorization',
                'Users',
                'ERP',
                'TenFour'
            ];
        }

        $plugins = [];

        foreach ($app->getPlugins() as $plugin) {
            $plugins[] = $plugin->getName();
        }

        $this->assertSame($expected, $plugins);
    }

    /**
     * testBootstrapPluginWitoutHalt
     *
     * @covers \App\Application::bootstrap
     *
     * @return void
     */
    public function testBootstrapPluginWithoutHalt()
    {
        $this->expectException(InvalidArgumentException::class);

        /**
         * @var Application $app
         */
        $app = $this->getMockBuilder(Application::class)
            ->setConstructorArgs([dirname(dirname(__DIR__)) . '/config'])
            ->onlyMethods(['addPlugin'])
            ->getMock();

        $app->method('addPlugin')
            ->will($this->throwException(new InvalidArgumentException('test exception.')));

        $app->bootstrap();
    }

    /**
     * testMiddleware
     *
     * @covers \App\Application::middleware
     *
     * @return void
     */
    public function testMiddleware()
    {
        $app = new Application(dirname(dirname(__DIR__)) . '/config');
        $middleware = new MiddlewareQueue();

        $middleware = $app->middleware($middleware);

        $this->assertInstanceOf(AssetMiddleware::class, $middleware->current());
        $middleware->seek(1);
        $this->assertInstanceOf(RoutingMiddleware::class, $middleware->current());
    }
}
