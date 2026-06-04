<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuAdminController extends Controller
{
    public function index()
    {
        $makanan = Menu::byCategory('makanan')->orderBy('name')->get();
        $minuman = Menu::byCategory('minuman')->orderBy('name')->get();
        return view('admin.menus.index', compact('makanan', 'minuman'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:100',
            'price'        => 'required|integer|min:0',
            'category'     => 'required|in:makanan,minuman',
            'stock'        => 'required|integer|min:0',
            'description'  => 'nullable|string|max:500',
            'is_available' => 'nullable|boolean',
        ]);

        $data['is_available'] = $request->has('is_available') ? true : false;

        Menu::create($data);

        return back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $data = $request->validate([
            'name'         => 'sometimes|string|max:100',
            'price'        => 'sometimes|integer|min:0',
            'stock'        => 'sometimes|integer|min:0',
            'description'  => 'nullable|string|max:500',
            'is_available' => 'nullable|boolean',
        ]);

        if ($request->has('is_available')) {
            $data['is_available'] = true;
        } elseif ($request->isMethod('put') || $request->isMethod('patch')) {
            $data['is_available'] = false;
        }

        $menu->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'menu' => $menu->fresh()]);
        }

        return back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function updateStock(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $menu->update(['stock' => $request->stock]);

        return response()->json([
            'success' => true,
            'stock'   => $menu->stock,
            'message' => "Stok {$menu->name} diperbarui: {$menu->stock}",
        ]);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus!');
    }
}
