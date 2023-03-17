<?php
namespace App\Http\Controllers\Application\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\CommonModel;
use App\Models\AdminModel;

class AdminAuthController extends Controller
{
    private $result = 0;
    private $message = 0;
    private $details = 0;
    private $value = 0;
    private $validator_error = 0;
   
    public function __construct() {
        $this->CommonModel = new CommonModel();
        $this->AdminModel = new AdminModel();
       
    }
    
    public function admin_login() {
        if (Session::has('admin_id')) {
            return redirect('admin-dashboard');
        }
        return view('admin.adminlogin');
    }


    public function post_login(Request $request) {
        $validator = Validator::make($request->all(), [
            'admin_user_name' => 'required',
            'admin_password' => 'required',
            //'user_type' => 'required',
        ]);

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $user_type = $request->input('user_type');
            $values = array(
                'admin_user_name' => $request->input('admin_user_name'), 
                'admin_password' => md5($request->input('admin_password')),
                'get_result_type' => 1
            );

            $logedin_details = $this->AdminModel->admin_user_get($values);
            if($logedin_details){
                Session::put('admin_id', $logedin_details->id);
                Session::put('admin_name', $logedin_details->admin_name);
                Session::put('admin_user_name', $logedin_details->admin_user_name);
                //Session::put('permission_array', $permission_array);
                Session::put('user_data', []);

                return redirect('admin-dashboard');
            }else{
                $flash_data = array(
                    'status' => 'error',
                    'message' => 'Invalid Login Credentials.',
                );
                Session::put('flash_data', $flash_data);
                return redirect()->back();
            }
        }
    }

    public function admin_logout(){
        if(Session::has('admin_id')){
            Session::flush();
        }
        return redirect('admin-login');
    }

    
    public function admin_change_password(Request $request){
         $validator = Validator::make($request->all(), [
                    'new_admin_password' => 'required',
                    'old_admin_password' => 'required'
                ]);
        if ($validator->fails()) {
            $this->result = config('constants.0');
            $this->message = trans('process.0');
            $this->validator_error = $validator->errors();
        } else {
            
            if($request->input('new_admin_password') != $request->input('old_admin_password')){
             $this->value = array(
                                'old_admin_password' => md5($request->input('old_admin_password')),
                                'new_admin_password' => md5($request->input('new_admin_password')),
                                'id' => Session::get('admin_id'),
                                'updated_at'=> date('Y-m-d H:i:s')
                                );
           $logedin_details = $this->AdminModel->admin_change_password($this->value);
            if($this->details > 0){
                $this->result = true;
                $this->message = 'password update successful';
            }else{
                $this->result = false;
                $this->message = 'Unabel to update password';
            }
            }else{
                $this->result = false;
                $this->message = 'This password alredy used';
            }
        }
        return Response::make([
                    'result' => $this->result,
                    'message' => $this->message,
                    'validator_error' => $this->validator_error,
                    'details' =>$logedin_details       
                ]);     
    }
}
