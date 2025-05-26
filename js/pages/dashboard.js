// Mock data for the dashboard
const mockData = {
  stats: {
    jobsToday: 4,
    pendingInvoices: 7,
    revenueMonth: 5840,
    newClients: 3
  },
  upcomingJobs: [
    {
      id: 1,
      client: "John Smith",
      type: "Plumbing Repair",
      address: "123 Main St, Anytown",
      date: "2025-01-15",
      time: "09:30",
      status: "scheduled"
    },
    {
      id: 2,
      client: "Emma Davis",
      type: "Water Heater Installation",
      address: "456 Oak Ave, Anytown",
      date: "2025-01-15",
      time: "13:00",
      status: "scheduled"
    },
    {
      id: 3,
      client: "Michael Brown",
      type: "Pipe Inspection",
      address: "789 Pine Rd, Anytown",
      date: "2025-01-16",
      time: "10:00",
      status: "scheduled"
    }
  ],
  recentActivity: [
    {
      id: 1,
      type: "invoice_paid",
      title: "Invoice Paid",
      description: "John Smith paid invoice #INV-2025-001 for $450.00",
      time: "1 hour ago"
    },
    {
      id: 2,
      type: "job_completed",
      title: "Job Completed",
      description: "Water heater installation for Emma Davis completed",
      time: "3 hours ago"
    },
    {
      id: 3,
      type: "new_client",
      title: "New Client Added",
      description: "Michael Brown was added as a new client",
      time: "5 hours ago"
    }
  ]
};

// Function to initialize the dashboard page
export function initDashboard(contentEl) {
  const dashboardHTML = `
    <div class="page-header">
      <h1>Dashboard</h1>
      <p>Welcome back! Here's what's happening today.</p>
    </div>
    
    <div class="dashboard-stats">
      <div class="stat-card">
        <h3>Today's Jobs</h3>
        <div class="value">${mockData.stats.jobsToday}</div>
        <div class="change positive">
          <i class="fas fa-arrow-up"></i> 20% from last week
        </div>
      </div>
      
      <div class="stat-card">
        <h3>Pending Invoices</h3>
        <div class="value">${mockData.stats.pendingInvoices}</div>
        <div class="change negative">
          <i class="fas fa-arrow-up"></i> 3 more than last month
        </div>
      </div>
      
      <div class="stat-card">
        <h3>Monthly Revenue</h3>
        <div class="value">$${mockData.stats.revenueMonth}</div>
        <div class="change positive">
          <i class="fas fa-arrow-up"></i> 15% from last month
        </div>
      </div>
      
      <div class="stat-card">
        <h3>New Clients</h3>
        <div class="value">${mockData.stats.newClients}</div>
        <div class="change positive">
          <i class="fas fa-arrow-up"></i> 1 more than last month
        </div>
      </div>
    </div>
    
    <div class="dashboard-grid">
      <div class="card overview-card">
        <div class="card-header">
          <h2>Upcoming Jobs</h2>
          <a href="#" class="secondary-btn">View Calendar</a>
        </div>
        
        <div class="job-list">
          ${mockData.upcomingJobs.map(job => `
            <div class="job-item">
              <div class="job-info">
                <div class="job-client">${job.client}</div>
                <div class="job-details">${job.type} | ${job.address}</div>
              </div>
              <div class="job-time">
                <span>${formatTime(job.time)}</span>
                <span>${formatDate(job.date)}</span>
              </div>
              <div class="job-actions">
                <button class="job-action-btn"><i class="fas fa-phone"></i></button>
                <button class="job-action-btn"><i class="fas fa-directions"></i></button>
                <button class="job-action-btn"><i class="fas fa-ellipsis-v"></i></button>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <h2>Recent Activity</h2>
          <a href="#" class="secondary-btn">View All</a>
        </div>
        
        <div class="activity-list">
          ${mockData.recentActivity.map(activity => `
            <div class="activity-item">
              <div class="activity-icon">
                <i class="${getActivityIcon(activity.type)}"></i>
              </div>
              <div class="activity-details">
                <div class="activity-title">${activity.title}</div>
                <div class="activity-description">${activity.description}</div>
                <div class="activity-time">${activity.time}</div>
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    </div>
  `;
  
  contentEl.innerHTML = dashboardHTML;
  
  // Add event listeners specific to the dashboard
  addDashboardEventListeners();
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

// Helper function to get icon for activity type
function getActivityIcon(type) {
  switch(type) {
    case 'invoice_paid': return 'fas fa-dollar-sign';
    case 'job_completed': return 'fas fa-check-circle';
    case 'new_client': return 'fas fa-user-plus';
    case 'job_scheduled': return 'fas fa-calendar-plus';
    default: return 'fas fa-bell';
  }
}

// Add event listeners specific to the dashboard
function addDashboardEventListeners() {
  // In a real app, we would add event listeners here
  // For example, clicking on a job item might open job details
  const jobItems = document.querySelectorAll('.job-item');
  jobItems.forEach(item => {
    item.addEventListener('click', () => {
      // This would navigate to job details in a real app
      console.log('Navigate to job details');
    });
  });
}