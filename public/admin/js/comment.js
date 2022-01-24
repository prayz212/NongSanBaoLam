$(document).ready(function () {
  const EDIT_ICON = '<svg class="svg-inline--fa fa-edit fa-w-18" style="color: grey; font-size: 1em" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M402.6 83.2l90.2 90.2c3.8 3.8 3.8 10 0 13.8L274.4 405.6l-92.8 10.3c-12.4 1.4-22.9-9.1-21.5-21.5l10.3-92.8L388.8 83.2c3.8-3.8 10-3.8 13.8 0zm162-22.9l-48.8-48.8c-15.2-15.2-39.9-15.2-55.2 0l-35.4 35.4c-3.8 3.8-3.8 10 0 13.8l90.2 90.2c3.8 3.8 10 3.8 13.8 0l35.4-35.4c15.2-15.3 15.2-40 0-55.2zM384 346.2V448H64V128h229.8c3.2 0 6.2-1.3 8.5-3.5l40-40c7.6-7.6 2.2-20.5-8.5-20.5H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V306.2c0-10.7-12.9-16-20.5-8.5l-40 40c-2.2 2.3-3.5 5.3-3.5 8.5z"></path></svg>';
  const SEND_ICON = '<svg class="svg-inline--fa fa-paper-plane fa-w-16" style="color: grey; font-size: 1em;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z"></path></svg>';

  $('#fetch-comments').click(function() {
    $(this).hide();
    $('#fetching-comments').show();
    $('.comments-section li').fadeOut(300, function(){ $(this).remove() });

    const element = $(this).closest('.__product-info-box').find('.comments-section');
    const href = $(this).attr('data-href');

    setTimeout(() => {
      fetchComments(href, element);
    }, 1000);    
  });

  $( ".comments-section" ).on( "click", "li .reply-comment", function() {
    const _parent = $(this).closest('.comment-row');
    $(this).hide();
    _parent.find('.replies-section').fadeIn(300, function(){ $(this).show() });
    _parent.find('.hide-reply-input').show();
  });

  $( ".comments-section" ).on( "click", "li .hide-reply-input", function() {
    const _parent = $(this).closest('.comment-row');
    $(this).hide();
    _parent.find('.reply-comment').show();
    _parent.find('.replies-section').fadeOut(300, function(){ $(this).hide() });
    _parent.find('.replies-section .cancel-edit-reply').click();
  });

  $( ".comments-section" ).on( "click", "li .mark-done-comment", function() {
    const _parent = $(this).closest('.comment-row');
    const actionUrl = _parent.attr('data-marked-href');
    const commentID = _parent.attr('data-comment-id');

    _parent.css({ 'left': '0px' }).animate({
        'left' : '-105%'    
    }, 'slow', function(){ $(this).remove() });

    markDoneComment(actionUrl, commentID);
    checkNothingDisplay();
  });

  $( ".comments-section" ).on( "click", "li .delete-comment", function() {
    const _parent = $(this).closest('.comment-row');
    const actionUrl = _parent.attr("data-detele-href");
    const commentID = _parent.attr("data-comment-id");
    
    showCommentConfirmPopup('Xác nhận xoá', 'Bạn có chắc chắn xoá bình luận này?', actionUrl + '|' + commentID, 'fa fa-exclamation-circle fa-3x');
  });

  $( ".comments-section" ).on( "click", "li .delete-reply", function() {
    const _parent = $(this).closest('.reply-row');
    const actionUrl = $(this).closest('.comment-row').attr("data-detele-href");
    const commentID = _parent.attr("data-reply-id");

    showCommentConfirmPopup('Xác nhận xoá', 'Bạn có chắc chắn xoá bình luận này?', actionUrl + '|' + commentID, 'fa fa-exclamation-circle fa-3x');
  });

  $( ".comments-section" ).on( "click", "li .edit-reply", function() {
    const _parent = $(this).closest('.replies-section');
    const _subparent = $(this).closest('.post-replies');
    const _element = $(this).closest('.reply-row');

    const content = _subparent.find('.reply-content').html().trim();
    _subparent.find('.cancel-edit-reply').show();
    $(this).hide();

    _parent.find('.form-replies').attr('data-edit-id', _element.attr('data-reply-id'));
    _parent.find('.form-replies a').attr('data-type', 'edit');
    _parent.find('.form-replies a svg').remove();
    _parent.find('.form-replies a').append(EDIT_ICON);
    _parent.find('.form-replies textarea').val(content);
    _parent.find('.form-replies textarea').focus();
  });

  $( ".comments-section" ).on( "click", "li .cancel-edit-reply", function() {
    const _parent = $(this).closest('.replies-section');
    const _subparent = $(this).closest('.post-replies');

    _subparent.find('.edit-reply').show();
    $(this).hide();

    _parent.find('.form-replies').removeAttr('data-edit-id');
    _parent.find('.form-replies a').attr('data-type', 'reply');
    _parent.find('.form-replies a svg').remove()
    _parent.find('.form-replies a').append(SEND_ICON);
    _parent.find('.form-replies textarea').val('');
  });

  $( ".comments-section" ).on( "click", ".form-replies .submit-reply-btn", function() {
    const _parent = $(this).closest('.form-replies');
    const content = _parent.find('textarea').val().trim();
    const username = _parent.attr('data-current-user');
    const type = $(this).attr('data-type');
    const href = type == 'reply' 
      ? _parent.attr('data-reply-href')
      : _parent.attr('data-edit-href');

    const id = type == 'reply' 
      ? $(this).closest('.comment-row').attr('data-comment-id')
      : _parent.attr('data-edit-id');

    const element = type == 'reply'
      ? $(this).closest('.replies-section')
      : $(this).closest('.replies-section').find('li[id*=reply-' + id + ']');

    if (content == '') {
      _parent.find('textarea').css('border', '0.1rem solid red');
      _parent.find('textarea').focus();
      return;
    }

    submitCommentForm(href, content, username, id, type, element);
    _parent.find('textarea').val('');
  });

  /* comment confirmation popup */
  $('#comment-popup-close-btn').click(function() {
    $(".__comment-popup-confirm").hide();
    $('#comment-popup-confirm-btn').removeAttr('data-detele-href');
  }); 

  $('#comment-popup-confirm-btn').click(function() {
    const data = $(this).attr('data-detele-href').split('|');
    deleteComment(data[0], data[1]);
    $(".__comment-popup-confirm").hide();
  });
});

