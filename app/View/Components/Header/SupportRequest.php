<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;
use DB;

class SupportRequest extends Component
{
    public $requestId;

    public function __construct($requestId)
    {
        $this->requestId = $requestId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $request = DB::select('SELECT departments.DepartmentName, support_requests.Amount, support_requests.AtSite, support_requests.Type, support_requests.Remark
            FROM support_requests
            INNER JOIN departments
            ON support_requests.department_id = departments.id
            WHERE support_requests.id = '.$this->requestId.'');

        return view('components.header.support-request',compact('request'));
    }
}
