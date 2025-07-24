<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DDDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coach = DB::select('SELECT employees.id, employees.ThaiName AS CoachName
            FROM employees
            ORDER BY employees.ThaiName;');

        return view('ddd.index',compact('coach'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function fetch(Request $request)
    {
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::select('SELECT courses.id, courses.Type, courses.CourseName, o_j_t_plans.employee_id, o_j_t_evaluations.Result
            FROM (courses INNER JOIN o_j_t_plans ON courses.id = o_j_t_plans.course_id) INNER JOIN o_j_t_evaluations ON o_j_t_plans.id = o_j_t_evaluations.id
            WHERE (((o_j_t_plans.employee_id)='.$value.') AND ((o_j_t_evaluations.Result)='."ผ่าน".'))
            ORDER BY courses.Type, courses.CourseName');
        $output = '<option value="">Select '.ucfirst($dependent).'</option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->$dependent.'">'.$row->$dependent.'</option>';
        }
        echo $output;
    }
}