function fetchComments(actionHref, element) {
  $.ajax({
    type: "GET",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: actionHref,
    success: function (data) {
      if (data.status == 200) {
        appendComments(data.comments, data.replies);
      } else {
        showNotifyPopup(
          'fail', 
          'Lỗi', 
          'Làm mới danh sách bình luận đã xảy ra lỗi, vui lòng thử lại sau', 
          'fas fa-exclamation-triangle fa-3x'
        );
      }
    },
    error: function () {
      showNotifyPopup(
        'fail', 
        'Lỗi', 
        'Làm mới danh sách bình luận đã xảy ra lỗi, vui lòng thử lại sau', 
        'fas fa-exclamation-triangle fa-3x'
      );

      setTimeout(() => {
        location.reload();
      }, 1500);
    },
  });
}

function showCommentConfirmPopup(title, messages, href, icon = null) {
  const _this = $(".__comment-popup-confirm");

  _this.find('#comment-popup-title').html(title);
  _this.find('#comment-popup-message').html(messages);

  $('#comment-popup-confirm-btn').attr('data-detele-href', href);
  $('#popup-icon')
      .removeClass()
      .addClass(icon);

  _this.show();
}

function deleteComment(href, commentID) {
  $.ajax({
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: href,
    data: {id: commentID},
    success: function (data) {
      if (data.status == 200) {
        if (data.reply) {
          $('li[id*=reply-' + commentID + ']')
            .closest('.reply-row')
            .fadeOut(300, function(){ $(this).remove();});
        } else {
          $('li[id*=comment-' + commentID + ']')
            .closest('.comment-row')
            .fadeOut(300, function(){ $(this).remove();});

          checkNothingDisplay();
        }
      } else {
        showNotifyPopup(
          'fail', 
          'Đã xảy ra lỗi', 
          'Xoá bình luận không thành công, vui lòng thử lại sau', 
          'fas fa-exclamation-triangle fa-3x',
          data.redirect
        );
      }
    },
    error: function () {
      showNotifyPopup(
        'fail', 
        'Đã xảy ra lỗi', 
        'Xoá bình luận không thành công, vui lòng thử lại sau', 
        'fas fa-exclamation-triangle fa-3x'
      );

      setTimeout(() => {
        location.reload();
      }, 1500);
    },
  });
}

