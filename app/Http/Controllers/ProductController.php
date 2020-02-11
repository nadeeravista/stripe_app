<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ProductController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $productService = new ProductService();
        $products = $productService->all();
        return view('product.index')
                        ->with('products', $products);
    }

    /**
     * Show the form for creating a new product.
     *
     * @return Response
     */
    public function create() {

        $productService = new ProductService();
        return view('product.create')
                        ->with('productCategory', $productService->getProductCategories());
    }

    /**
     * Store a new product.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|unique:products|max:255',
            'unit_price' => 'required|numeric',
            'quantity' => 'required:numeric',
            'image' => 'required|mimes:png'
        ]);

        $productService = new ProductService();
        $productService->store($request->all());
        Session::flash('message', 'Product successfully added');
        return redirect("product");
    }

    /**
     * Show the form for editing the product.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        $productService = new ProductService();
        $product = $productService->find($id);

        return view('product.edit')
                        ->with('product', $product)
                        ->with('productCategory', $productService->getProductCategories());
    }

    /**
     * Update the product.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $data = Input::all();
        $validator = Validator::make($data, [
                    'name' => "required|unique:products,name,$id",
                    'unit_price' => 'required|numeric',
                    'quantity' => 'required:numeric'
        ]);

        if ($validator->fails()) {
            return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $productService = new ProductService();
        $data['id'] = $id;
        $productService->update($data);
        Session::flash('message', 'Product successfully updated');
        return redirect("product");
    }

    /**
     * Remove a product.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        $productService = new ProductService();
        $product = $productService->delete($id);
       
        Session::flash('message', 'Product successfully deleted');
        return redirect("product");
    }

    /**
     * 
     * @param type $id
     * @return image
     */
    public function getProductImage($id) {
        $productService = new ProductService();
        $product = $productService->find($id);

        return response()->make($product->image, 200, array(
                    'Content-Type' => (new \finfo(FILEINFO_MIME))->buffer($product->image)
        ));
    }

}
