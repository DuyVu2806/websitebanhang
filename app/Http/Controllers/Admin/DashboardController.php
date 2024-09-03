<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GRN_detail;
use App\Models\Order;
use App\Models\OrderDetai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function dashboard()
    {

        $averagePrices0 = GRN_detail::calculateAverageOriginalPrice();
        $originalPrices0 = OrderDetai::getOriginalPriceByProductCode();
        $priceDifferences = [];
        $total = 0;

        foreach ($averagePrices0 as $averagePrice0) {
            $productCode0 = $averagePrice0->product_code;
            $averageOriginalPrice0 = $averagePrice0->average_original_price;

            $orderDetails0 = $originalPrices0->where('product_code', $productCode0);

            $priceDifference0 = 0;

            foreach ($orderDetails0 as $orderDetail0) {
                $originalPriceInOrderDetail0 = $orderDetail0->price;
                $quantity0 = $orderDetail0->quantity;
                $priceDifference0 += ($originalPriceInOrderDetail0 - $averageOriginalPrice0) * $quantity0;
            }

            if ($priceDifference0 != 0) {
                $total += $priceDifference0;
                $priceDifferences[$productCode0] = $priceDifference0;
            }
        }

        $total_prod_fir = $this->getPriceonMonth();
        $total_revenue = Order::where('status_message', '=', 3)
            ->whereDoesntHave('orderItem', function ($query) {
                $query->where('status_message', '=', 4);
            })->sum('total_price');

        $total_bill = Order::where('status_message', '=', 3)
            ->whereDoesntHave('orderItem', function ($query) {
                $query->where('status_message', '=', 4);
            })
            ->count();
        $total_order = Order::where('status_message', '!=', 4)->count();
        $total_product_sold = OrderDetai::whereHas('order', function ($query) {
            $query->where('status_message', '=', 3);
        })
            ->sum('quantity');
        $total_profit = OrderDetai::whereHas('order', function ($query) {
            $query->where('status_message', '=', 3);
        })
            ->selectRaw('SUM(price * quantity) as total_revenue')
            ->first()
            ->total_revenue;
        return view('admin.dashboard.dashboard', compact('total_revenue', 'total_bill', 'total_product_sold', 'total_order', 'total', 'total_prod_fir'));
    }

    public function getPriceonMonth()
    {
        $Month =  Carbon::now()->month;
        $Year = Carbon::now()->year;

        $averagePrices = GRN_detail::calculateAverageOriginalPrice();
        $originalPrices = OrderDetai::getOriginalPriceByProductCodeForMonth($Month, $Year);
        $totalProfit = 0;

        foreach ($averagePrices as $averagePrice) {
            $productCode = $averagePrice->product_code;
            $averageOriginalPrice = $averagePrice->average_original_price;

            $orderDetail = $originalPrices->where('product_code', $productCode)->first();
            if ($orderDetail) {
                $originalPriceInOrderDetail = $orderDetail->price;
                $quantity = $orderDetail->quantity;
                $priceDifference = ($originalPriceInOrderDetail - $averageOriginalPrice) * $quantity;
                $totalProfit += $priceDifference;
            }
        }
        return $totalProfit;
    }


    public function getOrderCountByDate($year, $month, $day)
    {
        $orderCount = DB::table('order')
            ->join('order_detail', 'order.id', '=', 'order_detail.order_id')
            ->whereYear('order.created_at', $year)
            ->whereMonth('order.created_at', $month)
            ->whereDay('order.created_at', $day)
            ->count();

        return $orderCount;
    }

    function revenue_analysis(Request $request)
    {

        $selectedMonth = $request->input('selected_month');
        list($year, $month) = explode('-', $selectedMonth);

        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $labels = []; // Mảng labels để lưu ngày
        $data = [];   // Mảng data để lưu order_count

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $orderCount = $this->getOrderCountByDate($year, $month, $day);
            $labels[] = 'Ngày ' . $day;       // Thêm ngày vào mảng labels
            $data[] = $orderCount;  // Thêm order_count vào mảng data
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
}
