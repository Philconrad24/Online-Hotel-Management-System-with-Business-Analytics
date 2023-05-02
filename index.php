<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $adults = (int)$_POST["adults"];
  $children = (int)$_POST["children"];
  $cp = $adults + $children;

  header("Location: ./reservation/?cp=" . $cp);
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <title>Mirth Hotels and Resorts | Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <link rel="shortcut icon" href="image/sleep-icon.svg">

</head>

<body>

  <!-- <div id="preloader">
    <img src="image/loader.gif" alt="">
  </div>  -->
  <header class="header" id="navigation-menu">
    <div class="container">
      <nav>
        <a href="#" class="logo"> <img src="image/logo.png" alt=""> </a>

        <div>
          <ul class="nav-menu">
            <li> <a href="#home" class="nav-link" data-aos="fade-down" data-aos-delay="100">Home</a> </li>
            <li> <a href="#about" class="nav-link" data-aos="fade-down" data-aos-delay="150">About</a> </li>
            <li> <a href="#rooms" class="nav-link" data-aos="fade-down" data-aos-delay="200">Rooms</a> </li>
            <li> <a href="#restaurant" class="nav-link" data-aos="fade-left" data-aos-delay="250">Restaurant</a> </li>
            <li> <a href="#gallery" class="nav-link" data-aos="fade-left" data-aos-delay="300">Gallery</a> </li>
            <li> <a href="#footer" class="nav-link" data-aos="fade-left" data-aos-delay="350">Contact</a> </li>
            <li> <a href="./reservation/login.php" class="nav-link" data-aos="fade-left" data-aos-delay="350">Login</a> </li>
            <a href="./reservation"> <button class="btn2">Book room</button></a>
          </ul>

        </div>

        <div class="hambuger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </div>
  </header>
  <script>
    const hambuger = document.querySelector('.hambuger');
    const navMenu = document.querySelector('.nav-menu');

    hambuger.addEventListener("click", mobileMenu);

    function mobileMenu() {
      hambuger.classList.toggle("active");
      navMenu.classList.toggle("active");
    }

    const navLink = document.querySelectorAll('.nav-link');
    navLink.forEach((n) => n.addEventListener("click", closeMenu));

    function closeMenu() {
      hambuger.classList.remove("active");
      navMenu.classList.remove("active");
    }
  </script>

  <section class="home" id="home">
    <div class="head_container">
      <div class="box">
        <div class="text">
          <h1 data-aos="fade-down">Hello.Habari</h1>
          <p data-aos="fade-up">Introducing to you a 4-star hotel, established in the year 2010, that has truly served as not only as hotel, but also as a proper hospitality institution. This is The Mirth Resort and Spa.</p>

        </div>
      </div>
      <div class="image">
        <img src="image/home1.jpg" class="slide">
      </div>
      <div class="image_item">
        <img src="image/home1.jpg" alt="" class="slide active" onclick="img('image/home1.jpg')">
        <img src="image/home2.jpg" alt="" class="slide" onclick="img('image/home2.jpg')">
        <img src="image/home3.jpg" alt="" class="slide" onclick="img('image/home3.jpg')">
        <img src="image/home4.jpg" alt="" class="slide" onclick="img('image/home4.jpg')">
      </div>
    </div>
  </section>
  <script>
    function img(anything) {
      document.querySelector('.slide').src = anything;
    }

    function change(change) {
      const line = document.querySelector('.image');
      line.style.background = change;
    }
  </script>
  <section class="book">
    <div class="container">
      <form method="post" class="flex">
        <div class="input grid">
          <div class="box">
            <label>Check-in:</label>
            <input type="date" placeholder="Check-in-Date">
          </div>
          <div class="box">
            <label>Check-out:</label>
            <input type="date" placeholder="Check-out-Date">
          </div>
          <div class="box">
            <label>Adults:</label> <br>
            <input type="number" placeholder="0" name="adults">
          </div>
          <div class="box">
            <label>Children:</label> <br>
            <input type="number" placeholder="0" name="children">
          </div>
        </div>
        <a class="search" style="text-decoration: none;">
          <input type="submit" value="SEARCH">
        </a>
      </form>
    </div>
  </section>
  <section class="about top" id="about">
    <div class="container flex">
      <div class="left">
        <div class="img">
          <img src="image/a1.jpg" alt="" class="image1">
          <img src="image/a2.jpg" alt="" class="image2">
        </div>
      </div>
      <div class="right">
        <div class="heading" data-aos="fade-down" data-aos-delay="200">
          <h5>RAISING COMFORT TO THE HIGHEST LEVEL</h5>
          <h2>Welcome to The Mirth Resort and Spa.</h2>
          <p>The Mirth Resort and Spa is an establishment located in Malindi. It was established in the year 2010 as an outside catering hotel service provider. It has grown in capacity through the years to been among the most sort after hotels in the region and it is now a fully serviced hotel and restaurant with accommodation services and other state of the art facilities </p>
          <p>Today, it has grown to be among the high ranked and biggest hotels in the country. ‘The Mirth Resort and Spa, the Home of African Prestige and Wonderland.’</p>

        </div>
      </div>
    </div>
  </section>
  <section class="wrapper top">
    <div class="container">
      <div class="text" data-aos="fade-left" data-aos-delay="250">
        <h2>Our Amenities</h2>
        <p>Rooms | Dining | Meeting & Events | Leisure</p>

        <hr>
        <br>
        <br>

        <div class="content">
          <div class="box flex">
            <i class="fas fa-swimming-pool"></i>
            <span>Swimming pool</span>
          </div>
          <div class="box flex">
            <i class="fas fa-dumbbell"></i>
            <span>Gym & Yoga</span>
          </div>
          <div class="box flex">
            <i class="fas fa-spa"></i>
            <span>Spa & Massage</span>
          </div>

          <div class="box flex">
            <i class="fas fa-swimmer"></i>
            <span>Surfing Lessons</span>
          </div>
          <div class="box flex">
            <i class="fas fa-microphone"></i>
            <span>Conference Room</span>
          </div>
          <div class="box flex">
            <i class="fas fa-water"></i>
            <span>Diving & Snorkeling</span>
          </div>

        </div>
      </div>
    </div>
  </section>
  <section class="room top" id="rooms">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading" data-aos="fade-right" data-aos-delay="100">
          <h5>RAISING COMFORT TO THE HIGHEST LEVEL</h5>
          <h2>Rooms $ Suites</h2>
        </div>
        <!--  <div class="button">
          <button class="btn1">VIEW ALL</button>
        </div> -->
      </div>

      <div class="content grid">
        <div class="box" data-aos="fade-left" data-aos-delay="150">
          <div class="img">
            <img src="image/r1.jpg" alt="">
          </div>
          <div class="text">
            <h3>Luxury Suite</h3>
            <p> <span>Ksh</span>25,000 <span>/per night</span> </p>
          </div>
        </div>
        <div class="box" data-aos="fade-left" data-aos-delay="200">
          <div class="img">
            <img src="image/r2.jpg" alt="">
          </div>
          <div class="text">
            <h3>Family Suite</h3>
            <p> <span>Ksh</span>20,000 <span>/per night</span> </p>
          </div>
        </div>
        <div class="box" data-aos="fade-left" data-aos-delay="250">
          <div class="img">
            <img src="image/r3.jpg" alt="">
          </div>
          <div class="text">
            <h3>Premium Suite</h3>
            <p> <span>Ksh</span>29,000 <span>/per night</span> </p>
          </div>
        </div>
      </div>
      <div class="button" id="ct-buton">
        <a href="./reservation/">
          <button class="btn1" id="r-btn">BOOK ROOM</button>
        </a>
      </div>
    </div>
  </section>
  <section class="wrapper wrapper2 top">
    <div class="container">
      <div class="text" data-aos="fade-right" data-aos-delay="200">
        <div class="heading">
          <h5>AT THE HEART OF COMMUNICATION</h5>
          <h2>People Say</h2>
        </div>

        <div class="para">
          <p>What an experience I had. Great customer service. The food is mouth-watering. Impeccable. I would recommend this place. 10/10! </p>

          <div class="box flex">
            <div class="img">
              <img src="image/c.jpg" alt="">
            </div>
            <div class="name">
              <h5>KATE PALMER</h5>
              <h5>IDAHO</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="restaurant top" id="restaurant">
    <div class="container flex">
      <div class="left">
        <img src="image/re.jpg" alt="">
      </div>
      <div class="right">
        <div class="text" data-aos="fade-left" data-aos-delay="250">
          <h2>Our Restaurant</h2>
          <p> It's unique food and beverage experience takes on an iconic status of its own. Open to hotel guests and visitors alike, the restaurant offers far more than a stunning setting.</p>
        </div>
        <div class="accordionWrapper" data-aos="fade-left" data-aos-delay="300">
          <div class="accordionItem open">
            <h2 class="accordionIHeading">Local Kitchen</h2>
            <div class="accordionItemContent">
              <p>Contains all types of local dishes. This includes githeri, <i>mukimu</i>, rice and beef stew, ugali with chicken/fish and many more.
              </p>
            </div>
          </div>
          <div class="accordionItem close">
            <h2 class="accordionIHeading">Italian Kitchen</h2>
            <div class="accordionItemContent">
              <p>This comprises of italian dishes such as lasagne, pasta, ravioli etc.
              </p>
            </div>
          </div>
          <div class="accordionItem close">
            <h2 class="accordionIHeading">Swahili Kitchen</h2>
            <div class="accordionItemContent">
              <p>Swahili cuisines at its finest. This includes pilau, beef/goat biryani, mishkaki, Mbaazi za Nazi and many more.
              </p>
            </div>
          </div>
          <div class="accordionItem close">
            <h2 class="accordionIHeading">International Kitchen</h2>
            <div class="accordionItemContent">
              <p>This comprises of cuisines from many parts of the world including Asian, Southern and West Africa.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    var accItem = document.getElementsByClassName('accordionItem');
    var accHD = document.getElementsByClassName('accordionIHeading');

    for (i = 0; i < accHD.length; i++) {
      accHD[i].addEventListener('click', toggleItem, false);
    }

    function toggleItem() {
      var itemClass = this.parentNode.className;
      for (var i = 0; i < accItem.length; i++) {
        accItem[i].className = 'accordionItem close';
      }
      if (itemClass == 'accordionItem close') {
        this.parentNode.className = 'accordionItem open';
      }
    }
  </script>



  <section class="gallery mtop " id="gallery">
    <div class="container">
      <div class="heading_top flex1">
        <div class="heading" data-aos="fade-right" data-aos-delay="200">
          <h5>WELCOME TO OUR PHOTO GALLERY</h5>
          <h2>Photo Gallery of Our Hotel</h2>
        </div>
        <!-- <div class="button">
          <button class="btn1">VIEW GALLERY</button>
        </div> -->
      </div>

      <div class="owl-carousel owl-theme" data-aos="fade-in" data-aos-delay="200">
        <div class="item">
          <img src="image/g1.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g2.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g3.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g4.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g5.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g6.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g7.jpg" alt="">
        </div>
        <div class="item">
          <img src="image/g8.jpg" alt="">
        </div>
      </div>

    </div>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      nav: true,
      dots: false,
      navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1000: {
          items: 4
        }
      }
    })
  </script>




  <div id="footer">
    <div class="container grid top">
      <div class="box">
        <img src="https://img.icons8.com/external-flatart-icons-flat-flatarticons/48/000000/external-hotel-hotel-services-and-city-elements-flatart-icons-flat-flatarticons-1.png" />
        <p> It is our pleasure serving you and providing you the best form of accommodation and luxury</p>
        <br>

        <p><em>Accepted payment methods</em></p>
        <div class="payment grid">
          <img src="https://img.icons8.com/color/48/000000/visa.png" />
          <img src="https://img.icons8.com/color/48/000000/mastercard.png" />
          <img src="https://img.icons8.com/color-glass/48/000000/paypal.png" />
          <img src="image/mpesa-seeklogo.com.svg" width="70" height="50" />
        </div>
      </div>



      <div class="box">
        <h3>Recent News</h3>

        <ul>
          <li>Rhumba Nights every first Saturday of the month</li>
          <li>Family Activities every Sunday</li>
          <li>December in Cascade Hotel</li>
          <li>Live Music Concerts at Cascade</li>
        </ul>
      </div>

      <div class="box">
        <h3>For Customers</h3>
        <ul>
          <li>About Cascade</li>
          <li>Customer Care/Help</li>
          <li>Corporate Accounts</li>
          <li>Financial Information</li>
          <li>Terms & Conditions</li>
        </ul>
      </div>

      <div class="box">
        <h3>Contact Us</h3>

        <ul>
          <li>P.O BOX 8065-00100 THIKA</li>
          <li><i class="far fa-envelope"></i>cascadehotel@agency.co.ke </li>
          <li><i class="far fa-phone-alt"></i>+254 725 118 000 </li>
          <li><i class="far fa-phone-alt"></i>+254 758 856 963 </li>
          <li><i class="far fa-comments"></i>24/7 Customer Services </li>
        </ul>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- <script>

    var loader = document.getElementById("preloader");

    window.addEventListener("load", function(){
      loader.style.display = "none";
    })

  </script> -->
</body>

</html>