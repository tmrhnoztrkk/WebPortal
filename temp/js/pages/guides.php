<script>
$(document).ready(function(){
    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });
});
$("#myTab a:first").tab('show'); // show first tab

function ssiptv_upload() {
    var mac = $("#ss_mac").val();
    var username = $("#ss_username").val();
    var password = $("#ss_password").val();
    var pin = $("#ss_pin").val();
    $.ajax({
        type: "POST",
        url: "app/_playlist.php",
        data: {'mac': mac, 'username': username, 'password': password, 'pin': pin, 'type': 1},
        dataType : "json",
        success: function (response) {
            if (response == 1) {
                $("#modal_body_text").html("<?= GUIDES_MESSAGE_1; ?>");
                $("#alert_modal").modal("show");
            } else if (response == 0) {
                $("#modal_body_text").html("<?= GUIDES_MESSAGE_2; ?>");
                $("#alert_modal").modal("show");
            } else {
                $("#modal_body_text").html("<?= GUIDES_MESSAGE_3; ?>");
                $("#alert_modal").modal("show");
            }
        }
    });
}

function royaliptv_upload() {
var mac = $("#ry_mac").val();
var username = $("#ry_username").val();
var password = $("#ry_password").val();
var url = $("#ry_url").val();
$.ajax({
    type: "POST",
    url: "app/_playlist.php",
    data: {'mac': mac, 'username': username, 'password': password, 'type': 2},
    dataType : "json",
    success: function (response) {
        if (response == 1) {
            $("#modal_body_text").html("<?= GUIDES_MESSAGE_1; ?>");
            $("#alert_modal").modal("show");
        } else {
            $("#modal_body_text").html("<?= GUIDES_MESSAGE_3; ?>");
            $("#alert_modal").modal("show");
        }
    }
});
}
</script>