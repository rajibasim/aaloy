<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\CommonModel;
use Validator;

class BannerController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/banner';
        $this->title = 'Banner';
        $this->table = 'banner';
    }

    /* List view */    
    public function index(Request $request){
        $serach_data = array();
        $title = $request->title;
        $status = $request->status;
        $where = array();
        $where = array(
            array('is_deleted', '=', 0)
        );
        if($title){
            array_push($where, array('title', 'like', "%{$title}%"));
            $serach_data['title'] = $title;
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
        return view('admin.pages.banner.view', $data);
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

        return view('admin.pages.banner.form', $data);
    }

    /* store & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'title' => 'required|unique:banner,title,' . $id,
            'url' => 'required',
            'description' => 'required',
            'status' => 'required', 
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $flash_data  = '';
            if($id){
                $post_data = array(
                    'title' => $request->input('title'),
                    'url' => $request->input('url'),
                    'description' => $request->input('description'),
                    'status' => $request->input('status'),
                    'slug' => Str::slug($request->input('title')),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $destinationPath = 'public/uploads/banner_image/';
                if (!empty($_FILES)) {
                    if ($_FILES['banner_image'] && $_FILES['banner_image']['name'] != "") {
                        $profile_image_new_name = str_replace(" ", "_", time() . $_FILES['banner_image']['name']);
                        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $destinationPath . $profile_image_new_name)) {
                            $post_data['banner_image'] = $destinationPath . $profile_image_new_name;
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
                    'url' => $request->input('url'),
                    'description' => $request->input('description'),
                    'status' => $request->input('status'),
                    'slug' => Str::slug($request->input('title')),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $destinationPath = 'public/uploads/banner_image/';
                if (!empty($_FILES)) {
                    if ($_FILES['banner_image'] && $_FILES['banner_image']['name'] != "") {
                        $profile_image_new_name = str_replace(" ", "_", time() . $_FILES['banner_image']['name']);
                        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $destinationPath . $profile_image_new_name)) {
                            $post_data['banner_image'] = $destinationPath . $profile_image_new_name;
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
}
