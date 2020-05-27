
($(function(){

    if (loop === null){
        loop = false
    }
    var mySiema = new Siema({
        selector: '#slider',
        duration: 500,
        easing: 'ease-out',
        perPage: 1,
        startIndex: 0,
        draggable: true,
        multipleDrag: true,
        threshold: 20,
        loop: loop,
        rtl: false,
        onInit: () => {},
        onChange: () => {},
    });

    function myTimer() {
        mySiema.next();
    }

    if (time === null){
        console.log(time);
    }
    function sliderAnimate(time) {

        var myVar = setInterval(myTimer, time);

        $('#slider').hover(function(){
            clearInterval(myVar);
        }, function(){
            myVar = setInterval(myTimer, time);
        });
    }

    /* lo voy a controlar en vista desde php */
    if (animated != null){
        sliderAnimate(time);
    }

}));
