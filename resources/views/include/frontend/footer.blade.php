<!-- Footer Area -->
<footer id="wn__footer" class="footer__area bg__cat--8 brown--color">
    <div class="footer-static-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__widget footer__menu">
                        <div class="ft__logo">
                            <a href="index.html">
                                <img src="{{ asset('frontend/images/logo/logo.jpg') }}" alt="logo">
                            </a>
                        </div>
                        <div class="footer__content">
                            <ul class="social__net social__net--2 d-flex justify-content-center">
                                <li><a href="https://www.facebook.com/"><i class="bi bi-facebook"></i></a></li>
                                <li><a href="#"><i class="bi bi-google"></i></a></li>
                                <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                                <li><a href="#"><i class="bi bi-linkedin"></i></a></li>
                                <li><a href="https://www.youtube.com/"><i class="bi bi-youtube"></i></a></li>
                            </ul>
                            <ul class="mainmenu d-flex justify-content-center">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                                <li><a href="{{ route('frontend.home') }}">All Product</a></li>
                                                     <li><a href="{{ route('frontend.contact') }}"> Contact </a></li>
                               


                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright__wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="copyright">
                        <div class="copy__right__inner text-right">
                        جميع الحقوق محفوظة                         </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="payment text-right">
                        <img src="{{ asset('frontend/images/icons/payment.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- //Footer Area -->