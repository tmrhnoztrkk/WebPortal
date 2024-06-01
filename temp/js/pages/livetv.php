<script>
<? if ($byakman->guvenlik($_GET["id"]) != "") { ?>
    var player =  jwplayer("myElement");
    player.setup({
		"file": "<?= $siteInfo->site_xtream;?>live/<?= $byakman->userInfo('username'); ?>/<?= $byakman->userInfo('password'); ?>/<?= $byakman->guvenlik($_GET['id']); ?>.m3u8",
		aspectratio: '16:9',
		autostart: true,
        width: '100%'
    });
    player.play();
<? } ?>
var bouquet_id = $("#live_cat").val();
function bouquet_get(a) {
    var bouguet_cat = a;

    $.ajax({
        type: "POST",
        url: "app/_livetv.php",
        data: { "type": 1, "cat": bouguet_cat},
        dataType: "json",
        success: function (response) {
            $(".mobile").empty();
            $(".desktop").empty();
            $.each(response, function(index, item) {
                if (item.epg_title != null) {
                    $(".mobile").append('<li onclick="yayin_ac(this);" class="list-group-item" data-id="'+ item.stream_id +'">'+ index +' - <img style="margin-right:5px" src="'+ item.stream_icon +'" width="25" />' + item.name + '<span class="epg_info">'+item.epg_title+'</span></li>');
                    $(".desktop").append('<li onclick="yayin_ac(this);" class="list-group-item" data-id="'+ item.stream_id +'">'+ index +' - <img style="margin-right:5px" src="'+ item.stream_icon +'" width="25" />' + item.name + '<span class="epg_info">'+item.epg_title+'</span></li>');
                } else {
                    $(".mobile").append('<li onclick="yayin_ac(this);" class="list-group-item" data-id="'+ item.stream_id +'"><div style="float:left">'+ index +' - <img style="margin-right:5px" src="'+ item.stream_icon +'" width="25" />' + item.name + '</div></li>');
                    $(".desktop").append('<li onclick="yayin_ac(this);" class="list-group-item" data-id="'+ item.stream_id +'">'+ index +' - <img style="margin-right:5px" src="'+ item.stream_icon +'" width="25" />' + item.name + '</li>');
                }
               
              
            });
			<? if ($byakman->guvenlik($_GET["id"]) == "") { ?>
            $('.list-group-item:first-child').click();
			<? } ?>
        }
    });

}

bouquet_get(bouquet_id);
 
$("#live_cat").change(function (e) { 
    e.preventDefault();
    $("#live_cat2").removeClass("active");
    $("#live_cat2").val(this.value).addClass("active");
    bouquet_get(this.value);
});
$("#live_cat2").change(function (e) { 
    e.preventDefault();
    $("#live_cat").removeClass("active");
    $("#live_cat").val(this.value).addClass("active");
    bouquet_get(this.value);
});
						

function yayin_ac(d){
    var id = d.getAttribute("data-id");
    $(".list-group-item").removeClass("active");
    $(d).addClass("active");
    if (id !== '') {
        if (!isNaN(id)) {
            $('.loader').addClass('active');
            $.ajax({
                url: 'app/_livetv.php',
                type: 'POST',
                data: {channel: id, type: 2},
                dataType: 'html',
                success: function (result) {
                    var player =  jwplayer("myElement");
                     player.setup({
						   "file": result,
						   aspectratio: '16:9',
                            autostart: true,
                            width: '100%'
                         });
                         player.play();
                    $.ajax({
                        type: "POST",
                        url: "app/_livetv.php",
                        data: {"channel": id, type: 3},
                        dataType: "json",
                        success: function (response) {
                            $("#epg_list").empty();
                            $("#epg_list").html('<ul class="list-group">');
                            $.each(response, function(index, item) {
                                if (item.description != "") {
                                    var description_item = "<p>"+item.description+"</p>";
                                } else {
                                    var description_item = "";
                                }
                                $("#epg_list").append('<li id="epg_data" class="list-group-item">'+ item.start +' - '+ item.end +' ' + item.title + ''+ description_item +'</li>');
                            });
                            $("#epg_list").append("</ul>");
                            
                        }
                    });
                   


                    $('.loader').removeClass('active');
                }
            });
        }
    }
}
function open_live_menu() {
    document.getElementById("mySidenav").style.width = "250px";
    $("#fixed_header").css("position", "fixed");
    $("#fixed_header").css("display", "contents");
    $("#live_box2").css("display", "flex");
  }
  
  function close_live_menu() {
    document.getElementById("mySidenav").style.width = "0";
    $("#fixed_header").css("display", "none");
    $("#live_box2").css("display", "none");
    
  }

  </script>