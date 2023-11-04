<?php 

namespace App\Http\Controllers\Application\API;

use DB;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\CommonModel;
use App\Models\push;
use App\Models\User;
use JWTAuth;
use JWTAuthException;

class UserController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->CommonModel = new CommonModel();
	}

    ### Logout
    public function logout(Request $request){
        try {
            Auth::guard('api')->logout();
            return response()->json([
                'result' => true,
                'message' => "Successfully logout",
                'data' => '',
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ]);
        }
    }

    ### Update Profile
    public function updateProfile(Request $request){
        $user_data = Auth::user();
        try {
            $post_data = [];
            if ($request->name) {
                $post_data['name'] = $request->name;
            }

            if ($request->address) {
                $post_data['address'] = $request->address;
            }

            if ($request->hasFile('profile_image')){
                $file = $request->file('profile_image');
                $image = time().$file->getClientOriginalName();
                $image = str_replace(' ', '', $image);
                $destinationPath = public_path() . '/uploads/profile_image/';
                $file->move($destinationPath, $image);  
                $post_data['profile_image'] = 'public/uploads/property_image/'.$image; 
            }

            $post_data['updated_at'] = date('Y-m-d H:i:s');
            $update = $this->CommonModel->update_data($table = "users", array(array('id', '=', $user_data->id)), $data = $post_data);

            //dd($update);

            $user_details = User::where('id','=',$user_data->id)->first();
            $token = JWTAuth::fromUser($user_details);

            $message = "";
            $result_data = array(
                'id' => $user_data->id,
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 604800,
                'user_data' => $user_details,
            );

            return response()->json([
                'result' => true,
                'message' => $message,
                'data' => $result_data,
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

