<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modelizer\Selenium\SeleniumTestCase;
use Illuminate\Support\Facades\Artisan;

class SeleniumProductControllerTest extends SeleniumTestCase {

    /**
     * Inserting data for test
     */
    public function setUp() {
        parent::setUp();
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');
    }

    /**
     * Test home page menus
     *
     * @return void
     */
    public function testHomePage() {
        $this->visit('/')
                ->see('Demo Cart')
                ->see('MANAGE PRODUCTS')
                ->see('SHOP')
                ->see('MY ORDERS')
                ->hold(3);
    }

    /**
     * Test product list
     *
     * @return void
     */
    public function testViewProductList() {
        $this->visit('/product')
                ->see('Test Product 1')
                ->see('SGD100.00')
                ->see('Test Product 2')
                ->see('SGD10.25');
    }
    
    
    /**
     * Test product list
     *
     * @return void
     */
    public function testEditProducts() {
        
        $this->visit('/product/1/edit')
             ->type('Updated Product', 'name', true)
             ->submitForm('#frm_product',array())
             ->see('Product successfully updated');  
      
        $this->visit('/product')
                ->see('Updated Product')
                ->see('SGD100.00');
    }

}
