<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index($table)
    {
        $menus = Menu::all();

        return view('menu.index', compact('menus', 'table'));
    }
}
