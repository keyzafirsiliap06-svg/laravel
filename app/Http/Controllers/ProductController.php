<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function apiData()
    {
        // Mengurutkan produk berdasarkan ID terkecil
        $products = Product::orderBy('id', 'asc')->get();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Menyimpan gambar
        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        // Menyimpan produk ke database
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $image,
        ]);

        if ($product) {
            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
        }

        return back()->with('error', 'Produk gagal ditambahkan!');
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
    // Mengambil data produk yang akan diedit
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    // Memperbarui data produk
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Menyiapkan data yang akan diperbarui
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        // Jika pengguna mengunggah gambar baru
        if ($request->hasFile('image')) {

            // Hapus gambar lama
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru
            $data['image'] = $request->file('image')
                ->store('products', 'public');
        }

        // Simpan perubahan
        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Menghapus gambar produk dari storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Menghapus data produk dari database
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus!'
        ]);
    }
}
