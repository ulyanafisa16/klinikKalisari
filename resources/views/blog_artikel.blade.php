<!DOCTYPE html>
<html lang="zxx">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="Orbitor,business,company,agency,modern,bootstrap4,tech,software">
  <meta name="author" content="themefisher.com">

  <title>Novena- Health & Care Medical template</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('novena') }}/images/favicon.ico" />

  <!-- bootstrap.min css -->
  <link rel="stylesheet" href="{{ asset('novena') }}/plugins/bootstrap/css/bootstrap.min.css">
  <!-- Icon Font Css -->
  <link rel="stylesheet" href="{{ asset('novena') }}/plugins/icofont/icofont.min.css">
  <!-- Slick Slider  CSS -->
  <link rel="stylesheet" href="{{ asset('novena') }}/plugins/slick-carousel/slick/slick.css">
  <link rel="stylesheet" href="{{ asset('novena') }}/plugins/slick-carousel/slick/slick-theme.css">

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('novena') }}/css/style.css">
  
  <!-- Favicons -->
  <link href="{{ asset('frontend') }}/assets/img/favicon.png" rel="icon">
  <link href="{{ asset('frontend') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontend') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('frontend') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('frontend') }}/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="{{ asset('frontend') }}/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('frontend') }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="{{ asset('frontend') }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('frontend') }}/assets/css/main.css" rel="stylesheet">

</head>

<body id="top">

    <header id="header" class="header sticky-top">
        <div class="topbar d-flex align-items-center">
          <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
              <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
              <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
            </div>
            <div class="social-links d-none d-md-flex align-items-center">
              <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>
          </div>
        </div><!-- End Top Bar -->
    
        <div class="branding d-flex align-items-center">
          <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center me-auto">
              <!-- Uncomment the line below if you also wish to use an image logo -->
              <!-- <img src="assets/img/logo.png" alt=""> -->
              <h1 class="sitename">Medilab</h1>
            </a>
    
            <nav id="navmenu" class="navmenu">
              <ul>
                <li><a href="#hero" class="active">Home<br></a></li>
              </ul>
            </nav>
            
            <a class="cta-btn d-none d-sm-block" href="{{ route('registrasipasien.create') }}">Make an Appointment</a>
          </div>
        </div>
    </header>

