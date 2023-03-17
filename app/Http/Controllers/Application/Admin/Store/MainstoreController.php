<?php
namespace App\Http\Controllers\Application\Admin\Store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class MainstoreController extends Controller{
    
    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/store/admin-main-store';
        $this->title = 'Main Store';
        $this->table = 'mainstore';
        /*$this->middleware(function ($request, $next) {
            $permission_array = session()->get('permission_array');
        });*/
    }

    /* List view */    
    public function index(Request $request){
        $permission_array = session()->get('permission_array');
        $user_data = session()->get('user_data');
        $serach_data = array();
        $name = $request->name;
        $status = $request->status;
        $districtstore_id = $request->districtstore_id;
        $where = array();
        $where = array(
            array('mainstore.is_deleted', '=', 0)
        );
        if($name){
            array_push($where, array('mainstore.name', 'like', "%{$name}%"));
            $serach_data['name'] = $name;
        }

        if($status){
            array_push($where, array('mainstore.status', '=', $status));
            $serach_data['status'] = $status;
        }

        if($districtstore_id){
            array_push($where, array('mainstore.districtstore_id', '=', $districtstore_id));
            $serach_data['districtstore_id'] = $districtstore_id;
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

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            array_push($where, array('mainstore.districtstore_id', '=', $user_data->districtstore_id)); 
        }

        $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('mainstore.*', 'districtstore.name as districtstorename'), $where, $join = array(), $left = array(array('districtstore', 'mainstore.districtstore_id', '=', 'districtstore.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20"); 

        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.mainstore.view', $data);
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
        }

        if(isset($permission_array['is_admin']) && $permission_array['is_admin']){
            $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
        }        

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
        }

        $data['subdevision'] = $this->CommonModel->get_all($table = 'subdevision', $select = array('*'), $where = array(array('is_deleted', '=', 0)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.mainstore.form', $data);
    }

    /* store & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|unique:mainstore,name,' . $id,
            'districtstore_id' => 'required',
            'status' => 'required', 
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            if($id){

                $old_data = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $post_data = array(
                    'districtstore_id' => $request->input('districtstore_id'),
                    'subdevision_id' => $request->input('subdevision_id'),
                    'subdivision_name' => $request->input('subdivision_name'),
                    'name' => $request->input('name'),
                    'status' => $request->input('status'),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->update_data($this->table, array(array('id', '=', $id)), $post_data, $old_data, $id);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'District store successfully updated.',
                    );
                }else{
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong try again later.',
                    );
                }
            }else{

                $post_data = array(
                    'districtstore_id' => $request->input('districtstore_id'),
                    'subdevision_id' => $request->input('subdevision_id'),
                    'subdivision_name' => $request->input('subdivision_name'),
                    'name' => $request->input('name'),
                    'status' => $request->input('status'),
                    'created_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id($this->table, $post_data);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'District store successfully added.',
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
                'message' => 'District store successfully deleted.',
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
