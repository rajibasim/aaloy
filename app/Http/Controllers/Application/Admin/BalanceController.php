<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class BalanceController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/admin-report';
        $this->title = 'Comodity';
        $this->table = 'mainstock';
    }

    /* List view */    
    public function product(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'serach_data' => [],
            'breadcumb' => array(
                    array(
                        'url' => '/dashboard',
                        'title' => 'Home',  
                    ),
                    array(
                        'url' => '',
                        'title' => $this->title,  
                    )
            ),
        );
        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $products = \DB::select("SELECT *, SUM(current_stock) as stock FROM current_stock_balance_sheet GROUP BY product_id");
            $dataArray = array();
            if(!empty($products)){
                foreach ($products as $key => $value) {
                    $wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE product_id = '".$value->product_id."' GROUP BY product_id");
                    $value->wastage = isset($wastage) && !empty($wastage) ? $wastage[0]->wastage : 0;

                    $substract = \DB::select("SELECT SUM(quentity) as substract FROM districtstoreproductstock WHERE product_id = '".$value->product_id."' AND type = 4 GROUP BY product_id");
                    $value->substract = isset($substract) && !empty($substract) ? $substract[0]->substract : 0;

                    $distribute = \DB::select("SELECT SUM(quentity) as distribute FROM subseedstoreproductstock WHERE product_id = '".$value->product_id."' AND type = 2 GROUP BY product_id");
                    $value->distribute = isset($distribute) && !empty($distribute) ? $distribute[0]->distribute : 0;

                    $total_stock = \DB::select("SELECT current_stock as total_stock FROM product WHERE id = '".$value->product_id."'");
                    $value->total_stock = isset($total_stock) && !empty($total_stock) ? $total_stock[0]->total_stock : 0;

                    $dataArray[] = (array) $value;
                }
            }
            
            $data['rows'] = $dataArray;
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $products = \DB::select("SELECT *, SUM(districtstoreproductstock.quentity) as total_stock, product.name as product_name, category.name as category_name, brand.name as brand_name FROM districtstoreproductstock LEFT JOIN product ON districtstoreproductstock.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id WHERE districtstoreproductstock.districtstore_id = '".$user_data->districtstore_id."' AND districtstoreproductstock.type = 1 GROUP BY districtstoreproductstock.product_id");

            $main_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM mainstore WHERE districtstore_id = '".$user_data->districtstore_id."'");
            $main_stores_ids = isset($main_stores_ids) && !empty($main_stores_ids) ? $main_stores_ids[0]->ids : 0;
            if($main_stores_ids){
                $subseed_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM subseedstore WHERE mainstore_id IN (".$main_stores_ids.") AND districtstore_id = '".$user_data->districtstore_id."'");
                $subseed_stores_ids = isset($subseed_stores_ids) && !empty($subseed_stores_ids) ? $subseed_stores_ids[0]->ids : 0;
            }else{
                $subseed_stores_ids = 0;
            }
            
            $dataArray = [];
            if(!empty($products)){
                foreach ($products as $key => $value) {

                    $district_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE districtstore_id = '".$user_data->districtstore_id."' AND product_id = '".$value->product_id."' AND type_of_store = '1' GROUP BY product_id");
                    $district_stock = isset($district_stock) && !empty($district_stock) ? $district_stock[0]->stock : 0;

                    $district_wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE districtstore_id = '".$user_data->districtstore_id."' AND product_id = '".$value->product_id."' AND type_of_store = '1' GROUP BY product_id");
                    $district_wastage = isset($district_wastage) && !empty($district_wastage) ? $district_wastage[0]->wastage : 0;

                    if($main_stores_ids){
                        $main_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id IN (".$main_stores_ids.") AND product_id = '".$value->product_id."' AND districtstore_id = '".$user_data->districtstore_id."' AND type_of_store = '2' GROUP BY product_id");
                        $main_stock = isset($main_stock) && !empty($main_stock) ? $main_stock[0]->stock : 0;

                        $main_wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE mainstore_id IN (".$main_stores_ids.") AND product_id = '".$value->product_id."' AND districtstore_id = '".$user_data->districtstore_id."' AND type_of_store = '2' GROUP BY product_id");
                        $main_wastage = isset($main_wastage) && !empty($main_wastage) ? $main_wastage[0]->wastage : 0;

                    }else{
                        $main_stock = 0;
                        $main_wastage = 0;
                    }

                    if($subseed_stores_ids){
                        $subseed_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id IN (".$main_stores_ids.") AND product_id = '".$value->product_id."' AND subseedstore_id IN (".$subseed_stores_ids.") AND type_of_store = '3' GROUP BY product_id");
                        $subseed_stock = isset($subseed_stock) && !empty($subseed_stock) ? $subseed_stock[0]->stock : 0;

                        $subseed_wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE mainstore_id IN (".$main_stores_ids.") AND product_id = '".$value->product_id."' AND subseedstore_id IN (".$subseed_stores_ids.") AND type_of_store = '3' GROUP BY product_id");
                        $subseed_wastage = isset($subseed_wastage) && !empty($subseed_wastage) ? $subseed_wastage[0]->wastage : 0;

                    }else{
                        $subseed_stock = 0;
                        $subseed_wastage = 0;
                    }

                    $value->stock = $district_stock + $main_stock + $subseed_stock;
                    $value->wastage = $district_wastage + $main_wastage + $subseed_wastage;

                    $substract = \DB::select("SELECT SUM(quentity) as substract FROM districtstoreproductstock WHERE product_id = '".$value->product_id."' AND type = 4 AND districtstore_id = '".$user_data->districtstore_id."' GROUP BY product_id");
                    $value->substract = isset($substract) && !empty($substract) ? $substract[0]->substract : 0;

                    $distribute = \DB::select("SELECT SUM(quentity) as distribute FROM subseedstoreproductstock WHERE subseedstore_id IN (".$subseed_stores_ids.") AND product_id = '".$value->product_id."' AND type = 2 GROUP BY product_id");
                    $value->distribute = isset($distribute) && !empty($distribute) ? $distribute[0]->distribute : 0;
                    
                    $dataArray[] = (array) $value;
                }
            }

            $data['rows'] = $dataArray;
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){

            $products = \DB::select("SELECT *, SUM(mainstoreproductstock.quentity) as total_stock, product.name as product_name, category.name as category_name, brand.name as brand_name FROM mainstoreproductstock LEFT JOIN product ON mainstoreproductstock.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id WHERE mainstoreproductstock.mainstore_id = '".$user_data->mainstore_id."' AND mainstoreproductstock.type = 1 GROUP BY mainstoreproductstock.product_id");

            $subseed_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM subseedstore WHERE mainstore_id = '".$user_data->mainstore_id."'");
            $subseed_stores_ids = isset($subseed_stores_ids) && !empty($subseed_stores_ids) ? $subseed_stores_ids[0]->ids : 0;

            $dataArray = [];
            if(!empty($products)){
                foreach ($products as $key => $value) {

                    $main_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id = '".$user_data->mainstore_id."' AND product_id = '".$value->product_id."' AND type_of_store = '2' GROUP BY product_id");
                    $main_stock = isset($main_stock) && !empty($main_stock) ? $main_stock[0]->stock : 0;

                    $main_wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE mainstore_id = '".$user_data->mainstore_id."' AND product_id = '".$value->product_id."' AND type_of_store = '2' GROUP BY product_id");
                    $main_wastage = isset($main_wastage) && !empty($main_wastage) ? $main_wastage[0]->wastage : 0;

                    if($subseed_stores_ids){
                        $subseed_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id = '".$user_data->mainstore_id."' AND product_id = '".$value->product_id."' AND subseedstore_id IN (".$subseed_stores_ids.") AND type_of_store = '3' GROUP BY product_id");
                        $subseed_stock = isset($subseed_stock) && !empty($subseed_stock) ? $subseed_stock[0]->stock : 0;

                        $subseed_wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE mainstore_id = '".$user_data->mainstore_id."' AND product_id = '".$value->product_id."' AND subseedstore_id IN (".$subseed_stores_ids.") AND type_of_store = '3' GROUP BY product_id");
                        $subseed_wastage = isset($subseed_wastage) && !empty($subseed_wastage) ? $subseed_wastage[0]->wastage : 0;

                    }else{
                        $subseed_stock = 0;
                        $subseed_wastage = 0;
                    }

                    $value->stock = $main_stock + $subseed_stock;
                    $value->wastage = $main_wastage + $subseed_wastage;

                    /*$substract = \DB::select("SELECT SUM(quentity) as substract FROM districtstoreproductstock WHERE product_id = '".$value->product_id."' AND type = 4 AND districtstore_id = '".$user_data->districtstore_id."' GROUP BY product_id");
                    $value->substract = isset($substract) && !empty($substract) ? $substract[0]->substract : 0;*/

                    $value->substract = 0;

                    $distribute = \DB::select("SELECT SUM(quentity) as distribute FROM subseedstoreproductstock WHERE subseedstore_id IN (".$subseed_stores_ids.") AND product_id = '".$value->product_id."' AND type = 2 GROUP BY product_id");
                    $value->distribute = isset($distribute) && !empty($distribute) ? $distribute[0]->distribute : 0;
                    
                    $dataArray[] = (array) $value;
                }
            }

            $data['rows'] = $dataArray; 
        }
         
        return view('admin.pages.balance.product', $data);
    }

    public function category(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $data['metadata'] = array(
            'page_title' => 'Type of Comodity',
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'serach_data' => [],
            'breadcumb' => array(
                    array(
                        'url' => '/dashboard',
                        'title' => 'Home',  
                    ),
                    array(
                        'url' => '',
                        'title' => $this->title,  
                    )
            ),
        );
        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $stocks = \DB::select("SELECT *, SUM(current_stock) as stock FROM current_stock_balance_sheet GROUP BY category_id");
                        
            $data['rows'] = $stocks;
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $stocks = \DB::select("SELECT *, SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE districtstore_id = '".$user_data->districtstore_id."' AND type_of_store = '1' GROUP BY category_id");

            $main_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM mainstore WHERE districtstore_id = '".$user_data->districtstore_id."'");
            $main_stores_ids = isset($main_stores_ids) && !empty($main_stores_ids) ? $main_stores_ids[0]->ids : '';

            if($main_stores_ids){
                $subseed_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM subseedstore WHERE mainstore_id IN (".$main_stores_ids.") AND districtstore_id = '".$user_data->districtstore_id."'");
                $subseed_stores_ids = isset($subseed_stores_ids) && !empty($subseed_stores_ids) ? $subseed_stores_ids[0]->ids : 0;
            }else{
                $subseed_stores_ids = 0;
            }
            

            if($stocks){
                foreach ($stocks as $key => $value) {
                    $main_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id IN (".$main_stores_ids.") AND brand_id = '".$value->brand_id."' AND districtstore_id = '".$user_data->districtstore_id."' AND type_of_store = '2' GROUP BY category_id");
                    $main_stock = isset($main_stock) && !empty($main_stock) ? $main_stock[0]->stock : 0;

                    $subseed_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id IN (".$main_stores_ids.") AND brand_id = '".$value->brand_id."' AND subseedstore_id IN (".$subseed_stores_ids.") AND type_of_store = '3' GROUP BY brand_id");
                    $subseed_stock = isset($subseed_stock) && !empty($subseed_stock) ? $subseed_stock[0]->stock : 0;

                    $stock = $main_stock + $subseed_stock + $value->stock;
                    $value->stock = $stock;
                }
            }
                        
            $data['rows'] = $stocks; 
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            $stocks = \DB::select("SELECT *, SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id = '".$user_data->mainstore_id."' AND type_of_store = '2' GROUP BY category_id");

            $subseed_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM subseedstore WHERE mainstore_id = '".$user_data->mainstore_id."'");
            $subseed_stores_ids = isset($subseed_stores_ids) && !empty($subseed_stores_ids) ? $subseed_stores_ids[0]->ids : 0;

            if($stocks){
                foreach ($stocks as $key => $value) {

                    $subseed_stock = \DB::select("SELECT SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE mainstore_id = '".$user_data->mainstore_id."' AND brand_id = '".$value->brand_id."' AND subseedstore_id IN (".$subseed_stores_ids.") AND type_of_store = '3' GROUP BY category_id");
                    $subseed_stock = isset($subseed_stock) && !empty($subseed_stock) ? $subseed_stock[0]->stock : 0;

                    $stock = $subseed_stock + $value->stock;
                    $value->stock = $stock;
                }
            }
                        
            $data['rows'] = $stocks; 
        }
         
        return view('admin.pages.balance.category', $data);
    }

}
