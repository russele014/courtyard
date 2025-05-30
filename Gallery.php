<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>The Courtyard of Maia Alta</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      color: #333;
      background: #fefefe;
    }

    /* Navbar Style */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        width: 100%;
        background-color: rgba(248, 186, 53, 0.595);
        backdrop-filter: blur(10px);
        padding: 10px 30px;
        z-index: 1000;
        box-sizing: border-box;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
        text-shadow: 2px 2px 4px #000000;
    }

    .navbar-left {
        color: white;
        font-size: 30px;
        font-weight: bold;
    }

    .navbar-right {
        list-style: none;
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .navbar-right li a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        padding: 6px 12px;
        border-radius: 5px;
        transition: background 0.3s ease;
        font-weight: 400;
    }

    .navbar-right li a:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .logout-btn {
        background-color: #dc3545;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .logout-btn:hover {
        background-color: #a72b38;
    }

    /* Admin Toggle */
    .admin-toggle {
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-left: 10px;
        transition: background-color 0.3s;
    }

    .admin-toggle:hover {
        background-color: #218838;
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, rgba(241,196,15,0.9), rgba(243,156,18,0.9)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600"><rect fill="%23ffd700" width="1000" height="600"/><text x="500" y="300" text-anchor="middle" font-size="40" fill="%23fff">Hero Background</text></svg>');
      background-size: cover;
      background-position: center;
      height: 60vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #2c3e50;
    }

    .hero-content h1 {
      font-size: 3.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 4px rgba(255,255,255,0.5);
    }

    .hero-content p {
      font-size: 1.3rem;
      max-width: 600px;
      margin: 0 auto;
      opacity: 0.8;
      font-weight: 500;
    }

    /* Main Content */
    .main-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 4rem 2rem;
    }

    .section {
      margin-bottom: 5rem;
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(241,196,15,0.15);
      border: 2px solid #f7dc6f;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
    }

    .section:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 50px rgba(241,196,15,0.25);
      border-color: #f1c40f;
    }

    .section-content {
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      min-height: 500px;
    }

    .section-image {
      height: 500px;
      position: relative;
      overflow: hidden;
    }

    .section-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .section:hover .section-image img {
      transform: scale(1.05);
    }

    .section-text {
      padding: 3rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .section-text h2 {
      font-size: 2.5rem;
      color: #b7950b;
      margin-bottom: 1.5rem;
      font-weight: 700;
    }

    .section-text p {
      font-size: 1.1rem;
      color: #555;
      line-height: 1.8;
      margin-bottom: 2rem;
    }

    .cta-button {
      display: inline-block;
      background: linear-gradient(135deg, #f1c40f, #f39c12);
      color: #2c3e50;
      padding: 1rem 2rem;
      text-decoration: none;
      border-radius: 50px;
      font-weight: 700;
      transition: all 0.3s ease;
      align-self: flex-start;
      box-shadow: 0 4px 15px rgba(241,196,15,0.4);
      border: 2px solid transparent;
      cursor: pointer;
      border: none;
      font-size: 1rem;
    }

    .cta-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(241,196,15,0.5);
      background: linear-gradient(135deg, #f39c12, #e67e22);
      border-color: #d68910;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.8);
      backdrop-filter: blur(5px);
    }

    .modal-content {
      background-color: white;
      margin: 2% auto;
      padding: 0;
      border-radius: 20px;
      width: 90%;
      max-width: 1000px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 60px rgba(0,0,0,0.3);
      animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
      from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    .modal-header {
      background: linear-gradient(135deg, #f1c40f, #f39c12);
      color: #2c3e50;
      padding: 2rem;
      border-radius: 20px 20px 0 0;
      position: relative;
    }

    .modal-header h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0;
    }

    .close {
      position: absolute;
      top: 1rem;
      right: 1.5rem;
      color: #2c3e50;
      font-size: 2rem;
      font-weight: bold;
      cursor: pointer;
      transition: color 0.3s;
    }

    .close:hover {
      color: #e74c3c;
    }

    .modal-body {
      padding: 2rem;
    }

    /* Admin Upload Section */
    .admin-section {
      display: none;
      background: #f8f9fa;
      padding: 2rem;
      border-radius: 15px;
      margin-bottom: 2rem;
      border: 2px dashed #f1c40f;
    }

    .admin-section.active {
      display: block;
    }

    .upload-form {
      display: grid;
      gap: 1rem;
      margin-bottom: 2rem;
    }

    .upload-form input, .upload-form textarea {
      padding: 0.8rem;
      border: 2px solid #ddd;
      border-radius: 10px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    .upload-form input:focus, .upload-form textarea:focus {
      outline: none;
      border-color: #f1c40f;
    }

    .upload-form textarea {
      min-height: 100px;
      resize: vertical;
    }

    .upload-btn {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      padding: 1rem 2rem;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .upload-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(40,167,69,0.4);
    }

    /* Gallery Grid */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-top: 2rem;
    }

    .gallery-item {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
      border: 2px solid #f7dc6f;
    }

    .gallery-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(241,196,15,0.2);
    }

    .gallery-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .gallery-item-content {
      padding: 1.5rem;
    }

    .gallery-item h3 {
      color: #b7950b;
      margin-bottom: 0.5rem;
      font-size: 1.3rem;
    }

    .gallery-item p {
      color: #666;
      font-size: 0.9rem;
      line-height: 1.4;
    }

    .gallery-item .date {
      color: #999;
      font-size: 0.8rem;
      margin-top: 0.5rem;
    }

    /* Reverse layout */
    .section.reverse .section-content {
      grid-template-columns: 1fr 1fr;
    }

    .section.reverse .section-image {
      order: 2;
    }

    .section.reverse .section-text {
      order: 1;
    }

    /* Stats Section */
    .stats-section {
      background: linear-gradient(135deg, #f1c40f, #f39c12);
      color: #2c3e50;
      padding: 4rem 2rem;
      margin: 5rem 0;
      position: relative;
    }

    .stats-container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 3rem;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    .stat-item {
      background: rgba(255,255,255,0.2);
      padding: 2rem;
      border-radius: 15px;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.3);
    }

    .stat-item h3 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
    }

    .stat-item p {
      font-size: 1.2rem;
      font-weight: 600;
    }

    /* Footer */
    .footer {
      background: #b7950b;
      color: white;
      text-align: center;
      padding: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        gap: 1rem;
        padding: 1rem;
      }

      .navbar-right {
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
      }

      .hero-content h1 {
        font-size: 2.5rem;
      }

      .modal-content {
        width: 95%;
        margin: 5% auto;
      }

      .modal-header h2 {
        font-size: 2rem;
      }

      .gallery-grid {
        grid-template-columns: 1fr;
      }

      .section-content {
        grid-template-columns: 1fr !important;
      }

      .section-image {
        height: 300px !important;
      }

      .section.reverse .section-image {
        order: 1 !important;
      }

      .section.reverse .section-text {
        order: 2 !important;
      }
    }

    /* Loading Animation */
    .section {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeInUp 0.8s ease forwards;
    }

    .section:nth-child(2) { animation-delay: 0.2s; }
    .section:nth-child(3) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(to bottom, #f1c40f, #f39c12);
      z-index: 1;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <div class="navbar-left">The Courtyard of Maia Alta</div>
    <ul class="navbar-right">
      <li><a href="index.php">Home</a></li>
      <li><a href="Gallery.php">Gallery</a></li>
      <li><a href="News.php">News</a></li>
      <li><a href="#about-container">About Us</a></li>
      <li><a href="#officers-intro">History</a></li>
      <li><a href="Login.php" class="logout-btn">Login</a></li>

    </ul>
  </nav>

  <section class="hero">
    <div class="hero-content">
      <h1>Welcome to Maia Alta</h1>
      <p>Celebrating community, tradition, and togetherness in the heart of our beautiful neighborhood</p>
    </div>
  </section>

  <main class="main-content">
    <div class="section">
      <div class="section-content">
        <div class="section-image">
          <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'><rect fill='%23f1c40f' width='400' height='300'/><text x='200' y='150' text-anchor='middle' font-size='24' fill='%23fff'>End Year Party</text></svg>" alt="End Year Party 2024" />
        </div>
        <div class="section-text">
          <h2>End Year Party 2024</h2>
          <p>Join us as we celebrate another successful year in our community. Our annual end-of-year celebration brings together neighbors, families, and friends for an unforgettable evening of entertainment, delicious food, and meaningful connections.</p>
          <button class="cta-button" onclick="openModal('endyear')">View Gallery</button>
        </div>
      </div>
    </div>

    <div class="section reverse">
      <div class="section-content">
        <div class="section-image">
          <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'><rect fill='%23e74c3c' width='400' height='300'/><text x='200' y='150' text-anchor='middle' font-size='24' fill='%23fff'>Christmas Party</text></svg>" alt="Christmas Party" />
        </div>
        <div class="section-text">
          <h2>Christmas Celebration</h2>
          <p>Experience the magic of Christmas with our community family. From traditional carols to festive decorations, our Christmas party creates lasting memories and strengthens the bonds that make Maia Alta special.</p>
          <button class="cta-button" onclick="openModal('christmas')">Learn More</button>
        </div>
      </div>
    </div>
  </main>

  <section class="stats-section">
    <div class="stats-container">
      <div class="stat-item">
        <h3>50+</h3>
        <p>Community Members</p>
      </div>
      <div class="stat-item">
        <h3>5+</h3>
        <p>Annual Events</p>
      </div>
      <div class="stat-item"> 
        <h3>7</h3>
        <p>Years of Service</p>
      </div>
      <div class="stat-item">
        <h3>100%</h3>
        <p>Community Spirit</p>
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div id="eventModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modalTitle">Event Gallery</h2>
      </div>
      <div class="modal-body">
        <!-- Admin Upload Section -->
        <div id="adminSection" class="admin-section">
          <h3>Admin Upload</h3>
          <div class="upload-form">
            <input type="text" id="postTitle" placeholder="Post Title" />
            <textarea id="postDescription" placeholder="Post Description"></textarea>
            <input type="file" id="imageUpload" accept="image/*" multiple />
            <button class="upload-btn" onclick="uploadPost()">Add New Post</button>
          </div>
        </div>

        <!-- Gallery Content -->
        <div id="galleryContent" class="gallery-grid">
          <!-- Dynamic content will be loaded here -->
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <p>&copy; 2024 The Courtyard of Maia Alta. All rights reserved.</p>
  </footer>

  <script>
    let isAdminMode = false;
    let currentEvent = '';

    // Sample data for different events
    const eventData = {
      endyear: [
        {
          id: 1,
          title: "New Year Countdown",
          description: "Community members gathered to welcome 2024 with fireworks and celebration.",
          image: "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%23f39c12' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>Countdown Event</text></svg>",
          date: "December 31, 2023"
        },
        {
          id: 2,
          title: "Year-End Recognition",
          description: "Honoring community volunteers and celebrating achievements of the past year.",
          image: "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%23e67e22' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>Recognition</text></svg>",
          date: "December 30, 2023"
        },
        {
          id: 3,
          title: "Community Dinner",
          description: "A special dinner bringing together all families in our community.",
          image: "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%23d68910' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>Dinner</text></svg>",
          date: "December 29, 2023"
        }
      ],
      christmas: [
        {
          id: 4,
          title: "Christmas Carol Night",
          description: "Traditional Christmas carols performed by community members of all ages.",
          image: "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%23c0392b' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>Carol Night</text></svg>",
          date: "December 24, 2023"
        },
        {
          id: 5,
          title: "Santa's Visit",
          description: "Special visit from Santa Claus with gifts for all the children in our community.",
          image: "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%23a93226' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>Santa Visit</text></svg>",
          date: "December 25, 2023"
        },
        {
          id: 6,
          title: "Christmas Tree Lighting",
          description: "The annual lighting of our community Christmas tree with hot cocoa and cookies.",
          image: "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%23922b21' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>Tree Lighting</text></svg>",
          date: "December 23, 2023"
        }
      ]
    };

    function toggleAdminMode() {
      isAdminMode = !isAdminMode;
      const adminBtn = document.querySelector('.admin-toggle');
      adminBtn.textContent = isAdminMode ? 'User Mode' : 'Admin Mode';
      adminBtn.style.backgroundColor = isAdminMode ? '#dc3545' : '#28a745';
      
      if (document.getElementById('eventModal').style.display === 'block') {
        loadGalleryContent(currentEvent);
      }
    }

    function openModal(eventType) {
      currentEvent = eventType;
      const modal = document.getElementById('eventModal');
      const modalTitle = document.getElementById('modalTitle');
      
      modalTitle.textContent = eventType === 'endyear' ? 'End Year Party 2024' : 'Christmas Celebration';
      modal.style.display = 'block';
      
      loadGalleryContent(eventType);
    }

    function closeModal() {
      document.getElementById('eventModal').style.display = 'none';
    }

    function loadGalleryContent(eventType) {
      const galleryContent = document.getElementById('galleryContent');
      const adminSection = document.getElementById('adminSection');
      
      // Show/hide admin section
      if (isAdminMode) {
        adminSection.classList.add('active');
      } else {
        adminSection.classList.remove('active');
      }
      
      // Load gallery items
      const posts = eventData[eventType] || [];
      galleryContent.innerHTML = posts.map(post => `
        <div class="gallery-item">
          <img src="${post.image}" alt="${post.title}" />
          <div class="gallery-item-content">
            <h3>${post.title}</h3>
            <p>${post.description}</p>
            <div class="date">${post.date}</div>
          </div>
        </div>
      `).join('');
    }

    function uploadPost() {
      const title = document.getElementById('postTitle').value;
      const description = document.getElementById('postDescription').value;
      const imageUpload = document.getElementById('imageUpload').files;
      
      if (!title || !description) {
        alert('Please fill in all fields');
        return;
      }
      
      // Create new post
      const newPost = {
        id: Date.now(),
        title: title,
        description: description,
        image: imageUpload.length > 0 ? 
          "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%2327ae60' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='14' fill='%23fff'>New Upload</text></svg>" :
          "data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'><rect fill='%2334495e' width='300' height='200'/><text x='150' y='100' text-anchor='middle' font-size='16' fill='%23fff'>No Image</text></svg>",
        date: new Date().toLocaleDateString('en-US', { 
          year: 'numeric', 
          month: 'long', 
          day: 'numeric' 
        })
      };
      
      // Add to current event data
      if (!eventData[currentEvent]) {
        eventData[currentEvent] = [];
      }
      eventData[currentEvent].unshift(newPost);
      
      // Reload gallery
      loadGalleryContent(currentEvent);
      
      // Clear form
      document.getElementById('postTitle').value = '';
      document.getElementById('postDescription').value = '';
      document.getElementById('imageUpload').value = '';
      
      alert('Post uploaded successfully!');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modal = document.getElementById('eventModal');
      if (event.target === modal) {
        closeModal();
      }
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeModal();
      }
    });
  </script>
</body>
</html> 