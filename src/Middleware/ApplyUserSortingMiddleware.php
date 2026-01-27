<?php

/*
 * This file is part of glowingblue/save-sorting-preferences.
 *
 * Copyright (c) Glowing Blue AG.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GlowingBlue\SaveSortingPreferences\Middleware;

use Flarum\Http\RequestUtil;
use Flarum\User\Guest;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApplyUserSortingMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $actor = RequestUtil::getActor($request);

        if ($request->getUri()->getPath() !== '/') {
            return $handler->handle($request);
        }

        if ($actor instanceof Guest) {
            return $handler->handle($request);
        }

        $params = $request->getQueryParams();

        $sort = Arr::get($params, 'sort');
        $lastSelectedSort = $actor->getPreference('discussion_sort');

        $request = $request->withQueryParams(
            array_merge($params, [
                'sort' => $sort ?? $lastSelectedSort,
            ])
        );

        return $handler->handle($request);
    }
}
