// Mock data for clients
const mockClients = [
  {
    id: 1,
    name: "John Smith",
    email: "john.smith@example.com",
    phone: "(555) 123-4567",
    address: "123 Main St, Anytown, CA 12345",
    status: "active",
    totalJobs: 12,
    totalSpent: 2450,
    lastService: "2025-01-10",
    avatar: "https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg"
  },
  {
    id: 2,
    name: "Emma Davis",
    email: "emma.davis@example.com",
    phone: "(555) 987-6543",
    address: "456 Oak Ave, Anytown, CA 12345",
    status: "active",
    totalJobs: 5,
    totalSpent: 1740,
    lastService: "2025-01-05",
    avatar: "https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg"
  },
  {
    id: 3,
    name: "Michael Brown",
    email: "michael.brown@example.com",
    phone: "(555) 456-7890",
    address: "789 Pine Rd, Anytown, CA 12345",
    status: "new",
    totalJobs: 1,
    totalSpent: 350,
    lastService: "2025-01-12",
    avatar: "https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg"
  },
  {
    id: 4,
    name: "Sarah Wilson",
    email: "sarah.wilson@example.com",
    phone: "(555) 789-0123",
    address: "321 Elm St, Anytown, CA 12345",
    status: "active",
    totalJobs: 7,
    totalSpent: 1890,
    lastService: "2024-12-28",
    avatar: "https://images.pexels.com/photos/712513/pexels-photo-712513.jpeg"
  },
  {
    id: 5,
    name: "David Thompson",
    email: "david.thompson@example.com",
    phone: "(555) 234-5678",
    address: "654 Maple Dr, Anytown, CA 12345",
    status: "inactive",
    totalJobs: 3,
    totalSpent: 870,
    lastService: "2024-11-15",
    avatar: "https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg"
  },
  {
    id: 6,
    name: "Jennifer Garcia",
    email: "jennifer.garcia@example.com",
    phone: "(555) 345-6789",
    address: "987 Cedar Ln, Anytown, CA 12345",
    status: "active",
    totalJobs: 9,
    totalSpent: 2150,
    lastService: "2025-01-08",
    avatar: "https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg"
  }
];

// Function to initialize the clients page
export function initClients(contentEl) {
  const clientsHTML = `
    <div class="clients-header">
      <h1>Clients</h1>
      <button class="primary-btn"><i class="fas fa-plus"></i> Add New Client</button>
    </div>
    
    <div class="client-filters">
      <div class="filter-item active">All</div>
      <div class="filter-item">Active</div>
      <div class="filter-item">New</div>
      <div class="filter-item">Inactive</div>
    </div>
    
    <div class="clients-grid">
      ${mockClients.map(client => `
        <div class="client-card" data-client-id="${client.id}">
          <div class="client-card-header">
            <h3>${client.name}</h3>
            <div class="client-status">${client.status}</div>
          </div>
          <div class="client-card-body">
            <div class="client-info">
              <div class="info-item">
                <i class="fas fa-envelope"></i>
                <span>${client.email}</span>
              </div>
              <div class="info-item">
                <i class="fas fa-phone"></i>
                <span>${client.phone}</span>
              </div>
              <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>${client.address}</span>
              </div>
            </div>
            
            <div class="client-stats">
              <div class="client-stat">
                <div class="stat-label">Total Jobs</div>
                <div class="stat-value">${client.totalJobs}</div>
              </div>
              <div class="client-stat">
                <div class="stat-label">Total Spent</div>
                <div class="stat-value">$${client.totalSpent}</div>
              </div>
            </div>
            
            <div class="client-actions">
              <button class="client-action-btn"><i class="fas fa-phone"></i></button>
              <button class="client-action-btn"><i class="fas fa-envelope"></i></button>
              <button class="client-action-btn view-client-btn"><i class="fas fa-user"></i></button>
              <button class="client-action-btn"><i class="fas fa-ellipsis-v"></i></button>
            </div>
          </div>
        </div>
      `).join('')}
    </div>
  `;
  
  contentEl.innerHTML = clientsHTML;
  
  // Add event listeners
  addClientEventListeners();
}

