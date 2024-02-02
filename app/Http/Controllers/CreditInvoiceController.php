<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CreditInvoiceController extends ParentController
{
    public function index()
    {
            return Inertia::render('CreditInvoice/index');
    }

    public function edit()
    {
            return Inertia::render('CreditInvoice/edit');
    }

    
}
