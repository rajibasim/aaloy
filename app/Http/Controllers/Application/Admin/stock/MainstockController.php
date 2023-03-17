<?php
namespace App\Http\Controllers\Application\Admin\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class MainstockController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/stock/main-store/admin-main-stock';
        $this->title = 'Main Stock';
        $this->table = 'mainstock';
    }

    /* List view */    
    public function index(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $district_id = $request->district_id;
        $districtstore_id = $request->districtstore_id;
        $mainstore_id = $request->mainstore_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;

        $where = array();
        $where = array(
            array('mainstoreproduct.is_deleted', '=', '0')
        );

        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($districtstore_id){
            array_push($where, array('mainstoreproduct.districtstore_id', '=', $districtstore_id));
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($mainstore_id){
            array_push($where, array('mainstoreproduct.mainstore_id', '=', $mainstore_id));
            $serach_data['mainstore_id'] = $mainstore_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            array_push($where, array('mainstoreproduct.product_id', '=', $product_id));
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
            $data['rows'] = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('mainstoreproduct.*', 'product.name as product_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('product', 'mainstoreproduct.product_id', '=', 'product.id'), array('mainstore', 'mainstoreproduct.mainstore_id', '=', 'mainstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            array_push($where, array('mainstoreproduct.districtstore_id', '=', $user_data->districtstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('mainstoreproduct.*', 'product.name as product_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('product', 'mainstoreproduct.product_id', '=', 'product.id'), array('mainstore', 'mainstoreproduct.mainstore_id', '=', 'mainstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            array_push($where, array('mainstoreproduct.mainstore_id', '=', $user_data->mainstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('mainstoreproduct.*', 'product.name as product_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('product', 'mainstoreproduct.product_id', '=', 'product.id'), array('mainstore', 'mainstoreproduct.mainstore_id', '=', 'mainstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
         
        return view('admin.pages.mainstock.view', $data);
    }

    /* Stock History */
    public function history(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $district_id = $request->district_id;
        $districtstore_id = $request->districtstore_id;
        $mainstore_id = $request->mainstore_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;
        $where = array();
        $where = array(
            array('mainstoreproductstock.is_deleted', '=', '0')
        );

        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($districtstore_id){
            array_push($where, array('mainstoreproductstock.districtstore_id', '=', $districtstore_id));
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($mainstore_id){
            array_push($where, array('mainstoreproductstock.mainstore_id', '=', $mainstore_id));
            $serach_data['mainstore_id'] = $mainstore_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            array_push($where, array('mainstoreproductstock.product_id', '=', $product_id));
            $serach_data['product_id'] = $product_id;
        }

        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => '/stock/main-store/admin-main-history',
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
            $data['rows'] = $this->CommonModel->get_all($table = 'mainstoreproductstock', $select = array('mainstoreproductstock.*', 'product.name as product_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('product', 'mainstoreproductstock.product_id', '=', 'product.id'), array('mainstore', 'mainstoreproductstock.mainstore_id', '=', 'mainstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");
            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            array_push($where, array('mainstoreproductstock.districtstore_id', '=', $user_data->districtstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'mainstoreproductstock', $select = array('mainstoreproductstock.*', 'product.name as product_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('product', 'mainstoreproductstock.product_id', '=', 'product.id'), array('mainstore', 'mainstoreproductstock.mainstore_id', '=', 'mainstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 
            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            array_push($where, array('mainstoreproductstock.mainstore_id', '=', $user_data->mainstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'mainstoreproductstock', $select = array('mainstoreproductstock.*', 'product.name as product_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('product', 'mainstoreproductstock.product_id', '=', 'product.id'), array('mainstore', 'mainstoreproductstock.mainstore_id', '=', 'mainstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 
            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        
        return view('admin.pages.mainstock.history', $data);
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

        $data['main_store'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('mainstore.*'), $where = array(array('mainstore.is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            $districtstore_id = \DB::select("SELECT * FROM `mainstore` WHERE `id` = '".$user_data->mainstore_id."'");
            $districtstore_id = isset($districtstore_id[0]) && !empty($districtstore_id[0]) ? $districtstore_id[0]->districtstore_id : 0; 
            $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('id', '=', $districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['main_store'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
        }  

        $data['subseed_store'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('subseedstore.*'), $where = array(array('subseedstore.is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");  

        $data['products'] = $this->CommonModel->get_all($table = 'product', $select = array('product.*', 'unit.name as unit', 'category.name as category', 'brand.name as brand'), $where = array(array('product.is_deleted', '=', 0)), $join = array(), $left = array(array('unit', 'product.unit_id', '=', 'unit.id'), array('category', 'product.category_id', '=', 'category.id'), array('brand', 'product.brand_id', '=', 'brand.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.mainstock.form', $data);
    }

    /* stock & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'date' => 'required',
            //'subseedstore_id' => 'required',
            'mainstore_id' => 'required',
            'type' => 'required',
            'product_id' => 'required',
            'quentity' => 'required',
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            $type = $request->input('type');
            $subseedstore_id = $request->input('subseedstore_id');
            $mainstore_id = $request->input('mainstore_id');
            $product_id = $request->input('product_id');
            $quentity = $request->input('quentity');
            $date = explode('/', $request->input('date'));
            $date = $date[2].'-'.$date[1].'-'.$date[0];
            $note = $request->input('note');
            
            //main store stock adjustment
            $details_main_store_product = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 

            if(isset($details_main_store_product) && empty($details_main_store_product)){
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Request product not avaliable right now.',
                );

                Session::put('flash_data', $flash_data); 
                return redirect($this->slug);
            }  

            $details_main_store_product = $details_main_store_product[0];


            $txn_details_main_store_product = $this->CommonModel->get_all($table = 'mainstoreproductstock', $select = array('*'), $where = array(array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($txn_details_main_store_product){
                $store_product_qty = $txn_details_main_store_product[0]->adjust_stock;
            }else{
                $store_product_qty = 0;
            }

            //main store banace sheet 
            $opening_balance = 0;
            $closing_balance = 0;
            $balancesheet_id = 0;
            $pre_open_balance = 0;
            $check_entry_exist = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $mainstore_id), array('product_id', '=', $product_id), array('type', '=', 2), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($check_entry_exist){
                $balancesheet_id = $check_entry_exist[0]->id;
                $opening_balance = $check_entry_exist[0]->opening_balance;
                $closing_balance = $check_entry_exist[0]->closing_balance;
                $pre_open_balance = $check_entry_exist[0]->closing_balance;
            }else{
                $check_entry_exist = \DB::select("select * from `balancesheet` where `store_id` = '".$mainstore_id."' and `product_id` = '".$product_id."' and `type` = 2 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                if($check_entry_exist){
                    $opening_balance = $check_entry_exist[0]->closing_balance;
                    $closing_balance = $check_entry_exist[0]->closing_balance;
                    $pre_open_balance = $check_entry_exist[0]->closing_balance;
                }
            }

            if($type == 2){
                //prevent negative stock
                if($details_main_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                //insert main product subseed stock table 
                $subseed_store_product_details = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $subseedstore_id), array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                if(empty($subseed_store_product_details)){
                    $subseed_store_product_details_array = array(
                        'subseedstore_id' => $subseedstore_id,
                        'mainstore_id' => $mainstore_id,
                        'product_id' => $product_id,
                        'current_stock' => $quentity,
                        'status' => 1,
                        'created_by' => $request->input('session_id'),
                        'updated_by' => $request->input('session_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $main_store_product_insert = $this->CommonModel->insert_data_get_id('subseedstoreproduct', $subseed_store_product_details_array);
                }else{
                    $subseed_store_product_details = $subseed_store_product_details[0];
                    $store_product_stock_details_array = array(
                        'current_stock' => ($subseed_store_product_details->current_stock + $quentity),
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_main_store_product_details = $this->CommonModel->update_data('subseedstoreproduct', array(array('mainstore_id', '=', $mainstore_id), array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $store_product_stock_details_array, $subseed_store_product_details, $subseed_store_product_details->id);

                } 

                $txn_subseed_store_product_stock = $this->CommonModel->get_all($table = 'subseedstoreproductstock', $select = array('*'), $where = array(array('subseedstore_id', '=', $subseedstore_id), array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($txn_subseed_store_product_stock){
                    $qty_main = $txn_subseed_store_product_stock[0]->quentity;
                }else{
                    $qty_main = 0;
                }

                $main_store_product_stock_array = array(
                    'entry_date' => $date,
                    'subseedstore_id' => $subseedstore_id,
                    'mainstore_id' => $mainstore_id,
                    'product_id' => $product_id,
                    'type' => 1,
                    'quentity' => $quentity,
                    'adjust_stock' => ($qty_main+$quentity),
                    'note' => $note ? $note : 'Stock entry by '.$request->input('main_store_name'),
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );


                $main_store_product_stock_insert = $this->CommonModel->insert_data_get_id('subseedstoreproductstock', $main_store_product_stock_array);

                //sub seed balance sheet
                $subseed_store_opening_balance = 0;
                $subseed_store_closing_balance = 0;
                $subseed_store_balancesheet_id = 0;
                $subseed_pre_open_balance = 0;

                $check_entry_exist_for_subseed_store = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $subseedstore_id), array('product_id', '=', $product_id), array('type', '=', 3), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($check_entry_exist_for_subseed_store){
                    $subseed_store_balancesheet_id = $check_entry_exist_for_subseed_store[0]->id;
                    $subseed_store_opening_balance = $check_entry_exist_for_subseed_store[0]->opening_balance;
                    $subseed_store_closing_balance = $check_entry_exist_for_subseed_store[0]->closing_balance;
                    $subseed_pre_open_balance = $check_entry_exist_for_subseed_store[0]->closing_balance;
                }else{
                    $check_entry_exist_for_subseed_store = \DB::select("select * from `balancesheet` where `store_id` = '".$subseedstore_id."' and `product_id` = '".$product_id."' and `type` = 3 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                    if($check_entry_exist_for_subseed_store){
                        $subseed_store_opening_balance = $check_entry_exist_for_subseed_store[0]->closing_balance;
                        $subseed_pre_open_balance = $check_entry_exist_for_subseed_store[0]->closing_balance;
                    }
                }

                $dist_pro_adjust_stock = $store_product_qty - $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance - $quentity;
                $subseed_store_closing_balance = $subseed_pre_open_balance + $quentity;
            }

            if($type == 3){

                $main_store_district_id = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('id', '=', $mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_district_id = !empty($main_store_district_id) ? $main_store_district_id[0]->districtstore_id : 0; 

                //district name 
                $main_store_district_name = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('id', '=', $main_store_district_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_district_name = !empty($main_store_district_name) ? $main_store_district_name[0]->name : 0; 


                $main_store_district_stock = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $main_store_district_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

                if(empty($main_store_district_stock)){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                } 

                $main_store_district_stock = $main_store_district_stock[0];
                if($main_store_district_stock->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                //update district stock
                $post_data = array(
                    'entry_date' => $date,
                    'districtstore_id' => $main_store_district_id,
                    'product_id' => $product_id,
                    'type' => $type,
                    'quentity' => $quentity,
                    'adjust_stock' => ($main_store_district_stock->current_stock-$quentity),
                    'note' => "Add Adjustment by ".$main_store_district_name,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id('districtstoreproductstock', $post_data);

                //update district product table
                $old_data = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $main_store_district_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $update_pro = array(
                    'current_stock' => ($main_store_district_stock->current_stock-$quentity),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('districtstoreproduct', array(array('districtstore_id', '=', $main_store_district_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $main_store_district_stock->id);


                //update or entry district store opening & closing stock
                $district_store_opening_balance = 0;
                $district_store_closing_balance = 0;
                $district_store_balancesheet_id = 0;
                $district_pre_open_balance = 0;

                $check_entry_exist_for_district_store = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $main_store_district_id), array('product_id', '=', $product_id), array('type', '=', 1), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($check_entry_exist_for_district_store){
                    $district_store_balancesheet_id = $check_entry_exist_for_district_store[0]->id;
                    $district_store_opening_balance = $check_entry_exist_for_district_store[0]->opening_balance;
                    $district_store_closing_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                    $district_pre_open_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                }else{
                    $check_entry_exist_for_district_store = \DB::select("select * from `balancesheet` where `store_id` = '".$main_store_district_id."' and `product_id` = '".$product_id."' and `type` = 1 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                    if($check_entry_exist_for_district_store){
                        $district_store_opening_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                        $district_pre_open_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                    }
                }


                $dist_pro_adjust_stock = $store_product_qty + $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance + $quentity;
                $district_store_closing_balance = $district_pre_open_balance - $quentity;
            }

            if($type == 4){

                //prevent negative stock
                if($details_main_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                $main_store_district_id = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('id', '=', $mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_district_id = !empty($main_store_district_id) ? $main_store_district_id[0]->districtstore_id : 0; 

                //district name 
                $main_store_district_name = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('id', '=', $main_store_district_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_district_name = !empty($main_store_district_name) ? $main_store_district_name[0]->name : 0; 


                $main_store_district_stock = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $main_store_district_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

                if(empty($main_store_district_stock)){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                } 

                $main_store_district_stock = $main_store_district_stock[0];


                //update district stock
                $post_data = array(
                    'entry_date' => $date,
                    'districtstore_id' => $main_store_district_id,
                    'product_id' => $product_id,
                    'type' => $type,
                    'quentity' => $quentity,
                    'adjust_stock' => ($main_store_district_stock->current_stock+$quentity),
                    'note' => "Substract Adjustment by ".$main_store_district_name,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id('districtstoreproductstock', $post_data);

                //update district product table
                $old_data = $this->CommonModel->get_all($table = 'districtstoreproduct', $select = array('*'), $where = array(array('districtstore_id', '=', $main_store_district_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $update_pro = array(
                    'current_stock' => ($main_store_district_stock->current_stock+$quentity),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('districtstoreproduct', array(array('districtstore_id', '=', $main_store_district_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $main_store_district_stock->id);


                //update or entry district store opening & closing stock
                $district_store_opening_balance = 0;
                $district_store_closing_balance = 0;
                $district_store_balancesheet_id = 0;
                $district_pre_open_balance = 0;

                $check_entry_exist_for_district_store = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $main_store_district_id), array('product_id', '=', $product_id), array('type', '=', 1), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($check_entry_exist_for_district_store){
                    $district_store_balancesheet_id = $check_entry_exist_for_district_store[0]->id;
                    $district_store_opening_balance = $check_entry_exist_for_district_store[0]->opening_balance;
                    $district_store_closing_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                    $district_pre_open_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                }else{
                    $check_entry_exist_for_district_store = \DB::select("select * from `balancesheet` where `store_id` = '".$main_store_district_id."' and `product_id` = '".$product_id."' and `type` = 1 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                    if($check_entry_exist_for_district_store){
                        $district_store_opening_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                        $district_pre_open_balance = $check_entry_exist_for_district_store[0]->closing_balance;
                    }
                }

                $dist_pro_adjust_stock = $store_product_qty - $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance - $quentity;
                $district_store_closing_balance = $district_pre_open_balance + $quentity;
            }

            if($type == 5){
                //prevent negative stock
                if($details_main_store_product->current_stock < $quentity){
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
            $districtstore_id = 0;
            $districtstore_id = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('id', '=', $mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            if($districtstore_id){
                $districtstore_id = $districtstore_id[0]->districtstore_id;
            }


            $post_data_arr = array(
                'entry_date' => $date,
                'mainstore_id' => $mainstore_id,
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

            $result = $this->CommonModel->insert_data_get_id('mainstoreproductstock', $post_data_arr);

            //update main product table
            $old_data = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $old_data = $old_data[0];

            $update_pro = array(
                'current_stock' => $dist_pro_current_stock,
                'updated_by' => $request->input('session_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = $this->CommonModel->update_data('mainstoreproduct', array(array('mainstore_id', '=', $mainstore_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $details_main_store_product->id);

            //insert & update main store banace sheet
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
                    'store_id' => $mainstore_id,
                    'product_id' => $product_id,
                    'type' => 2,
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

            //insert into main history table
            $main_store_history = array(
                'entry_date' => $date,
                'store_id' => $districtstore_id,
                'product_id' => $product_id,
                'type' => 2,
                'opening_balance' => $pre_open_balance,
                'closing_balance' => $closing_balance,
                'status' => 1,
                'created_by' => $request->input('session_id'),
                'updated_by' => $request->input('session_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $main_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $main_store_history);

            if($type == 2){
                //for subseed store
                if($subseed_store_balancesheet_id > 0){
                    $old_check_entry_exist_for_subseed_store = $check_entry_exist_for_subseed_store[0];
                    $subseed_store_balancesheet_array = array(
                        'closing_balance' => $subseed_store_closing_balance,
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $subseed_store_balancesheet_id)), $subseed_store_balancesheet_array, $old_check_entry_exist_for_subseed_store, $subseed_store_balancesheet_id);
                }else{
                    $subseed_store_balancesheet_array = array(
                        'entry_date' => $date,
                        'store_id' => $subseedstore_id,
                        'product_id' => $product_id,
                        'type' => 3,
                        'opening_balance' => $subseed_store_opening_balance,
                        'closing_balance' => $subseed_store_closing_balance,
                        'status' => 1,
                        'created_by' => $request->input('session_id'),
                        'updated_by' => $request->input('session_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $subseed_balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $subseed_store_balancesheet_array);
                }

                //insert into subseed history table
                $subseed_store_history = array(
                    'entry_date' => $date,
                    'store_id' => $subseedstore_id,
                    'product_id' => $product_id,
                    'type' => 3,
                    'opening_balance' => $subseed_pre_open_balance,
                    'closing_balance' => $subseed_store_closing_balance,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $subseed_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $subseed_store_history);
            }

            if($type == 3){
                //for district store
                if($district_store_balancesheet_id > 0){
                    $old_check_entry_exist_for_district_store = $check_entry_exist_for_district_store[0];
                    $district_store_balancesheet_array = array(
                        'closing_balance' => $district_store_closing_balance,
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $district_store_balancesheet_id)), $district_store_balancesheet_array, $old_check_entry_exist_for_district_store, $district_store_balancesheet_id);
                }else{
                    $district_store_balancesheet_array = array(
                        'entry_date' => $date,
                        'store_id' => $districtstore_id,
                        'product_id' => $product_id,
                        'type' => 1,
                        'opening_balance' => $district_store_opening_balance,
                        'closing_balance' => $district_store_closing_balance,
                        'status' => 1,
                        'created_by' => $request->input('session_id'),
                        'updated_by' => $request->input('session_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $district_balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $district_store_balancesheet_array);
                }

                //insert into district history table
                $district_store_history = array(
                    'entry_date' => $date,
                    'store_id' => $districtstore_id,
                    'product_id' => $product_id,
                    'type' => 1,
                    'opening_balance' => $district_pre_open_balance,
                    'closing_balance' => $district_store_closing_balance,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $district_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $district_store_history);
            }

            if($type == 4){
                //for district store
                if($district_store_balancesheet_id > 0){
                    $old_check_entry_exist_for_district_store = $check_entry_exist_for_district_store[0];
                    $district_store_balancesheet_array = array(
                        'closing_balance' => $district_store_closing_balance,
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $district_store_balancesheet_id)), $district_store_balancesheet_array, $old_check_entry_exist_for_district_store, $district_store_balancesheet_id);
                }else{
                    $district_store_balancesheet_array = array(
                        'entry_date' => $date,
                        'store_id' => $districtstore_id,
                        'product_id' => $product_id,
                        'type' => 1,
                        'opening_balance' => $district_store_opening_balance,
                        'closing_balance' => $district_store_closing_balance,
                        'status' => 1,
                        'created_by' => $request->input('session_id'),
                        'updated_by' => $request->input('session_id'),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $district_balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $district_store_balancesheet_array);
                }

                //insert into district history table
                $district_store_history = array(
                    'entry_date' => $date,
                    'store_id' => $districtstore_id,
                    'product_id' => $product_id,
                    'type' => 1,
                    'opening_balance' => $district_pre_open_balance,
                    'closing_balance' => $district_store_closing_balance,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $district_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $district_store_history);
            }


            if($result == true && $balancesheet_id == true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => 'Main store stock operation success executed.',
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
                'message' => 'main stock successfully deleted.',
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
