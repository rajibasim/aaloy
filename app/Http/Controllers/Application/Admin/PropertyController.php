<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\CommonModel;
use Validator;
use DB;

class PropertyController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/admin-property';
        $this->title = 'Property';
        $this->table = 'property';
    }

    /* List view */    
    public function index(Request $request){
        $serach_data = array();
        $title = $request->title;
        $location_id = $request->location_id;
        $property_for = $request->property_for;
        $posted_by = $request->posted_by;
        $posted_by_id = $request->posted_by_id;
        $property_type_id = $request->property_type_id;
        $preferance = $request->preferance;
        $status = $request->status;
        $where = array();
        $where = array(
            array('property.is_deleted', '=', 0)
        );
        if($title){
            array_push($where, array('property.title', 'like', "%{$title}%"));
            $serach_data['title'] = $title;
        }

        if($location_id){
            array_push($where, array('property.location_id', '=', $location_id));
            $serach_data['location_id'] = $location_id;
        }

        if($property_for){
            array_push($where, array('property.property_for', '=', $property_for));
            $serach_data['property_for'] = $property_for;
        }

        if($posted_by){
            array_push($where, array('property.posted_by', '=', $posted_by));
            $serach_data['posted_by'] = $posted_by;
        }

        if($posted_by_id){
            array_push($where, array('property.posted_by_id', '=', $posted_by_id));
            $serach_data['posted_by_id'] = $posted_by_id;
        }

        if($property_type_id){
            array_push($where, array('property.property_type_id', '=', $property_type_id));
            $serach_data['property_type_id'] = $property_type_id;
        }

         if($preferance){
            array_push($where, array('property.preferance', '=', $preferance));
            $serach_data['preferance'] = $preferance;
        }

        if($status){
            array_push($where, array('property.status', '=', $status));
            $serach_data['status'] = $status;
        }

        //dd($serach_data);

        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'page_details' => $this->slug.'/details',
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

        $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('property.*','property_type.property_type'), $where, $join = array(), $left = array(array('property_type', 'property.property_type_id', '=', 'property_type.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20");

        $data['location'] = $this->CommonModel->get_all($table = 'location', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['property_type'] = $this->CommonModel->get_all($table = 'property_type', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['users'] = $this->CommonModel->get_all($table = 'users', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.property.view', $data);
    }

    /* add & edit form */
    public function form(Request $request, $id = null){
        $data['metadata'] = array(
            'page_title' => $id > 0 ? $this->title.' Edit' : $this->title.' Add',
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'page_details' => $this->slug.'/details',
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

        if($id){
            $id = decrypt($id);
            $details = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $data['details'] = !empty($details) ? $details[0] : [];
        }

        $data['location'] = $this->CommonModel->get_all($table = 'location', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['car_parking'] = $this->CommonModel->get_all($table = 'car_parking', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['no_of_room'] = $this->CommonModel->get_all($table = 'no_of_room', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['furnishing_status'] = $this->CommonModel->get_all($table = 'furnishing_status', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['positioning_status'] = $this->CommonModel->get_all($table = 'positioning_status', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['property_type'] = $this->CommonModel->get_all($table = 'property_type', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['users'] = $this->CommonModel->get_all($table = 'users', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.property.form', $data);
    }

    /* store & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'title' => 'required',
            'status' => 'required', 
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            if($id){
                $post_data = array(
                    'title' => $request->input('title'),
                    'gender' => $request->input('gender'),
                    'property_for' => $request->input('property_for'),
                    'posted_by' => $request->input('posted_by'),
                    'posted_by_id' => $request->input('posted_by_id'),
                    'property_type_id' => $request->input('property_type_id'),
                    'preferance' => $request->input('preferance'),
                    'location_id' => $request->input('location_id'),
                    'address' => $request->input('address'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'pin_code' => $request->input('pin_code'),
                    'floor' => $request->input('floor_id'),
                    'out_of_floor' => $request->input('out_of_floor_id'),
                    'no_of_room_id' => $request->input('no_of_room_id'),
                    'price' => $request->input('price'),
                    'booking_price' => $request->input('booking_price'),
                    'maintenance' => $request->input('maintenance'),
                    'carpet_area' => $request->input('carpet_area'),
                    'car_parking_id' => $request->input('car_parking_id'),
                    'furnishing_status_id' => $request->input('furnishing_status_id'),
                    'positioning_status_id' => $request->input('positioning_status_id'),
                    'note' => $request->input('note'),
                    'description' => $request->input('description'),
                    'avalible_beds' => $request->input('avalible_beds'),
                    'is_address_visible' => $request->input('is_address_visible'),
                    'is_phone_visible' => $request->input('is_phone_visible'),
                    'is_email_visible' => $request->input('is_email_visible'),
                    'is_admin_aproved' => $request->input('is_admin_aproved'),
                    'avalible_from' => $request->input('avalible_from'),
                    'bathroom' => $request->input('bathroom'),
                    'video_url' => $request->input('video_url'),
                    'status' => $request->input('status'),
                    'slug' => Str::slug($request->input('title')),
                    'updated_at' => date('Y-m-d H:i:s'),
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
                $result = $this->CommonModel->update_data($this->table, array(array('id', '=', $id)), $post_data);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => $this->title.' successfully updated.',
                    );
                }else{
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong try again later.',
                    );
                }
            }else{

                $post_data = array(
                    'title' => $request->input('title'),
                    'gender' => $request->input('gender'),
                    'property_for' => $request->input('property_for'),
                    'posted_by' => $request->input('posted_by'),
                    'posted_by_id' => $request->input('posted_by_id'),
                    'property_type_id' => $request->input('property_type_id'),
                    'preferance' => $request->input('preferance'),
                    'location_id' => $request->input('location_id'),
                    'address' => $request->input('address'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'pin_code' => $request->input('pin_code'),
                    'floor' => $request->input('floor_id'),
                    'out_of_floor' => $request->input('out_of_floor_id'),
                    'no_of_room_id' => $request->input('no_of_room_id'),
                    'price' => $request->input('price'),
                    'booking_price' => $request->input('booking_price'),
                    'maintenance' => $request->input('maintenance'),
                    'carpet_area' => $request->input('carpet_area'),
                    'car_parking_id' => $request->input('car_parking_id'),
                    'furnishing_status_id' => $request->input('furnishing_status_id'),
                    'positioning_status_id' => $request->input('positioning_status_id'),
                    'note' => $request->input('note'),
                    'description' => $request->input('description'),
                    'avalible_beds' => $request->input('avalible_beds'),
                    'is_address_visible' => $request->input('is_address_visible'),
                    'is_phone_visible' => $request->input('is_phone_visible'),
                    'is_email_visible' => $request->input('is_email_visible'),
                    'is_admin_aproved' => $request->input('is_admin_aproved'),
                    'avalible_from' => $request->input('avalible_from'),
                    'bathroom' => $request->input('bathroom'),
                    'video_url' => $request->input('video_url'),
                    'status' => $request->input('status'),
                    'slug' => Str::slug($request->input('title')),
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

                $result = $this->CommonModel->insert_data_get_id($this->table, $post_data);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => $this->title.' successfully added.',
                    );
                }else{
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong try again later.',
                    );
                }
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
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->soft_delete($this->table, array(array('id', '=', $id)), $post_data);
            }
            $flash_data = array(
                'status' => 'success',
                'message' => $this->title.' successfully deleted.',
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

    /* details */
    public function details(Request $request, $id = null){
        $data['metadata'] = array(
            'page_title' => $id > 0 ? $this->title.' Details' : $this->title.' Add',
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'page_details' => $this->slug.'/details',
            'save_image' => $this->slug.'/save_image',
            'save_food' => $this->slug.'/save_food',
            'delete_image' => $this->slug.'/delete_image',
            'delete_food' => $this->slug.'/delete_food',
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
                        'title' => $id > 0 ? 'Details' : 'Add',  
                    ),
            ),
        );

        $id = decrypt($id);
        $sql = "SELECT property.id, property.title, property.description, property.property_for, IF(property.property_for = '1', 'Rent', 'Sell') AS property_for_text, property.posted_by, IF(property.posted_by = '1', 'Broker', 'Owner') AS posted_by_txt, property.posted_by_id, users.name as posted_by_name, property.property_type_id, property_type.property_type, property.location_id, location.location, property.address, property.is_address_visible, property.furnishing_status_id, furnishing_status.furnishing_status, property.positioning_status_id, positioning_status.positioning_status, property.car_parking_id, car_parking.car_parking, property.preferance, property.carpet_area, property.floor, property.out_of_floor, property.bathroom, property.no_of_room_id, no_of_room.no_of_room, property.price, property.booking_price, property.maintenance, IF(property.gender = '1', 'Male', IF(property.gender = '2', 'Female', IF(property.gender = '3', 'Transgender', 'No Choice'))) AS gender, property.note, property.is_phone_visible, property.is_email_visible, property.property_image, property.avalible_from, property.is_admin_aproved, property.status, property.video_url, property.created_at, property.updated_at FROM `property` LEFT JOIN users ON property.posted_by_id = users.id LEFT JOIN property_type ON property.property_type_id = property_type.id LEFT JOIN location ON property.location_id = location.id LEFT JOIN furnishing_status ON property.furnishing_status_id = furnishing_status.id LEFT JOIN positioning_status ON property.positioning_status_id = positioning_status.id LEFT JOIN car_parking ON property.car_parking_id = car_parking.id LEFT JOIN no_of_room ON property.no_of_room_id = no_of_room.id WHERE property.id = '".$id."'"; 

        $details = DB::select($sql); 
        $data['details'] = $details[0];  
        $data['property_images'] = $this->CommonModel->get_all($table = 'property_image', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('property_id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['food_data'] = $this->CommonModel->get_all($table = 'property_food', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('location_id', '=', $data['details']->location_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        //dd($details); 
        return view('admin.pages.property.details', $data);
    }

    /*Image Upload*/
    public function save_image(Request $request){
        if($request->input('id')){
            $post_data = array(
                'property_id' => $request->input('id'),
                'image_title' => $request->input('image_title'),
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

            $result = $this->CommonModel->insert_data_get_id('property_image', $post_data);
            if($result == true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => $this->title.' image successfully added.',
                );
            }else{
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Something went wrong try again later.',
                );
            }
        }else{
            $flash_data = array(
                'status' => 'danger',
                'message' => 'Something went wrong try again later.',
            );
        }

        Session::put('flash_data', $flash_data); 
        return redirect($this->slug.'/details/'.encrypt($request->input('id')));
    }

    /*Save food*/
    public function save_food(Request $request){
        if($request->input('id')){
            $post_data = array(
                'property_id' => $request->input('id'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $destinationPath = 'public/uploads/food_info_file/';
            if (!empty($_FILES)) {
                if ($_FILES['food_info_file'] && $_FILES['food_info_file']['name'] != "") {
                    $profile_image_new_name = str_replace(" ", "_", time() . $_FILES['food_info_file']['name']);
                    if (move_uploaded_file($_FILES['food_info_file']['tmp_name'], $destinationPath . $profile_image_new_name)) {
                        $post_data['food_info_file'] = $destinationPath . $profile_image_new_name;
                    }
                }
            }

            $result = $this->CommonModel->insert_data_get_id('property_food', $post_data);
            if($result == true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => $this->title.' food info successfully added.',
                );
            }else{
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Something went wrong try again later.',
                );
            }
        }else{
            $flash_data = array(
                'status' => 'danger',
                'message' => 'Something went wrong try again later.',
            );
        }

        Session::put('flash_data', $flash_data); 
        return redirect($this->slug.'/details/'.encrypt($request->input('id')));
    }

    /* delete image */
    public function delete_image(Request $request, $id = null){
        if($id){
            $getOldData = $this->CommonModel->get_all($table = 'property_image', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            if($getOldData){
                $getOldData = $getOldData[0];
                unlink($getOldData->property_image);

                $result = $this->CommonModel->delete_data('property_image', array(array('id', '=', $id)));

                $flash_data = array(
                    'status' => 'success',
                    'message' => $this->title.' image successfully deleted.',
                );

            }else{
                $flash_data = array(
                    'status' => 'danger',
                    'message' => 'Something went wrong try again later.',
                );
            }
        }else{
            $flash_data = array(
                'status' => 'danger',
                'message' => 'Something went wrong try again later.',
            );
        }

        Session::put('flash_data', $flash_data); 
        return redirect($this->slug.'/details/'.encrypt($getOldData->property_id));
    }

    /* delete food */
    public function delete_food(Request $request, $id = null){
        if($id){
            $getOldData = $this->CommonModel->get_all($table = 'property_food', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            if($getOldData){
                $getOldData = $getOldData[0];
                unlink($getOldData->food_info_file);

                $result = $this->CommonModel->delete_data('property_food', array(array('id', '=', $id)));

                $flash_data = array(
                    'status' => 'success',
                    'message' => $this->title.' food info successfully deleted.',
                );

            }else{
                $flash_data = array(
                    'status' => 'danger',
                    'message' => 'Something went wrong try again later.',
                );
            }
        }else{
            $flash_data = array(
                'status' => 'danger',
                'message' => 'Something went wrong try again later.',
            );
        }

        Session::put('flash_data', $flash_data); 
        return redirect($this->slug.'/details/'.encrypt($getOldData->property_id));
    }

}
