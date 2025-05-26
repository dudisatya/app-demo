// Mock data for invoices
const mockInvoices = [
  {
    id: "INV-2025-001",
    client: "John Smith",
    date: "2025-01-10",
    amount: 450.00,
    status: "paid",
    dueDate: "2025-01-24"
  },
  {
    id: "INV-2025-002",
    client: "Emma Davis",
    date: "2025-01-05",
    amount: 1200.00,
    status: "paid",
    dueDate: "2025-01-19"
  },
  {
    id: "INV-2025-003",
    client: "Michael Brown",
    date: "2025-01-12",
    amount: 350.00,
    status: "sent",
    dueDate: "2025-01-26"
  },
  {
    id: "INV-2025-004",
    client: "Sarah Wilson",
    date: "2024-12-28",
    amount: 780.00,
    status: "overdue",
    dueDate: "2025-01-11"
  },
  {
    id: "INV-2025-005",
    client: "David Thompson",
    date: "2024-12-15",
    amount: 540.00,
    status: "paid",
    dueDate: "2024-12-29"
  },
  {
    id: "INV-2025-006",
    client: "Jennifer Garcia",
    date: "2025-01-14",
    amount: 890.00,
    status: "draft",
    dueDate: "2025-01-28"
  }
];

// Function to initialize the invoices page
export function initInvoices(contentEl) {
  const invoicesHTML = `
    <div class="invoices-header">
      <h1>Invoices</h1>
      <button class="primary-btn"><i class="fas fa-plus"></i> Create Invoice</button>
    </div>
    
    <div class="invoice-filters">
      <div class="filter-item active">All</div>
      <div class="filter-item">Paid</div>
      <div class="filter-item">Unpaid</div>
      <div class="filter-item">Overdue</div>
      <div class="filter-item">Draft</div>
    </div>
    
    <div class="card">
      <table class="invoices-table">
        <thead>
          <tr>
            <th>Invoice #</th>
            <th>Client</th>
            <th>Date</th>
            <th>Due Date</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          ${mockInvoices.map(invoice => `
            <tr>
              <td class="invoice-id">${invoice.id}</td>
              <td>${invoice.client}</td>
              <td>${formatDate(invoice.date)}</td>
              <td>${formatDate(invoice.dueDate)}</td>
              <td class="invoice-amount">$${invoice.amount.toFixed(2)}</td>
              <td><span class="invoice-status invoice-${invoice.status}">${capitalizeFirstLetter(invoice.status)}</span></td>
              <td class="invoice-actions">
                <button class="job-action-btn"><i class="fas fa-eye"></i></button>
                <button class="job-action-btn"><i class="fas fa-edit"></i></button>
                <button class="job-action-btn"><i class="fas fa-ellipsis-v"></i></button>
              </td>
            </tr>
          `).join('')}
        </tbody>
      </table>
    </div>
    
    <div class="pagination">
      <button class="page-btn"><i class="fas fa-chevron-left"></i></button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
    </div>
  `;
  
  contentEl.innerHTML = invoicesHTML;
  
  // Add event listeners
  addInvoiceEventListeners();
}

// Helper function to format date
function formatDate(dateStr) {
  const date = new Date(dateStr);
  return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

// Helper function to capitalize first letter
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// Add event listeners for invoice interactions
function addInvoiceEventListeners() {
  // Filter clicks
  const filterItems = document.querySelectorAll('.filter-item');
  filterItems.forEach(item => {
    item.addEventListener('click', () => {
      filterItems.forEach(i => i.classList.remove('active'));
      item.classList.add('active');
      
      // In a real app, this would filter the invoices
      const filter = item.textContent.toLowerCase();
      console.log(`Filtering invoices by: ${filter}`);
    });
  });
  
  // Invoice view button
  const viewButtons = document.querySelectorAll('.invoice-actions .job-action-btn:first-child');
  viewButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      const row = e.target.closest('tr');
      const invoiceId = row.querySelector('.invoice-id').textContent;
      
      // Find the invoice
      const invoice = mockInvoices.find(inv => inv.id === invoiceId);
      
      if (invoice) {
        loadInvoiceDetail(invoice);
      }
    });
  });
  
  // Pagination
  const pageButtons = document.querySelectorAll('.page-btn');
  pageButtons.forEach(button => {
    button.addEventListener('click', () => {
      if (!button.classList.contains('active')) {
        pageButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        // In a real app, this would load the corresponding page of invoices
        console.log(`Loading page: ${button.textContent}`);
      }
    });
  });
}

