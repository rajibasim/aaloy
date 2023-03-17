<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class ReportController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/admin-report';
        $this->title = 'Report';
        $this->table = 'mainstock';
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
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $sql = "SELECT balancesheet.*, product.name as product_name, category.name as category_name, brand.name as brand_name, subseedstore.name as subseedstore_name, scheme.name as scheme_name FROM balancesheet LEFT JOIN subseedstore ON balancesheet.store_id = subseedstore.id LEFT JOIN product ON balancesheet.product_id = product.id LEFT JOIN category ON product.category_id = category.id LEFT JOIN brand ON product.brand_id = brand.id LEFT JOIN scheme ON balancesheet.scheme_id = scheme.id WHERE balancesheet.type = '3'";
        
        if($district_id){
            $serach_data['district_id'] = $district_id;
        }

        if($districtstore_id){
            $serach_data['districtstore_id'] = $districtstore_id;
        }

        if($mainstore_id){
            $serach_data['mainstore_id'] = $mainstore_id;
        }

        if($subseedstore_id){
            $sql = $sql ." AND balancesheet.store_id = '".$subseedstore_id."'";
            $serach_data['subseedstore_id'] = $subseedstore_id;
        }

        if($category_id){
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            $serach_data['brand_id'] = $brand_id;
        }

        if($product_id){
            $sql = $sql ." AND balancesheet.product_id = '".$product_id."'";
            $serach_data['product_id'] = $product_id;
        }

        if($start_date){
            $start_date = $start_date;
            $serach_data['start_date'] = $start_date;
        }

        if($end_date){
            $end_date = $end_date;
            $serach_data['end_date'] = $end_date;
        }else{
           if($start_date){
                $end_date = date('Y-m-d');
            } 
        }

        if((isset($start_date) && $start_date) && isset($end_date) && $end_date){
            $sql = $sql." AND DATE(balancesheet.entry_date) BETWEEN '".$start_date."' AND '".$end_date."'";
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
            $sql = $sql." ORDER BY balancesheet.entry_date DESC";
            $data['rows'] = \DB::select($sql); 

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_district']) && $permission_array['is_district']){
            $main_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM mainstore WHERE districtstore_id = '".$user_data->districtstore_id."'");
            $main_stores_ids = isset($main_stores_ids) && !empty($main_stores_ids) ? $main_stores_ids[0]->ids : '';

            $subseed_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM subseedstore WHERE mainstore_id IN (".$main_stores_ids.") AND districtstore_id = '".$user_data->districtstore_id."'");
            $subseed_stores_ids = isset($subseed_stores_ids) && !empty($subseed_stores_ids) ? $subseed_stores_ids[0]->ids : 0;

            $sql = $sql." AND balancesheet.store_id IN ('".$subseed_stores_ids."') ORDER BY balancesheet.entry_date DESC"; 
            $data['rows'] = \DB::select($sql); 

            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.districtstore_id', '=', $user_data->districtstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        }

        if(isset($permission_array['is_main']) && $permission_array['is_main']){

            $subseed_stores_ids = \DB::select("SELECT GROUP_CONCAT( id SEPARATOR ',') as ids FROM subseedstore WHERE mainstore_id = '".$user_data->mainstore_id."'");
            $subseed_stores_ids = isset($subseed_stores_ids) && !empty($subseed_stores_ids) ? $subseed_stores_ids[0]->ids : 0;

            $sql = $sql." AND balancesheet.store_id IN ('".$subseed_stores_ids."') ORDER BY balancesheet.entry_date DESC"; 
            $data['rows'] = \DB::select($sql);
            
            $data['mainstore'] = $this->CommonModel->get_all($table = 'mainstore', $select = array('*'), $where = array(array('mainstore.is_deleted', '=', '0'), array('mainstore.status', '=', '1'), array('mainstore.id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

            $data['subseedstore'] = $this->CommonModel->get_all($table = 'subseedstore', $select = array('*'), $where = array(array('subseedstore.is_deleted', '=', '0'), array('subseedstore.status', '=', '1'), array('subseedstore.mainstore_id', '=', $user_data->mainstore_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = ""); 
        }

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['product'] = $this->CommonModel->get_all($table = 'product', $select = array('*'), $where = array(array('product.is_deleted', '=', '0'), array('product.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['district'] = $this->CommonModel->get_all($table = 'district', $select = array('*'), $where = array(array('district.is_deleted', '=', '0'), array('district.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['districtstore'] = $this->CommonModel->get_all($table = 'districtstore', $select = array('*'), $where = array(array('districtstore.is_deleted', '=', '0'), array('districtstore.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
         
        return view('admin.pages.report.view', $data);
    }

}
