<?php
namespace app\api\Controller;
use app\api\model\Product as ProductModel;
use think\Controller;
class Product extends Controller{
    public function getProduct($id)
    {
//        var_dump(123);
//        $id='10010';
        $product=ProductModel::getpro($id);
        if(!$product){

        }
        return json($product);
    }
}