// Load invoice detail
function loadInvoiceDetail(invoice) {
  const contentEl = document.getElementById('content');
  
  const invoiceDetailHTML = `
    <div class="page-header">
      <button class="secondary-btn back-to-invoices"><i class="fas fa-arrow-left"></i> Back to Invoices</button>
    </div>
    
    <div class="invoice-detail">
      <div class="invoice-actions" style="display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 16px;">
        <button class="secondary-btn"><i class="fas fa-print"></i> Print</button>
        <button class="secondary-btn"><i class="fas fa-envelope"></i> Send</button>
        <button class="primary-btn"><i class="fas fa-credit-card"></i> Record Payment</button>
      </div>
      
      <div class="invoice-header">
        <div class="invoice-branding">
          <img src="/assets/logo.svg" alt="Catalyst HomePro" class="invoice-logo">
          <div class="invoice-company">Catalyst Plumbing</div>
        </div>
        
        <div class="invoice-meta">
          <div class="invoice-number">${invoice.id}</div>
          <div class="invoice-date">Date: ${formatDate(invoice.date)}</div>
          <div class="invoice-due-date">Due Date: ${formatDate(invoice.dueDate)}</div>
          <div class="invoice-status invoice-${invoice.status}">${capitalizeFirstLetter(invoice.status)}</div>
        </div>
      </div>
      
      <div class="invoice-parties">
        <div class="invoice-from">
          <h3>From</h3>
          <div class="company-name">Catalyst Plumbing</div>
          <div>123 Business St</div>
          <div>Anytown, CA 12345</div>
          <div>Phone: (555) 555-1234</div>
          <div>Email: contact@catalystplumbing.com</div>
        </div>
        
        <div class="invoice-to">
          <h3>Bill To</h3>
          <div class="client-name">${invoice.client}</div>
          <div>456 Oak Ave</div>
          <div>Anytown, CA 12345</div>
          <div>Phone: (555) 987-6543</div>
          <div>Email: ${invoice.client.toLowerCase().replace(' ', '.')}@example.com</div>
        </div>
      </div>
      
      <div class="invoice-items">
        <table class="invoice-table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Rate</th>
              <th class="text-right">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Labor</td>
              <td>Plumbing service - 2 hours</td>
              <td>2</td>
              <td>$125.00</td>
              <td class="text-right">$250.00</td>
            </tr>
            <tr>
              <td>Parts</td>
              <td>PVC Pipes and fittings</td>
              <td>1</td>
              <td>$85.00</td>
              <td class="text-right">$85.00</td>
            </tr>
            <tr>
              <td>Parts</td>
              <td>Water valve replacement</td>
              <td>1</td>
              <td>$115.00</td>
              <td class="text-right">$115.00</td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="invoice-totals">
        <div class="invoice-total-row">
          <div class="invoice-total-label">Subtotal:</div>
          <div class="invoice-total-value">$450.00</div>
        </div>
        <div class="invoice-total-row">
          <div class="invoice-total-label">Tax (0%):</div>
          <div class="invoice-total-value">$0.00</div>
        </div>
        <div class="invoice-total-row invoice-grand-total">
          <div class="invoice-total-label">Total:</div>
          <div class="invoice-total-value">$450.00</div>
        </div>
      </div>
      
      <div class="invoice-notes">
        <h3>Notes</h3>
        <p>Thank you for your business! Payment is due within 14 days of invoice date. Please make checks payable to Catalyst Plumbing or pay online at www.catalystplumbing.com/pay</p>
      </div>
      
      <div class="invoice-footer">
        <p>Catalyst Plumbing | 123 Business St, Anytown, CA 12345 | (555) 555-1234 | www.catalystplumbing.com</p>
      </div>
    </div>
  `;
  
  contentEl.innerHTML = invoiceDetailHTML;
  
  // Add event listener to go back to invoices list
  document.querySelector('.back-to-invoices').addEventListener('click', () => {
    initInvoices(contentEl);
  });
}