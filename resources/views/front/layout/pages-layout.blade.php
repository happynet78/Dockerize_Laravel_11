<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('pageTitle')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
    <meta name="description" content="This is meta description">
    <meta name="author" content="SawaStacks">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="/front/images/favicon.ico" type="image/x-icon">
    <link rel=icon href="/front/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/front/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/front/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/front/plugins/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('/front/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/front/css/style.css') }}">
    @stack('styles')
</head>
<body>
    <header class="sticky-top bg-white border-bottom border-default">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-white">
                <a href="index.html" class="navbar-brand">
                    <img src="/front/images/logo.pg" alt="SawaBlog" width="150px" class="img-fluid">
                </a>
                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-taget="#navigation">
                    <i class="ti-menu"></i>
                </button>

                <div class="collapse navbar-collapse text-center" id="navigation">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="index.html" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="about.html" class="nav-link">About</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-item" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pages <i class="ti-angle-down ml-1"></i>
                            </a>
                            <div class="dropdown-menu">
                                <a href="author.html" class="dropdown-item">Author</a>
                                <a href="category-posts.html" class="dropdown-item">Category Posts</a>
                                <a href="search-result.html" class="dropdown-item">Search results</a>
                                <a href="post-details.html" class="dropdown-item">Post Details</a>
                                <a href="privacy-policy.html" class="dropdown-item">Privacy Policy</a>
                                <a href="terms-conditions.html" class="dropdown-item">Terms Conditions</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="contact.html" class="nav-link">Contact</a>
                        </li>
                    </ul>

                    <!-- search -->
                    <div class="search px-4">
                        <button class="search-btn" id="searchOpen"><i class="ti-search"></i></button>
                        <div class="search-wrapper">
                            <form action="javascript:void(0);" class="h-100">
                                <input type="search" name="s" id="search-query" class="search-box pl-4" placeholder="Type to discover articles, guide &amp; tutorials...">
                            </form>
                            <button class="search-close" id="searchClose"><i class="ti-close text-dark"></i></button>
                        </div>
                    </div>
                    <!-- /search -->
                </div>
            </nav>
        </div>
    </header>
    <!-- /navigation -->

    <section class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>

    <footer class="section-sm pb-0 border-top border-default">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-3 mb-4">
                    <a href="index.html" class="mb-4 d-block">
                        <img src="/front/images/logo.png" class="img-fluid" alt="SawaBlog">
                    </a>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam ipsum voluptatem, optio nobis blanditiis non eligendi magni, illum dolores fuga beatae ducimus asperiores hic! Reiciendis repellendus vero ab incidunt rerum?
                    </p>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h6 class="mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-list">
                        <li><a href="contact-html">Contact</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li><a href="termns-conditions.html">Terms Conditions</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h6 class="mb-4">Social Links</h6>
                    <ul class="list-unstyled footer-list">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Github</a></li>
                        <li><a href="#">Linkedin</a></li>
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h6 class="mb-4">Subscribe Newsletter</h6>
                    <form class="subscription" action="javascript:void(0);" method="post">
                        <div class="position-relative">
                            <i class="ti-email email-icon"></i>
                            <input type="email" class="form-control" placeholder="Your Email Address">
                        </div>
                        <button class="btn btn-primary btn-block rouneded" type="submit">Subscribs now</button>
                    </form>
                </div>
            </div>
            <div class="scroll-top">
                <a href="javascript:void(0);" id="scrollTop"><i class="ti-angle-up"></i></a>
            </div>
            <div class="text-center">
                <p class="content">&copy; 2024 - Design &amp; Develop By SawaStacks</p>
            </div>
        </div>
    </footer>
    <script src="{{ asset('/front/plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('/front/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/front/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('/front/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>