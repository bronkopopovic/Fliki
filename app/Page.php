<?php

namespace App;

use GrahamCampbell\Flysystem\Facades\Flysystem as Fly;

class Page
{
    public $path;
    public $title;
    public $content;

    /**
     * Get pages file tree.
     *
     * @return array
     */
    public static function getTree()
    {
        $branches = Fly::listContents('/pages', true);
        $tree = self::buildTree($branches);
        return $tree;
    }

    /**
     * Build file tree.
     *
     * @param array $branches
     *
     * @return array
     */
    private static function buildTree($branches)
    {
        $tree = [];
        foreach($branches as $branch){
            $children =& $tree;
            foreach(explode('/', $branch['path']) as $label){
                if(!isset($children[$label])){
                    $children[$label] = [
                        'data' => $branch
                    ];
                }
                $children =& $children[$label]['children'];
            }
        }
        return $tree;
    }

    /**
     * Save a page.
     *
     * @return void
     */
    public function save()
    {
        Fly::put($this->path.'/'.strval($this->title).'.md', $this->content);
    }
}
