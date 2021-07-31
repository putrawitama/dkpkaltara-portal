<?php

namespace App\Http\Controllers;

use App\Job;
use App\Applicant;

use Request;

class ApplicantController extends Controller
{
    public function index() {
        return view('applicant.applicant-list')->with([
            'pageTitle' => 'Manage Applicant', 
            'title' => 'List Applicant', 
            'sidebar' => 'applicant'
        ]);
    }

    public function list() {
        $dataSend = array(
            "search" => Request::input('search')['value'],
            "offset" => Request::input('start'),
            "limit" => Request::input('length'),
            'order' => (!empty(Request::get('columns')[Request::get('order')[0]['column']]['data'])) ? Request::get('columns')[Request::get('order')[0]['column']]['data'] : '',
            'sort' => (!empty(Request::get('order')[0]['dir'])) ? Request::get('order')[0]['dir'] : '',
        );
        
        $job = new Applicant;
        
        if ($dataSend['search']){
            $job = $job->where('name','like','%'.$dataSend['search'].'%');
        }
        $count = $job->count();

        $list = $job->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

        if ($dataSend["order"]) {
            $list = $list->orderBy($dataSend["order"], $dataSend["sort"])->get()->toArray();
        } else {
            $list = $list->orderBy('created_at', $dataSend["sort"])->get()->toArray();
        }

        for ($i=0; $i < count($list); $i++) { 
            $list[$i]['link_id'] = Crypt::encryptString($list[$i]['id']);
        }
        // dd($list);
        if ($list != null) {
            $response = array(
                "draw"              => Request::get('draw'),
                "recordsTotal"      => $count,
                "recordsFiltered"   => $count,
                "data"              => $list
            );
        }else{
            $response = array(
                "draw"              => Request::get('draw'),
                "recordsTotal"      => 0,
                "recordsFiltered"   => 0,
                "data"              => []
            );
        }
        // dd($response);
        return $response;
    }
}
