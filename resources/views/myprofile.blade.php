<div class="container p-main">
  <!-- Nav -->
  <nav class="navbar navbar-default navbar-fz">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left">
          <ol class="breadcrumb p-loc">
            <li><a href="#">Home</a></li>
            <li>Profile</li>
            <li class="active">{{ Auth::user()->name }}</li>
          </ol>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/"><span class="fa fa-home"></span> Home</a></li>
          <li><a href="/tinychat" target="_blank"><span class="fa fa-video-camera"></span> TinyChat</a></li>
          <li><a href="#"><span class="fa fa-info-circle"></span> About</a></li>
          @if(Auth::user()->isAdmin > 0)
          <li><a href="/admin"><span class="fa fa-navicon"></span> DashBoard</a></li>
          @endif
              <li class="active"><a href="/profile"><span class="fa fa-user"></span> My Profile</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!-- End of Nav -->
  <div class="row no-gutters">
    <div class="col-md-4 col-sm-4">
      <div class="profile-s">
        <div class="panel panel-body profile-cont">
          <img src="{{ Auth::user()->avatar }}">
          <div class="name-cont">
            <p class="p-name">{{ Auth::user()->name }}</p>
            <p class="p-rank" onclick="$(this).html(inew.totherank({{ Auth::user()->acctype }}))" onload="alert(1)">x</p>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading">About
          <div class="pull-right p-edit">
            <a style="cursor:pointer"><span class="fa fa-pencil"></span></a>
          </div>
        </div>
        <div class="panel-body">
          <p class="p-title"> Description</p>
          <?php
            $userinfo = DB::table('users_info')->where("social_id","=",Auth::user()->social_id);
          ?>
          @if($userinfo->count() > 0 )
          <p class="p-info1"><?= strip_tags($userinfo->first()->about_you,"<br>"); ?></p>
          @else
          <p class="p-info1">No bio description to show.</p>
          @endif
          @if(Auth::user()->social_type == "FACEBOOK")
          <p class="p-title"><span class="fa fa-facebook-square"></span> Facebook</p>
          <a href="https://www.facebook.com/{{ Auth::user()->social_id }}" target="_blank"><span class="fa fa-external-link"></span></a> <input class="p-info" value="https://www.facebook.com/{{ Auth::user()->social_id }}" disabled> </input>
          @else
          <p class="p-title"><span class="fa fa-twitter-square"></span> Twitter</p>
          <a href="https://twitter.com/{{ Auth::user()->email }}" target="_blank"><span class="fa fa-external-link"></span></a> <input class="p-info" value="https://twitter.com/{{ Auth::user()->email }}" disabled> </input>
          @endif
          <p class="p-title"><span class="fa fa-star-o"></span> Points</p>
          <span class="fa fa-star"></span> <input class="p-info" value="{{ Auth::user()->points }}" disabled> </input>

        </div>
      </div>
    </div>
    <div class="col-md-8 col-sm-8">
      <div class="panel">
        <div class="panel-heading">Update Status</div>
        <div class=" panel-body status-bar">
          <form class="user-updstatus">
            <input type="hidden" name="acctype" value="{{ Auth::user()->acctype }}">
            <input type="hidden" name="avatar" value="{{ Auth::user()->avatar }}">
            <input type="hidden" name="social_type" value="{{ Auth::user()->social_type }}">
            <input type="hidden" name="name" value="{{ Auth::user()->name }}">
            <textarea placeholder="Whats on your mind ?" required cols="20" rows="2" maxlength="328" name="status-msg"></textarea>
        </div>
        <div class="panel-footer stat-footer">
          <div class="pull-right">
            <button type="submit" class="btn btn-md btn-stat" >Update</button>
          </form>
          </div>
        </div>
      </div>
      <div class="hori-line"></div>
      <!-- Statuses -->
      <div class="clearfix"></div>
      <div class="statuses" style="padding:0px;margin:0px">
        <?php
          $getem = DB::table('users_status')->where("social_id","=",Auth::user()->social_id)->orderBy("post_id","DESC");
        ?>
        @if($getem->count() < 0)
        No Post Available
        @else
        @foreach($getem->get() as $b)
        <!-- AUTO GENERATE "main-status" ID PARAM -->
        <?php
          $getlikes = DB::table('users_status_like')->where("post_id","=",$b->post_id)->count();
          $ifyouliked = DB::table('users_status_like')->where("post_id","=",$b->post_id)->where("liked_by","=",Auth::user()->social_id)->count();
        ?>
        <div class="main-status" id="{{ $b->post_id }}">
          <div class="user-stat">
            <div class="media">
              <div class="media-left">
                <img class="media-object stat-img" src="{{ Auth::user()->avatar }}" alt="...">
              </div>
              <div class="media-body">
                <p class="media-heading stat-name"> {{ Auth::user()->name }} </p>
                <p class="stat-rank" id={{ Auth::user()->acctype }}></p> @if(Auth::user()->social_type == "FACEBOOK")<span class="fa fa-facebook-square"></span> @else <span class="fa fa-twitter-square"></span> @endif

              </div>
              <div class="media-right">
                <p class="time"><span class="fa fa-clock-o"></span> {{ date('h:i a',$b->time) }}</p>
                <p>
                  <a class="stat-butts">
                    <span class="badge statuslikes-{{ $b->post_id }}">{{ $getlikes }}</span>
                  </a>
                  <a  class="stat-butts">
                    <!-- ! IMPORTANT ! IF LIKED ADDCLASS "h-color" ELSE REMOVECLASS "h-color" -->
                    <span class="fa fa-heart likebutt-{{ $b->post_id }} @if($ifyouliked > 0) h-color @endif" data-toggle="tooltip" data-placement="left" title="LIKE" id="{{ $b->post_id }}" onclick="inew.likethis(this.id)"></span>
                  </a>
                  <a class="stat-butts">
                    <span class="fa fa-times-circle" data-toggle="tooltip" data-placement="left" title="DELETE" id="{{ $b->post_id }}" onclick="inew.delStatus(this.id)"></span>
                  </a>
                </p>

              </div>
            </div>
          </div>
          <div class="stat-content"><?=strip_tags($b->msg,"<br>"); ?></div>
        </div>
        @endforeach
        @endif
      </div>


    </div>
  </div>
</div>
