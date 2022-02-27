<?php

namespace App\Http\Controllers\Api\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Group as mGroup;

class Group extends Controller
{
    public function index(Request $req)
    {
        $get = mGroup::all();

        if (empty($req->_page)) {
            return response()->json([
                'data'      => $get,
                'status'    => true
            ], 200);
        }

        $search     = $req->_search;
        $limit      = $req->_pageSize;
        $offset     = ($req->_page - 1) * $limit;
        $sort       = explode(':', $req->_sortby);
        $column     = $sort[0];
        $get        = $sort[1] == 1 ? $get->sortBy($column) : $get->sortByDesc($column);
        $total      = $get->count();
        $numPage    = $total / $limit;

        if (!empty($search)) {
            $get = $get->filter(function ($col, $val) use ($search) {
                return (stristr($col->group_code, $search) ||
                    stristr($col->group_name, $search));
            });
        }

        return response()->json([
            'documentSize'  => $get->count(),
            'numberOfPages' => $numPage <= 1 ? 1 : floor($numPage) + 1,
            'page'          => $req->_page,
            'pageSize'      => $limit,
            'data'          => $get->slice($offset, $limit)->values()->all(),
            'status'        => true,
        ], 200);
    }

    public function unique(Request $req)
    {
        if ($req->group_id == 'undefined') {
            $duplicate = mGroup::orWhere([
                'group_code'      => $req->group_code,
                'group_name'      => $req->group_name,
            ])
                ->get();
        } else {
            $duplicate = mGroup::orWhere([
                'group_code'      => $req->group_code,
                'group_name'      => $req->group_name,
            ])
                ->where('group_id', '<>', $req->group_id)->get();
        }

        $response = [];

        if ($duplicate->count() > 0) {
            $duplicate = $duplicate->first();

            if ($duplicate->group_code == $req->group_code) {
                $message = 'Group Code has already exists.';
            } elseif ($duplicate->group_name == $req->group_name) {
                $message = 'Group Name has already exists.';
            }

            $response = [
                'data'      => $duplicate,
                'status'    => false,
                'message'   => $message,
            ];
        } else {
            $response = [
                'data'      => true,
                'status'    => true
            ];
        }

        return response()->json($response, 200);
    }

    public function store(Request $req)
    {
        $data = mGroup::create([
            'group_code'        => trim($req->group_code),
            'group_name'        => trim($req->group_name),
        ]);

        return response()->json([
            'data'      => $data,
            'status'    => true,
            'message'   => 'New record has been saved.'
        ], 200);
    }

    public function save(Request $req)
    {
        $row = mGroup::find($req->group_id);

        $row->group_code        = trim($req->group_code);
        $row->group_name        = trim($req->group_name);

        $row->save();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }

    public function destroy(Request $req)
    {
        $row = mGroup::find($req->group_id);

        $row->save();
        $row->delete();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully deleted.'
        ], 200);
    }
}
