$(document).ready(function () {
  $('.cust-file').css('display', 'none');
  $('#link_preview_selector').on('change', function () {
    if ($('#link_preview_selector').prop("checked") === true) {
      $('#link_preview_custom').prop('checked', true);
      $('#cust_img_chk').prop('checked', true);
      $('#cust_title_chk').prop('checked', true);
      $('#cust_dsc_chk').prop('checked', true);
      $('.use-custom').css({'display':'block'});
      $('.use-custom1').css({'display':'block'});
      $('.use-custom2').css({'display':'block'});
    } else {
      $('#link_preview_custom').prop('checked', false);
      $('#cust_img_chk').prop('checked', false);
      $('#cust_title_chk').prop('checked', false);
      $('#cust_dsc_chk').prop('checked', false);
    }
  })
});