function markDoneComment(actionHref, commentID) {
  $.ajax({
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: actionHref,
    data: {id: commentID},
    success: function (data) {
      if (data.status == 200) {
        console.log('marked comment done');
      } else {
        showNotifyPopup(
          'fail', 
          'Đã xảy ra lỗi', 
          'Đánh dấu bình luận hoàn tất không thành công, vui lòng thử lại sau', 
          'fas fa-exclamation-triangle fa-3x',
          data.redirect
        );
      }
    },
    error: function () {
      showNotifyPopup(
        'fail', 
        'Đã xảy ra lỗi', 
        'Đánh dấu bình luận hoàn tất không thành công, vui lòng thử lại sau', 
        'fas fa-exclamation-triangle fa-3x'
      );

      setTimeout(() => {
        location.reload();
      }, 1500);
    },
  });
}

function submitCommentForm(actionHref, content, commentator, id, type, element) {
  const data = type == 'reply'
    ? {id, content, name: commentator}
    : {id, content};

  $.ajax({
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: actionHref,
    data: data,
    success: function (data) {
      if (data.status == 200) {
        return type == 'reply' 
          ? appendReplyToComment(data.data, element)
          : updateReplyContent(data.data, element);
      } else {
        let action = type == 'edit' ? 'Chỉnh sửa' : 'Trả lời';
        showNotifyPopup(
          'fail', 
          'Đã xảy ra lỗi', 
          `${action} bình luận không thành công, vui lòng thử lại sau`, 
          'fas fa-exclamation-triangle fa-3x'
        );

        console.log(data.messages);
      }
    },
    error: function () {
      let action = type == 'edit' ? 'Chỉnh sửa' : 'Trả lời';
      showNotifyPopup(
        'fail', 
        'Đã xảy ra lỗi', 
        `${action} bình luận không thành công, vui lòng thử lại sau`, 
        'fas fa-exclamation-triangle fa-3x'
      );

      setTimeout(() => {
        location.reload();
      }, 1500);
    },
  });
}

function appendComments(comments, replies) {
  const _this = $('.comments-section');
  const deleteHref = _this.attr('data-detele-href');
  const markedHref = _this.attr('data-marked-href');
  const productHref = _this.attr('data-product-href');
  const editHref = _this.attr('data-edit-href');
  const replyHref = _this.attr('data-reply-href');
  const currentUser = _this.attr('data-current-user');

  if (comments.length <= 0) {
    nothingToDisplay();
  } else {
    comments.forEach(comment => {
      const {id, name, content, product} = comment;
      let HTML = 
      `<li id="comment-${id}" class="clearfix comment-row" style="position: relative;" data-comment-id="${id}" data-detele-href="${deleteHref}" data-marked-href="${markedHref}">
          <img src="https://bootdey.com/img/Content/user_1.jpg" class="commentators">
          <div class="post-comments">
              <p class="meta">${name} 
                  <span>
                      <span class="d-inline d-sm-none"> - </span> 
                      <span class="d-none d-sm-inline">bình luận vào</span> 
                      <span>
                          <a style="text-decoration: none; color: darkblue" href="${productHref.replace('productID', product.id)}">${product.name}</a>
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
                  ${content}
              </p>
          </div>
          <ul class="comments replies-section" style="display: none">
              ${generateReplyHTML(replies, id)}
              <div class="reply-comment-input">
                  <div class="form-replies" data-edit-href="${editHref}" data-reply-href="${replyHref}" data-current-user="${currentUser}">
                      <div class="row">
                          <textarea class="form-control shadow-none" style="width: 88%; padding: 0.3rem!important; font-size: 1rem!important;" name="content" rows="1" cols="50" placeholder="Nhập nội dung bình luận..."></textarea>
                          <a class="btn align-items-center submit-reply-btn" style="width: 12%" data-type="reply"><i class="fas fa-paper-plane" style="color: grey; font-size: 1em"></i></a>
                      </div>
                  </div>
              </div>
          </ul>
      </li>`

      $('.comments-section').append(HTML);
    });
  }

  $('#fetching-comments').hide();
  $('#fetch-comments').show();
}

