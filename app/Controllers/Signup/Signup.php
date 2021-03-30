<?php
namespace App\Controllers\Signup;
use App\Controllers\BaseController;
use App\Models\LiveSearch;


class Signup extends BaseController
{
    public function index(){
        $liveSearh = new LiveSearch();
        
        $data['dosbing'] = $liveSearh->get_dosbing();
        $data['for_auth'] = $this->data_for_auth();       
        return view('signup/signup', $data);
    }
}