<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

class PdfController extends Controller
{
    public function showPdf($year)
    {
        // Fetch the number of orders for each month of the specified year
        $thisYearOrders = $this->getOrdersCountByMonth($year);
        
        // Fetch the number of orders for each month of the previous year
        $lastYearOrders = $this->getOrdersCountByMonth($year - 1);

        // Return the view with the fetched data
        return view('pdf.example', compact('year', 'thisYearOrders', 'lastYearOrders'));
    }

    public function generatePdf($year)
    {
        $thisYearOrders = $this->getOrdersCountByMonth($year);
        
        // Fetch the number of orders for each month of the previous year
        $lastYearOrders = $this->getOrdersCountByMonth($year - 1);

        // Render the view and save it as HTML
        $template = view('pdf.example', compact('year', 'thisYearOrders', 'lastYearOrders'))->render();

        Pdf::html($template)->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot->setIncludePath(env('BROWSER_PATH'));
            $browsershot->waitUntilNetworkIdle();
        })->save('orders -- '.$year.'.pdf');

        return ('HTML saved successfully');
    }

    public function downloadPdf($year)
    {
        // Fetch the number of orders for each month of the specified year
        $thisYearOrders = $this->getOrdersCountByMonth($year);
        
        // Fetch the number of orders for each month of the previous year
        $lastYearOrders = $this->getOrdersCountByMonth($year - 1);

        // Render the view and save it as HTML
        
        $template = view('pdf.example', compact('year', 'thisYearOrders', 'lastYearOrders'))->render();

        // Generate the PDF and trigger download
        return Pdf::html($template)->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot->setIncludePath(env('BROWSER_PATH'));
            $browsershot->waitUntilNetworkIdle()->setDelay(1000);
        })->download('orders_' . $year . '.pdf');
    }

    private function getOrdersCountByMonth($year)
    {
        // Initialize an array with all months set to 0
        $months = array_fill(1, 12, 0);

        $ordersQuery = Order::select(DB::raw("strftime('%m', order_date) as month, COUNT(*) as count"))
            ->whereYear('order_date', $year)
            ->groupBy(DB::raw("strftime('%m', order_date)"))
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        foreach ($ordersQuery as $month => $count) {
            $months[intval($month)] = $count;
        }

        return array_values($months);
    }
}
