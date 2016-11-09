@extends('admin.app')

@section('content')

<div class="container-fluid db-main">

    <section id="djs">
      <div class="row no-gutters">
		{{-- Banners --}}
      	<div class="col-md-4">
      		<div class="panel" id="db-panel">
      			<div class="panel-heading">
      				Banner <a class="pull-right btn btn-primary"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Banner List</a>
					<div style="clear:both"></div>
      			</div>
      			<div class="panel-body">
					<form class="bannerForm" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label class="control-label">Upload Banner : </label>
							<input type="file" name="bannerfile" placeholder="Image here." required>
						</div>
						<button type="submit" class="btn btn-success">
							Upload
						</button>
					</form>
				</div>
			</div>
		  </div>
		{{-- Fansigns --}}
      	<div class="col-md-4" style="display:none">
      		<div class="panel" id="db-panel">
      			<div class="panel-heading">
      				Fansigns <a class="pull-right btn btn-primary"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Fansigns List</a>
					<div style="clear:both"></div>
      			</div>
      			<div class="panel-body">
					<form class="bannerForm" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label class="control-label">Upload New Fansigns : </label>
							<input type="file" name="bannerfile" placeholder="Image here." required>
						</div>
						<button type="submit" class="btn btn-success">
							Upload
						</button>
					</form>
				</div>
			</div>
		  </div>
		{{-- Wall Of Fame --}}
      	<div class="col-md-4" style="display:none">
      		<div class="panel" id="db-panel">
      			<div class="panel-heading">
      				Wall Of Fame
					<div style="clear:both"></div>
      			</div>
      			<div class="panel-body">
					<form class="bannerForm" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label class="control-label">Change W-O-F : </label>
							<input type="file" name="bannerfile" placeholder="Image here." required>
						</div>
						<button type="submit" class="btn btn-success">
							Upload
						</button>
					</form>
				</div>
			</div>
		  </div>

		</div>
	</section>

</div>

@endsection