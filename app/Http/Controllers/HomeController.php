<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $count_all =Invoices::count();
        $count_invoices1 = Invoices::where('Value_Status', 1)->count();
        $count_invoices2 = Invoices::where('Value_Status', 2)->count();
        $count_invoices3 = Invoices::where('Value_Status', 3)->count();
        $nspainvoices1 = ($count_invoices1 == 0) ? 0 : ($count_invoices1 / $count_all * 100);
        $nspainvoices2 = ($count_invoices2 == 0) ? 0 : ($count_invoices2 / $count_all * 100);
        $nspainvoices3 = ($count_invoices3 == 0) ? 0 : ($count_invoices3 / $count_all * 100);
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$nspainvoices2]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$nspainvoices1]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$nspainvoices3]
                ],
            ])
            ->options([]);
        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$nspainvoices2, $nspainvoices1,$nspainvoices3]
                ]
            ])
            ->options([]);
        return view('home', compact('chartjs','chartjs_2'));
    }
}
