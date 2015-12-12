<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
    <head>
        <meta charset="utf-8" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>E-Club | IIT Patna</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5" />

        <!--<link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,700|Titillium+Web:400,600' rel='stylesheet' type='text/css'>-->
        <link href="css/reset.css" rel="stylesheet">
        <link href="css/floater.css" rel="stylesheet">
        <link href="css/calendar.css" rel="stylesheet">
        <link href="css/foundation.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/isotope.css" rel="stylesheet">
        <link href="css/jquery.fancybox-1.3.4.css" rel="stylesheet">
        <link href="css/validationEngine.jquery.css" rel="stylesheet">
        <link href="css/archtek-init.css" rel="stylesheet">

        <!--[if IE 8]>
        <link href="css/foundation-ie8.css" rel="stylesheet">
        <link href="css/archtek-ie8.css" rel="stylesheet">
        <![endif]-->

        <script src="js/custom.modernizr.js"></script>
        <script type="text/javascript">
            function generateCalendar (month, year) {
                var dates = showEvents(month, year);
                var flag = true;
                if(dates.length == 0)
                    flag = false;
                dates_i = 0;
                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var monthDays = [31, 28, 31, 30 , 31, 30, 31, 31, 30, 31, 30 , 31];

                //alert(month+","+year);

                if (((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0))
                    monthDays[1] = 29;

                var nDays = monthDays[month - 1];
                var firstDay = new Date();
                firstDay.setDate(1);
                firstDay.setMonth(month - 1);
                var startDay = firstDay.getDay();


                for (var i = 0; i < 6; i++) {
                    for (var j = 0; j < 7; j++) {
                        var d = document.getElementById(i+"_"+j);
                        d.innerHTML = "";
                    };
                };


                var i = 0;
                for (; i < startDay; i++) {
                    var d = document.getElementById("0_"+i);
                    d.innerHTML = "";
                };

                var startDate = 1;
                for (var count = 0; count < 6; count++) {
                    while(startDate <= nDays){
                        var d = document.getElementById(count+"_"+i);
                        d.style.background = "white";
                        if(i == 0)
                            d.style.color = "red";
                        else
                            d.style.color = "black";
                        if(flag && startDate == parseInt(dates[dates_i])){
                            d.style.background = "black";
                            d.style.color = "white";
                            dates_i ++;
                        }
                        d.innerHTML = startDate;
                        startDate ++;
                        i++;
                        if(i == 7){
                            i = 0;
                            break;
                        }
                    }
                };

                generateTitle(month, year);
            }
            function generateTitle(month, year){
                var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                var title = months[month - 1]+" "+year;
                var d = document.getElementById("calendar_title");
                var next = "next('"+month+"', '"+year+"')";
                var prev = "prev('"+month+"', '"+year+"')";
                d.innerHTML = '<a href="javascript: '+prev+'"><img src="images/prev.png"></a><b style="color:black; font-size:15px">'+title+'</b><a href="javascript: '+next+'"><img src="images/next.png"></a>';
            }
            function prev(month, year){
                var m = parseInt(month) - 1;
                var y = parseInt(year);
                if(m < 1){
                    m = 12;
                    y = y - 1;
                }
                month = m.toString();
                year = y.toString();
                generateCalendar(month, year);
            }
            function next(month, year){
                var m = parseInt(month) + 1;
                var y = parseInt(year);
                if(m > 12){
                    m = 1;
                    y = y + 1;
                }
                month = m.toString();
                year = y.toString();
                generateCalendar(month, year);
            }
            function showEvents(month, year){
                var res = "";
                var xmlHttp = new XMLHttpRequest();

                if(xmlHttp != null){
                    xmlHttp.open("GET", "php/events_calendar.php?month="+month+"&year="+year, false);
                    xmlHttp.send(null);
                    res = xmlHttp.responseText;
                }

                var ans = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b style="font-weight:bold; text-decoration:underline">EVENTS</b><br/><ul style="list-style: none">';
                var date_array = [];

                res = res.substring(1, res.length - 1);
                var index = res.indexOf("}");
                while(index != -1){
                    var sub = res.substring(1, index);
                    var title_index = sub.indexOf("title");

                    var splits = sub.split(",");
                    var day = splits[1];
                    var month = splits[2];
                    var year = splits[3];
                    var title = splits[4];
                    var desc = splits[5];
                    day = day.substring(day.indexOf(":") + 1);
                    day = day.substring(1, day.length - 1);
                    date_array[date_array.length] = day;
                    month = month.substring(month.indexOf(":") + 1);
                    month = month.substring(1, month.length - 1);
                    year = year.substring(year.indexOf(":") + 1);
                    year = year.substring(1, year.length - 1);
                    var date = day+"/"+month+"/"+year;
                    title = title.substring(title.indexOf(":") + 1);
                    title = title.substring(1, title.length - 1);
                    desc = desc.substring(desc.indexOf(":") + 1);
                    desc = desc.substring(1, desc.length - 1);
                    if(desc != "")
                        ans += '<li><b style="font-weight:bold">'+date+":  "+title+'</b> -- '+desc+'</li>';
                    else
                        ans += '<li><b style="font-weight:bold">'+date+":  "+title+'</b></li>';


                    res = res.substring(index+2);
                    index = res.indexOf("}");

                }
                ans += "</ul>";

                if(ans == '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b style="font-weight:bold; text-decoration:underline">EVENTS</b><br/><ul style="list-style: none"></ul>')
                    ans = '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<b style="font-weight:bold; text-decoration:underline">EVENTS</b><br/><ul style="list-style: none;"><li>&nbsp&nbsp&nbsp&nbsp&nbsp&nbspNo Events yet in this month.</li></ul>';

                var d = document.getElementById("showEvents");
                d.innerHTML = ans;

                return date_array;
            }
        </script>

        <link rel="shortcut icon" href="images/favicon.ico" />
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
    </head>

    <body>
        <div id="header-container" class="content-width">
            <!-- Logo -->
            <div id="logo-wrapper">
                <div id="logo">
                    <a href="#"><img src="images/logo.png" align="left" alt="E-Club IIT Patna" /></a>
                    <p>&nbsp&nbsp&nbsp&nbsp Entrepreneurship Club IIT Patna</p>
                </div>
            </div>
            <!-- Menu -->
            <div id="menu-wrapper">
                <ul id="root-menu" class="sf-menu">
                    <li>
                        <a href="index.php" class="active">Home</a>
                    </li>
                    <li>
                        <a href="about-us.html">About Us</a>
                        <ul>
                            <li>
                                <a href="about-us.html#mission">Our Mission</a>
                            </li>
                            <li>
                                <a href="about-us.html#logo-rationale">Logo Rationale</a>
                            </li>
                            <li>
                                <a href="team.html">Our Team</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Events</a><!--goto the list page of all events-->
                        <ul>
                            <li>
                                <a href="ead.html">EAD</a>
                            </li>
                            <li>
                                <a href="celesta.html">Celesta</a>
                            </li>
							<li>
								<a href="anwesha.html">Anwesha</a>
							</li>
							<li>
								<a href="others.html">Entrepreneurs Week</a>
							</li>
                        </ul>
                    </li>
					<li>
                        <a href="icenter.html">Innovation Center</a>
                    </li>
                    <li>
                        <a href="#">Gallery</a>
                        <ul>
                            <li>
                                <a href="gallery.html">Events Gallery</a>
                            </li>
                            <li>
                                <a href="media.html">Media Coverage</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://eclubiitp.blogspot.in">Blog</a>
                    </li>
					<li>
                        <a href="#">Portal</a>
                    </li>
                    <li>
                        <a href="contact-us.html">Contact</a>
                    </li>
                </ul>

                <nav id="mobile-menu" class="top-bar">
                    <ul class="title-area">
                        <!-- Do not remove this list item -->
                        <li class="name"></li>

                        <!-- Menu toggle button -->
                        <li class="toggle-topbar menu-icon">
                            <a href="#"><span>Menu</span></a>
                        </li>
                    </ul>

                    <!-- Mobile menu's container -->
                    <section class="top-bar-section"></section>
                </nav>

            </div>


        </div> <!-- End id="header-container" -->

        <div id="floater">
            <ul>
                <li><a href="https://www.facebook.com/iitp.entrepreneurship" target="_blank"><img src="images/social/fb_float.png" alt="Facebook" title="Facebook" /></a></li>
                <li><a href="https://twitter.com/iitp_eclub" target="_blank"><img src="images/social/twitter_float.png" alt="Twitter" title="Twitter" /></a></li>
                <li><a href="https://plus.google.com/u/0/communities/116727158895303706628" target="_blank"><img src="images/social/gplus_float.png" alt="Google+" title="Google+" /></a></li>
                <li><a href="https://www.youtube.com/channel/UCeQ7Tz0Zfn5ziGLQtXEIx4g" target="_blank"><img src="images/social/youtube_float.png" alt="YouTube" title="YouTube" /></a></li>
            </ul>
        </div>

        <!-- Home Slider Container -->
        <div id="home-slider-container">

            <div id="home-slider">
                <div class="home-slider-item">
                    <img src="images/img/img5.jpg" alt="Slide 1" />
                    <div class="slider-caption">
                        <h2>Mr. Ajai Chowdhry</h2>
                        <p>
							"Entrepreneurs are people who convert noise to signal"
                        </p>
                    </div>
                </div>
                <div class="home-slider-item">
                    <img src="images/img/img7.jpg" alt="Slide 2" />
                    <div class="slider-caption">
                        <h2>Dr. Harish Hande</h2>
                        <p>
                            Taking a lecture at IIT Patna
                        </p>
                    </div>
                </div>
                <div class="home-slider-item">
                    <img src="images/img/img6.jpg" alt="Slide 3" />
					<div class="slider-caption">
                        <h2 style="font-size:38px;">Prof. Anjan Raichaudhuri</h2>
                        <p>
                            Studying Entrepreneurs Life Stories
                        </p>
                    </div>
                </div>
            </div>
            <div id="slider-controller" class="content-width">
                <a href="#" id="slider-prev"><i class="icon-angle-left"></i></a>
                <a href="#" id="slider-next"><i class="icon-angle-right"></i></a>
            </div>
            <div id="header-image-shadow" class="content-width"></div>

        </div>
        <!-- Finally Completed this -->

        <div id="content-container" class="content-width">

            <!-- Page Intro -->
            <div id="intro" class="row">
                <div class="large-12 columns">
                    <div style="float:left; width:75%">
                        <p style="width:90%;">
                        We, at the <b>Entrepreneurship Club</b>, shall strive to educate ourselves about the nuances involved in
                        entrepreneurship and business in order to prepare ourselves for undertaking the journey from the genesis of
                        an idea to its successful business implementation. We shall work to create an environment that would allow us
                        to learn from each other and from the experiences of people who have undertaken this journey in the past.
                        </p>
                        <br/>
                        <p id="showEvents" style="background:white; height:171px; float:right; width:100%; padding-left:10px; font-family:Calibri; padding-right:10px; text-align:justify">
                            No Events in this period
                        </p>
                    </div>
                    <div style="float:right; width:25%; background:white">
                        <div id="calendar">
                            <br/>
                            <p style="font-size: 20px; font-weight: bold; font-family: 'Callibri'; text-align:center">Events Calendar</p>
                            <p id="calendar_title" style="font-family: 'Callibri'; font-size: 20px; text-align:center"></p>
                            <table>
                                <tr>
                                    <td style="color:red"><b>Sun</b></td>
                                    <td><b>Mon</b></td>
                                    <td><b>Tue</b></td>
                                    <td><b>Wed</b></td>
                                    <td><b>Thu</b></td>
                                    <td><b>Fri</b></td>
                                    <td><b>Sat</b></td>
                                </tr>
                                <?php
                                    for ($i=0; $i < 6 ; $i++) {
                                        echo '<tr>';
                                        for ($j=0; $j < 7; $j++) {
                                            if($j == 0)
                                                echo '<td style="user-select: none; -moz-user-select:none; -webkit-user-select: none" id="'.$i.'_'.$j.'" width="14.28%"></td>';
                                            else
                                                echo '<td style="user-select:none; -moz-user-select:none; -webkit-user-select: none" id="'.$i.'_'.$j.'" width="14.28%"></td>';
                                        }
                                        echo '</tr>';
                                    }
                                    $date = time();
                                    $month = date('m', $date);
                                    $year = date('Y', $date);
                                    echo "<script type='text/javascript'>generateCalendar('".$month."', '".$year."')</script>";
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial Slider -->
            <div class="row top-margin no-bg">
                <div class="large-12 columns no-padding">

                    <div class="testimonial-wrapper">
                        <div class="testimonial-inner">
                            <div class="testimonial-list">
                                <div>
                                    <blockquote>
                                        <p>
                                            When I dare to be powerful, to use my strength in the service of my vision, then it becomes less and less important whether I am afraid.
                                        </p>
                                        <cite> Audre Lorde </cite>
                                    </blockquote>
                                    <img src="images/img/test1.jpg" alt="" />
                                </div>
                                <div>
                                    <blockquote>
                                        <p>
                                            "Twenty years from now you will be more disappointed by the things that you didn't do than by the ones you did do. So throw off the bowlines. Sail away from the safe harbor. Catch the trade winds in your sails. Explore. Dream. Discover."
                                        </p>
                                        <cite> Mark Twain </cite>
                                    </blockquote>
                                    <img src="images/img/test2.jpg" alt="" />
                                </div>
                                <div>
                                    <blockquote>
                                        <p class="smaller">
                                            "Entrepreneurship is living a few years of your life like most people won't so you can spend the rest of your life like most people cant."
                                        </p>
                                        <cite> Warren G. Tracy's Student </cite>
                                    </blockquote>

                                </div>
                            </div>
                            <div class="testimonial-angle"></div>
                            <div class="testimonial-corner"></div>
                            <div class="testimonial-corner-mirror"></div>
                        </div>
                        <div class="testimonial-bullets"></div>
                    </div>

                </div>
            </div>

            <!-- Blog -->
            <div class="row top-margin">
                <div class="large-12 columns bottom-line">
                    <h3 class="no-margin">News Update.</h3>
                    <!--<a href="blog-list.html" class="bottom-right angle flat button">View all news<span class="angle"><i class="icon-angle-right"></i></span></a>-->
                </div>
            </div>
            <div class="row">
                <div class="blog-item no-border large-12 columns for-nested">
                    <div class="right-border row">
                        <div class="large-12 columns">
                            <div class="blog-meta">
                                <span class="date">Oct 26, 2014</span>
                            </div>
                            <hr />
                            <h4 class="blog-title">Tata First Dot Workshop</h4>
                            <p class="excerpt">
                                "TATA First Dot, Powered by National Entrepreneurship Network", India's first national platform for student start-ups.
                                A unique initiative which promotes, mentors and showcases India’s most dynamic and youngest entrepreneurs.
                                The program is open to students who’ve already started their ventures, and students who have a solid plan, but are yet to start.<br/>
                                Register <a href="http://goo.gl/HUwE8v" target="_blank">here</a>.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-offset-3 large-6 columns height-255">
                            <img src="images/news/nen.jpg" alt="" class="stretch-image" />
                        </div>
                    </div>
                </div>
                <div class="blog-item no-border large-12 columns for-nested">
                    <div class="right-border row">
                        <div class="large-12 columns">
                            <div class="blog-meta">
                                <span class="date">Oct 11, 2014</span>
                            </div>
                            <hr />
                            <!--<h4 class="sub-blog-title">Innovation Center at IIT Patna</h4>-->
							<p class="excerpt">
                                Entrepreneurship Club, IIT Patna and Entrepreneurship Cell, IIT Kharagpur organized the Patna chapter of EAD 2014, at IIT Patna. The coveted event had guest talks by Mr. Rahul Narvekar, CEO and Co-founder, NDTV Ehtnic Retail Pvt. Ltd., Mr. Abhishek Chakraborty, CEO and Founder, Whiz Mantra.
                            </p>
                        </div>
                        <div class="large-offset-3 large-6 columns no-padding height-255">
                            <img src="images/news/ead.jpg" alt="" class="stretch-image" />
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="blog-item no-border large-12 columns for-nested">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="blog-meta">
                                <span class="date">Mar 1, 2014</span>
                            </div>
                            <hr />
                            <!--<h4 class="sub-blog-title"><a href="blog-single.html">Ut enim ad minim veniam consectetur adipisicing elit, sed do eiusmod</a></h4>-->
							<p class="excerpt">
                                Celebrating <b>Entrepreneurs Week</b>. Your chance to interact with eminent Entrepreneurs and get an insight into their journey, and learn some entrepreneurial and business mantras with Mr. Arjun Malhotra, Co-Founder HCL, Ms. Padmaja Ruparel, President Indian Angel Network.
                                <br/><br/>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-offset-3 large-6 columns no-padding height-255">
                            <img src="images/news/seminar.jpg" alt="" class="stretch-image" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End of content-container -->

        <!-- Footer Content -->
        <div id="footer-content-container">
            <div id="footer-content-inner-wrapper" class="content-width">
                <div id="footer-content" class="row top-margin">
                    <div class="large-4 columns less-padding">
                        <img id="footer-logo" src="images/iitplogo.png" width="150" height="150" alt="E-Club IIT Patna" />
                        <p>

                        </p>
                    </div>
                    <div class="large-4 columns less-padding">
                        <h5>Contact Us</h5>
                        <p>
                            Indian Institute of Technology,<br/>
							Patliputra Colony,<br/>
							Patna - 800013<br/>
							Bihar.
                        </p>
                        <ul>
                            <li>
                                Mobile: +91-8603251503
                            </li>
                            <li>
                                Email: <a href="#">entrepreneurship@iitp.ac.in</a>
                            </li>
                        </ul>
                    </div>
                    <div class="large-4 columns less-padding">
                        <h5>Join Us.</h5>
                        <p>
							"The value of an idea lies in the using of it."<br/><br/>
                            If you share the same zeal and are passionate about achieving your vision
							join us in our efforts to help others achieve the same.
                        </p>
                        <a href="https://www.facebook.com/iitp.entrepreneurship" target="_blank" class="flat button">Join our Facebook page</a>
                    </div>
                </div>
            </div>
        </div> <!-- End id="footer-content-container" -->

        <!-- Footer Bar -->
        <div id="footer-bar-container" class="row">
            <div id="footer-bar-inner-wrapper" class="content-width">
                <div class="large-6 columns less-padding">
                    2015 &copy; E-Club IIT Patna
                </div>
                <div class="large-6 columns less-padding">
                    <div id="footer-social">
                        <span>Connect with us:</span>
                        <ul class="bar-social">
                            <li>
                                <a href="https://www.facebook.com/iitp.entrepreneurship" target="_blank"><img src="images/social/facebook-bw.png" alt="" title="" /><img class="hover" src="images/social/facebook.png" alt="Facebook" title="Facebook" /></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/iitp_eclub" target="_blank"><img src="images/social/twitter-bw.png" alt="" title="" /><img class="hover" src="images/social/twitter.png" alt="Twitter" title="Twitter" /></a>
                            </li>
                            <li>
                                <a href="https://plus.google.com/u/0/communities/116727158895303706628" target="_blank"><img src="images/social/googleplus-bw.png" alt="" title="" /><img class="hover" src="images/social/googleplus.png" alt="Google+" title="Google+" /></a>
                            </li>
                            <!--<li>
                                <a href="#" target="_blank"><img src="images/social/linkedin-bw.png" alt="" title="" /><img class="hover" src="images/social/linkedin.png" alt="LinkedIn" title="LinkedIn" /></a>
                            </li>-->
                            <li>
                                <a href="https://www.youtube.com/channel/UCeQ7Tz0Zfn5ziGLQtXEIx4g" target="_blank"><img src="images/social/youtube-bw.png" alt="" title="" /><img class="hover" src="images/social/youtube.png" alt="YouTube" title="YouTube" /></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> <!-- End id="footer-bar-container" -->

        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/jquery-ui-1.10.2.custom.min.js"></script>
        <script src="js/foundation.min.js"></script>
        <script src="js/jquery.backstretch.min.js"></script>
        <script src="js/superfish.js"></script>
        <script src="js/supersubs.js"></script>
        <script src="js/jquery.hoverIntent.minified.js"></script>
        <script src="js/jquery.fancybox-1.3.4.js"></script>
        <script src="js/jquery.transit.min.js"></script>
        <script src="js/jquery.touchSwipe.min.js"></script>
        <script src="js/jquery.carouFredSel-6.1.0-packed.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/jquery.isotope.min.js"></script>
        <script src="js/jquery.hoverdir.js"></script>
        <script src="js/jquery.validationEngine-en.js"></script>
        <script src="js/jquery.validationEngine.js"></script>
        <script src="js/jquery.scrollUp.min.js"></script>
        <script src="js/archtek.js"></script>

    </body>
</html>
