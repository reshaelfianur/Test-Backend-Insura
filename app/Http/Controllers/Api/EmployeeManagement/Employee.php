<?php

namespace App\Http\Controllers\Api\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee as mEmployee;

class Employee extends Controller
{
    public function index(Request $req)
    {
        $get = mEmployee::fetch();

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
                return (stristr($col->employee_code, $search) ||
                    stristr($col->employee_full_name, $search) ||
                    stristr($col->group_name, $search) ||
                    stristr($col->employee_birth_date, $search));
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
        if ($req->employee_id == 'undefined') {
            $duplicate = mEmployee::where('employee_code', $req->employee_code)
                ->get();
        } else {
            $duplicate = mEmployee::where('employee_code', $req->employee_code)
                ->where('employee_id', '<>', $req->employee_id)
                ->get();
        }

        $response = [];

        if ($duplicate->count() > 0) {
            $response = [
                'data'      => $duplicate,
                'status'    => false,
                'message'   => 'Employee Code has already exists.',
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
        $data = mEmployee::create([
            'group_id'                  => trim($req->group_id),
            'employee_code'             => trim($req->employee_code),
            'employee_first_name'       => trim($req->employee_first_name),
            'employee_last_name'        => trim($req->employee_last_name),
            'employee_birth_date'       => $req->employee_birth_date,
            'employee_email_private'    => trim($req->employee_email_private),
            'employee_basic_salary'     => trim($req->employee_basic_salary),
            'employee_description'      => trim($req->employee_description),
            'created_by'                => $req->created_by,
        ]);

        return response()->json([
            'data'      => $data,
            'status'    => true,
            'message'   => 'New record has been saved.'
        ], 200);
    }

    public function save(Request $req)
    {
        $row = mEmployee::find($req->employee_id);

        $row->group_id                  = trim($req->group_id);
        $row->employee_code             = trim($req->employee_code);
        $row->employee_first_name       = trim($req->employee_first_name);
        $row->employee_last_name        = trim($req->employee_last_name);
        $row->employee_birth_date       = $req->employee_birth_date;
        $row->employee_email_private    = trim($req->employee_email_private);
        $row->employee_basic_salary     = trim($req->employee_basic_salary);
        $row->employee_description      = trim($req->employee_description);
        $row->updated_by                = $req->updated_by;

        $row->save();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully modified.'
        ], 200);
    }

    public function destroy(Request $req)
    {
        $row = mEmployee::find($req->employee_id);

        $row->deleted_by    = $req->deleted_by;

        $row->save();
        $row->delete();

        return response()->json([
            'data'      => $row,
            'status'    => true,
            'message'   => 'Record has been successfully deleted.'
        ], 200);
    }
}
