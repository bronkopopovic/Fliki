<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Save a page.
     *
     * @param Request $request
     *
     * @return string
     */
    public function save(Request $request)
    {
        $content = $request->input('content');
        $title = $request->input('title');
        $path = $request->input('path');
        $page = new Page();
        $page->path = $path;
        $page->title = $title;
        $page->content = $content;
        $page->save();
        return response()->json(['message' => 'Page saved']);
    }

    /**
     * Get pages file tree.
     *
     * @return string
     */
    public function getTree()
    {
        return response()->json(Page::getTree());
    }
}

