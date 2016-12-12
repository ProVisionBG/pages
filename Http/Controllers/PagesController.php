<?php

/*
 * ProVision Administration, http://ProVision.bg
 * Author: Venelin Iliev, http://veneliniliev.com
 */

namespace ProVision\Pages\Http\Controllers;

use Illuminate\Http\Request;
use ProVision\Pages\Models\Pages;
use App\Http\Controllers\BaseController;
use ProVision\Administration\Facades\Administration;

class PagesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Pages::whereHas('translations', function ($query) use ($slug) {
            $query->where('locale', Administration::getLanguage())
                ->where('slug', $slug);
        })->with(['media'])
            ->active()
            ->first();

        if (empty($page)) {
            return back();
        }
      //  dd($page->media);
        if (! $page->media->isEmpty()) {
            $image = asset($page->media[0]->path.$page->media[0]->file);
        } else {
            $image = '';
        }

        $this->setMeta($page->title, $page->meta_description, $page->meta_keyword, $image);

        return view('pages::show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
