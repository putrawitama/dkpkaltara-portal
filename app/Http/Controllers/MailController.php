<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Security\EncryptController;
use App\Http\Controllers\Security\ValidatorController;
use App\Mail;
use App\Menu;

use Request;
use Crypt;
use Http;

class MailController extends Controller
{
    public function index() {
        return view('email.mail-list')->with([
            'pageTitle' => 'Manage Inbox', 
            'title' => 'List Inbox', 
            'sidebar' => 'mail'
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
        
        $mail = new Mail;
        
        if ($dataSend['search']){
            $mail = $mail->where('title','like','%'.$dataSend['search'].'%');
        }
        $count = $mail->count();

        $list = $mail->skip(intval( $dataSend["offset"]))->take(intval($dataSend["limit"]));

        if ($dataSend["order"]) {
            $list = $list->orderBy($dataSend["order"], $dataSend["sort"])->get()->toArray();
        } else {
            $list = $list->orderBy('created_at', $dataSend["sort"])->get()->toArray();
        }

        for ($i=0; $i < count($list); $i++) { 
            $list[$i]['link_id'] = Crypt::encryptString($list[$i]['id']);
        }

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

        return $response;
    }

    public function detail($id) {
        $id = Crypt::decryptString($id);

        $detail = Mail::where('id', $id)->first()->toArray();

        return view('email.mail-detail')->with([
            'pageTitle' => 'Manage Inbox', 
            'title' => 'Detail Mail', 
            'sidebar' => 'mail',
            'detail' => $detail
        ]);
    }

    public function contactUs()
    {
        $menu = Menu::with('subMenu')->get();
        return view('landing.contact')->with([
            'menu' => $menu
        ]);
    }

    public function postContact()
    {

        $data = Request::all();

        $details = [
            'subject' => $data['subject'],
            'content' => $data['message'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];

        $mail = new Mail;
        $mail->subject  = $data['subject'];
        $mail->message  = $data['message'];
        $mail->name     = $data['name'];
        $mail->email    = $data['email'];
        $mail->phone    = $data['phone'];
        $mail->save();
       
        \Mail::to('dkp@kaltaraprov.go.id')->send(new \App\Mail\ContactMail($details));

        return redirect('/kontak')->with('notif', 'Pesan Telah Terkirim');
    }
}
