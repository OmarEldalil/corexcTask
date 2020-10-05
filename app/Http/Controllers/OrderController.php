<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cartItems = $request->post();
        if (!count($cartItems)) {
            return response([
                'success' => false,
                'error' => 'No Products Provided'
            ], 400);
        }
        $validationResults = $this->validateProductQuantities($cartItems);
        if (!$validationResults['valid']) {
            return response([
                'success' => false,
                'error' => $validationResults['error']
            ], 400);
        }
        $order = Order::create([
            'total' => $validationResults['total'],
            'status' => Order::STATUS_NEW
        ]);
        $order->save();
        $order->orderItems()->saveMany($validationResults['orderItems']);
        return response([
            'success' => true,
        ], 201);

    }

    private function validateProductQuantities($cartItems)
    {
        $total = 0;
        $orderItems = [];
        foreach ($cartItems as $cartItem) {
            $product = Product::where('id', $cartItem['id'])->first();
            if (!($product && $product->quantity >= $cartItem['quantity'])) {
                $title = $cartItem['title'];
                return [
                    'valid' => false,
                    'error' => "\"$title\" doesn't have enough quantity"
                ];
            }
            $total += $product->price * $cartItem['quantity'];
            $orderItems[] = new OrderItem([
                'product_id' => $product->id,
                'quantity' => $cartItem['quantity'],
                'price' => $product->price
            ]);
        }
        return ['valid' => true, 'total' => $total, 'orderItems' => $orderItems];
    }
}
