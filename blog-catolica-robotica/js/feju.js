var data = new Date();

    document.getElementById("ano").innerHTML = "Copyright &copy; WickedBotz 2012 - "+data.getFullYear();
   !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

   $(document).ready(function() {
$('.header-video').each(function(i, elem) {
    headerVideo = new HeaderVideo({
      element: elem,
      media: '.header-video__media',
      playTrigger: '.header-video__play-trigger',
      closeTrigger: '.header-video__close-trigger'
    });
});
});
