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
            <form action="{{ route('comment', [$article->id]) }}" method="post" id="form">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Message subject"
                           value="{{ old('title') }}">
                    <span class="text-danger" id="title-error"></span>
                </div>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <div class="form-group">
                    <textarea placeholder="Message" name="content" class="form-control"
                              id="content">{{ old('content') }}</textarea>
                    <span class="text-danger" id="content-error"></span>
                </div>

                @if($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                @endif
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <span class="text-success" id="success-response"></span>

        </div>
        <div class="mb-5" id="article-comment">
            @include('article_comment')
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

        $("#form").submit(function (e) {
            e.preventDefault()
            let title = $("#title").val()
            let content = $("#content").val()
            if (title.length === 0) {
                $("#title-error").text('The title field is required.')
            }
            if (content.length === 0) {
                $("#content-error").text('The content field is required.')
            }
            if (title.length > 0 && content.length > 0) {
                $.ajax({
                    url: "{{ route('comment', [$article->id]) }}",
                    method: "POST",
                    data: {title: title, content: content, _token: "{{ csrf_token() }}"},
                    success: function (result) {
                        if (result.data) {
                            $("#article-comment").html(result.data);
                        }
                        if (result.message) {
                            $("#success-response").text(result.message);
                        }
                        $("#title").val('')
                        $("#content").val('')
                        setTimeout(function () {
                            $("#success-response").text('');
                        }, 1000)
                    },
                    error: function (e) {
                        let resData = e.responseJSON
                        if (resData.errors) {
                            if (resData.errors.title) {
                                $("#title-error").text(resData.errors.title.join(', '))
                            }
                            if (resData.errors.content) {
                                $("#content-error").text(resData.errors.content.join(', '))
                            }
                        }
                    }
                });
            }
            setTimeout(function () {
                $("#title-error").text('')
                $("#content-error").text('')
            }, 5000)

        });
    </script>
@endsection
