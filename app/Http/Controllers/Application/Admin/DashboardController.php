<?php
namespace App\Http\Controllers\Application\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Models\CommonModel;
use Illuminate\Support\Facades\Session;
use Validator;
use Mail;
use DB;
use Crypt;

class DashboardController extends Controller {

    private $result = 0;
    private $message = 0;
    private $details = 0;
    private $value = 0;
    private $validator_error = 0;

    public function __construct() {
        $this->CommonModel = new CommonModel();
    }

    public function get_admin_dashboard() {
        $data['metadata'] = array(
            'page_title' => 'Dashboard',
            'page_url' => '/masterdata/states',
        );

        $user_data = session()->get('user_data');
        return view('admin.pages.dashboard.view', $data);
    }

}
