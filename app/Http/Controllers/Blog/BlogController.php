<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogRequest;
use App\Models\Blog\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('tags')->latest()->paginate(10);;
        return view('blog.index', compact('blogs'));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $data['status'] = 1;

        $blog = Blog::create($data);

        if ($request->tags) {
            $tagArray = $request->tags;
            $tags =  explode(',', $tagArray[0]);
            foreach ($tags as $tag) {
                $blog->tags()->create(['tags' => trim($tag)]);
            }
        }

        return response()->json(['message' => 'Blog post created successfully!']);
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        // Update Tags
        if ($request->tags) {
            $tagArray = $request->tags;
            $tags = explode(',', $tagArray[0]);

            $blog->tags()->delete(); // Delete old tags and insert new ones
            foreach ($tags as $tag) {
                $blog->tags()->create(['tags' => trim($tag)]);
            }
        }

        return response()->json(['message' => 'Blog post updated successfully!']);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json(['message' => 'Blog post deleted successfully!']);
    }

    public function toggleStatus(Blog $blog)
    {
        $blog->update(['status' => !$blog->status]);
        return response()->json(['message' => 'Status updated successfully!']);
    }
}
