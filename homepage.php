<html>

<head>
  <title>Webpage</title>
</head>

<body>


  <link rel="stylesheet" type="text/css" href="../css/style.css">

  <div class="logo">
    <center><img src="../assets/imgs/Logo.jpg" height="150"></center>
  </div>

  <hr style="width:100%">

  <html>

  <head>

    <style>
      .mySlides11 {
        display1: none;
      }

      img11 {
        vertical-align1: middle;
      }

      .slideshow-container11 {
        max-width: 1000px;
        margin: auto;
      }

      .text11 {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
      }


      .numbertext11 {
        color: white;
        font-size: 25px;
        padding: 8px 12px;
        position: absolute;
      }


      .dot11 {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
      }

      .slideshowactive {
        background-color: #717171;
      }


      .fade11 {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 1.5s;
        animation-name: fade;
        animation-duration: 1.5s;
      }

      @-webkit-keyframes fade11 {
        from {
          opacity: .4
        }

        to {
          opacity: 1
        }
      }

      @keyframes fade11 {
        from {
          opacity: .4
        }

        to {
          opacity: 1
        }
      }


      @media only screen and (max-width: 300px) {
        .text {
          font-size: 11px
        }
      }
    </style>
  </head>

  <body>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <div>
      <h4 class="feat"> Featured Dishes
    </div>


    <div class="slideshow-container11">

      <div class="mySlides11 fade11">
        <div class="numbertext11">1 / 6</div>
        <img src="../assets/imgs/food01.jpg" style="height:450px; width:100%">
      </div>

      <div class="mySlides11 fade11">
        <div class="numbertext11">2 / 6</div>
        <img src="../assets/imgs/food02.jpg" style="font-size:50px; height:450px; width:100%">
      </div>

      <div class="mySlides11 fade11">
        <div class="numbertext11">3 / 6</div>
        <img src="../assets/imgs/food03.jpg" style="font-size:50px; height:450px; width:100%">
      </div>

      <div class="mySlides11 fade11">
        <div class="numbertext11">4 / 6</div>
        <img src="../assets/imgs/food04.jfif" style="font-size:50px; height:450px; width:100%">
      </div>

      <div class="mySlides11 fade11">
        <div class="numbertext11">5 / 6</div>
        <img src="../assets/imgs/food05.jpg" style="font-size:50px; height:450px; width:100%">
      </div>

      <div class="mySlides11 fade11">
        <div class="numbertext11">6 / 6</div>
        <img src="../assets/imgs/food06.jpg" style="font-size:50px; height:450px; width:100%">
      </div>

    </div>
    <br>
    <div style="text-align:center">
      <span class="dot11"></span>
      <span class="dot11"></span>
      <span class="dot11"></span>
      <span class="dot11"></span>
      <span class="dot11"></span>
      <span class="dot11"></span>
    </div>

    <script>
      var slideIndex = 0;
      showSlides();

      function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides11");
        var dots = document.getElementsByClassName("dot11");
        for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
        }
        slideIndex++;
        if (slideIndex > slides.length) {
          slideIndex = 1
        }
        for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" slideshowactive", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " slideshowactive";
        setTimeout(showSlides, 2000);
      }
    </script>





    </>
    </head>

  </html>