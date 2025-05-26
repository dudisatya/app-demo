// Mock data for jobs
const mockJobs = [
  {
    id: 1,
    client: "John Smith",
    type: "repair",
    address: "123 Main St, Anytown, CA 12345",
    date: "2025-01-15",
    time: "09:30",
    duration: 2,
    description: "Fix leaking bathroom faucet and replace worn-out washers.",
    price: 250.00,
    status: "scheduled"
  },
  {
    id: 2,
    client: "Emma Davis",
    type: "installation",
    address: "456 Oak Ave, Anytown, CA 12345",
    date: "2025-01-15",
    time: "13:00",
    duration: 3,
    description: "Install new water heater in basement.",
    price: 1200.00,
    status: "scheduled"
  },
  {
    id: 3,
    client: "Michael Brown",
    type: "inspection",
    address: "789 Pine Rd, Anytown, CA 12345",
    date: "2025-01-16",
    time: "10:00",
    duration: 1.5,
    description: "Annual plumbing inspection and maintenance check.",
    price: 150.00,
    status: "scheduled"
  },
  {
    id: 4,
    client: "Sarah Wilson",
    type: "maintenance",
    address: "321 Elm St, Anytown, CA 12345",
    date: "2025-01-17",
    time: "14:00",
    duration: 2,
    description: "Regular maintenance of water filtration system.",
    price: 180.00,
    status: "scheduled"
  },
  {
    id: 5,
    client: "David Thompson",
    type: "repair",
    address: "654 Maple Dr, Anytown, CA 12345",
    date: "2025-01-18",
    time: "11:00",
    duration: 4,
    description: "Diagnose and repair pipe leak in kitchen wall.",
    price: 450.00,
    status: "scheduled"
  },
  {
    id: 6,
    client: "Jennifer Garcia",
    type: "installation",
    address: "987 Cedar Ln, Anytown, CA 12345",
    date: "2025-01-20",
    time: "09:00",
    duration: 5,
    description: "Install new bathroom fixtures including shower, toilet and sink.",
    price: 1800.00,
    status: "scheduled"
  }
];

// Function to initialize the jobs page
export function initJobs(contentEl) {
  const jobsHTML = `
    <div class="jobs-header">
      <h1>Jobs</h1>
      <button class="primary-btn" id="jobs-new-job-btn"><i class="fas fa-plus"></i> New Job</button>
    </div>
    
    <div class="jobs-filters">
      <div class="filter-item active">All</div>
      <div class="filter-item">Today</div>
      <div class="filter-item">Upcoming</div>
      <div class="filter-item">Completed</div>
      <div class="filter-item">Cancelled</div>
    </div>
    
    <div class="jobs-grid">
      ${mockJobs.map(job => `
        <div class="job-card" data-job-id="${job.id}">
          <div class="job-card-header">
            <div class="job-type job-type-${job.type}">
              <div class="job-type-indicator"></div>
              <span>${capitalizeFirstLetter(job.type)}</span>
            </div>
            <div class="status-tag status-${job.status}">${capitalizeFirstLetter(job.status)}</div>
          </div>
          
          <div class="job-card-body">
            <div class="job-client">
              <img src="${getClientAvatar(job.client)}" alt="${job.client}" class="client-avatar">
              <span>${job.client}</span>
            </div>
            
            <div class="job-address">
              <i class="fas fa-map-marker-alt"></i>
              <span>${job.address}</span>
            </div>
            
            <div class="job-time">
              <i class="fas fa-clock"></i>
              <span>${formatDate(job.date)} at ${formatTime(job.time)} (${job.duration} hrs)</span>
            </div>
            
            <div class="job-description">
              ${job.description}
            </div>
          </div>
          
          <div class="job-card-footer">
            <div class="job-price">$${job.price.toFixed(2)}</div>
            <div class="job-actions">
              <button class="job-action-btn"><i class="fas fa-phone"></i></button>
              <button class="job-action-btn"><i class="fas fa-directions"></i></button>
              <button class="job-action-btn view-job-btn"><i class="fas fa-eye"></i></button>
            </div>
          </div>
        </div>
      `).join('')}
    </div>
  `;
  
  contentEl.innerHTML = jobsHTML;
  
  // Add event listeners
  addJobsEventListeners(contentEl);
}

