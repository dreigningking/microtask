<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>Default Header (Container) | Front - Admin &amp; Dashboard Template</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="../favicon.ico">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="{{asset('new/vendor/bootstrap-icons/font/bootstrap-icons.css')}}">
  <link rel="stylesheet" href="{{asset('new/vendor/hs-mega-menu/dist/hs-mega-menu.min.css')}}">

  <!-- CSS Front Template -->

  <link rel="preload" href="{{asset('new/css/theme.min.css')}}" data-hs-appearance="default" as="style">
  <link rel="preload" href="{{asset('new/css/theme-dark.min.css')}}" data-hs-appearance="dark" as="style">

  <style data-hs-appearance-onload-styles>
    *
    {
      transition: unset !important;
    }

    body
    {
      opacity: 0;
    }
  </style>

  <script>
            window.hs_config = {"autopath":"@@autopath","deleteLine":"hs-builder:delete","deleteLine:build":"hs-builder:build-delete","deleteLine:dist":"hs-builder:dist-delete","previewMode":false,"startPath":"/index.html","vars":{"themeFont":"https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap","version":"?v=1.0"},"layoutBuilder":{"extend":{"switcherSupport":true},"header":{"layoutMode":"default","containerMode":"container-fluid"},"sidebarLayout":"default"},"themeAppearance":{"layoutSkin":"default","sidebarSkin":"default","styles":{"colors":{"primary":"#377dff","transparent":"transparent","white":"#fff","dark":"132144","gray":{"100":"#f9fafc","900":"#1e2022"}},"font":"Inter"}},"languageDirection":{"lang":"en"},"skipFilesFromBundle":{"dist":["assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","assets/js/demo.js"],"build":["assets/css/theme.css","assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js","assets/js/demo.js","assets/css/theme-dark.css","assets/css/docs.css","assets/vendor/icon-set/style.css","assets/js/hs.theme-appearance.js","assets/js/hs.theme-appearance-charts.js","node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js","assets/js/demo.js"]},"minifyCSSFiles":["assets/css/theme.css","assets/css/theme-dark.css"],"copyDependencies":{"dist":{"*assets/js/theme-custom.js":""},"build":{"*assets/js/theme-custom.js":"","node_modules/bootstrap-icons/font/*fonts/**":"assets/css"}},"buildFolder":"","replacePathsToCDN":{},"directoryNames":{"src":"./src","dist":"./dist","build":"./build"},"fileNames":{"dist":{"js":"theme.min.js","css":"theme.min.css"},"build":{"css":"theme.min.css","js":"theme.min.js","vendorCSS":"vendor.min.css","vendorJS":"vendor.min.js"}},"fileTypes":"jpg|png|svg|mp4|webm|ogv|json"}
            window.hs_config.gulpRGBA = (p1) => {
  const options = p1.split(',')
  const hex = options[0].toString()
  const transparent = options[1].toString()

  var c;
  if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
    c= hex.substring(1).split('');
    if(c.length== 3){
      c= [c[0], c[0], c[1], c[1], c[2], c[2]];
    }
    c= '0x'+c.join('');
    return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',' + transparent + ')';
  }
  throw new Error('Bad Hex');
}
            window.hs_config.gulpDarken = (p1) => {
  const options = p1.split(',')

  let col = options[0].toString()
  let amt = -parseInt(options[1])
  var usePound = false

  if (col[0] == "#") {
    col = col.slice(1)
    usePound = true
  }
  var num = parseInt(col, 16)
  var r = (num >> 16) + amt
  if (r > 255) {
    r = 255
  } else if (r < 0) {
    r = 0
  }
  var b = ((num >> 8) & 0x00FF) + amt
  if (b > 255) {
    b = 255
  } else if (b < 0) {
    b = 0
  }
  var g = (num & 0x0000FF) + amt
  if (g > 255) {
    g = 255
  } else if (g < 0) {
    g = 0
  }
  return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
}
            window.hs_config.gulpLighten = (p1) => {
  const options = p1.split(',')

  let col = options[0].toString()
  let amt = parseInt(options[1])
  var usePound = false

  if (col[0] == "#") {
    col = col.slice(1)
    usePound = true
  }
  var num = parseInt(col, 16)
  var r = (num >> 16) + amt
  if (r > 255) {
    r = 255
  } else if (r < 0) {
    r = 0
  }
  var b = ((num >> 8) & 0x00FF) + amt
  if (b > 255) {
    b = 255
  } else if (b < 0) {
    b = 0
  }
  var g = (num & 0x0000FF) + amt
  if (g > 255) {
    g = 255
  } else if (g < 0) {
    g = 0
  }
  return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
}
            </script>
</head>

