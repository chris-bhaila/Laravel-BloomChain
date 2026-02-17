<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->query('year', null) === 'All' ? null : $request->query('year', null);
        $month = $request->query('month', null) === 'All' ? null : $request->query('month', null);
        $period = $request->query('period', null) === 'month' ? null : $request->query('period', null);

        $availableYears = Order::selectRaw('YEAR(created_at) year')->distinct()->get()->pluck('year');

        $orders = Order::query();
        $staticOrders = Order::all();

        if ($year && $month) {
            $orders->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } elseif ($year) {
            $orders->whereYear('created_at', $year);
        }

        $orders = $orders->get();

        $totalOrderMoney = $orders->sum('price') === 0 ? 1 : $orders->sum('price');
        $totalOrderNumber = $orders->count();

        $totalSales = $orders->where('status', 'Delivered')->sum('price');
        $salesNumber = $orders->where('status', 'Delivered')->count();
        $salesPecent = intval($totalSales / $totalOrderMoney * 100);

        $totalRecived = $orders->where('status', 'Received')->sum('price');
        $recivedNumber = $orders->where('status', 'Received')->count();
        $recivedPecent = intval($totalRecived / $totalOrderMoney * 100);

        $totalReturned = $orders->where('status', 'Returned')->sum('price');
        $returnedNumber = $orders->where('status', 'Returned')->count();
        $returnedPecent = intval($totalReturned / $totalOrderMoney * 100);

        if ($period) {
            $totalSalesMonthly = $staticOrders->groupBy(function ($order) {
                return \Carbon\Carbon::parse($order->created_at)->format('Y');
            })->map(function ($yearOrders) {
                return $yearOrders->sum('price');
            });
            $selected = "yearly";
        } else {
            $totalSalesMonthly = $staticOrders->where('created_at', '>=', now()->startOfYear())->groupBy(function ($order) {
                return \Carbon\Carbon::parse($order->created_at)->format('M');
            })->map(function ($monthOrders) {
                return $monthOrders->sum('price');
            });
            $selected = "monthly";
        }

        $mostSoldItems = $orders->groupBy('shoe_name')->map(function ($shoeOrders) use ($totalOrderNumber) {
            $count = $shoeOrders->count();
            return [
                'shoe_name' => $shoeOrders->first()->shoe_name,
                'count' => $count,
                'percentage' => $totalOrderNumber > 0 ? intval(($count / $totalOrderNumber * 100)) : 0,
            ];
        })->sortByDesc('count')->values()->take(5);

        $recentOrders = $staticOrders->sortByDesc('created_at')->take(5)->map(function ($order) {
            return [
                "order_id" => $order->order_id,
                "customer_name" => $order->customer_name,
                "shoe_name" => $order->shoe_name,
                "date" => $order->created_at->format('Y-m-d'),
                "status" => $order->status,
            ];
        })->values();

        $largestSales = $totalSalesMonthly->isNotEmpty() ? $totalSalesMonthly->max() : 0;
        
        return view('admin.dashboard', [
            "availableYears" => $availableYears,
            "sales" => $totalSales,
            "sales_number" => $salesNumber,
            "sales_percent" => $salesPecent,
            "pending" => $totalRecived,
            "pending_number" => $recivedNumber,
            "pending_percent" => $recivedPecent,
            "returned" => $totalReturned,
            "returned_number" => $returnedNumber,
            "returned_percent" => $returnedPecent,
            "most_sold" => $mostSoldItems->isNotEmpty() ? $mostSoldItems : null,   
            "orders" => $recentOrders,
            "selected" => $selected,
            "total_sales" => $totalSalesMonthly->isNotEmpty() ? $totalSalesMonthly : null,
            "max_sales" => $largestSales,
        ]);
    }
    public function notification(Request $request)
    {
        $orders = Order::where('status', 'Received')->orderBy('created_at', 'desc')->get(['order_id', 'customer_name', 'created_at']);

        $notifications = $orders->map(function ($order) {
            return [
                'id' => $order->order_id,
                'message' => $order->customer_name . ' ordered ' . $order->shoe_name,
                'time' => $order->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'notifications' => $notifications
        ]);
    }


}

