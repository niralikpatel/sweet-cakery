<style>
	.banner-img {
	/* background-image: url('img_girl.jpg'); */
		background-image: url('../Admin/item-images/cupcake1.jpg');
		background-repeat: no-repeat;
		/* background-attachment: fixed; */
		background-size: cover;
	}
</style>

<div class="banner banner-img">
    <div class="banner-text">
        <h1>Quality Cakes ...</h1>
        <h1> Filled with sweetness & love.</h1>
        <p>Delicious cakes for every occasion</p>
    </div>
</div>

<!-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="images/banner1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/banner2.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/cake1.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> -->

<!-- banner2 -->
<!-- <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100 img-sz" src="images/cupcake1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/cupcake4.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/cupcake1.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> -->

<!-- <script>
    var imgs = document.querySelectorAll('.slider img');
    var dots = document.querySelectorAll('.dot');
    var currentImg = 0; // index of the first image 
    const interval = 3000; // duration(speed) of the slide

    function changeSlide(n) {
        for (var i = 0; i < imgs.length; i++) { // reset
            imgs[i].style.opacity = 0;
            dots[i].className = dots[i].className.replace(' active', '');
        }

        currentImg = n;

        imgs[currentImg].style.opacity = 1;
        dots[currentImg].className += ' active';
    }

    var timer = setInterval(changeSlide, interval);

    currentImg = (currentImg + 1) % imgs.length; // update the index number

    if (n != undefined) {
        clearInterval(timer);
        timer = setInterval(changeSlide, interval);
        currentImg = n;
    }
</script>

<div class="slider">
  <img id="img-1" src="images/banner1.jpg" alt="Image 1"/>
  <img id="img-2" src="images/banner2.jpg" alt="Image 2"/>
  <img id="img-3" src="images/cake1.jpg" alt="Image 3"/>
</div>
<div class="navigation-button">
  <span class="dot active" onclick="changeSlide(0)"></span>
  <span class="dot" onclick="changeSlide(1)"></span>
  <span class="dot" onclick="changeSlide(2)"></span>
</div> -->