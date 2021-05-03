<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use DB;


class ProductController extends Controller
{

    public function products(Request $request){
        return view('products');
    }

    public function productList(Request $request){
        $list =  Product::paginate(4);
        $returnHTML = view('_product_list',['products'=> $list])->render();
        return response()->json( array('success' => true, 'html'=>$returnHTML) );
    }

    public function addToCart($id)
    {
        try{

        $product = Product::find($id);
        if(!$product) {
            abort(404);
        }
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                    $id => [
                        "id"=>$product->id,
                        "name" => $product->name,
                        "quantity" => 1,
                        "price" => $product->price,
                        "photo" => 'public/product_images/'.$product->image
                    ]
            ];
            session()->put('cart', $cart);
            return response()->json( array('success' => true, 'message'=>'Product added to cart successfully!') );
        }
        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return response()->json( array('success' => true, 'message'=>'Product added to cart successfully!') );
        }
        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "id"=>$product->id,
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => 'public/product_images/'.$product->image
        ];
        session()->put('cart', $cart);
            return response()->json( array('success' => true, 'message'=>'Product added to cart successfully!') );
        }catch(\Exception $ex){
            return response()->json( array('success' => false, 'message'=>$ex->getMessage()) );  
        }
        
    }

    public function cartList(Request $request){
        return view('cart');
    }

    public function removeFromCart(Request $request){
        try{
            if($request->id) {
                $cart = session()->get('cart');
                if(isset($cart[$request->id])) {
                    unset($cart[$request->id]);
                    session()->put('cart', $cart);
                }
                return response()->json( array('success' => true, 'message'=>'Product removed from cart successfully!','id'=>$request->id) );
            }
        }catch(\Exception $ex){
            return response()->json( array('success' => false, 'message'=>$ex->getMessage()) );  
        }
    }

    public function clearCart(){

        try{
            $cart = session()->get('cart');
            if($cart){
                foreach($cart as $id=>$row){
                    unset($cart[$id]);
                 }
                 session()->put('cart', $cart);
          
                return response()->json( array('success' => true, 'message'=>'Cart clreared successfully!') );
            }else{
                return response()->json( array('success' => false, 'message'=>'There is not product into cart!') );
            }
        }catch(\Exception $ex){
            return response()->json( array('success' => false, 'message'=>$ex->getMessage()) );  
        }
    }


    public function getabsoluteDiffrence()
    {
            $arr = [4,5,6,2,8,10,9,1];
            $oldArray = $arr;
            $temp;
            $n = count($arr);
            for($j = 0; $j < $n; $j ++) {
                for($i = 0; $i < $n-1; $i ++){
                    if($arr[$i] > $arr[$i+1]) {
                        $temp = $arr[$i+1];
                        $arr[$i+1]=$arr[$i];
                        $arr[$i]=$temp;
                    }       
                }
            }
            $sortedArray = $arr;
            $min = $sortedArray[0];
            $max = $sortedArray[$n-1];
            //get index of min and max value
            for($i=0;$i<$n;$i++){
                if($oldArray[$i] == $min){
                    $minIndex = $i;
                }
                if($oldArray[$i] == $max){
                    $maxIndex = $i;
                }
            }
            $absDifference = abs($maxIndex - $minIndex);
            echo "Absolute difference:";
            print_r($absDifference);die;
    }

    public function getUserList()
    {
        $query = "SELECT p1.id,p1.name,
        (SELECT 
         (
             SELECT 
             name 
             FROM `role` p3
             WHERE p3.id = p2.role_id 
         )
          FROM `user_role_map` p2 
          WHERE p2.user_id = p1.id) as role_name,
          
          (SELECT 
         (
             SELECT 
              (
              SELECT 
                 name
               FROM `department` p4
               WHERE p4.id = p3.department_id 
              )
             FROM `role` p3
             WHERE p3.id = p2.role_id 
         )
           FROM `user_role_map` p2 
          WHERE p2.user_id = p1.id) as department_name
        FROM `user` p1";

       $userList =  DB::select($query);
       echo "<pre>";
       print_r($userList);die;
    }
}
