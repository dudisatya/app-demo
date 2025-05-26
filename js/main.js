import "../css/style.css";

// Import page modules
import { initDashboard } from "./pages/dashboard.js";
import { initCalendar } from "./pages/calendar.js";
import { initClients } from "./pages/clients.js";
import { initInvoices } from "./pages/invoices.js";
import { initJobs } from "./pages/jobs.js";

// Global state
const state = {
  currentPage: "dashboard",
  // Mock user data - in a real app, this would come from authentication
  user: {
    id: 1,
    name: "Sarah Johnson",
    email: "sarah@catalyst.pro",
    company: "Catalyst Plumbing",
    role: "owner",
    avatar: "https://images.pexels.com/photos/1516680/pexels-photo-1516680.jpeg"
  }
};

// DOM Elements
const contentEl = document.getElementById("content");
const sidebarItems = document.querySelectorAll(".sidebar-menu li");
const newJobBtn = document.getElementById("new-job-btn");
const newJobModal = document.getElementById("new-job-modal");
const closeModalBtn = document.querySelector(".close-modal");
const cancelBtn = document.querySelector(".cancel-btn");
const newJobForm = document.getElementById("new-job-form");

// Initialize the application
function initApp() {
  // Set up event listeners
  setupEventListeners();
  
  // Load the initial page
  loadPage(state.currentPage);
}

// Set up event listeners
function setupEventListeners() {
  // Sidebar navigation
  sidebarItems.forEach(item => {
    item.addEventListener("click", () => {
      const page = item.dataset.page;
      if (page !== state.currentPage) {
        loadPage(page);
        
        // Update active state
        sidebarItems.forEach(i => i.classList.remove("active"));
        item.classList.add("active");
        
        // Update state
        state.currentPage = page;
      }
    });
  });
  
  // Modal handling
  newJobBtn.addEventListener("click", () => {
    openModal(newJobModal);
  });
  
  closeModalBtn.addEventListener("click", () => {
    closeModal(newJobModal);
  });
  
  cancelBtn.addEventListener("click", () => {
    closeModal(newJobModal);
  });
  
  newJobModal.addEventListener("click", (e) => {
    if (e.target === newJobModal) {
      closeModal(newJobModal);
    }
  });
  
  // Form submission
  newJobForm.addEventListener("submit", (e) => {
    e.preventDefault();
    
    // In a real app, this would send data to the backend
    console.log("Creating new job...");
    
    // Show success message
    const formData = new FormData(newJobForm);
    const jobData = {};
    for (let [key, value] of formData.entries()) {
      jobData[key] = value;
    }
    
    // Add the job to our mock data
    addNewJob(jobData);
    
    // Close the modal and reset form
    closeModal(newJobModal);
    newJobForm.reset();
  });
  
  // Handle client selection in new job form
  const clientSelect = document.getElementById("client");
  clientSelect.addEventListener("change", (e) => {
    if (e.target.value === "new") {
      // In a real app, this would open a new client form
      alert("In a complete app, this would open a new client form.");
      clientSelect.value = "";
    }
  });
}

// Load a page
function loadPage(page) {
  // Clear the content area
  contentEl.innerHTML = "";
  
  // Load the requested page
  switch (page) {
    case "dashboard":
      initDashboard(contentEl);
      break;
    case "calendar":
      initCalendar(contentEl);
      break;
    case "clients":
      initClients(contentEl);
      break;
    case "invoices":
      initInvoices(contentEl);
      break;
    case "jobs":
      initJobs(contentEl);
      break;
    default:
      // If page doesn't exist, load dashboard
      initDashboard(contentEl);
  }
}

// Open a modal
function openModal(modal) {
  modal.classList.add("active");
  document.body.style.overflow = "hidden"; // Prevent scrolling
}

// Close a modal
function closeModal(modal) {
  modal.classList.remove("active");
  document.body.style.overflow = ""; // Re-enable scrolling
}

// Add a new job to mock data
function addNewJob(jobData) {
  // In a real app with PHP backend, this would make an API call to create a job
  console.log("Job created:", jobData);
  
  // If we're on the jobs page, refresh it to show the new job
  if (state.currentPage === "jobs") {
    loadPage("jobs");
  }
}

// Start the app when the DOM is loaded
document.addEventListener("DOMContentLoaded", initApp);

// Export functions for use in other modules
export { openModal, closeModal };