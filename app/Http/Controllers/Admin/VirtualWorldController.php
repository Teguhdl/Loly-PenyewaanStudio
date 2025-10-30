<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\VirtualWorlds\Services\VirtualWorldService;
use Illuminate\Http\Request;
use App\Domain\Categories\Services\CategoryService;
use App\Models\Category;
use App\Models\VirtualWorld;
use Illuminate\Support\Str;

class VirtualWorldController extends Controller
{
    protected $service;
    protected $categoryService;

    public function __construct(VirtualWorldService $service, CategoryService $categoryService)
    {
        $this->service = $service;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $virtualWorlds = $this->service->all();
        return view('admin.virtual_worlds.index', compact('virtualWorlds'));
    }

    public function create()
    {
        $categories = $this->categoryService->all();

        do {
            $code = 'VW-' . strtoupper(Str::random(5));
        } while (VirtualWorld::where('code', $code)->exists());

        return view('admin.virtual_worlds.create', compact('categories', 'code'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:virtual_worlds,code',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4072', // ✅
            'is_rented' => 'boolean',
            'is_available' => 'boolean',
            'categories' => 'required|array|min:1'
        ]);

        $this->service->create($request->all());
        return redirect()->route('admin.virtual_worlds.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $virtualWorld = $this->service->find($id);
        $categories = Category::all();
        return view('admin.virtual_worlds.edit', compact('virtualWorld', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:virtual_worlds,code,' . $id,
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // ✅
            'is_rented' => 'boolean',
            'is_available' => 'boolean',
            'categories' => 'required|array|min:1'
        ]);

        $this->service->update($id, $request->all());
        return redirect()->route('admin.virtual_worlds.index')->with('success', 'Unit berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('admin.virtual_worlds.index')->with('success', 'Unit berhasil dihapus.');
    }
}
