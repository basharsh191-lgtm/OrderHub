<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'customer_name' => 'required|string',
        'total_amount' => 'required|numeric|min:0'
    ]);

    $order = Order::create($validated);

    // اطلب النسخة الطازجة من قاعدة البيانات للتأكد أن الـ Observer أضاف الرقم
    return response()->json($order->fresh(), 201);
}
public function update(Request $request, Order $order)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,completed,cancelled'
    ]);
    $order->update($validated);

    return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
}
public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(['message'=>'oreder is deleted'], 200);
    }
}
//add bashar
