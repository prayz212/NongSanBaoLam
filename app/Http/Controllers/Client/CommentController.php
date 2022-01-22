<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function addComment(CommentRequest $request) {
        try {
            Comment::create([
                'name' => $request->name,
                'content' => $request->content,
                'product_id' => $request->id
            ]);

            return redirect()->back();
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function replyComment(ReplyRequest $request) {
        try {
            Comment::create([
                'name' => $request->name ?? 'Nông sản Bảo Lâm',
                'content' => $request->content,
                'product_id' => $request->product_id,
                'reply_to' => $request->comment_id
            ]);

            return redirect()->back();
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }
}
