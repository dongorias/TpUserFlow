<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::all();
        return view('menus.list', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menus.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'intitule' => 'required|string',
            'lien' => 'required|string',
        ]);

        $count = Menu::count();
         Menu::create([
            'intitule' => $request->intitule,
            'lien' => $request->lien,
            'ordre' => $count+1,
        ]);

        return redirect()->route('menus.index')
            ->with('success', 'Menus created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $id)
    {
        $menu = Menu::find($id);
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        return view('menus.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $menu = Menu::find($id);
        $menu->intitule = $request->intitule;
        $menu->lien = $request->lien;
        $menu->save();
        return redirect()->route('menus.index')
            ->with('success', 'Menus updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $menu = Menu::find($id);
        $menu->delete();
        return redirect()->route('menus.index')
            ->with('success', 'Menu deleted successfully');
    }

    public function content(int $id)
    {
        $menu = Menu::find($id);

        return view('menus.menu-content', compact('menu'));
    }

    public function updateMenuOrder($items)
    {
        foreach ($items as $item) {
            Menu::find($item['value'])->update(['ordre_position' => $item['ordre']]);
        }
    }
}
