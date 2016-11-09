<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
  public function __construct(){
      $this->middleware('auth');
  }

  public function sendstatus(Request $request){
    if($request->ajax()){
      if(empty($request->input('msg')) || ctype_space($request->input('msg'))){
        return $this->respondent(0,"Please enter some text.");
      }
      else if(strlen($request->input('msg')) > 328){
        return $this->respondent(0,"Please enter only 328 text.");
      }
      else{
        DB::table('users_status')->insert([
            'social_id' => Auth::user()->social_id,
            'msg' => $request->input('msg'),
            'time' => time()
        ]);
        $lastid = DB::table('users_status')->where("social_id","=",Auth::user()->social_id)->orderBy("post_id","DESC")->first();
        return $this->respondent(1,array('time' => date('h:i a',time()),'lastid' => $lastid->post_id));
      }
    }
    else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  public function likethis(Request $request){
    if($request->ajax()){
      $chk = DB::table('users_status')->where("post_id","=",$request->input('postid'))->count();
      if($chk > 0){
        $chkagain = DB::table('users_status_like')->where("post_id","=",$request->input('postid'))->where("liked_by","=",Auth::user()->social_id)->count();
        if($chkagain > 0){
          return $this->respondent(0,"You already liked this post.");
        }else{
          DB::table('users_status_like')->insert([
            'liked_by' => Auth::user()->social_id,
            'post_id' => $request->input('postid'),
            'time' => time()
          ]);
          $getlikes = DB::table('users_status_like')->where("post_id","=",$request->input('postid'))->count();
          return $this->respondent(1,array('msg' => 'liked', 'likedcount' => $getlikes ));
        }
      }else{
        return $this->respondent(0,"Post you liked doesn`t exist.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  public function unlikethis(Request $request){
    if($request->ajax()){
      $chk = DB::table('users_status')->where("post_id","=",$request->input('postid'))->count();
      if($chk > 0){
        $chkagain = DB::table('users_status_like')->where("post_id","=",$request->input('postid'))->where("liked_by","=",Auth::user()->social_id)->count();
        if($chkagain > 0){
          DB::table('users_status_like')->where("liked_by","=",Auth::user()->social_id)->where("post_id","=",$request->input('postid'))->delete();
          $getlikes = DB::table('users_status_like')->where("post_id","=",$request->input('postid'))->count();
          return $this->respondent(1,array('msg' => 'unliked', 'likedcount' => $getlikes ));
        }else{
          return $this->respondent(0,"You didnt liked it yet.");
        }
      }else{
        return $this->respondent(0,"Post that you`re trying to unlike doesn`t exist.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  public function delStatus(Request $request){
    if($request->ajax()){
      $chk = DB::table('users_status')->where("social_id","=",Auth::user()->social_id)->where("post_id","=",$request->input('postid'))->count();
      if($chk > 0){
        DB::table('users_status')->where("social_id","=",Auth::user()->social_id)->where("post_id","=",$request->input('postid'))->delete();
        DB::table('users_status_like')->where("post_id","=",$request->input('postid'))->delete();
        return $this->respondent(1,"Post deleted");
      }else{
        return $this->respondent(0,"Post that you are trying deleted doesn`t exist.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  public function userBio(Request $request){
    if($request->ajax()){
      $chk = DB::table('users_info')->where("social_id","=",Auth::user()->social_id);
      if($chk->count() > 0){
          DB::table('users_info')->where("social_id","=",Auth::user()->social_id)->update([
            'about_you' => $request->input('about_you'),
            'time' => time()
          ]);
          return $this->respondent(1,"Bio Updated.");
      }else{
        DB::table('users_info')->insert([
          'about_you' => $request->input('about_you'),
          'social_id' => Auth::user()->social_id,
          'social_type' => Auth::user()->social_type,
          'time' => time()
        ]);
        return $this->respondent(1,"Bio Updated.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  public function ranking($x){
    return $x;
  }

  private function respondent($status,$text){
    return response()->json(array(
      'status' => $status,
      'text' => $text
    ));
  }
}
