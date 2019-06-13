<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;
use App\Stock;
use App\Inventory;
use Excel;

class ExportExcelController extends Controller
{
    public function asset()
    {
        $asset = Asset::all();
        return view('export_excel_asset')->with('asset',$asset);
    }
    
    public function stock()
    {
        $asset = Stock::all();
        return view('export_excel_stock')->with('asset',$asset);
    }
    public function inventory()
    {
        $asset = Inventory::all();
        return view('export_excel_inventory')->with('asset',$asset);
    }
    public function excel_asset()
    {
        $asset = Asset::all();

        $asset_array[] = array('Id','Name','Description','Location','Vendor','Group','Cost');

        foreach($asset as $a)
        {
            $asset_array[] = array(
                'Id' => $a->id,
                'Name' => $a->name,
                'Description' => $a->description,
                'Location' => $a->location,
                'Vendor' => $a->vendor,
                'Group' => $a->group,
                'Cost' => $a->cost_price
            );
        }
        Excel::create('Asset Data',function($excel) use($asset_array)
        {
            $excel->setTitle('Asset Data');
            $excel->sheet('Asset Data',function($sheet) use($asset_array)
            {
                $sheet->fromArray($asset_array,null,'A1',false,false);
            });
        })->download('xlsx');
    }
}
