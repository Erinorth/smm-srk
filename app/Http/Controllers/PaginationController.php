<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PaginationController extends Controller
{
    function index()
    {
        $data = DB::table('consumables')->orderBy('id', 'asc')->paginate(10);
        return view('pagination', compact('data'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');

            $data = DB::table('consumables')
            ->orderBy($sort_by, $sort_type)
            ->paginate(5);
            return view('pagination_data', compact('data'))->render();
        }
    }
}
