<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;

class OrderController extends Controller
{
    // This method will handle all of the orders of the user
    public function index(){
        $orders = Order::where('user_id', auth()->id())->get();
        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'No orders found for this user',
            ], 404);
        }
        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $orders,
        ], 200);
    }

    // Xem chi tiết đơn hàng 
    public function showOrderDetails($id){
        $order = Order::where('user_id', auth()->id())->where('id', $id)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        if ($orderItems->isEmpty()) {
            return response()->json([
                'message' => 'No items found for this order',
            ], 404);
        }

        return response()->json([
            'message' => 'Order details retrieved successfully',
            'data' => [
                'order' => $order,
                'items' => $orderItems,
            ],
        ], 200);
    }

    // Tạo đơn hàng mới trong giỏ hàng
    public function createOrderWithCart(Request $request){
        
    }

    // Tạo trực tiếp đơn hàng mới
    public function createOrder(Request $request){
        
    }
}
