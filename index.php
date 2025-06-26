<!-- done -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bijoy-24 Hall</title>

          <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    

    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="index1_welcome.css">

    <link rel="stylesheet" href="index2_why.css">

    <link rel="stylesheet" href="index3_facility.css">


    <!-- Navbar styles -->
    <link rel="stylesheet" href="z_nav.css">

     <!-- footer styles -->
    <link rel="stylesheet" href="z_foot.css">

</head>
<body>
    
    <!-- navber -->
    <?php include 'z_nav.php'; ?>

    <!-- index1_welcome.css -->
    <section class="i1-hero-section">
        <div class="i1-hero-content">
            <h1>Welcome to Bijoy 24 Hall</h1>
            <p>Patuakhali Science and Technology University</p>
        </div>
    </section>

    <!-- index2_why.css -->
<section class="i2-choose-section">

<div class="i2-text-content">
  <h2>WHY CHOOSE <br>BIJOY 24 HALL?</h2>
  <p>
    Choosing Bijoy 24 Hall means choosing a comfortable and supportive residential environment 
    at PSTU. The hall ensures safety, cleanliness, and a peaceful atmosphere conducive to both 
    academic and personal growth.
  </p>
  <p>
    With well-maintained facilities, dedicated hall administration, and a strong sense of community, 
    Bijoy 24 Hall provides an ideal place for students to live, learn, and thrive during their university life.
  </p>
  <a href="#" class="i2-read-more">READ MORE</a>
</div>


  <div class="i2-image-content">
    <div class="i2-carousel">
      <img src="pic/gate_dron.jpg" alt="Hall 1" class="i2-carousel-image active">
      <img src="pic/fest5.jpg" alt="Hall 2" class="i2-carousel-image">
      <img src="pic/ifter4.jpg" alt="Hall 3" class="i2-carousel-image">
      <button class="i2-prev" onclick="prevSlide()">❮</button>
      <button class="i2-next" onclick="nextSlide()">❯</button>
      <div class="i2-caption">BIJOY-24 HALL</div>
    </div>
  </div>
</section>

<!-- index3_facility.css -->
  <div class="i3-container">
    <h1>Our Facilities</h1>
    <p class="subtitle">Our top-notch facilities ensure a conducive environment for student success.</p>
    <div class="grid">
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/classroom.png" alt="Multimedia Classroom">
        <div>
          <div class="facility-title">Comfortable Readingroom</div>
          <div>Classrooms with advanced audio-visual tools and devices and other digital teaching aids</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/home.png" alt="Residential Hall">
        <div>
          <div class="facility-title">Residential Hall</div>
          <div>Comfortable and supportive living environment</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/apple.png" alt="Central Dining">
        <div>
          <div class="facility-title">Central Dining</div>
          <div>Providing well-balanced meals</div>
        
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/test-tube.png" alt="Laboratory">
        <div>
          <div class="facility-title">Security</div>
          <div>CCTV Cameras , Security Guard ,24 Hour Security (incl CCTV)</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/bus.png" alt="Transport">
        <div>
          <div class="facility-title">Hall Transport</div>
          <div>Convenient commuting for non-resident students</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/baby.png" alt="Day Care Center">
        <div>
          <div class="facility-title">Day Care Center</div>
          <div>Childcare services for the convenience of student parents and faculty members</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/books.png" alt="Library">
        <div>
          <div class="facility-title">Hall Library</div>
          <div>Diverse collection of books, journals, and digital materials</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/pill.png" alt="Health Care Center">
        <div>
          <div class="facility-title">Health and Hygiene</div>
          <div>Comprehensive healthcare services</div>
        </div>
      </div>
      <div class="facility">
        <img src="https://img.icons8.com/ios/50/internet.png" alt="Wifi & Tech">
        <div>
          <div class="facility-title">Wifi & Tech</div>
          <div>Robust Wi-Fi and comprehensive technological support</div>
        </div>
      </div>
    </div>
  </div>

    <!-- footer -->
    <?php include 'z_foot.php'; ?>

    <!-- Link to external JavaScript -->
    <script src="index2_why.js"></script>
    <script src="z_nav.js"></script>

</body>
</html>
