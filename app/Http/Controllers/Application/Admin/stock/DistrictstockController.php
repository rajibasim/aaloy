<?php
namespace App\Http\Controllers\Application\Admin\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class DistrictstockController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/stock/district-store/admin-district-stock';
        $this->title = 'District Stock';
        //$this->table = 'districtstock';
    }

    /* List view */    
    public function index(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $district_id = $request->district_id;
        $districtstore_id = $request->districtstore_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;
        $where = array();
        $where = array(
            array('districtstoreproduct.is_deleted', '=', '0')
        );
        if($districtstore_id){
            array_push($where, array('districtstoreproduct.districtstore_id', '=', $districtstore_id));
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            array_push($where, array('districtstoreproduct.product_id', '=', $product_id));
            $serach_data['product_id'] = $product_id;
        }

        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'serach_data' => $serach_data,
            'breadcumb' => array(
                    array(
                        'url' => '/dashboard',
                        'title' => 'Home',  
                    ),
                    array(
                        'url' => '',
                        'title' => $this->title,  
                    ),
            ),
        );

        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $data['rows'] = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('districtstoreproduct.*', 'product.name as product_name', 'districtstore.name as districtstore_name'), $where, $join = array(), $left = array(array('product', 'districtstoreproduct.product_id', '=', 'product.id'), array('districtstore', 'districtstoreproduct.districtstore_id', '=', 'districtstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){

            array_push($where, array('districtstoreproduct.districtstore_id', '=', $user_data->districtstore_id));

            $data['rows'] = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('districtstoreproduct.*', 'product.name as product_name', 'districtstore.name as districtstore_name'), $where, $join = array(), $left = array(array('product', 'districtstoreproduct.product_id', '=', 'product.id'), array('districtstore', 'districtstoreproduct.districtstore_id', '=', 'districtstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
         
        return view('admin.pages.districtstock.view', $data);
    }

    /* Stock History */
    public function history(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        
        $serach_data = array();
        $district_id = $request->district_id;
        $districtstore_id = $request->districtstore_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;
        $where = array();
        $where = array(
            array('districtstoreproductstock.is_deleted', '=', '0')
        );
        if($districtstore_id){
            array_push($where, array('districtstoreproductstock.districtstore_id', '=', $districtstore_id));
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            array_push($where, array('districtstoreproductstock.product_id', '=', $product_id));
            $serach_data['product_id'] = $product_id;
        }

        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => "/stock/district-store/admin-district-history",
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'serach_data' => $serach_data,
            'breadcumb' => array(
                    array(
                        'url' => '/dashboard',
                        'title' => 'Home',  
                    ),
                    array(
                        'url' => '',
                        'title' => $this->title,  
                    ),
            ),
        );

        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $data['rows'] = $this->CommonModel->get_all($table = 'districtstoreproductstock', $select = array('districtstoreproductstock.*', 'product.name as product_name', 'districtstore.name as districtstore_name'), $where, $join = array(), $left = array(array('product', 'districtstoreproductstock.product_id', '=', 'product.id'), array('districtstore', 'districtstoreproductstock.districtstore_id', '=', 'districtstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){

            array_push($where, array('districtstoreproductstock.districtstore_id', '=', $user_data->districtstore_id));

            $data['rows'] = $this->CommonModel->get_all($table = 'districtstoreproductstock', $select = array('districtstoreproductstock.*', 'product.name as product_name', 'districtstore.name as districtstore_name'), $where, $join = array(), $left = array(array('product', 'districtstoreproductstock.product_id', '=', 'product.id'), array('districtstore', 'districtstoreproductstock.districtstore_id', '=', 'districtstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
         
        return view('admin.pages.districtstock.history', $data);
    }

    /* add & edit form */
    public function form(Request $request, $id = null){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $data['metadata'] = array(
            'page_title' => $id > 0 ? $this->title.' Edit' : $this->title.' Add',
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
                    ),
                    array(
                        'url' => '',
                        'title' => $id > 0 ? 'Edit' : 'Add',  
                    ),
            ),
        );

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $data['district_store'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('districtstore.*', 'district.name as district'), $where = array(array('districtstore.is_deleted', '=', 0)), $join = array(), $left = array(array('district', 'districtstore.district_id', '=', 'district.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $data['district_store'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('districtstore.*', 'district.name as district'), $where = array(array('districtstore.is_deleted', '=', 0), array('districtstore.id', '=', $user_data->districtstore_id)), $join = array(), $left = array(array('district', 'districtstore.district_id', '=', 'district.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
        }    

        $data['products'] = $this->CommonModel->get_all($table = 'product', $select = array('product.*', 'unit.name as unit', 'category.name as category', 'brand.name as brand'), $where = array(array('product.is_deleted', '=', 0)), $join = array(), $left = array(array('unit', 'product.unit_id', '=', 'unit.id'), array('category', 'product.category_id', '=', 'category.id'), array('brand', 'product.brand_id', '=', 'brand.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['main_store'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('mainstore.*', 'districtstore.name as districtstorename'), $where = array(array('mainstore.is_deleted', '=', 0)), $join = array(), $left = array(array('districtstore', 'mainstore.districtstore_id', '=', 'districtstore.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.districtstock.form', $data);
    }

    /* stock & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'date' => 'required',
            'districtstore_id' => 'required',
            'type' => 'required',
            'product_id' => 'required',
            'quentity' => 'required',
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            $type = $request->input('type');
            $districtstore_id = $request->input('districtstore_id');
            $mainstore_id = $request->input('mainstore_id');
            $product_id = $request->input('product_id');
            $quentity = $request->input('quentity');
            $date = explode('/', $request->input('date'));
            $date = $date[2].'-'.$date[1].'-'.$date[0];
            $note = $request->input('note');
            //check product exist or not for this distraict
            $check_district_store_product = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $districtstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
            if(empty($check_district_store_product)){
                $dist_str_pro_array = array(
                    'districtstore_id' => $districtstore_id,
                    'product_id' => $product_id,
                    'current_stock' => 0,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $insert_dist_str_pro = $this->CommonModel->insert_data_get_id('districtstoreproduct', $dist_str_pro_array);
            } 

            //district store stock adjustment
            $details_district_store_product = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $districtstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");   
            $details_district_store_product = $details_district_store_product[0];


            $txn_details_district_store_product = $this->CommonModel->get_all($table = 'districtstoreproductstock', $select = array('*'), $where = array(array('districtstore_id', '=', $districtstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($txn_details_district_store_product){
                $store_product_qty = $txn_details_district_store_product[0]->adjust_stock;
            }else{
                $store_product_qty = 0;
            }

            $opening_balance = 0;
            $closing_balance = 0;
            $balancesheet_id = 0;
            $pre_open_balance = 0;
            $check_entry_exist = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $districtstore_id), array('product_id', '=', $product_id), array('type', '=', 1), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($check_entry_exist){
                $balancesheet_id = $check_entry_exist[0]->id;
                $opening_balance = $check_entry_exist[0]->opening_balance;
                $closing_balance = $check_entry_exist[0]->closing_balance;
                $pre_open_balance = $check_entry_exist[0]->closing_balance;
            }else{
                $check_entry_exist = \DB::select("select * from `balancesheet` where `store_id` = '".$districtstore_id."' and `product_id` = '".$product_id."' and `type` = 1 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                if($check_entry_exist){
                    $opening_balance = $check_entry_exist[0]->closing_balance;
                    $closing_balance = $check_entry_exist[0]->closing_balance;
                    $pre_open_balance = $check_entry_exist[0]->closing_balance;
                }
            }

            if($type == 1){
                //insert main product district stock table 
                $details = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");  
                $product_details = $details[0];

                $txn_details = $this->CommonModel->get_all($table = 'productstock', $select = array('*'), $where = array(array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($txn_details){
                    $qty = $txn_details[0]->adjust_stock;
                }else{
                    $qty = 0;
                }

                $adjust_stock = $qty + $quentity;
                $current_stock = $adjust_stock;

                $post_data = array(
                    'entry_date' => $date,
                    'product_id' => $product_id,
                    'type' => 3,
                    'quentity' => $quentity,
                    'adjust_stock' => $adjust_stock,
                    'note' => $note ? $note : 'Stock entry by '.$request->input('district_name'),
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $insert_productstock = $this->CommonModel->insert_data_get_id('productstock', $post_data);
                //update product master table
                $old_data = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];
                $update_pro = array(
                    'current_stock' => $current_stock,
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('product', array(array('id', '=', $product_id)), $update_pro, $old_data, $product_id);

                $dist_pro_adjust_stock = $store_product_qty + $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance + $quentity;
            }

            if($type == 2){
                //prevent negative stock
                if($details_district_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                //insert main product district stock table 
                $main_store_product_details = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $districtstore_id), array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                if(empty($main_store_product_details)){
                    $store_product_stock_details_array = array(
                        'districtstore_id' => $districtstore_id,
                        'mainstore_id' => $mainstore_id,
                        'product_id' => $product_id,
                        'current_stock' => $quentity,
                        'status' => 1,
                        'created_by' => $request->input('session_id'),
                        'updated_by' => $request->input('session_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $main_store_product_insert = $this->CommonModel->insert_data_get_id('mainstoreproduct', $store_product_stock_details_array);
                }else{
                    $main_store_product_details = $main_store_product_details[0];
                    $store_product_stock_details_array = array(
                        'current_stock' => ($main_store_product_details->current_stock + $quentity),
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_main_store_product_details = $this->CommonModel->update_data('mainstoreproduct', array(array('districtstore_id', '=', $districtstore_id), array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $store_product_stock_details_array, $main_store_product_details, $main_store_product_details->id);

                } 

                $txn_main_store_product_stock = $this->CommonModel->get_all($table = 'mainstoreproductstock', $select = array('*'), $where = array(array('districtstore_id', '=', $districtstore_id), array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($txn_main_store_product_stock){
                    $qty_main = $txn_main_store_product_stock[0]->quentity;
                }else{
                    $qty_main = 0;
                }

                $main_store_product_stock_array = array(
                    'entry_date' => $date,
                    'districtstore_id' => $districtstore_id,
                    'mainstore_id' => $mainstore_id,
                    'product_id' => $product_id,
                    'type' => 1,
                    'quentity' => $quentity,
                    'adjust_stock' => ($qty_main+$quentity),
                    'note' => $note ? $note : 'Stock entry by '.$request->input('district_name'),
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );


                $main_store_product_stock_insert = $this->CommonModel->insert_data_get_id('mainstoreproductstock', $main_store_product_stock_array);

                //update or entry main store opening & closing stock
                $main_store_opening_balance = 0;
                $main_store_closing_balance = 0;
                $main_store_balancesheet_id = 0;
                $main_pre_open_balance = 0;

                $check_entry_exist_for_main_store = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $mainstore_id), array('product_id', '=', $product_id), array('type', '=', 2), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($check_entry_exist_for_main_store){
                    $main_store_balancesheet_id = $check_entry_exist_for_main_store[0]->id;
                    $main_store_opening_balance = $check_entry_exist_for_main_store[0]->opening_balance;
                    $main_store_closing_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                    $main_pre_open_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                }else{
                    $check_entry_exist_for_main_store = \DB::select("select * from `balancesheet` where `store_id` = '".$mainstore_id."' and `product_id` = '".$product_id."' and `type` = 2 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                    if($check_entry_exist_for_main_store){
                        $main_store_opening_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                        $main_pre_open_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                    }
                }

                $dist_pro_adjust_stock = $store_product_qty - $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance - $quentity;
                $main_store_closing_balance = $main_pre_open_balance + $quentity;
            }

            if($type == 3){
                $dist_pro_adjust_stock = $store_product_qty + $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance + $quentity;
            }

            if($type == 4){
                //prevent negative stock
                if($details_district_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                $dist_pro_adjust_stock = $store_product_qty - $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance - $quentity;
            }

            if($type == 5){
                //prevent negative stock
                if($details_district_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }
                
                $dist_pro_adjust_stock = $store_product_qty - $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance - $quentity;
            }

            $post_data = array(
                'entry_date' => $date,
                'districtstore_id' => $districtstore_id,
                'product_id' => $product_id,
                'type' => $type,
                'quentity' => $quentity,
                'adjust_stock' => $dist_pro_adjust_stock,
                'note' => $request->input('note'),
                'status' => 1,
                'created_by' => $request->input('session_id'),
                'updated_by' => $request->input('session_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $result = $this->CommonModel->insert_data_get_id('districtstoreproductstock', $post_data);

            //update district product table
            $old_data = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $districtstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $old_data = $old_data[0];

            $update_pro = array(
                'current_stock' => $dist_pro_current_stock,
                'updated_by' => $request->input('session_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = $this->CommonModel->update_data('districtstoreproduct', array(array('districtstore_id', '=', $districtstore_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $details_district_store_product->id);

            //insert or update balance sheet
            if($balancesheet_id > 0){
                $old_check_entry_exist = $check_entry_exist[0];
                $balancesheet_array = array(
                    'closing_balance' => $closing_balance,
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $balancesheet_id)), $balancesheet_array, $old_check_entry_exist, $balancesheet_id);
            }else{
                $balancesheet_array = array(
                    'entry_date' => $date,
                    'store_id' => $districtstore_id,
                    'product_id' => $product_id,
                    'type' => 1,
                    'opening_balance' => $opening_balance,
                    'closing_balance' => $closing_balance,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $balancesheet_array);
            }

            //insert into district history table
            $district_store_history = array(
                'entry_date' => $date,
                'store_id' => $districtstore_id,
                'product_id' => $product_id,
                'type' => 1,
                'opening_balance' => $pre_open_balance,
                'closing_balance' => $closing_balance,
                'status' => 1,
                'created_by' => $request->input('session_id'),
                'updated_by' => $request->input('session_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $dist_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $district_store_history);

            if($type == 2){
                //for main store
                if($main_store_balancesheet_id > 0){
                    $old_check_entry_exist_for_main_store = $check_entry_exist_for_main_store[0];
                    $main_store_balancesheet_array = array(
                        'closing_balance' => $main_store_closing_balance,
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $main_store_balancesheet_id)), $main_store_balancesheet_array, $old_check_entry_exist_for_main_store, $main_store_balancesheet_id);
                }else{
                    $main_store_balancesheet_array = array(
                        'entry_date' => $date,
                        'store_id' => $mainstore_id,
                        'product_id' => $product_id,
                        'type' => 2,
                        'opening_balance' => $main_store_opening_balance,
                        'closing_balance' => $main_store_closing_balance,
                        'status' => 1,
                        'created_by' => $request->input('session_id'),
                        'updated_by' => $request->input('session_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $main_balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $main_store_balancesheet_array);
                }

                //insert into main history table
                $main_store_history = array(
                    'entry_date' => $date,
                    'store_id' => $mainstore_id,
                    'product_id' => $product_id,
                    'type' => 2,
                    'opening_balance' => $main_pre_open_balance,
                    'closing_balance' => $main_store_closing_balance,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $main_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $main_store_history);
            }

            if($result == true && $balancesheet_id = true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => 'District stock operation success executed.',
                );
            }else{
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Something went wrong try again later.',
                );
            }

            Session::put('flash_data', $flash_data); 
            return redirect($this->slug);                
        }
    }

    /* delete multiple & single */
    public function delete(Request $request, $id = null){
        if($id){
            $ids = explode(',', $id);
            foreach ($ids as $key => $id) {
                $post_data = array();
                $post_data = array(
                    'is_deleted' => 1,
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->soft_delete($this->table, array(array('id', '=', $id)), $post_data, $id);
            }
            $flash_data = array(
                'status' => 'success',
                'message' => 'District stock successfully deleted.',
            );
        }else{
            $flash_data = array(
                'status' => 'danger',
                'message' => 'Something went wrong try again later.',
            );
        }

        Session::put('flash_data', $flash_data); 
        return redirect($this->slug);
    }
}
