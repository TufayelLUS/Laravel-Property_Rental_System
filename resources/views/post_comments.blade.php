@extends('layouts.user')

@section('page_title')
Comments on My Posts
@endsection

@section('page_body')
<div class="container my-4">
	<h3 class="mb-4">Comments on your property listing</h3>
	<div class="text-left font-weight-normal">
		@foreach($comments as $comment)
			<blockquote onclick="location.href='property/{{$comment->prop_id}}#comment{{$comment->id}}'" onmouseenter="this.style.boxShadow='0px 0px 5px -1px black';this.style.cursor='pointer'" onmouseleave="this.style.boxShadow=''" class="blockquote border p-3" style="background-color: #dcf3fa; border-radius: 10px">
			  <p class="mb-0 font-weight-normal" style="color: #525354"><sup><i class="fas fa-quote-left" style="font-size: 10px"></i></sup> {{$comment->comment_body}} <sup><i class="fas fa-quote-right" style="font-size: 10px"></i></sup></p>
			  <footer class="blockquote-footer text-center"><b>{{App\User::find($comment->user_id)->name}}</b> in <cite title="Source Title"><b>{{App\Listing::where('id', $comment->prop_id)->first()->title}}</b></cite></footer>
			</blockquote>
		@endforeach
		@if(count($comments) == 0)
		<div class="alert alert-primary">
		There's no comment for now. Once available, it will appear here.
		</div>
		@endif
	</div>
	<div class="mt-2"><a href="{{ $comments->url(0) }}" class="btn btn-sm"><i class="fa fa-fast-backward"></i></a>
	@if(!$comments->onFirstPage())
		<a class="btn btn-sm" style="color: black" href="{{ $comments->previousPageUrl() }}">{{ $comments->currentPage()-1 }}</a>
	@endif
	<span class="h4">{{ $comments->currentPage() }}</span>
	@if($comments->hasMorePages())
		<a class="btn btn-sm" style="color: black" href="{{ $comments->nextPageUrl() }}">{{ $comments->currentPage()+1 }}</a>
	@endif
	<a href="?page={{ $comments->lastPage() }}" class="btn btn-sm"><i class="fa fa-fast-forward"></i></a></div>
</div>
@endsection