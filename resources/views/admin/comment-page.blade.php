@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4 h-100">
    <div class="row h-100">
      <div class="col-sm-12">
        <div class="__product-info-box h-100" style="padding: 16px 10px; margin: 0px">
          <div class="row fw-bold fs-3 d-flex justify-content-center mb-3">Quản lý bình luận</div>
          <div class="row d-flex justify-content-center">
            <div class="col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7 px-sm-5">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="fw-normal fs-5">Danh sách bình luận</div>
                  <a id="fetch-comments" class="shadow-none" title="Làm mới" style="cursor: pointer;" data-href="{{ route('fetchComment') }}"><i class="fas fa-sync-alt"></i></a>
                  <a id="fetching-comments" class="shadow-none" title="Đang làm mới" style="display: none"><i class="fas fa-sync fa-spin"></i></a>
                </div>
              </div>
          </div>
          <div class="d-flex justify-content-center">
            <div class="col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7 px-sm-3 blog-comment comments-scrollable">
                <div>
                    <ul class="comments comments-section" 
                        data-detele-href="{{ route('deleteComment') }}" 
                        data-marked-href="{{ route('markComment') }}" 
                        data-product-href="{{ route('productDetail', ['id' => 'productID']) }}"
                        data-edit-href="{{ route('editComment') }}" 
                        data-reply-href="{{ route('replyComment') }}" 
                        data-current-user="{{ Auth::guard('admin')->user()->fullname }}">
                        @foreach($comments as $comment)
                        @if($comment->reply_to == 0)
                        <li id="comment-{{ $comment->id }}" class="clearfix comment-row" style="position: relative" data-comment-id="{{ $comment->id }}" data-detele-href="{{ route('deleteComment') }}" data-marked-href="{{ route('markComment') }}">    
                            <img src="https://bootdey.com/img/Content/user_1.jpg" class="commentators">
                            <div class="post-comments">
                                <p class="meta">{{ $comment->name }} 
                                    <span>
                                        <span class="d-inline d-sm-none"> - </span> 
                                        <span class="d-none d-sm-inline">bình luận vào</span> 
                                        <span>
                                            <a style="text-decoration: none; color: darkblue" href="{{ route('productDetail', ['id' => $comment->product->id]) }}">{{ $comment->product->name }}</a>
                                        </span>
                                        :
                                    </span> 
                                    <span class="float-end">
                                        <span class="reply-comment" title="Trả lời" style="cursor: pointer">
                                            <i class="fas fa-reply" style="color: gray; font-size: 1.4em"></i>
                                        </span>
                                        <span class="hide-reply-input" title="Trả lời" style="cursor: pointer; display: none">
                                            <i class="fas fa-eye-slash" style="color: gray; font-size: 1.4em"></i>
                                        </span>
                                        <span class="mark-done-comment mx-2" title="Đánh dấu hoàn thành" style="cursor: pointer">
                                            <i class="far fa-check-square" style="color: green; font-size: 1.4em"></i>
                                        </span>
                                        <span class="delete-comment" title="Xoá bình luận" style="cursor: pointer">
                                            <i class="fas fa-trash" style="color: brown; font-size: 1.4em"></i>
                                        </span>
                                    </span>
                                </p>
                                <p>
                                    {{ $comment->content }}
                                </p>
                            </div>
                            <ul class="comments replies-section" style="display: none">
                                @foreach($comments as $reply)
                                    @if($reply->reply_to == $comment->id)
                                    <li id="reply-{{ $reply->id }}" class="clearfix reply-row" data-reply-id="{{ $reply->id }}">
                                        <img src="https://bootdey.com/img/Content/user_3.jpg" class="replier" alt="">
                                        <div class="post-replies">
                                            <p class="meta">{{ $reply->name == Auth::guard('admin')->user()->fullname ? 'Tôi' : $reply->name }} 
                                                <span> 
                                                    <span class="d-none d-sm-inline large-device-time">trả lời lúc {{ $reply->created_at->format('H:i d/m/Y') }}</span>
                                                    <span class="d-inline d-sm-none mobile-device-time">({{ $reply->created_at->format('H:i d/m/Y') }})</span>
                                                    :
                                                </span>
                                                <span class="float-end">
                                                    <span title="Chỉnh sửa câu trả lời" class="mx-2 edit-reply" style="cursor: pointer;">
                                                        <i class="far fa-edit" style="color: cadetblue; font-size: 1.4em"></i>
                                                    </span>
                                                    <span title="Huỷ chỉnh sửa" class="mx-2 cancel-edit-reply" style="cursor: pointer; display: none;">
                                                        <i class="far fa-window-close" style="color: cadetblue; font-size: 1.4em;"></i>
                                                    </span>
                                                    <span title="Xoá câu trả lời" class="delete-reply" style="cursor: pointer">
                                                        <i class="fas fa-trash" style="color: brown; font-size: 1.4em"></i>
                                                    </span>
                                                </span>
                                            </p>
                                            <p class="reply-content">
                                                {{ $reply->content }}
                                            </p>
                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                                <div class="reply-comment-input">
                                    <div class="form-replies" data-edit-href="{{ route('editComment') }}" data-reply-href="{{ route('replyComment') }}" data-current-user="{{ Auth::guard('admin')->user()->fullname }}">
                                        <div class="row">
                                            <textarea class="form-control shadow-none" style="width: 90%; padding: 0.3rem!important; font-size: 1rem!important;" name="content" rows="1" cols="50" placeholder="Nhập nội dung bình luận..."></textarea>
                                            <a class="btn align-items-center submit-reply-btn" style="width: 10%" data-type="reply"><i class="fas fa-paper-plane" style="color: grey; font-size: 1em"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        @endif
                        @endforeach
                        @if (count($comments) == 0)
                            <li class="w-100 d-flex justify-content-center">
                                <div class="mt-4 empty-comment">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('images/completed_tasks.jpeg') }}" alt="all tasks completed" width="400px">
                                    </div>
                                    <p style="font-weight: 600; text-align: center">Tuyệt vời, không còn bình luận nào cần được phản hồi</p>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@include('admin.includes.comment-confirmation-popup')
@include('admin.includes.pop-up-notify')

<script src="{{ asset('admin/js/comment.js') }}"></script>
@endsection