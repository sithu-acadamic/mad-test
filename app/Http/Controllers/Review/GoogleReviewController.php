<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoogleReviewRequest;
use App\Models\Review\GoogleReview;
use Illuminate\Http\Request;

class GoogleReviewController extends Controller
{
    public function index()
    {
        $reviews = GoogleReview::orderBy('created_at', 'desc')->paginate(5);
        return view('review.index', compact('reviews'));
    }

    public function store(GoogleReviewRequest $request)
    {
        GoogleReview::create($request->validated() + ['status' => 1]);
        return response()->json(['success' => true, 'message' => 'Review added successfully!']);
    }

    public function update(GoogleReviewRequest $request, GoogleReview $review)
    {
        $review->update($request->validated());
        return response()->json(['success' => true, 'message' => 'Review updated successfully!']);
    }

    public function destroy(GoogleReview $review)
    {
        $review->delete();
        return response()->json(['success' => true, 'message' => 'Review deleted successfully!']);
    }

    public function toggleStatus(GoogleReview $review)
    {
        $review->update(['status' => !$review->status]);
        return response()->json(['success' => true, 'message' => 'Review status updated!']);
    }
}
