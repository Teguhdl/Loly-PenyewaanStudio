<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Categories\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->middleware(['auth','role:admin']);
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->service->all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        $this->service->create($request->only('name','description'));
        return redirect()->route('admin.categories.index')->with('success','Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->service->find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
            'description' => 'nullable|string',
        ]);

        $this->service->update($id, $request->only('name','description'));
        return redirect()->route('admin.categories.index')->with('success','Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('admin.categories.index')->with('success','Kategori berhasil dihapus.');
    }
}
