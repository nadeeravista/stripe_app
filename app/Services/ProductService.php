<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Product;
/**
 * Description of ProductService
 *
 * @author nadeerathilak
 */
class ProductService {
   
    /**
     * 
     * @param type $data request data
     * @return bool
     */
    public function store($data){
        
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->unit_price = $data['unit_price'];
        $product->quantity = $data['quantity'];
        $product->category = $data['category'];
        $product->availability = true;
        
        if(isset($data['image'])){
            $file = $data['image'];
            $contents = $file->openFile()->fread($file->getSize());
            $product->image = $contents;
            $product->image_extension = $file->getClientOriginalExtension();
        }
        
        return $product->save();
    }
    
    /**
     * 
     * @param type $id
     * @return type
     */
    public function find($id){
        $product = new Product();
        return $product->find($id);
    }
    
    /**
     * 
     * @return array
     */
    public function getProductCategories(){
        return array(1 => "Electronics", 2 => "Automobile");
    }
    
    /**
     * 
     * @param type $data
     * @return boolean
     */
    public function update($data){
        
        $product = new Product();
        $product = $product->find($data['id']);
        
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->unit_price = $data['unit_price'];
        $product->quantity = $data['quantity'];
        $product->category = $data['category'];
        
        if(isset($data['image'])){
            $file = $data['image'];
            $contents = $file->openFile()->fread($file->getSize());
            $product->image = $contents;
            $product->image_extension = $file->getClientOriginalExtension();
        }
        return $product->save();
    }
    
    /**
     * 
     * @param type $id
     * @return boolean
     */
    public function delete($id){
        $product = new Product();
        $product = $product->find($id);
        $product->delete();
        return true;
    }
    
    /**
     * 
     * @return array
     */
    public function all(){
        $product = new Product();
        return $product->all();
    }
    
    /**
     * 
     * @return array
     */
    public function getAllAvaialble(){
        $product = new Product();
        return $product->select('id','name','unit_price','description')->where('availability',1)->get();
    }
    
}
