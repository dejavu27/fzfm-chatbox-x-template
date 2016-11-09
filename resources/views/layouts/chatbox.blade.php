                                <div class="col-lg-12" style="padding:0px">
                                    <form class="sendchat">
                                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                        <input type="hidden" name="social_id" value="{{ Auth::user()->social_id }}">
                                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                        <input type="hidden" name="social_type" value="{{ Auth::user()->social_type }}">
                                        <input type="hidden" name="points" value="{{ Auth::user()->points }}">
                                        <input type="hidden" name="acctype" value="{{ Auth::user()->acctype }}">
                                        <input type="hidden" name="avatar" value="{{ Auth::user()->avatar }}">
                                        <input type="hidden" name="color" value="{{ Auth::user()->color}}">
                                        <input type="hidden" name="neon" value="{{ Auth::user()->neon}}">
                                        <input type="hidden" name="replto">
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default dropdown-toggle text-butts" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="refresh" type="button" style="margin: 0px;cursor: pointer;"><i class="fa fa-refresh" aria-hidden="true"></i> Refresh</a></li>
                                                        @if (Auth::user()->isAdmin > 0)
                                                        <li ><a type="button" onclick="inew.addAnnc('{{ Auth::user()->name }}')" style="margin: 0px;cursor: pointer;"><i class="fa fa-bullhorn" aria-hidden="true"></i> Announce</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </span>
                                            <input type="text" required autocomplete="off" class="form-control text-box" name="msg" placeholder="Send a message....">
                                            <span class="input-group-btn addreplyer">
                                                <button class="btn btn-default text-butts" type="submit" data-toggle="tooltip" data-placement="top" title="Send chat"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                                                <button class="btn btn-default text-butts" type="button" data-toggle="tooltip" data-placement="top" title="Emoticons"><i class="fa fa-smile-o" aria-hidden="true"></i></button>
                                            </span>
                                        </div>
                                    </form>
                                    <div class="smilys" style="width:100%;height:auto;position:absolute;top:30px;left:0px;right:0px;background:#eee;padding:10px;z-index:99999;display:none;color:#222">
                                      <?php
                                        $basicsdir = "/emojis/basic";
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
                                        for($i=1;$i < 64; $i++){
                                          echo "<img src='".$basicsdir."/".$i.".png' width='30px' title='".$descbasic[$i]."' class='img-smilys'>";
                                        }
                                      ?>
                                      <br>
                                      <?php 
                                      	$permittedall = array(111,1,2,3,4,5,6,7,8,9,12,10);
                                      	$prempermitted = array(13,14,15,16,11);
                                      ?>
                                      <?php
                                        $monzdir = "/emojis/crazymonkz";
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
                                        if(in_array(Auth::user()->acctype,$permittedall)){
	                                        for($i=1;$i < 36; $i++){
	                                          echo "<img src='".$monzdir."/".$i.".gif' width='30px' title='".$descmonkz[$i]."' class='img-smilys'>";
	                                        }
	                                        echo "<br>";
                                        }
                                      ?>
                                      <?php
										$descrabz = array(
											'',
											'*rabziyakin*',
											'*rabzbyebyeiyak*',
											'*rabzgising*',
											'*rabzswinging*',
											'*rabzdancingduo*',
											'*rabzikotikot*',
											'*rabzlalawala*',
											'*rabzsilenteating*',
											'*rabztotheleft*',
											'*rabzboomlala*',
											'*rabztothewindow*',
											'*rabzsungit*',
											'*rabzuntogpader*',
											'*rabzwattodo*',
											'*rabzflyingkiss*',
											'*rabzpacool*',
											'*rabzmiming*',
											'*djrabz*',
											'*sexyrabz*',
											'*curoiusrabz*',
											'*crazyrabz*',
											'*rabztadada*',
											'*goodnight*',
											'*rabzhagikgik*',
											'*pangasarrabz*',
											'*nabaliwnarabz*',
											'*rabzyoga*',
											'*rabzkarate*',
											'*rabzpawisan*',
											'*rabzrobot*',
											'*rabzbusted*',
											'*rabzdacinglol*',
											'*rabzkulangot*',
											'*rabzaralpa*',
											'*rabzdown*'
										);
										$rabzdir = "/emojis/crazyrabz";
					
                                        if(in_array(Auth::user()->acctype,$permittedall) || in_array(Auth::user()->acctype,$prempermitted)){
	                                        for($x=1;$x< 36; $x++){
	                                          echo "<img src='".$rabzdir."/".$x.".gif' title='".$descrabz[$x]."' width='30px' class='img-smilys'>";
	                                        }
	                                        echo "<br>";
                                        }
                                      ?>
                                      <?php
                                        $basicsdir = "/emojis/onionheadz";
                                        for($i=1;$i < 36; $i++){
                                          echo "<img src='".$basicsdir."/".$i.".gif' width='30px' class='img-smilys' style='display:none'>";
                                        }
                                      ?>
                                      <?php
                                        $basicsdir = "/emojis/panda";
                                        for($i=1;$i < 36; $i++){
                                          echo "<img src='".$basicsdir."/".$i.".gif' width='30px' class='img-smilys' style='display:none'>";
                                        }
                                      ?>
                                      <img src='/emojis/ingat.png' title='*ingatpo*' class='img-smilys'>
                                      <img src='/emojis/welcome.png' title='*welcomeback*' class='img-smilys'>
                                    </div>
                                    <div class="chat-msgbox" style="width: 100%;min-height:550px;max-height: 550px;overflow: auto;overflow-x:hidden;position: relative;z-index: 0;">
                                        <div class="chatloadhere" style="padding: 0px;margin: 0px"></div>
                                        <div class="alert alert-warning load-more" style="display:none;cursor: pointer;text-align: center" onclick="inew.getMoreMsg(inew.index.firstid)">Load more messages</div>
                                    </div>
                                </div>
                                <div class="loader" style="width: 100%;height: 100%;background: #fff;position: absolute;top: 0;left: 0;right: 0;bottom: 0;z-index: 20;text-align: center"><center><img src="{{ URL::to('/assetses/img/loading.gif') }}"></center></div>