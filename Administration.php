<?php

/*
 * ProVision Administration, http://ProVision.bg
 * Author: Venelin Iliev, http://veneliniliev.com
 */

namespace ProVision\Pages;

use Kris\LaravelFormBuilder\Form;
use ProVision\Administration\Contracts\Module;

class Administration implements Module
{
    public function routes($module)
    {
        \Route::resource('pages', 'ProVision\Pages\Http\Controllers\Admin\PagesController');
    }

    public function dashboard($module)
    {
        //
    }

    public function menu($module)
    {
        \AdministrationMenu::addModule(trans('pages::admin.module_name'), [
            'route' => \Administration::routeName('pages.index'),
            'icon' => 'file-text-o'
        ], function ($menu) {
            $menu->addItem(trans('pages::admin.list'), [
                'route' => \Administration::routeName('pages.index')
            ])->addItem(trans('pages::admin.add'), [
                'route' => \Administration::routeName('pages.create')
            ]);
        });
    }

    /**
     * Add settings in administration panel
     * @param $module
     * @param Form $form
     * @return mixed
     */
    public function settings($module, Form $form)
    {
        // TODO: Implement settings() method.
    }
}