// Add event listeners for client interactions
function addClientEventListeners() {
  // Client card click to view client details
  const viewClientButtons = document.querySelectorAll('.view-client-btn');
  viewClientButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const clientCard = btn.closest('.client-card');
      const clientId = clientCard.dataset.clientId;
      loadClientDetail(clientId);
    });
  });
  
  // Filter clicks
  const filterItems = document.querySelectorAll('.filter-item');
  filterItems.forEach(item => {
    item.addEventListener('click', () => {
      filterItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      
      // In a real app, this would filter the client list
      const filter = item.textContent.toLowerCase();
      console.log(`Filtering clients by: ${filter}`);
    });
  });
}

// Load client detail view
function loadClientDetail(clientId) {
  // Find the client data
  const client = mockClients.find(c => c.id == clientId);
  
  if (!client) {
    console.error(`Client with ID ${clientId} not found`);
    return;
  }
  
  const contentEl = document.getElementById('content');
  
  const clientDetailHTML = `
    <div class="page-header">
      <button class="secondary-btn back-to-clients"><i class="fas fa-arrow-left"></i> Back to Clients</button>
    </div>
    
    <div class="client-detail-view">
      <div class="client-profile">
        <div class="client-profile-header">
          <img src="${client.avatar}" alt="${client.name}" class="client-avatar">
          <h2>${client.name}</h2>
          <div class="client-status">${client.status}</div>
        </div>
        
        <div class="client-info">
          <div class="info-item">
            <i class="fas fa-envelope"></i>
            <span>${client.email}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-phone"></i>
            <span>${client.phone}</span>
          </div>
          <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <span>${client.address}</span>
          </div>
        </div>
        
        <div class="client-stats">
          <div class="client-stat">
            <div class="stat-label">Total Jobs</div>
            <div class="stat-value">${client.totalJobs}</div>
          </div>
          <div class="client-stat">
            <div class="stat-label">Total Spent</div>
            <div class="stat-value">$${client.totalSpent}</div>
          </div>
        </div>
        
        <div class="client-actions" style="margin-top: 20px;">
          <button class="primary-btn"><i class="fas fa-plus"></i> New Job</button>
          <button class="secondary-btn"><i class="fas fa-file-invoice-dollar"></i> New Invoice</button>
        </div>
      </div>
      
      <div class="client-history">
        <div class="history-nav">
          <div class="history-nav-item active">Jobs</div>
          <div class="history-nav-item">Invoices</div>
          <div class="history-nav-item">Notes</div>
          <div class="history-nav-item">Files</div>
        </div>
        
        <div class="history-content">
          <div class="job-list">
            <div class="job-item">
              <div class="job-info">
                <div class="job-client">Plumbing Repair</div>
                <div class="job-details">Completed on Jan 10, 2025</div>
              </div>
              <div class="status-tag status-completed">Completed</div>
              <div class="job-actions">
                <button class="job-action-btn"><i class="fas fa-eye"></i></button>
              </div>
            </div>
            
            <div class="job-item">
              <div class="job-info">
                <div class="job-client">Water Heater Installation</div>
                <div class="job-details">Completed on Dec 15, 2024</div>
              </div>
              <div class="status-tag status-completed">Completed</div>
              <div class="job-actions">
                <button class="job-action-btn"><i class="fas fa-eye"></i></button>
              </div>
            </div>
            
            <div class="job-item">
              <div class="job-info">
                <div class="job-client">Drain Cleaning</div>
                <div class="job-details">Completed on Nov 22, 2024</div>
              </div>
              <div class="status-tag status-completed">Completed</div>
              <div class="job-actions">
                <button class="job-action-btn"><i class="fas fa-eye"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  contentEl.innerHTML = clientDetailHTML;
  
  // Add event listener to go back to clients list
  document.querySelector('.back-to-clients').addEventListener('click', () => {
    initClients(contentEl);
  });
  
  // Add event listeners for history navigation
  const historyNavItems = document.querySelectorAll('.history-nav-item');
  historyNavItems.forEach(item => {
    item.addEventListener('click', () => {
      historyNavItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      
      // In a real app, this would switch between different history views
      console.log(`Switching to ${item.textContent} view`);
    });
  });
}