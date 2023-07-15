<?php 

namespace App\Http\Controllers\Application\API;

use DB;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\CommonModel;
use App\Models\push;
use App\Models\User;
use JWTAuth;
use JWTAuthException;

class PropertyController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->CommonModel = new CommonModel();
	}

    ### Add
    public function add(Request $request){
        try {

            $user_data = Auth::user();

            if (!$request->title) {
                throw new \Exception('This field required');
            }

            if (!$request->gender) {
                throw new \Exception('This field required');
            }

            if (!$request->property_for) {
                throw new \Exception('This field required');
            }

            $request->posted_by = $user_data->type;
            $request->posted_by_id = $user_data->id;

            if (!$request->property_type_id) {
                throw new \Exception('This field required');
            }

            if (!$request->preferance) {
                throw new \Exception('This field required');
            }

            if (!$request->location_id) {
                throw new \Exception('This field required');
            }

            if (!$request->address) {
                throw new \Exception('This field required');
            }

            if (!$request->latitude) {
                throw new \Exception('This field required');
            }

            if (!$request->longitude) {
                throw new \Exception('This field required');
            }

            if (!$request->pin_code) {
                throw new \Exception('This field required');
            }

            if (!$request->floor_id) {
                throw new \Exception('This field required');
            }

            if (!$request->out_of_floor_id) {
                throw new \Exception('This field required');
            }

            if (!$request->no_of_room_id) {
                throw new \Exception('This field required');
            }

            if (!$request->price) {
                throw new \Exception('This field required');
            }
            if (!$request->booking_price) {
                throw new \Exception('This field required');
            }

            if (!$request->maintenance) {
                throw new \Exception('This field required');
            }

            if (!$request->carpet_area) {
                throw new \Exception('This field required');
            }

            if (!$request->car_parking_id) {
                throw new \Exception('This field required');
            }

            if (!$request->furnishing_status_id) {
                throw new \Exception('This field required');
            }

            if (!$request->positioning_status_id) {
                throw new \Exception('This field required');
            }

            if (!$request->description) {
                throw new \Exception('This field required');
            }

            /*if (!$request->property_image) {
                throw new \Exception('This field required');
            }*/

            if (!$request->avalible_from) {
                throw new \Exception('This field required');
            }

            if (!$request->bathroom) {
                throw new \Exception('This field required');
            }

            if (!$request->video_url) {
                throw new \Exception('This field required');
            } 

            $request->status = 2; 

            $post_data = array(
                'title' => $request->title,
                'gender' => $request->gender,
                'property_for' => $request->property_for,
                'posted_by' => $request->posted_by,
                'posted_by_id' => $request->posted_by_id,
                'property_type_id' => $request->property_type_id,
                'preferance' => $request->preferance,
                'location_id' => $request->location_id,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'pin_code' => $request->pin_code,
                'floor' => $request->floor_id,
                'out_of_floor' => $request->out_of_floor_id,
                'no_of_room_id' => $request->no_of_room_id,
                'price' => $request->price,
                'booking_price' => $request->booking_price,
                'maintenance' => $request->maintenance,
                'carpet_area' => $request->carpet_area,
                'car_parking_id' => $request->car_parking_id,
                'furnishing_status_id' => $request->furnishing_status_id,
                'positioning_status_id' => $request->positioning_status_id,
                'note' => $request->note,
                'description' => $request->description,
                'avalible_from' => $request->avalible_from,
                'bathroom' => $request->bathroom,
                'video_url' => $request->video_url,
                'status' => $request->status,
                'slug' => Str::slug($request->title),
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $destinationPath = 'public/uploads/property_image/';
            if (!empty($_FILES)) {
                if ($_FILES['property_image'] && $_FILES['property_image']['name'] != "") {
                    $profile_image_new_name = str_replace(" ", "_", time() . $_FILES['property_image']['name']);
                    if (move_uploaded_file($_FILES['property_image']['tmp_name'], $destinationPath . $profile_image_new_name)) {
                        $post_data['property_image'] = $destinationPath . $profile_image_new_name;
                    }
                }
            }

            $property_id = $this->CommonModel->insert_data_get_id('property', $post_data); 
            if($property_id){
                if(isset($_FILES["multi_image"]["tmp_name"]) && is_array($_FILES["multi_image"]["tmp_name"])){
                    foreach ($_FILES["multi_image"]["tmp_name"] as $key => $tmp_name) {
                        $file_name = str_replace(" ", "_", time() . $_FILES["multi_image"]["name"][$key]);
                        $file_tmp = $file_tmp = $_FILES["multi_image"]["tmp_name"][$key];

                        $target_path = $destinationPath . $file_name;
                        move_uploaded_file($file_tmp, $target_path);

                        $uploadedImages = [];
                        $uploadedImages = array(
                            'property_id' => $property_id,
                            'property_image' => $target_path,
                        );

                        $result = $this->CommonModel->insert_data_get_id('property_image', $uploadedImages);
                    }
                }

                return response()->json([
                    'result' => true,
                    'message' => "Property added Successfully.",
                    'data' => [],
                ]);
            }else{
                return response()->json([
                    'result' => false,
                    'message' => "Something wrong, try again later.",
                    'data' => [],
                ]);
            }                   
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### List
    public function list(Request $request){
        try {

            $user_data = Auth::user();
            if (!$request->latitude) {
                throw new \Exception('This field required');
            }

            if (!$request->longitude) {
                throw new \Exception('This field required');
            }

            if (!$request->type) {
                throw new \Exception('This field required');
            }

            $sql = "SELECT property.id, property.title, property.description, property.property_for, IF(property.property_for = '1', 'Rent', 'Sell') AS property_for_text, property.posted_by, IF(property.posted_by = '1', 'Broker', 'Owner') AS posted_by_txt, property.posted_by_id, users.name as posted_by_name, property.property_type_id, property_type.property_type, property.location_id, location.location, property.address, property.is_address_visible, property.furnishing_status_id, furnishing_status.furnishing_status, property.positioning_status_id, positioning_status.positioning_status, property.car_parking_id, car_parking.car_parking, property.preferance, property.carpet_area, property.floor, property.out_of_floor, property.bathroom, property.no_of_room_id, no_of_room.no_of_room, property.price, property.booking_price, property.maintenance, IF(property.gender = '1', 'Male', IF(property.gender = '2', 'Female', IF(property.gender = '3', 'Transgender', 'No Choice'))) AS gender, property.note, property.is_phone_visible, property.is_email_visible, property.property_image, property.avalible_from, property.is_admin_aproved, property.status, property.video_url, property.created_at, property.updated_at FROM `property` LEFT JOIN users ON property.posted_by_id = users.id LEFT JOIN property_type ON property.property_type_id = property_type.id LEFT JOIN location ON property.location_id = location.id LEFT JOIN furnishing_status ON property.furnishing_status_id = furnishing_status.id LEFT JOIN positioning_status ON property.positioning_status_id = positioning_status.id LEFT JOIN car_parking ON property.car_parking_id = car_parking.id LEFT JOIN no_of_room ON property.no_of_room_id = no_of_room.id WHERE property.status = '1'"; 

            $page_no = 1;
            if($request->page_no){
                $page_no = $request->page_no;
            }

            $per_page = 10;
            if($request->per_page){
                $per_page = $request->per_page;
            }

            $page_no = ($page_no-1)*$per_page;

            $total_count = DB::select($sql);
            $total_count = count($total_count);

            $sql = $sql ." LIMIT ".$page_no.', '.$per_page;
            $list = DB::select($sql);
            if (empty($list)) {
                throw new \Exception('No records found.');
            }

            $listArray = [];
            foreach ($list as $key => $value) {

                $is_saved = $this->CommonModel->get_all($table = 'users_saved_property', $select = array('id'), $where = array(array('is_deleted', '=', 0), array('property_id', '=', $value->id), array('user_id', '=', $user_data->id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $value->is_saved = !empty($is_saved) ? 1 : 0;

                $property_images = $this->CommonModel->get_all($table = 'property_image', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('property_id', '=', $value->id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $value->property_images = !empty($property_images) ? $property_images : [];

                
                $listArray[] = $value;
            }

            return response()->json([
                'result' => true,
                'message' => '',
                'data' => $listArray,
                'total_count' => $total_count,
            ],200,[],JSON_NUMERIC_CHECK);
               
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Details
    public function details(Request $request, $id){
        try {
            $id = $id;
            $sql = "SELECT property.id, property.title, property.description, property.property_for, IF(property.property_for = '1', 'Rent', 'Sell') AS property_for_text, property.posted_by, IF(property.posted_by = '1', 'Broker', 'Owner') AS posted_by_txt, property.posted_by_id, users.name as posted_by_name, property.property_type_id, property_type.property_type, property.location_id, location.location, property.address, property.is_address_visible, property.furnishing_status_id, furnishing_status.furnishing_status, property.positioning_status_id, positioning_status.positioning_status, property.car_parking_id, car_parking.car_parking, property.preferance, property.carpet_area, property.floor, property.out_of_floor, property.bathroom, property.no_of_room_id, no_of_room.no_of_room, property.price, property.booking_price, property.maintenance, IF(property.gender = '1', 'Male', IF(property.gender = '2', 'Female', IF(property.gender = '3', 'Transgender', 'No Choice'))) AS gender, property.note, property.is_phone_visible, property.is_email_visible, property.property_image, property.avalible_from, property.is_admin_aproved, property.status, property.video_url, property.created_at, property.updated_at FROM `property` LEFT JOIN users ON property.posted_by_id = users.id LEFT JOIN property_type ON property.property_type_id = property_type.id LEFT JOIN location ON property.location_id = location.id LEFT JOIN furnishing_status ON property.furnishing_status_id = furnishing_status.id LEFT JOIN positioning_status ON property.positioning_status_id = positioning_status.id LEFT JOIN car_parking ON property.car_parking_id = car_parking.id LEFT JOIN no_of_room ON property.no_of_room_id = no_of_room.id WHERE property.id = '".$id."'"; 

            $details = DB::select($sql); 
            if (empty($details)) {
                throw new \Exception('Invalid request.');
            }
            $data['details'] = $details[0];  
            $property_images = $this->CommonModel->get_all($table = 'property_image', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('property_id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $data['property_images'] = $property_images ? $property_images : [];

            $food_data = $this->CommonModel->get_all($table = 'property_food', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('location_id', '=', $data['details']->location_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $data['food_data'] = $food_data ? $food_data : [];

            return response()->json([
                'result' => true,
                'message' => "",
                'data' => $data,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Edit
    public function edit(Request $request, $id){
        try {

            $user_data = Auth::user();

            if (!$request->title) {
                throw new \Exception('This field required');
            }

            if (!$request->gender) {
                throw new \Exception('This field required');
            }

            if (!$request->property_for) {
                throw new \Exception('This field required');
            }

            $request->posted_by = $user_data->type;
            $request->posted_by_id = $user_data->id;

            if (!$request->property_type_id) {
                throw new \Exception('This field required');
            }

            if (!$request->preferance) {
                throw new \Exception('This field required');
            }

            if (!$request->location_id) {
                throw new \Exception('This field required');
            }

            if (!$request->address) {
                throw new \Exception('This field required');
            }

            if (!$request->latitude) {
                throw new \Exception('This field required');
            }

            if (!$request->longitude) {
                throw new \Exception('This field required');
            }

            if (!$request->pin_code) {
                throw new \Exception('This field required');
            }

            if (!$request->floor_id) {
                throw new \Exception('This field required');
            }

            if (!$request->out_of_floor_id) {
                throw new \Exception('This field required');
            }

            if (!$request->no_of_room_id) {
                throw new \Exception('This field required');
            }

            if (!$request->price) {
                throw new \Exception('This field required');
            }
            if (!$request->booking_price) {
                throw new \Exception('This field required');
            }

            if (!$request->maintenance) {
                throw new \Exception('This field required');
            }

            if (!$request->carpet_area) {
                throw new \Exception('This field required');
            }

            if (!$request->car_parking_id) {
                throw new \Exception('This field required');
            }

            if (!$request->furnishing_status_id) {
                throw new \Exception('This field required');
            }

            if (!$request->positioning_status_id) {
                throw new \Exception('This field required');
            }

            if (!$request->description) {
                throw new \Exception('This field required');
            }

            /*if (!$request->property_image) {
                throw new \Exception('This field required');
            }*/

            if (!$request->avalible_from) {
                throw new \Exception('This field required');
            }

            if (!$request->bathroom) {
                throw new \Exception('This field required');
            }

            if (!$request->video_url) {
                throw new \Exception('This field required');
            } 

            $request->status = 2; 

            $post_data = array(
                'title' => $request->title,
                'gender' => $request->gender,
                'property_for' => $request->property_for,
                'posted_by' => $request->posted_by,
                'posted_by_id' => $request->posted_by_id,
                'property_type_id' => $request->property_type_id,
                'preferance' => $request->preferance,
                'location_id' => $request->location_id,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'pin_code' => $request->pin_code,
                'floor' => $request->floor_id,
                'out_of_floor' => $request->out_of_floor_id,
                'no_of_room_id' => $request->no_of_room_id,
                'price' => $request->price,
                'booking_price' => $request->booking_price,
                'maintenance' => $request->maintenance,
                'carpet_area' => $request->carpet_area,
                'car_parking_id' => $request->car_parking_id,
                'furnishing_status_id' => $request->furnishing_status_id,
                'positioning_status_id' => $request->positioning_status_id,
                'note' => $request->note,
                'description' => $request->description,
                'avalible_from' => $request->avalible_from,
                'bathroom' => $request->bathroom,
                'video_url' => $request->video_url,
                'is_admin_aproved' => 0,
                'status' => $request->status,
                'slug' => Str::slug($request->title),
                'updated_at' => date('Y-m-d H:i:s'),
                //'created_at' => date('Y-m-d H:i:s'),
            );

            $destinationPath = 'public/uploads/property_image/';
            if (!empty($_FILES)) {
                if ($_FILES['property_image'] && $_FILES['property_image']['name'] != "") {
                    $profile_image_new_name = str_replace(" ", "_", time() . $_FILES['property_image']['name']);
                    if (move_uploaded_file($_FILES['property_image']['tmp_name'], $destinationPath . $profile_image_new_name)) {
                        $post_data['property_image'] = $destinationPath . $profile_image_new_name;
                    }
                }
            }

            $result = $this->CommonModel->update_data('property', array(array('id', '=', $id)), $post_data); 
            if($id && $result){
                if(isset($_FILES["multi_image"]["tmp_name"]) && is_array($_FILES["multi_image"]["tmp_name"])){
                    $unlink_old_images = $this->CommonModel->get_all($table = 'property_image', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('property_id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                    if($unlink_old_images){
                        foreach ($unlink_old_images as $key => $value) {
                            unlink($value->property_image);
                            $image_delete = $this->CommonModel->delete_data('property_image', array(array('id', '=', $value->id)));
                        }
                    }

                    foreach ($_FILES["multi_image"]["tmp_name"] as $key => $tmp_name) {
                        $file_name = str_replace(" ", "_", time() . $_FILES["multi_image"]["name"][$key]);
                        $file_tmp = $file_tmp = $_FILES["multi_image"]["tmp_name"][$key];

                        $target_path = $destinationPath . $file_name;
                        move_uploaded_file($file_tmp, $target_path);

                        $uploadedImages = [];
                        $uploadedImages = array(
                            'property_id' => $id,
                            'property_image' => $target_path,
                        );

                        $result = $this->CommonModel->insert_data_get_id('property_image', $uploadedImages);
                    }
                }
                
                return response()->json([
                    'result' => true,
                    'message' => "Property updated Successfully.",
                    'data' => [],
                ]);
            }else{
                return response()->json([
                    'result' => false,
                    'message' => "Something wrong, try again later.",
                    'data' => [],
                ]);
            }                   
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Delete
    public function delete(Request $request, $id){
        try {

            $check_data = $this->CommonModel->get_all($table = 'property', $select = array('id'), $where = array(array('is_deleted', '=', 0), array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            if(empty($check_data)){
                throw new \Exception('Invalid request.');
            }

            $post_data = array(
                'is_deleted' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $result = $this->CommonModel->soft_delete('property', array(array('id', '=', $id)), $post_data);
            return response()->json([
                'result' => true,
                'message' => "Property deleted successfully.",
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

    

}