<body>
  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand-lg navbar-end navbar-sticky-top navbar-dark navbar-show-hide"
    data-hs-header-options='{
            "fixMoment": 1000,
            "fixEffect": "slide"
          }'>
    

    <div class="container">
      <nav class="js-mega-menu navbar-nav-wrap">
        <!-- Default Logo -->
        <a class="navbar-brand" href="./index.html" aria-label="Front">
          <img class="navbar-brand-logo" src="{{asset('new/svg/logos/logo-white.svg')}}" alt="Logo">
        </a>
        <!-- End Default Logo -->

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-default">
            <i class="bi-list"></i>
          </span>
          <span class="navbar-toggler-toggled">
            <i class="bi-x"></i>
          </span>
        </button>
        <!-- End Toggler -->

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <div class="navbar-absolute-top-scroller">
            <ul class="navbar-nav">
              <!-- Landings -->
              <li class="hs-has-mega-menu nav-item">
                <a id="landingsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle active" aria-current="page" href="#" role="button" aria-expanded="false">Landings</a>

                <!-- Mega Menu -->
                <div class="hs-mega-menu dropdown-menu w-100" aria-labelledby="landingsMegaMenu" style="min-width: 30rem;">
                  <div class="row">
                    <div class="col-lg-6 d-none d-lg-block">
                      <!-- Banner Image -->
                      <div class="navbar-dropdown-menu-banner" style="background-image: url({{asset('new/svg/components/shape-3.svg')}});">
                        <div class="navbar-dropdown-menu-banner-content">
                          <div class="mb-4">
                            <span class="h2 d-block">Branding Works</span>
                            <p>Experience a level of our quality in both design &amp; customization works.</p>
                          </div>
                          <a class="btn btn-primary btn-transition" href="#">Learn more <i class="bi-chevron-right small"></i></a>
                        </div>
                      </div>
                      <!-- End Banner Image -->
                    </div>
                    <!-- End Col -->

                    <div class="col-lg-6">
                      <div class="navbar-dropdown-menu-inner">
                        <div class="row">
                          <div class="col-sm mb-3 mb-sm-0">
                            <span class="dropdown-header">Classic</span>
                            <a class="dropdown-item " href="./landing-classic-corporate.html">Corporate</a>
                            <a class="dropdown-item " href="./landing-classic-analytics.html">Analytics <span class="badge bg-primary rounded-pill ms-1">Hot</span></a>
                            <a class="dropdown-item " href="./landing-classic-studio.html">Studio</a>
                            <a class="dropdown-item " href="./landing-classic-marketing.html">Marketing</a>
                            <a class="dropdown-item " href="./landing-classic-advertisement.html">Advertisement</a>
                            <a class="dropdown-item active" href="./landing-classic-consulting.html">Consulting</a>
                            <a class="dropdown-item " href="./landing-classic-portfolio.html">Portfolio</a>
                            <a class="dropdown-item " href="./landing-classic-software.html">Software</a>
                            <a class="dropdown-item " href="./landing-classic-business.html">Business</a>
                          </div>
                          <!-- End Col -->

                          <div class="col-sm">
                            <div class="mb-3">
                              <span class="dropdown-header">App</span>
                              <a class="dropdown-item " href="./landing-app-ui-kit.html">UI Kit</a>
                              <a class="dropdown-item " href="./landing-app-saas.html">SaaS</a>
                              <a class="dropdown-item " href="./landing-app-workflow.html">Workflow</a>
                              <a class="dropdown-item " href="./landing-app-payment.html">Payment</a>
                              <a class="dropdown-item " href="./landing-app-tool.html">Tool</a>
                            </div>

                            <span class="dropdown-header">Onepage</span>
                            <a class="dropdown-item " href="./landing-onepage-corporate.html">Corporate</a>
                            <a class="dropdown-item " href="./landing-onepage-saas.html">SaaS <span class="badge bg-primary rounded-pill ms-1">Hot</span></a>
                          </div>
                          <!-- End Col -->
                        </div>
                        <!-- End Row -->
                      </div>
                    </div>
                    <!-- End Col -->
                  </div>
                  <!-- End Row -->
                </div>
                <!-- End Mega Menu -->
              </li>
              <!-- End Landings -->

              <!-- Company -->
              <li class="hs-has-sub-menu nav-item">
                <a id="companyMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button" aria-expanded="false">Company</a>

                <!-- Mega Menu -->
                <div class="hs-sub-menu dropdown-menu" aria-labelledby="companyMegaMenu" style="min-width: 14rem;">
                  <a class="dropdown-item " href="./page-about.html">About</a>
                  <a class="dropdown-item " href="./page-services.html">Services</a>
                  <a class="dropdown-item " href="./page-customer-stories.html">Customer Stories</a>
                  <a class="dropdown-item " href="./page-customer-story.html">Customer Story</a>
                  <a class="dropdown-item " href="./page-careers.html">Careers</a>
                  <a class="dropdown-item " href="./page-careers-overview.html">Careers Overview</a>
                  <a class="dropdown-item " href="./page-hire-us.html">Hire Us</a>
                  <a class="dropdown-item " href="./page-pricing.html">Pricing</a>
                  <a class="dropdown-item " href="./page-contacts-agency.html">Contacts: Agency</a>
                  <a class="dropdown-item " href="./page-contacts-startup.html">Contacts: Startup</a>
                </div>
                <!-- End Mega Menu -->
              </li>
              <!-- End Company -->

              <!-- Account -->
              <li class="hs-has-sub-menu nav-item">
                <a id="accountMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button" aria-expanded="false">Account</a>

                <!-- Mega Menu -->
                <div class="hs-sub-menu dropdown-menu" aria-labelledby="accountMegaMenu" style="min-width: 14rem;">
                  <!-- Authentication -->
                  <div class="hs-has-sub-menu nav-item">
                    <a id="authenticationMegaMenu" class="hs-mega-menu-invoker dropdown-item dropdown-toggle " href="#" role="button" aria-expanded="false">Authentication</a>

                    <div class="hs-sub-menu dropdown-menu" aria-labelledby="authenticationMegaMenu" style="min-width: 14rem;">
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Signup Modal</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item " href="./page-login.html">Login</a>
                      <a class="dropdown-item " href="./page-signup.html">Signup</a>
                      <a class="dropdown-item " href="./page-reset-password.html">Reset Password</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item " href="./page-login-simple.html">Login Simple</a>
                      <a class="dropdown-item " href="./page-signup-simple.html">Signup Simple</a>
                      <a class="dropdown-item " href="./page-reset-password-simple.html">Reset Password Simple</a>
                    </div>
                  </div>
                  <!-- End Authentication -->

                  <a class="dropdown-item " href="./account-overview.html">Personal Info</a>
                  <a class="dropdown-item " href="./account-security.html">Security</a>
                  <a class="dropdown-item " href="./account-notifications.html">Notifications</a>
                  <a class="dropdown-item " href="./account-preferences.html">Preferences</a>
                  <a class="dropdown-item " href="./account-orders.html">Orders</a>
                  <a class="dropdown-item " href="./account-wishlist.html">Wishlist</a>
                  <a class="dropdown-item " href="./account-payments.html">Payments</a>
                  <a class="dropdown-item " href="./account-address.html">Address</a>
                  <a class="dropdown-item " href="./account-teams.html">Teams</a>
                </div>
                <!-- End Mega Menu -->
              </li>
              <!-- End Account -->

              <!-- Pages -->
              <li class="hs-has-sub-menu nav-item">
                <a id="pagesMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button" aria-expanded="false">Pages</a>

                <!-- Mega Menu -->
                <div class="hs-sub-menu dropdown-menu" aria-labelledby="pagesMegaMenu" style="min-width: 14rem;">
                  <a class="dropdown-item " href="./page-faq.html">FAQ</a>
                  <a class="dropdown-item " href="./page-terms.html">Terms &amp; Conditions</a>
                  <a class="dropdown-item " href="./page-privacy.html">Privacy &amp; Policy</a>
                  <a class="dropdown-item " href="./page-coming-soon.html">Coming Soon</a>
                  <a class="dropdown-item " href="./page-coming-soon-simple.html">Coming Soon: Simple</a>
                  <a class="dropdown-item " href="./page-maintenance-mode.html">Maintenance Mode</a>
                  <a class="dropdown-item " href="./page-status.html">Status</a>
                  <a class="dropdown-item " href="./page-invoice.html">Invoice</a>
                  <a class="dropdown-item " href="./page-error-404.html">Error 404</a>
                </div>
                <!-- End Mega Menu -->
              </li>
              <!-- End Pages -->

              <!-- Blog -->
              <li class="hs-has-sub-menu nav-item">
                <a id="blogMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button" aria-expanded="false">Blog</a>

                <!-- Mega Menu -->
                <div class="hs-sub-menu dropdown-menu" aria-labelledby="blogMegaMenu" style="min-width: 14rem;">
                  <a class="dropdown-item " href="./blog-journal.html">Journal</a>
                  <a class="dropdown-item " href="./blog-metro.html">Metro</a>
                  <a class="dropdown-item " href="./blog-newsroom.html">Newsroom</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item " href="./blog-article.html">Article</a>
                  <a class="dropdown-item " href="./blog-author-profile.html">Author Profile</a>
                </div>
                <!-- End Mega Menu -->
              </li>
              <!-- End Blog -->

              <!-- Portfolio -->
              <li class="hs-has-sub-menu nav-item">
                <a id="portfolioMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button" aria-expanded="false">Portfolio</a>

                <!-- Mega Menu -->
                <div class="hs-sub-menu dropdown-menu" aria-labelledby="portfolioMegaMenu" style="min-width: 14rem;">
                  <a class="dropdown-item " href="./portfolio-grid.html">Grid</a>
                  <a class="dropdown-item " href="./portfolio-product-article.html">Product Article</a>
                  <a class="dropdown-item " href="./portfolio-case-studies-branding.html">Case Studies: Branding</a>
                  <a class="dropdown-item " href="./portfolio-case-studies-product.html">Case Studies: Product</a>
                </div>
                <!-- End Mega Menu -->
              </li>
              <!-- End Portfolio -->

              <!-- Button -->
              <li class="nav-item">
                <a class="btn btn-light btn-transition" href="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/" target="_blank">Buy now</a>
              </li>
              <!-- End Button -->
            </ul>
          </div>
        </div>
        <!-- End Collapse -->
      </nav>
    </div>
  </header>

  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    <!-- Hero -->
    <div class="gradient-x-overlay-lg-dark-video">

      <div class="hero-bg-image" style="background-image: url('{{ asset('frontend/images/hero.jpg') }}'); background-size: cover; background-position: center; width: 100%; height: 100vh; min-height: 500px; position: absolute; top: 0; left: 0; z-index: 1;"></div>


      <div class="position-relative zi-2">
        <!-- Content -->
        <div class="d-md-flex">
          <div class="container d-md-flex align-items-md-center min-vh-md-100 text-center content-space-3 content-space-t-md-4 content-space-t-lg-3">
            <div class="w-lg-75 mx-lg-auto">
              <!-- Heading -->
              <div class="mb-7">
                <h1 class="display-4 text-white mb-3">Change is coming</h1>
                <p class="lead text-white">Attract more visitors, and win more business with Front template.</p>
              </div>
              <!-- End Title & Description -->

              <!-- Input Card -->
              <form>
                <div class="input-card input-card-sm">
                  <div class="input-card-form">
                    <label for="nameRegisterForm" class="form-label visually-hidden">Enter your name</label>
                    <input type="text" class="form-control form-control-lg" id="nameRegisterForm" placeholder="Your name" aria-label="Your name">
                  </div>
                  <div class="input-card-form">
                    <label for="emailRegisterForm" class="form-label visually-hidden">Enter email</label>
                    <input type="text" class="form-control form-control-lg" id="emailRegisterForm" placeholder="Your email" aria-label="Your email">
                  </div>
                  <button type="button" class="btn btn-primary btn-lg">Get started</button>
                </div>
              </form>
              <!-- End Input Card -->
            </div>
          </div>
        </div>
        <!-- End Content -->

        <!-- Clients -->
        <div class="position-absolute bottom-0 start-0 end-0">
          <div class="container py-5">
            <!-- Swiper Slider -->
            <div class="js-swiper-hero-clients swiper text-center">
              <div class="swiper-wrapper">
                <!-- Slide -->
                <div class="swiper-slide">
                  <img class="avatar avatar-lg avatar-4x3" src="{{asset('new/svg/brands/capsule-white.svg')}}" alt="Logo">
                </div>
                <!-- End Slide -->

                <div class="swiper-slide">
                  <img class="avatar avatar-lg avatar-4x3" src="{{asset('new/svg/brands/fitbit-white.svg')}}" alt="Logo">
                </div>
                <!-- End Slide -->

                <div class="swiper-slide">
                  <img class="avatar avatar-lg avatar-4x3" src="{{asset('new/svg/brands/forbes-white.svg')}}" alt="Logo">
                </div>
                <!-- End Slide -->

                <div class="swiper-slide">
                  <img class="avatar avatar-lg avatar-4x3" src="{{asset('new/svg/brands/mailchimp-white.svg')}}" alt="Logo">
                </div>
                <!-- End Slide -->

                <div class="swiper-slide">
                  <img class="avatar avatar-lg avatar-4x3" src="{{asset('new/svg/brands/layar-white.svg')}}" alt="Logo">
                </div>
                <!-- End Slide -->

                <div class="swiper-slide">
                  <img class="avatar avatar-lg avatar-4x3" src="{{asset('new/svg/brands/hubspot-white.svg')}}" alt="Logo">
                </div>
                <!-- End Slide -->
              </div>
            </div>
            <!-- End Swiper Slider -->
          </div>
        </div>
        <!-- End Clients -->
      </div>
    </div>
    <!-- End Hero -->

    <!-- Icon Blocks -->
    <!-- Card Grid -->
    <div class="container content-space-2 content-space-t-lg-3 content-space-b-lg-3">
      <!-- Heading -->
      <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-7">
        <h2>Explore over 2 million tech and startup job-opportunities</h2>
        <p>Find a job you love. <a class="link" href="#">Set your career interests.</a></p>
      </div>
      <!-- End Heading -->

      <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 mb-5">
        <div class="col mb-5">
          <!-- Card -->
          <div class="card card-bordered h-100">
            <!-- Card Body -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  <!-- Media -->
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img class="avatar avatar-sm avatar-4x3" src="{{asset('new/svg/brands/mailchimp-icon.svg')}}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <h6 class="card-title">
                        <a class="text-dark" href="../demo-jobs/employer.html">Mailchimp</a>
                        <img class="avatar avatar-xss ms-1" src="{{asset('new/svg/illustrations/top-vendor.svg')}}" alt="Review rating" data-toggle="tooltip" data-placement="top" title="Claimed profile">
                      </h6>
                    </div>
                  </div>
                  <!-- End Media -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->

              <h3 class="card-title">
                <a class="text-dark" href="../demo-jobs/employer.html">Senior B2B sales consultant</a>
              </h3>

              <span class="d-block small text-body mb-1">$125k-$135k yearly</span>

              <span class="badge bg-soft-info text-info me-2">
                <span class="legend-indicator bg-info"></span>Remote
              </span>
            </div>
            <!-- End Card Body -->

            <!-- Card Footer -->
            <div class="card-footer pt-0">
              <ul class="list-inline list-separator small text-body">
                <li class="list-inline-item">Posted 7 hours ago</li>
                <li class="list-inline-item">Oxford</li>
                <li class="list-inline-item">Full time</li>
              </ul>
            </div>
            <!-- End Card Footer -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col mb-5">
          <!-- Card -->
          <div class="card card-bordered h-100">
            <!-- Card Body -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  <!-- Media -->
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img class="avatar avatar-sm avatar-4x3" src="{{asset('new/svg/brands/capsule-icon.svg')}}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <h6 class="card-title">
                        <a class="text-dark" href="../demo-jobs/employer.html">Capsule</a>
                      </h6>
                    </div>
                  </div>
                  <!-- End Media -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->

              <h3 class="card-title">
                <a class="text-dark" href="../demo-jobs/employer.html">Office assistant/Social media assistant</a>
              </h3>

              <span class="d-block small text-body mb-1">$50-$135 hourly</span>
            </div>
            <!-- End Card Body -->

            <!-- Card Footer -->
            <div class="card-footer pt-0">
              <ul class="list-inline list-separator small text-body">
                <li class="list-inline-item">Posted 21 hours ago</li>
                <li class="list-inline-item">Newcastle</li>
                <li class="list-inline-item">Part time</li>
              </ul>
            </div>
            <!-- End Card Footer -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col mb-5">
          <!-- Card -->
          <div class="card card-bordered h-100">
            <!-- Card Body -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  <!-- Media -->
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img class="avatar avatar-sm avatar-4x3" src="{{asset('new/svg/brands/dropbox-icon.svg')}}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <h6 class="card-title">
                        <a class="text-dark" href="../demo-jobs/employer.html">Dropbox</a>
                      </h6>
                    </div>
                  </div>
                  <!-- End Media -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->

              <h3 class="card-title">
                <a class="text-dark" href="../demo-jobs/employer.html">Marketing and Communications Manager</a>
              </h3>

              <span class="d-block small text-body mb-1">$5k monthly</span>
            </div>
            <!-- End Card Body -->

            <!-- Card Footer -->
            <div class="card-footer pt-0">
              <ul class="list-inline list-separator small text-body">
                <li class="list-inline-item">Posted 1 day ago</li>
                <li class="list-inline-item">London</li>
                <li class="list-inline-item">Full time</li>
              </ul>
            </div>
            <!-- End Card Footer -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col mb-5">
          <!-- Card -->
          <div class="card card-bordered h-100">
            <!-- Card Body -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  <!-- Media -->
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img class="avatar avatar-sm avatar-4x3" src="{{asset('new/svg/brands/prosperops-icon.svg')}}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <h6 class="card-title">
                        <a class="text-dark" href="../demo-jobs/employer.html">Prosperops</a>
                      </h6>
                    </div>
                  </div>
                  <!-- End Media -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->

              <h3 class="card-title">
                <a class="text-dark" href="../demo-jobs/employer.html">Senior backend developer</a>
              </h3>

              <span class="d-block small text-body mb-1">$75k-$85k yearly</span>

              <span class="badge bg-soft-info text-info me-2">
                <span class="legend-indicator bg-info"></span>Remote
              </span>
            </div>
            <!-- End Card Body -->

            <!-- Card Footer -->
            <div class="card-footer pt-0">
              <ul class="list-inline list-separator small text-body">
                <li class="list-inline-item">Posted 1 day ago</li>
                <li class="list-inline-item">Liverpool</li>
                <li class="list-inline-item">Full time</li>
              </ul>
            </div>
            <!-- End Card Footer -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col mb-5">
          <!-- Card -->
          <div class="card card-bordered h-100">
            <!-- Card Body -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  <!-- Media -->
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img class="avatar avatar-sm avatar-4x3" src="{{asset('new/svg/brands/airbnb-icon.svg')}}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <h6 class="card-title">
                        <a class="text-dark" href="../demo-jobs/employer.html">Airbnb</a>
                        <img class="avatar avatar-xss ms-1" src="{{asset('new/svg/illustrations/top-vendor.svg')}}" alt="Review rating" data-toggle="tooltip" data-placement="top" title="Claimed profile">
                      </h6>
                    </div>
                  </div>
                  <!-- End Media -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->

              <h3 class="card-title">
                <a class="text-dark" href="../demo-jobs/employer.html">Senior product manager</a>
              </h3>

              <span class="d-block small text-body mb-1">$76k-$98k yearly</span>
            </div>
            <!-- End Card Body -->

            <!-- Card Footer -->
            <div class="card-footer pt-0">
              <ul class="list-inline list-separator small text-body">
                <li class="list-inline-item">Posted 2 days ago</li>
                <li class="list-inline-item">London</li>
                <li class="list-inline-item">Full time</li>
              </ul>
            </div>
            <!-- End Card Footer -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->

        <div class="col mb-5">
          <!-- Card -->
          <div class="card card-bordered h-100">
            <!-- Card Body -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col">
                  <!-- Media -->
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                      <img class="avatar avatar-sm avatar-4x3" src="{{asset('new/svg/brands/guideline-icon.svg')}}" alt="Image Description">
                    </div>

                    <div class="flex-grow-1 ms-3">
                      <h6 class="card-title">
                        <a class="text-dark" href="../demo-jobs/employer.html">Guideline</a>
                      </h6>
                    </div>
                  </div>
                  <!-- End Media -->
                </div>
                <!-- End Col -->
              </div>
              <!-- End Row -->

              <h3 class="card-title">
                <a class="text-dark" href="../demo-jobs/employer.html">iOS Engineer</a>
              </h3>

              <span class="d-block small text-body mb-1">$500-$1000 weekly</span>

              <span class="badge bg-soft-info text-info me-2">
                <span class="legend-indicator bg-info"></span>Remote
              </span>
            </div>
            <!-- End Card Body -->

            <!-- Card Footer -->
            <div class="card-footer pt-0">
              <ul class="list-inline list-separator small text-body">
                <li class="list-inline-item">Posted 3 days ago</li>
                <li class="list-inline-item">Manchester</li>
                <li class="list-inline-item">Part time</li>
              </ul>
            </div>
            <!-- End Card Footer -->
          </div>
          <!-- End Card -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->

      <div class="text-center">
        <a class="btn btn-outline-primary" href="../demo-jobs/job-list.html">View all jobs <i class="bi-chevron-right small ms-1"></i></a>
      </div>
    </div>
    <!-- End Card Grid -->
    <div class="overflow-hidden gradient-x-three-sm-primary rounded-2 mx-md-10">
      <div class="container content-space-2 content-space-lg-3">
        <!-- Heading -->
        <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-7">
          <h2>Explore Startups</h2>
          <p>Find a job you love. <a class="link" href="#">Set your career interests.</a></p>
        </div>
        <!-- End Heading -->

        <div class="row row-cols-1 row-cols-sm-2 1 row-cols-md-3 row-cols-lg-4 mb-5">
          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">Management</h5>
                    <p class="card-text text-body small">4 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">App Development</h5>
                    <p class="card-text text-body small">26 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">Arts &amp; Entertainment</h5>
                    <p class="card-text text-body small">9 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">Accounting</h5>
                    <p class="card-text text-body small">11 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">UI Designer</h5>
                    <p class="card-text text-body small">37 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">Apps</h5>
                    <p class="card-text text-body small">2 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">Content Writer</h5>
                    <p class="card-text text-body small">10 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->

          <div class="col mb-3 mb-sm-4">
            <!-- Card -->
            <a class="card card-sm card-bordered card-transition h-100" href="../demo-jobs/job-overview.html">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h5 class="card-title text-inherit">Analytics</h5>
                    <p class="card-text text-body small">14 job positions</p>
                  </div>
                  <!-- End Col -->

                  <div class="col-auto">
                    <span class="text-muted">
                      <i class="bi-chevron-right small"></i>
                    </span>
                  </div>
                  <!-- End Col -->
                </div>
                <!-- End Row -->
              </div>
            </a>
            <!-- End Card -->
          </div>
          <!-- End Col -->
        </div>
        <!-- End Row -->

        <div class="text-center">
          <a class="btn btn-outline-primary" href="../demo-jobs/job-list.html">View all startups <i class="bi-chevron-right small ms-1"></i></a>
        </div>
      </div>
    </div>






  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- ========== FOOTER ========== -->
  <footer class="bg-dark">
    <div class="container pb-1 pb-lg-5">
      <div class="row content-space-t-2">
        <div class="col-lg-3 mb-7 mb-lg-0">
          <!-- Logo -->
          <div class="mb-5">
            <a class="navbar-brand" href="./index.html" aria-label="Space">
              <img class="navbar-brand-logo" src="{{asset('new/svg/logos/logo-white.svg')}}" alt="Image Description">
            </a>
          </div>
          <!-- End Logo -->

          <!-- List -->
          <ul class="list-unstyled list-py-1">
            <li><a class="link-sm link-light" href="#"><i class="bi-geo-alt-fill me-1"></i> 153 Williamson Plaza, Maggieberg</a></li>
            <li><a class="link-sm link-light" href="tel:1-062-109-9222"><i class="bi-telephone-inbound-fill me-1"></i> +1 (062) 109-9222</a></li>
          </ul>
          <!-- End List -->

        </div>
        <!-- End Col -->

        <div class="col-sm mb-7 mb-sm-0">
          <h5 class="text-white mb-3">Company</h5>

          <!-- List -->
          <ul class="list-unstyled list-py-1 mb-0">
            <li><a class="link-sm link-light" href="#">About</a></li>
            <li><a class="link-sm link-light" href="#">Careers <span class="badge bg-warning text-dark rounded-pill ms-1">We're hiring</span></a></li>
            <li><a class="link-sm link-light" href="#">Blog</a></li>
            <li><a class="link-sm link-light" href="#">Customers <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
            <li><a class="link-sm link-light" href="#">Hire us</a></li>
          </ul>
          <!-- End List -->
        </div>
        <!-- End Col -->

        <div class="col-sm mb-7 mb-sm-0">
          <h5 class="text-white mb-3">Features</h5>

          <!-- List -->
          <ul class="list-unstyled list-py-1 mb-0">
            <li><a class="link-sm link-light" href="#">Press <i class="bi-box-arrow-up-right small ms-1"></i></a></li>
            <li><a class="link-sm link-light" href="#">Release Notes</a></li>
            <li><a class="link-sm link-light" href="#">Integrations</a></li>
            <li><a class="link-sm link-light" href="#">Pricing</a></li>
          </ul>
          <!-- End List -->
        </div>
        <!-- End Col -->

        <div class="col-sm mb-7 mb-sm-0">
          <h5 class="text-white mb-3">Documentation</h5>

          <!-- List -->
          <ul class="list-unstyled list-py-1 mb-0">
            <li><a class="link-sm link-light" href="#">Support</a></li>
            <li><a class="link-sm link-light" href="#">Docs</a></li>
            <li><a class="link-sm link-light" href="#">Status</a></li>
            <li><a class="link-sm link-light" href="#">API Reference</a></li>
            <li><a class="link-sm link-light" href="#">Tech Requirements</a></li>
          </ul>
          <!-- End List -->
        </div>
        <!-- End Col -->

        <div class="col-sm">
          <h5 class="text-white mb-3">Resources</h5>

          <!-- List -->
          <ul class="list-unstyled list-py-1 mb-5">
            <li><a class="link-sm link-light" href="#"><i class="bi-question-circle-fill me-1"></i> Help</a></li>
            <li><a class="link-sm link-light" href="#"><i class="bi-person-circle me-1"></i> Your Account</a></li>
          </ul>
          <!-- End List -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->

      <div class="border-top border-white-10 my-7"></div>

      <div class="row mb-7">
        <div class="col-sm mb-3 mb-sm-0">
          <!-- Socials -->
          <ul class="list-inline list-separator list-separator-light mb-0">
            <li class="list-inline-item">
              <a class="link-sm link-light" href="#">Privacy &amp; Policy</a>
            </li>
            <li class="list-inline-item">
              <a class="link-sm link-light" href="#">Terms</a>
            </li>
            <li class="list-inline-item">
              <a class="link-sm link-light" href="#">Site Map</a>
            </li>
          </ul>
          <!-- End Socials -->
        </div>

        <div class="col-sm-auto">
          <!-- Socials -->
          <ul class="list-inline mb-0">
            <li class="list-inline-item">
              <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                <i class="bi-facebook"></i>
              </a>
            </li>

            <li class="list-inline-item">
              <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                <i class="bi-google"></i>
              </a>
            </li>

            <li class="list-inline-item">
              <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                <i class="bi-twitter"></i>
              </a>
            </li>

            <li class="list-inline-item">
              <a class="btn btn-soft-light btn-xs btn-icon" href="#">
                <i class="bi-github"></i>
              </a>
            </li>

            <li class="list-inline-item">
              <!-- Button Group -->
              <div class="btn-group">
                <button type="button" class="btn btn-soft-light btn-xs dropdown-toggle" id="footerSelectLanguage" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                  <span class="d-flex align-items-center">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{asset('new/vendor/flag-icon-css/flags/1x1/us.svg')}}" alt="Image description" width="16" />
                    <span>English (US)</span>
                  </span>
                </button>

                <div class="dropdown-menu" aria-labelledby="footerSelectLanguage">
                  <a class="dropdown-item d-flex align-items-center active" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{asset('new/vendor/flag-icon-css/flags/1x1/us.svg')}}" alt="Image description" width="16" />
                    <span>English (US)</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{asset('new/vendor/flag-icon-css/flags/1x1/de.svg')}}" alt="Image description" width="16" />
                    <span>Deutsch</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{asset('new/vendor/flag-icon-css/flags/1x1/es.svg')}}" alt="Image description" width="16" />
                    <span>Español</span>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="avatar avatar-xss avatar-circle me-2" src="{{asset('new/vendor/flag-icon-css/flags/1x1/cn.svg')}}" alt="Image description" width="16" />
                    <span>中文 (繁體)</span>
                  </a>
                </div>
              </div>
              <!-- End Button Group -->
            </li>
          </ul>
          <!-- End Socials -->
        </div>
      </div>

      <!-- Copyright -->
      <div class="w-md-85 text-lg-center mx-lg-auto">
        <p class="text-white-50 small">&copy; Front. 2021 Htmlstream. All rights reserved.</p>
        <p class="text-white-50 small">When you visit or interact with our sites, services or tools, we or our authorised service providers may use cookies for storing information to help provide you with a better, faster and safer experience and for marketing purposes.</p>
      </div>
      <!-- End Copyright -->
    </div>
  </footer>

  <!-- ========== END FOOTER ========== -->

  <!-- ========== SECONDARY CONTENTS ========== -->
  <!-- Sign Up -->
  <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <!-- Header -->
        <div class="modal-close">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="modal-body">
          <!-- Log in -->
          <div id="signupModalFormLogin" style="display: none; opacity: 0;">
            <!-- Heading -->
            <div class="text-center mb-7">
              <h2>Log in</h2>
              <p>Don't have an account yet?
                <a class="js-animation-link link" href="javascript:;" role="button"
                  data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormSignup",
                         "groupName": "idForm"
                       }'>Sign up</a>
              </p>
            </div>
            <!-- End Heading -->

            <div class="d-grid gap-2">
              <a class="btn btn-white btn-lg" href="#">
                <span class="d-flex justify-content-center align-items-center">
                  <img class="avatar avatar-xss me-2" src="{{asset('new/svg/brands/google-icon.svg')}}" alt="Image Description">
                  Log in with Google
                </span>
              </a>

              <a class="js-animation-link btn btn-primary btn-lg" href="#"
                data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormLoginWithEmail",
                       "groupName": "idForm"
                     }'>Log in with Email</a>
            </div>
          </div>
          <!-- End Log in -->

          <!-- Log in with Modal -->
          <div id="signupModalFormLoginWithEmail" style="display: none; opacity: 0;">
            <!-- Heading -->
            <div class="text-center mb-7">
              <h2>Log in</h2>
              <p>Don't have an account yet?
                <a class="js-animation-link link" href="javascript:;" role="button"
                  data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormSignup",
                         "groupName": "idForm"
                       }'>Sign up</a>
              </p>
            </div>
            <!-- End Heading -->

            <form class="js-validate needs-validation" novalidate>
              <!-- Form -->
              <div class="mb-3">
                <label class="form-label" for="signupModalFormLoginEmail">Your email</label>
                <input type="email" class="form-control form-control-lg" name="email" id="signupModalFormLoginEmail" placeholder="email@site.com" aria-label="email@site.com" required>
                <span class="invalid-feedback">Please enter a valid email address.</span>
              </div>
              <!-- End Form -->

              <!-- Form -->
              <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormLoginPassword">Password</label>

                  <a class="js-animation-link form-label-link" href="javascript:;"
                    data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormResetPassword",
                       "groupName": "idForm"
                     }'>Forgot Password?</a>
                </div>

                <input type="password" class="form-control form-control-lg" name="password" id="signupModalFormLoginPassword" placeholder="8+ characters required" aria-label="8+ characters required" required minlength="8">
                <span class="invalid-feedback">Please enter a valid password.</span>
              </div>
              <!-- End Form -->

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary form-control-lg">Log in</button>
              </div>
            </form>
          </div>
          <!-- End Log in with Modal -->

          <!-- Sign up -->
          <div id="signupModalFormSignup">
            <!-- Heading -->
            <div class="text-center mb-7">
              <h2>Sign up</h2>
              <p>Already have an account?
                <a class="js-animation-link link" href="javascript:;" role="button"
                  data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>Log in</a>
              </p>
            </div>
            <!-- End Heading -->

            <div class="d-grid gap-3">
              <a class="btn btn-white btn-lg" href="#">
                <span class="d-flex justify-content-center align-items-center">
                  <img class="avatar avatar-xss me-2" src="{{asset('new/svg/brands/google-icon.svg')}}" alt="Image Description">
                  Sign up with Google
                </span>
              </a>

              <a class="js-animation-link btn btn-primary btn-lg" href="#"
                data-hs-show-animation-options='{
                       "targetSelector": "#signupModalFormSignupWithEmail",
                       "groupName": "idForm"
                     }'>Sign up with Email</a>

              <div class="text-center">
                <p class="small mb-0">By continuing you agree to our <a href="#">Terms and Conditions</a></p>
              </div>
            </div>
          </div>
          <!-- End Sign up -->

          <!-- Sign up with Modal -->
          <div id="signupModalFormSignupWithEmail" style="display: none; opacity: 0;">
            <!-- Heading -->
            <div class="text-center mb-7">
              <h2>Sign up</h2>
              <p>Already have an account?
                <a class="js-animation-link link" href="javascript:;" role="button"
                  data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>Log in</a>
              </p>
            </div>
            <!-- End Heading -->

            <form class="js-validate need-validate" novalidate>
              <!-- Form -->
              <div class="mb-3">
                <label class="form-label" for="signupModalFormSignupEmail">Your email</label>
                <input type="email" class="form-control form-control-lg" name="email" id="signupModalFormSignupEmail" placeholder="email@site.com" aria-label="email@site.com" required>
                <span class="invalid-feedback">Please enter a valid email address.</span>
              </div>
              <!-- End Form -->

              <!-- Form -->
              <div class="mb-3">
                <label class="form-label" for="signupModalFormSignupPassword">Password</label>
                <input type="password" class="form-control form-control-lg" name="password" id="signupModalFormSignupPassword" placeholder="8+ characters required" aria-label="8+ characters required" required>
                <span class="invalid-feedback">Your password is invalid. Please try again.</span>
              </div>
              <!-- End Form -->

              <!-- Form -->
              <div class="mb-3" data-hs-validation-validate-class>
                <label class="form-label" for="signupModalFormSignupConfirmPassword">Confirm password</label>
                <input type="password" class="form-control form-control-lg" name="confirmPassword" id="signupModalFormSignupConfirmPassword" placeholder="8+ characters required" aria-label="8+ characters required" required
                  data-hs-validation-equal-field="#signupModalFormSignupPassword">
                <span class="invalid-feedback">Password does not match the confirm password.</span>
              </div>
              <!-- End Form -->

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary form-control-lg">Sign up</button>
              </div>

              <div class="text-center">
                <p class="small mb-0">By continuing you agree to our <a href="#">Terms and Conditions</a></p>
              </div>
            </form>
          </div>
          <!-- End Sign up with Modal -->

          <!-- Reset Password -->
          <div id="signupModalFormResetPassword" style="display: none; opacity: 0;">
            <!-- Heading -->
            <div class="text-center mb-7">
              <h2>Forgot password?</h2>
              <p>Enter the email address you used when you joined and we'll send you instructions to reset your password.</p>
            </div>
            <!-- En dHeading -->

            <form class="js-validate need-validate" novalidate>
              <div class="mb-3">
                <!-- Form -->
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label" for="signupModalFormResetPasswordEmail" tabindex="0">Your email</label>

                  <a class="js-animation-link form-label-link" href="javascript:;"
                    data-hs-show-animation-options='{
                         "targetSelector": "#signupModalFormLogin",
                         "groupName": "idForm"
                       }'>
                    <i class="bi-chevron-left small"></i> Back to Log in
                  </a>
                </div>

                <input type="email" class="form-control form-control-lg" name="email" id="signupModalFormResetPasswordEmail" tabindex="1" placeholder="Enter your email address" aria-label="Enter your email address" required>
                <span class="invalid-feedback">Please enter a valid email address.</span>
                <!-- End Form -->
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary form-control-lg">Submit</button>
              </div>
            </form>
          </div>
          <!-- End Reset Password -->
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="modal-footer d-block text-center py-sm-5">
          <small class="text-cap mb-4">Trusted by the world's best teams</small>

          <div class="w-85 mx-auto">
            <div class="row justify-content-between">
              <div class="col">
                <img class="img-fluid" src="{{asset('new/svg/brands/gitlab-gray.svg')}}" alt="Logo">
              </div>
              <!-- End Col -->

              <div class="col">
                <img class="img-fluid" src="{{asset('new/svg/brands/fitbit-gray.svg')}}" alt="Logo">
              </div>
              <!-- End Col -->

              <div class="col">
                <img class="img-fluid" src="{{asset('new/svg/brands/flow-xo-gray.svg')}}" alt="Logo">
              </div>
              <!-- End Col -->

              <div class="col">
                <img class="img-fluid" src="{{asset('new/svg/brands/layar-gray.svg')}}" alt="Logo">
              </div>
              <!-- End Col -->
            </div>
          </div>
          <!-- End Row -->
        </div>
        <!-- End Footer -->
      </div>
    </div>
  </div>

  <!-- Go To -->
  <a class="js-go-to go-to position-fixed" href="javascript:;" style="visibility: hidden;"
    data-hs-go-to-options='{
       "offsetTop": 700,
       "position": {
         "init": {
           "right": "2rem"
         },
         "show": {
           "bottom": "2rem"
         },
         "hide": {
           "bottom": "-2rem"
         }
       }
     }'>
    <i class="bi-chevron-up"></i>
  </a>

  <!-- Page Preloader -->
  <div id="jsPreloader" class="page-preloader">
    <div class="page-preloader-middle gap-2">
      <span class="spinner-grow text-primary" role="status" aria-hidden="true"></span>
      <span>Loading...</span>
    </div>
  </div>
  <!-- End Page Preloader -->
  <!-- ========== END SECONDARY CONTENTS ========== -->

  <!-- JS Global Compulsory  -->
  <script src="{{asset('new/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

  <!-- JS Implementing Plugins -->
  <script src="{{asset('new/vendor/hs-header/dist/hs-header.min.js')}}"></script>
  <script src="{{asset('new/vendor/hs-mega-menu/dist/hs-mega-menu.min.js')}}"></script>
  <script src="{{asset('new/vendor/hs-show-animation/dist/hs-show-animation.min.js')}}"></script>
  <script src="{{asset('new/vendor/hs-go-to/dist/hs-go-to.min.js')}}"></script>
  <script src="{{asset('new/vendor/aos/dist/aos.js')}}"></script>
  <script src="{{asset('new/vendor/hs-video-bg/dist/hs-video-bg.min.js')}}"></script>
  <script src="{{asset('new/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- JS Front -->
  <script src="{{asset('new/js/theme.min.js')}}"></script>

  <!-- JS Plugins Init. -->
  <script>
    (function() {
      // INITIALIZATION OF HEADER
      // =======================================================
      new HSHeader('#header').init()


      // INITIALIZATION OF MEGA MENU
      // =======================================================
      new HSMegaMenu('.js-mega-menu', {
        desktop: {
          position: 'left'
        }
      })


      // INITIALIZATION OF SHOW ANIMATIONS
      // =======================================================
      new HSShowAnimation('.js-animation-link')


      // INITIALIZATION OF BOOTSTRAP VALIDATION
      // =======================================================
      HSBsValidation.init('.js-validate', {
        onSubmit: data => {
          data.event.preventDefault()
          alert('Submited')
        }
      })


      // INITIALIZATION OF BOOTSTRAP DROPDOWN
      // =======================================================
      HSBsDropdown.init()


      // INITIALIZATION OF GO TO
      // =======================================================
      new HSGoTo('.js-go-to')


      // INITIALIZATION OF AOS
      // =======================================================
      AOS.init({
        duration: 650,
        once: true
      });


      // INITIALIZATION OF VIDEO BG
      // =======================================================
      document.querySelectorAll('.js-video-bg').forEach(item => {
        new HSVideoBg(item).init()
      })


      // INITIALIZATION OF SWIPER
      // =======================================================
      var swiper = new Swiper('.js-swiper-hero-clients', {
        slidesPerView: 2,
        breakpoints: {
          480: {
            slidesPerView: 4,
            spaceBetween: 15,
          },
          768: {
            slidesPerView: 4,
            spaceBetween: 15,
          },
          1024: {
            slidesPerView: 6,
            spaceBetween: 15,
          },
        },
      });


      // PAGE PRELOADER
      // =======================================================
      setTimeout(() => {
        const preloader = document.getElementById('jsPreloader')
        preloader.style.opacity = 0

        setTimeout(() => {
          preloader.parentNode.removeChild(preloader)
        }, 500)
      }, 1000)
    })()
  </script>
</body>

</html>