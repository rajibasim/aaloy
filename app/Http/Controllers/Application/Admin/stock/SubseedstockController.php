<?php
namespace App\Http\Controllers\Application\Admin\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class SubseedstockController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/stock/subseed-store/admin-subseed-stock';
        $this->title = 'Sub-Seed Stock';
        $this->table = 'subseedstock';
    }

    /* List view */    
    public function index(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $district_id = $request->district_id;
        $districtstore_id = $request->districtstore_id;
        $mainstore_id = $request->mainstore_id;
        $subseedstore_id = $request->subseedstore_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;

        $where = array();
        $where = array(
            array('subseedstoreproduct_view.is_deleted', '=', '0')
        );

        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($districtstore_id){
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($mainstore_id){
            array_push($where, array('subseedstoreproduct_view.mainstore_id', '=', $mainstore_id));
            $serach_data['mainstore_id'] = $mainstore_id;
        }

        if($subseedstore_id){
            array_push($where, array('subseedstoreproduct_view.subseedstore_id', '=', $subseedstore_id));
            $serach_data['subseedstore_id'] = $subseedstore_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            array_push($where, array('subseedstoreproduct_view.product_id', '=', $product_id));
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
            $data['rows'] = $this->CommonModel->get_all($table = 'subseedstoreproduct_view', $select = array('subseedstoreproduct_view.*', 'product.name as product_name', 'subseedstore.name as subseedstore_name'), $where, $join = array(), $left = array(array('product', 'subseedstoreproduct_view.product_id', '=', 'product.id'), array('subseedstore', 'subseedstoreproduct_view.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            array_push($where, array('subseedstoreproduct_view.districtstore_id', '=', $user_data->districtstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'subseedstoreproduct_view', $select = array('subseedstoreproduct_view.*', 'product.name as product_name', 'subseedstore.name as subseedstore_name'), $where, $join = array(), $left = array(array('product', 'subseedstoreproduct_view.product_id', '=', 'product.id'), array('subseedstore', 'subseedstoreproduct_view.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            array_push($where, array('subseedstoreproduct_view.mainstore_id', '=', $user_data->mainstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'subseedstoreproduct_view', $select = array('subseedstoreproduct_view.*', 'product.name as product_name', 'subseedstore.name as subseedstore_name'), $where, $join = array(), $left = array(array('product', 'subseedstoreproduct_view.product_id', '=', 'product.id'), array('subseedstore', 'subseedstoreproduct_view.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.mainstore_id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }


        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.subseedstock.view', $data);
    }

    /* Stock History */
    public function history(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $district_id = $request->district_id;
        $districtstore_id = $request->districtstore_id;
        $mainstore_id = $request->mainstore_id;
        $subseedstore_id = $request->subseedstore_id;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $product_id = $request->product_id;

        $where = array();
        $where = array(
            array('subseedstoreproductstockstock_view.is_deleted', '=', '0')
        );

        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($districtstore_id){
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($mainstore_id){
            array_push($where, array('subseedstoreproductstockstock_view.mainstore_id', '=', $mainstore_id));
            $serach_data['mainstore_id'] = $mainstore_id;
        }

        if($subseedstore_id){
            array_push($where, array('subseedstoreproductstockstock_view.subseedstore_id', '=', $subseedstore_id));
            $serach_data['subseedstore_id'] = $subseedstore_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            array_push($where, array('subseedstoreproductstockstock_view.product_id', '=', $product_id));
            $serach_data['product_id'] = $product_id;
        }

        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => '/stock/subseed-store/admin-subseed-history',
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
            $data['rows'] = $this->CommonModel->get_all($table = 'subseedstoreproductstockstock_view', $select = array('subseedstoreproductstockstock_view.*', 'product.name as product_name', 'subseedstore.name as subseedstore_name'), $where, $join = array(), $left = array(array('product', 'subseedstoreproductstockstock_view.product_id', '=', 'product.id'), array('subseedstore', 'subseedstoreproductstockstock_view.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }


        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            array_push($where, array('subseedstoreproductstockstock_view.districtstore_id', '=', $user_data->districtstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'subseedstoreproductstockstock_view', $select = array('subseedstoreproductstockstock_view.*', 'product.name as product_name', 'subseedstore.name as subseedstore_name'), $where, $join = array(), $left = array(array('product', 'subseedstoreproductstockstock_view.product_id', '=', 'product.id'), array('subseedstore', 'subseedstoreproductstockstock_view.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            array_push($where, array('subseedstoreproductstockstock_view.mainstore_id', '=', $user_data->mainstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = 'subseedstoreproductstockstock_view', $select = array('subseedstoreproductstockstock_view.*', 'product.name as product_name', 'subseedstore.name as subseedstore_name'), $where, $join = array(), $left = array(array('product', 'subseedstoreproductstockstock_view.product_id', '=', 'product.id'), array('subseedstore', 'subseedstoreproductstockstock_view.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25"); 

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.mainstore_id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
 
        return view('admin.pages.subseedstock.history', $data);
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

        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $data['subseed_store'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('subseedstore.*'), $where = array(array('subseedstore.is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){            
            $data['subseed_store'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('subseedstore.*'), $where = array(array('subseedstore.is_deleted', '=', 0), array('subseedstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            $data['subseed_store'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('subseedstore.*'), $where = array(array('subseedstore.is_deleted', '=', 0), array('subseedstore.mainstore_id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");    

        $data['products'] = $this->CommonModel->get_all($table = 'product', $select = array('product.*', 'unit.name as unit', 'category.name as category', 'brand.name as brand'), $where = array(array('product.is_deleted', '=', 0)), $join = array(), $left = array(array('unit', 'product.unit_id', '=', 'unit.id'), array('category', 'product.category_id', '=', 'category.id'), array('brand', 'product.brand_id', '=', 'brand.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.subseedstock.form', $data);
    }

    /* stock & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'date' => 'required',
            'subseedstore_id' => 'required',
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
            $product_id = $request->input('product_id');
            $quentity = $request->input('quentity');
            $date = explode('/', $request->input('date'));
            $date = $date[2].'-'.$date[1].'-'.$date[0];
            $note = $request->input('note');
            
            //subseed store stock adjustment
            $details_subseed_store_product = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $subseedstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");   

            if(empty($details_subseed_store_product)){
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Request stock not avaliable right now.',
                );

                Session::put('flash_data', $flash_data); 
                return redirect($this->slug);
            }

            $details_subseed_store_product = $details_subseed_store_product[0];

            $txn_details_subseed_store_product = $this->CommonModel->get_all($table = 'subseedstoreproductstock', $select = array('*'), $where = array(array('subseedstore_id', '=', $subseedstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($txn_details_subseed_store_product){
                $store_product_qty = $txn_details_subseed_store_product[0]->adjust_stock;
            }else{
                $store_product_qty = 0;
            }

            //main store banace sheet 
            $opening_balance = 0;
            $closing_balance = 0;
            $balancesheet_id = 0;
            $pre_open_balance = 0;
            $check_entry_exist = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $subseedstore_id), array('product_id', '=', $product_id), array('type', '=', 3), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($check_entry_exist){
                $balancesheet_id = $check_entry_exist[0]->id;
                $opening_balance = $check_entry_exist[0]->opening_balance;
                $closing_balance = $check_entry_exist[0]->closing_balance;
                $pre_open_balance = $check_entry_exist[0]->closing_balance;
            }else{
                $check_entry_exist = \DB::select("select * from `balancesheet` where `store_id` = '".$subseedstore_id."' and `product_id` = '".$product_id."' and `type` = 3 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                if($check_entry_exist){
                    $opening_balance = $check_entry_exist[0]->closing_balance;
                    $closing_balance = $check_entry_exist[0]->closing_balance;
                    $pre_open_balance = $check_entry_exist[0]->closing_balance;
                }
            }

            if($type == 3){
                $subseed_store = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('id', '=', $subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_id = !empty($subseed_store) ? $subseed_store[0]->mainstore_id : 0;


                //main store name 
                $main_store = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('id', '=', $main_store_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_name = !empty($main_store) ? $main_store[0]->name : 0;
                $main_store_district_id = !empty($main_store) ? $main_store[0]->districtstore_id : 0;

                $main_store_stock = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('mainstore_id', '=', $main_store_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

                if(empty($main_store_stock)){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                } 

                $main_store_stock = $main_store_stock[0];
                if($main_store_stock->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                //update main store stock
                $post_data = array(
                    'entry_date' => $date,
                    'districtstore_id' => $main_store_district_id,
                    'mainstore_id' => $main_store_id,
                    'product_id' => $product_id,
                    'type' => $type,
                    'quentity' => $quentity,
                    'adjust_stock' => ($main_store_stock->current_stock-$quentity),
                    'note' => "Add Adjustment by ".$main_store_name,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id('mainstoreproductstock', $post_data);

                //update district product table
                $old_data = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('mainstore_id', '=', $main_store_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $update_pro = array(
                    'current_stock' => ($main_store_stock->current_stock-$quentity),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('mainstoreproduct', array(array('mainstore_id', '=', $main_store_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $subseed_store[0]->id);


                //update or entry main store opening & closing stock
                $main_store_opening_balance = 0;
                $main_store_closing_balance = 0;
                $main_store_balancesheet_id = 0;
                $main_pre_open_balance = 0;

                $check_entry_exist_for_main_store = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $main_store_id), array('product_id', '=', $product_id), array('type', '=', 2), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($check_entry_exist_for_main_store){
                    $main_store_balancesheet_id = $check_entry_exist_for_main_store[0]->id;
                    $main_store_opening_balance = $check_entry_exist_for_main_store[0]->opening_balance;
                    $main_store_closing_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                    $main_pre_open_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                }else{
                    $check_entry_exist_for_main_store = \DB::select("select * from `balancesheet` where `store_id` = '".$main_store_id."' and `product_id` = '".$product_id."' and `type` = 2 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
                    if($check_entry_exist_for_main_store){
                        $main_store_opening_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                        $main_pre_open_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                    }
                }

                $dist_pro_adjust_stock = $store_product_qty + $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance + $quentity;
                $main_store_closing_balance = $main_pre_open_balance - $quentity;
            }

            if($type == 4){

                //prevent negative stock
                if($details_subseed_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }

                $subseed_store = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('id', '=', $subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_id = !empty($subseed_store) ? $subseed_store[0]->mainstore_id : 0;


                //main store name 
                $main_store = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('id', '=', $main_store_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_name = !empty($main_store) ? $main_store[0]->name : 0;
                $main_store_district_id = !empty($main_store) ? $main_store[0]->districtstore_id : 0;

                $main_store_stock = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('mainstore_id', '=', $main_store_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

                if(empty($main_store_stock)){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                } 

                $main_store_stock = $main_store_stock[0];

                //update main store stock
                $post_data = array(
                    'entry_date' => $date,
                    'districtstore_id' => $main_store_district_id,
                    'mainstore_id' => $main_store_id,
                    'product_id' => $product_id,
                    'type' => $type,
                    'quentity' => $quentity,
                    'adjust_stock' => ($main_store_stock->current_stock+$quentity),
                    'note' => "Sudstruct Adjustment by ".$main_store_name,
                    'status' => 1,
                    'created_by' => $request->input('session_id'),
                    'updated_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id('mainstoreproductstock', $post_data);

                //update district product table
                $old_data = $this->CommonModel->get_all($table = 'mainstoreproduct', $select = array('*'), $where = array(array('mainstore_id', '=', $main_store_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $update_pro = array(
                    'current_stock' => ($main_store_stock->current_stock+$quentity),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('mainstoreproduct', array(array('mainstore_id', '=', $main_store_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $subseed_store[0]->id);


                //update or entry main store opening & closing stock
                $main_store_opening_balance = 0;
                $main_store_closing_balance = 0;
                $main_store_balancesheet_id = 0;
                $main_pre_open_balance = 0;

                $check_entry_exist_for_main_store = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $main_store_id), array('product_id', '=', $product_id), array('type', '=', 2), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
                if($check_entry_exist_for_main_store){
                    $main_store_balancesheet_id = $check_entry_exist_for_main_store[0]->id;
                    $main_store_opening_balance = $check_entry_exist_for_main_store[0]->opening_balance;
                    $main_store_closing_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                    $main_pre_open_balance = $check_entry_exist_for_main_store[0]->closing_balance;
                }else{
                    $check_entry_exist_for_main_store = \DB::select("select * from `balancesheet` where `store_id` = '".$main_store_id."' and `product_id` = '".$product_id."' and `type` = 2 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
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

            if($type == 5){
                //prevent negative stock
                if($details_subseed_store_product->current_stock < $quentity){
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Request stock not avaliable right now.',
                    );

                    Session::put('flash_data', $flash_data); 
                    return redirect($this->slug);
                }
                
                $subseed_store = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('id', '=', $subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $main_store_id = !empty($subseed_store) ? $subseed_store[0]->mainstore_id : 0;

                $dist_pro_adjust_stock = $store_product_qty - $quentity;
                $dist_pro_current_stock = $dist_pro_adjust_stock;
                $closing_balance = $closing_balance - $quentity;
            }

            $post_data = array(
                'entry_date' => $date,
                'subseedstore_id' => $subseedstore_id,
                'mainstore_id' => $main_store_id,
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

            $result = $this->CommonModel->insert_data_get_id('subseedstoreproductstock', $post_data);

            //update subseed product table
            $old_data = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $subseedstore_id), array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $old_data = $old_data[0];

            $update_pro = array(
                'current_stock' => $dist_pro_current_stock,
                'updated_by' => $request->input('session_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = $this->CommonModel->update_data('subseedstoreproduct', array(array('subseedstore_id', '=', $subseedstore_id), array('product_id', '=', $product_id)), $update_pro, $old_data, $details_subseed_store_product->id);

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
                    'store_id' => $subseedstore_id,
                    'product_id' => $product_id,
                    'type' => 3,
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
                'store_id' => $subseedstore_id,
                'product_id' => $product_id,
                'type' => 3,
                'opening_balance' => $pre_open_balance,
                'closing_balance' => $closing_balance,
                'status' => 1,
                'created_by' => $request->input('session_id'),
                'updated_by' => $request->input('session_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $main_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $main_store_history);

            if($type == 3){
                //for district store
                if($main_store_balancesheet_id > 0){
                    $old_check_entry_exist_for_district_store = $check_entry_exist_for_main_store[0];
                    $district_store_balancesheet_array = array(
                        'closing_balance' => $main_store_closing_balance,
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $main_store_balancesheet_id)), $district_store_balancesheet_array, $old_check_entry_exist_for_district_store, $main_store_balancesheet_id);
                }else{
                    $district_store_balancesheet_array = array(
                        'entry_date' => $date,
                        'store_id' => $main_store_id,
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

                    $district_balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $district_store_balancesheet_array);
                }

                //insert into district history table
                $district_store_history = array(
                    'entry_date' => $date,
                    'store_id' => $main_store_id,
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

                $district_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $district_store_history);
            }

            if($type == 4){
                //for district store
                if($main_store_balancesheet_id > 0){
                    $old_check_entry_exist_for_district_store = $check_entry_exist_for_main_store[0];
                    $district_store_balancesheet_array = array(
                        'closing_balance' => $main_store_closing_balance,
                        'updated_by' => $request->input('session_id'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    );

                    $update_balance = $this->CommonModel->update_data('balancesheet', array(array('id', '=', $main_store_balancesheet_id)), $district_store_balancesheet_array, $old_check_entry_exist_for_district_store, $main_store_balancesheet_id);
                }else{
                    $district_store_balancesheet_array = array(
                        'entry_date' => $date,
                        'store_id' => $main_store_id,
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

                    $district_balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $district_store_balancesheet_array);
                }

                //insert into district history table
                $district_store_history = array(
                    'entry_date' => $date,
                    'store_id' => $main_store_id,
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

                $district_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $district_store_history);
            }

            if($result == true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => 'Subseed store stock operation success executed.',
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
                'message' => 'subseed stock successfully deleted.',
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
