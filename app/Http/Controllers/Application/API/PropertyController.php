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

class PropertyController extends Controller
{
    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->CommonModel = new CommonModel();
	}

    ### Add
    public function add(Request $request){
        dd("add");
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

    ### Edit
    public function edit(Request $request, $id){
        dd("edit");
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

    ### Delete
    public function delete(Request $request, $id){
        dd("delete");
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

    ### Details
    public function details(Request $request, $id){
        dd("details");
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

}

