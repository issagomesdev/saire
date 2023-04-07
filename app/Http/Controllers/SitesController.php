<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Menu;
use DB;

class SitesController extends Controller
{
    public function index()
    {
        $publications = Publication::orderBy('created_at', 'desc')->limit(10)->get();
        $features = Publication::where("status", 1)->limit(10)->orderBy('created_at', 'desc')->get();
        $categories = Category::get();
        $galleries = Gallery::orderBy('created_at', 'desc')->limit(10)->get();
        $menus = Menu::with(['submenuses', 'page'])->orderBy('position')->get();
        
        return view('site.index', compact('publications', 'features', 'categories', 'galleries', 'menus'));
    }

    public function galleries()
    {
        $galleries = Gallery::with(['categories'])->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::get();
        $menus = Menu::with(['submenuses', 'page'])->orderBy('position')->get();
        return view('site.galleries.index', compact('galleries', 'categories', 'menus'));
    }

    public function publications(Request $request)
    {
        $publications = Publication::with(['categories'])->orderBy('created_at', 'desc')->paginate(12);   
        $categories = Category::get();
        $menus = Menu::with(['submenuses', 'page'])->orderBy('position')->get();
        // dd($publications);
        
        return view('site.publications.index', compact('publications', 'categories', 'menus'));
    }

    public function show($title, Request $request)
    {
        $publication = Publication::with(['categories'])
        ->where("title", str_replace("_", " ", $title))
        ->first();
        $next = Publication::where('created_at', '>', $publication->created_at)->orderBy('created_at')->first();
        $previus = Publication::where('created_at', '<', $publication->created_at)->orderBy('created_at', 'desc')->first();
        $menus = Menu::with(['submenuses', 'page'])->orderBy('position')->get();
        return view('site.publications.show', compact('publication', 'next', 'previus', 'menus'));
    }

    public function page($title, Request $request)
    {
        $page = Page::where("title", str_replace("_", " ", $title))->first();
        $menus = Menu::with(['submenuses', 'page'])->orderBy('position')->get();
        
        return view('site.page', compact('page', 'menus'));
    }
}



