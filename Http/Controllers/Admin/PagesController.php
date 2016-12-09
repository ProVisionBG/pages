<?php

namespace App\Modules\Pages\Http\Controllers\Admin;

use App\Http\Requests;
use App\Modules\Pages\Models\Pages;
use Datatables;
use Form;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use ProVision\Administration\Facades\Administration;
use ProVision\Administration\Http\Controllers\BaseAdministrationController;

class PagesController extends BaseAdministrationController {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->ajax()) {
            $pages = Pages::withTranslation()->defaultOrder();
            $datatables = Datatables::of($pages)
                ->editColumn('title', function ($page) {
                    return $page->title . ' <a href="' . Administration::route('pages.index', ['parent_id' => $page->id]) . '"><i class="fa fa-share" aria-hidden="true"></i></a>';
                })
                ->addColumn('action', function ($page) {
                    $actions = '';
                    if (!empty($page->deleted_at)) {
                        //restore button
                    } else {
                        $actions .= Form::adminDeleteButton(trans('administration::index.delete'), Administration::route('pages.destroy', $page->id));
                    }
                    $actions .= Form::adminMediaButton($page, 'pages') . Form::adminOrderButton($page);
                    return Form::adminEditButton(trans('administration::index.edit'), Administration::route('pages.edit', $page->id)) . $actions;
                })
                ->addColumn('visible', function ($page) {
                    return Form::adminSwitchButton('visible', $page);
                })
                ->addColumn('show_media', function ($page) {
                    return Form::adminSwitchButton('show_media', $page);
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('parent_id')) {
                        $query->where('parent_id', $request->input('parent_id'));
                    } else {
                        $query->whereNull('parent_id');
                    }
                });

            return $datatables->make(true);
        }

        Administration::setTitle(trans('pages::admin.module_name'));

        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('pages::admin.module_name'), Administration::route('pages.index'));
        });

        $table = Datatables::getHtmlBuilder()
            ->addColumn([
                'data' => 'id',
                'name' => 'id',
                'title' => trans('administration::administrators.id')
            ])->addColumn([
                'data' => 'title',
                'name' => 'title',
                'title' => trans('administration::administrators.name')
            ])->addColumn([
                'data' => 'visible',
                'name' => 'visible',
                'title' => 'visible'
            ])->addColumn([
                'data' => 'show_media',
                'name' => 'show_media',
                'title' => 'show_media'
            ])->addColumn([
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => trans('pages::admin.date')
            ]);

        return view('administration::empty-listing', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder) {
        $form = $formBuilder->create(\App\Modules\Pages\Forms\PageForm::class, [
                'method' => 'POST',
                'url' => Administration::route('pages.store'),
                'role' => 'form',
                'id' => 'formID'
            ]
        );
        Administration::setTitle(trans('pages::admin.create'));
        \Breadcrumbs::register('admin_final', function ($breadcrumbs) {
            $breadcrumbs->parent('admin_home');
            $breadcrumbs->push(trans('pages::admin.module_name'), Administration::route('pages.index'));
            $breadcrumbs->push(trans('pages::admin.create'), Administration::route('pages.create'));
        });
        return view('administration::empty-form', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $page = new Pages();
        if ($page->validate($request->all())) {
            $page->fill($request->all());
            $page->save();

            return \Redirect::route(Administration::routeName('pages.index'));

        } else {
            return \Redirect::route(Administration::routeName('pages.create'))
                ->withInput()
                ->withErrors($page->getValidationErrors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder) {
        $page = Pages::where('id', $id)->first();

        if (!empty($page)) {
            $form = $formBuilder->create(\App\Modules\Pages\Forms\PageForm::class, [
                    'method' => 'PUT',
                    'url' => Administration::route('pages.update', $page->id),
                    'model' => $page
                ]
            );

            Administration::setTitle(trans('pages::admin.edit') . ' - ' . $page->title);

            \Breadcrumbs::register('admin_final', function ($breadcrumbs) use ($page) {
                $breadcrumbs->parent('admin_home');
                $breadcrumbs->push(trans('pages::admin.module_name'), Administration::route('pages.index'));
                $breadcrumbs->push($page->title, Administration::route('pages.edit', $page->id));
            });

            return view('administration::empty-form', compact('form'));
        } else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $page = Pages::where('id', $id)->first();

        if ($page->validate($request->all())) {
            $page->fill($request->all());

            $page->save();
            return \Redirect::route(Administration::routeName('pages.index'));

        } else {
            return \Redirect::route(Administration::routeName('pages.create'))
                ->withInput()
                ->withErrors($page->getValidationErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $page = Pages::findOrFail($id);
        $page->delete();
        return response()->json(['ok'], 200);
    }
}
