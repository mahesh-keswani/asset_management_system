<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\Stock;
use App\Inventory;
use PDF;
use App\Customer;

class DynamicPDFController extends Controller
{
    public function assets()
    {
        $assets = Asset::all();
        return view('dynamic_pdf')->with('assets',$assets);
    }
    public function stocks()
    {
        $assets = Stock::all();
        return view('dynamicPdfStock')->with('assets',$assets);

    }
    public function inventorys()
    {
        $assets = Inventory::all();
        return view('dynamicPdfInventory')->with('assets',$assets);
    }
    public function customers()
    {
        $customer = Customer::all();
        return view('dynamic_customer_pdf')->with('customer',$customer);
    }
    public function pdfAsset()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_asset_to_html());
        return $pdf->stream();
        

    }
    
    public function pdfStock()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_stock_to_html());
        return $pdf->stream();
        

    }
    
    public function pdfInventory()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_inventory_to_html());
        return $pdf->stream();
        

    }

    
    public function pdfcustomers()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_to_html());
        return $pdf->stream();
        

    }
    public function convert_asset_to_html()
    {
        $asset = Asset::all();
        $output = '
                    <h1><center>Assets</center></h1>
                    <table class="table table-striped" style="border-collapse:collapse;border:0px;"border-radius:20px;font-family:"Courier New", Courier, monospace"">
                        <tr>
                            <th  style="border:1px solid black;padding:30px;">Id</th>
                            <th style="border:1px solid black;padding:30px;">Name</th>
                            <th style="border:1px solid black;padding:30px;">Description</th>
                            <th style="border:1px solid black;padding:30px;">Location</th>
                            <th style="border:1px solid black;padding:30px;">Group</th>
                            <th  style="border:1px solid black;padding:30px;">Vendor</th>
                            <th style="border:1px solid black;padding:30px;">Cost</th>
                        </tr>
                 ';
        foreach($asset as $a)
        {  
            $output .= '
                            <tr style="border:1px solid black;padding:30px;">
                                    <th style="border:1px solid black;padding:30px;">'.$a->id.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->name.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->description.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->location.'</th>
                                    <th  style="border:1px solid black;padding:30px;">'. $a->group.'</th>
                                    <th style="border:1px solid black;padding:30px;">'. $a->vendor.'</th>
                                    <th style="border:1px solid black;padding:30px;">'. $a->cost_price.' $</th>
                            </tr>
                        ';
        }
        $output .= ' </table>';
        return $output;
    }

    public function convert_customer_to_html()
    {
        $asset = Customer::all();
        $output = '
                    <h1><center>Customers</center></h1>
                    <table class="table table-striped" style="border-collapse:collapse;border:0px;"border-radius:20px;font-family:"Courier New", Courier, monospace"">
                        <tr>
                            <th  style="border:1px solid black;padding:30px;">Id</th>
                            <th style="border:1px solid black;padding:30px;">Product Name</th>
                            <th style="border:1px solid black;padding:30px;">Seller ID</th>
                            <th style="border:1px solid black;padding:30px;">Cost</th>
                            
                            <th  style="border:1px solid black;padding:30px;">Vendor</th>
                            
                        </tr>
                 ';
        foreach($asset as $a)
        {  
            $output .= '
                            <tr style="border:1px solid black;padding:30px;">
                                    <th style="border:1px solid black;padding:30px;">'.$a->id.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->product_name.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->seller_id.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->cost.'</th>
                                    <th  style="border:1px solid black;padding:30px;">'. $a->vendor.'</th>
                                    
                            </tr>
                        ';
        }
        $output .= ' </table>';
        return $output;
    }

    public function convert_stock_to_html()
    {
        $asset = Stock::all();
        $output = '
                    <h1><center>Asset Stocks</center></h1>
                    <table class="table table-striped" style="border-collapse:collapse;border:0px;"border-radius:20px;font-family:"Courier New", Courier, monospace"">
                        <tr>
                            <th  style="border:1px solid black;padding:30px;">Id</th>
                            <th style="border:1px solid black;padding:30px;">Name</th>
                            <th style="border:1px solid black;padding:30px;">Description</th>
                            <th style="border:1px solid black;padding:30px;">Location</th>
                            <th style="border:1px solid black;padding:30px;">Group</th>
                            <th  style="border:1px solid black;padding:30px;">Vendor</th>
                            <th style="border:1px solid black;padding:30px;">Cost</th>
                        </tr>
                 ';
        foreach($asset as $a)
        {  
            $output .= '
                            <tr style="border:1px solid black;padding:30px;">
                                    <th style="border:1px solid black;padding:30px;">'.$a->id.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->name.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->description.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->location.'</th>
                                    <th  style="border:1px solid black;padding:30px;">'. $a->group.'</th>
                                    <th style="border:1px solid black;padding:30px;">'. $a->vendor.'</th>
                                    <th style="border:1px solid black;padding:30px;">'. $a->cost_price.' $</th>
                            </tr>
                        ';
        }
        $output .= ' </table>';
        return $output;
    }
    public function convert_inventory_to_html()
    {
        $asset = Inventory::all();
        $output = '
                    <h1><center>Inventories</center></h1>
                    <table class="table table-striped" style="border-collapse:collapse;border:0px;"border-radius:20px;font-family:"Courier New", Courier, monospace"">
                        <tr>
                            <th  style="border:1px solid black;padding:30px;">Id</th>
                            <th style="border:1px solid black;padding:30px;">Name</th>
                            <th style="border:1px solid black;padding:30px;">Description</th>
                            <th style="border:1px solid black;padding:30px;">Location</th>
                            <th style="border:1px solid black;padding:30px;">Group</th>
                            <th  style="border:1px solid black;padding:30px;">Vendor</th>
                            <th style="border:1px solid black;padding:30px;">Cost</th>
                        </tr>
                 ';
        foreach($asset as $a)
        {  
            $output .= '
                            <tr style="border:1px solid black;padding:30px;">
                                    <th style="border:1px solid black;padding:30px;">'.$a->id.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->name.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->description.'</th>
                                    <th style="border:1px solid black;padding:30px;">'.$a->location.'</th>
                                    <th  style="border:1px solid black;padding:30px;">'. $a->group.'</th>
                                    <th style="border:1px solid black;padding:30px;">'. $a->vendor.'</th>
                                    <th style="border:1px solid black;padding:30px;">'. $a->cost_price.' $</th>
                            </tr>
                        ';
        }
        $output .= ' </table>';
        return $output;
    }

}
