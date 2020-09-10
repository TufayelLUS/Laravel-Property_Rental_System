@extends('layouts.admin')

@section('page_title')
All Users
@endsection

@section('page_body')
<div class="container">
	<h1 class="my-2">All Registered Users ({{ App\User::count()}})</h1>
	<div style="overflow-x: auto;">
		<table class="table table-striped table-bordered" width="100%">
			<tr>
				<th class="text-center" width="14%">ID</th>
				<th width="5%">User Name</th>
				<th width="19%">Email Address</th>
				<th width="19%">Phone Number</th>
				<th width="19%">Registered On</th>
				<th width="19%">Verified</th>
				<th width="19%">Action</th>
			</tr>
			@foreach($users as $user)
			<tr class="font-weight-normal">
				<td class="text-center">{{$user->id}}</td>
				<td id="{{$user->id}}_name">{{$user->name}}</td>
				<td id="{{$user->id}}_email">{{$user->email}}</td>
				<td id="{{$user->id}}_phone">{{$user->phone}}</td>
				<td>{{$user->created_at}}</td>
				<td id="{{$user->id}}_verified">{{$user->is_email_verified == "True" ? "Verified" : "Not Verified"}}</td>
				<td id="{{$user->id}}_actions"><button onclick="trigger_edit({{ $user->id }}, '{{ csrf_token() }}')" class="btn btn-sm btn-primary">Edit</button> <button onclick="trigger_delete({{ $user->id }}, '{{ csrf_token() }}')" class="btn btn-sm btn-danger">Delete</button>
				
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<div><a href="{{ $users->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$users->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $users->previousPageUrl() }}">{{ $users->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $users->currentPage() }}</span>
	@if($users->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $users->nextPageUrl() }}">{{ $users->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $users->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
</div>
<script type="text/javascript">
	function trigger_edit(id, token)
	{
		var old_name = $('#' + id + "_name").text();
		var old_email = $('#' + id + "_email").text();
		var old_phone = $('#' + id + "_phone").text();
		var verified = $('#' + id + "_verified").text();
		var final_html = "<form method='POST'><input type='hidden' name='_token' value='" + token + "'>";
		final_html += "<b>User Name:</b><input placeholder='User Name' class='form-control mb-2' type='text' value='" + old_name + "' name='name' required>";
		final_html += "<b>Email Address:</b><input placeholder='Email' class='form-control mb-2' type='email' value='" + old_email + "' name='email' required>";
		final_html += "<b>Phone:</b><input placeholder='Phone No.' class='form-control mb-2' type='text' value='" + old_phone + "' name='phone' required>";
		if (verified == "Verified") {
			final_html += "<b>Verification Status:</b><br><input class='mb-2' type='radio' value='True' name='verified' checked> Verified";
			final_html += "<br><input class='mb-2' type='radio' value='False' name='verified'> Not Verified";
		}
		else
		{
			final_html += "<b>Verification Status:</b><br><input class='mb-2' type='radio' value='True' name='verified'> Verified";
			final_html += "<br><input class='mb-2' type='radio' value='False' name='verified' checked> Not Verified";
		}
		final_html += "<input type='hidden' name='id' value=" + id + ">";
		final_html += "<div class='text-center'><button type='submit' class='btn btn-success'>Update Info</button></div></form>";
		$('#user_edit_form').html(final_html);
		$('#user_edit_modal_title').html("Update User Information");
		$('#user_edit_modal').modal('show');
	}
	function trigger_delete(id, token)
	{
		var final_html = "<form action='delete_user/" + id +"' method='POST'><input type='hidden' name='_token' value='" + token + "'>";
		final_html += "<div class='text-center text-danger mb-2'>Are you Sure to Delete User Account with ID " + id + "? Action cannot be reverted.</div>";
		final_html += "<div class='text-center'><button class='btn btn-danger'>Proceed</button></div></form>";
		$('#user_edit_form').html(final_html);
		$('#user_edit_modal_title').html("Delete User Information");
		$('#user_edit_modal').modal('show');
	}
</script>
@endsection
@section('extra_headers')
<!-- Modal -->
<div class="modal fade" id="user_edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="user_edit_modal_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="user_edit_form" class="modal-body font-weight-bold">
        
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
@endsection