var reached = 0;
var textarea = null;
$.ajaxSetup({
  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
});
$(document).ready(function(){
	inew.sc_details();
  inew.artWork();
  if(window.location.pathname == "/"){
   $('#introModal').modal('show');
  }
  $('.carousel').carousel();
	$('form.bannerForm').submit(function(e){
		e.preventDefault();
		var formData = new FormData(this);
		$.ajax({
			type : 'POST',
			url : '/admin/banners/uploadbanner',
			data : formData,
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
				console.log("success");
				console.log(data);
				$('input[name="bannerfile"]').val('');
				alert('File Uploaded');
			},
			error: function(data){
				console.log("error");
				console.log(data);
				alert('Something went wrong')
			}
		});
		return false;
	});
  $('span.playbutton').click(function(){
    if($(this).hasClass('fa-pause')){
      $(this).removeClass('fa-pause').addClass('fa-play');
      document.getElementById('player').play()
    }else{
      $(this).removeClass('fa-play').addClass('fa-pause');
      document.getElementById('player').pause();
    }
  });
  $('a[href="#"]').click(function(){
    alert('Will be available soon.');
    return false;
  });
  $('img.img-smilys').click(function(){
    $('input[name="msg"]').val($('input[name="msg"]').val() + $(this).prop('title')).focus();
    $('div.smilys').slideUp(200);
  });
  $('button[title="Emoticons"]').click(function(){
    $('div.smilys').slideToggle(200);
  });
  $('p.stat-rank,td.users_ranks').each(function(){
    $(this).html(inew.totherank($(this).prop('id')));
  });
	if(window.location.pathname == "/" || window.location.pathname == "/admin" || window.location.pathname == "/tinychat" ){
	   inew.index();
		inew.onlines();
		inew.djob();
  }
  if(window.location.pathname == "/admin/dj" || window.location.pathname == "/admin/users"){
    $('.display').DataTable();
  }
  if(window.location.pathname == "/profile"){
    window.addEventListener("load", function() {
        textarea = window.document.querySelector("textarea");
        textarea.addEventListener("keypress", function() {
            if(textarea.scrollTop != 0){
                textarea.style.height = textarea.scrollHeight + "px";
            }
        }, false);
    }, false);
  }
  $('form.user-updstatus').submit(function(){
    var msg = $('textarea[name="status-msg"]').val().replace(/\r?\n/g, '<br>'),
        msgid = Math.floor(Math.random()*32767);
    if(msg.length == "" ){
      alert("Please enter some message.");
      return false;
    }else if(msg.length < 4){
      alert("Please enter a longer than 4 letter in message.");
      return false;
    }
    $('textarea[name="status-msg"]').prop('disabled',true);
    $('button.btn-stat').prop('disabled',true).html('loading....');
    $.ajax({
      type : 'POST',
      url : '/update/status',
      dataType : 'JSON',
      data : { msg : msg },
      success : function(res){
        if(res.status == 1){
            var userStatus =  {
              msgid : msgid,
              msg : msg,
              avatar : $('input[name="avatar"]').val(),
              acctype : $('input[name="acctype"]').val(),
              social_type : $('input[name="social_type"]').val(),
              name : $('input[name="name"]').val(),
              time : res.text.time,
              newid : res.text.lastid
            }
            inew.updStatus(userStatus);
            $('textarea[name="status-msg"]').prop('disabled',false).val('');
            $('button.btn-stat').prop('disabled',false).html('Update');
        }else{
          $('div#'+msgid).slideUp(300);
          $('div.statuses').prepend('<div class="alert alert-danger" style="display:none">'+res.text+'</div>');
          $('div.alert').hide().slideDown(300);
        }
      }
    });

    return false;
  });
	$('[data-toggle="tooltip"]').tooltip();
	$('textarea').keyup(function(){
		if($(this).val().length < 1){
			$(this).height('42px');
		}
	});
  //Update Bio
  $('div.p-edit').click(function(){
      x = '<div class="modal fade bs-example-modal-sm" id="userbio-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal">';
      x = x +'<div class="modal-dialog">';
      x = x +'<div class="modal-content">';
      x = x +'<div class="modal-header">';
      x = x +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
      x = x +'<h4 class="modal-title" id="myModalLabel">Bio</b></h4>';
      x = x +'';
      x = x +'</div>';
      x = x +'<div class="modal-body">';
        x = x +'<form class="userbioForm">';
        x = x +'<div class="form-group">';
          x = x +'<label for="content-text">About :  <span class="biotextlength">328</span></label>';
          x = x +'<textarea name="msg" class="form-control" style="width:100%;resize:none" rows="5" required>'+$('p.p-info1').html().replace(/<br>/g,'\r\n')+'</textarea>';
        x = x +'</div>';
        x = x +'<button type="submit" class="btn btn-primary pull-right">UPDATE</button>';
        x = x +'<div style="clear:both"></div>';
        x = x +'</form>';
      x = x +'</div>';
      x = x +'</div>';
      x = x +'</div>';
      x = x +'</div>';
      x = x +'</div>';
      x = x +'</div>';
      if(!$('div#userbio-modal').length > 0){
        $('body').append(x);
      }
      $('span.biotextlength').html(328 - $('textarea[name="msg"]').val().length);
      $('div#userbio-modal').modal('show');
      $('textarea[name="msg"]').keyup(function(){
        $('span.biotextlength').html(328 - $(this).val().length);
        if(!inew.textLength($(this).val(),328)){
          alert('too long.');
        }
      });
      $('form.userbioForm').submit(function(){
        $('textarea[name="msg"]').prop("disabled",true);
        $('button[type="submit"]').prop("disabled",true).html('Loading....');
        $.ajax({
          type : 'POST',
          url : '/user/updatebio',
          dataType : 'JSON',
          data : { about_you : $('textarea[name="msg"]').val().replace(/\r?\n/g, '<br>') },
          success : function(res){
            if(res.status){
              $("div.modal-body").prepend('<div class="alert alert-success">'+res.text+'</div>');
              setTimeout(function(){
                $("div.alert").slideUp().remove();
                $('div#userbio-modal').modal('hide');
              },5000);
            }else{

            }
            $('div#userbio-modal').on('hidden.bs.modal', function (e) {
              $('p.p-info1').html(inew.stripper($('textarea[name="msg"]').val().replace(/\r?\n/g, '<br>'),"<br>"));
              $(this).remove();
            });
          }
        });
        return false;
      });
  });
  //DJs form
  $('form.djsForm').submit(function(){
    $('input[name="djName"],select[name="djSocialID"],input[name="djTag"]').prop('readonly',true);
    $('button[type="submit"]').prop('readonly',true).html('Loading......');
    $.ajax({
      type : 'POST',
      url : '/admin/dj/add',
      dataType : 'JSON',
      data : $(this).serialize(),
      success : function(res){
        if(res.status == 1){
            var x = '<tr>';
                x = x + '<td>'+inew.stripper(res.text.djName)+'('+inew.stripper(res.text.djName2)+')</td>';
                x = x + '<td>'+inew.stripper(res.text.djTag)+'</td>';
                x = x + '<td>'+res.text.added_by+'</td>';
                x = x + '<td>'+res.text.time+'</td>';
                x = x + '<td><a class="act-butt btn btn-xs btn-info" id="'+res.text.djid+'" onclick="inew.editDj(this.id,\''+inew.stripper(res.text.djName)+'\',\''+inew.stripper(res.text.djTag)+'\',\''+res.text.djSocialID+'\',\''+inew.stripper(res.text.djName2)+'\')">EDIT</a> <a class="act-butt btn btn-xs btn-danger" id="'+res.text.djid+'" onclick="inew.deleteDj(this.id,\''+res.text.djSocialID+'\',\''+res.text.djName+'\')">DELETE</a></td>';
            x = x + '</tr>';
            $('table#djtable tbody').prepend(x);
            $('form.djsForm').prepend('<div class="alert alert-success">'+res.text.text+'</div>');
            $('input[name="djName"],select[name="djSocialID"],input[name="djTag"]').prop('readonly',false).val('');
            $('button[type="submit"]').prop('readonly',false).html('Add');
            setTimeout(function(){
              $('div.alert').slideUp().remove();
            },3000);
        }else{
            $('form.djsForm').prepend('<div class="alert alert-danger">'+res.text+'</div>');
            $('input[name="djName"],select[name="djSocialID"],input[name="djTag"]').prop('readonly',false);
            $('button[type="submit"]').prop('readonly',false).html('Add');
            setTimeout(function(){
              $('div.alert').slideUp().remove();
            },3000);
        }
      }
    });
    return false;
  });
  //Dj On Board
  $('select#djob_social_id').change(function(){
    if($(this).val() != ""){
      $('span.djob_status').html('Loading.....');
      $.ajax({
        type : 'POST',
        url : '/admin/djob/update',
        dataType : 'JSON',
        data : $(this).serialize(),
        success : function(res){
          if(res.status==1){
            $('span.djob_status').html(res.text.text);
            $('select#djob_social_id').val('');
            if(res.text.status==1){
              $('p.djob_name').css({ 'color' : '#2ecc71' }).html(inew.stripper(res.text.dj_name));
            }else{
              $('p.djob_name').css({ 'color' : '#e74c3c' }).html(inew.stripper(res.text.dj_name));
            }
            setTimeout(function(){
              $('span.djob_status').html('');
            },3000);
          }else{
            $('span.djob_status').html(res.text.text);
            $('select#djob_social_id').val('');
          }
        }
      });
    }else{
      $('span.djob_status').html('');
      return false;
    }
  });
});
$(window).load(function(){
	$('div.loader').fadeOut();
	$('p.p-rank').click();
	//$('tr#'+window.location.hash.substr(1)).addClass('highlight');
});
$('div.chat-msgbox').scroll(function(){
	if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight){
		if(reached==0){
			reached=1;
			$('.load-more').show();
		}
	}
});
var inew = {
	SelectText : function(element) {
    var doc = document
        , text = doc.getElementById(element)
        , range, selection
    ;    
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
	},
	index : function(){
		$('a.refresh').click(function(){
			$(".chatloadhere").children().slideUp(200, function() { $(this).children().remove(); });
			$('div.load-more').hide();
			inew.index.lastid=0;
			inew.index.firstid=0;
			inew.index.doneAll=0;
			inew.index.working=false;
			$('div.loader').fadeIn();
			inew.getmsg();
			$('div.loader').fadeOut();
			reached=0;
		});
		var working = false,
			lastid = 0,
			doneAll = 0,
			firstid = 0;

		//formation
		$('form.sendchat').submit(function(ep){
			var msg = $('input[name="msg"]').val();
			if(msg.length == 0){
				alert('Please enter a message');
				return false;
			}
			if(msg.length < 2){
				alert('Please enter a longer message');
				return false;
			}
			/*msg = $('input[name="replto"]').val() + $('input[name="msg"]').val();
			var patt = new RegExp(/\@reply\_(.*?)\:/g);
			if(patt.test(msg)){
				$('input[name="msg"]').val($('input[name="replto"]').val() + $('input[name="msg"]').val());
			}*/
			if(working){
				return false;
			}
			else {
				if($('input[name="replto"]').val().length > 0){
					$('input[name="msg"]').val($('input[name="replto"]').val() + $('input[name="msg"]').val());
					msg = $('input[name="msg"]').val();
				}
				working = true;
				var tempID = Math.floor(Math.random()*32767),
					userInfo = {
						msg_id		: 'tempmsg-'+tempID,
						name		: $('input[name="name"]').val(),
						social_id		: $('input[name="social_id"]').val(),
						social_type		: $('input[name="social_type"]').val(),
						email		: $('input[name="email"]').val(),
						points		: $('input[name="points"]').val(),
						acctype		: $('input[name="acctype"]').val(),
						avatar		: $('input[name="avatar"]').val(),
						color		: $('input[name="color"]').val(),
						neon		: $('input[name="neon"]').val(),
						time		: Math.round(new Date().getTime() / 1000),
						text		: msg.replace(/</g,'&lt;').replace(/>/g,'&gt;'),
						msgType		: 'normal',
						more		: 0
					}
				inew.addMessage(userInfo);
		        $.ajaxSetup({
		           headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		        });
				$.ajax({
					url : 'sendchat/now',
					type : 'post',
					data : { msg : escape(msg)},
					dataType : 'JSON',
					success : function(res){
						if(res.status==0){
							alert(res.text);
							$('#msg-'+userInfo.msg_id).slideUp();
						}
						console.log(res);
					},
					error : function(res){
						console.log(res.status);
					}
				});
				$('input[name="msg"]').val('').focusout();
				working = false;
				$('input[name="msg"], button[type="submit"]').val('Please wait 5 seconds to send a chat again...').prop('disabled',true);
				$('button.replyer').fadeOut().remove();
				$('input[name="replto"]').prop('value','');
				setTimeout(function(){
					$('input[name="msg"], button[type="submit"]').val('').prop('disabled',false);
					$('input[name="msg"]').focus();
				},5000);

			}

			return false;
		});

		(function getChatsFunction(){
			inew.getmsg(getChatsFunction);
		})();
		(function TimeoutFunction(){
			inew.liveTime(TimeoutFunction);
		})();
	},
  textLength : function(val,max){
    if(val.length > max) return false;
    return true;
  },
  //Users Edit
  editUser : function(id,name,acctype,points,color,neon,avatar,social_id){
    var su = false;
    x = '<div class="modal fade bs-example-modal-sm" id="editUsers-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal">';
    x = x +'<div class="modal-dialog">';
    x = x +'<div class="modal-content">';
    x = x +'<div class="modal-header">';
    x = x +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    x = x +'<h4 class="modal-title" id="myModalLabel">EDIT User <b>"'+inew.stripper(name)+'"</b></h4>';
    x = x +'';
    x = x +'</div>';
    x = x +'<div class="modal-body">';
      x = x +'<form class="editUserForm">';
	  	x = x +'<div id="results"></div>';
        x = x +'<div class="form-group">';
          x = x +'<label>Name : </label>';
          x = x +'<input type="text" class="form-control" name="name" id="name" placeholder="Enter Name here." value="'+inew.stripper(name)+'">';
        x = x +'</div>';
        x = x +'<div class="form-group">';
          x = x +'<label>Account Type : </label>';
          x = x +'<select name="acctype" class="form-control">';
            x = x +'<option value="">SELECT HERE</option>';
            x = x +'<option class="111" value="111">Owner</option>';
            x = x +'<option class="1" value="1">Co - Owner</option>';
            x = x +'<option class="2" value="2">Head Admin</option>';
            x = x +'<option class="3" value="3">Admin</option>';
            x = x +'<option class="4" value="4">Head Mod</option>';
            x = x +'<option class="5" value="5">Senior Mod</option>';
            x = x +'<option class="6" value="6">Mod</option>';
            x = x +'<option class="7" value="7">Head Dj</option>';
            x = x +'<option class="8" value="8">Female Dj</option>';
            x = x +'<option class="9" value="9">Male Dj</option>';
            x = x +'<option class="10" value="10">Developer</option>';
            x = x +'<option class="11" value="11">Premium</option>';
            x = x +'<option class="12" value="12">Sponsor</option>';
            x = x +'<option class="13" value="13">Partner Site</option>';
            x = x +'<option class="14" value="14">Newbie</option>';
            x = x +'<option class="15" value="15">Chatter of the Month</option>';
            x = x +'<option class="16" value="16">FriendZone FM Tambayer</option>';
            x = x +'<option class="0" value="0">Member</option>';
          x = x +'</select>';
        x = x +'</div>';
        x = x +'<div class="form-group">';
          x = x +'<label>Points : </label>';
          x = x +'<input type="text" class="form-control" name="points" id="points" placeholder="Enter Points here." value="'+points+'">';
          x = x +'';
        x = x +'</div>';
        x = x +'<div class="form-group">';
          x = x +'<label>Color Name : </label><br>';
          x = x +'<span class="colorpicker">';
          x = x +'';
          x = x +'<span class="bgbox"></span><span class="hexbox"></span>';
          x = x +'<span class="clear"></span>';
          x = x +'<span class="colorbox">';
          x = x +'<b id="colors" data-value="0" data-color="bcbcbc" style="background:#bcbcbc" title="Dirty White"></b>';
          x = x +'<b id="colors" data-value="2" data-color="9e0b0f" style="background:#9e0b0f" title="Dark Red"></b>';
          x = x +'<b id="colors" data-value="3" data-color="ff0000" style="background:#ff0000" title="Red"></b>';
          x = x +'<b id="colors" data-value="4" data-color="f26522" style="background:#f26522" title="Orange"></b>';
          x = x +'<b id="colors" data-value="5" data-color="00a651" style="background:#00a651" title="Dark Green"></b>';
          x = x +'<b id="colors" data-value="6" data-color="39b54a" style="background:#39b54a" title="Green"></b>';
          x = x +'<b id="colors" data-value="7" data-color="00ffff" style="background:#00ffff" title="Light Blue"></b>';
          x = x +'<b id="colors" data-value="8" data-color="00aeef" style="background:#00aeef" title="Sky Blue"></b>';
          x = x +'<b id="colors" data-value="9" data-color="005fe1" style="background:#005fe1" title="Blue"></b>';
          x = x +'<b id="colors" data-value="10" data-color="f06eaa" style="background:#f06eaa" title="Pink"></b>';
          x = x +'<b id="colors" data-value="11" data-color="92278f" style="background:#92278f" title="Violet"></b>';
          x = x +'<b id="colors" data-value="12" data-color="8dc63f" style="background:#8dc63f" title="Light Green"></b>';
          x = x +'<b id="colors" data-value="13" data-color="ffde00" style="background:#ffde00" title="Yellow"></b>';
          x = x +'</span>';
          x = x +'</span>';
          x = x +'<input type="hidden" value="'+color+'" name="usercolor" />';
        x = x +'</div>';
        x = x +'<div class="form-group">';
          x = x +'<label>Neon Name : </label><br>';
          x = x +'<input type="checkbox" class="neonbox" name="neonbox" id="neonbox">';
          x = x +'<input type="hidden" value="'+neon+'" name="neon" />';
        x = x +'</div>';
        x = x +'<div class="form-group">';
          x = x +'<label>PREVIEW : </label><br>';
          x = x +'<div class="media">';
          x = x +'<div class="pull-left">';
          x = x +'<a><img class="media-object" src="'+avatar+'" width="60px"></a>';
          x = x +'</div>';
          x = x +'<div class="media-body">';
          x = x +'<h4 class="media-heading useredit_colorname">'+inew.stripper(name)+'<span class="ranking acctype-'+acctype+'">&nbsp;&nbsp;&nbsp;&nbsp;</span></h4>';
          x = x +'Hello i`m <b>'+inew.stripper(name)+'</b>';
          x = x +'</div>';
          x = x +'</div>';
        x = x +'</div>';
        x = x +'<input type="hidden" value="'+social_id+'" name="social_id" />';
        x = x +'<button type="submit" class="btn btn-primary pull-right">EDIT</button><div style="clear:both"></div>';
      x = x +'</form>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    $('body').append(x);
    $('#editUsers-modal').modal('show');
    $('#editUsers-modal').on('shown.bs.modal', function (e) {
      $('b[data-value="'+color+'"]').click();
      $('select[name="acctype"]').val(acctype);
      if(neon == 1){
        $('input.neonbox').prop('checked',true);
        $('h4.useredit_colorname').addClass('neon');
      }
    });
    $('#editUsers-modal').on('hidden.bs.modal', function (e) {
	  if(su == true){
	 	 location.href='/admin/users/#user-'+id;
	  }
      $(this).remove();
    });
	$('select[name="acctype"]').change(function(){
		$('.ranking').removeClass().addClass('ranking acctype-'+$(this).val());
	});
    $('input.neonbox').change(function(){
      if(this.checked){
        $('h4.useredit_colorname').addClass('neon');
        $('input[name="neon"]').val(1);
      }else{
        $('h4.useredit_colorname').removeClass('neon');
        $('input[name="neon"]').val(0);
      }
    });
    $('b#colors').click(function(){
      $('.useredit_colorname').css({'color' : '#'+$(this).attr('data-color')});
      $('input[name="usercolor"]').val($(this).attr('data-value'));
    });
    MC.CustomColorPicker.reload();
    $('form.editUserForm').submit(function(){
	  su = true;
      $.ajax({
		  type : 'POST',
		  url : '/admin/users/edit',
		  dataType : 'JSON',
		  data : $(this).serialize(),
		  success : function(res){
			if(res.status==1){
				$('div#results').slideUp().html('').html('<div class="alert alert-success">'+res.text+'</div>').slideDown();
			}else{
				$('div#results').slideUp().html('').html('<div class="alert alert-danger">'+res.text+'</div>').slideDown();
			}
		  }
	  });
      return false;
    });
  },
  //DJs Edit
  editDj : function(id,djname,djTag,djSocialID,djName2){
    var su = false;
		x = '<div class="modal fade bs-example-modal-sm" id="editDj-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal">';
		x = x +'<div class="modal-dialog">';
		x = x +'<div class="modal-content">';
		x = x +'<div class="modal-header">';
		x = x +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		x = x +'<h4 class="modal-title" id="myModalLabel">EDIT <b>'+inew.stripper(djname)+'('+inew.stripper(djName2)+')</b></h4>';
		x = x +'';
		x = x +'</div>';
		x = x +'<div class="modal-body">';
			x = x +'<form class="editDjForm-'+id+'">';
			x = x +'<div class="form-group">';
				x = x +'<label for="content-text">DJ NAME :</label>';
				x = x +'<input type="text" class="form-control" value="'+inew.stripper(djname)+'" name="djName" id="djName" placeholder="Enter DJ Name" required />';
			x = x +'</div>';
			x = x +'<div class="form-group">';
				x = x +'<label for="content-text">DJ Tagline :</label>';
				x = x +'<input type="text" class="form-control" value="'+inew.stripper(djTag)+'" name="djTag" id="djTag" placeholder="Enter DJ Name" required />';
				x = x +'<input type="hidden" class="form-control" value="'+inew.stripper(djSocialID)+'" name="djSocialID" id="djSocialID" required />';
			x = x +'</div>';
			x = x +'<button type="submit" class="btn btn-primary pull-right">EDIT</button>';
			x = x +'<div style="clear:both"></div>';
			x = x +'</form>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		$('body').append(x);
		$('#editDj-modal').modal('show');
    $('form.editDjForm-'+id).submit(function(){
      //alert($(this).serialize());
      $.ajax({
        type : 'POST',
        url : '/admin/dj/edit',
        dataType : 'JSON',
        data : $(this).serialize(),
        success : function(res){
          if(res.status==1){
            $('form.editDjForm-'+id).prepend('<div class="alert alert-success">'+res.text+'</div>');
            setTimeout(function(){
              $('div.alert').slideUp().remove();
            },3000);
            su = true;

          }else{
            $('form.editDjForm-'+id).prepend('<div class="alert alert-danger">'+res.text+'</div>');
            setTimeout(function(){
              $('div.alert').slideUp().remove();
            },3000);
          }
        }
      });
      return false;
    });
    var months = new Array(12);
    months[0] = "Jan";
    months[1] = "Feb";
    months[2] = "Mar";
    months[3] = "Apr";
    months[4] = "May";
    months[5] = "Jun";
    months[6] = "Jul";
    months[7] = "Aug";
    months[8] = "Sept";
    months[9] = "Oct";
    months[10] = "Nov";
    months[11] = "Dec";
    var d = new Date(),
        h = d.getHours(),
        m = months[d.getMonth()],
        day = d.getDate(),
        y = d.getFullYear();
    if(h == 0){
      h = 12;
    }
    if(h < 10){
      h = '0'+h
    }
    var timeOfDay = ( d.getHours() < 12 ) ? "am" : "pm";
    $('#editDj-modal').on('hidden.bs.modal', function (e) {
      $('tr#'+id+' td.djname').html($('form.editDjForm-'+id+' div input[name="djName"]').val()+'('+djName2+')');
      $('tr#'+id+' td.djtag').html($('form.editDjForm-'+id+' div input[name="djTag"]').val());
      if(su == true){
        $('tr#'+id+' td.djtime').html(m + ' ' + day + ', ' + y + ' ' + h +':' +d.getMinutes() + ' ' +timeOfDay);
      }
      $(this).remove();
    });
  },
  //Delete Dj
  deleteDj : function(id,djSocialID,djName){
    var su = false;
    x = '<div class="modal fade bs-example-modal-sm" id="deleteDj-modal" tabindex="-1" role="dialog" aria-labelledby="deleteDj-modal">';
    x = x +'<div class="vertical-alignment-helper">';
    x = x +'<div class="modal-dialog modal-sm vertical-align-center">';
    x = x +'<div class="modal-content">';
    x = x +'<div class="modal-header">';
    x = x +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    x = x +'<h4 class="modal-title" id="myModalLabel">Are you sure you want to delete <b>'+djName+'?</b></h4>';
    x = x +'';
    x = x +'</div>';
    x = x +'<div class="modal-body">';
      x = x +'<form class="deleteDjForm">';
      x = x +'<center>';
      x = x +'<input type="hidden" name="dj_id" value="'+id+'">';
      x = x +'<input type="hidden" name="djSocialID" value="'+djSocialID+'">';
      x = x +'<button type="button" class="btn btn-danger">NO</button> ';
      x = x +'<button type="submit" class="btn btn-success">YES</button>';
      x = x +'</center>';
      x = x +'</form>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    x = x +'</div>';
    $('body').append(x);
    $('#deleteDj-modal').modal('show');
    $('form.deleteDjForm').submit(function(){
      $.ajax({
        type : 'POST',
        url : '/admin/dj/delete',
        dataType : 'JSON',
        data : $(this).serialize(),
        success : function(res){
          if(res.status == 1){
            $('form.deleteDjForm center').html('<b>'+djName+'</b> has been successfully deleted.');
            setTimeout(function(){
              $('#deleteDj-modal').modal('hide');
            },5000);
            su = true;
          }else{
            $('form.deleteDjForm center').html('<b>'+res.text+'</b> ');
          }
        }
      });
      return false;
    });
    $('#deleteDj-modal').on('hidden.bs.modal', function (e) {
      $(this).remove();
      if(su == true){
        $('tr#'+id).slideUp().remove();
      }
    });
  },
  //strip tags
  stripper : function(text,allowed){
    allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return text.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
  },
  //Update Status
  updStatus : function(user){
    var x = '<div class="main-status" id="'+user.msgid+'" style="display:none">';
        x = x + '<div class="user-stat">';
        x = x + '<div class="media">';
        x = x + '<div class="media-left"><img class="media-object stat-img" src="'+user.avatar+'"></div>';
        x = x + '<div class="media-body">';
        x = x + '<p class="media-heading stat-name"> '+user.name+' </p>';
        x = x + '<p class="stat-rank">'+inew.totherank(user.acctype)+'</p> <span class="fa fa-facebook-square"></span>';
        x = x + '</div>';
        x = x + '<div class="media-right">';
        x = x + '<p class="time"><span class="fa fa-clock-o"></span> '+user.time+'</p>';
        //h-color when clicked
        x = x + '<p>';
        x = x + '<a class="stat-butts"><span class="badge statuslikes-'+user.newid+'">0</span></a>';
        x = x + '<a class="stat-butts"><span class="fa fa-heart likebutt-'+user.newid+'" data-toggle="tooltip" data-placement="left" title="LIKE" title="LIKE" id="'+user.newid+'" onclick="inew.likethis(this.id)"></span></a>';
        x = x + '<a class="stat-butts"><span class="fa fa-times-circle" data-toggle="tooltip" data-placement="left" title="DELETE" title="LIKE" id="'+user.newid+'" onclick="inew.delStatus(this.id)"></span></a>';
        x = x + '</p></div>';
        x = x + '</div>';
        x = x + '</div>';
        x = x + '<div class="stat-content">'+inew.stripper(user.msg,'<br>')+'</div>';
        x = x + '</div>';
        $('div.statuses').prepend(x);
        $('div#'+user.msgid).hide().fadeIn(300);
      	$('[data-toggle="tooltip"]').tooltip();
  },
  //Like
  likethis : function(x){
    if($('.likebutt-'+x).hasClass('h-color')){
      $('.likebutt-'+x).removeClass('h-color');
      $.ajax({
        type : 'POST',
        url : '/user/unlike',
        dataType : 'JSON',
        data : { postid : x },
        success : function(res){
          if(res.status==1){
            $('.statuslikes-'+x).html(res.text.likedcount);
          }else{
            $('.likebutt-'+x).removeClass('h-color');
            alert(res.text)
          }
        }
      });
    }else{
      $('.likebutt-'+x).addClass('h-color');
      $.ajax({
        type : 'POST',
        url : '/user/like',
        dataType : 'JSON',
        data : { postid : x },
        success : function(res){
          if(res.status==1){
            $('.statuslikes-'+x).html(res.text.likedcount);
          }else{
            $('.likebutt-'+x).removeClass('h-color');
            alert(res.text)
          }
        }
      });
    }
  },
  //Delete Status
  delStatus : function(x){
    var laman = $('div#'+x).html();
    $('div#'+x).fadeOut().html('').addClass('alert alert-warning').fadeIn().html('Please wait while loading...');
    $.ajax({
      type : 'POST',
      url : '/user/delstatus',
      dataType : 'JSON',
      data : { postid : x },
      success : function(res){
        if(res.status==1){
          $('div#'+x).html('').removeClass('alert-warning').addClass('alert alert-success').html(res.text);
          setTimeout(function(){
            $('div#'+x).slideUp().remove();
          },3000);
        }else{
          $('div#'+x).html('').removeClass('alert-warning').addClass('alert alert-danger').html(res.text+" <a href='/profile/'>Click Here</a> to refresh page.");
        }
      }
    });
  },
	//Ranking
	totherank : function(asd){
		if(asd == 111){
			 x = "OWNER";
		}
		else if(asd == 1){
			 x = "CO-OWNER";
		}
		else if(asd == 2){
			 x = "HEAD ADMINISTRATOR";
		}
		else if(asd == 3){
			 x = "ADMINISTRATOR";
		}
		else if(asd == 4){
			 x = "HEAD MODERATOR";
		}
		else if(asd == 5){
			 x = "SENIOR MODERATOR";
		}
		else if(asd == 6){
			 x = "MODERATOR";
		}
		else if(asd == 7){
			 x = "HEAD DISC JOCKEY";
		}
		else if(asd == 8){
			 x = "FEMALE DISC JOCKEY";
		}
		else if(asd == 9){
			 x = "MALE DISC JOCKEY";
		}
		else if(asd == 10){
			 x = "DEVELOPER";
		}
		else if(asd == 11){
			 x = "PREMIUM";
		}
		else if(asd == 12){
			 x = "SPONSOR";
		}
		else if(asd == 13){
			 x = "PARTNER SITE";
		}
		else if(asd == 14){
			 x = "NEWBIE";
		}
		else if(asd == 15){
			 x = "CHATTER OF THE MONTH";
		}
		else if(asd == 16){
			 x = "FRIENDZONE FM TAMBAYER";
		}
		else{
			 x = "MEMBER";
		}
		return x;

	},
	//add messages
	addMessage : function(userInfo){
		$('[data-toggle="tooltip"]').tooltip();
		var ex = $("div.msg-"+userInfo.msg_id),
			msg = userInfo.text;
		if(ex.length) ex.remove();
		switch(userInfo.msgType){
			case 'normal' :
			var x = '<div style="padding:2px" id="msg-'+userInfo.msg_id+'">';
					x = x+'<div class="msgcomp msg-"'+userInfo.msg_id+'">';
					x = x+'<div class="media">';
					x = x+'<div class="pull-left">';
					x = x+'<a href="/profile/'+userInfo.social_id+'"><img class="media-object pr-img" src="'+userInfo.avatar+'" width="50px" height="50px"></a>';
					if(userInfo.social_type == "FACEBOOK"){
						x = x+'<center><i style="font-color:#3498db" class="fa fa-facebook-official" aria-hidden="true"></i></center>';
					}
					else{
						x = x+'<center><i style="font-color:#2ecc71" class="fa fa-twitter" aria-hidden="true"></i></center>';
					}
					x = x+'</div>';
					x = x+'<div class="media-body chat-body">';
					var neon = "";
					if(userInfo.neon == 1){
						neon = "neon";
					}
					x = x+'<h4 class="media-heading pull-left pr-i"><a class="color-'+userInfo.color+' '+neon+'" href="/profile/'+userInfo.social_id+'">'+userInfo.name+'</a> ';
						if(userInfo.acctype == 111){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[OWNER]</span>';
						}
						else if(userInfo.acctype == 1){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[CO-OWNER]</span>';
						}
						else if(userInfo.acctype == 2){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[HEAD ADMINISTRATOR]</span>';
						}
						else if(userInfo.acctype == 3){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[ADMINISTRATOR]</span>';
						}
						else if(userInfo.acctype == 4){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[HEAD MODERATOR]</span>';
						}
						else if(userInfo.acctype == 5){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[SENIOR MODERATOR]</span>';
						}
						else if(userInfo.acctype == 6){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[MODERATOR]</span>';
						}
						else if(userInfo.acctype == 7){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[HEAD DISC JOCKEY]</span>';
						}
						else if(userInfo.acctype == 8){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[FEMALE DISC JOCKEY]</span>';
						}
						else if(userInfo.acctype == 9){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[MALE DISC JOCKEY]</span>';
						}
						else if(userInfo.acctype == 10){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[DEVELOPER]</span>';
						}
						else if(userInfo.acctype == 11){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[PREMIUM]</span>';
						}
						else if(userInfo.acctype == 12){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[SPONSOR]</span>';
						}
						else if(userInfo.acctype == 13){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[PARTNER SITE]</span>';
						}
						else if(userInfo.acctype == 14){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[NEWBIE]</span>';
						}
						else if(userInfo.acctype == 15){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[CHATTES OF THE MONTH]</span>';
						}
						else if(userInfo.acctype == 16){
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[FRIENDZONE FM TAMBAYER]</span>';
						}
						else{
							x = x +'<span class="ranking" style="font-size:9px;vertical-align: middle;">[MEMBER]</span>';
						}
					x = x +'<span class="ranking acctype-'+userInfo.acctype+'" style="font-size:9px;vertical-align: middle;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></h4>';
					//banuser
					var ban = ($('input[name="social_id"]').val() != userInfo.social_id && userInfo.acctype == 0 && $('input[name="acctype"]').val() > 0 && $('input[name="acctype"]').val() != 7) ? x = x+'<i class="fa fa-ban replyButt pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Ban '+userInfo.name+'" onclick="inew.ban(\''+userInfo.name+'\','+userInfo.social_id+')" style="cursor:pointer"></i>' : '';
					//report
					var report = ($('input[name="social_id"]').val() != userInfo.social_id) ? x = x+'<i class="fa fa-flag reportButt pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Report '+userInfo.name+' to Admin" onclick="inew.sumreport(\''+userInfo.social_id+'\',\''+userInfo.name+'\')" style="cursor:pointer"></i>' : '';
					//reply
					var reply = ($('input[name="social_id"]').val() != userInfo.social_id) ? x = x+'<i class="fa fa-share-square replyButt pull-right" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="Reply to '+userInfo.name+'" onclick="inew.sumreply(\''+userInfo.name+'\')" style="cursor:pointer"></i>' : '';
					x = x+'<i class="fa fa-clock-o pull-right" data-unix-time="'+userInfo.time+'" aria-hidden="true"></i>';
					x = x +'<span class="pull-right tfm-time" data-unix-time="'+userInfo.time+'" style="font-size:9px">Just Now</span>';
					x = x +'<div style="clear:both"></div>';
					x = x+'<span class="msg" style="font-size: 12px">'+inew.smilys(inew.replaceReply(unescape(msg).replace(/</g,'&lt;').replace(/>/g,'&gt;')),userInfo.acctype)+'</span>';
					x = x+'</div>';
					x = x+'</div>';
					x = x+'</div>';
				x = x+'</div>';
			break;
			case 'announcement':
			var x = '<div style="padding:2px" id="msg-'+userInfo.msg_id+'">';
					x = x+'<div class="msgcomp msg-"'+userInfo.msg_id+' >';
						x = x+'';
						x = x+'<div class="alert alert-annc">';
						x = x+'<h3 class="annc-head"> ANNOUNCEMENT</h3>';
						x = x+'<span style="font-size:11px;text-style:italic;margin:0px;padding:0px;">'+unescape(userInfo.text)+'</span><br>';
						x = x+'</div>';
            x = x+'<div class="pull-right"><img class="media-object pr-img annc-img" src="'+userInfo.avatar+'" width="50px" height="50px" data-toggle="tooltip" data-placement="bottom" title="Announced By '+userInfo.name+'"></div>';
					x = x+'</div>';
				x = x+'</div>';
			break;
      case 'warning':
      var x = '<div style="padding:2px" id="msg-'+userInfo.msg_id+'">';
          x = x+'<div class="msgcomp msg-"'+userInfo.msg_id+' >';
            x = x+'';
            x = x+'<div class="alert alert-annc">';
            x = x+'<h3 class="annc-head"> WARNING</h3>';
            x = x+'<span style="font-size:11px;text-style:italic;margin:0px;padding:0px;">'+unescape(userInfo.text)+'</span><br>';
            x = x+'</div>';
            x = x+'<div class="pull-right"><img class="media-object pr-img annc-img" src="https://graph.facebook.com/friendzonefm/picture" width="50px" height="50px" data-toggle="tooltip" data-placement="bottom" title="Announced By '+userInfo.name+'"></div>';
          x = x+'</div>';
        x = x+'</div>';
      break;
      case 'global':
      var x = '<div style="padding:2px" id="msg-'+userInfo.msg_id+'">';
          x = x+'<div class="msgcomp msg-"'+userInfo.msg_id+' >';
            x = x+'<div class="alert alert-annc2">';
            x = x+'<span style="font-size:11px;text-style:italic;margin:0px;padding:0px;">'+unescape(userInfo.text)+'</span><br>';
            x = x+'</div>';
          x = x+'</div>';
        x = x+'</div>';
      break;
		}
		if(userInfo.more==0){
			$('div.chatloadhere').prepend(x);
		}else{
			$('div.chatloadhere').append(x);

		}
		$('#msg-'+userInfo.msg_id).hide().slideDown(200);
	},
	ban : function(name,id){
		if(confirm("Do you really want to ban "+name)){
			var day = prompt("Enter how many days you want to ban "+name);
			if(isNaN(day) || day == "" || day == null){
				alert("Please enter a number!");
				return inew.ban(name,id);
			}
			$.ajax({
				type : 'POST',
				url : '/tools/ban',
				dataType : 'JSON',
				data : { social_id : id, day : day },
				success : function(res){
					if(res.status==1){
						alert(res.text);
					}else{
						alert(res.text);
					}
				}
			});
		}else{
			return false;
		}
	},
	//announcement
	addAnnc : function(name){
		x = '<div class="modal fade bs-example-modal-sm" id="annc-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal">';
		x = x +'<div class="modal-dialog">';
		x = x +'<div class="modal-content">';
		x = x +'<div class="modal-header">';
		x = x +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		x = x +'<h4 class="modal-title" id="myModalLabel">Announcement</b></h4>';
		x = x +'';
		x = x +'</div>';
		x = x +'<div class="modal-body">';
			x = x +'<form class="anncForm">';
			x = x +'<div class="form-group">';
				x = x +'<label for="content-text">Message :</label>';
				x = x +'<textarea name="msg" class="form-control" style="width:100%;resize:none" rows="5" required></textarea>';
			x = x +'</div>';
			x = x +'<button type="submit" class="btn btn-default pull-right">ANNOUNCE</button>';
			x = x +'<div style="clear:both"></div>';
			x = x +'</form>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		$('body').append(x);
		$('#annc-modal').modal('show');
		$('form.anncForm').submit(function(){
			var msg = $('textarea[name="msg"]').val().replace(/</g,'&lt;').replace(/>/g,'&gt;');
			var tempID = Math.floor(Math.random()*32767);
			var userInfo = {
				msg_id		: 'tempmsg-'+tempID,
				name		: name,
				time		: Math.round(new Date().getTime() / 1000),
				text		: msg,
				msgType		: 'announcement',
				more		: 0
			}
			$.ajax({
				type : 'POST',
				url : 'announcement',
				data : { msg : escape(msg) },
				dataType : 'JSON',
				success : function(res){
					if(res.status==1){
						$('#annc-modal').modal('hide');
						$('#annc-modal').on('hidden.bs.modal', function (e) {
							$(this).remove();
							inew.addMessage(userInfo);
						});
					}else{
						console.log(res);
					}
				}
			});
			return false
		});
		/**/
	},
	// report to admin
	sumreport : function(social_id,name){
		x = '<div class="modal fade bs-example-modal-sm" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal">';
		x = x +'<div class="vertical-alignment-helper">';
		x = x +'<div class="modal-dialog modal-sm vertical-align-center">';
		x = x +'<div class="modal-content">';
		x = x +'<div class="modal-header">';
		x = x +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		x = x +'<h4 class="modal-title" id="myModalLabel">Report <b>'+name+'</b></h4>';
		x = x +'';
		x = x +'</div>';
		x = x +'<div class="modal-body">';
			x = x +'<form class="reportForm">';
			x = x +'<div class="checkbox">';
			x = x +'<label for="input-reasons" style="font-weight:bolder">Reason :</label><br>';
			x = x +'<label><input type="radio" name="reasons[]" value="Chat Spamming" required> Chat Spamming</label><br>';
			x = x +'<label><input type="radio" name="reasons[]" value="Abusing Power"> Abusing Power</label><br>';
			x = x +'<label><input type="radio" name="reasons[]" value="Saying Badwords"> Saying Badwords</label><br>';
			x = x +'<label><input type="radio" name="reasons[]" value="Annoying"> Annoying</label><br>';
			x = x +'<label><input type="radio" name="reasons[]" value="Others"> Others :</label>';
				x = x +'<input class="form-control" name="others" style="display:none">';
			x = x +'</div>';
			x = x +'<button type="submit" class="btn btn-sm btn-success pull-right">REPORT</button>';
			x = x +'<button type="button" class="btn btn-sm btn-danger pull-right" data-dismiss="modal" aria-label="Close">CANCEL</button>';
			x = x +'<div style="clear:both"></div>';
			x = x +'</form>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		x = x +'</div>';
		$('body').append(x);
		$('#report-modal').modal('show');
		$('input[name="reasons[]"]').change(function(){
			if($('input[name="reasons[]"]:checked').val() == "Others"){
				$('input[name="others"]').slideDown();
			}else {
				$('input[name="others"]').slideUp();
			}
		});
		$('form.reportForm').submit(function(){
			$('div.modal-body').fadeOut();
			var data;
			if($('input[name="reasons[]"]:checked').val() == "Others"){
				data = { reason : $('input[name="others"]').val(), reported_id : social_id }
			}else{
				data = { reason : $('input[name="reasons[]"]:checked').val(), reported_id : social_id }
			}
			$.ajax({
				type : 'POST',
				url : 'report',
				data : data,
				dataType : 'JSON',
				success : function(res){
					if(res.status==1){
						setTimeout(function(){
							if($('input[name="reasons[]"]:checked').val() == "Others"){
							$('div.modal-body').fadeIn().html('<div class="alert alert-success">Your report for <b>'+name+'</b> has been sent. <b>Reason : '+$('input[name="others"]').val().replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</b></div>');
							}else {
							$('div.modal-body').fadeIn().html('<div class="alert alert-success">Your report for <b>'+name+'</b> has been sent. <b>Reason : '+$('input[name="reasons[]"]:checked').val().replace(/</g,'&lt;').replace(/>/g,'&gt;')+'</b></div>');
							}
						},500);
					}
					else if(res.status==2){

					}else{
						console.log(res);
					}
				}
			});

			return false;
		});
		$('#report-modal').on('hidden.bs.modal', function (e) {
		  $(this).remove();
		});
	},
	//reply
	sumreply : function(name){
		if(!$('button.replyer').length){
			$('input[name="replto"]').prop('value','@reply_'+name+': ');
			$('[data-toggle="tooltip"]').tooltip();
			$('span.addreplyer').append('<button class="btn btn-default replyer text-butts" type="button" data-toggle="tooltip" data-placement="top" title="Click to remove reply" style="display:none">'+name+'</button>');
		}else {
			alert('You already have set a person to reply with.');
			return false;
		}
		//$('input[name="msg"]').val('@reply_'+name+':' + $('input[name="msg"]').val());
		$('button.replyer').fadeIn();
		$('input[name="msg"]').focus();
		//alert(name);
		$('button.replyer').click(function(){
			$(this).fadeOut().remove();
			$('input[name="replto"]').val('');
		});
	},
	replaceReply : function(text){
		return text.replace(/\@reply\_(.*?)\:/g,'<span class="reply"><a href="#">$1 </a></span> ');
	},
	//get messages
	getmsg : function(getChatsFunction){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			cache : false,
			type : 'POST',
			url : 'getchats',
			data : 'id='+inew.index.lastid,
			dataType : 'JSON',
			success : function(res){
					if(res.msg){
						//console.log(res.msg[0].msg_id);
						if(inew.index.firstid==0){
							inew.index.firstid = res.msg[0].msg_id;
						}
						for(var i=0; i < res.msg.length; i++){
							if(inew.index.doneAll){
								if(res.msg[i].social_id != $('input[name="social_id"]').val() ){
									//$('div.chat-msgbox').append(res.msg[i].text+"<br>");
									inew.addMessage(res.msg[i]);
									inew.index.lastid = res.msg[i].msg_id;
								}
								else if(res.msg[i].social_id == $('input[name="social_id"]').val() && res.msg[i].msg_type == "warning" ){
									//$('div.chat-msgbox').append(res.msg[i].text+"<br>");
									inew.addMessage(res.msg[i]);
									inew.index.lastid = res.msg[i].msg_id;
								}
							} else {
								inew.addMessage(res.msg[i]);
								inew.index.lastid = res.msg[i].msg_id;
							}
						}
						inew.index.doneAll = 1;
					}
					else{
						console.log(res);
					}
			}
		});
		setTimeout(getChatsFunction,5000);
	},
	getMoreMsg : function(lastid){
		$('div.load-more').html('LOADING...');
		$.ajax({
			type : 'POST',
			url : 'getmorechats',
			data : 'id='+lastid,
			dataType : 'JSON',
			success : function(res){
					if(res.msg){
						for(var i=0; i < res.msg.length; i++){
								inew.addMessage(res.msg[i]);
								inew.index.firstid = res.msg[i].msg_id;
						}
						inew.index.doneAll = 1;
					}
					else{
						console.log(res);
					}
					if(inew.index.firstid==1){
						$('div.load-more').html('No more message to load').prop('onclick','');
					}else{
						$('div.load-more').html('Load more messages');
					}
					//setTimeout(function(){
						//$('div.chat-msgbox').animate({ scrollTop: $('div.chat-msgbox')[0].scrollHeight },100);
					//},500);
			}
		});
	},
	//timer
	liveTime: function(selfTimeout) {

		$('.tfm-time').each(function() {

			var msgTime = $(this).attr('data-unix-time');

			var time = Math.round(new Date().getTime() / 1000) - msgTime;

			var day = Math.round(time / (60 * 60 * 24));
			var week = Math.round(day / 7);
			var remainderHour = time % (60 * 60 * 24);
			var hour = Math.round(remainderHour / (60 * 60));
			var remainderMinute = remainderHour % (60 * 60);
			var minute = Math.round(remainderMinute / 60);
			var second = remainderMinute % 60;

			var currentTime = new Date(msgTime*1000);
			var currentHours = ( currentTime.getHours() > 12 ) ? currentTime.getHours() - 12 : currentTime.getHours();
			var currentHours = ( currentHours == 0 ) ? 12 : currentHours;
			var realTime = currentHours+':'+currentTime.getMinutes();
			var timeOfDay = ( currentTime.getHours() < 12 ) ? "AM" : "PM";

			if(day > 7) {
				var timeAgo = currentTime.toLocaleDateString();
			} else if(day>=2 && day<=7) {
				var timeAgo =  day+' days ago';
			} else if(day==1) {
				var timeAgo =  'Yesterday '+realTime+' '+timeOfDay;
			} else if(hour>1) {
				var timeAgo =  hour+' hours ago';
			} else if(hour==1) {
				var timeAgo =  'about an hour ago';
			} else if(minute==1) {
				var timeAgo =  'about a minute ago';
			} else if(minute>1) {
				var timeAgo =  minute+' minutes ago';
			} else if(second>1) {
				var timeAgo =  second+' seconds ago';
			} else {
				var timeAgo =  'few seconds ago';
			}

			//$(this).prop('title',timeAgo);
			$(this).html(timeAgo);
		});
		setTimeout(selfTimeout,5000);
	},

  smilys : function(msg,acctype){
    var premium = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,111];
    if(acctype >= 0){
      var smileys = {
        //basics
        '*wink*' : '/emojis/basic/1.png',
        '*love*' : '/emojis/basic/2.png',
        '*kissed*' : '/emojis/basic/3.png',
        '*kissing*' : '/emojis/basic/4.png',
        '*tokiss*' : '/emojis/basic/5.png',
        '*shykiss*' : '/emojis/basic/6.png',
        '*bleh*' : '/emojis/basic/7.png',
        '*crossedbleh*' : '/emojis/basic/8.png',
        '*sabogbleh*' : '/emojis/basic/9.png',
        '*shocked*' : '/emojis/basic/10.png',
        '*pilitsmile*' : '/emojis/basic/11.png',
        '*sadding*' : '/emojis/basic/12.png',
        '*relaxed*' : '/emojis/basic/13.png',
        '*really*' : '/emojis/basic/14.png',
        '*saddest*' : '/emojis/basic/15.png',
        '*confused*' : '/emojis/basic/16.png',
        '*tocry*' : '/emojis/basic/17.png',
        '*crylaugh*' : '/emojis/basic/18.png',
        '*crying*' : '/emojis/basic/19.png',
        '*antok*' : '/emojis/basic/20.png',
        '*problemado*' : '/emojis/basic/21.png',
        '*takot*' : '/emojis/basic/22.png',
        '*kabadongtawa*' : '/emojis/basic/23.png',
        '*stress*' : '/emojis/basic/24.png',
        '*bayan*' : '/emojis/basic/25.png',
        '*anobayan*' : '/emojis/basic/26.png',
        '*takotnatakot*' : '/emojis/basic/27.png',
        '*gulatnagulat*' : '/emojis/basic/28.png',
        '*galit*' : '/emojis/basic/29.png',
        '*sobranggalit*' : '/emojis/basic/30.png',
        '*inis*' : '/emojis/basic/31.png',
        '*aburido*' : '/emojis/basic/32.png',
        '*natawa*' : '/emojis/basic/33.png',
        '*nandila*' : '/emojis/basic/34.png',
        '*ayaw*' : '/emojis/basic/35.png',
        '*cool*' : '/emojis/basic/36.png',
        '*inantok*' : '/emojis/basic/37.png',
        '*xxgulat*' : '/emojis/basic/38.png',
        '*xxgulatnagulat*' : '/emojis/basic/39.png',
        '*dialamsasabihin*' : '/emojis/basic/40.png',
        '*tameme*' : '/emojis/basic/41.png',
        '*natameme*' : '/emojis/basic/42.png',
        '*evillaugh*' : '/emojis/basic/43.png',
        '*evilface*' : '/emojis/basic/44.png',
        '*kagulat*' : '/emojis/basic/45.png',
        '*ngtingpeke*' : '/emojis/basic/46.png',
        '*zipped*' : '/emojis/basic/47.png',
        '*feelingewan*' : '/emojis/basic/48.png',
        '*halanagulat*' : '/emojis/basic/49.png',
        '*faceless*' : '/emojis/basic/50.png',
        '*ngitinganghel*' : '/emojis/basic/51.png',
        '*talaga*' : '/emojis/basic/52.png',
        '*ayewan*' : '/emojis/basic/53.png',
        '*like*' : '/emojis/basic/54.png',
        '*dislike*' : '/emojis/basic/55.png',
        '*okay*' : '/emojis/basic/56.png',
        '*suntok*' : '/emojis/basic/57.png',
        '*laban*' : '/emojis/basic/58.png',
        '*peace*' : '/emojis/basic/59.png',
        '*kaway*' : '/emojis/basic/60.png',
        '*puso*' : '/emojis/basic/61.png',
        '*wasaknapuso*' : '/emojis/basic/62.png',
        '*kissmark*' : '/emojis/basic/63.png',
		'*ingatpo*' : '/emojis/ingat.png',
		'*welcomeback*' : '/emojis/welcome.png',
        //Monkeys
        '*yahooo*' : '/emojis/crazymonkz/1.gif',
        '*kinikilig*' : '/emojis/crazymonkz/2.gif',
        '*jumpup*' : '/emojis/crazymonkz/3.gif',
        '*yowyow*' : '/emojis/crazymonkz/4.gif',
        '*wazzup*' : '/emojis/crazymonkz/5.gif',
        '*kabadongmatsing*' : '/emojis/crazymonkz/6.gif',
        '*iyakingmatsing*' : '/emojis/crazymonkz/7.gif',
        '*okay!*' : '/emojis/crazymonkz/8.gif',
        '*curious*' : '/emojis/crazymonkz/9.gif',
        '*sobrangiyak*' : '/emojis/crazymonkz/10.gif',
        '*maybalak*' : '/emojis/crazymonkz/11.gif',
        '*pacute*' : '/emojis/crazymonkz/12.gif',
        '*nagiisip*' : '/emojis/crazymonkz/13.gif',
        '*sayawewan*' : '/emojis/crazymonkz/14.gif',
        '*galitnamatsing*' : '/emojis/crazymonkz/15.gif',
        '*himatsing*' : '/emojis/crazymonkz/16.gif',
        '*pabebematsing*' : '/emojis/crazymonkz/17.gif',
        '*please*' : '/emojis/crazymonkz/18.gif',
        '*patakasnamatsing*' : '/emojis/crazymonkz/19.gif',
        '*ikawha*' : '/emojis/crazymonkz/20.gif',
        '*sukona*' : '/emojis/crazymonkz/21.gif',
        '*yogaaa*' : '/emojis/crazymonkz/22.gif',
        '*stretching*' : '/emojis/crazymonkz/23.gif',
        '*flyingkiss*' : '/emojis/crazymonkz/24.gif',
        '*boredmatsing*' : '/emojis/crazymonkz/25.gif',
        '*nononono*' : '/emojis/crazymonkz/26.gif',
        '*nagsusubaybay*' : '/emojis/crazymonkz/27.gif',
        '*nononono2*' : '/emojis/crazymonkz/28.gif',
        '*tuwangtuwa*' : '/emojis/crazymonkz/29.gif',
        '*tsismis*' : '/emojis/crazymonkz/30.gif',
        '*monghe*' : '/emojis/crazymonkz/31.gif',
        '*bulaga*' : '/emojis/crazymonkz/32.gif',
        '*yoyohe*' : '/emojis/crazymonkz/33.gif',
        '*lagariin*' : '/emojis/crazymonkz/34.gif',
        '*boomsabog*' : '/emojis/crazymonkz/35.gif',
        //Rabbits
		'*rabziyakin*' : '/emojis/crazyrabz/1.gif',
		'*rabzbyebyeiyak*' : '/emojis/crazyrabz/2.gif',
		'*rabzgising*' : '/emojis/crazyrabz/3.gif',
		'*rabzswinging*' : '/emojis/crazyrabz/4.gif',
		'*rabzdancingduo*' : '/emojis/crazyrabz/5.gif',
		'*rabzikotikot*' : '/emojis/crazyrabz/6.gif',
		'*rabzlalawala*' : '/emojis/crazyrabz/7.gif',
		'*rabzsilenteating*' : '/emojis/crazyrabz/8.gif',
		'*rabztotheleft*' : '/emojis/crazyrabz/9.gif',
		'*rabzboomlala*' : '/emojis/crazyrabz/10.gif',
		'*rabztothewindow*' : '/emojis/crazyrabz/11.gif',
		'*rabzsungit*' : '/emojis/crazyrabz/12.gif',
		'*rabzuntogpader*' : '/emojis/crazyrabz/13.gif',
		'*rabzwattodo*' : '/emojis/crazyrabz/14.gif',
		'*rabzflyingkiss*' : '/emojis/crazyrabz/15.gif',
		'*rabzpacool*' : '/emojis/crazyrabz/16.gif',
		'*rabzmiming*' : '/emojis/crazyrabz/17.gif',
		'*djrabz*' : '/emojis/crazyrabz/18.gif',
		'*sexyrabz*' : '/emojis/crazyrabz/19.gif',
		'*curoiusrabz*' : '/emojis/crazyrabz/20.gif',
		'*crazyrabz*' : '/emojis/crazyrabz/21.gif',
		'*rabztadada*' : '/emojis/crazyrabz/22.gif',
		'*goodnight*' : '/emojis/crazyrabz/23.gif',
		'*rabzhagikgik*' : '/emojis/crazyrabz/24.gif',
		'*pangasarrabz*' : '/emojis/crazyrabz/25.gif',
		'*nabaliwnarabz*' : '/emojis/crazyrabz/26.gif',
		'*rabzyoga*' : '/emojis/crazyrabz/27.gif',
		'*rabzkarate*' : '/emojis/crazyrabz/28.gif',
		'*rabzpawisan*' : '/emojis/crazyrabz/29.gif',
		'*rabzrobot*' : '/emojis/crazyrabz/30.gif',
		'*rabzbusted*' : '/emojis/crazyrabz/31.gif',
		'*rabzdacinglol*' : '/emojis/crazyrabz/32.gif',
		'*rabzkulangot*' : '/emojis/crazyrabz/33.gif',
		'*rabzaralpa*' : '/emojis/crazyrabz/34.gif',
		'*rabzdown*' : '/emojis/crazyrabz/35.gif'


      }
    }else{
      var smileys = {
        //basics
        '*wink*' : '/emojis/basic/1.png',
        '*love*' : '/emojis/basic/2.png',
        '*kissed*' : '/emojis/basic/3.png',
        '*kissing*' : '/emojis/basic/4.png',
        '*tokiss*' : '/emojis/basic/5.png',
        '*shykiss*' : '/emojis/basic/6.png',
        '*bleh*' : '/emojis/basic/7.png',
        '*crossedbleh*' : '/emojis/basic/8.png',
        '*sabogbleh*' : '/emojis/basic/9.png',
        '*shocked*' : '/emojis/basic/10.png',
        '*pilitsmile*' : '/emojis/basic/11.png',
        '*sadding*' : '/emojis/basic/12.png',
        '*relaxed*' : '/emojis/basic/13.png',
        '*really*' : '/emojis/basic/14.png',
        '*saddest*' : '/emojis/basic/15.png',
        '*confused*' : '/emojis/basic/16.png',
        '*tocry*' : '/emojis/basic/17.png',
        '*crylaugh*' : '/emojis/basic/18.png',
        '*crying*' : '/emojis/basic/19.png',
        '*antok*' : '/emojis/basic/20.png',
        '*problemado*' : '/emojis/basic/21.png',
        '*takot*' : '/emojis/basic/22.png',
        '*kabadongtawa*' : '/emojis/basic/23.png',
        '*stress*' : '/emojis/basic/24.png',
        '*bayan*' : '/emojis/basic/25.png',
        '*anobayan*' : '/emojis/basic/26.png',
        '*takotnatakot*' : '/emojis/basic/27.png',
        '*gulatnagulat*' : '/emojis/basic/28.png',
        '*galit*' : '/emojis/basic/29.png',
        '*sobranggalit*' : '/emojis/basic/30.png',
        '*inis*' : '/emojis/basic/31.png',
        '*aburido*' : '/emojis/basic/32.png',
        '*natawa*' : '/emojis/basic/33.png',
        '*nandila*' : '/emojis/basic/34.png',
        '*ayaw*' : '/emojis/basic/35.png',
        '*cool*' : '/emojis/basic/36.png',
        '*inantok*' : '/emojis/basic/37.png',
        '*xxgulat*' : '/emojis/basic/38.png',
        '*xxgulatnagulat*' : '/emojis/basic/39.png',
        '*dialamsasabihin*' : '/emojis/basic/40.png',
        '*tameme*' : '/emojis/basic/41.png',
        '*natameme*' : '/emojis/basic/42.png',
        '*evillaugh*' : '/emojis/basic/43.png',
        '*evilface*' : '/emojis/basic/44.png',
        '*kagulat*' : '/emojis/basic/45.png',
        '*ngtingpeke*' : '/emojis/basic/46.png',
        '*zipped*' : '/emojis/basic/47.png',
        '*feelingewan*' : '/emojis/basic/48.png',
        '*halanagulat*' : '/emojis/basic/49.png',
        '*faceless*' : '/emojis/basic/50.png',
        '*ngitinganghel*' : '/emojis/basic/51.png',
        '*talaga*' : '/emojis/basic/52.png',
        '*ayewan*' : '/emojis/basic/53.png',
        '*like*' : '/emojis/basic/54.png',
        '*dislike*' : '/emojis/basic/55.png',
        '*okay*' : '/emojis/basic/56.png',
        '*suntok*' : '/emojis/basic/57.png',
        '*laban*' : '/emojis/basic/58.png',
        '*peace*' : '/emojis/basic/59.png',
        '*kaway*' : '/emojis/basic/60.png',
        '*puso*' : '/emojis/basic/61.png',
        '*wasaknapuso*' : '/emojis/basic/62.png',
        '*kissmark*' : '/emojis/basic/63.png',
		'*ingatpo*' : '/emojis/ingat.png',
		'*welcomeback*' : '/emojis/welcome,png'
      }
    }

    for(var prop in smileys) {
      for(var x=0;x<=msg.length;x++) {
		if(prop=="*ingatpo*" || prop=="*welcomeback*"){
        	msg = msg.replace(prop,'<img src="'+smileys[prop]+'" class="smlys1">');
		}else{
        	msg = msg.replace(prop,'<img src="'+smileys[prop]+'" class="smlys1" width="35px">');
		}
      }
    }

    return msg;
  },

  artWork : function(){
    var query_title = $("p.song > span").text();
    $.ajax({
      url: 'http://itunes.apple.com/search?term='+ query_title +'&country=PH&media=music&limit=1',
      dataType: 'jsonp',
      success: function(json) {
        if(json.results.length === 0) {
          $('img.track-img').attr('src', 'http://static.gigwise.com/gallery/5209864_8262181_JasonDeruloTatGall.jpg');
          return;
        }
        var artworkURL = json.results[0].artworkUrl100;
        $('img.track-img').attr('src', artworkURL);
        setTimeout("inew.artWork()", 3000);
        }
    });
    $('img.track-img').attr('title', 'Search "'+query_title+'" on Shazam Music.');
  },

  onlines : function(){
    $.ajax({
      type : 'POST',
      url : '/tools/onlines',
      dataType : 'JSON',
      success : function(res){
        if(res.onlines.length > 0){
          $('div.olbody').html('');
            for(var i=0;i<res.onlines.length;i++){
              var x = '<div class="media">';
                  x = x +'<div class="media-left">';
                    x = x +'<a href="/profile/'+res.onlines[i].social_id+'"><img class="media-object" src="'+res.onlines[i].avatar+'" alt="'+res.onlines[i].name+'" width="20px" height="20px"></a>';
                  x = x +'</div>';
                  x = x +'<div class="media-body">';
                  x = x +'<h4 class="media-heading">'+res.onlines[i].name+'</h4>';
                  x = x +'</div>';
                x = x +'</div>';
               $('div.olbody').prepend(x);
            }
        }else{
          $('div.olbody').html('');
          $('div.olbody').html('No Online Users');
        }
      }
    });
    setTimeout("inew.onlines()", 30000);
  },

  djob : function() {
    $.ajax({
      type : 'POST',
      url : '/tools/djob',
      dataType : 'JSON',
      success : function(res){
        if(res.djob.dj_status==1){
          $('.ob-img').attr('src','https://graph.facebook.com/'+res.djob.dj_social_id+'/picture');
          $('.ob-name').html(res.djob.dj_name);
        }else{
          $('.ob-img').attr('src','/assetses/img/logo.png');
          $('.ob-name').html('Auto Tune');
        }
      }
    });
    setTimeout("inew.djob()", 10000);
  },
	
	sc_details : function(){
		$.ajax({
			type : 'POST',
			url : '/shout/details.php',
			dataType : 'JSON',
			success : function(res){
				$('p.song').html(res.SONGTITLE);
				$('p.listeners span').html(res.CURRENTLISTENERS);
			}
		});
		setTimeout("inew.sc_details()",5000);
	}
}
		