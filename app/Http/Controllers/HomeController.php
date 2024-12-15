<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Filters\Article\ArticleFilter;
use App\Http\Requests\CommentRequest;
use App\Models\ArticleModel;
use App\Models\CommentModel;
use App\Models\TagModel;
use App\Services\CommentService;
use App\Services\ReactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected CommentService  $commentService,
        protected ReactionService $reactionService,
    )
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $articles = ArticleModel::query()->with('isLiked')->paginate(6);
        return view('home', compact('articles'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function articles(Request $request): View
    {
        $tags = TagModel::query()->get();

        $filters[] = ArticleFilter::getRequest($request);
        $articles = ArticleModel::applyEloquentFilters($filters)->with('isLiked')->paginate(10);

        return view('articles', compact('articles', 'tags'));
    }

    /**
     * @param string $slug
     * @return View
     */
    public function article(string $slug): View
    {
        $article = ArticleModel::query()
            ->with(['tags', 'isLiked'])
            ->where('slug', '=', $slug)
            ->firstOrFail();
        $comments = CommentModel::query()
            ->where('article_id', '=', $article->id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('article', compact('article', 'comments'));
    }

    /**
     * @param CommentRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function comment(CommentRequest $request, int $id): RedirectResponse
    {
        $article = ArticleModel::query()
            ->where('id', '=', $id)
            ->firstOrFail();
        $this->commentService->storeComment($article->id, $request->validated('title'), $request->validated('content'));
        return redirect()->route('article', [$article->slug])->with('success', 'Successfully');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function like(Request $request): JsonResponse
    {
        $article = ArticleModel::query()
            ->where('id', '=', $request->get('article_id'))
            ->firstOrFail();
        if ($this->reactionService->checkLikedReaction($request->ip(), $article->id)) {
            $article->update([
                'liked' => ++$article->liked
            ]);
        } else {
            $article->update([
                'liked' => --$article->liked
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Successfully",
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $article = ArticleModel::query()
            ->where('id', '=', $request->get('article_id'))
            ->firstOrFail();

        if ($this->reactionService->checkShowedReaction($request->ip(), $article->id)) {
            $article->update([
                'showed' => ++$article->showed
            ]);
        }

        return response()->json([
            "status" => true,
            "data" => $article->showed,
            "message" => "Successfully",
        ]);
    }


}
