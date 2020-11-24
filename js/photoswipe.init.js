(function($) {
    var $pswp = $('.pswp')[0];
    var image = [];

    $('#gallery').each( function() {
        var $pic     = $(this),
            getItems = function() {
                var items = [];
                //$pic.find('a').each(function() {
                $pic.find('.thumb').each(function() {
                    if($(this).is('.limit')){console.log('.limit');return;}
                    var $href   = $(this).attr('href'),
                        $title  = $(this).attr('title'),
                        $size   = $(this).data('size').split('x'),
                        $width  = $size[0],
                        $height = $size[1];

                    var item = {
                        src : $href,
                        w   : $width,
                        h   : $height,
                        title : $title
                    }

                    items.push(item);
                });
                //console.log(items);
                return items;
            }

        var items = getItems();

        $.each(items, function(index, value) {
            image[index]     = new Image();
            image[index].src = value['src'];
        });

        $pic.on('click', 'figure .thumb', function(event) {
            event.preventDefault();

            //console.log(parseInt($(this).attr('data-index')));
            var $index = parseInt($(this).attr('data-index'));
            //var $index = $(this).index();
            //var $index = $(this).attr('data-index');
            var options = {
                index: $index,
                bgOpacity: 0.7,
                showHideOpacity: true
            }

            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
})(jQuery);
