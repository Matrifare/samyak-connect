<?php
if (!empty($_GET['action']) && $_GET['action'] == 'logout') {
    header('Location: https://reviewthis.biz/samyakmatrimony');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keyword"
        content="Buddhist Matrimony, Buddhist Vadhu Var Suchak Mandal, Buddhist Marriage Bureau, Buddhist Wedding Services, Vadhu Var Mandal, Marriage Bureau in Mumbai, Marriage Bureau in Pune, Buddhist Brides, Buddhist Grooms, Buddhist Matchmaking, Buddhist Shaadi, Buddhist Wedding Portal" />
    <meta name="description"
        content="Find your perfect match with our trusted Buddhist Matrimony & Vadhu Var Suchak Mandal. Leading marriage bureau in Mumbai & Pune,">
    <meta name="author" content="Manish Gupta <contact@manishdesigner.com>">
    <title>Buddhist Matrimony|VadhuVar Suchak Mandal|Marriage Bureau </title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="new-design/img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="new-design/img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
        href="new-design/img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
        href="new-design/img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
        href="new-design/img/apple-touch-icon-144x144-precomposed.png">

    <!-- COMMON CSS -->
    <link href="new-design/css/bootstrap-vendors.bundle.css" rel="stylesheet">
    <link href="new-design/css/style.min.css" rel="stylesheet">

</head>

<body>

    <?php
    require_once 'layouts/new-header.php';
    ?>

    <div id="search_container_2">
        <div id="search_2">
            <form action="search_result" method="post">
                <div class="row no-gutters custom-search-input-2">
                    <div class="col-lg-1 col-6 mobile-space">
                        <div class="form-group">
                            <select class="form-control" name="gender" id="gender"
                                data-placeholder="Marital Status">
                                <!--                            <option value="">Looking For</option>-->
                                <option value="Bride">Bride</option>
                                <option value="Groom">Groom</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-3 mobile-space">
                        <div class="form-group">
                            <select class="form-control" name="age_from" id="age_from">
                                <!--                                    <option value="">From Age</option>-->
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24" selected>24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                                <option value="32">32</option>
                                <option value="33">33</option>
                                <option value="34">34</option>
                                <option value="35">35</option>
                                <option value="36">36</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                                <option value="47">47</option>
                                <option value="48">48</option>
                                <option value="49">49</option>
                                <option value="50">50</option>
                                <option value="51">51</option>
                                <option value="52">52</option>
                                <option value="53">53</option>
                                <option value="54">54</option>
                                <option value="55">55</option>
                                <option value="56">56</option>
                                <option value="57">57</option>
                                <option value="58">58</option>
                                <option value="59">59</option>
                                <option value="60">60</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1 col-3 mobile-space">
                        <div class="form-group">
                            <select class="form-control" name="age_to" id="age_to">
                                <!--                                    <option value="">To Age</option>-->
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                                <option value="32">32</option>
                                <option value="33">33</option>
                                <option value="34">34</option>
                                <option value="35">35</option>
                                <option value="36">36</option>
                                <option value="37">37</option>
                                <option value="38" selected>38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                                <option value="42">42</option>
                                <option value="43">43</option>
                                <option value="44">44</option>
                                <option value="45">45</option>
                                <option value="46">46</option>
                                <option value="47">47</option>
                                <option value="48">48</option>
                                <option value="49">49</option>
                                <option value="50">50</option>
                                <option value="51">51</option>
                                <option value="52">52</option>
                                <option value="53">53</option>
                                <option value="54">54</option>
                                <option value="55">55</option>
                                <option value="56">56</option>
                                <option value="57">57</option>
                                <option value="58">58</option>
                                <option value="59">59</option>
                                <option value="60">60</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mobile-space">
                        <div class="form-group">
                            <select name="religion[]" class="form-control">
                                <option value="">Religion</option>
                                <option value="7">Buddhist</option>
                                <option value="3">Christian</option>
                                <option value="1">Hindu</option>
                                <option value="5">Jain</option>
                                <option value="2">Muslim</option>
                                <option value="8">Other</option>
                                <option value="6">Parsi</option>
                                <option value="4">Sikh</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mobile-space">
                        <div class="form-group">
                            <select class="form-control" name="m_status[]" id="m_status"
                                data-placeholder="Marital Status">
                                <option value="">Marital Status</option>
                                <option value="Unmarried">Unmarried
                                </option>
                                <option value="Widow/Widower">Widow/Widower
                                </option>
                                <option value="Divorcee">Divorcee
                                </option>
                                <option value="Separated">Separated
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mobile-space">
                        <div class="form-group">
                            <select class="form-control" name="education_field[]" id="education_field"
                                data-placeholder="Select Your Education">
                                <option value="">Education</option>
                                <option value="2">
                                    Administrative services
                                </option>
                                <option value="1">
                                    Advertising/ Marketing
                                </option>
                                <option value="3">
                                    Architecture
                                </option>
                                <option value="4">
                                    Armed Forces
                                </option>
                                <option value="5">
                                    Arts
                                </option>
                                <option value="6">
                                    Commerce
                                </option>
                                <option value="7">
                                    Computers/ IT
                                </option>
                                <option value="8">
                                    Education
                                </option>
                                <option value="9">
                                    Engineering
                                </option>
                                <option value="10">
                                    Fashion
                                </option>
                                <option value="11">
                                    Finance
                                </option>
                                <option value="12">
                                    Fine Arts
                                </option>
                                <option value="18">
                                    Health Care
                                </option>
                                <option value="13">
                                    Home Science
                                </option>
                                <option value="14">
                                    Journalism/Media
                                </option>
                                <option value="15">
                                    Law
                                </option>
                                <option value="24">
                                    Less Than High School
                                </option>
                                <option value="16">
                                    Management
                                </option>
                                <option value="17">
                                    Medicine
                                </option>
                                <option value="20">
                                    Office administration
                                </option>
                                <option value="19">
                                    Pharmacy
                                </option>
                                <option value="21">
                                    Science
                                </option>
                                <option value="22">
                                    Shipping
                                </option>
                                <option value="23">
                                    Travel &amp; Tourism
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-6 mobile-space">
                        <div class="form-group">
                            <select name="city" class="form-control">
                                <option value="">City</option>
                                <option value="2">Ahmednagar</option>
                                <option value="3">Akola</option>
                                <option value="589">Alibag</option>
                                <option value="672">Ambernath</option>
                                <option value="4">Amravati</option>
                                <option value="598">Andhra Pradesh</option>
                                <option value="599">Assam</option>
                                <option value="5">Aurangabad</option>
                                <option value="650">Badlapur</option>
                                <option value="245">Bangalore</option>
                                <option value="7">Beed</option>
                                <option value="645">Belgaum</option>
                                <option value="593">Belgium</option>
                                <option value="8">Bhandara</option>
                                <option value="651">Bhiwandi</option>
                                <option value="643">Bhusawal</option>
                                <option value="600">Bihar</option>
                                <option value="9">Buldhana</option>
                                <option value="590">Canada</option>
                                <option value="646">Chalishgaon</option>
                                <option value="399">Chandigarh</option>
                                <option value="10">Chandrapur</option>
                                <option value="453">Chennai</option>
                                <option value="602">Chhattisgarh</option>
                                <option value="668">Chikhli</option>
                                <option value="644">Chiplun</option>
                                <option value="150">Delhi</option>
                                <option value="11">Dhule</option>
                                <option value="653">Dombiwali</option>
                                <option value="592">Dubai</option>
                                <option value="12">Gadchiroli</option>
                                <option value="152">Goa</option>
                                <option value="666">Godiya</option>
                                <option value="13">Gondiya</option>
                                <option value="665">Gujarat</option>
                                <option value="611">Haryana</option>
                                <option value="664">Hinganghat</option>
                                <option value="14">Hingoli</option>
                                <option value="649">Igatpuri</option>
                                <option value="418">Jaipur</option>
                                <option value="15">Jalgaon</option>
                                <option value="16">Jalna</option>
                                <option value="652">Jammu &amp; Kashmir</option>
                                <option value="594">Japan</option>
                                <option value="613">Jharkand</option>
                                <option value="585">Kalyan</option>
                                <option value="648">Kankavli</option>
                                <option value="617">karad</option>
                                <option value="663">Karji</option>
                                <option value="603">Karnataka</option>
                                <option value="604">Kerala</option>
                                <option value="641">Khamgaon</option>
                                <option value="661">khandesh</option>
                                <option value="642">Khed</option>
                                <option value="640">Khopoli</option>
                                <option value="639">Kokan</option>
                                <option value="17">Kolhapur</option>
                                <option value="18">Latur</option>
                                <option value="601">Madhya Pradesh</option>
                                <option value="634">mahad</option>
                                <option value="633">malkapur</option>
                                <option value="631">Malvan</option>
                                <option value="638">Mangaon</option>
                                <option value="632">Manmad</option>
                                <option value="630">Miraj</option>
                                <option value="1">Mumbai</option>
                                <option value="19">Nagpur</option>
                                <option value="20">Nanded</option>
                                <option value="21">Nandurbar</option>
                                <option value="22">Nashik</option>
                                <option value="627">Navi-Mumbai</option>
                                <option value="591">New Zealand</option>
                                <option value="626">Nifad</option>
                                <option value="595">Oman</option>
                                <option value="605">Orissa</option>
                                <option value="23">Osmanabad</option>
                                <option value="619">Other City</option>
                                <option value="675">Outside india</option>
                                <option value="670">Palghar</option>
                                <option value="623">panchgani</option>
                                <option value="621">Panvel</option>
                                <option value="24">Parbhani</option>
                                <option value="635">patan</option>
                                <option value="25">Pune</option>
                                <option value="658">Punjab</option>
                                <option value="586">Qatar</option>
                                <option value="618">Raigad</option>
                                <option value="26">Raigarh</option>
                                <option value="132">Raipur</option>
                                <option value="597">Rajasthan</option>
                                <option value="27">Ratnagiri</option>
                                <option value="622">sangamner</option>
                                <option value="28">Sangli</option>
                                <option value="29">Satara</option>
                                <option value="625">Shahapur</option>
                                <option value="629">Shirdi</option>
                                <option value="30">Sindhudurg</option>
                                <option value="616">Singapore</option>
                                <option value="31">Solapur</option>
                                <option value="606">Tamil Nadu</option>
                                <option value="32">Thane</option>
                                <option value="637">Titwala</option>
                                <option value="596">UAE</option>
                                <option value="584">UK</option>
                                <option value="636">Ulhasnagar</option>
                                <option value="588">USA</option>
                                <option value="607">Uttar Pradesh</option>
                                <option value="609">Uttaranchal</option>
                                <option value="654">Vapi</option>
                                <option value="628">Vasai</option>
                                <option value="620">Vidarbha</option>
                                <option value="33">Wardha</option>
                                <option value="34">Washim</option>
                                <option value="608">West Bengal</option>
                                <option value="35">Yavatmal</option>
                                <option value="624">Yeola</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <button type="submit" class="btn_search">
                            <i class="icon icon-search"></i>
                            Search
                        </button>
                        <!--<input type="submit" class="btn_search" value="Search">-->
                    </div>
                </div>
                <!-- /row -->
            </form>
        </div>
        <!-- End search_container_2 -->
    </div>
    <!-- End search_container -->

    <main>
        <div class="container margin_60">

            <div class="row d-lg-none d-md-none d-sm-none">
                <div class="col-6 text-center">
                    <a href="register" class="btn_1 btn_map">Register Free!</a>
                </div>
                <div class="col-6 text-center">
                    <a href="login" class="btn_1 btn_map btn_gray">Login Now</a>
                </div>
            </div>

            <hr class="row d-lg-none d-md-none d-sm-none" />

            <div class="main_title">
                <h2>Samyakmatrimony <span>Success</span> Stories</h2>
                <p>Find inspiration for your Special Day. Yours could be the next Success Story.</p>
            </div>

            <div class="owl-carousel owl-theme list_carousel add_bottom_30">
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/34.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/33.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/35.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/36.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/37.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/38.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/39.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/40.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/32.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="tour_container">
                        <div class="img_container">
                            <a href="success_story">
                                <img src="//www.samyakmatrimony.com/SuccessStory/31.jpg" width="800" height="533"
                                    class="img-fluid" alt="image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /carousel -->

            <p class="text-center add_bottom_30">
                <a href="success_story" class="btn_1">View all Success Stories</a>
            </p>

        </div>
        <!-- End container -->

        <div class="white_bg">
            <div class="container margin_60">
                <div class="main_title">
                    <h2>What <span>We</span> Offer</h2>
                    <p>
                        Search Buddhist Bride & Groom authentic profiles.
                    </p>
                </div>
                <div class="row feature_home_2">
                    <div class="col-md-4 text-center">
                        <div class="icon-sm contact-icon-sm"></div>
                        <h3>View Contacts</h3>
                        <p>View contact number to connect or WhatsApp. Visit office to view Profile</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon-sm message-icon-sm"></div>
                        <h3>Send Personal Message</h3>
                        <p> Send message/sms to interested profile.Connnect via WhatsApp</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="icon-sm chat-icon-sm"></div>
                        <h3>Chat</h3>
                        <p>Chat instantly with online Members
                            Send message to discuss more</p>
                    </div>
                    <div class="col-sm-12">
                        <p class="text-center add_bottom_30">
                            <a href="tel:+91-79779-93616" class="btn_1"> To know more, call us @ +91-79779-93616</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="container">
                <h1>Welcome to Samyak Buddhist Matrimony</h1>
                <p>The leading Samyak Buddhist Matrimony platform serves the Buddhist community by guiding individuals toward finding meaningful life partners. Our Buddhist matrimony platform enables safe connections between verified profiles through advanced search functions to help you find single individuals who share your Buddhist values and traditions.</p>

                <p>Samyak Buddhist Matrimony serves as your perfect platform for secure and genuine matchmaking as you search for either a lifelong partner or a meaningful connection. Become part of our community immediately to discover our dependable and honorable Buddhist marriage service.</p>
                </p>
            </div>
            <!-- End container -->
        </div>
        <!-- End white_bg -->

        <div class="container margin_60">
            <div class="main_title">
                <h2>Quick <span>Links</span></h2>
                <p>Explore profiles that matches your search criteria</p>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <b>Quick Links - </b>
                    <a title="Divorcee Matrimony" href="divorcee-matrimonials" class="tag-item">Divorcee </a> |
                    <a title="Separated Matrimony " href="separated-matrimonials" class="tag-item">Separated </a> |
                    <a title="Widow/Widower Matrimony" href="widow-widower-matrimonials" class="tag-item">Widow/Widower </a>
                    |
                    <a title="Caste No Bar" href="no-caste-bar-matrimonials" class="tag-item">No Caste Bar
                    </a> |
                    <a title="Physically Challenged Profiles" href="physically-challenged-matrimonials" class="tag-item">Physically
                        Challenged
                    </a> |
                </div>
                <div class="col-12 mt-10 text-center font-11">
                    <b>Education - </b>
                    <a title="Buddhist Bride & Groom Enginner Profile" href="engineer-matrimonials" class="tag-item">Engineering</a>
                    |
                    <a title="Buddhist Bride & Groom Doctor Matrimonials profile" href="doctor-matrimonials"
                        class="tag-item">Doctor </a>|
                    <a title="Buddhist Bride & Groom MBA Matrimonials profile" href="management-matrimonials"
                        class="tag-item">Management</a> |
                    <a title="Buddhist Bride & Groom Architect Matrimonials profile" href="architect-matrimonials"
                        class="tag-item">Architect </a> |
                    <a title="Buddhist Bride & Groom Finance Matrimonials" href="finance-matrimonials" class="tag-item">
                        Finance </a> |
                    <a title="Buddhist Bride & Groom Lawyers Profile" href="lawyers-matrimonials"
                        class="tag-item">Lawyers </a> |
                    <a title="Buddhist Bride & Groom IT Software " href="it-software-matrimonials" class="tag-item">IT
                        Software </a> |
                    <a title="Buddhist Bride & Groom Pharmacy Profile" href="pharmacy-matrimonials" class="tag-item">Pharmacy </a>
                    |
                    <a title="Buddhist Bride & Groom Administrative Profile" href="administrative-matrimonials"
                        class="tag-item"> Administrative</a> |
                    <a title="Buddhist Bride & Groom Marketing Profile" href="marketing-matrimonials" class="tag-item">
                        Marketing</a> |
                    <a title="Buddhist Bride & Groom BA/MA Profile" href="art-matrimonials" class="tag-item">
                        BA/MA </a> |
                    <a title="Buddhist Bride & Groom BCom/MCom profile" href="commerce-matrimonials" class="tag-item">
                        BCom/MCom</a> |
                    <a title="Buddhist Bride & Groom BSc/MSc profile " href="science-matrimonials" class="tag-item">
                        BSc/MSc </a> |
                    <a title="Buddhist Bride & Groom Healthcare profile" href="healthcare-media-matrimonials"
                        class="tag-item"> Healthcare</a> |
                    <a title="Buddhist Bride & Groom Less than High School profile"
                        href="less-than-high-school-matrimonials" class="tag-item"> High School</a>
                </div>
                <div class="col-12 mt-10 font-12 text-center">
                    <b>Residence District - </b>
                    <a title="India Buddhist Matrimony " href="vidarbha-city-matrimonials" class="tag-item">Vidarbha</a> |
                    <a title="India Buddhist Matrimony " href="Kokan-city-matrimonials" class="tag-item">Kokan</a> |
                    <a title="India Buddhist Matrimony " href="marathwada-city-matrimonials" class="tag-item">Marathwada</a>
                    |
                    <a title="India Buddhist Matrimony " href="mumbai-city-matrimonials" class="tag-item">Mumbai</a> |
                    <a title="India Buddhist Matrimony " href="khandesh-city-matrimonials" class="tag-item">Khandesh</a> |
                    <a title="India Buddhist Matrimony " href="paschim_maharashtra-city-matrimonials.php" class="tag-item">Paschim
                        Maharashtra</a> |
                    </a>
                    <b>Country - </b>
                    <a title="India Buddhist Matrimony " href="india-matrimonials" class="tag-item">India</a> |
                    <a title="Outside India Buddhist Matrimony" href="nri-matrimonials" class="tag-item">Outside India
                        Profiles
                    </a>
                </div>
                <div class="col-12 mt-10 font-12 text-center">
                    <b>Native District - </b>
                    <a title="India Buddhist Matrimony " href="vidarbha-native-city-matrimonials"
                        class="tag-item">Vidarbha</a> |
                    <a title="India Buddhist Matrimony " href="kokan-native-city-profile" class="tag-item">Kokan</a> |
                    <a title="India Buddhist Matrimony " href="marathwada-native-city-matrimonials" class="tag-item">Marathwada</a>
                    |
                    <a title="India Buddhist Matrimony " href="mumbai-native-city-matrimonials" class="tag-item">Mumbai</a>
                    |
                    <a title="India Buddhist Matrimony " href="khandesh-native-city-profile" class="tag-item">Khandesh</a> |
                    <a title="India Buddhist Matrimony " href="paschim_maharashtra-native-city-matrimonials"
                        class="tag-item">Paschim Maharashtra</a> |
                </div>
            </div>
        </div>
        <!-- /box_news -->
        </div>
        <!-- /row -->
        </div>
        <!-- End container -->
    </main>
    <!-- End main -->
    <?php
    require_once 'layouts/new-footer.php';
    ?>
    <!-- Common scripts -->
    <script src="new-design/js/jquery-3.6.0.min.js"></script>
    <script src="new-design/js/common_scripts_min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script src="new-design/js/functions.js"></script>

</body>

</html>