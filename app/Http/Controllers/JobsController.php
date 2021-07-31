<?php

namespace App\Http\Controllers;

use App\Job;
use App\Wilayah;

use Request;

class JobsController extends Controller
{
    public function index() {
        return view('jobs.jobs-list')->with([
            'pageTitle' => 'Manage Jobs', 
            'title' => 'List Jobs', 
            'sidebar' => 'jobs'
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
        
        $job = new Job;
        
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

    public function add() {
        $kota = Wilayah::select('kabupaten')->groupBy('kabupaten')->get()->toArray();
        dd($kota);
        return view('jobs.jobs-add')->with([
            'pageTitle' => 'Manage Jobs', 
            'title' => 'Add Jobs', 
            'sidebar' => 'jobs'
        ]);
    }

    public function store() {
        $encrypt = new EncryptController;
        $data = $encrypt->fnDecrypt(Request::input('data'),true);
        // dd($data);
        $path = [];
        if (Request::has('image')) {
            $image = Request::file('image');
            
            for ($i=0; $i < count($image); $i++) {
                $ext = $image[$i]->getClientOriginalExtension();
                $path_path = $image[$i]->storeAs('uploads', 'image_gallery_'.time().$i.'.'.$ext, 'public');

                array_push($path, $path_path);
            }
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Input images require',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }

        $insert = new Gallery;
        $insert->title = $data['title'];
        $insert->desc = $data['desc'];
        if (isset($data['publish']) && $data['publish'] == 1) {
            $insert->publish = $data['publish'];
        }
        $insert->images = json_encode($path);
        $insert->save();

        if ($insert->save()) {
            $messages = [
                'status' => 'success',
                'message' => 'Success save gallery!',
                'url' => 'close'
            ];

            return redirect('/gallery')->with('notif', $messages);
        } else {
            $messages = [
                'status' => 'error',
                'message' => 'Error save gallery',
                'url' => 'close'
            ];

            return back()->with('notif', $messages);
        }
    }
}
