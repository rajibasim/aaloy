<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
     public function admin_user_get($data){
        $get_result_type = 0;
        if(isset($data['get_result_type']) && !empty($data['get_result_type'])){
            $get_result_type = $data['get_result_type'];
        }
            $category= DB::table('admin as ad');
            $category->select('ad.*'); 
            $category->orderBy('ad.id', 'desc');
        if($get_result_type == 1) {
            $category->where('ad.admin_user_name','=',$data['admin_user_name']); 
            $category->where('ad.admin_password','=',$data['admin_password']); 
            $category->where('ad.status','=',1); 
            $result = $category->first();
        }elseif($get_result_type == 2) {
            $category->where('ad.id','=',$data['admin_id']); 
            $result = $category->first();
        }elseif($get_result_type == 3) {
            $result = $category->get(); 
        }else{
            $result = $category->get(); 
        }
        return $result;
     }
     public function admin_change_password($data){
          $result = DB::table('admin')
                ->where('id', $data['id'])
                ->where('admin_password', $data['old_admin_password'])
                ->update([
                        'updated_at'=> $data['updated_at'],
                        'admin_password'=> $data['new_admin_password']                    
                ]);
        return $result;
     }
}