// Helper function to get client avatar URL
function getClientAvatar(clientName) {
  // In a real app, this would come from the client database
  switch(clientName) {
    case "John Smith": return "https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg";
    case "Emma Davis": return "https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg";
    case "Michael Brown": return "https://images.pexels.com/photos/614810/pexels-photo-614810.jpeg";
    case "Sarah Wilson": return "https://images.pexels.com/photos/712513/pexels-photo-712513.jpeg";
    case "David Thompson": return "https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg";
    case "Jennifer Garcia": return "https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg";
    default: return "https://images.pexels.com/photos/1516680/pexels-photo-1516680.jpeg";
  }
}

// Helper function to format time
function formatTime(timeStr) {
  // Convert 24-hour time to 12-hour format with AM/PM
  const [hours, minutes] = timeStr.split(':');
  const hour = parseInt(hours);
  const ampm = hour >= 12 ? 'PM' : 'AM';
  const hour12 = hour % 12 || 12;
  return `${hour12}:${minutes} ${ampm}`;
}

// Helper function to format date
function formatDate(dateStr) {
  const date = new Date(dateStr);
  // Return month/day (e.g., Jan 15)
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
}

// Helper function to capitalize first letter
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// Add event listeners for job interactions
function addJobsEventListeners(contentEl) {
  // Filter clicks
  const filterItems = document.querySelectorAll('.filter-item');
  filterItems.forEach(item => {
    item.addEventListener('click', () => {
      filterItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      
      // In a real app, this would filter the jobs
      const filter = item.textContent.toLowerCase();
      console.log(`Filtering jobs by: ${filter}`);
    });
  });
  
  // New job button
  const newJobBtn = document.getElementById('jobs-new-job-btn');
  if (newJobBtn) {
    newJobBtn.addEventListener('click', () => {
      // In a real app, this would open the new job modal
      const newJobModal = document.getElementById('new-job-modal');
      newJobModal.classList.add('active');
    });
  }
  
  // Job card click to view job details
  const viewJobBtns = document.querySelectorAll('.view-job-btn');
  viewJobBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      const jobCard = btn.closest('.job-card');
      const jobId = jobCard.dataset.jobId;
      loadJobDetail(jobId, contentEl);
    });
  });
}

