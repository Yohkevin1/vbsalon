<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Venus Beauty Salon</title>
   <link rel="icon" type="image/png" href="{{ asset('images/Logo.png')}}">
   <meta name="keywords" content="beauty, salon, hair care, skincare, makeup, beauty treatments">
   <meta name="description" content="Selamat datang di Venus Beauty Salon. Kami menawarkan layanan kecantikan terbaik, termasuk perawatan rambut, perawatan kulit, dan layanan makeup. Kunjungi salon kami untuk pengalaman kecantikan yang luar biasa.">
   <meta name="author" content="Venus Beauty Salon">
   <!-- bootstrap css -->
   <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
   <!-- style css -->
   <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
   <!-- Responsive-->
   <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css')}}">
   <!-- Scrollbar Custom CSS -->
   <link rel="stylesheet" href="{{ asset('frontend/css/jquery.mCustomScrollbar.min.css')}}">
   <!-- Tweaks for older IEs-->
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="main-layout">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#" /></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-5 col-lg-5 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item">
                                 <a class="nav-link" href="#home"> Home  </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#about">About</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#service">Service</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#product">Product</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#contact">Contact Us</a>
                              </li>
                           </ul>
                        </div>
                     </nav>
                  </div>
                  <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="#home">VB Salon</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
                     <ul class="email">
                        <li><a href="#">Call: (+62) 1234567890</a></li>
                        <li><a href="#">Email: xxxxx@gmail.com</a></li>
                        <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- banner -->
      <section id="home" class="banner_main">
         <div id="banner1" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container-fluid">
                     <div class="carousel-caption">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="text-bg">
                                 <span>Welcome to</span>
                                 <h1>Venus Beauty SALON</h1>
                                 <a href="#about">Read More </a> <a href="#contact">Book Now</a>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="text_img">
                                 <figure><img src="frontend/images/girl.png" alt="#"/></figure>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- service -->
      <div id="service"  class="service">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2> <img src="frontend/images/head.png" alt="#"/> Layanan Kami</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               @foreach ($data['service'] as $jasa)
               <div class="col-md-4">
                  <div id="hover_chang" class="service_box">
                     <i><img src="images/jasa/{{$jasa->foto}}" alt="#"/></i>
                     <h3>{{$jasa->nama_jasa}}</h3>
                     <p>{{$jasa->deskripsi}}</p>
                  </div>
               </div>            
               @endforeach
               {{-- <div class="col-md-12">
                  <a class="read_more" href="#">Read More</a>
               </div> --}}
            </div>
         </div>
      </div>
      <!-- about -->
      <div id="about"  class="about">
         <div class="container">
            <div class="row">
               <div class="col-md-9">
                  <div class="titlepage">
                     <h2> <img src="frontend/images/head.h.png" alt="#"/> About VB Salon</h2>
                     <p>Venus Beauty Salon adalah destinasi kecantikan eksklusif yang menghadirkan pengalaman perawatan dan keindahan terbaik. Dengan tim profesional kami yang berkomitmen untuk memberikan pelayanan terbaik, kami menawarkan beragam layanan kecantikan mulai dari perawatan rambut, perawatan kulit, hingga perawatan tubuh.</p>
                     <p>Di Venus Beauty Salon, kami memahami bahwa kecantikan adalah ungkapan dari kepribadian dan gaya hidup unik setiap individu. Dengan menggunakan produk-produk berkualitas tinggi dan teknologi terkini, kami berdedikasi untuk membantu Anda menemukan kilau alami dan kepercayaan diri yang luar biasa.</p>
                     <p>Nikmati suasana yang nyaman dan santai sambil mempercayakan diri Anda pada tangan-tangan ahli kami. Mulai dari potongan rambut yang trendy hingga perawatan kulit yang menyegarkan, Venus Beauty Salon memberikan perhatian khusus pada setiap detail untuk memastikan Anda merasa memanjakan diri dan mendapatkan hasil terbaik.</p>
                     {{-- <a class="read_more">Read More</a> --}}
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- product -->
      <div id="product"  class="service">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2> <img src="frontend/images/head.png" alt="#"/> Produk Kami</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               @foreach ($data['produk'] as $produk)
               <div class="col-md-4">
                  <div id="hover_chang" class="service_box">
                     <i><img src="images/produk/{{$produk->foto}}" alt="#"/></i>
                     <h3>{{$produk->merek}}</h3>
                     <p>{{ substr($produk->deskripsi, 0, 100) }}...</p>
                  </div>
               </div>            
               @endforeach
               {{-- <div class="col-md-12">
                  <a class="read_more" href="#">Read More</a>
               </div> --}}
            </div>
         </div>
      </div>
      </div>
      <!--  contact -->
      <div id="contact" class="contact">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2> <img src="frontend/images/head.h.png" alt="#"/> Minta <span class="white"> Kami Hubungi</span></h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                  <form id="request" class="main_form" method="POST" action="{{route('sendEmail')}}">
                        @csrf
                     <div class="row">
                        <div class="col-md-12 ">
                           <input class="contactus" placeholder="Name" type="type" name="Name"> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Email" type="type" name="Email"> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Phone Number" type="type" name="Phone_Number">                          
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Subject" type="type" name="Subject">                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="Message" type="type" name="Message" Message="Name">Message </textarea>
                        </div>
                        <div class="col-sm-col-xl-6 col-lg-6 col-md-6 col-sm-12">
                           <button class="send_btn" type="submit">Send</button>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.426958949974!2d110.37140067382087!3d-7.744455292274213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a58fcb5c06c65%3A0xf7a17629f9aba68f!2sJl.%20Palagan%20Tentara%20Pelajar%20No.49%2C%20Jongkang%2C%20Sariharjo%2C%20Kec.%20Ngaglik%2C%20Kabupaten%20Sleman%2C%20Daerah%20Istimewa%20Yogyakarta%2055581!5e0!3m2!1sid!2sid!4v1700441744578!5m2!1sid!2sid" width="600" height="432" frameborder="0" style="border:0; width: 100%;" allowfullscreen></iframe>
                     </div>
               </div>
            </div>
         </div>
      </div>
      <!--  footer -->
      <footer id="contact">
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>Copyright &copy 2023; VENUS BEAUTY SALON</p>
                     </div>
                  </div>
               </div>
            </div>
         
      </footer>
     <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
      <script src="{{ asset('frontend/js/popper.min.js')}}"></script>
      <script src="{{ asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
      <!-- sidebar -->
      <script src="{{ asset('frontend/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
      <script src="{{ asset('frontend/js/custom.js')}}"></script>
      <script>
         $('a[href^="#"]').on('click', function(event) {
         
          var target = $(this.getAttribute('href'));
         
          if( target.length ) {
              event.preventDefault();
              $('html, body').stop().animate({
                  scrollTop: target.offset().top
              }, 2000);
          }
         
         });
      </script>
      <script>
         function initMap() {
           var map = new google.maps.Map(document.getElementById('map'), {
             zoom: 11,
             center: {lat: 40.645037, lng: -73.880224},
             });
         
         var image = 'images/maps-and-flags.png';
         var beachMarker = new google.maps.Marker({
             position: {lat: 40.645037, lng: -73.880224},
             map: map,
             icon: image
           });
         }
      </script> 
</body>
</html>