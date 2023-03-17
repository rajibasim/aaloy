<?php 

namespace App\Http\Controllers\Application\API;

use DB;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\CommonModel;
use App\Models\push;
use App\Models\User;
use JWTAuth;
use JWTAuthException;

class MainController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->CommonModel = new CommonModel();
	}

    ### Brand List
	public function brand(Request $request){
        try {

            $brand = $this->CommonModel->get_all($table = "brand", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('name' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($brand) ? $brand : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
	}

    ### Scheme List
    public function scheme(Request $request){
        try {

            $scheme = $this->CommonModel->get_all($table = "scheme", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('name' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($scheme) ? $scheme : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

    ### Category List
    public function category(Request $request){
        try {

            $category = $this->CommonModel->get_all($table = "category", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('name' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($category) ? $category : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

    ### Product List
    public function product(Request $request){
        try {

            if (!$request->category_id) {
                throw new \Exception("Category id required.");
            }

            if (!$request->brand_id) {
                throw new \Exception("Brand id required.");
            }

            $product = $this->CommonModel->get_all($table = "product", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1), array('category_id', '=', $request->category_id), array('brand_id', '=', $request->brand_id)), $join = array(), $left = array(), $right = array(), $order = array(array('name' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($product) ? $product : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

    ### Login
    public function login(Request $request){

        try {

            if (!$request->phone) {
                throw new \Exception("Enter valid phone no.");
            }

            if ($request->phone && !preg_match('/^[0-9]{10}+$/', $request->phone)) {
                throw new \Exception("Enter valid phone no.");
            }

            if (!$request->password) {
                throw new \Exception("Enter your password.");
            }

            $check_user = $this->CommonModel->get_all($table = "users", $select = array('*'), $where = array(array('phone', '=', $request->phone), array('password', '=', md5($request->password)), array('type', '=', 3), array('status', '=', 1), array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $verification_code = rand(1000,9999);
            if (empty($check_user)) {
                throw new \Exception("Invalid login credentials.");
            }

            $user_data = $check_user[0];

            $save_data['updated_at'] = date('Y-m-d H:i:s');
            $save_data['device_id'] = $request->device_id;
            $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $user_data->id)), $data = $save_data);


            $check_email = User::where('phone','=',$user_data->phone)->first();
            $token = JWTAuth::fromUser($check_email);
            
            $result_data = array(
                'id' => $user_data->id,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 604800,
                'user_data' => $user_data,
            );

            return response()->json([
                'result' => true,
                'message' => "",
                'data' => $result_data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Resend
    public function resend(Request $request){
        
        try {

            if (!$request->user_id) {
                throw new \Exception("User id is required.");
            }    

            $verification_code = rand(1000,9999);        
            $update_data = array(
                'verification_code' => $verification_code,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $request->user_id)), $data = $update_data);

            $result_data = array(
                'id' => $request->user_id,
                'phone' => $request->phone,
                'verification_code' => $verification_code,
            );

            return response()->json([
                'result' => true,
                'message' => "Verificaion code send successfully.",
                'data' => $result_data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Verify
    public function verify(Request $request){
        try {

            if (!$request->device_id) {
                throw new \Exception('Device id is required');
            }

            if (!$request->user_id) {
                throw new \Exception("User id is required.");
            }

            if (!$request->verification_code) {
                throw new \Exception("Verification code is required.");
            }

            $check_data = $this->CommonModel->get_all($table = "users", $select = array('*'), $where = array(array('id', '=', $request->user_id), array('verification_code', '=', $request->verification_code)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            if(empty($check_data)){
                throw new \Exception("Invalid verification code.");
            }

            $user_data = $check_data[0];
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            $save_data['device_id'] = $request->device_id;
            $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $request->user_id), array('verification_code', '=', $request->verification_code)), $data = $save_data);


            $check_email = User::where('phone','=',$user_data->phone)->first();
            $token = JWTAuth::fromUser($check_email);
            
            $result_data = array(
                'id' => $user_data->id,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 604800,
                'user_data' => $user_data,
            );

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => $result_data,
            ]);
            

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Stock
    public function stock(Request $request){
        try {

            if (!$request->product_id) {
                throw new \Exception('Product id is required');
            }

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            $stock = $this->CommonModel->get_all($table = "subseedstoreproduct", $select = array('*'), $where = array(array('product_id', '=', $request->product_id), array('subseedstore_id', '=', $request->subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            if(empty($stock)){
                throw new \Exception("Invalid stock request.");
            }

            $stock = $stock[0];
            $result_data = array(
                'product_id' => $request->product_id,
                'current_stock' => $stock->current_stock,
            );

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => $result_data,
            ]);
            

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Verify
    public function stockEntry(Request $request){
        try {

            if (!$request->user_id) {
                throw new \Exception('User id is required');
            }

            if (!$request->date) {
                throw new \Exception('Date id is required');
            }

            if (!$request->product_id) {
                throw new \Exception('Product id is required');
            }

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            if (!$request->quentity) {
                throw new \Exception('Quentity id is required');
            }

            if (!$request->cash_quentity) {
                throw new \Exception('Cash quentity is required');
            }

            if (!$request->scheme_quentity) {
                throw new \Exception('Scheme quentity is required');
            }


            $quentity = $request->quentity;

            $date = explode('/', $request->date);
            $date = $date[2].'-'.$date[1].'-'.$date[0];

            $opening_balance = 0;
            $closing_balance = 0;
            $balancesheet_id = 0;
            $pre_open_balance = 0;
            $cash_value = $request->cash_value ? $request->cash_value : 0;
            $subsidy_value = $request->subsidy_value ? $request->subsidy_value : 0;
            $scheme_value = $request->scheme_value ? $request->scheme_value : 0;
            $westage = $request->westage ? $request->westage : 0;

            $check_stock = $this->CommonModel->get_all($table = "subseedstoreproduct", $select = array('*'), $where = array(array('product_id', '=', $request->product_id), array('subseedstore_id', '=', $request->subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            if($check_stock){
                $avl_stock = $check_stock[0]->current_stock;
                $req_stock = $quentity + $westage;
                if($avl_stock < $req_stock){
                    throw new \Exception('Request stock not avaliable right now.');
                }
            }

            $check_entry_exist = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id), array('type', '=', 3), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");

            if($check_entry_exist){
                throw new \Exception('Entry exist on this date for this product.');
            }


            $check_entry_exist = \DB::select("select * from `balancesheet` where `store_id` = '".$request->subseedstore_id."' and `product_id` = '".$request->product_id."' and `type` = 3 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
            if($check_entry_exist){
                if(strtotime($date) < strtotime($check_entry_exist[0]->entry_date)){
                    throw new \Exception('Entry not avaliable for this date.');
                }
                $opening_balance = $check_entry_exist[0]->closing_balance;
                $closing_balance = $check_entry_exist[0]->closing_balance;
                $pre_open_balance = $check_entry_exist[0]->closing_balance;
            }



            $details_subseed_store_product = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            if(empty($details_subseed_store_product)){
                throw new \Exception('Invalid request.');
            }   
            $details_subseed_store_product = $details_subseed_store_product[0];

            $txn_details_subseed_store_product = $this->CommonModel->get_all($table = 'subseedstoreproductstock', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if(empty($txn_details_subseed_store_product)){
                throw new \Exception('Invalid request.');
            }

            $store_product_qty = $txn_details_subseed_store_product[0]->adjust_stock;

            $sub_seed_store_details = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('id', '=', $request->subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            
            if(empty($sub_seed_store_details)){
                throw new \Exception('Invalid request.');
            }

            $sub_seed_store_details = $sub_seed_store_details[0];

            $subseed_store_product_stock_array = array(
                'entry_date' => $date,
                'subseedstore_id' => $request->subseedstore_id,
                'mainstore_id' => $sub_seed_store_details->mainstore_id,
                'product_id' => $request->product_id,
                'type' => 2,
                'quentity' => $quentity,
                'adjust_stock' => ($store_product_qty-$quentity),
                'status' => 1,
                'created_by' => $request->user_id,
                'updated_by' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );


            $subseed_store_product_stock_insert = $this->CommonModel->insert_data_get_id('subseedstoreproductstock', $subseed_store_product_stock_array);

            $subseed_pro_adjust_stock = $store_product_qty - $quentity;
            $subseed_pro_adjust_stock = $subseed_pro_adjust_stock;
            $closing_balance = $closing_balance - $quentity;

            //update subseed product table
            $old_data = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $old_data = $old_data[0];

            $update_pro = array(
                'current_stock' => $subseed_pro_adjust_stock,
                'updated_by' => $request->user_id,
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = $this->CommonModel->update_data('subseedstoreproduct', array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $update_pro, $old_data, $details_subseed_store_product->id);

            if($westage > 0){
                $subseed_store_product_stock_array = array(
                    'entry_date' => $date,
                    'subseedstore_id' => $request->subseedstore_id,
                    'mainstore_id' => $sub_seed_store_details->mainstore_id,
                    'product_id' => $request->product_id,
                    'type' => 5,
                    'quentity' => $westage,
                    'adjust_stock' => ($store_product_qty-($westage+$quentity)),
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );


                $subseed_store_product_stock_insert = $this->CommonModel->insert_data_get_id('subseedstoreproductstock', $subseed_store_product_stock_array);

                $subseed_pro_adjust_stock = $subseed_pro_adjust_stock - $westage;
                $subseed_pro_adjust_stock = $subseed_pro_adjust_stock;
                $closing_balance = $closing_balance - $westage;

                //update subseed product table
                $old_data = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $update_pro = array(
                    'current_stock' => $subseed_pro_adjust_stock,
                    'updated_by' => $request->user_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('subseedstoreproduct', array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $update_pro, $old_data, $details_subseed_store_product->id);
            }


            //insert or update balance sheet
            $balancesheet_array = array(
                'entry_date' => $date,
                'store_id' => $request->subseedstore_id,
                'product_id' => $request->product_id,
                'type' => 3,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
                'cash_value' => $cash_value,
                'subsidy_value' => $subsidy_value,
                'scheme_value' => $scheme_value,
                'scheme_id' => $request->scheme_id,
                'quentity' => $quentity,
                'cash_quentity' => $request->cash_quentity,
                'scheme_quentity' => $request->scheme_quentity,
                'westage' => $westage,
                'status' => 1,
                'created_by' => $request->user_id,
                'updated_by' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $balancesheet_array);

            //insert into main history table
            $main_store_history = array(
                'entry_date' => $date,
                'store_id' => $request->subseedstore_id,
                'product_id' => $request->product_id,
                'type' => 3,
                'opening_balance' => $pre_open_balance,
                'closing_balance' => $closing_balance,
                'cash_value' => $cash_value,
                'subsidy_value' => $subsidy_value,
                'scheme_value' => $scheme_value,
                'scheme_id' => $request->scheme_id,
                'quentity' => $quentity,
                'westage' => $westage,
                'status' => 1,
                'created_by' => $request->user_id,
                'updated_by' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $main_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $main_store_history);

            return response()->json([
                'result' => true,
                'message' => 'Stock updated successfully',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### History
    public function history(Request $request){
        try {

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            $list = \DB::select("SELECT *, CASE subseedstoreproductstock.type WHEN 1 THEN 'Entry' WHEN 2 THEN 'Distribute' WHEN 5 THEN 'Westage' END as type_name, subseedstore.name as subseedstore_name, product.name as product_name, category.name as category_name, brand.name as brand_name FROM subseedstoreproductstock LEFT JOIN subseedstore ON subseedstoreproductstock.subseedstore_id = subseedstore.id LEFT JOIN product ON subseedstoreproductstock.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id WHERE subseedstoreproductstock.subseedstore_id = '".$request->subseedstore_id."' ORDER BY subseedstoreproductstock.entry_date DESC");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($list) ? $list : [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Stock list
    public function stockList(Request $request){
        try {

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            $list = \DB::select("SELECT balancesheet.*, product.name as product_name, category.name as category_name, brand.name as brand_name, subseedstore.name as subseedstore_name FROM balancesheet LEFT JOIN subseedstore ON balancesheet.store_id = subseedstore.id LEFT JOIN product ON balancesheet.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id WHERE balancesheet.store_id = '".$request->subseedstore_id."' AND balancesheet.type = '3' ORDER BY balancesheet.entry_date"); 

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($list) ? $list : [],
            ]);
            

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Stock Details
    public function stockDetails(Request $request){
        try {

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            if (!$request->stock_id) {
                throw new \Exception('Stock id is required');
            }

            $details = \DB::select("SELECT balancesheet.*, product.name as product_name, category.name as category_name, brand.name as brand_name, subseedstore.name as subseedstore_name FROM balancesheet LEFT JOIN subseedstore ON balancesheet.store_id = subseedstore.id LEFT JOIN product ON balancesheet.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id WHERE balancesheet.id = '".$request->stock_id."'"); 

            if (empty($details)) {
                throw new \Exception('Stock id not exist');
            }

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($details) ? $details[0] : [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Stock Update
    public function stockUpdate(Request $request){
        try {

            if (!$request->stock_id) {
                throw new \Exception('Stock id is required');
            }

            if (!$request->user_id) {
                throw new \Exception('User id is required');
            }

            if (!$request->date) {
                throw new \Exception('Date id is required');
            }

            if (!$request->product_id) {
                throw new \Exception('Product id is required');
            }

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            if (!$request->quentity) {
                throw new \Exception('Quentity id is required');
            }


            $quentity = $request->quentity;

            $date = explode('/', $request->date);
            $date = $date[2].'-'.$date[1].'-'.$date[0];

            $opening_balance = 0;
            $closing_balance = 0;
            $balancesheet_id = 0;
            $pre_open_balance = 0;
            $cash_value = $request->cash_value ? $request->cash_value : 0;
            $subsidy_value = $request->subsidy_value ? $request->subsidy_value : 0;
            $scheme_value = $request->scheme_value ? $request->scheme_value : 0;
            $westage = $request->westage ? $request->westage : 0;

            /*$check_stock = $this->CommonModel->get_all($table = "subseedstoreproduct", $select = array('*'), $where = array(array('product_id', '=', $request->product_id), array('subseedstore_id', '=', $request->subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            if($check_stock){
                $avl_stock = $check_stock[0]->current_stock;
                $req_stock = $quentity + $westage;
                if($avl_stock < $req_stock){
                    throw new \Exception('Request stock not avaliable right now.');
                }
            }

            $check_entry_exist = $this->CommonModel->get_all($table = 'balancesheet', $select = array('*'), $where = array(array('store_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id), array('type', '=', 3), array('entry_date', '=', $date)), $join = array(), $left = array(), $right = array(), $order = array(array('entry_date'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");

            if($check_entry_exist){
                throw new \Exception('Entry exist on this date for this product.');
            }


            $check_entry_exist = \DB::select("select * from `balancesheet` where `store_id` = '".$request->subseedstore_id."' and `product_id` = '".$request->product_id."' and `type` = 3 and DATE(entry_date) < '".$date."' order by `entry_date` DESC");
            if($check_entry_exist){
                if(strtotime($date) < strtotime($check_entry_exist[0]->entry_date)){
                    throw new \Exception('Entry not avaliable for this date.');
                }
                $opening_balance = $check_entry_exist[0]->closing_balance;
                $closing_balance = $check_entry_exist[0]->closing_balance;
                $pre_open_balance = $check_entry_exist[0]->closing_balance;
            }



            $details_subseed_store_product = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            if(empty($details_subseed_store_product)){
                throw new \Exception('Invalid request.');
            }   
            $details_subseed_store_product = $details_subseed_store_product[0];

            $txn_details_subseed_store_product = $this->CommonModel->get_all($table = 'subseedstoreproductstock', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if(empty($txn_details_subseed_store_product)){
                throw new \Exception('Invalid request.');
            }

            $store_product_qty = $txn_details_subseed_store_product[0]->adjust_stock;

            $sub_seed_store_details = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('id', '=', $request->subseedstore_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            
            if(empty($sub_seed_store_details)){
                throw new \Exception('Invalid request.');
            }

            $sub_seed_store_details = $sub_seed_store_details[0];

            $subseed_store_product_stock_array = array(
                'entry_date' => $date,
                'subseedstore_id' => $request->subseedstore_id,
                'mainstore_id' => $sub_seed_store_details->mainstore_id,
                'product_id' => $request->product_id,
                'type' => 2,
                'quentity' => $quentity,
                'adjust_stock' => ($store_product_qty-$quentity),
                'status' => 1,
                'created_by' => $request->user_id,
                'updated_by' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );


            $subseed_store_product_stock_insert = $this->CommonModel->insert_data_get_id('subseedstoreproductstock', $subseed_store_product_stock_array);

            $subseed_pro_adjust_stock = $store_product_qty - $quentity;
            $subseed_pro_adjust_stock = $subseed_pro_adjust_stock;
            $closing_balance = $closing_balance - $quentity;

            //update subseed product table
            $old_data = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $old_data = $old_data[0];

            $update_pro = array(
                'current_stock' => $subseed_pro_adjust_stock,
                'updated_by' => $request->user_id,
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = $this->CommonModel->update_data('subseedstoreproduct', array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $update_pro, $old_data, $details_subseed_store_product->id);

            if($westage > 0){
                $subseed_store_product_stock_array = array(
                    'entry_date' => $date,
                    'subseedstore_id' => $request->subseedstore_id,
                    'mainstore_id' => $sub_seed_store_details->mainstore_id,
                    'product_id' => $request->product_id,
                    'type' => 5,
                    'quentity' => $westage,
                    'adjust_stock' => ($store_product_qty-$westage),
                    'status' => 1,
                    'created_by' => $request->user_id,
                    'updated_by' => $request->user_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );


                $subseed_store_product_stock_insert = $this->CommonModel->insert_data_get_id('subseedstoreproductstock', $subseed_store_product_stock_array);

                $subseed_pro_adjust_stock = $subseed_pro_adjust_stock - $westage;
                $subseed_pro_adjust_stock = $subseed_pro_adjust_stock;
                $closing_balance = $closing_balance - $westage;

                //update subseed product table
                $old_data = $this->CommonModel->get_all($table = 'subseedstoreproduct', $select = array('*'), $where = array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $update_pro = array(
                    'current_stock' => $subseed_pro_adjust_stock,
                    'updated_by' => $request->user_id,
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                $update = $this->CommonModel->update_data('subseedstoreproduct', array(array('subseedstore_id', '=', $request->subseedstore_id), array('product_id', '=', $request->product_id)), $update_pro, $old_data, $details_subseed_store_product->id);
            }


            //insert or update balance sheet
            $balancesheet_array = array(
                'entry_date' => $date,
                'store_id' => $request->subseedstore_id,
                'product_id' => $request->product_id,
                'type' => 3,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
                'cash_value' => $cash_value,
                'subsidy_value' => $subsidy_value,
                'scheme_value' => $scheme_value,
                'scheme_id' => $request->scheme_id,
                'quentity' => $quentity,
                'westage' => $westage,
                'status' => 1,
                'created_by' => $request->user_id,
                'updated_by' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $balancesheet_id = $this->CommonModel->insert_data_get_id('balancesheet', $balancesheet_array);

            //insert into main history table
            $main_store_history = array(
                'entry_date' => $date,
                'store_id' => $request->subseedstore_id,
                'product_id' => $request->product_id,
                'type' => 3,
                'opening_balance' => $pre_open_balance,
                'closing_balance' => $closing_balance,
                'cash_value' => $cash_value,
                'subsidy_value' => $subsidy_value,
                'scheme_value' => $scheme_value,
                'scheme_id' => $request->scheme_id,
                'quentity' => $quentity,
                'westage' => $westage,
                'status' => 1,
                'created_by' => $request->user_id,
                'updated_by' => $request->user_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $main_hist_id = $this->CommonModel->insert_data_get_id('balancesheethistory', $main_store_history);*/

            return response()->json([
                'result' => true,
                'message' => 'Stock updated successfully',
                'data' => [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Report
    public function report(Request $request){

        try {

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            if($request->start_date){
                $start_date = $request->start_date;
            }

            if($request->end_date){
                $end_date = $request->end_date;
            }else{
               if($request->start_date){
                    $end_date = date('Y-m-d');
                } 
            }

            $sql = "SELECT balancesheet.*, product.name as product_name, category.name as category_name, brand.name as brand_name, subseedstore.name as subseedstore_name FROM balancesheet LEFT JOIN subseedstore ON balancesheet.store_id = subseedstore.id LEFT JOIN product ON balancesheet.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id WHERE balancesheet.store_id = '".$request->subseedstore_id."' AND balancesheet.type = '3'";

            if((isset($start_date) && $start_date) && isset($end_date) && $end_date){
                $sql = $sql." AND DATE(balancesheet.entry_date) BETWEEN '".$start_date."' AND '".$end_date."'";
            }

            $sql = $sql." ORDER BY balancesheet.entry_date DESC"; 
            $list = \DB::select($sql);

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($list) ? $list : [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Logout
    public function logout(Request $request){

        try {
            
            Auth::guard('api')->logout();

            return response()->json([
                'result' => true,
                'message' => "Successfully logout",
                'data' => '',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ## category Balance
    public function categoryBalance(Request $request){
        try {

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            $brandStock = \DB::select("SELECT *, SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE subseedstore_id = '".$request->subseedstore_id."' AND type_of_store = '3' GROUP BY category_id");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($brandStock) ? $brandStock : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

    ## product Balance
    public function productBalance(Request $request){
        try {

            if (!$request->subseedstore_id) {
                throw new \Exception('Subseed store id is required');
            }

            $products = \DB::select("SELECT *, SUM(current_stock) as stock FROM current_stock_balance_sheet WHERE subseedstore_id = '".$request->subseedstore_id."' AND type_of_store = '3' GROUP BY product_id");
            $listArray = array();
            if($products){
                foreach ($products as $key => $value) {
                    $wastage = \DB::select("SELECT SUM(wastage) as wastage FROM current_wastage_balance_sheet WHERE  product_id = '".$value->product_id."' AND subseedstore_id = '".$request->subseedstore_id."' AND type_of_store = '3' GROUP BY product_id");
                    $wastage = isset($wastage) && !empty($wastage) ? $wastage[0]->wastage : 0;
                    
                    $value->wastage = $wastage;
                    $listArray[] = $value;
                }
            }

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($listArray) ? $listArray : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

}

