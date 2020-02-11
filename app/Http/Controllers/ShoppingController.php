<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\ShoppingCartService;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller {

    /**
     * Display a listing of the products.
     *
     * @return Response
     */
    public function index() {
        $productService = new ProductService();
        $cartService = new ShoppingCartService();
        $products = $productService->getAllAvaialble();
        $cartItems = $cartService->getItems();

        return view('shopping.index')
                        ->with('products', $products)
                        ->with('itemCountInCart', $cartItems->count());
    }

    /**
     * Add products to cart
     * @param Request $request
     * @return Response
     */
    public function addToCart(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, [
                    'quantity' => 'required:numeric|min:1|max:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $shoppingCartService = new ShoppingCartService();

        if ($shoppingCartService->addToCart($data)) {
            return redirect()->back()
                            ->with("success", "Successfully added to Cart");
        } else {
            $validator->errors()->add("quantity","Insufficant quantity");
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }
    }

    /**
     * 
     * @param type $id
     * @return Response
     */
    public function removeFromCart($id) {

        $shoppingCartService = new ShoppingCartService();
        $shoppingCartService->removeFromCart($id);
        return redirect()->back()
                        ->with("success", "Successfully delete from Cart");
    }

    /**
     * @return Response
     */
    public function viewCart() {

        $shoppingCartService = new ShoppingCartService();
        $cartItems = $shoppingCartService->getItems();
        $cartTotal = $shoppingCartService->getCartTotal();

        return view('shopping.cart')
                        ->with('cartItems', $cartItems)
                        ->with('cartTotal', $cartTotal)
                        ->with('itemCountInCart', $cartItems->count());
    }

    public function getCheckout() {
        $shoppingCartService = new ShoppingCartService();

        return view('shopping.checkout')
                        ->with('total', $shoppingCartService->getCartTotal());
    }

    /**
     * 
     * @param Request $request
     * @return Response
     */
    public function postCheckout(Request $request) {

        $shoppingCartService = new ShoppingCartService();
        $data = $request->all();
        if(!$shoppingCartService->chekout($data)){
            return redirect('checkout')->with('error', "Payment not successful");
        }
        
        return view('shopping.payment_success')
                        ->with("success", "Successfully added to Cart");
    }
    
    /**
     * 
     * @return Response
     */
    public function viewOrders(){
        $shoppingCartService = new ShoppingCartService();
        $cartItems = $shoppingCartService->getItems();
        return view('shopping.orders')
                        ->with("orders", $shoppingCartService->getAllOrders())
                        ->with('itemCountInCart', $cartItems->count());
    }
    
    /**
     * 
     * @param type $id
     * @return image
     */
    public function getProductImage($id) {
        $shoppingCartService = new ShoppingCartService();
        $orderItem = $shoppingCartService->getOrderItem();

        return response()->make($orderItem->image, 200, array(
                    'Content-Type' => (new \finfo(FILEINFO_MIME))->buffer($product->image)
        ));
    }

}
