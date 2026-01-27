<?php

/*
 * This file is part of glowingblue/save-sorting-preferences.
 *
 * Copyright (c) Glowing Blue AG.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GlowingBlue\SaveSortingPreferences;

use Flarum\Extend;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Middleware('forum'))
        ->add(Middleware\ApplyUserSortingMiddleware::class),

    (new Extend\Middleware('api'))
        ->add(Middleware\ApplyUserSortingMiddleware::class),

    (new Extend\User())
        ->registerPreference('discussion_sort'),
];
