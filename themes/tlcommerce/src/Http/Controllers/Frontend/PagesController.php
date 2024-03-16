<?php

namespace Theme\TLCommerce\Http\Controllers\Frontend;

use Core\Models\TlPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Theme\TLCommerce\Repositories\PageRepository;

class PagesController extends Controller
{
    protected $page_repository;
    public function __construct(PageRepository $page_repository)
    {
        $this->page_repository = $page_repository;
    }

    /**
     * customer login
     */
    public function customerLogin()
    {
        return view('theme/tlcommerce::frontend.pages.customer-login');
    }

    /**
     * Customer registration
     */
    public function customerRegistration()
    {
        return view('theme/tlcommerce::frontend.pages.customer-registration');
    }

    /**
     * Will redirect to single page details page 
     */
    public function getSinglePageDetails(Request $request){
        try {
            $request_path = $request->path();
            $request_path_array = explode('/', $request_path);
            $permalink = end($request_path_array);

            $data = [
                DB::raw('GROUP_CONCAT(distinct tl_pages.id) as id'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.title) as title'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.meta_title) as meta_title'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.meta_description) as meta_description'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.meta_image) as meta_image'),
            ];
            $match_case = [
                ['tl_pages.permalink', '=', $permalink],
            ];
            $page_details = $this->page_repository->getPages($data, $match_case)->first();

            if($page_details!=null){
                if($page_details->meta_image!=null){
                    $page_details->meta_image = getFilePath($page_details->meta_image);
                }
            }

            return view('theme/tlcommerce::frontend.pages.page-details')->with(
                [
                    'page_details' => $page_details
                ]
            );
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     ** Show the Details page in frontend
     ** click on the permalink and sent to the frontend if published
     * @return View
     */
    public function pageDetails(Request $request)
    {
        
        try {
            $request_path = $request->path();
            $request_path_array = explode('/', $request_path);
            $permalink = end($request_path_array);

            $data = [
                DB::raw('GROUP_CONCAT(distinct tl_pages.id) as id'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.title) as title'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.permalink) as permalink'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.parent) as parent'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.visibility) as visibility'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.content) as content'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.page_template) as page_template'),
                DB::raw('GROUP_CONCAT(distinct tl_pages.page_image) as page_image'),
            ];
            $match_case = [
                ['tl_pages.publish_at', '<', currentDateTime()],
                ['tl_pages.publish_status', '=',  config('tlcommerce.page_status.publish')],
                ['tl_pages.permalink', '=', $permalink],
            ];
            $page = $this->page_repository->getPages($data, $match_case)->first();

            $parentUrl = getParentUrl($page);
            $parents = preg_split('#/#', $parentUrl, -1, PREG_SPLIT_NO_EMPTY);

            $breadCrumbs=[
                [
                    'text'=>'Home',
                    'href'=>'/'
                ]
            ];

            for($i=0;$i<count($parents);$i++){
                $parent = TlPage::where('permalink', $parents[$i])->first();
                array_push($breadCrumbs,[
                    'text'=>$parent->translation('title', getLocale()),
                    'href'=>"/page/".getParentUrl($parent) . $parent->permalink
                ]);
            }

            array_push($breadCrumbs,[
                'text'=>$page->title,
                'active'=>true
            ]);

            if(isset($page->page_image)){
                $page->page_image = getFilePath($page->page_image);
            }
            $page->title = $page->translation('title', Session::get('api_locale'));
            $page->content = $page->translation('content', Session::get('api_locale'));

            return response()->json(
                [
                    'success' => true,
                    'page' => $page,
                    'breadCrumbs' => $breadCrumbs,
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /**
     * Preview Page
     */
    public function previewPage($slug)
    {
        try {
            $page = $this->page_repository->findPage($slug);
            if(isset($page->page_image)){
                $page->page_image = getFilePath($page->page_image);
            }
            $page->title = $page->translation('title', Session::get('api_locale'));
            $page->content = $page->translation('content', Session::get('api_locale'));
      
            return response()->json(
                [
                    'success' => true,
                    'page' => $page
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
}
