<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\PosOrder;
use Illuminate\Http\Request;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\PosPaymentFacade\PosPaymentFacade;
use Illuminate\Support\Facades\Auth;

class HomeController extends ParentController
{
    public function index()
    {
        $full_date = Carbon::now();
        $date = $full_date->toDateString();

        $hours = range(0, 24);

        $today_sales = PosOrder::whereDate('created_at', $date)->where('status', '==', 1)->orderBy('total')->get();
        //assign prices ascending order to a array
        foreach ($today_sales as $key => $today_sale) {
            $today_sales_price[] = $today_sale->total;
        }


        $today_invoices = PosOrder::whereDate('created_at', $date)->where('status', '==', 1)->orderBy('id')->get();
        foreach ($today_invoices as $key => $today_invoice) {
            $today_invoices_price[] = $key + 1;
        }

        $monthly_sales = PosOrder::whereYear('created_at', Carbon::now()->year)
            ->orderBy('total')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m'); // Group by month
            });

        $monthly_invoices = PosOrder::whereYear('created_at', Carbon::now()->year)
            ->where('status', '>', 0)
            ->orderBy('id')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m'); // Group by month
            });

        $monthly_sales_price = [];
        $monthly_invoices_price = [];

        foreach ($monthly_sales as $month => $sales) {
            $monthly_sales_price[] = $sales->count();
        }

        foreach ($monthly_invoices as $month => $invoices) {
            $monthly_invoices_price[] = $invoices->count(); // Count the number of invoices in each month
        }

        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->year;

        // Get monthly sales data for the current year
        $monthly_sales = PosOrder::where('created_by', Auth::id())
            ->whereYear('created_at', $currentYear)
            ->where('status', '>', 0)
            ->orderBy('id')
            ->get();

        $monthly_invoices = PosOrder::where('created_by', Auth::id())
            ->whereYear('created_at', $currentYear)
            ->where('status', '>', 0)
            ->orderBy('id')
            ->get();

        // Extract distinct month names
        $distinct_months_sales = $monthly_sales
            ->unique(function ($item) {
                return Carbon::parse($item->created_at)->format('F');
            })
            ->values()
            ->toArray();

        $distinct_months_invoices = $monthly_invoices
            ->unique(function ($item) {
                return Carbon::parse($item->created_at)->format('F');
            })
            ->values()
            ->toArray();

        // Add the current month if not already in the array
        if (!in_array($currentMonth, $distinct_months_sales)) {
            array_unshift($distinct_months_sales, $currentMonth);
        }

        if (!in_array($currentMonth, $distinct_months_invoices)) {
            array_unshift($distinct_months_invoices, $currentMonth);
        }


        $response['total_sales'] = $today_sales_price ?? 0;
        $response['total_invoices'] = $today_invoices_price ?? 0;
        $response['monthly_sales'] =  $monthly_sales_price ?? [0];
        $response['monthly_invoices'] = $monthly_invoices_price ??  [0];

        // To get hours
        foreach ($hours as $key => $hour) {
            $startTime = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
            $datetime[] =  $startTime;
        }

        $response['distinct_month_names'] = $distinct_months_sales ?? [];
        $response['distinct_month_names_invoices'] = $distinct_months_invoices ?? [];

        $response['total_system_sales'] = PosOrder::where('status', 1)->sum('total');
        $response['total_system_non_paid'] = PosOrder::where('status', 1)->sum('balance');
        $response['total_system_invoices'] = PosOrder::where('status',1)->count();

        $response['hours'] = $datetime;
        $response['today_total_sales'] = PosOrder::whereDate('created_at', $date)->sum('total');
        $response['today_total_invoices'] = PosOrder::whereDate('created_at', $date)->where('status', '==', 1)->count();

        return Inertia::render('Dashboard/index', $response);
    }
}
