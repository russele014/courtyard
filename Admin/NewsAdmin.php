<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard: Manage Posts</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <link rel="stylesheet" href="/courtyard/navbar.css" />
  <style>
    /* Modal Overlay */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      backdrop-filter: blur(5px);
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      z-index: 1000;
    }

    .modal-overlay.open {
      opacity: 1;
      visibility: visible;
    }

    /* Modal Content */
    .modal-content {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border-radius: 20px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      padding: 2rem;
      max-height: 90vh;
      overflow-y: auto;
      transform: scale(0.8) translateY(20px);
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modal-overlay.open .modal-content {
      transform: scale(1) translateY(0);
    }

    /* Modal Close Button */
    .modal-close-button {
      position: absolute;
      top: 15px;
      right: 20px;
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      font-size: 20px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      font-weight: bold;
    }

    .modal-close-button:hover {
      background: rgba(239, 68, 68, 0.2);
      transform: scale(1.1);
    }

    /* Main Layout */
    .main-layout {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    /* Add Post Button */
    #addPostButton {
      width: 200px;
      height: 60px;
      border-radius: 15px;
      font-size: 18px;
      font-weight: bold;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 2rem;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    #addPostButton:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    /* Post Cards Grid */
    .posts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    /* Post Card */
    .post-card {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      border: 1px solid rgba(0, 0, 0, 0.05);
      position: relative;
      overflow: hidden;
    }

    .post-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .post-card img {
      border-radius: 10px;
      margin-bottom: 1rem;
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .post-card h3 {
      font-weight: bold;
      font-size: 1.25rem;
      margin-bottom: 0.75rem;
      color: #1f2937;
    }

    .post-card p {
      color: #6b7280;
      margin-bottom: 1.5rem;
      line-height: 1.6;
    }

    .post-card button {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
    }

    .post-card button:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    }

    /* Form Styling */
    .form-input {
      width: 100%;
      padding: 0.75rem;
      border: 2px solid #e5e7eb;
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #f9fafb;
    }

    .form-input:focus {
      outline: none;
      border-color: #3b82f6;
      background: white;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-label {
      display: block;
      color: #374151;
      font-size: 0.875rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    /* Image Preview */
    #imagePreview {
      max-height: 200px;
      border-radius: 10px;
      border: 2px dashed #d1d5db;
      transition: all 0.3s ease;
    }

    #imagePreview:hover {
      border-color: #3b82f6;
    }

    /* Action Buttons */
    .action-btn {
      padding: 0.75rem 2rem;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 1rem;
    }

    .action-btn:hover {
      transform: translateY(-1px);
    }

    /* Success Animation */
    @keyframes successPulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .success-animation {
      animation: successPulse 0.6s ease-in-out;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .posts-grid {
        grid-template-columns: 1fr;
      }
      
      .modal-content {
        margin: 1rem;
        padding: 1.5rem;
      }
      
      #addPostButton {
        width: 100%;
      }
    }





    .logo {
  width: 50px;
  height: 50px;
  position: fixed; /* Keeps the element fixed in the viewport */
  bottom: 20px; /* Adjust the distance from the bottom */
  right: 20px; /* Adjust the distance from the right */
  z-index: 100; /* Ensures the logo stays on top of other content */
}




  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen p-4">
      <nav class="navbar">
      <div class="navbar-left">Courtyard of Maia Alta</div>
      <ul class="navbar-right">
        <li><a href="index.php">Home</a></li>
        <li><a href="Gallery.php">Gallery </a></li>
        <li><a href="News.php">News</a></li>
        <li><a href="#about-container">About Us</a></li>
        <li><a href="#officers-intro">History</a></li>
        <li><a href="Login.php" class="logout-btn">Login</a></li>
      </ul>
    </nav>

<div class="text-center mb-8 w-full">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
    <p class="text-lg text-gray-600">Manage Posts</p>
  </div>

  <div class="main-layout">
    <div class="flex justify-center mb-6">
      <button id="addPostButton" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
        <i class="fas fa-plus"></i>
        Add New Post
      </button>
    </div>

    <!-- Posts Grid -->
    <div id="postsContainer" class="posts-grid">
      <!-- Sample Post Cards -->
      <div class="post-card">
        <img src="https://placehold.co/300x180/FCA5A5/FFFFFF?text=Sample+Post+1" alt="Post Image">
        <h3>Welcome to Our Blog</h3>
        <p>This is our first blog post where we introduce ourselves and share our vision for the future.</p>
        <button onclick="viewPost(1)">Read More</button>
      </div>

      <div class="post-card">
        <img src="https://placehold.co/300x180/A78BFA/FFFFFF?text=Sample+Post+2" alt="Post Image">
        <h3>Getting Started Guide</h3>
        <p>A comprehensive guide to help you get started with our platform and make the most of its features.</p>
        <button onclick="viewPost(2)">Read More</button>
      </div>

      <div class="post-card">
        <img src="https://placehold.co/300x180/34D399/FFFFFF?text=Sample+Post+3" alt="Post Image">
        <h3>Best Practices</h3>
        <p>Learn about the best practices and tips to optimize your workflow and achieve better results.</p>
        <button onclick="viewPost(3)">Read More</button>
      </div>
    </div>
  </div>

  <!-- Modal 1 - Create Post -->
  <div id="myModal1" class="modal-overlay">
    <div class="modal-content relative flex flex-col items-center max-w-2xl mx-auto">
      <button class="modal-close-button" data-modal-id="myModal1">&times;</button>
      <div class="w-full flex-col items-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Create New Post</h2>

        <div class="mb-6 w-full">
          <label for="imageUpload" class="form-label">Upload Image:</label>
          <input type="file" id="imageUpload" accept="image/*" class="form-input">
        </div>

        <div class="mb-6 w-full">
          <label class="form-label">Image Preview:</label>
          <div class="text-center">
            <img id="imagePreview" src="https://placehold.co/400x200/E5E7EB/9CA3AF?text=No+Image+Selected"
                 alt="Image Preview"
                 class="w-full h-auto object-cover mx-auto">
          </div>
        </div>

        <div class="mb-6 w-full">
          <label for="postTitleEditor" class="form-label">Post Title:</label>
          <input type="text" id="postTitleEditor" class="form-input" placeholder="Enter an engaging post title...">
        </div>

        <div class="mb-8 w-full">
          <label for="postContentEditor" class="form-label">Post Content:</label>
          <textarea id="postContentEditor" rows="8" class="form-input resize-y" placeholder="Write your post content here... Share your thoughts, insights, and ideas!"></textarea>
        </div>

        <div class="flex gap-4 justify-center w-full">
          <button id="cancelCreateBtn" class="action-btn bg-gray-500 hover:bg-gray-600 text-white">
            Cancel
          </button>
          <button id="createPostBtn" class="action-btn bg-green-600 hover:bg-green-700 text-white">
            <i class="fas fa-plus mr-2"></i>
            Create Post
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div id="successModal" class="modal-overlay">
    <div class="modal-content relative flex flex-col items-center max-w-md mx-auto text-center">
      <button class="modal-close-button" data-modal-id="successModal">&times;</button>
      <div class="w-full flex-col items-center">
        <div class="text-green-600 text-6xl mb-4">
          <i class="fas fa-check-circle"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Post Created Successfully!</h2>
        <p class="text-gray-600 mb-6">Your new post has been added to the dashboard.</p>
        <button id="successOkBtn" class="action-btn bg-green-600 hover:bg-green-700 text-white">
          <i class="fas fa-thumbs-up mr-2"></i>
          Great!
        </button>
      </div>
    </div>
  </div>



   <img src="chat.png" alt="Your Logo" class="logo">






  <!-- JavaScript for modal functionality and post creation -->
  <script>
    let postCounter = 4; // Starting from 4 since we have 3 sample posts
    const colors = ['FCA5A5', 'A78BFA', '34D399', '60A5FA', 'F472B6', 'FBBF24'];

    // Open Modal 1 when clicking the add post button
    document.getElementById('addPostButton').addEventListener('click', () => {
      document.getElementById('myModal1').classList.add('open');
      document.body.style.overflow = 'hidden'; // Prevent background scrolling
    });

    // Close modal functionality
    function closeModal(modalId) {
      document.getElementById(modalId).classList.remove('open');
      document.body.style.overflow = 'auto'; // Restore scrolling
      
      // Clear form if closing create modal
      if (modalId === 'myModal1') {
        clearCreateForm();
      }
    }

    // Close modal on close button click
    document.querySelectorAll('.modal-close-button').forEach(button => {
      button.addEventListener('click', () => {
        const modalId = button.getAttribute('data-modal-id');
        closeModal(modalId);
      });
    });

    // Close modal when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
          closeModal(overlay.id);
        }
      });
    });

    // Cancel button closes modal
    document.getElementById('cancelCreateBtn').addEventListener('click', () => {
      closeModal('myModal1');
    });

    // Success modal OK button
    document.getElementById('successOkBtn').addEventListener('click', () => {
      closeModal('successModal');
    });

    // Image preview functionality
    document.getElementById('imageUpload').addEventListener('change', function () {
      const file = this.files[0];
      const preview = document.getElementById('imagePreview');
      
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
          preview.style.borderStyle = 'solid';
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = "https://placehold.co/400x200/E5E7EB/9CA3AF?text=No+Image+Selected";
        preview.style.borderStyle = 'dashed';
      }
    });

    // Create post functionality
    document.getElementById('createPostBtn').addEventListener('click', () => {
      const title = document.getElementById('postTitleEditor').value.trim();
      const content = document.getElementById('postContentEditor').value.trim();
      const imageFile = document.getElementById('imageUpload').files[0];
      
      // Validation
      if (!title) {
        alert('Please enter a post title.');
        document.getElementById('postTitleEditor').focus();
        return;
      }
      
      if (!content) {
        alert('Please enter post content.');
        document.getElementById('postContentEditor').focus();
        return;
      }

      // Create new post card
      createNewPost(title, content, imageFile);
      
      // Close create modal and show success modal
      closeModal('myModal1');
      document.getElementById('successModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    });

    // Function to create new post
    function createNewPost(title, content, imageFile) {
      const postsContainer = document.getElementById('postsContainer');
      const postCard = document.createElement('div');
      postCard.className = 'post-card success-animation';
      
      // Get random color for placeholder
      const colorIndex = (postCounter - 1) % colors.length;
      const color = colors[colorIndex];
      
      // Handle image source
      let imageSrc;
      if (imageFile) {
        imageSrc = URL.createObjectURL(imageFile);
      } else {
        imageSrc = `https://placehold.co/300x180/${color}/FFFFFF?text=Post+${postCounter}`;
      }
      
      // Truncate content for preview
      const truncatedContent = content.length > 100 ? content.substring(0, 100) + '...' : content;
      
      postCard.innerHTML = `
        <img src="${imageSrc}" alt="Post Image" onerror="this.src='https://placehold.co/300x180/${color}/FFFFFF?text=Post+${postCounter}'">
        <h3>${title}</h3>
        <p>${truncatedContent}</p>
        <button onclick="viewPost(${postCounter})">Read More</button>
      `;
      
      // Insert at the beginning of the posts container
      postsContainer.insertBefore(postCard, postsContainer.firstChild);
      
      // Scroll to the new post
      setTimeout(() => {
        postCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }, 300);
      
      postCounter++;
    }

    // Function to clear create form
    function clearCreateForm() {
      document.getElementById('postTitleEditor').value = '';
      document.getElementById('postContentEditor').value = '';
      document.getElementById('imageUpload').value = '';
      document.getElementById('imagePreview').src = "https://placehold.co/400x200/E5E7EB/9CA3AF?text=No+Image+Selected";
      document.getElementById('imagePreview').style.borderStyle = 'dashed';
    }

    // Function to view post (placeholder)
    function viewPost(postId) {
      alert(`Opening post ${postId}... (This would navigate to the full post view)`);
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      // ESC to close modals
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.open').forEach(modal => {
          closeModal(modal.id);
        });
      }
      
      // Ctrl/Cmd + N to add new post
      if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
        e.preventDefault();
        document.getElementById('addPostButton').click();
      }
    });

    // Add some sample interaction feedback
    document.getElementById('addPostButton').addEventListener('mouseenter', function() {
      this.innerHTML = '<i class="fas fa-plus"></i> Create New Post';
    });

    document.getElementById('addPostButton').addEventListener('mouseleave', function() {
      this.innerHTML = '<i class="fas fa-plus"></i> Add New Post';
    });
  </script>
</body>
</html>