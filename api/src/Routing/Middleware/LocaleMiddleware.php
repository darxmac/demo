<?php
declare(strict_types=1);

namespace App\Routing\Middleware;

use Cake\Core\Configure;
use Cake\I18n\I18n;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Routing\Exception\FailedRouteCacheException;
use Cms\Model\Table\SitesTable;
use Cms\Routing\Middleware\Exception\FailedCmsSiteException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocaleMiddleware implements MiddlewareInterface
{


    public function __construct(array $options = [])
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        // @todo needs refactor of primary language usage
         $ourLocaleHeader = $request->getHeaderLine('X-Winston-Locale');
         if ($ourLocaleHeader) {
             I18n::setLocale($ourLocaleHeader);
         }
        return $handler->handle($request);
    }
}
