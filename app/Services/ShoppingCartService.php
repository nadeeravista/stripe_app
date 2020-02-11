<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Cart;
use GuzzleHttp\Client;
use App\OrderItem;
use App\Order;
use Stripe\Charge;
use Stripe\Stripe;

/**
 * Description of ProductService
 *
 * @author nadeerathilak
 */
class ShoppingCartService {

    /**
     * 
     * @param type $data request data
     * @return bool
     */
    public function addToCart($data) {
        $cart = new Cart();
        $cart->product_id = $data['product_id'];
        $inventoryblance = $cart->product->quantity - $data['quantity'];

        if ($inventoryblance >= 0) {

            $cart->quantity = $data['quantity'];
            $total = $data['quantity'] * $cart->product->unit_price;

            $cart->unit_price = $cart->product->unit_price;
            $cart->total = $total;
            $cart->product->quantity = $cart->product->quantity - $data['quantity'];
            $cart->product->save();
            return $cart->save();
        } else {
            return false;
        }
    }

    /**
     * 
     * @return array
     */
    public function getItems() {
        $cart = new Cart();
        return $cart->all();
    }

    /**
     * 
     * @return decimal
     */
    public function getCartTotal() {
        $total = 0;
        foreach ($this->getItems() as $item) {
            $total += $item->total;
        }
        $total = number_format($total, 2);
        return $total;
    }

    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function removeFromCart($id) {
        $cart = new Cart();
        $cart = $cart->find($id);
        if($cart->product){
            $cart->product->quantity = $cart->product->quantity + $cart->quantity;
            $cart->product->save();
        }
        return $cart->delete();
    }

    /**
     * 
     * @return boolean
     */
    public function createOrder() {

        $order = new Order();
        $order->status = "PAYMENT SUCCESSFUL";
        $order->payment = $this->getCartTotal();
        $order->date_time = date("Y-m-d H:i:s");
        $order->save();

        $cartItems = $this->getItems();
        foreach ($cartItems as $cartItem) {

            $orderItem = new OrderItem();
            $orderItem->name = $cartItem->product->name;
            $orderItem->description = $cartItem->product->description;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->unit_price = $cartItem->product->unit_price;
            $orderItem->total = $orderItem->unit_price * $orderItem->quantity;
            $orderItem->image = $cartItem->product->image;
            $orderItem->image_extension = $cartItem->product->image_extension;

            $order->items()->save($orderItem);
            $cartItem->delete();
        }

        return true;
    }

    /**
     * 
     * @return array of Order
     */
    public function getAllOrders() {
        $order = new Order();
        return $order->all();
    }

    /**
     * 
     * @return array of Order
     */
    public function getOrderItem($id) {
        $item = new OrderItem();
        return $item->find($id);
    }

    /**
     * 
     * @return boolean
     */
    public function chekout($data) {

        if ($this->doPayment($data)) {
            $this->createOrder();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function doPayment($data) {

        Stripe::setApiKey(config('cart_settings.sripe_prvate_key'));
        try {
            Charge::create(array(
                "amount" => $this->getCartTotal() * 100,
                "currency" => strtolower(config('cart_settings.currency')),
                "source" => $data['stripeToken'],
                "description" => "Test Charge"
            ));
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

}
