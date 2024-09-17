<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function storeInvoice(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|unique:invoices,customer_email',
            'products' => 'required|array|min:1',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.product_price' => 'required|numeric|min:0',
            'products.*.product_discount' => 'required|numeric|min:0',
        ]);
        // Inovice table invocie customer data stored 
        $invoice = invoice::create([
            'customer_name' => $request->get('customer_name'),
            'customer_email' => $request->get('customer_email'),
        ]);
        // Product table product data stored
        foreach ($request->products as $product) {
            $products =  product::create([
                'invoice_id' => $invoice->id,
                'product_name' => $product['product_name'],
                'product_price' => $product['product_price'],
                'product_discount' => $product['product_discount'],
            ]);
        }
        return response()->json(['success' => 'Invoice and products saved successfully.']);
    }

    public function editInvoice(Request $request){
        dd("Edit Invoice");
    }
}
