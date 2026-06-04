<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request, $table = null)
    {
        // Jika tidak ada table parameter (dari QR scan langsung), tampilkan form input meja
        if (!$table && !$request->has('table')) {
            return view('welcome');
        }

        $table = $table ?? $request->input('table');
        $category = $request->input('category', 'makanan');

        $makanan = Menu::byCategory('makanan')->orderBy('name')->get();
        $minuman = Menu::byCategory('minuman')->orderBy('name')->get();

        $menus = $category === 'minuman' ? $minuman : $makanan;

        return view('menu.index', compact('menus', 'table', 'category', 'makanan', 'minuman'));
    }
}
