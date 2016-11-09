<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Session;
class adminController extends Controller
{
  public function __construct(){
      $this->middleware('auth');
  }

	protected function admin(){
		if(Auth::user()->isAdmin ==1 || Auth::user()->isAdmin == 2 || Auth::user()->isAdmin == 3){
			$descbasic = array(
				'',
				'*wink*',
				'*love*',
				'*kissed*',
				'*kissing*',
				'*tokiss*',
				'*shykiss*',
				'*bleh*',
				'*crossedbleh*',
				'*sabogbleh*',
				'*shocked*',
				'*pilitsmile*',
				'*sadding*',
				'*relaxed*',
				'*really*',
				'*saddest*',
				'*confused*',
				'*tocry*',
				'*crylaugh*',
				'*crying*',
				'*antok*',
				'*problemado*',
				'*takot*',
				'*kabadongtawa*',
				'*stress*',
				'*bayan*',
				'*anobayan*',
				'*takotnatakot*',
				'*gulatnagulat*',
				'*galit*',
				'*sobranggalit*',
				'*inis*',
				'*aburido*',
				'*natawa*',
				'*nandila*',
				'*ayaw*',
				'*cool*',
				'*inantok*',
				'*xxgulat*',
				'*xxgulatnagulat*',
				'*dialamsasabihin*',
				'*tameme*',
				'*natameme*',
				'*evillaugh*',
				'*evilface*',
				'*kagulat*',
				'*ngtingpeke*',
				'*zipped*',
				'*feelingewan*',
				'*halanagulat*',
				'*faceless*',
				'*ngitinganghel*',
				'*talaga*',
				'*ayewan*',
				'*like*',
				'*dislike*',
				'*okay*',
				'*suntok*',
				'*laban*',
				'*peace*',
				'*kaway*',
				'*puso*',
				'*wasaknapuso*',
				'*kissmark*',
			);


			$descmonkz = array(
				'',
				'*yahooo*',
				'*kinikilig*',
				'*jumpup*',
				'*yowyow*',
				'*wazzup*',
				'*kabadongmatsing*',
				'*iyakingmatsing*',
				'*okay!*',
				'*curious*',
				'*sobrangiyak*',
				'*maybalak*',
				'*pacute*',
				'*nagiisip*',
				'*sayawewan*',
				'*galitnamatsing*',
				'*himatsing*',
				'*pabebematsing*',
				'*please*',
				'*patakasnamatsing*',
				'*ikawha*',
				'*sukona*',
				'*yogaaa*',
				'*stretching*',
				'*flyingkiss*',
				'*boredmatsing*',
				'*nononono*',
				'*nagsusubaybay*',
				'*nononono2*',
				'*tuwangtuwa*',
				'*tsismis*',
				'*monghe*',
				'*bulaga*',
				'*yoyohe*',
				'*lagariin*',
				'*boomsabog*',
			);

			$data = array(
				'basicsdir' => '/emojis/basic',
				'basics' => $descbasic,
				'monzdir' => '/emojis/crazymonkz',
				'descmonkz' => $descmonkz,
				'rabzdir' => '/emojis/crazyrabz',
				'me' => 'home',
				'title' => 'Home'
			);
			return view('admin/welcome',$data);
		}
		else{
			Session::flash('error','Sorry you dont have permission to access that page.');
			Session::flash('alert-class','alert-danger');
			return redirect('/');
		}
	}
  //Dashboard DJs
  protected function dj(){
		if(Auth::user()->isAdmin == 1 || Auth::user()->isAdmin == 2 || Auth::user()->isAdmin == 3){
		      $data = array(
		        'me' => 'djs',
				'title' => 'DJ'
		      );
			return view('admin/djs',$data);
		}
		else{
			Session::flash('error','Sorry you dont have permission to access that page.');
			Session::flash('alert-class','alert-danger');
			return redirect('/');
		}
  }

