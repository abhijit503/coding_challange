<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        try {
            $page_qty = 10;
            $domain = "localhost:8000/api/v1";
            $offset = 0;
            if (isset($request->page)) {
                $page_for_offset = isset($request->q) ? $request->page - 1 : $request->page;
                $offset = ($page_qty * $page_for_offset) - $page_qty;
            }

            //query//
            $users = new Users();
            $users_page_data = [];
            if (isset($request->q)) {
                $users_page_data = $users->offset($offset)->limit($page_qty)->where('first_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->q . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->q . '%')->get();
            } else {
                $users_page_data = $users->offset($offset)->limit($page_qty)->get();
            }

            $total_page = count($users->get()) / $page_qty;
            //end//
            $cur_set=!isset($request->page)||$request->page==1 ?'&page=1':'&page='.$request->page;
            $current = $domain . '?q='.$cur_set;
            $next = $domain . '?q=&page='.$request->page+1;

            return response()->json(["items" => $request->page > 0 || !isset($request->page) ? $users_page_data : [], "metadata" => ["current_url" => $current, "next_url" => $next, "total_page" => $total_page]]);
        } catch (\Exception $ex) {
            return response()->json(["status" => false, "error" => ['error'], "message" => $ex->getMessage(), "data" => []]);
        }
    }


}
