<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>News Portal - Latest Updates</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
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
    }k

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
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 3rem 0;
      text-align: center;
      margin-bottom: 3rem;
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
    // Sample news data
    const newsArticles = [
      {
        id: 1,
        title: "Revolutionary AI Technology Transforms Healthcare Industry",
        summary: "New artificial intelligence breakthrough promises to revolutionize patient diagnosis and treatment planning across hospitals worldwide, improving accuracy by 40%.",
        content: `A groundbreaking artificial intelligence system has been successfully deployed in over 200 hospitals worldwide, showing remarkable improvements in diagnostic accuracy and treatment planning. The AI system, developed by researchers at leading medical institutions, uses advanced machine learning algorithms to analyze patient data and medical imaging with unprecedented precision.

The technology has shown a 40% improvement in early disease detection rates and has reduced diagnostic errors by 60%. Dr. Sarah Chen, lead researcher on the project, stated that this represents "the most significant advancement in medical diagnosis since the invention of the MRI."

Key benefits include:
• Faster diagnosis times, reducing patient wait times from hours to minutes
• More accurate identification of rare diseases that often go undetected
• Personalized treatment recommendations based on comprehensive patient history analysis
• Real-time monitoring of treatment effectiveness and patient response

The system has been particularly effective in oncology, cardiology, and neurology departments. Initial trials showed that the AI could detect certain cancers up to 18 months earlier than traditional methods, significantly improving patient survival rates.

Hospitals implementing the technology report not only improved patient outcomes but also reduced healthcare costs due to more efficient resource allocation. The next phase will focus on expanding the system to rural and underserved communities to ensure equitable access to advanced medical care.

The development team is now working on integrating the system with wearable health devices to provide continuous health monitoring and early warning systems for patients at risk.`,
        author: "Dr. Michael Rodriguez",
        date: "March 15, 2024",
        category: "Technology",
        readTime: "5 min read",
        image: "https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&h=400&fit=crop"
      },
      {
        id: 2,
        title: "Global Climate Summit Reaches Historic Agreement",
        summary: "World leaders unite on unprecedented climate action plan with binding commitments for carbon neutrality by 2040, establishing a $2 trillion global climate fund.",
        content: `In a historic moment for environmental policy, 195 countries have signed the most comprehensive climate agreement in history at the Global Climate Summit in Geneva. The agreement, dubbed the "Geneva Accord," establishes legally binding commitments for achieving carbon neutrality by 2040, ten years ahead of previous targets.

The accord represents a significant shift from voluntary commitments to mandatory action. Key provisions include:

Financial Commitments:
• $2 trillion global climate fund for developing nations over the next decade
• Mandatory carbon pricing across all signatory countries by 2026
• Complete phase-out of fossil fuel subsidies by 2030
• Green bonds program to finance renewable energy infrastructure

Technology Transfer:
• Open-source sharing of clean energy technologies between developed and developing nations
• Joint research initiatives for breakthrough climate solutions
• Support for green infrastructure development in emerging economies
• Technology transfer agreements for solar, wind, and battery storage systems

Implementation Timeline:
• 50% reduction in greenhouse gas emissions by 2030
• Complete phase-out of coal power generation by 2035
• 100% renewable energy targets for all participating countries by 2040
• Reforestation of 500 million hectares of degraded land by 2035

The agreement also establishes an international climate enforcement body with the authority to impose economic sanctions on countries that fail to meet their commitments. This marks the first time climate action has been backed by enforceable consequences on a global scale.

Environmental groups have praised the agreement as a "turning point in human history," while business leaders see it as an opportunity for massive investment in clean technology sectors.`,
        author: "Sarah Johnson",
        date: "March 12, 2024",
        category: "Environment",
        readTime: "6 min read",
        image: "https://images.unsplash.com/photo-1569163139394-de4e4f43e4e3?w=800&h=400&fit=crop"
      },
      {
        id: 3,
        title: "Breakthrough in Quantum Computing Achieved",
        summary: "Scientists successfully demonstrate quantum computer capable of solving complex problems 1000 times faster than traditional supercomputers.",
        content: `Researchers at the International Quantum Research Institute have achieved a major breakthrough in quantum computing, successfully demonstrating a quantum computer capable of solving certain complex problems up to 1000 times faster than the world's most powerful traditional supercomputers.

The quantum computer, named "QuantumPrime," uses a revolutionary approach to quantum error correction that has long been considered the holy grail of quantum computing. This advancement addresses one of the biggest challenges in the field: maintaining quantum states long enough to perform meaningful calculations.

Technical Achievements:
• 1024-qubit quantum processor with 99.9% fidelity
• Quantum error correction reducing error rates by 95%
• Operating temperature increased to -200°C (much warmer than previous systems)
• Stable quantum states maintained for up to 30 minutes

Real-World Applications:
The breakthrough opens doors to solving previously impossible problems in drug discovery, climate modeling, financial optimization, and cryptography. Pharmaceutical companies are already expressing interest in using the technology to simulate molecular interactions for new drug development.

Dr. Elena Vasquez, lead quantum physicist on the project, explained: "This isn't just an incremental improvement – it's a fundamental leap forward that brings practical quantum computing within reach for solving real-world problems that affect millions of people."

The team expects commercial applications to emerge within the next 3-5 years, with the first quantum computers potentially being used for:
• Optimizing traffic flow in smart cities
• Accelerating the development of new materials for renewable energy
• Enhancing artificial intelligence capabilities
• Breaking new ground in weather prediction accuracy

Major tech companies have already announced partnerships to integrate this quantum technology into their cloud computing platforms.`,
        author: "Prof. James Liu",
        date: "March 10, 2024",
        category: "Science",
        readTime: "4 min read",
        image: "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=800&h=400&fit=crop"
      },
      {
        id: 4,
        title: "Space Tourism Takes Flight with Successful Commercial Mission",
        summary: "First fully commercial space tourism flight successfully completed with 6 civilian passengers, marking new era in accessible space travel.",
        content: `Space tourism reached a historic milestone this week with the successful completion of the first fully commercial space flight carrying six civilian passengers. The mission, operated by Stellar Horizons, marked a new chapter in making space travel accessible to private individuals.

The spacecraft "Horizon One" launched from the Mojave Desert spaceport and reached an altitude of 100 kilometers, providing passengers with several minutes of weightlessness and breathtaking views of Earth's curvature against the blackness of space.

Mission Details:
• Duration: 2 hours and 45 minutes total flight time
• Maximum altitude: 106 kilometers above Earth
• Weightlessness duration: 6 minutes
• All passengers: Civilians with no prior astronaut training
• Perfect safety record maintained

Passenger Experience:
The six passengers, ranging in age from 28 to 67, underwent three days of training before the flight. They included a retired teacher, a small business owner, an artist, a software engineer, a doctor, and a college student who won her seat through a scholarship program.

"Seeing Earth from space changes your perspective on everything," said Maria Santos, 34, a software engineer from California. "The thin blue line of our atmosphere looked so fragile and precious. It's an experience that will stay with me forever."

Industry Impact:
The successful mission is expected to accelerate the growth of the space tourism industry, which analysts predict could be worth $8 billion by 2030. Several other companies are now preparing to launch similar services, with some offering orbital flights that would last several days.

Safety measures included multiple backup systems, extensive ground testing, and real-time monitoring throughout the flight. The success rate for commercial space flights now stands at 100% over the past two years.

Future plans include launching a space hotel by 2027, which would allow tourists to stay in orbit for up to a week.`,
        author: "Captain Alex Thompson",
        date: "March 8, 2024",
        category: "Space",
        readTime: "5 min read",
        image: "https://images.unsplash.com/photo-1446776877081-d282a0f896e2?w=800&h=400&fit=crop"
      },
      {
        id: 5,
        title: "Revolutionary Ocean Cleanup Technology Removes 50 Tons of Plastic",
        summary: "New autonomous ocean cleaning system successfully removes 50 tons of plastic waste from Pacific Ocean in first month of operation.",
        content: `A revolutionary ocean cleanup system has exceeded all expectations in its first month of operation, successfully removing over 50 tons of plastic waste from the Great Pacific Garbage Patch. The autonomous system, called "Ocean Guardian," represents a major breakthrough in marine environmental protection.

The system uses advanced AI-powered robotics combined with biodegradable collection nets to identify, capture, and sort plastic waste without harming marine life. Solar panels and wave energy converters power the operation, making it completely self-sufficient.

Technology Features:
• AI-powered plastic detection with 99.7% accuracy
• Biodegradable collection materials that dissolve safely if lost
• Marine life protection sensors that halt operations when sea creatures are detected
• Autonomous navigation system covering 100 square kilometers daily
• Solar and wave energy power system for complete sustainability

Environmental Impact:
In just 30 days of operation, the system has:
• Removed 52.3 tons of plastic waste
• Sorted materials into 15 different recyclable categories
• Protected an estimated 10,000 marine animals from plastic ingestion
• Covered over 3,000 square kilometers of ocean surface

The collected plastic is transported to nearby ships and taken to shore for recycling into new products, including park benches, clothing, and construction materials.

Dr. Marina Oceanic, marine biologist and project leader, stated: "This technology proves that we can actively heal our oceans. The system not only removes existing pollution but also provides valuable data about ocean currents and marine ecosystems."

Expansion Plans:
Based on the initial success, five additional Ocean Guardian systems will be deployed across different ocean regions by the end of 2024. The goal is to remove 1 million tons of ocean plastic within the next decade.

Environmental groups worldwide have praised the initiative as a game-changer in the fight against ocean pollution.`,
        author: "Dr. Marina Oceanic",
        date: "March 5, 2024",
        category: "Environment",
        readTime: "4 min read",
        image: "https://images.unsplash.com/photo-1583212292454-1fe6229603b7?w=800&h=400&fit=crop"
      },
      {
        id: 6,
        title: "Smart Cities Initiative Reduces Urban Energy Consumption by 35%",
        summary: "Advanced IoT sensors and AI optimization systems help major cities cut energy usage dramatically while improving quality of life for residents.",
        content: `A groundbreaking smart cities initiative has achieved remarkable results across 12 major metropolitan areas, reducing urban energy consumption by an average of 35% while significantly improving quality of life for millions of residents.

The comprehensive system integrates Internet of Things (IoT) sensors, artificial intelligence, and machine learning algorithms to optimize everything from traffic flow to building energy usage in real-time.

System Components:
• 500,000 IoT sensors monitoring air quality, traffic, noise, and energy usage
• AI-powered traffic optimization reducing commute times by 25%
• Smart grid technology automatically adjusting power distribution
• Predictive maintenance systems preventing infrastructure failures
• Real-time data dashboards for city managers and residents

Energy Savings Breakdown:
• Street lighting: 45% reduction through adaptive LED systems
• Public transportation: 30% efficiency improvement
• Building HVAC systems: 40% energy savings through predictive climate control
• Water treatment facilities: 25% reduction in energy consumption
• Waste management: 35% optimization in collection routes

Quality of Life Improvements:
Residents report significant improvements in daily life:
• 20% reduction in average commute times
• 15% improvement in air quality measurements
• 30% faster emergency response times
• 25% reduction in noise pollution levels
• 40% increase in satisfaction with public services

The system's AI continuously learns from patterns in city data, making increasingly accurate predictions about energy needs, traffic patterns, and infrastructure maintenance requirements.

Mayor Jennifer Chang of Seattle, one of the participating cities, commented: "This technology has transformed how we manage our city. We're not just saving energy – we're creating a more livable, sustainable urban environment for everyone."

Economic Benefits:
The initiative has generated substantial cost savings:
• $2.3 billion in reduced energy costs across all participating cities
• $1.8 billion in infrastructure maintenance savings through predictive systems
• Creation of 15,000 new jobs in smart city technology sectors
• Attraction of $5.2 billion in new business investments

The success has prompted 50 additional cities worldwide to request implementation of similar systems.`,
        author: "Urban Planning Consortium",
        date: "March 3, 2024",
        category: "Technology",
        readTime: "6 min read",
        image: "https://images.unsplash.com/photo-1480714378408-67cf0d13bc1f?w=800&h=400&fit=crop"
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