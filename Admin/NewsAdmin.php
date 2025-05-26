<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard: Manage News</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <link rel="stylesheet" href="/courtyard/navbar.css" />
  <style>
    /* General Modal Overlay */
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
      width: 90%; /* Make modal wider for forms */
      max-width: 700px; /* Max width for consistency */
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

    /* Add News Article Button */
    #addNewsArticleButton {
      width: 250px;
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
      background-color: #3b82f6; /* Tailwind blue-500 */
      color: white; /* Ensure text is white */
    }

    #addNewsArticleButton:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
      background-color: #2563eb; /* Tailwind blue-600 */
    }

    /* Logo at bottom right */
    .logo {
      width: 50px;
      height: 50px;
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 100;
    }

    /* News specific styles */
    .news-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    .news-card {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.4s ease;
      border: 1px solid rgba(0, 0, 0, 0.05);
      position: relative; /* Needed for positioning delete button */
    }

    .news-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .news-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .news-card:hover img {
      transform: scale(1.05);
    }

    .news-card-content {
      padding: 1.5rem;
    }

    .news-card h3 {
      font-weight: bold;
      font-size: 1.3rem;
      margin-bottom: 0.75rem;
      color: #1f2937;
      line-height: 1.4;
    }

    .news-card p {
      color: #6b7280;
      margin-bottom: 1rem;
      line-height: 1.6;
      font-size: 0.95rem;
    }

    .news-meta {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1rem;
      font-size: 0.85rem;
      color: #9ca3af;
    }

    .news-category {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .read-more-btn {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      border-radius: 25px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .read-more-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    /* NEW: Delete Button on News Cards */
    .delete-btn {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(239, 68, 68, 0.8); /* Red with some transparency */
      color: white;
      border: none;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      font-size: 1rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease-in-out;
      z-index: 10; /* Ensure it's above other elements */
    }

    .delete-btn:hover {
      background: #ef4444; /* Solid red on hover */
      transform: scale(1.1);
      box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
    }

    /* Modal Article Content (for news modal) */
    .modal-article {
      line-height: 1.8;
    }

    .modal-article h1 {
      font-size: 2rem;
      font-weight: bold;
      color: #1f2937;
      margin-bottom: 1rem;
      line-height: 1.3;
    }

    .modal-article .article-meta {
      display: flex;
      align-items: center;
      gap: 2rem;
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #e5e7eb;
      flex-wrap: wrap;
    }

    .modal-article .article-meta span {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: #6b7280;
      font-size: 0.9rem;
    }

    .modal-article img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 15px;
      margin-bottom: 2rem;
    }

    .modal-article .article-content {
      font-size: 1.1rem;
      color: #374151;
      white-space: pre-line;
    }

    /* Form within modals */
    .modal-form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem; /* Equivalent to my-5 for vertical spacing between elements */
    }

    .modal-form label {
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.25rem;
      display: block; /* Ensure label is on its own line */
    }

    .modal-form input[type="text"],
    .modal-form input[type="url"],
    .modal-form input[type="date"],
    .modal-form textarea,
    .modal-form select {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #d1d5db; /* Tailwind gray-300 */
      border-radius: 0.5rem; /* Tailwind rounded-lg */
      font-size: 1rem;
      color: #374151;
      background-color: #f9fafb; /* Tailwind gray-50 */
      transition: all 0.2s ease-in-out;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .modal-form input[type="text"]:focus,
    .modal-form input[type="url"]:focus,
    .modal-form input[type="date"]:focus,
    .modal-form textarea:focus,
    .modal-form select:focus {
      outline: none;
      border-color: #3b82f6; /* Tailwind blue-500 */
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Tailwind ring-blue-200 */
      background-color: #ffffff;
    }

    .modal-form textarea {
      min-height: 120px;
      resize: vertical;
    }

    .modal-buttons {
      display: flex;
      justify-content: flex-end; /* Align buttons to the right */
      gap: 1rem;
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 1px solid #e5e7eb; /* Light separator line */
    }

    .modal-buttons button {
      padding: 0.75rem 1.5rem;
      border-radius: 0.5rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease-in-out;
    }

    .modal-buttons .post-btn {
      background-color: #22c55e; /* Tailwind green-500 */
      color: white;
      border: none;
    }

    .modal-buttons .post-btn:hover {
      background-color: #16a34a; /* Tailwind green-600 */
      box-shadow: 0 4px 10px rgba(34, 197, 94, 0.2);
    }

    .modal-buttons .clear-btn {
      background-color: #f59e0b; /* Tailwind amber-500 */
      color: white;
      border: none;
    }

    .modal-buttons .clear-btn:hover {
      background-color: #d97706; /* Tailwind amber-600 */
      box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);
    }

    /* Smooth scrollbar for modals */
    .modal-content::-webkit-scrollbar {
      width: 8px;
    }

    .modal-content::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }

    .modal-content::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 10px;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .news-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .modal-content {
        margin: 1rem;
        padding: 1.5rem;
      }

      #addNewsArticleButton {
        width: 100%;
      }

      .modal-article h1 {
        font-size: 1.5rem;
      }

      .modal-article .article-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }

      .modal-buttons {
        flex-direction: column;
      }

      .modal-buttons button {
        width: 100%;
      }
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
    <p class="text-lg text-gray-600">Manage News Articles</p>
  </div>

  <div class="main-layout">
    <div class="flex justify-center mb-6">
      <button id="addNewsArticleButton" class="bg-blue-600 hover:bg-blue-700 text-white cursor-pointer">
        <i class="fas fa-plus"></i>
        Add New News Article
      </button>
    </div>

    <div class="my-12 pt-12">
      <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Community News Articles</h2>
      <div id="newsContainer" class="news-grid">
        </div>
    </div>
  </div>

  <div id="newsArticleModal" class="modal-overlay">
    <div class="modal-content relative">
      <button class="modal-close-button" data-modal-id="newsArticleModal">&times;</button>
      <div id="modalArticleContent" class="modal-article">
        </div>
    </div>
  </div>

  <div id="addNewsArticleFormModal" class="modal-overlay">
    <div class="modal-content relative">
      <button class="modal-close-button" data-modal-id="addNewsArticleFormModal">&times;</button>
      <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Post New News Article</h2>
      <form id="newsArticleForm" class="modal-form">
        <div>
          <label for="articleTitle">Title:</label>
          <input type="text" id="articleTitle" placeholder="Enter article title" required>
        </div>
        <div>
          <label for="articleSummary">Summary:</label>
          <textarea id="articleSummary" placeholder="A brief summary of the article" required></textarea>
        </div>
        <div>
          <label for="articleContent">Full Content:</label>
          <textarea id="articleContent" placeholder="Write the full news content here..." required></textarea>
        </div>
        <div>
          <label for="articleAuthor">Author:</label>
          <input type="text" id="articleAuthor" placeholder="e.g., Homeowners Association" required>
        </div>
        <div>
          <label for="articleDate">Date (YYYY-MM-DD):</label>
          <input type="date" id="articleDate" required>
        </div>
        <div>
          <label for="articleCategory">Category:</label>
          <select id="articleCategory" required>
            <option value="">Select a category</option>
            <option value="Community">Community</option>
            <option value="Security">Security</option>
            <option value="Events">Events</option>
            <option value="Maintenance">Maintenance</option>
            <option value="Announcements">Announcements</option>
          </select>
        </div>
        <div>
          <label for="articleReadTime">Read Time (e.g., 3 min read):</label>
          <input type="text" id="articleReadTime" placeholder="e.g., 3 min read" required>
        </div>
        <div>
          <label for="articleImage">Image URL:</label>
          <input type="url" id="articleImage" placeholder="https://example.com/image.jpg">
        </div>

        <div class="modal-buttons">
          <button type="button" class="post-btn" onclick="postNewsArticle()">Post Article</button>
          <button type="button" class="clear-btn" onclick="clearAddForm()">Clear Form</button>
        </div>
      </form>
    </div>
  </div>

  <img src="chat.png" alt="Your Logo" class="logo">

  <script>
    // News Articles Data (This array holds all the news content)
    // IMPORTANT: In a real application, this data would be loaded from a backend database.
    // Changes made here are only temporary and will reset on page refresh.
    let newsArticles = [ // Changed to `let` so we can modify it
      {
        id: 1,
        title: "New Community Park and Playground Opens in Courtyard of Maia Alta",
        summary: "Residents can now enjoy enhanced recreational facilities including a modern playground, walking trails, and landscaped green spaces designed for family enjoyment.",
        content: `The Courtyard of Maia Alta community celebrates the grand opening of its newest amenity - a beautifully designed community park and playground complex that promises to become the heart of neighborhood recreation and social gatherings.

Project Overview:
The new 2-acre park features state-of-the-art playground equipment suitable for children ages 2-12, complete with safety surfacing and shade structures. The playground includes climbing structures, swings, slides, and interactive play elements designed to encourage physical activity and social interaction among young residents.

Key Features:
• Modern playground equipment with safety certification
• Paved walking trails connecting to existing subdivision pathways
• Landscaped picnic areas with tables and benches
• Native plant gardens requiring minimal water maintenance
• LED lighting for evening safety and extended use hours
• Covered pavilion available for community events and gatherings

The walking trail system integrates seamlessly with the subdivision's existing pedestrian network, creating a comprehensive path system that encourages residents to walk, jog, or bike throughout the community safely.

Community Impact:
"This park represents our commitment to creating spaces where neighbors can connect and families can thrive," said Maria Santos, Homeowners Association President. "We've seen increased community engagement already, with families gathering here daily and children making new friendships."

The project was funded through a combination of HOA reserves and a special assessment approved by 85% of homeowners last year. Construction began in January and was completed ahead of schedule with minimal disruption to daily life in the subdivision.

Maintenance and Safety:
The park features drought-resistant landscaping aligned with local water conservation efforts. Regular maintenance schedules ensure playground equipment remains in excellent condition, while security lighting and clear sightlines promote safe usage at all hours.

Future enhancements may include additional seating areas and seasonal flower displays based on resident feedback and community input sessions scheduled for later this year.`,
        author: "Homeowners Association Board",
        date: "March 18, 2024",
        category: "Community",
        readTime: "3 min read",
        image: "https://images.unsplash.com/photo-1544944150-4afde9d19eb4?w=800&h=400&fit=crop"
      },
      {
        id: 2,
        title: "Enhanced Security System and Improved Street Lighting Installed",
        summary: "Courtyard of Maia Alta upgrades its security infrastructure with new surveillance cameras, improved street lighting, and enhanced entry gate systems for resident safety.",
        content: `The Courtyard of Maia Alta subdivision has completed a comprehensive security enhancement project, significantly upgrading safety measures throughout the community to provide residents with improved peace of mind and property protection.

Security System Upgrades:
The new security infrastructure includes 24 strategically placed high-definition surveillance cameras covering all entry points, common areas, and main thoroughfares within the subdivision. The cameras feature night vision capabilities and motion detection, with footage stored securely for 30 days.

Enhanced Features:
• HD surveillance cameras with 24/7 monitoring capabilities
• Upgraded LED street lighting throughout all residential streets
• New automated entry gate system with resident access cards
• Improved perimeter fencing and landscaping for natural security barriers
• Emergency call boxes at key locations throughout the community
• Mobile app integration allowing residents to receive security alerts

The LED street lighting upgrade provides 40% brighter illumination while reducing energy consumption by 60% compared to the previous lighting system. This improvement enhances visibility for evening walks, jogging, and general navigation throughout the subdivision.

Access Control Improvements:
The new entry gate system features dual-lane access with backup power systems ensuring continuous operation during power outages. Residents receive programmable access cards that can be quickly deactivated if lost or stolen, eliminating security concerns associated with traditional remote controls.

Technology Integration:
A new mobile application allows residents to receive real-time security notifications, report concerns directly to the management company, and access community announcements. The system also enables residents to grant temporary access to guests and service providers remotely.

Cost and Implementation:
The $280,000 security enhancement project was funded through special assessment contributions approved by homeowners. Installation was completed with minimal disruption to daily activities, with most work conducted during off-peak hours.

Resident Response:
"The improvements have made a noticeable difference in how secure we feel in our community," commented longtime resident David Chen. "The better lighting alone has made evening walks much more comfortable for my family."

The upgraded systems are monitored by professional security services with direct connections to local law enforcement when needed. Regular system maintenance ensures optimal performance and reliability year-round.`,
        author: "Community Management Team",
        date: "March 15, 2024",
        category: "Security",
        readTime: "4 min read",
        image: "https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=400&fit=crop"
      }
      // Add more news articles here if needed
    ];

    // --- General Modal Functions ---
    /**
     * Opens a modal by adding the 'open' class and preventing background scrolling.
     * @param {string} modalId The ID of the modal element to open.
     */
    function openModal(modalId) {
      document.getElementById(modalId).classList.add('open');
      document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    /**
     * Closes a modal by removing the 'open' class and restoring background scrolling.
     * @param {string} modalId The ID of the modal element to close.
     */
    function closeModal(modalId) {
      document.getElementById(modalId).classList.remove('open');
      document.body.style.overflow = 'auto'; // Restore scrolling
    }

    // Event listeners for closing modals (on close button click and outside click)
    document.querySelectorAll('.modal-close-button').forEach(button => {
      button.addEventListener('click', () => {
        const modalId = button.getAttribute('data-modal-id');
        closeModal(modalId);
      });
    });

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
          closeModal(overlay.id);
        }
      });
    });

    // --- News Article Display Functions ---
    /**
     * Populates the news grid with articles from the newsArticles array.
     * Sorts articles by ID in descending order to show the latest first.
     */
    function populateNews() {
      const newsContainer = document.getElementById('newsContainer');
      newsContainer.innerHTML = ''; // Clear existing news before populating

      // Sort news articles by ID in descending order to show latest first
      const sortedNews = [...newsArticles].sort((a, b) => b.id - a.id);

      sortedNews.forEach(article => {
        const newsCard = document.createElement('div');
        newsCard.className = 'news-card';

        newsCard.innerHTML = `
          <button class="delete-btn" onclick="event.stopPropagation(); deleteNewsArticle(${article.id})">
            <i class="fas fa-trash-alt"></i>
          </button>
          <img src="${article.image}" alt="${article.title}" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=400&fit=crop'">
          <div class="news-card-content">
            <div class="news-meta">
              <span class="news-category">${article.category}</span>
              <span><i class="fas fa-clock"></i> ${article.readTime}</span>
            </div>
            <h3>${article.title}</h3>
            <p>${article.summary}</p>
            <button class="read-more-btn" onclick="openNewsModal(${article.id})">Read More <i class="fas fa-arrow-right ml-2"></i></button>
          </div>
        `;
        newsContainer.appendChild(newsCard);
      });
    }

    /**
     * Opens the news article modal and populates it with the given article data.
     * @param {number} articleId The ID of the news article to display.
     */
    function openNewsModal(articleId) {
      const article = newsArticles.find(a => a.id === articleId);
      if (!article) {
        console.error('Article not found:', articleId);
        return;
      }

      const modalArticleContent = document.getElementById('modalArticleContent');
      modalArticleContent.innerHTML = `
        <h1>${article.title}</h1>
        <div class="article-meta">
          <span><i class="fas fa-user"></i> ${article.author}</span>
          <span><i class="fas fa-calendar-alt"></i> ${article.date}</span>
          <span><i class="fas fa-tag"></i> ${article.category}</span>
          <span><i class="fas fa-clock"></i> ${article.readTime}</span>
        </div>
        <img src="${article.image}" alt="${article.title}" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=400&fit=crop'">
        <div class="article-content">${article.content}</div>
      `;
      openModal('newsArticleModal');
    }

    /**
     * Deletes a news article from the array and refreshes the display.
     * @param {number} id The ID of the article to delete.
     */
    function deleteNewsArticle(id) {
      if (confirm('Are you sure you want to delete this news article? This action cannot be undone.')) {
        newsArticles = newsArticles.filter(article => article.id !== id);
        populateNews(); // Re-render the articles
        alert('News article deleted successfully!');
      }
    }


    // --- Add News Article Form Functions ---
    /**
     * Opens the "Add News Article" form modal.
     */
    function openAddNewsModal() {
      clearAddForm(); // Clear the form every time it opens
      openModal('addNewsArticleFormModal');
    }

    /**
     * Clears all input fields in the "Add News Article" form.
     */
    function clearAddForm() {
      document.getElementById('newsArticleForm').reset(); // Resets all form fields
      // For input type="date", .value = '' is safer than reset for consistency
      document.getElementById('articleDate').value = '';
    }

    /**
     * Handles the "Post Article" action:
     * Gathers data from the form, creates a new article object,
     * adds it to the newsArticles array, and refreshes the display.
     */
    function postNewsArticle() {
      const title = document.getElementById('articleTitle').value;
      const summary = document.getElementById('articleSummary').value;
      const content = document.getElementById('articleContent').value;
      const author = document.getElementById('articleAuthor').value;
      const date = document.getElementById('articleDate').value;
      const category = document.getElementById('articleCategory').value;
      const readTime = document.getElementById('articleReadTime').value;
      const image = document.getElementById('articleImage').value;

      // Basic validation
      if (!title || !summary || !content || !author || !date || !category || !readTime) {
        alert('Please fill in all required fields.');
        return;
      }

      // Generate a new unique ID (simple increment for demonstration)
      // This ensures new IDs are higher than existing ones
      const newId = newsArticles.length > 0 ? Math.max(...newsArticles.map(a => a.id)) + 1 : 1;

      const newArticle = {
        id: newId,
        title,
        summary,
        content,
        author,
        date,
        category,
        readTime,
        image: image || 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=400&fit=crop' // Default image if none provided
      };

      newsArticles.push(newArticle); // Add new article to the array
      populateNews(); // Re-populate the news section to show the new article
      closeModal('addNewsArticleFormModal'); // Close the form modal
      alert('News article posted successfully!');
    }

    // --- Event Listeners ---
    // Call populateNews when the page loads to display the articles
    document.addEventListener('DOMContentLoaded', populateNews);

    // Event listener for the "Add New News Article" button
    document.getElementById('addNewsArticleButton').addEventListener('click', openAddNewsModal);

    // Add some interaction feedback for the "Add New News Article" button
    document.getElementById('addNewsArticleButton').addEventListener('mouseenter', function() {
      this.innerHTML = '<i class="fas fa-plus"></i> Create News Article';
    });

    document.getElementById('addNewsArticleButton').addEventListener('mouseleave', function() {
      this.innerHTML = '<i class="fas fa-plus"></i> Add New News Article';
    });

    // --- Global Keyboard Shortcuts ---
    document.addEventListener('keydown', function(e) {
      // ESC to close any open modal
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.open').forEach(modal => {
          closeModal(modal.id);
        });
      }
    });
  </script>
</body>
</html>