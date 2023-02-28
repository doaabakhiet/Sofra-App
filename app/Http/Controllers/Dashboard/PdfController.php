<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App;
class PdfController extends Controller
{
    // public function view($id)
    // {
    //     $order=Order::find($id);
    //     return view('Admin.orders.show_order',compact('order'));
    // }
    // public function create($id)
    // {
    //     $order=Order::find($id);
    //     $data=['order'=>$order];
    //     // $pdf = Pdf::loadView('Admin.pdf.invoice', $data);
    //     // return $pdf->download('invoice.pdf');
    //     $pdfContent = PDF::loadView('Admin.pdf.invoice', $data)->output();
    //     return response()->streamDownload(
    //         fn () => print($pdfContent),
    //         "invoice.pdf"
    //     );
    // }
}
