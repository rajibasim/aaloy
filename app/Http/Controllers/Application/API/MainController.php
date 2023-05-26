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
use Illuminate\Support\Str;
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

    ### master data List
	public function masterData(Request $request){
        try {

            $car_parking = $this->CommonModel->get_all($table = "car_parking", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('car_parking' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['car_parking'] = !empty($car_parking) ? $car_parking : [];

            $category = $this->CommonModel->get_all($table = "category", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('category' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['category'] = !empty($category) ? $category : [];

            $furnishing_status = $this->CommonModel->get_all($table = "furnishing_status", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('furnishing_status' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['furnishing_status'] = !empty($furnishing_status) ? $furnishing_status : [];

            $no_of_room = $this->CommonModel->get_all($table = "no_of_room", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('no_of_room' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['no_of_room'] = !empty($no_of_room) ? $no_of_room : [];

            $positioning_status = $this->CommonModel->get_all($table = "positioning_status", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('positioning_status' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['positioning_status'] = !empty($positioning_status) ? $positioning_status : [];

            $property_type = $this->CommonModel->get_all($table = "property_type", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('property_type' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['property_type'] = !empty($property_type) ? $property_type : [];

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => $data,
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
	}

    ### banner List
    public function banner(Request $request){
        try {

            $banner = $this->CommonModel->get_all($table = "banner", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($banner) ? $banner : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

    ### accessory List
    public function accessory(Request $request){
        try {

            $accessory = $this->CommonModel->get_all($table = "accessory", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($accessory) ? $accessory : [],
            ],200,[],JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ],200,[],JSON_NUMERIC_CHECK);

        }
    }

    ### location List
    public function location(Request $request){
        try {

            $location = $this->CommonModel->get_all($table = "location", $select = array('*'), $where = array(array('is_deleted', '=', 0), array('status', '=', 1)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");
            $locationArr = [];
            if($location){
                foreach ($location as $key => $value) {
                    //TO DO : Distance will calculate here
                    $value->distance = 0;
                    $locationArr[] = $value;
                }
            }

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => !empty($locationArr) ? $locationArr : [],
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
    public function signup(Request $request){
        
        try {

            if (!$request->type) {
                throw new \Exception("User type is required.");
            }

            if (!$request->name) {
                throw new \Exception("Name is required.");
            }

            if (!$request->phone) {
                throw new \Exception("Enter valid phone no.");
            }

            if ($request->phone && !preg_match('/^[0-9]{10}+$/', $request->phone)) {
                throw new \Exception("Enter valid phone no.");
            }

            if (!$request->email) {
                throw new \Exception("Enter valid email id.");
            }

            if ($request->email && !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Enter valid email id.");
            }

            if (!$request->password) {
                throw new \Exception("Enter your password.");
            }

            $checkUserByphone = $this->CommonModel->get_all($table = "users", $select = array('*'), $where = array(array('phone', '=', $request->phone), array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            if(!empty($checkUserByphone)){
                throw new \Exception("This mobile no already register with us.");
            }

            $phone_verification_code = $this->sendOtp($request->phone, 1);
            $promo_code = Str::random(6);
            $user_data = array(
                'type' => $request->type,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'phone_verification_code' => $phone_verification_code,
                'promo_code' => $promo_code,
                'password' => bcrypt($request->password),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $user_id = $this->CommonModel->insert_data_get_id($table = "users", $data = $user_data);
            //TO DO : SMS gatway intregation
            $result_data = array(
                'user_id' => $user_id,
                'user_phone_num' => $request->phone,
                'phone_verification_code' => $phone_verification_code,
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

    ### Login
    public function signin(Request $request){

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

            if (!$request->divice_type) {
                throw new \Exception("Divice type is required.");
            }

            if (!$request->device_id) {
                throw new \Exception("Divice id is required.");
            }

            $check_user = $this->CommonModel->get_all($table = "users", $select = array('*'), $where = array(array('phone', '=', $request->phone), array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            if (empty($check_user)) {
                throw new \Exception("Invalid login credentials.");
            }

            $user_data = $check_user[0];
            if($user_data->is_phone_verified == 1){
                $check_email = User::where('phone','=',$user_data->phone)->first();
                $token = JWTAuth::fromUser($check_email);

                $save_data = array(
                    'user_id' => $user_data->id,
                    'device_id' => $request->device_id,
                    'divice_type' => $request->divice_type,
                    'token' => $token,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $insert = $this->CommonModel->insert_data_get_id($table = "users_log", $data = $save_data);
                $message = "You have loged in successfully.";
                $result_data = array(
                    'id' => $user_data->id,
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 604800,
                    'user_data' => $user_data,
                );
            }else{
                $phone_verification_code = $this->sendOtp($user_data->phone, 1);        
                $update_data = array(
                    'phone_verification_code' => $phone_verification_code,
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $user_data->id), array('phone', '=', $user_data->phone)), $data = $update_data);

                $message = "Verificaion code send successfully.";
                $result_data = array(
                    'is_phone_verified' => $user_data->is_phone_verified,
                    'user_id' => $user_data->id,
                    'phone' => $user_data->phone,
                    'phone_verification_code' => $phone_verification_code,
                );
            }

            return response()->json([
                'result' => true,
                'message' => $message,
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

            if (!$request->phone) {
                throw new \Exception("Enter valid phone no.");
            }

            if ($request->phone && !preg_match('/^[0-9]{10}+$/', $request->phone)) {
                throw new \Exception("Enter valid phone no.");
            }  

            $phone_verification_code = $this->sendOtp($request->phone, 1);        
            $update_data = array(
                'phone_verification_code' => $phone_verification_code,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $request->user_id), array('phone', '=', $request->phone)), $data = $update_data);
            if(!$update){
                throw new \Exception("Please enter valid user id & phone.");
            }

            $result_data = array(
                'user_id' => $request->user_id,
                'phone' => $request->phone,
                'phone_verification_code' => $phone_verification_code,
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

            if (!$request->user_id) {
                throw new \Exception("User id is required.");
            }

            if (!$request->phone_verification_code) {
                throw new \Exception("Verification code is required.");
            }

            $check_data = $this->CommonModel->get_all($table = "users", $select = array('*'), $where = array(array('id', '=', $request->user_id), array('phone_verification_code', '=', $request->phone_verification_code)), $join = array(), $left = array(), $right = array(), $order = array(array('id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            if(empty($check_data)){
                throw new \Exception("Invalid verification code.");
            }
            $user_data = $check_data[0];
            if($user_data->is_phone_verified == 1){
                throw new \Exception("Alredy verified. Signin to continue.");
            }
            $save_data['updated_at'] = date('Y-m-d H:i:s');
            $save_data['is_phone_verified'] = 1;
            $save_data['phone_verified_at'] = date('Y-m-d H:i:s');
            $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $request->user_id)), $data = $save_data);

            return response()->json([
                'result' => true,
                'message' => 'User verified successfully. Signin to continue.',
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

    public function sendOtp($phone, $msgType){
        if($phone){
            $verification_code = rand(1000,9999);
            //TO DO : Send it through sms later
        }

        return $verification_code;
    }
}

