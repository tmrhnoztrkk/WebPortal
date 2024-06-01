<script>
$(document).on('click', '.ep-list-min', function (e) {
    var data = $(this).data('id');
    var type = $(this).data('type');
    var val = $('#series_view').data('src');
    var surl = val + data + '.'+type;
    var player = videojs("maat-player");
    player.pause();
    player.src({
        src:surl,
        type: 'video/mp4'
    });
    player.load();
    player.play();
    e.preventDefault();
});


$("#alert_modal").on('hide.bs.modal', function () {
    var player = videojs("maat-player");
    player.pause();
});

$('.slide-sliders-full').owlCarousel({
    loop:false,
    margin:15,
    nav:true,
    autoplay:false,  
    dots:false,
    items:5,
    navText:['<img src="temp/images/left.png" alt="icon" />','<img src="temp/images/right.png" alt="icon" />'],
    responsive:{
        0:{
            items:2,
        },
        600:{
            items:3,
        },
        1200:{
            items:6,
        },
        1600:{
            items:6,
        }
    }
     
});
$('.top-episode a').eq(0).addClass('active');



$(document).on('click', '.top-episode a', function (e) {
    var indis = $(this).index();
    $('.top-episode a').removeClass('active');
    $(this).addClass('active');
    $('.tab_episode').hide().eq(indis).fadeIn();
    e.preventDefault();
});
</script>