<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function get_access(string $pageName, string $userGroup)
    {
        return \App\Models\User::leftJoin('group_pages', 'users.group_id', '=', 'group_pages.group_id')
            ->leftJoin('groups', 'users.group_id', '=', 'groups.group_id')
            ->leftJoin('pages', 'group_pages.page_id', '=', 'pages.page_id')
            ->where('pages.page_name', '=', $pageName)
            ->where('group_pages.group_id', '=', $userGroup)
            ->select(['group_pages.access', 'pages.page_name', 'pages.action'])
            ->get();
    }
}
