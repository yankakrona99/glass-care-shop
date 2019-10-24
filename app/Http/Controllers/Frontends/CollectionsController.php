<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    /**
     * Show the application collection.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCollection()
    {
        try {
            $slug = 'iphone-x';
            return view('frontends.pages.collections.index', [
                'slug' => $slug,
            ]);
        } catch (\ValidationException $e) {
            return exceptionError($e, 'frontends.pages.collections.index');
        }
    }

    /**
     * Show the application collection.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCollectionBySlug($slug)
    {
        try {
            return view('frontends.pages.collections.collection-detail', [
                'slug' => $slug,
            ]);
        } catch (\ValidationException $e) {
            return exceptionError($e, 'frontends.pages.collections.collection-detail');
        }
    }
}