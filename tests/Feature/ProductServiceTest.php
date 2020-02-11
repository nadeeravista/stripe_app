<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ProductService;
use Illuminate\Support\Facades\Artisan;

class ProductServiceTest extends TestCase {
   
    /**
     * Inserting data for test
     */
    public function setUp() {
        parent::setUp();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    
    public function testStore() {
      
        $data['name'] = "Test Prodcut 3";
        $data['description'] = "Test Prodcut Description";
        $data['quantity'] = 20;
        $data['unit_price'] = 200;
        $data['category'] = 1;
        $data['availability'] = true;

        $productService = new ProductService();
        $productService->store($data);
        $this->assertTrue($productService->store($data));
       
        
    }

    public function testGetProduct() {
        
        $productService = new ProductService();
        $product = $productService->find(1);
        $this->assertEquals($product->name, "Test Product 1");
        
    }
    
    public function testGetProductCategories(){
        $productService = new ProductService();
        $categories = $productService->getProductCategories();
        $this->assertEquals(count($categories), 2);
        $this->assertEquals($categories[1], "Electronics");
        
    }
    
    public function testUpdateProduct(){
        
        $data['id'] = 1;
        $data['name'] = "Updated Product";
        $data['description'] = "";
        $data['quantity'] = 1;
        $data['unit_price'] = 5;
        $data['category'] = 1;
        $data['availability'] = true;
        
        $productService = new ProductService();
        $productService->update($data);
        
        $product = $productService->find(1);
        $this->assertEquals($product->name, "Updated Product");
        $this->assertEquals($product->quantity, 1);
        $this->assertEquals($product->unit_price, 5);
        $this->assertEquals($product->availability, true);
    }
    
    public function testGetProductAll(){
        
        $productService = new ProductService();
        $products = $productService->all();
        $this->assertEquals(sizeof($products), 2);
    }

   
}
