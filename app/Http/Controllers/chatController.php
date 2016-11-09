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

class chatController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    
    public function sendmsg(Request $request)
    {
	    if($request->ajax()){
			$bancheck = DB::table('banned')->where('social_id','=',Auth::user()->social_id);
			if($bancheck->count() > 0){
				return $this->respondent(0,"Sorry! But you are currently ban for chatting!.");
			}
	    	$antispam = $this->antispam();
	    	$spamchk = DB::table('antispam')->where('social_id','=',Auth::user()->social_id);
	    	if(empty($request->input('msg')) || ctype_space($request->input('msg'))){
	    		return $this->respondent(0,"Please enter something in chat text box.");
	    	}
	    	if($spamchk->count() > 0 && $spamchk->first()->violation_count == 20){
		    	DB::table('chatbox')->insert([
		    		'msg' => 'THIRD AND LAST VIOLATION WARNING FOR <b>'.$this->getuserinfo(Auth::user()->social_id)->name.'</b>. User('.$this->getuserinfo(Auth::user()->social_id)->name.') is now banned for 15 days',
		    		'social_id' => '0123456789',
		    		'msg_type' => 'warning',
		    		'time' => time()
		    	]);
				DB::table('banned')->insert([
					'banned_by' => Auth::user()->social_id,
					'social_id' => $request->input('social_id'),
					'time' => time(),
					'time_banned' => (time() + (15 * 60 * 60 * 24))
				]);
		    	DB::table('antispam')->where('social_id','=',Auth::user()->social_id)->delete();
	    		return $this->respondent(0,"Third & Last Violation Encountered.");
	    	}
	    	else if($spamchk->count() > 0 && $spamchk->first()->violation_count == 10){
		    	DB::table('chatbox')->insert([
		    		'msg' => 'SECOND VIOLATION WARNING FOR <b>'.$this->getuserinfo(Auth::user()->social_id)->name.'</b>. User('.$this->getuserinfo(Auth::user()->social_id)->name.') is now banned for 3 days',
		    		'social_id' => '0123456789',
		    		'msg_type' => 'warning',
		    		'time' => time()
		    	]);
				DB::table('banned')->insert([
					'banned_by' => Auth::user()->social_id,
					'social_id' => $request->input('social_id'),
					'time' => time(),
					'time_banned' => (time() + (3 * 60 * 60 * 24))
				]);
		    	DB::table('antispam')->where('social_id','=',Auth::user()->social_id)->increment('violation_count', 1);
	    		return $this->respondent(0,"Second Violation Encountered.");
	    	}
	    	else if($spamchk->count() > 0 && $spamchk->first()->violation_count == 5){
		    	DB::table('chatbox')->insert([
		    		'msg' => 'FIRST VIOLATION WARNING FOR <b>'.$this->getuserinfo(Auth::user()->social_id)->name.'</b>. The next time you tried to spam. You will be automatically banned for 3 days.',
		    		'social_id' => '0123456789',
		    		'msg_type' => 'warning',
		    		'time' => time()
		    	]);
		    	DB::table('antispam')->where('social_id','=',Auth::user()->social_id)->increment('violation_count', 1);
	    		return $this->respondent(0,"First Violation Encountered.");
	    	}
	    	if(DB::table('chatbox')->orderBy('msg_id','desc')->where('social_id','=',Auth::user()->social_id)->count() > 0){
	    		if($antispam->first()->time >= (time() - 5)){
	    		    if($spamchk->count() > 0){
	    			    DB::table('antispam')->where('social_id','=',Auth::user()->social_id)->increment('violation_count', 1);
	    		    }
	    		    else{
	    			    DB::table('antispam')->insert([
	    			    	'social_id' => Auth::user()->social_id,
	    			    	'violation_count' => 1,
	    			    	'description' => 'Chatbox Spamming'
	    			    ]);
	    		    }
	    		    return response()->json(array('status' => 0,'text' => 'You can only send a message after 5 seconds. '));
	    		}
		    	else{
		    		DB::table('chatbox')->insert([
		    			'msg' => $request->input('msg'),
		    			'social_id' => Auth::user()->social_id,
		    			'msg_type' => 'normal',
		    			'time' => time()
		    		]);
		    		DB::table('users')->where('social_id','=',Auth::user()->social_id)->increment('points', 2);
		    		$this->updateTimeRequest();
		    		return $this->respondent(1,"Message Sent : ");
		    	}
	    	}
	    	else{
	    		DB::table('chatbox')->insert([
	    			'msg' => $request->input('msg'),
	    			'social_id' => Auth::user()->social_id,
	    			'msg_type' => 'normal',
	    			'time' => time()
	    		]);
				$typeacc = Auth::user()->acctype;
				if($typeacc == 16 || $typeacc == 13 ){
	    			DB::table('users')->where('social_id','=',Auth::user()->social_id)->increment('points', 2);
				}
				else if($typeacc == 11 || $typeacc == 15 ){
	    			DB::table('users')->where('social_id','=',Auth::user()->social_id)->increment('points', 3);
				}
				else if($typeacc == 12){
	    			DB::table('users')->where('social_id','=',Auth::user()->social_id)->increment('points', 5);
				}
				else{
	    			DB::table('users')->where('social_id','=',Auth::user()->social_id)->increment('points', 1);
				}
	    		$this->updateTimeRequest();
	    		return $this->respondent(1,"Message Sent : ");
	    	}
	    }
	    else {
	    	return response()->json(array('text' => 'oops'));
	    }
    }

    private function antispam(){
    	$dis = DB::table('chatbox')->orderBy('msg_id','desc')->where('social_id','=',Auth::user()->social_id);
    	if($dis->count() > 0){
    		return $dis;
    	}else {
    		return 0;
    	}
    }

    public function getMsg(Request $request){
	    if($request->ajax()){
	    	if($request->input('id') == 0 ){
	    		$id = $this->getlastid()-15;
	    	}
	    	else {
	    		$id = $request->input('id');
	    	}
	    	$all = DB::table('chatbox')->where('msg_id','>',$id)->orderBy('msg_id','ASC')->get();
	    	$bind = array();
	    	foreach($all as $alls){
	    		$x = $this->getuserinfo($alls->social_id);
	    		$makeRow = array(
	    			'msg_id' => $alls->msg_id,
	    			'text' => $alls->msg,
	    			'social_id' => $x->social_id,
	    			'name' => $x->name,
	    			'acctype' => $x->acctype,
	    			'points' => $x->points,
	    			'avatar' => $x->avatar,
	    			'social_type' => $x->social_type,
	    			'email' => $x->email,
	    			'time' => $alls->time,
	    			'msgType' => $alls->msg_type,
	    			'more' => 0,
					'color' => $x->color,
					'neon' => $x->neon
	    		);
	    		$bind[] = $makeRow;
	    	}
	    	$makeArr = array('msg' => $bind);
	    	return response()->json($makeArr);
	    }
	    else{
	    	return response()->json(array('text' => 'oops'));
	    }
    }

    public function getMoreMsg(Request $request){
	    if($request->ajax()){
	    	if($request->input('id') == 0 ){
	    		$id = $this->getlastid()-15;
	    	}
	    	else {
	    		$id = $request->input('id');
	    	}
	    	$all = DB::table('chatbox')->where('msg_id','<',$id)->orderBy('msg_id','DESC')->take(10)->get();
	    	$bind = array();
	    	foreach($all as $alls){
	    		$x = $this->getuserinfo($alls->social_id);
	    		$makeRow = array(
	    			'msg_id' => $alls->msg_id,
	    			'text' => $alls->msg,
	    			'social_id' => $x->social_id,
	    			'name' => $x->name,
	    			'acctype' => $x->acctype,
	    			'points' => $x->points,
	    			'avatar' => $x->avatar,
	    			'social_type' => $x->social_type,
	    			'email' => $x->email,
	    			'time' => $alls->time,
	    			'msgType' => $alls->msg_type,
	    			'more' => 1,
					'color' => $x->color,
					'neon' => $x->neon
	    		);
	    		$bind[] = $makeRow;
	    	}
	    	$makeArr = array('msg' => $bind);
	    	return response()->json($makeArr);
	    }
	    else{
	    	return response()->json(array('text' => 'oops'));
	    }
    }

    public function report(Request $request){
    	if($request->ajax()){
	    	DB::table('report')->insert([
	    		'reported_by' => Auth::user()->social_id,
	    		'reason_desc' => $request->input('reason'),
	    		'reported_id' => $request->input('reported_id'),
	    		'time' => time()
	    	]);
    		$x = array(
    			'reported_by' => Auth::user()->social_id,
    			'report_desc' => $request->input('reason'),
    			'reported_id' => $request->input('reported_id'),
    			'time' => time()
    		);
    		return $this->respondent(1,'Report submitted');
    	}else{
    		return $this->respondent(0,'Something went wrong');
    	}
    }

    public function announcement(Request $request){
    	if($request->ajax()){
	    	$antispam = $this->antispam();
	    	if(DB::table('chatbox')->orderBy('msg_id','desc')->where('social_id','=',Auth::user()->social_id)->count() > 0){
	    		if($antispam->first()->time >= (time() - 5)){
	    		    		return response()->json(array('status' => 0,'text' => 'You can only send a message after 5 seconds. '));
	    		    	}
	    		    	else{
	    		    		DB::table('chatbox')->insert([
	    			    		'msg' => $request->input('msg'),
	    			    		'social_id' => Auth::user()->social_id,
	    			    		'msg_type' => 'announcement',
	    			    		'time' => time()
	    		    		]);
	    		    		return $this->respondent(1,'Announcement Sent');
	    	    		}
	    	}else{
	    		DB::table('chatbox')->insert([
	    			'msg' => $request->input('msg'),
	    			'social_id' => Auth::user()->social_id,
	    			'msg_type' => 'announcement',
	    			'time' => time()
	    		]);
	    		return $this->respondent(1,'Announcement Sent');
	    	}
    	}else{
    		return $this->respondent(0,'Something went wrong');
    	}
    }
	
	public function ban(Request $request){
		if($request->ajax()){
			$chk = DB::table('users')->where('social_id','=',$request->input('social_id'));
			if($chk->count() > 0){
				$chk2 = DB::table('banned')->where('social_id','=',$request->input('social_id'));
				if($chk2->count() > 0){
    				return $this->respondent(0,'User is already banned!');
				}else{
					DB::table('banned')->insert([
						'banned_by' => Auth::user()->social_id,
						'social_id' => $request->input('social_id'),
						'time' => time(),
						'time_banned' => (time() + ($request->input('day') * 60 * 60 * 24))
					]);
					DB::table('chatbox')->insert([
						'msg' => '<b>'.$chk->first()->name.'</b> just got banned by <b>'.Auth::user()->name.'</b> for <b>'.$request->input('day').' day/s </b>',
						'social_id' => '0123456789',
						'msg_type' => 'global',
						'time' => time()
					]);
					return $this->respondent(1,'User got banned!');
				}
			}else{
    			return $this->respondent(0,'User Not found!');
			}
		}else{
    		return $this->respondent(0,'Something went wrong');
		}
	}

    public function onlines(Request $request){
    	if($request->ajax()){
    		return response()->json(array('onlines' => DB::table('users')->where('active','=',1)->orderBy('id','DESC')->get()));
    	}else{
    		return $this->respondent(0,'Something went wrong');
    	}
    }
    
    public function chkol(){
    	return DB::table('users')->where('last_request_time','<=',(time()- 5*60))->update([
			'active' => 0
		]);
    }

    public function djob(Request $request){
    	if($request->ajax()){
    		return response()->json(array('djob' => DB::table('dashboard_onboard')->first()));
    	}else{
    		return $this->respondent(0,'Something went wrong');
    	}
    }

    private function getuserinfo($x){
    	return DB::table('users')->where('social_id','=',$x)->first();
    }

    private function getlastid(){
    	$dbli = DB::table('chatbox')->orderBy('msg_id','DESC');
    	if($dbli->count() > 0){
    		return $dbli->first()->msg_id;
    	}else{
    		return 0;
    	}
    }

    private function updateTimeRequest(){
    	DB::table('users')->where('social_id','=',Auth::user()->social_id)->update(['last_request_time' => time(), 'active' => 1 ]);
    }

    private function respondent($status,$text){
    	return response()->json(array(
    		'status' => $status,
    		'text' => $text
    	));
    }
}
