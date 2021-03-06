<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentController extends Controller
{
    public function index() {
        try {
            $comments = Comment::with(['product'])
                ->where('is_marked', false)
                ->where('is_deleted', false)
                ->get();

            return view('admin.comment-page')
                ->with('comments', $comments);
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function fetch() {
        try {
            $comments = Comment::with(['product'])
                ->orderBy('created_at', 'DESC')
                ->where('reply_to', 0)
                ->where('is_deleted', false)
                ->where('is_marked', false)
                ->get();

            $replies = Comment::where('is_deleted', false)
                ->where('is_marked', false)
                ->where('reply_to', '>', 0)
                ->get();
            
            return response()->json([
                'status' => 200,
                'comments' => $comments,
                'replies' => $replies
            ]);
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function mark(Request $request) {
        try {
            if ($request->id) {
                $id = $request->id;
                //update comment to done
                Comment::where('is_deleted', false)
                    ->where('id', $id)
                    ->update(['is_marked' => true]);

                //update reply comment to done too
                Comment::where('is_deleted', false)
                    ->where('reply_to', $id)
                    ->update(['is_marked' => true]);

                return response()->json([
                    'status' => 200
                ]);
            }
            else {
                return response()->json([
                    'status' => 400,
                    'redirect' => route('commentManagement')
                ]);
            }
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function delete(Request $request) {
        try {
            if ($request->id) {
                $id = $request->id;
                
                $comment = Comment::where('is_deleted', false)
                    ->find($id);

                //delete comment
                Comment::where('is_deleted', false)
                    ->where('id', $id)
                    ->update(['is_deleted' => true]);

                //delete reply comment too
                Comment::where('is_deleted', false)
                    ->where('reply_to', $id)
                    ->update(['is_deleted' => true]);

                return response()->json([
                    'status' => 200,
                    'reply' => $comment->reply_to > 0
                ]);
            }
            else {
                return response()->json([
                    'status' => 400,
                    'redirect' => route('commentManagement')
                ]);
            }
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function reply(Request $request) {
        try {
            if ($request->id && $request->content && $request->name) {
                $comment = Comment::where('is_deleted', false)
                    ->find($request->id);

                if (!$comment) {
                    return response()->json([
                        'status' => 400,
                        'messages' => 'Comment not exist to replying'
                    ]);
                }

                $reply = Comment::create([
                    'name' => $request->name,
                    'content' => $request->content,
                    'reply_to' => $request->id,
                    'product_id' => $comment->product_id,
                ]);

                return response()->json([
                    'status' => 200,
                    'data' => $reply
                ]);
            }
            else {
                return response()->json([
                    'status' => 400,
                    'messages' => 'Missing required fields'
                ]);
            }
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }

    public function edit(Request $request) {
        try {
            if ($request->id && $request->content) {
                Comment::where('is_deleted', false)
                    ->where('id', $request->id)
                    ->update(['content' => $request->content]);

                $edit = Comment::where('is_deleted', false)
                    ->find($request->id);

                return response()->json([
                    'status' => 200,
                    'data' => $edit
                ]);
            }
            else {
                return response()->json([
                    'status' => 400,
                    'messages' => 'Missing required fields'
                ]);
            }
        }
        catch(\Exception $error){
            return response()->json(['status' => 400, 'errorMessages' => $error->getMessage()], 400);
        }
    }
}