<section class="page-title bg-1">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block text-center">
          <span class="text-white">Our blog</span>
          <h1 class="text-capitalize mb-5 text-lg">Blog articles</h1>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section blog-wrap">
    <div class="container">
        <div class="row">
            <!-- MAIN CONTENT COLUMN - Blog Articles -->
            <div class="col-lg-8">
                @forelse($articles as $article)
                <div class="blog-item mb-5">
                    <div class="blog-thumb">
                        @if($article->thumbnail)
                            <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="img-fluid">
                        @else
                            <img src="{{ asset('novena') }}/images/blog/blog-1.jpg" alt="" class="img-fluid">
                        @endif
                    </div>
        
                    <div class="blog-item-content">
                        <div class="blog-item-meta mb-3 mt-4">
                            <span class="text-black text-capitalize mr-3"><i class="icofont-calendar mr-1"></i> {{ $article->published_at->format('d M Y') }}</span>
                        </div> 
        
                        <h2 class="mt-3 mb-3"><a href="{{ route('blog.show', $article->slug) }}">{{ $article->title }}</a></h2>
        
                        <p class="mb-4">{{ Str::limit($article->ringkasan ?? $article->content, 150) }}</p>
        
                        <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-main btn-icon btn-round-full">Read More <i class="icofont-simple-right ml-2"></i></a>
                    </div>
                </div>
                @empty
                <div class="alert alert-info">
                    No articles available at the moment.
                </div>
                @endforelse
                
                <!-- Pagination -->
                <div class="row mt-5">
                    <div class="col-12">
                        {{ $articles->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
            
            <!-- SIDEBAR COLUMN -->
            <div class="col-lg-4">
                <div class="sidebar-wrap pl-lg-4 mt-5 mt-lg-0">
                    <!-- Search Widget -->
                    <div class="sidebar-widget search mb-4">
                        <h5>Search Here</h5>
                        <form action="{{ route('blog.search') }}" method="GET" class="search-form">
                            <input type="text" name="query" class="form-control" placeholder="search">
                            <button type="submit" style="background:none;border:none;"><i class="ti-search"></i></button>
                        </form>
                    </div>

                    <!-- Popular Posts Widget -->
                    <div class="sidebar-widget latest-post mb-4">
                        <h5>Popular Posts</h5>
                        @foreach($popularPosts as $post)
                        <div class="py-2">
                            <span class="text-sm text-muted">{{ $post->published_at->format('d M Y') }}</span>
                            <h6 class="my-2"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h6>
                        </div>
                        @endforeach
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget category mb-4">
                        <h5 class="mb-4">Categories</h5>
                        <ul class="list-unstyled">
                            @foreach($categories as $category)
                            <li class="align-items-center">
                                <a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a>
                                <span>({{ $category->articles_count }})</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Tags Widget -->
                    <div class="sidebar-widget tags mb-4">
                        <h5 class="mb-4">Tags</h5>
                        <a href="#">Doctors</a>
                        <a href="#">agency</a>
                        <a href="#">company</a>
                        <a href="#">medicine</a>
                        <a href="#">surgery</a>
                        <a href="#">Marketing</a>
                        <a href="#">Social Media</a>
                        <a href="#">Branding</a>
                        <a href="#">Laboratory</a>
                    </div>

                    <!-- Schedule Widget -->
                    <div class="sidebar-widget schedule-widget mb-4">
                        <h5 class="mb-4">Time Schedule</h5>
                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between align-items-center">
                                <a href="#">Monday - Friday</a>
                                <span>9:00 - 17:00</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <a href="#">Saturday</a>
                                <span>9:00 - 16:00</span>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <a href="#">Sunday</a>
                                <span>Closed</span>
                            </li>
                        </ul>
                        <div class="sidebar-contatct-info mt-4">
                            <p class="mb-0">Need Urgent Help?</p>
                            <h3>+23-4565-65768</h3>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</section>

<!-- footer Start -->
<footer id="footer" class="footer light-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="index.html" class="logo d-flex align-items-center">
          <span class="sitename">Kalisari Healthcare</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Jl.Kalisari No.20.Kel. Kalisari</p>
          <p>Kec.Pasar Rebo, Jakarta Timur</p>
          <p class="mt-3"><strong>Phone:</strong> <span>0822 9999 6577</span></p>
          <p><strong>Email:</strong> <span>kalisarihealthcare@gmail.com</span></p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href="https://www.tiktok.com/@klinikkalisarihealthcare?_t=8o8muvNKE8l&_r=1" ><i class="bi bi-tiktok"></i></a>
          <a href="https://www.instagram.com/kalisarihealthcare/"><i class="bi bi-instagram"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">About us</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Terms of service</a></li>
          <li><a href="#">Privacy policy</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Layanan Kami</h4>
        <ul>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Poli Umum</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Poli Gigi</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Poli KIA</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Periksa Hamil</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Laboratorium</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Sunat Modern</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">Vaksinasi</a></li>
        <li><i class="bx bx-chevron-right"></i> <a href="#">HomeCare</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-3 footer-newsletter">
        <h4>Jam Operasional</h4>
        <p>Senin - Sabtu</p>
        <p>08.00 - 20.00</p>
        <p>Hari Minggu dan tanggal Merah Libur</p>
    </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Medilab</strong> <span>All Rights Reserved</span></p>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you've purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
      Designed by <a href="https://bootstrapmade.com/">Ulya</a> Distributed by <a href=“https://themewagon.com>ThemeWagon
    </div>
  </div>

</footer>
   
<!-- Essential Scripts -->
<!-- Main jQuery -->
<script src="{{ asset('novena') }}/plugins/jquery/jquery.js"></script>
<!-- Bootstrap 4.3.2 -->
<script src="{{ asset('novena') }}/plugins/bootstrap/js/popper.js"></script>
<script src="{{ asset('novena') }}/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="{{ asset('novena') }}/plugins/counterup/jquery.easing.js"></script>
<!-- Slick Slider -->
<script src="{{ asset('novena') }}/plugins/slick-carousel/slick/slick.min.js"></script>
<!-- Counterup -->
<script src="{{ asset('novena') }}/plugins/counterup/jquery.waypoints.min.js"></script>

<script src="{{ asset('novena') }}/plugins/shuffle/shuffle.min.js"></script>
<script src="{{ asset('novena') }}/plugins/counterup/jquery.counterup.min.js"></script>
<!-- Google Map -->
<script src="{{ asset('novena') }}/plugins/google-map/map.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>    

<script src="{{ asset('novena') }}/js/script.js"></script>
<script src="{{ asset('novena') }}/js/contact.js"></script>

</body>
</html>