<?php

use Formwork\Http\JsonResponse;
use Formwork\Http\RedirectResponse;
use Formwork\Http\Request;
use Formwork\Http\ResponseStatus;
use Formwork\Pages\Site;
use Formwork\Panel\Panel;
use Formwork\Security\CsrfToken;
use Formwork\Translations\Translations;
use Formwork\Utils\FileSystem;

return [
    'routes' => [
        'panel.index' => [
            'path'   => '/',
            'action' => fn (Panel $panel) => new RedirectResponse($panel->uri('/dashboard/')),
        ],

        'panel.login' => [
            'path'    => '/login/',
            'action'  => 'Formwork\Panel\Controllers\AuthenticationController@login',
            'methods' => ['GET', 'POST'],
        ],

        'panel.logout' => [
            'path'   => '/logout/',
            'action' => 'Formwork\Panel\Controllers\AuthenticationController@logout',
        ],

        'panel.backup.make' => [
            'path'    => '/backup/make/',
            'action'  => 'Formwork\Panel\Controllers\BackupController@make',
            'methods' => ['POST'],
            'types'   => ['XHR'],
        ],

        'panel.backup.download' => [
            'path'    => '/backup/download/{backup}/',
            'action'  => 'Formwork\Panel\Controllers\BackupController@download',
            'methods' => ['GET', 'POST'],
        ],

        'panel.backup.delete' => [
            'path'    => '/backup/delete/{backup}/',
            'action'  => 'Formwork\Panel\Controllers\BackupController@delete',
            'methods' => ['POST'],
        ],

        'panel.cache.clear' => [
            'path'    => '/cache/clear/{type}?/',
            'action'  => 'Formwork\Panel\Controllers\CacheController@clear',
            'methods' => ['POST'],
            'types'   => ['XHR'],
        ],

        'panel.dashboard' => [
            'path'   => '/dashboard/',
            'action' => 'Formwork\Panel\Controllers\DashboardController@index',
        ],

        'panel.options' => [
            'path'   => '/options/',
            'action' => 'Formwork\Panel\Controllers\OptionsController@index',
        ],

        'panel.options.system' => [
            'path'    => '/options/system/',
            'action'  => 'Formwork\Panel\Controllers\OptionsController@systemOptions',
            'methods' => ['GET', 'POST'],
        ],

        'panel.options.site' => [
            'path'    => '/options/site/',
            'action'  => 'Formwork\Panel\Controllers\OptionsController@siteOptions',
            'methods' => ['GET', 'POST'],
        ],

        'panel.pages' => [
            'path'   => '/pages/',
            'action' => 'Formwork\Panel\Controllers\PagesController@index',
        ],

        'panel.tools' => [
            'path'   => '/tools/',
            'action' => 'Formwork\Panel\Controllers\ToolsController@index',
        ],

        'panel.tools.backups' => [
            'path'   => '/tools/backups/',
            'action' => 'Formwork\Panel\Controllers\ToolsController@backups',
        ],

        'panel.tools.updates' => [
            'path'   => '/tools/updates/',
            'action' => 'Formwork\Panel\Controllers\ToolsController@updates',
        ],

        'panel.tools.info' => [
            'path'   => '/tools/info/',
            'action' => 'Formwork\Panel\Controllers\ToolsController@info',
        ],

        'panel.pages.new' => [
            'path'    => '/pages/new/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@create',
            'methods' => ['POST'],
        ],

        'panel.pages.edit' => [
            'path'    => '/pages/{page}/edit/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@edit',
            'methods' => ['GET', 'POST'],
        ],

        'panel.pages.edit.lang' => [
            'path'    => '/pages/{page}/edit/language/{language}/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@edit',
            'methods' => ['GET', 'POST'],
        ],

        'panel.pages.reorder' => [
            'path'    => '/pages/reorder/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@reorder',
            'methods' => ['POST'],
            'types'   => ['XHR'],
        ],

        'panel.pages.uploadfile' => [
            'path'    => '/pages/{page}/file/upload/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@uploadFile',
            'methods' => ['POST'],
        ],

        'panel.pages.deletefile' => [
            'path'    => '/pages/{page}/file/{filename}/delete/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@deleteFile',
            'methods' => ['POST'],
        ],

        'panel.pages.renameFile' => [
            'path'    => '/pages/{page}/file/{filename}/rename/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@renameFile',
            'methods' => ['POST'],
        ],

        'panel.pages.replaceFile' => [
            'path'    => '/pages/{page}/file/{filename}/replace/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@replaceFile',
            'methods' => ['POST'],
        ],

        'panel.pages.file' => [
            'path'    => '/pages/{page}/file/{filename}/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@file',
            'methods' => ['GET'],
        ],

        'panel.pages.delete' => [
            'path'    => '/pages/{page}/delete/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@delete',
            'methods' => ['POST'],
        ],

        'panel.pages.delete.lang' => [
            'path'    => '/pages/{page}/delete/language/{language}/',
            'action'  => 'Formwork\Panel\Controllers\PagesController@delete',
            'methods' => ['POST'],
        ],

        'panel.updates.check' => [
            'path'    => '/updates/check/',
            'action'  => 'Formwork\Panel\Controllers\UpdatesController@check',
            'methods' => ['POST'],
            'types'   => ['XHR'],
        ],

        'panel.updates.update' => [
            'path'    => '/updates/update/',
            'action'  => 'Formwork\Panel\Controllers\UpdatesController@update',
            'methods' => ['POST'],
            'types'   => ['XHR'],
        ],

        'panel.statistics' => [
            'path'   => '/statistics/',
            'action' => 'Formwork\Panel\Controllers\StatisticsController@index',
        ],

        'panel.users' => [
            'path'   => '/users/',
            'action' => 'Formwork\Panel\Controllers\UsersController@index',
        ],

        'panel.users.new' => [
            'path'    => '/users/new/',
            'action'  => 'Formwork\Panel\Controllers\UsersController@create',
            'methods' => ['POST'],
        ],

        'panel.users.delete' => [
            'path'    => '/users/{user}/delete/',
            'action'  => 'Formwork\Panel\Controllers\UsersController@delete',
            'methods' => ['POST'],
        ],

        'panel.users.profile' => [
            'path'    => '/users/{user}/profile/',
            'action'  => 'Formwork\Panel\Controllers\UsersController@profile',
            'methods' => ['GET', 'POST'],
        ],

        'panel.register' => [
            'path'    => '/register/',
            'action'  => 'Formwork\Panel\Controllers\RegisterController@register',
            'methods' => ['GET', 'POST'],
        ],

        'panel.errors.notfound' => [
            'path'   => '/{route}/',
            'action' => 'Formwork\Panel\Controllers\ErrorsController@notFound',
        ],
    ],

    'filters' => [
        'panel.request.validateSize' => [
            'action' => static function (Request $request, Translations $translations, Panel $panel) {
                // Validate HTTP request Content-Length according to `post_max_size` directive
                if ($request->contentLength() !== null) {
                    $maxSize = FileSystem::shorthandToBytes(ini_get('post_max_size') ?: '0');

                    if ($request->contentLength() > $maxSize && $maxSize > 0) {
                        $panel->notify(
                            $translations->getCurrent()->translate('panel.request.error.postMaxSize'),
                            'error'
                        );
                        return new RedirectResponse($panel->uri());
                    }
                }
            },
            'methods' => ['POST'],
            'types'   => ['HTTP', 'XHR'],
        ],

        'panel.request.validateCsrf' => [
            'action' => static function (Request $request, Translations $translations, Panel $panel, CsrfToken $csrfToken) {
                $tokenName = $panel->getCsrfTokenName();
                $token = (string) $request->input()->get('csrf-token');

                if (!$csrfToken->validate($tokenName, $token)) {
                    $csrfToken->destroy($tokenName);
                    $request->session()->remove('FORMWORK_USERNAME');

                    $panel->notify(
                        $translations->getCurrent()->translate('panel.login.suspiciousRequestDetected'),
                        'warning'
                    );

                    if ($request->isXmlHttpRequest()) {
                        return JsonResponse::error('Bad Request: the CSRF token is not valid', ResponseStatus::BadRequest);
                    }

                    return new RedirectResponse($panel->uri('/login/'));
                }
            },
            'methods' => ['POST'],
            'types'   => ['HTTP', 'XHR'],
        ],

        'panel.register' => [
            'action' => static function (Request $request, Site $site, Panel $panel) {
                // Register panel if no user exists
                if ($panel->users()->isEmpty()) {
                    if (!$request->isLocalhost()) {
                        return new RedirectResponse($site->uri());
                    }

                    if ($panel->route() !== '/register/') {
                        return new RedirectResponse($panel->uri('/register/'));
                    }
                }
            },
            'methods' => ['GET', 'POST'],
        ],

        'panel.redirectToLogin' => [
            'action' => static function (Request $request, Panel $panel) {
                // Redirect to login if no user is logged
                if (!$panel->users()->isEmpty() && !$panel->isLoggedIn() && $panel->route() !== '/login/') {
                    $request->session()->set('FORMWORK_REDIRECT_TO', $panel->route());
                    return new RedirectResponse($panel->uri('/login/'));
                }
            },
        ],
    ],
];
