  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Home User</title>

  <link rel="stylesheet" href="/courtyard/Home.css" />
    <link rel="stylesheet" href="/courtyard/navbar.css" />
    <style>
      body {
  margin: 0;
  padding: 0;
  background-image: url(' Home_bg.jpg'); 
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  background-attachment: fixed; 
  font-family: Arial, sans-serif;
  overflow-x: hidden;
}
    </style>
  
  </head>

  <body>  
  <nav class="navbar">
    <div class="navbar-left">The Courtyard of Maia Alta</div>
    <ul class="navbar-right">
    <li><a href="HomeUser.php">Home</a></li>
      <li><a href="Gallery.php">Gallery </a></li>
      <li><a href="News.php">News</a></li>
            <li><a href="UserDash.php">History</a></li>
    <li><a href="Login.php" class="logout-btn">Logout</a></li>
    </ul>
  </nav>

  <div class="text-title-con">
    <p>A PLACE <br />YOU CAN CALL</p>
    <div class="text-title-con-big">
      <h1>HOME.</h1>
    </div>
  </div>

  <div class="officers-intro">
    <h2 class="officers-title">Meet the Officers</h2>
    <p class="officers-description">
      Behind every thriving community is a team of passionate individuals dedicated to its growth.
      Get to know the officers who have helped shape The Courtyard of Maia Alta through the years.
    </p>
  </div>

  <!-- Modals -->
  <div class="modal-container">
    <section class="modal-section">
      <div class="modal-box" onclick="showPopup(1)">2008 - 2010</div>
      <div class="modal-box" onclick="showPopup(2)">2010 - 2012</div>
      <div class="modal-box" onclick="showPopup(3)">2012 - 2014</div>
      <div class="modal-box" onclick="showPopup(4)">2014 - 2019</div>
      <div class="modal-box" onclick="showPopup(5)">2019 - 2021</div>
      <div class="modal-box" onclick="showPopup(6)">2021 - 2023</div>
      <div class="modal-box" onclick="showPopup(7)">2024 - Present</div>
    </section>
  </div>

  <!-- Popup -->
  <div class="overlay" id="overlay" onclick="closePopup(event)">
    <div class="popup" id="popup" onclick="event.stopPropagation()">
      <button class="close-btn" onclick="closePopup()">&times;</button>
      <h3>Officers</h3>
      <ul id="officerList"></ul>
    </div>
  </div>



<!-- Event Section (User View) --> 
<div class="event-section-wrapper">
  <div class="event-section-header">
    <h2>Upcoming Events!! See you there!</h2>
  </div>

  <div class="event-section user-view">
    <div class="event-image">
      <img src="event.jpg" alt="Event Photo" />
    </div>

    <div class="event-description">
      <p>This is the current description.</p>
    </div>
  </div>
