<?php
namespace ProVision\Pages;

use ProVision\Administration\Contracts\Module;

class Administration implements Module {

    public function routes($module) {
        \Route::resource('pages', 'ProVision\Pages\Http\Controllers\Admin\PagesController');
    }

    public function dashboard($module) {
        //
    }

    public function menu($module) {
        //root menu
        $moduleMenu = \Administration::getMenuInstance()->add(trans('pages::admin.module_name'), [
            'route' => \Administration::routeName('pages.index')
        ])
            ->data('order', 9002)
            ->data('icon', 'file-text-o');

        //sub menu
        $moduleMenu->add(trans('pages::admin.list'), ['route' => \Administration::routeName('pages.index')])->data('icon', 'list');
        $moduleMenu->add(trans('pages::admin.add'), ['route' => \Administration::routeName('pages.create')])->data('icon', 'plus');
    }


}