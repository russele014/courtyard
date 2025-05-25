<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>News Portal - Latest Updates</title>
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
      background-color: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(8px);
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      visibility: hidden;
      transition: all 0.4s ease;
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
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
      padding: 2.5rem;
      max-width: 90vw;
      max-height: 90vh;
      overflow-y: auto;
      transform: scale(0.7) translateY(50px);
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      border: 1px solid rgba(255, 255, 255, 0.3);
      width: 800px;
    }

    .modal-overlay.open .modal-content {
      transform: scale(1) translateY(0);
    }

    /* Modal Close Button */
    .modal-close-button {
      position: absolute;
      top: 20px;
      right: 25px;
      background: rgba(239, 68, 68, 0.1);
      color: #ef4444;
      border: none;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      font-size: 24px;
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
      max-width: 1400px;
      margin: 0 auto;
    }

    /* News Grid */
    .news-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 2rem;
      margin-top: 2rem;
    }

    /* News Card */
    .news-card {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.4s ease;
      border: 1px solid rgba(0, 0, 0, 0.05);
      cursor: pointer;
      position: relative;
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

    /* Modal Article Content */
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

    /* Header Styling */
    .header {
      background: linear-gradient(135deg,rgb(205, 69, 24) 0%,rgb(141, 138, 49) 100%);
      color: white;
      padding: 3rem 0;
      text-align: center;
      margin-bottom: 3rem;
      margin-top: 60px;
    }

    .header h1 {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .header p {
      font-size: 1.2rem;
      opacity: 0.9;
    }

    /* Loading Animation */
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .loading {
      animation: pulse 2s infinite;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .news-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }
      
      .modal-content {
        margin: 1rem;
        padding: 2rem;
        width: calc(100vw - 2rem);
      }
      
      .header h1 {
        font-size: 2rem;
      }
      
      .header p {
        font-size: 1rem;
      }

      .modal-article h1 {
        font-size: 1.5rem;
      }

      .modal-article .article-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
      }
    }

    /* Smooth scrollbar */
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
  </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
  <!-- Header -->
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
  <div class="header">
    <h1><i class="fas fa-newspaper mr-3"></i>News Portal</h1>
    <p>Stay updated with the latest news and stories</p>
  </div>

  <div class="main-layout px-4">
    <!-- News Grid -->
    <div id="newsContainer" class="news-grid">
      <!-- News articles will be populated here -->
    </div>
  </div>

  <!-- News Article Modal -->
  <div id="newsModal" class="modal-overlay">
    <div class="modal-content relative">
      <button class="modal-close-button" onclick="closeModal()">&times;</button>
      <div id="modalArticleContent" class="modal-article">
        <!-- Article content will be populated here -->
      </div>
    </div>
  </div>

  <script>
    // Subdivision enhancement news data
    const newsArticles = [
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
    ];

    // Function to populate news cards
    function populateNews() {
      const container = document.getElementById('newsContainer');
      
      newsArticles.forEach(article => {
        const newsCard = document.createElement('div');
        newsCard.className = 'news-card';
        newsCard.onclick = () => openNewsModal(article);
        
        newsCard.innerHTML = `
          <img src="${article.image}" alt="${article.title}" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=400&fit=crop'">
          <div class="news-card-content">
            <div class="news-meta">
              <span class="news-category">${article.category}</span>
              <span><i class="fas fa-clock"></i> ${article.readTime}</span>
            </div>
            <h3>${article.title}</h3>
            <p>${article.summary}</p>
            <button class="read-more-btn">
              <i class="fas fa-book-open"></i>
              Read More
            </button>
          </div>
        `;
        
        container.appendChild(newsCard);
      });
    }

    // Function to open news modal with article details
    function openNewsModal(article) {
      const modalContent = document.getElementById('modalArticleContent');
      
      modalContent.innerHTML = `
        <h1>${article.title}</h1>
        <div class="article-meta">
          <span><i class="fas fa-user"></i> ${article.author}</span>
          <span><i class="fas fa-calendar"></i> ${article.date}</span>
          <span><i class="fas fa-tag"></i> ${article.category}</span>
          <span><i class="fas fa-clock"></i> ${article.readTime}</span>
        </div>
        <img src="${article.image}" alt="${article.title}" onerror="this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=800&h=400&fit=crop'">
        <div class="article-content">${article.content}</div>
      `;
      
      document.getElementById('newsModal').classList.add('open');
      document.body.style.overflow = 'hidden';
    }

    // Function to close modal
    function closeModal() {
      document.getElementById('newsModal').classList.remove('open');
      document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('newsModal').addEventListener('click', (e) => {
      if (e.target === document.getElementById('newsModal')) {
        closeModal();
      }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeModal();
      }
    });

    // Initialize the news viewer
    document.addEventListener('DOMContentLoaded', function() {
      populateNews();
    });

    // Add smooth scroll animation when page loads
    window.addEventListener('load', function() {
      document.querySelectorAll('.news-card').forEach((card, index) => {
        setTimeout(() => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(30px)';
          card.style.transition = 'all 0.6s ease';
          
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 100);
        }, index * 100);
      });
    });
  </script>
</body>
</html>