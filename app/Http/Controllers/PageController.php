<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

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
     * Get a page.
     *
     * @return string
     */
    public function get(Request $request)
    {
        $path = explode('/', $request->input('path'));
        try{
            return response()->json([
                'title' => str_replace('.md', '', end($path)),
                'content' => Page::get($request->input('path'))
            ]);
        } catch(\Exception $e){
            return response()->json(['error' => 'Page not found'], 404);
        }
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
        $page = new Page();
        $page->path = $request->input('path');
        $page->title = $request->input('title');
        $page->content = $request->input('content');
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

