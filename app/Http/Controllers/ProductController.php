<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function getProducts(Request $request) {
        $products = "";
        if(Storage::exists('products.json')) {
            $products = Storage::get('products.json');
        }
        return json_decode($products, true);
    }

    public function addProducts(Request $request) {
        try {
            $name  = $request->product_name;
            $qty   = $request->product_qty;
            $price = $request->product_price;
            $product = [];
            $item = [
                "name"  => $name,
                "qty"   => $qty,
                "price" => $price,
                "date"  => date("Y-m-d H:i:s")
            ];
            $success = false;
            $message = "";

            if(!Storage::exists('products.json')) {
                $item['id'] = 1;
                $product['products'][] = $item;
                Storage::put('products.json', json_encode($product));
                $success = true;
            } else {
                $contents = Storage::get('products.json');
                $collection = collect(json_decode($contents, true));
                $last_id = 0;
                $temp_products = [];
                foreach ($collection["products"] as $row) {
                    $temp_item = [
                        "name"  => $row["name"],
                        "qty"   => $row["qty"],
                        "price" => $row["price"],
                        "date"  => $row["date"],
                        "id"    => $row["id"],
                    ];
                    $temp_products[] = $temp_item;
                    $last_id = $row['id'];
                }

                $id = ($last_id + 1);
                $item['id'] = $id;

                $product["products"] = $temp_products;
                $product["products"][] = $item;
                Storage::put('products.json', json_encode($product));
                $success = true;
            }

            return [
                "success" => $success,
                "message" => $message
            ];

        } catch (Exception $e) {
            return $e;
        }
    }

}
