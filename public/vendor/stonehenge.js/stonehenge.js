(function($) {
    $.fn.stonehenge = function (options) {
        options = $.extend({
            speed: 1.0
        }, options);

        return this.each(function () {
            let $stonehenge = $(this),
                speed = options.speed || $stonehenge.data('stonehenge-speed') || 1.0,
                isGrabbed = false,
                initialX,
                scrollLeft;

            $stonehenge
                .on('mousedown', function (e) {
                    isGrabbed = true;
                    $stonehenge.addClass('is-grabbed');
                    initialX = e.pageX - this.offsetLeft;
                    scrollLeft = this.scrollLeft;
                })
                .on('mouseleave', function (e) {
                    isGrabbed = false;
                    $stonehenge.removeClass('is-grabbed');
                })
                .on('mouseup', function (e) {
                    isGrabbed = false;
                    $stonehenge.removeClass('is-grabbed');
                })
                .on('mousemove', function (e) {
                    if (! isGrabbed) return;
                    e.preventDefault();
                    let x = e.pageX - this.offsetLeft;
                    let walk = (x - initialX) * speed;
                    this.scrollLeft = scrollLeft - walk;
                });
        });
    };
}(jQuery));
