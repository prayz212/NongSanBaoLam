<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReplyRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function addComment(CommentRequest $request) {
        Comment::create([
            'name' => $request->name,
            'content' => $request->content,
            'product_id' => $request->id
        ]);

        return redirect()->back();
    }

    public function replyComment(ReplyRequest $request) {
         Comment::create([
             'name' => $request->name ?? 'Nông sản Bảo Lâm',
             'content' => $request->content,
             'product_id' => $request->product_id,
             'reply_to' => $request->comment_id
         ]);

        return redirect()->back();
    }
}
