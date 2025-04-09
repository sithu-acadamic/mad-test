<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Traits\Admin\ProductTrait;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ProductTrait;

    public function index()
    {
        return view('admin.products.index');
    }

    public function getResultData(Request $request)
    {
        parse_str($request['f'], $filter_fld);
        $mainFilter = [];

        //ASSIGN TO FILTER ARRAYS
        $mainFilter = $this->setFeildArrays(array('feild_name' => $filter_fld['pr_name'], 'column_name' => 'name', 'operator' => 'LIKE', 'search' => 'both', 'type' => 'string'), $mainFilter);
        $mainFilter = $this->setFeildArrays(array('feild_name' => $filter_fld['pr_price'], 'column_name' => 'price', 'operator' => 'LIKE', 'search' => 'both', 'type' => 'string'), $mainFilter);

        //COOMON FILTER ARRY TO GET RESULT
        $filter_arr[0] = array('level' => 1, 'filter' => $mainFilter, 'rel' => '', 'parent' => '');

        //MODEL
        $model = new Product();

        //RELATIONS ->with()
        $relations = [];

        //CONDITION ARRY ->where()
        $conditions = [];

        //ORDER BY ->orderby()
        $order_by[] = ['column' => 'name', 'direction' => 'ASC'];

        //PARAMETER LIST ARRAY
        $param = array(
            'model' => $model,
            'relations' => $relations,
            'conditions' => $conditions,
            'filter_fld' => $filter_fld,
            'filter_arr' => $filter_arr,
            'order_by' => $order_by,
            'start' => $request->input('start'),
            'limit' => $request->input('length')
        );

        //FINAL DATA RESULT
        $result = $this->getData($param);

        $count_filter = $this->getFilterRecorders($param);

        return DataTables::of($result)
            ->addIndexColumn()
            ->with([
                "recordsTotal" => $count_filter,
                "recordsFiltered" => $count_filter,
            ])
            ->addColumn('action', function ($result) {
                $path1 = route('admin.product.edit', ['product_id' => Crypt::encrypt($result->id)]);
                return '<a class="btn btn-sm btn-outline-danger btn-circle me-2 delete-product" data-product-id="'.Crypt::encrypt($result->id).'"><i class="dripicons-trash"></i> </a><a class="btn btn-sm btn-outline-success btn-circle me-2 edit-product" href="' . $path1 . '"><i class="dripicons-pencil"></i> </a>';
            })
            ->rawColumns(['action'])
            ->skipPaging()
            ->make(true);
    }

    public function create()
    {
        $types = ProductType::orderBy('name', 'asc')->get();
        $produtCount = Product::count();
        return view('admin.products.create', compact(['types','produtCount']));
    }

    public function save(ProductRequest $request)
    {
        return $this->saveOrUpdateProduct($request);
    }

    public function view(Request $request)
    {
        try {
            $productId = Crypt::decrypt($request->product_id);
            $productData = Product::with('ProductTypes')->find($productId);

            if ($productData === null) {
                return response()->json(['error' => 'Product not found.'], Response::HTTP_NOT_FOUND);
            }

            return view('admin.products.view', compact(['productData', 'productId']));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid product identifier.'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function edit(Request $request)
    {
        try {
            $productId = Crypt::decrypt($request->product_id);
            $product = Product::with('productType')->find($productId);
            $types = ProductType::orderBy('name', 'asc')->get();
            $produtCount = Product::count();

            if ($product === null) {
                return response()->json(['error' => 'Product not found.'], Response::HTTP_NOT_FOUND);
            }

            return view('admin.products.edit', compact(['product', 'productId', 'types','produtCount']));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['error' => 'Invalid product identifier.'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function delete(Request $request)
    {
        return $this->deleteEntity(
            $request->product_id,  // Encrypted ID from the request
            Product::class,        // Model class
            'admin/assets/images/product_images/', // Image path
            'image'                // Image name field in the Product model
        );
    }
}

