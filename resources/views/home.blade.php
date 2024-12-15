@extends('layout')
@section('content')
    <div class="container">
        <div class="row mt-5 mb-5">
            @foreach($articles as $article)
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="card mb-3" >
                        <img class="card-img-top" src="{{ $article->photo }}" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('article', [$article->slug]) }}">{{ $article->title }}</a>
                            </h5>
                            <p class="card-text">{{ $article->short_content }}</p>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fa fa-eye"></i>
                                    <span id="showed">{{ $article->showed }}</span>
                                </div>
                                <div>
                                    @if($article->isLiked)
                                        <i class="fa fa-heart" style="cursor: pointer"></i>
                                    @else
                                        <i class="fa fa-regular fa-heart" style="cursor: pointer"></i>
                                    @endif
                                </div>

                            </div>
{{--                            <a href="#" class="btn btn-primary">Go somewhere</a>--}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mb-5">{{ $articles->links() }}</div>

    </div>
@endsection
