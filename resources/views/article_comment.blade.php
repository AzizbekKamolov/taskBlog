@foreach($comments as $comment)
    <hr>
    <i class="fa fa-user-circle"></i><span
        style="font-size: 24px;font-weight: bold;">{{ $comment->title }}</span>
    <p>{{ $comment->content }}</p>
    <p style="text-align: end">{{ \Illuminate\Support\Carbon::parse($comment->created_at)->longRelativeDiffForHumans() }}</p>
@endforeach
