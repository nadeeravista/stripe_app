<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ShoppingCartService;
use Illuminate\Support\Facades\Artisan;

class ShoppingCartServiceTest extends TestCase {

    public function setUp() {
        parent::setUp();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    /**
     * Test if the adding to cart successful
     *
     * @return void
     */
    public function testAddTOCart() {

        $data['product_id'] = 1;
        $data['quantity'] = 2;

        $cartService = new ShoppingCartService();
        $this->assertTrue($cartService->addToCart($data));
        $cartItems = $cartService->getItems();

        $this->assertEquals(sizeof($cartItems), 1);
        $this->assertEquals($cartItems[0]->quantity, 2);
        $this->assertEquals($cartItems[0]->product->name, "Test Product 1");
    }

    /**
     * Check if inventory is deducted when adding items to cart
     *
     * @return void
     */
    public function testAddTOCartReduceInventory() {

        $data['product_id'] = 1;
        $data['quantity'] = 1;

        $cartService = new ShoppingCartService();
        $this->assertTrue($cartService->addToCart($data));
        $cartItems = $cartService->getItems();

        $this->assertEquals(sizeof($cartItems), 1);
        $this->assertEquals($cartItems[0]->quantity, 1);
        $this->assertEquals($cartItems[0]->product->name, "Test Product 1");
        $this->assertEquals($cartItems[0]->product->quantity, 9);

        $this->assertTrue($cartService->addToCart($data));
        $cartItems = $cartService->getItems();
        $this->assertEquals($cartItems[0]->product->quantity, 8);
        
    }
    
    /**
     * Not allowed to add cart more than available inventory
     *
     * @return void
     */
    public function testAddTOCartReduceInventoryInsufficianyQuantity() {

        $data['product_id'] = 1;
        $data['quantity'] = 20;

        $cartService = new ShoppingCartService();
        $this->assertFalse($cartService->addToCart($data));
        
    }
    
    /**
     * Check if the cart total is correct
     *
     * @return void
     */
    public function testCartTotal() {
        
        $data['product_id'] = 1;
        $data['quantity'] = 2;

        $cartService = new ShoppingCartService();
        $this->assertTrue($cartService->addToCart($data));
        
        $this->assertEquals($cartService->getCartTotal(), 200);
        
        $data['product_id'] = 2;
        $data['quantity'] = 2;
        $this->assertTrue($cartService->addToCart($data));
        
        $this->assertEquals($cartService->getCartTotal(), 220.50);
        
    }
    
    /**
     * Check remove from cart
     *
     * @return void
     */
    public function testRemoveFromCart() {
        
        $data['product_id'] = 1;
        $data['quantity'] = 2;

        $cartService = new ShoppingCartService();
        $this->assertTrue($cartService->addToCart($data));
        
        $data['product_id'] = 2;
        $data['quantity'] = 2;
        $this->assertTrue($cartService->addToCart($data));
        $this->assertEquals($cartService->getCartTotal(),220.50);
        $cartItems = $cartService->getItems();
        
        //secondly enterd product id
        $itmeId = $cartItems[1]['id'];
     
        $this->assertTrue($cartService->removeFromCart($itmeId));
        $cartItems = $cartService->getItems();
        
        $this->assertEquals(sizeof($cartItems),1);
        $this->assertEquals($cartService->getCartTotal(),200);
        
    }
    
    /**
     * Testing checkout and create order
     *
     * @return void
     */
    public function testCreateOrder() {
        
        $data['product_id'] = 1;
        $data['quantity'] = 2;

        $cartService = new ShoppingCartService();
        $this->assertTrue($cartService->addToCart($data));
        
        $data['product_id'] = 2;
        $data['quantity'] = 2;
        $this->assertTrue($cartService->addToCart($data));
        
        $orders = $cartService->getAllOrders();
        $this->assertEquals(sizeof($orders),0);
        
        $cartService->createOrder();
        $orders = $cartService->getAllOrders();
        $this->assertEquals(sizeof($orders),1);
        $this->assertEquals($orders[0]->status,"PAYMENT SUCCESSFUL");
        $this->assertEquals($orders[0]->payment,220.50);
    }
    
    /**
     * Testing created order items
     *
     * @return void
     */
    public function testGetOrderItesm() {
        
        $data['product_id'] = 1;
        $data['quantity'] = 2;

        $cartService = new ShoppingCartService();
        $this->assertTrue($cartService->addToCart($data));
        
        $data['product_id'] = 2;
        $data['quantity'] = 2;
        $this->assertTrue($cartService->addToCart($data));
        
        $cartService->createOrder();
        $orders = $cartService->getAllOrders();
        $this->assertEquals(sizeof($orders[0]->items),2);
        $this->assertEquals($orders[0]->items[0]->total,200);
        $this->assertEquals($orders[0]->items[1]->total,20.50);
       
    }
    
    /**
     * Testing payment
     *
     * @return void
     */
    public function testDoPayment() {
        
        $data['product_id'] = 1;
        $data['quantity'] = 2;

        $cartService = new ShoppingCartService();
        $cartService->addToCart($data);
        
        $data = array();
        $cartService = $this->createPartialMock(ShoppingCartService::class,['doPayment']);
        
        $cartService->expects($this->any())
             ->method('doPayment')
             ->with($data)
             ->will($this->returnValue(true));
        
        $this->assertTrue($cartService->doPayment($data));
        $this->assertTrue($cartService->chekout($data));
        
        $orders = $cartService->getAllOrders();
        $this->assertEquals(sizeof($orders[0]->items),1);
    }
}
