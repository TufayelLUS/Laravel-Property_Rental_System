@extends('layouts.admin')

@section('page_title')
All Posts
@endsection

@section('page_body')
<div class="container">
	<h1 class="py-2">All Properties</h1>
	<div style="overflow-x: auto;">
	<table width="100%" class="table table-striped table-bordered text-center">
		<tr >
			<th>User Name</th>
			<th>Property Link</th>
			<th>Created At</th>
			<th>Action</th>
		</tr>
		@foreach($listings as $listing)
		<tr>
			<td>{{App\User::find($listing->user_id)->name}}</td>
			<td><a target="_blank" class="text-primary" href="{{url('property/' . $listing->id)}}" >View Property</a></td>
			<td>{{$listing->created_at}}</td>
			<td><button onclick="triggerDelete({{$listing->id}})" class="btn btn-sm btn-danger">Delete</button></td>
		</tr>
		@endforeach
	</table>
	</div>
</div>
<div><a href="{{ $listings->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$listings->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->previousPageUrl() }}">{{ $listings->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $listings->currentPage() }}</span>
	@if($listings->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $listings->nextPageUrl() }}">{{ $listings->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $listings->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
	<script type="text/javascript">
		function triggerDelete(id)
		{
			$('#delete_id').attr('onclick', 'location.href="delete_property/' + id + '"');
			$('#exampleModalCenter').modal('show');
		}
	</script>
@endsection
@section('extra_headers')
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body font-weight-bold text-center">
      	You are about to delete a property listing. Are you sure?
      	<button id="delete_id" class="mt-2 btn btn-sm btn-danger">Confirm</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection