<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Asset;
class ConfirmController extends Controller
{
    
    public static function receiveRequest($msg,$created_at,$id,$qy)
    {
        
       $abc = DB::select("SELECT user_id FROM assets WHERE id=$id");
        
     
        $asset = Asset::find($id);
        $asset_status = $asset->status;
        global $qy;
    

        $data = array('msg'=>$msg,'created_at'=>$created_at,'id'=>$id,'status'=>$asset_status);
        
       return view('pages.confirm')->with($data);

    }
    
    public function confirm($id)
    {
        $asset = Asset::find($id);

        $asset['status'] = 1;

        $asset['available'] = $asset['available'] - $qy;
        
        $asset->save();
        return 123;
    }
}
