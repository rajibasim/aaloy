<?php
namespace App\Http\Controllers\Application\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\CommonModel;
use App\Models\User;
use JWTAuth;
use JWTAuthException;
use Validator;
use DB;

class AppCmsController extends Controller{

    public function __construct(){
        $this->CommonModel = new CommonModel();
    }

    /* Home Page */    
    public function home(Request $request){
        $data['metadata'] = array(
            'page_title' => 'Home',
            'seo_description' => '',
            'seo_keyword' => ''
        );

        return view('web.pages.home.home', $data);
    }

    //CMS Page
    public function appCmsPage(Request $request, $page_slug){
        $row = $this->CommonModel->get_all($table = 'cms', $select = array('*'), $where = array(array('is_deleted', '=', 0), array('slug', '=', $page_slug)), $join = array(), $left = array(), $right = array(), $order = array(), $group = "", $limit = array(), $raw = "", $paging = "");

        if($row == null){
            abort('404');
        }

        $data['row'] = $row[0];
        $data['metadata'] = array(
            'page_title' => $data['row']->title,
            'seo_description' => $data['row']->seo_description,
            'seo_keyword' => $data['row']->seo_keyword
        );

        return view('web.pages.app-cms.index', $data);
    }

    //Blog List Page
    public function appBlogs(Request $request, $slug = ''){
        if($slug){
            $row = $this->CommonModel->get_all($table = "blog", $select = array('blog.*','category.category'), $where = array(array('blog.is_deleted', '=', 0), array('blog.status', '=', 1), array('blog.slug', '=', $slug)), $join = array(), $left = array(array('category', 'blog.category_id', '=', 'category.id')), $right = array(), $order = array(array('blog.id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");
        }else{
            $row = $this->CommonModel->get_all($table = "blog", $select = array('blog.*','category.category'), $where = array(array('blog.is_deleted', '=', 0), array('blog.status', '=', 1)), $join = array(), $left = array(array('category', 'blog.category_id', '=', 'category.id')), $right = array(), $order = array(array('blog.id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");
        }
        
        if($row == null){
            abort('404');
        }
        $page = '';
        if($slug){
            $data['row'] = $row[0];
            $data['metadata'] = array(
                'page_title' => $data['row']->title,
                'seo_description' => $data['row']->seo_description,
                'seo_keyword' => $data['row']->seo_keyword,
            );

            $data['recent'] = $this->CommonModel->get_all($table = "blog", $select = array('blog.*','category.category'), $where = array(array('blog.is_deleted', '=', 0), array('blog.status', '=', 1), array('blog.id', '<>', $data['row']->id)), $join = array(), $left = array(array('category', 'blog.category_id', '=', 'category.id')), $right = array(), $order = array(array('blog.id' => "ASC")), $group = "", $limit = array(), $raw = "", $paging = "");

            $page = 'details';
        }else{
            $data['row'] = $row;
            $data['metadata'] = array(
                'page_title' => config('config.seo_content.blog.page_title'),
                'seo_description' => config('config.seo_content.blog.seo_description'),
                'seo_keyword' => config('config.seo_content.blog.seo_keyword'),
            );
            $page = 'index';
        }

        return view('web.pages.app-blog.'.$page, $data);
    }
}