// Load job detail
function loadJobDetail(jobId, contentEl) {
  // Find the job
  const job = mockJobs.find(j => j.id == jobId);
  
  if (!job) {
    console.error(`Job with ID ${jobId} not found`);
    return;
  }
  
  const jobDetailHTML = `
    <div class="page-header">
      <button class="secondary-btn back-to-jobs"><i class="fas fa-arrow-left"></i> Back to Jobs</button>
    </div>
    
    <div class="job-detail">
      <div class="job-main-info">
        <div class="job-header">
          <h2>
            <div class="job-type-indicator job-type-${job.type}"></div>
            ${capitalizeFirstLetter(job.type)} Job #${job.id}
          </h2>
          <div class="status-tag status-${job.status}">${capitalizeFirstLetter(job.status)}</div>
          
          <div class="job-meta">
            <div class="job-meta-item">
              <i class="fas fa-calendar"></i>
              <span>${formatDate(job.date)}</span>
            </div>
            <div class="job-meta-item">
              <i class="fas fa-clock"></i>
              <span>${formatTime(job.time)} (${job.duration} hrs)</span>
            </div>
            <div class="job-meta-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>${job.address}</span>
            </div>
            <div class="job-meta-item">
              <i class="fas fa-dollar-sign"></i>
              <span>$${job.price.toFixed(2)}</span>
            </div>
          </div>
        </div>
        
        <div class="job-section">
          <h3>Description</h3>
          <p>${job.description}</p>
        </div>
        
        <div class="job-section">
          <h3>Job Photos</h3>
          <div class="job-photos">
            <div class="job-photo">
              <img src="https://images.pexels.com/photos/1181354/pexels-photo-1181354.jpeg" alt="Job photo">
            </div>
            <div class="job-photo">
              <img src="https://images.pexels.com/photos/1181354/pexels-photo-1181354.jpeg" alt="Job photo">
            </div>
            <div class="job-photo">
              <img src="https://images.pexels.com/photos/1181354/pexels-photo-1181354.jpeg" alt="Job photo">
            </div>
            <div class="job-photo add-photo">
              <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-plus" style="font-size: 2rem; color: var(--neutral-400);"></i>
              </div>
            </div>
          </div>
        </div>
        
        <div class="job-section">
          <h3>Notes</h3>
          <div class="job-notes">
            <p>Customer mentioned the faucet has been leaking for about a week. Bring extra washers and check water pressure.</p>
          </div>
        </div>
        
        <div class="job-actions" style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 20px;">
          <button class="secondary-btn"><i class="fas fa-edit"></i> Edit</button>
          <button class="secondary-btn"><i class="fas fa-comment"></i> Message</button>
          <button class="secondary-btn"><i class="fas fa-clock"></i> Reschedule</button>
          <button class="primary-btn"><i class="fas fa-check"></i> Mark Complete</button>
        </div>
      </div>
      
      <div class="job-sidebar">
        <div class="client-card">
          <div class="sidebar-section-header">
            <h3>Client Information</h3>
            <button class="job-action-btn"><i class="fas fa-external-link-alt"></i></button>
          </div>
          
          <div class="client-info">
            <div class="job-client" style="margin-bottom: 10px;">
              <img src="${getClientAvatar(job.client)}" alt="${job.client}" class="client-avatar">
              <span>${job.client}</span>
            </div>
            
            <div class="info-item">
              <i class="fas fa-envelope"></i>
              <span>${job.client.toLowerCase().replace(' ', '.')}@example.com</span>
            </div>
            <div class="info-item">
              <i class="fas fa-phone"></i>
              <span>(555) 123-4567</span>
            </div>
          </div>
        </div>
        
        <div class="invoice-card">
          <div class="sidebar-section-header">
            <h3>Invoice Status</h3>
            <button class="job-action-btn"><i class="fas fa-external-link-alt"></i></button>
          </div>
          
          <div style="text-align: center; padding: 20px 0;">
            <p>No invoice has been created yet</p>
            <button class="primary-btn" style="margin-top: 10px;"><i class="fas fa-file-invoice-dollar"></i> Create Invoice</button>
          </div>
        </div>
        
        <div class="activity-card">
          <div class="sidebar-section-header">
            <h3>Activity</h3>
          </div>
          
          <div class="activity-list">
            <div class="activity-item">
              <div class="activity-icon">
                <i class="fas fa-calendar-plus"></i>
              </div>
              <div class="activity-details">
                <div class="activity-title">Job Created</div>
                <div class="activity-description">Created by Sarah Johnson</div>
                <div class="activity-time">Jan 10, 2025 at 2:30 PM</div>
              </div>
            </div>
            
            <div class="activity-item">
              <div class="activity-icon">
                <i class="fas fa-edit"></i>
              </div>
              <div class="activity-details">
                <div class="activity-title">Job Updated</div>
                <div class="activity-description">Changed time from 9:00 AM to 9:30 AM</div>
                <div class="activity-time">Jan 12, 2025 at 10:15 AM</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
  
  contentEl.innerHTML = jobDetailHTML;
  
  // Add event listener to go back to jobs list
  document.querySelector('.back-to-jobs').addEventListener('click', () => {
    initJobs(contentEl);
  });
}