@extends('layouts.site')

@section('content')
<!-- Page Book Table Start -->
    <div class="page-book-table">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <!-- Book Table Image Start -->
                    <div class="book-table-image">
                        <figure class="image-anime">
                            <img src="assets/images/book-table-image.jpg" alt="">
                        </figure>
                    </div>
                    <!-- Book Table Image End -->
                </div>

                <div class="col-lg-6">
                    <!-- Book Table Content Start -->
                    <div class="book-table-content">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h3 class="wow fadeInUp">Book a table</h3>
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Online Reservation</h2>
                            <p class="wow fadeInUp" data-wow-delay="0.2s">Book your favorite table or pre-order your brews effortlessly with our seamless online system. Enjoy convenience at your fingertips!</p>
                            <p class="wow fadeInUp" data-wow-delay="0.4s"><b>Booking request <a href="tel:+123456789">+123 456 789</a> or fill out the order form</b></p>
                        </div>
                        <!-- Section Title End -->

                        <!-- Contact Us Form Start -->
                        <div class="contact-us-form wow fadeInUp" data-wow-delay="0.6s">
                            <form id="appointmentForm" action="#" method="POST" data-toggle="validator">
                                <div class="row">
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-6 mb-5">
                                        <input type="email" name ="email" class="form-control" id="email" placeholder="Email Address" required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    
                                    <div class="form-group col-md-6 mb-5">
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-6 mb-5">
                                        <input type="date" name="date" class="form-control" id="date" required>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="form-group col-md-6 mb-5">
                                        <select name="time" class="form-control form-select" id="time" required>
                                            <option value="" disabled selected>Time</option>
                                            <option value="6_30pm">06:30 PM</option>
                                            <option value="7_00pm">07:00 PM</option>
                                            <option value="7_30pm">07:30 PM</option>
                                            <option value="8_00pm">08:00 PM</option>
                                            <option value="8_30pm">08:30 PM</option>
                                            <option value="9_00pm">09:00 PM</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="book-table-btn">
                                            <button type="submit" class="btn-default">Book a table</button>
                                            <div id="msgSubmit" class="h3 hidden"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Contact Us Form End -->
                    </div>
                    <!-- Book Table Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Book Table End -->

@endsection