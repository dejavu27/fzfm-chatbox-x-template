@extends('admin.app')

@section('content')

<div class="container-fluid db-main">

    <section id="djs">
      <div class="row no-gutters">
      	<div class="col-md-12">
      		<div class="panel" id="db-panel">
      			<div class="panel-heading">
      				User List
      			</div>
      			<div class="panel-body">
					<table id="djtable" class="display">
					    <thead>
					        <tr>
					        	<th style="display:none">&nbsp;</th>
					        	<th>&nbsp;</th>
					            <th style="text-align:center">NAME</th>
					            <th style="text-align:center">ACCOUNT TYPE</th>
					            <th style="text-align:center">POINTS</th>
					            <th style="text-align:center">SIGN TIME</th>
					            <th style="text-align:center">LAST ACTIVITY</th>
					            <th style="text-align:center">IP ADDRESS</th>
					            <th style="text-align:center">ACTIONS</th>
					        </tr>
					    </thead>
					    <tbody>
					    	<?php
					    		$getinfo = DB::table('users')->orderBy('id','ASC');
					    	?>
					    	@if($getinfo->count() > 0)
					    		@foreach($getinfo->get() as $b)
					    		@if($b->name == "FM BOT")

					    		@else
						        <tr id="user-{{ $b->id }}">
						        	<td style="display:none">{{ $b->id }}</td>
						        	<td><img src="{{ $b->avatar }}" width="30px"></td>
						            <td style="font-weight:bolder" id="user-name">{{ $b->name }}</td>
						            <td class="users_ranks" id="{{ $b->acctype }}"></td>
						            <td id="user-points">{{ $b->points }}</td>
						            <td>{{ date('M d, Y h:i:s a',strToTime($b->sign_time)) }}</td>
						            <td>{{ date('M d, Y h:i:s a',$b->last_request_time) }}</td>
						            <td>{{ $b->ip_address }}</td>
						            <td>
						            	<center>
						            		<a class="btn btn-xs btn-primary" id="{{ $b->id }}" onclick="inew.editUser(this.id,'{{ $b->name }}','{{ $b->acctype }}','{{ $b->points }}','{{ $b->color }}','{{ $b->neon }}','{{ $b->avatar }}','{{ $b->social_id }}')">EDIT</a>
						            	</center>
						            </td>
						        </tr>
						        @endif
						        @endforeach
					    	@endif
					    </tbody>
					</table>
      			</div>
      		</div>
      	</div>
      </div>
    </section>

</div>

@endsection