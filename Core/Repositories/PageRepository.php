<?php

namespace Core\Repositories;

use Core\Models\TlPage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Core\Models\TlPageTemplates;
use Core\Models\TlPageTranslation;

class PageRepository
{
    /**
     * Get page List by different conditions.
     * 
     * @param array $data select from
     * @param array $match_case where condition
     * @param integer $paginate_page paginate number
     * @param string $search search text
     *
     * @return mixed|integer|boolean
     */
    public function getPages($data = ['*'], $match_case = [], $paginate_page = null, $search = '')
    {
        $pages = DB::table('tl_pages')
            ->join('tl_users', 'tl_users.id', '=', 'tl_pages.user_id')
            ->leftJoin('tl_page_templates', 'tl_page_templates.id', '=', 'tl_pages.page_template')
            ->orderBy('tl_pages.order', 'asc')
            ->orderBy('tl_pages.id', 'desc')
            ->groupBy('tl_pages.id')
            ->where($match_case);

        $pages = $pages->where(function ($query) use ($search) {
            $query->where('tl_pages.title', 'like', '%' . $search . '%')
                ->orWhere('tl_pages.visibility', 'like', '%' . $search . '%')
                ->orWhere('tl_pages.content', 'like', '%' . $search . '%')
                ->orWhere('tl_users.name', 'like', '%' . $search . '%');
        });

        $pages = $pages->select($data);

        if (isset($paginate_page)) {
            $pages = $pages->paginate($paginate_page);
        } else {
            $pages;
        }
        return $pages;
    }

    /**
     ** get a page by permalink
     * @param Tlpage $permalink
     * @return mixed|array
     */
    public function findPage($permalink)
    {
        $page = TlPage::where('permalink', $permalink)->first();
        return $page;
    }

    /**
     ** page update
     * @param Tlpage $request
     * @return void
     */
    public function pageUpdate($request)
    {
        if ($request['lang'] != null && $request['lang'] != 'en') {
            $page_translation = TlPageTranslation::firstOrNew(['page_id' => $request['id'], 'lang' => $request['lang']]);
            $page_translation->title = $request['title'];
            $page_translation->content = $request['content'];
            $page_translation->save();
        } else {
            $this->pageCreateUpdate($request, $request->id);
        }
    }

    /**
     ** This function is for page Create Or Update  based on parameter passed.
     ** If Id is set then it will update the page , if not
     ** it will create a new page.
     ** action param is for draft,preview. if action is set then publish status is null and if action is not set then publish status is publish.
     * @param mixed|array $request
     * @param mixed $id
     * @param mixed $action
     * @return mixed/array created or updated $page
     */
    public function pageCreateUpdate($request, $id = null, $action = null)
    {
        $page = TlPage::firstOrNew(['id' => $id]);
        $page->page_image = $request['page_image'];
        $page->title = $request['title'];
        $page->permalink = $request['permalink'];
        $page->content = $request['content'];
        $page->visibility = $request['visibility'];

        if ($request['visibility'] == 'password') {
            if (!isset($request['page_password'])) {
                $page->visibility = 'public';
            }
        }
        $page->page_password = $request['page_password'] != '' ? Crypt::encrypt($request['page_password']):null;
        $page->publish_at = isset($request['publish_at']) &&  $request['publish_at'] != '' ? $request['publish_at'] : currentDateTime();

        $page->meta_title = $request['meta_title'];
        $page->meta_description = $request['meta_description'];
        $page->meta_image = $request['meta_image'];

        $page->parent = isset($request['page_parent']) ? $request['page_parent']:null;
        $page->page_template = $request['page_template'];
        $page->order = is_numeric($request['order']) && isset($request['order']) ? (int)$request['order']:0;

        if (isset($id)) {
            if (isset($action)) {
                if (!($action == 'preview' && $page->publish_status == config('settings.page_status.publish'))) {
                    $page->publish_status = config('settings.page_status.draft');
                }
            } else {
                $page->publish_status = config('settings.page_status.publish');
            }
            $page->update();
        } else {
            if (isset($action)) {
                $page->publish_status = config('settings.page_status.draft');
            } else {
                $page->publish_status = config('settings.page_status.publish');
            }
            $page->user_id = Auth::user()->id;
            $page->save();
        }
        return $page;
    }

    /**
     ** delete a page by permalink
     * @param Tlpage $permalink
     * @return mixed|array
     */
    public function deletePage($permalink)
    {
        $page = $this->findPage($permalink);
        if($page->parent != null){
            return [
                'status' => 'error',
                'message' => translate('A Parent Page Cannot be Deleted Before Child Page.'),
            ];
        }

        $page->delete();
        return [
            'status' => 'success',
            'message' => translate('Page Deleted Successfully'),
        ];
    }

    /**
     ** bulk delete page by ids
     * @param array $data of Tlpage id
     * @return void
     */
    public function bulkDeletePage($data)
    {
        TlPage::whereIn('id', $data)->delete();
    }

    /**
     ** change page status to tras
     * @param Tlpage $permalink
     * @return mixed|array
     */
    public function pageChangeToTrash($request)
    {
        $page = $this->findPage($request['permalink']);
        switch ($request['status']) {
            case 'trash':
                $page->publish_status = config('settings.page_status.trash');
                $page->update();
                return [
                    'status' => 'success',
                    'message' => translate('Page Trashed Successfully'),
                ];
                break;
            case 'restore':
                $page->publish_status = config('settings.page_status.draft');
                $page->update();
                return [
                    'status' => 'success',
                    'message' => translate('Page Restored Successfully'),
                ];
                break;
            default:
                return [
                    'status' => 'error',
                    'message' => translate('Page Status Changing Failed'),
                ];
                break;
        }
    }

    /**
     ** get a all the page Templates
     * @return mixed|array
     */
    public function getPageTemplates($condition = null)
    {
        return  TlPageTemplates::where($condition);
    }

    
}