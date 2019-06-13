<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Input;
use App\Asset;
use App\Stock;
use App\Inventory;
use Illuminate\Http\Request;
Route::get('/', function()
{
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::resource('asset','AssetController');
Route::resource('stock','StockController');
Route::resource('location','LocationController');
Route::resource('inventory','InventoryController');
Route::resource('group','GroupController');
Route::get('/members','AssetController@member');
Route::get('/items','AssetController@showItems');
Route::resource('vendor','VendorController');
Route::post('purchase','PurchaseController@store');
Route::get('/showPurchase','PurchaseController@index');
Route::get('/payment_process','AssetController@show_payment_func');
Route::get('confirm/{id}','purchaseController@confirmPurchase');
Route::get('customers','GroupController@show_customer');

Route::resource('cart','CartController');


Route::get('/service/{asset_id}','ServiceController@showService');
Route::get('/service_stock/{stock_id}','ServiceController@showStockService');
Route::get('/service_inventory/{inventory_id}','ServiceController@showInventoryService');

Route::post('/assetService','ServiceController@assetService');
Route::post('/stockService','ServiceController@stockService');
Route::post('/inventoryService','ServiceController@inventoryService');

Route::get('/retire/{asset_id}','RetireController@showRetire');
Route::get('/retire_stock/{stock_id}','RetireController@showStockRetire');
Route::get('/retire_inventory/{inventory_id}','RetireController@showInventoryRetire');

Route::post('/assetRetire','RetireController@assetRetire');
Route::post('/stockRetire','RetireController@stockRetire');
Route::post('/inventoryRetire','RetireController@inventoryRetire');



Route::get('/checkout/{asset_id}','CheckoutController@showCheckout');
Route::get('/checkout_stock/{stock_id}','CheckoutController@showStockCheckout');
Route::get('/checkout_inventory/{inventory_id}','CheckoutController@showInventoryCheckout');

Route::post('/assetCheckout','CheckoutController@assetCheckout');
Route::post('/stockCheckout','CheckoutController@stockCheckout');
Route::post('/inventoryCheckout','CheckoutController@inventoryCheckout');


Route::get('/reservation/{asset_id}','ReservationController@showReservation');
Route::get('/reservation_stock/{stock_id}','ReservationController@showStockReservation');
Route::get('/reservation_inventory/{inventory_id}','ReservationController@showInventoryReservation');

Route::post('/assetReservation','ReservationController@assetReservation');
Route::post('/stockReservation','ReservationController@stockReservation');
Route::post('/inventoryReservation','ReservationController@inventoryReservation');

Route::get('/reservationStatus','ReservationController@index');
Route::get('/confirmReservation/{id}','ReservationController@confirm');

Route::get('/services','AssetController@services');
Route::post('/changeView','GroupController@changeView');

Route::get('/state/{id}','AssetController@somefunction');
Route::get('/checkin/{id}/{user_id}','CheckoutController@confirmAsset');
Route::get('/checkinStock/{id}/{user_id}','CheckoutController@confirmStock');
Route::get('/checkinInventory/{id}/{user_id}','CheckoutController@confirmInventory');

Route::get('addmoney/stripe', array('as' => 'addmoney.paywithstripe','uses' => 'AddMoneyController@payWithStripe'));

Route::post('addmoney/stripe', array('as' => 'addmoney.stripe','uses' => 'AddMoneyController@postPaymentWithStripe'));
Route::get('/pay','AssetController@pay');
Route::get('/purchaseOrder','AssetController@purchaseOrder');

Route::post('/customer_asset','AssetController@customer');
Route::post('/customer_stock','StockController@customer');
Route::post('/customer_inventory','InventoryController@customer');

Route::post('/search',function()
{
    
    $q = Input::get('q');
    
    if(!empty($q))
    {   
        $asset = Asset::where('name','LIKE','%'.$q.'%')
                        ->orWhere('id','LIKE','%'.$q.'%')
                        ->orWhere('location','LIKE','%'.$q.'%')
                        ->orWhere('purchased_on','LIKE','%'.$q.'%')
                        ->orWhere('cost_price','LIKE','%'.$q.'%')
                        ->orWhere('group','LIKE','%'.$q.'%')
                        ->get();
        $stock = Stock::where('name','LIKE','%'.$q.'%')
                ->orWhere('id','LIKE','%'.$q.'%')
                ->orWhere('location','LIKE','%'.$q.'%')
                ->orWhere('purchased_on','LIKE','%'.$q.'%')
                ->orWhere('cost_price','LIKE','%'.$q.'%')
                ->orWhere('group','LIKE','%'.$q.'%')
                ->get();
        $inventory = Inventory::where('name','LIKE','%'.$q.'%')
                ->orWhere('id','LIKE','%'.$q.'%')
                ->orWhere('location','LIKE','%'.$q.'%')
                ->orWhere('purchased_on','LIKE','%'.$q.'%')
                ->orWhere('cost_price','LIKE','%'.$q.'%')
                ->orWhere('group','LIKE','%'.$q.'%')
                ->get();
        
        $data = array('asset'=>$asset,'stock'=>$stock,'inventory'=>$inventory);
     
        if(!empty($asset) || !empty($stock) || !empty($inventory))
        {
            return view('pages.search')->with($data);
        }
        else
        {
            return redirect('http://localhost/vesit/public/asset')->with('error','Serach not found');
        }
    }
    
    
});

Route::get('/dynamicPdfCustomer','DynamicPDFController@customers');
Route::get('/dynamicPdfCustomer/pdf','DynamicPDFController@pdfcustomers');


Route::get('/dynamicPdfAsset','DynamicPDFController@assets');
Route::get('/dynamicPdfAsset/pdf','DynamicPDFController@pdfAsset');

Route::get('dynamicPdfStock','DynamicPDFController@stocks');
Route::get('dynamicPdfStock/pdf','DynamicPDFController@pdfStock');

Route::get('dynamicPdfInventory','DynamicPDFController@inventorys');
Route::get('dynamicPdfInventory/pdf','DynamicPDFController@pdfInventory');

Route::get('/dynamicExcelAsset','AssetController@export');
Route::get('/export_excel/asset','ExportExcelController@excel_asset')->name('export_excel_asset.excel_asset');
