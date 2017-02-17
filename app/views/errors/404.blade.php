<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Not Found</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo url();?>/css/bootstrap.css" rel="stylesheet">
  <link href="<?php echo url();?>/css/css.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="<?php echo url();?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo url();?>/css/custom.css" rel="stylesheet">
        <link href="<?php echo url();?>/css/animate.css" rel="stylesheet">



</head>

<body>

  <section>
              <div class="container">
                  <div class="row row1">
                      <div class="col-md-12">
                          <h3 style="visibility: visible;-webkit-animation-duration: 2s; -moz-animation-duration: 2s; animation-duration: 2s;" class="center capital f1 wow fadeInLeft animated" data-wow-duration="2s">Something went Wrong!</h3>
                          <h1 style="visibility: visible;-webkit-animation-duration: 2s; -moz-animation-duration: 2s; animation-duration: 2s;" id="error" class="center wow fadeInRight animated" data-wow-duration="2s">404</h1>
                          <p style="visibility: visible;-webkit-animation-delay: 2s; -moz-animation-delay: 2s; animation-delay: 2s;" class="center wow bounceIn animated" data-wow-delay="2s">Page not Found!</p>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <div style="visibility: visible;-webkit-animation-delay: 2800ms; -moz-animation-delay: 2800ms; animation-delay: 2800ms;" id="cflask-holder" class="wow fadeIn animated" data-wow-delay="2800ms">
                              <span style="visibility: visible;-webkit-animation-delay: 3000ms; -moz-animation-delay: 3000ms; animation-delay: 3000ms;" class="wow tada  animated" data-wow-delay="3000ms"><i style="visibility: visible;-webkit-animation-delay: 3300ms; -moz-animation-delay: 3300ms; animation-delay: 3300ms;" class="fa fa-flask fa-5x flask wow flip animated" data-wow-delay="3300ms"></i>
                                  <i id="b1" class="bubble"></i>
                                  <i id="b2" class="bubble"></i>
                                  <i id="b3" class="bubble"></i>

                              </span>
                          </div>
                      </div>
                  </div>


                  <div class="row"> <!--Search Form Start-->
                      <div class="col-md-12">
                          <div style="visibility: visible;-webkit-animation-delay: 4000ms; -moz-animation-delay: 4000ms; animation-delay: 4000ms;" class="col-md-6 col-md-offset-3 search-form wow fadeInUp animated" data-wow-delay="4000ms">
                          <center>  <a href="<?php echo url();?>" class="btn submit">Home</a></center>
                          </div>
                      </div>
                  </div> <!--Search Form End-->



              </div>
          </section>

<!-- jQuery -->
<script src="<?php echo url();?>/js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php echo url();?>/js/bootstrap.min.js"></script>
<script src="<?php echo url();?>/js/countUp.js"></script>
<script src="<?php echo url();?>/js/wow.js"></script>

<!--Initiating the CountUp Script-->
       <script type="text/javascript">
           "use strict";
           var count = new countUp("error", 0, 404, 0, 3);

           window.onload = function() {
               // fire animation
               count.start();
           }
       </script>

       <!--Initiating the Wow Script-->
       <script>
           "use strict";
           var wow = new WOW(
           {
               animateClass: 'animated',
               offset:       100
           }
       );
           wow.init();
       </script>
</body>

</html>