</div>



    <div class="about-container" id="about-container">
    <div class="column-container">
      <div class="column">
        <h2>About Us</h2>
        <p>A community organization committed to enhancing the quality of life for residents of Maia Alta subdivision. We strive to maintain a harmonious living environment by upholding rules, promoting social interaction, and ensuring transparency and fairness in all community affairs. Our mission is to support the community in fostering unity, health, and well-being while safeguarding the community’s aesthetic and functional integrity.</p>
      </div>
      <div class="column">
        <h2>Mission</h2>
        <p>Effectively direct and administer the affairs of the Association in accordance with its overall charter. To provide information regarding laws, rules and regulations which govern the community and its members to ensure consistency.</p>
      </div>
      <div class="column">
        <h2>Vision</h2>
        <p>To create a vibrant and harmonious community where every resident enjoys a comfortable, safe, and beautiful environment. HACMAI envisions a well-organized neighborhood that encourages active participation, mutual respect, and sustained growth, ultimately making Maia Alta a model community of excellence and unity.</p>
      </div>
    </div>
  </div>
 <img src="chat.png" alt="Your Logo" class="logo">

  <script>
    // Updated data structure: array of objects with name and title
    const officersData = {
      1: [
        { name: 'Cesar O. Villoria', title: 'President' },
        { name: 'Ronnie Hernandez', title: 'Vice-President' },
        { name: 'Marceliana Bermudez', title: 'Secretary' },
        { name: 'Marilou Cajayon', title: 'Treasurer' },
        { name: 'Mary Ann Neiva', title: 'Auditor' },
        { name: 'Directors', title: 'Eduardo Quintos, Nelson Basa, Lourdes Paulino' }
      ],
      2: [
        { name: 'Crenella Carvajal', title: 'President' },
        { name: 'Shirley Sevilla', title: 'Vice-President' },
        { name: 'Salve Oandasan', title: 'Secretary' },
        { name: 'Angeli Balaguer', title: 'Treasurer' },
        { name: 'Marceliana Bermudez', title: 'Auditor' },
        { name: 'Directors', title: 'Francis Abujela, Rodrin, Editha Caronan' }
      ],
      3: [
        { name: 'Teresita Balasabas', title: 'President' },
        { name: 'Rhea Lepitin', title: 'Vice-President' },
        { name: 'Agnes Ubas', title: 'Secretary' },
        { name: 'Irene Pasamonte', title: 'Treasurer' },
        { name: 'Marie Gilda Rodolfo', title: 'Auditor' },
        { name: 'Directors', title: 'Nelson Basa, Arlene LIbar, Arellano Cruz' }
      ],
      4: [
        { name: 'Martina Pantig', title: 'President' },
        { name: 'Gina E. Stella', title: 'Vice-President' },
        { name: 'Angeli O. Balaguer', title: 'Secretary' },
        { name: 'Noemie V. Silayan', title: 'Treasurer' },
        { name: 'Elvive S. Calope', title: 'Auditor' },
        { name: 'Directors', title: 'Francis Abejuela, Liberty Jorge, Analiza Analiza' }
      ],
      5: [
        { name: 'Elvie S. Caloper', title: 'President' },
        { name: 'Darlyn Halili', title: 'Vice-President' },
        { name: 'Gina E. Estella', title: 'Secretary' },
        { name: 'Noemie V. Silayan', title: 'Treasurer' },
        { name: 'Glaiza D. Bitang', title: 'Auditor' },
        { name: 'Directors', title: 'Philip Arevalo, Francis Abejuela, Editha Caronan' }
      ],
      6: [
        { name: 'Almario Nieva', title: 'President' },
        { name: 'Ricardo Cena', title: 'Vice-President' },
        { name: 'Twinkle Dessie Dalo', title: 'Secretary' },
        { name: 'Teresita Balasabas', title: 'Treasurer' },
        { name: 'Ronalyn Montalbo', title: 'Auditor' },
        { name: 'Directors', title: 'Saint Gray Paulino, Liberty Jorge, Maryann Nieva' }
      ],
      7: [
        { name: 'Saint Gray Paulino', title: 'President' },
        { name: 'Arsenia Cena', title: 'Vice-President' },
        { name: 'Editha Caronan', title: 'Secretary' },
        { name: 'Teresita Balasabas', title: 'Treasurer' },
        { name: 'Nelson Basa', title: 'Auditor' },
        { name: 'Directors', title: 'Francis Abejuela, Philip Arevalo' }
      ],
    };

    const overlay = document.getElementById('overlay');
    const officerList = document.getElementById('officerList');

    function showPopup(modalNumber) {
      officerList.innerHTML = '';
      officersData[modalNumber].forEach(officer => {
        const li = document.createElement('li');
        li.style.textAlign = 'center';
        li.style.marginBottom = '1rem';
        li.innerHTML = `<div><strong>${officer.name}</strong></div><div><em>${officer.title}</em></div>`;
        officerList.appendChild(li);
      });
      overlay.classList.add('active');
    }

    function closePopup(event) {
      if (!event || event.target === overlay) {
        overlay.classList.remove('active');
      }
    }





    


// Open file selector
document.querySelector('.edit-photo').onclick = () => {
  document.getElementById('imageUpload').click();
};

// Preview uploaded photo
document.getElementById('imageUpload').addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const img = document.getElementById('eventImage');
    img.src = URL.createObjectURL(file);
  }
});

// Delete Photo
document.querySelector('.delete-photo').onclick = () => {
  if (confirm("Are you sure you want to delete the photo?")) {
    document.getElementById('eventImage').src = "placeholder.jpg";
  }
};

// Update Description
document.querySelector('.update-description').onclick = () => {
  const textarea = document.getElementById('eventDescription');
  alert("Description updated:\n\n" + textarea.value);
  // You can replace alert with a real save function if needed
};

  </script>

  </body>
  </html>


