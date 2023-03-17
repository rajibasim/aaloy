<?php
namespace App\Http\Controllers\Application\Admin\Masterdata;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class BrandController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/masterdata/admin-brand';
        $this->title = 'Manufacturer';
        $this->table = 'brand';
    }

    /* List view */    
    public function index(Request $request){
        $serach_data = array();
        $name = $request->name;
        $status = $request->status;
        $where = array();
        $where = array(
            array('is_deleted', '=', 0)
        );
        if($name){
            array_push($where, array('name', 'like', "%{$name}%"));
            $serach_data['name'] = $name;
        }

        if($status){
            array_push($where, array('status', '=', $status));
            $serach_data['status'] = $status;
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

        $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where, $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20");        
        return view('admin.pages.brand.view', $data);
    }

    /* add & edit form */
    public function form(Request $request, $id = null){
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

        return view('admin.pages.brand.form', $data);
    }

    /* store & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|unique:brand,name,' . $id,
            'status' => 'required', 
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            if($id){

                $old_data = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
                $old_data = $old_data[0];

                $issue_date = explode('/', $request->input('issue_date'));
                $issue_date = $issue_date[2].'-'.$issue_date[1].'-'.$issue_date[0];

                $expiry_date = explode('/', $request->input('expiry_date'));
                $expiry_date = $expiry_date[2].'-'.$expiry_date[1].'-'.$expiry_date[0];

                $post_data = array(
                    'name' => $request->input('name'),
                    'registration_address' => $request->input('registration_address'),
                    'licence_address' => $request->input('licence_address'),
                    'licence_number' => $request->input('licence_number'),
                    'issue_date' => $issue_date,
                    'expiry_date' => $expiry_date,
                    'status' => $request->input('status'),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->update_data($this->table, array(array('id', '=', $id)), $post_data, $old_data, $id);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'Manufacturer successfully updated.',
                    );
                }else{
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong try again later.',
                    );
                }
            }else{

                $issue_date = explode('/', $request->input('issue_date'));
                $issue_date = $issue_date[2].'-'.$issue_date[1].'-'.$issue_date[0];

                $expiry_date = explode('/', $request->input('expiry_date'));
                $expiry_date = $expiry_date[2].'-'.$expiry_date[1].'-'.$expiry_date[0];

                $post_data = array(
                    'name' => $request->input('name'),
                    'registration_address' => $request->input('registration_address'),
                    'licence_address' => $request->input('licence_address'),
                    'licence_number' => $request->input('licence_number'),
                    'issue_date' => $issue_date,
                    'expiry_date' => $expiry_date,
                    'status' => $request->input('status'),
                    'created_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id($this->table, $post_data);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'Manufacturer successfully added.',
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
                'message' => 'Brand successfully deleted.',
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
