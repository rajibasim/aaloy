<?php
namespace App\Http\Controllers\Application\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CommonModel;
use Validator;

class ProductController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
        $this->slug = '/admin-product';
        $this->title = 'Comodity';
        $this->table = 'product';
    }

    /* List view */    
    public function index(Request $request){
        $serach_data = array();
        $name = $request->name;
        $status = $request->status;
        $category_id = $request->category_id;
        $brand_id = $request->brand_id;
        $unit_id = $request->unit_id;
        $where = array();
        $where = array(
            array('product.is_deleted', '=', '0')
        );
        if($name){
            array_push($where, array('product.name', 'like', "%{$name}%"));
            $serach_data['name'] = $name;
        }

        if($status){
            array_push($where, array('product.status', '=', $status));
            $serach_data['status'] = $status;
        }

        if($category_id){
            array_push($where, array('product.category_id', '=', $category_id));
            $serach_data['category_id'] = $category_id;
        }

        if($brand_id){
            array_push($where, array('product.brand_id', '=', $brand_id));
            $serach_data['brand_id'] = $brand_id;
        }

        if($unit_id){
            array_push($where, array('product.unit_id', '=', $unit_id));
            $serach_data['unit_id'] = $unit_id;
        }

        $data['metadata'] = array(
            'page_title' => $this->title,
            'page_url' => $this->slug,
            'page_form_url' => $this->slug.'/form',
            'page_delete_url' => $this->slug.'/delete',
            'page_data_store_url' => $this->slug.'/save',
            'page_data_details_url' => $this->slug.'/details',
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

        $data['rows'] = $this->CommonModel->get_all($table = $this->table, $select = array('product.*', 'unit.name as unit', 'category.name as category', 'brand.name as brand'), $where, $join = array(), $left = array(array('unit', 'product.unit_id', '=', 'unit.id'), array('category', 'product.category_id', '=', 'category.id'), array('brand', 'product.brand_id', '=', 'brand.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "20");   
         $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('category.is_deleted', '=', '0'), array('category.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('brand.is_deleted', '=', '0'), array('brand.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['unit'] = $this->CommonModel->get_all($table = 'unit', $select = array('*'), $where = array(array('unit.is_deleted', '=', '0'), array('unit.status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");     
        return view('admin.pages.product.view', $data);
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

        $data['category'] = $this->CommonModel->get_all($table = 'category', $select = array('*'), $where = array(array('is_deleted', '=', '0'), array('status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['brand'] = $this->CommonModel->get_all($table = 'brand', $select = array('*'), $where = array(array('is_deleted', '=', '0'), array('status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
        $data['unit'] = $this->CommonModel->get_all($table = 'unit', $select = array('*'), $where = array(array('is_deleted', '=', '0'), array('status', '=', '1')), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        return view('admin.pages.product.form', $data);
    }

    /* store & update data */
    public function save(Request $request){
        $id = $request->input('id');
        $validator = Validator::make($request->all(), [ 
            'name' => 'required|unique:product,name,' . $id,
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit_id' => 'required',
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
                    'name' => $request->input('name'),
                    'category_id' => $request->input('category_id'),
                    'brand_id' => $request->input('brand_id'),
                    'unit_id' => $request->input('unit_id'),
                    'status' => $request->input('status'),
                    'updated_by' => $request->input('session_id'),
                    'updated_at' => date('Y-m-d H:i:s'),
                );
                $result = $this->CommonModel->update_data($this->table, array(array('id', '=', $id)), $post_data, $old_data, $id);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'Comodity successfully updated.',
                    );
                }else{
                    $flash_data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong try again later.',
                    );
                }
            }else{

                $post_data = array(
                    'name' => $request->input('name'),
                    'category_id' => $request->input('category_id'),
                    'brand_id' => $request->input('brand_id'),
                    'unit_id' => $request->input('unit_id'),
                    'status' => $request->input('status'),
                    'created_by' => $request->input('session_id'),
                    'created_at' => date('Y-m-d H:i:s'),
                );

                $result = $this->CommonModel->insert_data_get_id($this->table, $post_data);
                if($result == true){
                    $flash_data = array(
                        'status' => 'success',
                        'message' => 'Comodity successfully added.',
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
                'message' => 'Product successfully deleted.',
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

    /* product details */
    public function details(Request $request, $id = null){
        $data['metadata'] = array(
            'page_title' => 'Product Details',
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
                        'title' => 'Details',  
                    ),
            ),
        );

        $id = decrypt($id);
        $details = $this->CommonModel->get_all($table = $this->table, $select = array('product.*', 'unit.name as unit', 'category.name as category', 'brand.name as brand'), $where = array(array('product.id', '=', $id)), $join = array(), $left = array(array('unit', 'product.unit_id', '=', 'unit.id'), array('category', 'product.category_id', '=', 'category.id'), array('brand', 'product.brand_id', '=', 'brand.id')), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");  
        $data['details'] = !empty($details) ? $details[0] : [];
        
        $data['rows'] = $this->CommonModel->get_all($table = 'productstock', $select = array('*'), $where = array(array('product_id', '=', $id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "25");

        return view('admin.pages.product.details', $data);
    }

    /* store & update data */
    public function updatestock(Request $request){
        $product_id = $request->input('product_id');
        $validator = Validator::make($request->all(), [ 
            'date' => 'required',
            'quentity' => 'required',
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{

            $flash_data  = '';

            $details = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");  
            $product_details = $details[0];

            $txn_details = $this->CommonModel->get_all($table = 'productstock', $select = array('*'), $where = array(array('product_id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(array('id'=> 'DESC')), $group = "", $limit = array(), $raw = "", $paging = "");
            if($txn_details){
                $qty = $txn_details[0]->adjust_stock;
            }else{
                $qty = 0;
            }

            $type = $request->input('type');
            $date = explode('/', $request->input('date'));
            $date = $date[2].'-'.$date[1].'-'.$date[0];
            $quentity = $request->input('quentity');
            if($type == 1){
                $adjust_stock = $qty + $quentity;
                $current_stock = $adjust_stock;
            }

            if($type == 3){
                $adjust_stock = $qty + $quentity;
                $current_stock = $adjust_stock;
            }

            if($type == 4){
                $adjust_stock = $qty - $quentity;
                $current_stock = $adjust_stock;
            }

            $post_data = array(
                'entry_date' => $date,
                'product_id' => $product_id,
                'type' => $type,
                'quentity' => $quentity,
                'adjust_stock' => $adjust_stock,
                'note' => $request->input('note'),
                'status' => 1,
                'created_by' => $request->input('session_id'),
                'updated_by' => $request->input('session_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $result = $this->CommonModel->insert_data_get_id('productstock', $post_data);

            //update product master table

            $old_data = $this->CommonModel->get_all($table = $this->table, $select = array('*'), $where = array(array('id', '=', $product_id)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");
            $old_data = $old_data[0];

            $update_pro = array(
                'current_stock' => $current_stock,
                'updated_by' => $request->input('session_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $update = $this->CommonModel->update_data($this->table, array(array('id', '=', $product_id)), $update_pro, $old_data, $product_id);

            if($result == true){
                $flash_data = array(
                    'status' => 'success',
                    'message' => 'Stock successfully operated.',
                );
            }else{
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Something went wrong try again later.',
                );
            }

            Session::put('flash_data', $flash_data); 
            return redirect('admin-product/details/'.encrypt($product_id));
        }
    }


    
}
