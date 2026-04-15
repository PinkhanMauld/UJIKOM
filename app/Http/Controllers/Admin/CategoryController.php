<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Division;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('items')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::all();
        return view('admin.categories.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
            'division_id' => 'required',
        ], [
            'name.unique' => 'Kategori sudah ada.',
        ]);

        Category::create([
            'name' => $request->name,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findorFail($id);
        $divisions = Division::all();

        return view('admin.categories.edit', compact('category', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
            'division_id' => 'required',
        ], [
            'name.unique' => 'Kategori sudah dipakai.',
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name,
            'division_id' => $request->division_id,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findorFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category berhasil di hapus!');

    }
}