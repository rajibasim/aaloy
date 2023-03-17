<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class UsersController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/admin-users';
        $this->title = 'User';
        $this->table = 'users';
    }

    /* List view */    
    public function index(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $name = $request->name;
        $status = $request->status;
        $email = $request->email;
        $phone = $request->phone;
        $where = array();
        $where = array(
            array('users.is_deleted', '=', '0')
        );
        if($name){
            array_push($where, array('users.name', 'like', "%{$name}%"));
            $serach_data['name'] = $name;
        }

        if($status){
            array_push($where, array('users.status', '=', $status));
            $serach_data['status'] = $status;
        }

        if($email){
            array_push($where, array('users.email', '=', $email));
            $serach_data['email'] = $email;
        }

        if($phone){
            array_push($where, array('users.phone', '=', $phone));
            $serach_data['phone'] = $phone;
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

        $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('users.*', 'subseedstore.name as subseedstore_name', 'districtstore.name as districtstore_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('districtstore', 'users.districtstore_id', '=', 'districtstore.id'), array('mainstore', 'users.mainstore_id', '=', 'mainstore.id'), array('subseedstore', 'users.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20"); 

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            array_push($where, array('users.districtstore_id', '=', $user_data->districtstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('users.*', 'subseedstore.name as subseedstore_name', 'districtstore.name as districtstore_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('districtstore', 'users.districtstore_id', '=', 'districtstore.id'), array('mainstore', 'users.mainstore_id', '=', 'mainstore.id'), array('subseedstore', 'users.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            array_push($where, array('users.mainstore_id', '=', $user_data->mainstore_id));
            $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('users.*', 'subseedstore.name as subseedstore_name', 'districtstore.name as districtstore_name', 'mainstore.name as mainstore_name'), $where, $join = array(), $left = array(array('districtstore', 'users.districtstore_id', '=', 'districtstore.id'), array('mainstore', 'users.mainstore_id', '=', 'mainstore.id'), array('subseedstore', 'users.subseedstore_id', '=', 'subseedstore.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20");
        }  


        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.mainstore_id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        } 

        return view('admin.pages.users.view', $data);
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

        if($id){
            $id = decrypt($id);
            $details = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $data['details'] = !empty($details) ? $details[0] : [];

            if($data['details']->type == 1){
              $data['stores'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            }else if($data['details']->type == 2){
              $data['stores'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            }else{
              $data['stores'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            }
        }

        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        
        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        if(isset($permission_array['is_main']) && $permission_array['is_main']){
            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.mainstore_id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }  

        $data['designation'] = $this->CommonModel->get_all($table = 'designation', $select = array('*'), $where = array(array('designation.is_deleted', '=', '0'), array('designation.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.users.form', $data);
    }

    /* store & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'name' => 'required',
            'incharge' => 'required',
            'designation_id' => 'required',
            'designation' => 'required',
            'type' => 'required',
            'store_id' => 'required',
            'password' => 'required',
            'status' => 'required', 
        ]); 
        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            if($id){

                $old_data = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $type = $request->input('type');
                $store_id = $request->input('store_id');
                $districtstore_id = 0;
                $mainstore_id = 0;
                $subseedstore_id = 0;
                if($type == '1'){
                    $districtstore_id = $store_id;
                }

                if($type == '2'){
                    $mainstore_id = $store_id;
                }

                if($type == '3'){
                    $subseedstore_id = $store_id;
                }
                

                $post_data = array(
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'incharge' => $request->input('incharge'),
                    'designation_id' => $request->input('designation_id'),
                    'designation' => $request->input('designation'),
                    'type' => $request->input('type'),
                    'store_id' => $request->input('store_id'),
                    'districtstore_id' => $districtstore_id,
                    'mainstore_id' => $mainstore_id,
                    'subseedstore_id' => $subseedstore_id,
                    'password' => md5($request->input('password')),
                    'status' => $request->input('status'),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->update_data($this->table, array(array('id', '=', $id)), $post_data, $old_data, $id);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'User successfully updated.',
                    );
                }else{
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong try again later.',
                    );
                }
            }else{

                $type = $request->input('type');
                $store_id = $request->input('store_id');
                $districtstore_id = 0;
                $mainstore_id = 0;
                $subseedstore_id = 0;
                if($type == '1'){
                    $districtstore_id = $store_id;
                }

                if($type == '2'){
                    $mainstore_id = $store_id;
                }

                if($type == '3'){
                    $subseedstore_id = $store_id;
                }

                $post_data = array(
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'incharge' => $request->input('incharge'),
                    'designation' => $request->input('designation'),
                    'designation_id' => $request->input('designation_id'),
                    'type' => $request->input('type'),
                    'store_id' => $request->input('store_id'),
                    'districtstore_id' => $districtstore_id,
                    'mainstore_id' => $mainstore_id,
                    'subseedstore_id' => $subseedstore_id,
                    'password' => md5($request->input('password')),
                    'status' => $request->input('status'),
                    'created_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id($this->table, $post_data);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'User successfully added.',
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
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->soft_delete($this->table, array(array('id', '=', $id)), $post_data, $id);
            }
            $flash_data = array(
                'status' => 'success',
                'message' => 'User successfully deleted.',
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
