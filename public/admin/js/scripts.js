$(document).ready(function () {
  /*      remove error messages       */
  $(':input.AcUpdateInput').on('click', () => {
      $('.AcUpdateMess').text("");
  })

  $(':input.AcCreateInput').on('click', () => {
      $('.AcCreateMess').text("");
  })

  /*      Trigger enter event     */
  $('.enter-event').keyup(function (e) {
      if (e.keyCode == 13) {
          $('#loginBtnAdmin').click();
      }
  });
});