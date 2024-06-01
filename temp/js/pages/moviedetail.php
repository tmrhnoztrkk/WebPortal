<script>
  $(document).on('click', '.ep-list-min', function (e) {
    $("#youtube_fragman").YTPPause();
    e.preventDefault();
});


$("#alert_modal").on('hide.bs.modal', function () {
    var player = videojs("my-video");
    player.pause();
    $("#youtube_fragman").YTPPlay();
});

$(function(){
  $("#youtube_fragman").YTPlayer();
});
</script>