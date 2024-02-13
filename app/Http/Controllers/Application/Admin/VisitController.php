<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\CommonModel;
use Validator;

class VisitController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/visit-request';
        $this->title = 'Request For Visit';
        $this->table = 'users_requet_for_visit';
    }

    /* List view */    
    public function index(Request $request){
        $serach_data = array();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $visit_status = $request->visit_status;
        $where = array();
        $where = array(
            array('users_requet_for_visit.is_deleted', '=', 0)
        );
        if($start_date){
            array_push($where, array('users_requet_for_visit.created_at', '>=', $start_date));
            $serach_data['start_date'] = $start_date;
        }

        if($end_date){
            array_push($where, array('users_requet_for_visit.created_at', '<=', $end_date));
            $serach_data['end_date'] = $end_date;
        }

        if($visit_status){
            array_push($where, array('users_requet_for_visit.visit_status', '=', $visit_status));
            $serach_data['visit_status'] = $visit_status;
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
        //posted_by_id
        $data['rows'] = $this->CommonModel->get_all($table = "users_requet_for_visit", $select = array('users_requet_for_visit.*', 'users.name', 'users.phone', 'property.title', 'property.address',  'property.property_for', 'property.posted_by', 'p_users.name as posted_by_name'), $where, $join = array(), $left = array(array('users', 'users.id', '=', 'users_requet_for_visit.user_id'), array('property', 'property.id', '=', 'users_requet_for_visit.property_id'), array('users as p_users', 'p_users.id', '=', 'property.posted_by_id')), $right = array(), $order = array(array('users_requet_for_visit.id' => 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "20");  
        //dd($data['rows']);   
        return view('admin.pages.visit.view', $data);
    }

    /* Change status */
    public function changeStatus(Request $request){
        $id = $request->id;
        $value = $request->value;
        if($id && $value){
            $update_data = array(
                'visit_status' => $value,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $result = $this->CommonModel->update_data($this->table, array(array('id', '=', $id)), $update_data);
            if($result == true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => $this->title.' status successfully updated.',
                );
            }else{
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Something went wrong try again later.',
                );
            }
            Session::put('flash_data', $flash_data); 
            return redirect()->back();
        }else{
            abort(403);
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