  protected function addDj(Request $request){
    if($request->ajax()){
      if(empty($request->input('djName')) || empty($request->input('djTag'))){
        return $this->respondent(0,"All textbox are required.");
      }
      $chk = DB::table('dashboard_djs')->where("dj_social_id","=",$request->input('djSocialID'))->where("added_by","=",Auth::user()->social_id)->count();
      $chk2 = DB::table('dashboard_djs')->where("dj_name","=",$request->input('djName'))->count();
      if($chk > 0 || $chk2 > 0){
        return $this->respondent(0,"This DJ is already exist.");
      }else {
        DB::table('dashboard_djs')->insert([
          'dj_name' => strip_tags($request->input('djName')),
          'dj_social_id' => $request->input('djSocialID'),
          'dj_tagline' => strip_tags($request->input('djTag')),
          'added_by' => Auth::user()->social_id,
          'time' => time()
        ]);
        $djname = DB::table('users')->where('social_id','=',$request->input('djSocialID'))->first();
        $djid = DB::table('dashboard_djs')->where('dj_social_id','=',$request->input('djSocialID'))->first();
        return $this->respondent(1,array(
          'djid' => $djid->id,
          'djName' => $request->input('djName'),
          'djName2' => $djname->name,
          'djSocialID' => $request->input('djSocialID'),
          'djTag' => $request->input('djTag'),
          'added_by' => Auth::user()->name,
          'time' => date('F d, Y h:i a',time()),
          'text' => 'DJ Added.'
        ));
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  protected function editDj(Request $request){
    if($request->ajax()){
      if(empty($request->input('djName')) || empty($request->input('djTag'))){
        return $this->respondent(0,"All textbox are required.");
      }
      $chk = DB::table('dashboard_djs')->where("dj_social_id","=",$request->input('djSocialID'))->count();
      if($chk > 0){
        DB::table('dashboard_djs')->where('dj_social_id','=',$request->input('djSocialID'))->update([
          'dj_name' => $request->input('djName'),
          'dj_tagline' => $request->input('djTag'),
          'time' => time()
        ]);
        return $this->respondent(1,'DJ Updated.');
      }else{
        return $this->respondent(0,"The DJ that you`re trying to edit doesn`t exist.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  protected function deleteDj(Request $request){
    if($request->ajax()){
      $chk = DB::table('dashboard_djs')->where('dj_social_id','=',$request->input('djSocialID'))->where('id','=',$request->input('dj_id'))->count();
      if($chk > 0){
        DB::table('dashboard_djs')->where('id','=',$request->input('dj_id'))->where('dj_social_id','=',$request->input('djSocialID'))->delete();
        return $this->respondent(1,"DJ Deleted.");
      }else{
        return $this->respondent(0,"The DJ that you`re trying to delete doesn`t exist.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  protected function djob(Request $request){
    if($request->ajax()){
      if($request->input('djSocialID') == 0){
        $chk = 1;
      }else{
        $chk = DB::table('dashboard_djs')->where('dj_social_id','=',$request->input('djSocialID'))->count();
      }
      if($chk > 0){
        if($request->input('djSocialID') == 0){
          DB::table('dashboard_onboard')->where('id','=',1)->update([
            'dj_name' => 'Auto Tune',
            'dj_status' => 0,
            'dj_social_id' => '0123456789'
          ]);
          return $this->respondent(1,array(
              'status' => 0,
              'text' => 'DJ On Board Updated',
              'dj_name' => 'Auto Tune'
          ));
        }else{
          $getdj = DB::table('dashboard_djs')->where('dj_social_id','=',$request->input('djSocialID'))->first();
          DB::table('dashboard_onboard')->where('id','=',1)->update([
            'dj_name' => $getdj->dj_name,
            'dj_status' => 1,
            'dj_social_id' => $getdj->dj_social_id
          ]);
          return $this->respondent(1,array(
              'status' => 1,
              'text' => 'DJ On Board Updated',
              'dj_name' => $getdj->dj_name
          ));
        }
      }else{
      return $this->respondent(0,"This DJ doesn`t even exist,Try Another.");
      }
    }else{
      return $this->respondent(0,"Ajax request must be done.");
    }
  }

  //Dashboard Users
  protected function users(){
    if(Auth::user()->isAdmin == 3){
      $data = array(
        'me' => 'users',
		'title' => 'Users'
      );
      return view('admin/users',$data);
    }
    else{
      Session::flash('error','Sorry you dont have permission to access that page.');
      Session::flash('alert-class','alert-danger');
      return redirect('/');
    }
  }
	
 public function userEdit(Request $request){
	if($request->ajax()){
		$chkuser = DB::table('users')->where('social_id','=',$request->input('social_id'));
		if($chkuser->count() > 0){
			DB::table('users')->where('social_id','=',$request->input('social_id'))->update([
				'name' => $request->input('name'),
				'acctype' => $request->input('acctype'),
				'points' => $request->input('points'),
				'color' => $request->input('usercolor'),
				'neon' => $request->input('neon')
			]);
			$djaccess = array(7,8,9);
			$adminaccess = array(111,1,2,3);
			if(in_array($request->input('acctype'),$djaccess)){
				DB::table('users')->where('social_id','=',$request->input('social_id'))->update([
					'isAdmin' => 2
				]);
			}else if(in_array($request->input('acctype'),$adminaccess)){
				DB::table('users')->where('social_id','=',$request->input('social_id'))->update([
					'isAdmin' => 3
				]);
			}else{
				DB::table('users')->where('social_id','=',$request->input('social_id'))->update([
					'isAdmin' => 0
				]);
			}
      		return $this->respondent(1,"User Updated.");
		}else{
      		return $this->respondent(0,"User not found.");
		}
	}else{
      return $this->respondent(0,"Ajax request must be done.");
	}
 }

  //Dashboard Banners
  protected function banner(){
    if(Auth::user()->isAdmin == 3){
      $data = array(
        'me' => 'settings',
		'title' => 'Banners'
      );
      return view('admin/banner',$data);
    }
    else{
      Session::flash('error','Sorry you dont have permission to access that page.');
      Session::flash('alert-class','alert-danger');
      return redirect('/');
    }
  }

  protected function uploadBanner(Request $request){
	if($request->ajax()){
		if($request->hasFile('bannerfile')){
			$file = $request->file('bannerfile');
			if($file->getClientOriginalExtension() == "jpg"){
				$bannerloc = base_path()."/public/banners/";
				$tempname = time().".".$file->getClientOriginalExtension();
				$file->move($bannerloc,$tempname);
				//exec('rm -rf '.$bannerloc.'1467438988.jpg');
				DB::table('banners')->insert([
					'banner_name' => $bannerloc.$tempname,
					'uploaded_by' => Auth::user()->social_id,
					'time' => time()
				]);
      			return $this->respondent(1,"File Uploaded.");
			}else{
      			return $this->respondent(0,"Invalid File");
			}
		}
		else{
      		return $this->respondent(0,"No file detected");
		}
	}else{
      return $this->respondent(0,"Ajax request must be done.");
	}
  }

  private function respondent($status,$text){
    return response()->json(array(
      'status' => $status,
      'text' => $text
    ));
  }
}
