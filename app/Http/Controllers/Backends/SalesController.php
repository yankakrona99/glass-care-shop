<?php

namespace App\Http\Controllers\Backends;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;

class SalesController extends Controller
{
    public function __construct(
        Category $category,
        Product $product,
        Customer $customer
    ) {
        $this->category = $category;
        $this->product = $product;
        $this->customer = $customer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
          
            return view('backends.sales.index', [
                'request' => $request,
            ]);
        } catch (\ValidationException $e) {
            return exceptionError($e, 'backends.sales.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $categories = $this->category->getCategoryNameByProducts();
            $customers = $this->customer->getCustomer();
            return view('backends.sales.create', [
                'request' => $request,
                'categories' => $categories,
                'customers' => $customers
            ]);
        } catch (\ValidationException $e) {
            return exceptionError($e, 'backends.sales.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Rules of field
            
            $rules = [
               
            ];
            // Set field of Validattion
            $validator = \Validator::make([
               
            ], $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                
                return \Redirect::route('sale.create')
                    ->with('success', __('flash.store'));
            }
        } catch (\ValidationException $e) {
            return exceptionError($e, 'customers.create');
        }
    }

    public function getProductByCategory(Request $request)
    {
        $productOrders = [];
        try {
            $productOrders = $this->product->where('is_delete', '<>', 0)
                ->where('is_active', 1) // is_delete = 1 and is_active = 1
                ->where('category_id', $request->category_id)
                ->select(['id', 'category_id', 'title', 'price', 'in_store', 'thumbnail'])
                ->orderBy('id', 'DESC')
                ->get();
            return response()
                ->json([
                    'productOrders' => $productOrders,
                    'code' => 200,
                    'status'  => 'success'
                ]);
        } catch (Exception $e) {
            return response()
                ->json([
                    'status'  => 'fail',
                    'message' => $e->getMessage()
                ]);
        }
    }
    
}
