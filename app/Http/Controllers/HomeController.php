<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
        if($id != null){
          $chk = DB::table('users')->where('social_id','=',$id)->count();
          if($chk > 0){
            $data = array('exist' => true, 'userid' => $id);
            return view('home',$data);
          }else{
            $data = array('dontexist' => true);
            return view('home',$data);
          }
        }else{
          return view('home');
        }
    }
}
