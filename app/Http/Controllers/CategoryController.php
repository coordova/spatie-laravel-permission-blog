<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Aplica middleware de autorización a todos los métodos del resource
    public function __construct()
    {
        // Esto usa los métodos de CategoryPolicy automáticamente
//        $this->authorizeResource(Category::class, 'category');
//        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories')); // Necesitarás crear esta vista
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create'); // Necesitarás crear esta vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        // El slug se genera automáticamente por el mutador en el Modelo

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Categoría creada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category')); // Necesitarás crear esta vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            // Asegúrate de ignorar el registro actual al validar unicidad
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);
        // El slug se actualiza automáticamente por el mutador

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoría eliminada.');
    }
}
