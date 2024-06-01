<script>
var i = 0;

$('#change_bouquet').click(function(e) {
	var arr = [];
   $('#bq:checked').each(function () {
       arr[i++] = $(this).val();
    });
	$.ajax({
        type: "POST",
		url: "app/_bouqet.php",
		data: {'bouqet': arr},
		success: function (response) {
			if (response == 1) {
				$("#modal_info_body").text("<?= PROFILE_BOUQET_ALERT_1; ?>");
				$("#info_modal").modal("show");
			} else {
				$("#modal_info_body").text("<?= PROFILE_BOUQET_ALERT_2; ?>");
				$("#info_modal").modal("show");
			}
        }
    });
});
<? if ($siteInfo->password_change == 1) { ?>

$("#change_pass").click(function() {
	var password = $("#password_c1").val();
	var password_c = $("#password_c2").val();
	if (password != password_c) {
		
		$("#modal_info_body").text("<?= PROFILE_PASS_ALERT_1; ?>");
        $("#info_modal").modal("show");
	} else if (password.length < 8) {
		
		$("#modal_info_body").text("<?= PROFILE_PASS_ALERT_2; ?>");
        $("#info_modal").modal("show");
	} else if (!password.match(/([A-Z])/)) {
		
		$("#modal_info_body").text("<?= PROFILE_PASS_ALERT_3; ?>");
        $("#info_modal").modal("show");
	} else if ((password.length - password.replace(/[A-Z]/g, '').length) < 3) {
		
		$("#modal_info_body").text("<?= PROFILE_PASS_ALERT_3; ?>");
        $("#info_modal").modal("show");
	} else if (!password.match(/([0-9])/)) {
		
		$("#modal_info_body").text("<?= PROFILE_PASS_ALERT_4; ?>");
        $("#info_modal").modal("show");
	} else if ((password.length - password.replace(/[0-9]/g, '').length) < 3) {
		
		$("#modal_info_body").text("<?= PROFILE_PASS_ALERT_4; ?>");
        $("#info_modal").modal("show");
	} else {
		 $.ajax({
            type: "POST",
            url: "app/_passchange.php",
            data: {'password': password, 'password_c': password_c},
            success: function (response) {
				
                if (response == 1) {
                    $("#modal_info_body").text("<?= PROFILE_PASS_ALERT_5; ?>");
                    $("#info_modal").modal("show");
                    $('#info_modal').on('hidden.bs.modal', function (e) {
					  window.location.href="index.php?page=logout";
					});
                } else if (response == 2) {
                    $("#modal_info_body").text("<?= PROFILE_PASS_ALERT_6; ?>");
                    $("#info_modal").modal("show");
                } else if (response == 3) {
                    $("#modal_info_body").text("<?= PROFILE_PASS_ALERT_7; ?>");
                    $("#info_modal").modal("show");
                }
            }
        });
	}
});
<?
}
?>
</script>