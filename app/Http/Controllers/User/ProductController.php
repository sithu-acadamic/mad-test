<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByRaw('ISNULL(product_index), product_index ASC')->paginate(9);
        $productTypes = ProductType::with('products')->get();
        $randoms = Product::inRandomOrder()->limit(3)->get();
        return view('user.shop.index', compact('products', 'productTypes', 'randoms'));
    }

    public function getProductListByProductType($typeId)
    {
        try {
            $productTypeId = Crypt::decrypt($typeId);
            $productType = ProductType::with('products')->findOrFail($productTypeId);
            $products = $productType->products()->paginate(9);
            $productTypes = ProductType::with('products')->get();
            $randoms = Product::inRandomOrder()->limit(3)->get();
            return view('user.shop.index', compact('products', 'productTypes', 'productTypeId', 'randoms'));
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid product type identifier.');
        }
    }

    public function getProductDetail($productId)
    {
        try {
            $productId = Crypt::decrypt($productId);
            $product = Product::with('productType')->findOrFail($productId);
            $productTypes = ProductType::with('products')->get();
            $relatedProducts = Product::where('product_type', $product->product_type)
                ->where('id', '!=', $productId)
                ->inRandomOrder()
                ->limit(3)
                ->get();
            $randoms = Product::inRandomOrder()->limit(3)->get();
            return view('user.shop.product-detail', compact('product', 'productTypes', 'relatedProducts', 'randoms'));
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Invalid product identifier.');
        }
    }

    public function searchProducts(Request $request)
    {
        $searchTerm = $request->input('search');
        $products = Product::where('name', 'like', '%' . $searchTerm . '%')->paginate(9);
        $productTypes = ProductType::with('products')->get();
        $randoms = Product::inRandomOrder()->limit(3)->get();
        return view('user.shop.index', compact('products', 'productTypes', 'randoms'));
    }
}
