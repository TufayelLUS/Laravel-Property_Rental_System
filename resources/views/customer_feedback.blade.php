@extends('layouts.admin')

@section('page_title')
All Customer Feedback
@endsection

@section('page_body')
<div class="container">
	<h1>All Customer Feedback</h1>
	<div style="overflow-x: auto;">
	<table class="table table-bordered table-striped" width="100%">
		<tr>
			<th width="20%">Name</th>
			<th width="20%">Email</th>
			<th width="20%">Subject</th>
			<th width="20%">Message</th>
			<th width="">Action</th>
		</tr>
		@foreach($feedbacks as $feedback)
		<tr>
			<th>{{$feedback->name}}</th>
			<th>{{$feedback->email}}</th>
			<th>{{$feedback->subject}}</th>
			<th>{{$feedback->message}}</th>
			<th><button onclick="showModal({{$feedback->id}})" class="btn btn-sm btn-danger">Delete</button></th>
		</tr>
		@endforeach
	</table>
	</div>
	<div><a href="{{ $feedbacks->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$feedbacks->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $feedbacks->previousPageUrl() }}">{{ $feedbacks->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $feedbacks->currentPage() }}</span>
	@if($feedbacks->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $feedbacks->nextPageUrl() }}">{{ $feedbacks->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $feedbacks->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
</div>
<script type="text/javascript">
	function showModal(id)
	{
		$('#delete_id').attr('onclick', 'location.href="customer_feedback/delete/' + id + '"');
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
      	You are about to delete a customer feedback. Are you sure?
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