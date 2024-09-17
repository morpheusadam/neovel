<?php

namespace Modules\CMS\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\CMS\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'messages' => __('CMS::messages.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json([
            'messages' => __('CMS::messages.show'),
        ]);
    }

    /**
     * Validate the post creation request.
     */
    public function validatePostData(Request $request) // تغییر به public
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'textcontent' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
    }

    /**
     * Save the post to the database.
     */
    public function savePost(Request $request) // تغییر به public
    {
        return Post::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'textcontent' => $request->textcontent,
        ]);
    }

    /**
     * Handle the post creation request.
     */
    public function store(Request $request)
    {
        $validationResponse = $this->validatePostData($request);
        if ($validationResponse) {
            return $validationResponse;
        }

        try {
            $post = $this->savePost($request);
            return response()->json($post, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while creating the post.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