function nothingToDisplay() {
  $('.comments-section').append(
    `<li class="w-100 d-flex justify-content-center">
        <div class="mt-4 empty-comment">
            <div class="d-flex justify-content-center">
                <img src="https://res.cloudinary.com/dazdxrnam/image/upload/v1642849813/completed_tasks_mqdzte.jpg" alt="all tasks completed" width="400px" height="233">
            </div>
            <p style="font-weight: 600; text-align: center">Tuyệt vời, không còn bình luận nào cần được phản hồi</p>
        </div>
    </li>`
  );
}

function checkNothingDisplay() {
  if ($('.comments-section li.comment-row').length <= 1) {
    setTimeout(() => {
      nothingToDisplay();
    }, 1800); 
  }
}

function generateReplyHTML(replies, commentID) {
  let HTML = '';
  replies.forEach(reply => {
    if (reply.reply_to == commentID) {
      const {id, content, created_at} = reply;
      const date = new Date(created_at);
      let [hour, minutes, month, day, year] = [
        date.getHours(), 
        date.getMinutes(), 
        date.getMonth(), 
        date.getDate(), 
        date.getFullYear()
      ];

      month += 1;
      let monthOfYear = month.toString();
      if (month < 10) {
        monthOfYear = '0' + month;
      }

      HTML += 
      `<li id="reply-${id}" class="clearfix reply-row" data-reply-id="${id}">
          <img src="https://bootdey.com/img/Content/user_3.jpg" class="replier" alt="">
          <div class="post-replies">
              <p class="meta">Tôi
                  <span> 
                      <span class="d-none d-sm-inline large-device-time">trả lời lúc ${hour}:${minutes} ${day}/${monthOfYear}/${year}</span>
                      <span class="d-inline d-sm-none mobile-device-time">(${hour}:${minutes} ${day}/${monthOfYear}/${year})</span>
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
                  ${content}
              </p>
          </div>
      </li>`
    }
  });

  return HTML;
}

function appendReplyToComment(data, element) {
  const {id, content, created_at} = data;
  const date = new Date(created_at);
  let [hour, minutes, month, day, year] = [
    date.getHours(), 
    date.getMinutes(), 
    date.getMonth(), 
    date.getDate(), 
    date.getFullYear()
  ];

  month += 1;
  let monthOfYear = month.toString();
  if (month < 10) {
    monthOfYear = '0' + month;
  }
  const HTML_ELEMENT = 
  `<li id="reply-${id}" class="clearfix reply-row" data-reply-id="${id}">
    <img src="https://bootdey.com/img/Content/user_3.jpg" class="replier" alt="">
    <div class="post-replies">
        <p class="meta">Tôi
            <span> 
                <span class="d-none d-sm-inline large-device-time">trả lời lúc ${hour}:${minutes} ${day}/${monthOfYear}/${year}</span>
                <span class="d-inline d-sm-none mobile-device-time">(${hour}:${minutes} ${day}/${monthOfYear}/${year})</span>
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
            ${content}
        </p>
    </div>
  </li>`;

  if (element.find('li').length >= 1) {
    element.find('li:last').after(HTML_ELEMENT);
  } else {
    element.find('.reply-comment-input').prepend(HTML_ELEMENT);
  }
}

function updateReplyContent(data, element) {
  const {content, updated_at} = data;
  const date = new Date(updated_at);
  let [hour, minutes, month, day, year] = [
    date.getHours(), 
    date.getMinutes(), 
    date.getMonth(), 
    date.getDate(), 
    date.getFullYear()
  ];

  month += 1;
  let monthOfYear = month.toString();
  if (month < 10) {
    monthOfYear = '0' + month;
  }

  element.find('.reply-content').html(content);
  element.find('.post-replies .meta .large-device-time').html(`trả lời lúc ${hour}:${minutes} ${day}/${monthOfYear}/${year}`)
  element.find('.post-replies .meta .mobile-device-time').html(`(${hour}:${minutes} ${day}/${monthOfYear}/${year})`)
}