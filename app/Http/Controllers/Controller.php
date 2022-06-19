<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $title = "Dashboard";
    protected $code = "SK";

    protected function buildTitle($section = 'section') {
        return "{$this->title} <span class=\"font-weight-light h5\">$section</span>";
    }

    protected function buildTransactionCode($id) {
        return sprintf($this->code . "-%05d", $id);
    }
}
