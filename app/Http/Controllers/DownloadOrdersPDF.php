<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class DownloadOrdersPDF extends Controller
{
    public function __invoke(Pdf $pdf)
    {
        return $pdf;
    }
}
