if (typeof loop !== 'undefined') {
    loop = loop
}else{
    loop = false
}

if (typeof time !== 'undefined') {
    time = time
}else{
    time = 5000
}


const mySiema = new Siema({

  selector: '#main-slider',
  duration: 400,
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

if (typeof animated !== true) {
    // listen for keydown event
    setInterval(() => mySiema.next(), time)
}
