<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GRN;
use App\Models\Order;
use App\Models\OrderDetai;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    function view_goods_import()
    {
        $grn = GRN::all();
        return view('admin.business.view_goods_import', compact('grn'));
    }
    function view_orders(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $orders = Order::orderBy('created_at', 'DESC')
            ->when($request->date != null, function ($e) use ($request) {
                return $e->whereDate('created_at', $request->date);
            })
            ->when($request->status != null, function ($e) use ($request) {
                return $e->where('status_message', $request->status);
            })
            ->when($request->date == '' && $request->status == null, function ($e) {
                return $e;
            })->get();
        return view('admin.business.view_orders', compact('orders'));
    }
    function view_order_detail($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.business.view_order_detail', compact('order'));
    }
}
