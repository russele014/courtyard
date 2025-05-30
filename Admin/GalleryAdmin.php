<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - The Courtyard of Maia Alta</title>
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
        background-color: rgba(248, 186, 53, 0.595); /* Transparent with blur */
        backdrop-filter: blur(10px);
        padding: 10px 30px;
        z-index: 1000;
        box-sizing: border-box;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
        text-shadow: 2px 2px 4px #000000;
    }

    /* Text on the Left */
    .navbar-left {
        color: white;
        font-size: 30px;
        font-weight: bold;
    }

    /* Options on the Right */
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

    /* Logout Button */
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

    /* Admin Badge */
    .admin-badge {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
        margin-left: 10px;
        text-shadow: none;
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(135deg, rgba(241,196,15,0.9), rgba(243,156,18,0.9)), url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 600"><rect fill="%23ffd700" width="1000" height="600"/><text x="500" y="300" text-anchor="middle" font-size="40" fill="%23fff">Admin Dashboard</text></svg>');
      background-size: cover;
      background-position: center;
      height: 60vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: #2c3e50;
      margin-top: 60px;
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

    /* Admin Controls */
    .admin-controls {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(241,196,15,0.15);
      border: 2px solid #f7dc6f;
      margin-top: -50px;
      position: relative;
      z-index: 10;
    }

    .controls-title {
      font-size: 2rem;
      color: #b7950b;
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 700;
    }

    .control-buttons {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin-bottom: 3rem;
    }

    .control-btn {
      background: linear-gradient(135deg, #f1c40f, #f39c12);
      color: #2c3e50;
      padding: 1.5rem;
      border: none;
      border-radius: 15px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(241,196,15,0.3);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .control-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(241,196,15,0.4);
      background: linear-gradient(135deg, #f39c12, #e67e22);
    }

    .control-btn i {
      font-size: 1.5rem;
    }

    /* Upload Modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.7);
      backdrop-filter: blur(5px);
    }

    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 2rem;
      border-radius: 20px;
      width: 90%;
      max-width: 600px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.3);
      position: relative;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      position: absolute;
      right: 20px;
      top: 15px;
    }

    .close:hover {
      color: #000;
    }

    .modal h2 {
      color: #b7950b;
      margin-bottom: 1.5rem;
      font-size: 1.8rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 0.8rem;
      border: 2px solid #f7dc6f;
      border-radius: 8px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      outline: none;
      border-color: #f1c40f;
    }

    .file-upload {
      border: 2px dashed #f1c40f;
      border-radius: 10px;
      padding: 2rem;
      text-align: center;
      background: #fffef7;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .file-upload:hover {
      background: #fff8e1;
      border-color: #f39c12;
    }

    .file-upload.dragover {
      background: #fff3cd;
      border-color: #f39c12;
    }

    .submit-btn {
      background: linear-gradient(135deg, #f1c40f, #f39c12);
      color: #2c3e50;
      padding: 1rem 2rem;
      border: none;
      border-radius: 50px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
    }

    .submit-btn:hover {
      background: linear-gradient(135deg, #f39c12, #e67e22);
      transform: translateY(-2px);
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
    }

    .cta-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(241,196,15,0.5);
      background: linear-gradient(135deg, #f39c12, #e67e22);
      border-color: #d68910;
    }

    /* Admin Edit Controls */
    .admin-edit-controls {
      position: absolute;
      top: 15px;
      right: 15px;
      display: flex;
      gap: 10px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .section:hover .admin-edit-controls {
      opacity: 1;
    }

    .edit-btn, .delete-btn {
      background: rgba(255,255,255,0.9);
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .edit-btn {
      color: #f39c12;
    }

    .delete-btn {
      color: #dc3545;
    }

    .edit-btn:hover, .delete-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    /* Alternate layout for second section */
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

      .hero-content p {
        font-size: 1.1rem;
      }

      .main-content {
        padding: 2rem 1rem;
      }

      .section-content {
        grid-template-columns: 1fr !important;
      }

      .section-image {
        height: 300px !important;
      }

      .section-text {
        padding: 2rem;
      }

      .section-text h2 {
        font-size: 2rem;
      }

      .section.reverse .section-image {
        order: 1 !important;
      }

      .section.reverse .section-text {
        order: 2 !important;
      }

      .stats-container {
        grid-template-columns: 1fr;
        gap: 2rem;
      }

      .control-buttons {
        grid-template-columns: 1fr;
      }

      .modal-content {
        width: 95%;
        margin: 10% auto;
        padding: 1.5rem;
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

    /* Additional Yellow Accents */
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

    .section {
      position: relative;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <div class="navbar-left">
      The Courtyard of Maia Alta

    </div>
    <ul class="navbar-right">
      <li><a href="index.php">Home</a></li>
      <li><a href="Gallery.php">Gallery</a></li>
      <li><a href="News.php">News</a></li>
      <li><a href="#about-container">About Us</a></li>
      <li><a href="#officers-intro">History</a></li>
      <li><a href="Login.php" class="logout-btn">Logout</a></li>
    </ul>
  </nav>

  <section class="hero">
    <div class="hero-content">
      <h1>Admin Dashboard</h1>
      <p>Manage community content, photos, and events</p>
    </div>
  </section>

  <div class="admin-controls">
    <h2 class="controls-title">Content Management</h2>
    <div class="control-buttons">
      <button class="control-btn" onclick="openModal('picture-modal')">
        📷 Add Single Picture
      </button>
      <button class="control-btn" onclick="openModal('album-modal')">
        📁 Create Photo Album
      </button>

    </div>
  </div>

  <!-- Picture Upload Modal -->
  <div id="picture-modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('picture-modal')">&times;</span>
      <h2>Add Single Picture</h2>
      <form>
        <div class="form-group">
          <label for="pic-title">Picture Title</label>
          <input type="text" id="pic-title" placeholder="Enter picture title">
        </div>
        <div class="form-group">
          <label for="pic-description">Description</label>
          <textarea id="pic-description" rows="3" placeholder="Enter picture description"></textarea>
        </div>
        <div class="form-group">
          <label for="pic-category">Category</label>
          <select id="pic-category">
            <option value="events">Events</option>
            <option value="community">Community</option>
            <option value="facilities">Facilities</option>
            <option value="news">News</option>
          </select>
        </div>
        <div class="form-group">
          <label>Upload Picture</label>
          <div class="file-upload" onclick="document.getElementById('single-pic').click()">
            <p>📸 Click or drag to upload picture</p>
            <input type="file" id="single-pic" accept="image/*" style="display: none;">
          </div>
        </div>
        <button type="submit" class="submit-btn">Upload Picture</button>
      </form>
    </div>
  </div>

  <!-- Album Upload Modal -->
  <div id="album-modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('album-modal')">&times;</span>
      <h2>Create Photo Album</h2>
      <form>
        <div class="form-group">
          <label for="album-title">Album Title</label>
          <input type="text" id="album-title" placeholder="Enter album title">
        </div>
        <div class="form-group">
          <label for="album-description">Album Description</label>
          <textarea id="album-description" rows="3" placeholder="Enter album description"></textarea>
        </div>
        <div class="form-group">
          <label for="album-date">Event Date</label>
          <input type="date" id="album-date">
        </div>
        <div class="form-group">
          <label>Upload Multiple Pictures</label>
          <div class="file-upload" onclick="document.getElementById('album-pics').click()">
            <p>📁 Click or drag to upload multiple pictures</p>
            <input type="file" id="album-pics" accept="image/*" multiple style="display: none;">
          </div>
        </div>
        <button type="submit" class="submit-btn">Create Album</button>
      </form>
    </div>
  </div>

  <main class="main-content">
    <div class="section">
      <div class="admin-edit-controls">
        <button class="edit-btn" title="Edit">✏️</button>
        <button class="delete-btn" title="Delete">🗑️</button>
      </div>
      <div class="section-content">
        <div class="section-image">
          <img src="Endyr.jpg" alt="End Year Party 2024" />
        </div>
        <div class="section-text">
          <h2>End Year Party 2024</h2>
          <p>Join us as we celebrate another successful year in our community. Our annual end-of-year celebration brings together neighbors, families, and friends for an unforgettable evening of entertainment, delicious food, and meaningful connections.</p>
          <a href="#" class="cta-button">View Gallery</a>
        </div>
      </div>
    </div>

    <div class="section reverse">
      <div class="admin-edit-controls">
        <button class="edit-btn" title="Edit">✏️</button>
        <button class="delete-btn" title="Delete">🗑️</button>
      </div>
      <div class="section-content">
        <div class="section-image">
          <img src="Cmas.jpg" alt="Christmas Party" />
        </div>
        <div class="section-text">
          <h2>Christmas Celebration</h2>
          <p>Experience the magic of Christmas with our community family. From traditional carols to festive decorations, our Christmas party creates lasting memories and strengthens the bonds that make Maia Alta special.</p>
          <a href="#" class="cta-button">Learn More</a>
        </div>
      </div>
    </div>
  </main>

  <section class="stats-section">
    <div class="stats-container">
      <div class="stat-item">
        <h3>500+</h3>
        <p>Community Members</p>
      </div>
      <div class="stat-item">
        <h3>25+</h3>
        <p>Annual Events</p>
      </div>
      <div class="stat-item">
        <h3>15</h3>
        <p>Years of Service</p>
      </div>
      <div class="stat-item">
        <h3>100%</h3>
        <p>Community Spirit</p>
      </div>
    </div>
  </section>

  <footer class="footer">
    <p>&copy; 2024 The Courtyard of Maia Alta. All rights reserved. | Admin Panel</p>
  </footer>

  <script>
    function openModal(modalId) {
      document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
      const modals = document.querySelectorAll('.modal');
      modals.forEach(modal => {
        if (event.target === modal) {
          modal.style.display = 'none';
        }
      });
    }

    // File upload drag and drop functionality
    document.querySelectorAll('.file-upload').forEach(upload => {
      upload.addEventListener('dragover', (e) => {
        e.preventDefault();
        upload.classList.add('dragover');
      });

      upload.addEventListener('dragleave', (e) => {
        e.preventDefault();
        upload.classList.remove('dragover');
      });

      upload.addEventListener('drop', (e) => {
        e.preventDefault();
        upload.classList.remove('dragover');
        // Handle file drop here
      });
    });

    // File input change handlers
    document.querySelectorAll('input[type="file"]').forEach(input => {
      input.addEventListener('change', function() {
        const fileUpload = this.parentElement;
        const fileCount = this.files.length;
        if (fileCount > 0) {
          const text = fileCount === 1 ? 
            `📁 ${this.files[0].name}` : 
            `📁 ${fileCount} files selected`;
          fileUpload.querySelector('p').textContent = text;
        }
      });
    });
  </script>
</body>
</html>