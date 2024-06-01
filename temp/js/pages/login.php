<script>
$(document).on('keypress',function(e) {
    if(e.which == 13) {
        $("#login_user").click();
    }
});
<? if ($siteInfo->recaptcha == 1) { ?>
    grecaptcha.ready(function () {
            grecaptcha.execute('<?= $siteInfo->recaptcha_key; ?>', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptcha_response');
                recaptchaResponse.value = token;
            });
        });
<? } ?>

$("#login").click(function() {
    var username = $("#username").val();
    var sifre = $("#sifre").val();
    var mac = $("#mac").val();
    var remember = $("#remember").val();
    var captcha = $("#recaptchaResponse").val();
        $.ajax({
            type: "POST",
            url: "app/_login.php",
            data: {'username': username, 'password': sifre, 'mac': mac, 'captcha': captcha, 'remember': remember, 'type': "1"},
            success: function (response) {
                if (response == 1) {
                    $("#modal_body_text").text("<?= LOGIN_ALERT_3; ?>");
                    $("#alert_modal").modal("show");
                    setTimeout(function(){ window.location.href="index.php?page=homepage"; }, 3000);
                } else if (response == 2) {
                    $("#modal_body_text").text("<?= LOGIN_ALERT_4; ?>");
                    $("#alert_modal").modal("show");
                } else if (response == 3) {
                    $("#modal_body_text").text("<?= LOGIN_ALERT_5; ?>");
                    $("#alert_modal").modal("show");
                } else if (response == 4) {
                    $("#modal_body_text").text("<?= LOGIN_ALERT_6; ?>");
                    $("#alert_modal").modal("show");
                } else if (response == 5) {
                    $("#modal_body_text").text("<?= LOGIN_ALERT_8; ?>");
                    $("#alert_modal").modal("show");
                }
            }
        });
});



var $myGroup = $('#myGroup');
$myGroup.on('show.bs.collapse','.collapse', function() {
    $myGroup.find('.collapse.show').collapse('hide');
});

var macAddress = document.getElementById("mac");
function formatMAC(e) {
    var r = /([a-f0-9]{2})([a-f0-9]{2})/i,
        str = e.target.value.replace(/[^a-f0-9]/ig, "");
    while (r.test(str)) {
        str = str.replace(r, '$1' + ':' + '$2');
    }
    e.target.value = str.slice(0, 17);
};
macAddress.addEventListener("keyup", formatMAC, false);
</script>