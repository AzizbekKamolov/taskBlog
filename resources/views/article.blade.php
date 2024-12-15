@extends('layout')
@section('content')
    <div class="container">
        <div class="mt-5 mb-5">
            <h2>{{ $article->title }}</h2>

            <div>
                @if($article->isLiked)
                    <i id="like" class="fa fa-heart" style="cursor: pointer"></i>
                @else
                    <i id="like" class="fa fa-regular fa-heart" style="cursor: pointer"></i>
                @endif
                <i class="fa fa-eye"></i>
                <span id="showed">{{ $article->showed }}</span>
            </div>
            <br>
            @foreach($article->tags as $tag)
                <span class="badge badge-secondary">{{ $tag->name }}</span>
            @endforeach
            <br>
            <br>
            <p>{{ $article->short_content }}</p>
            <p>{{ $article->content }}</p>

            <hr>
            <h3>Leave a Comment</h3>
            @if(session()->has('success'))
                <span class="text-success">{{ session('success') }}</span>
            @endif
            <form action="{{ route('comment', [$article->id]) }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Message subject"
                           value="{{ old('title') }}">
                </div>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <div class="form-group">
                    <textarea placeholder="Message" name="content" class="form-control">{{ old('content') }}</textarea>
                </div>
                @if($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
        <div class="mb-5">
            @foreach($comments as $comment)
                <hr>
                <i class="fa fa-user-circle"></i><span
                    style="font-size: 24px;font-weight: bold;">{{ $comment->title }}</span>
                <p>{{ $comment->content }}</p>
                <p style="text-align: end">{{ \Illuminate\Support\Carbon::parse($comment->created_at)->longRelativeDiffForHumans() }}</p>
            @endforeach
        </div>

    </div>
@endsection
@section('script')
    <script>
        let like = document.getElementById('like');
        let article_id = {{ $article->id }};
        like.addEventListener('click', function (e) {
            $.ajax({
                url: "{{ route('like') }}",
                method: "POST",
                data: {article_id: article_id, _token: "{{ csrf_token() }}"},
                success: function (result) {
                    $("#like").toggleClass('fa-regular');
                }
            });
        });
        setTimeout(function () {
            $.ajax({
                url: "{{ route('show') }}",
                method: "POST",
                data: {article_id: article_id, _token: "{{ csrf_token() }}"},
                success: function (result) {
                    $("#showed").text(result.data);
                }
            });
        }, 5000)
    </script>
@endsection
