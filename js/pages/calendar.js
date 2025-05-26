// Mock data for calendar
const mockEvents = [
  {
    id: 1,
    title: "Plumbing Repair",
    client: "John Smith",
    start: new Date(2025, 0, 15, 9, 30),
    end: new Date(2025, 0, 15, 11, 30),
    type: "repair"
  },
  {
    id: 2,
    title: "Water Heater Installation",
    client: "Emma Davis",
    start: new Date(2025, 0, 15, 13, 0),
    end: new Date(2025, 0, 15, 16, 0),
    type: "installation"
  },
  {
    id: 3,
    title: "Pipe Inspection",
    client: "Michael Brown",
    start: new Date(2025, 0, 16, 10, 0),
    end: new Date(2025, 0, 16, 11, 30),
    type: "inspection"
  },
  {
    id: 4,
    title: "Annual Maintenance",
    client: "Sarah Wilson",
    start: new Date(2025, 0, 17, 14, 0),
    end: new Date(2025, 0, 17, 16, 0),
    type: "maintenance"
  }
];

// Function to initialize the calendar page
export function initCalendar(contentEl) {
  const today = new Date();
  const calendarHTML = `
    <div class="calendar-container">
      <div class="calendar-header">
        <div class="calendar-title">
          <h1>Schedule</h1>
        </div>
        <div class="calendar-controls">
          <div class="calendar-nav">
            <button class="view-btn active" data-view="week">Week</button>
            <button class="view-btn" data-view="day">Day</button>
            <button class="view-btn" data-view="month">Month</button>
            <button class="primary-btn"><i class="fas fa-plus"></i> New Appointment</button>
          </div>
        </div>
      </div>
      
      <div class="calendar-view">
        <div class="calendar-sidebar">
          <div class="mini-calendar">
            <div class="mini-calendar-header">
              <button class="prev-month"><i class="fas fa-chevron-left"></i></button>
              <span>${formatMonthYear(today)}</span>
              <button class="next-month"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="mini-calendar-weekdays">
              ${getDayInitials().map(day => `<span>${day}</span>`).join('')}
            </div>
            <div class="mini-calendar-days">
              ${generateMiniCalendarDays(today)}
            </div>
          </div>
          
          <div class="color-filters">
            <h3>Job Types</h3>
            <div class="color-filter">
              <div class="color-indicator repair-color"></div>
              <span>Repair</span>
            </div>
            <div class="color-filter">
              <div class="color-indicator installation-color"></div>
              <span>Installation</span>
            </div>
            <div class="color-filter">
              <div class="color-indicator maintenance-color"></div>
              <span>Maintenance</span>
            </div>
            <div class="color-filter">
              <div class="color-indicator inspection-color"></div>
              <span>Inspection</span>
            </div>
          </div>
        </div>
        
        <div class="main-calendar">
          <div class="calendar-week-header">
            <h2>${formatDateRange(today)}</h2>
          </div>
          <div class="calendar-grid">
            <div class="time-column-header"></div>
            ${getDayHeaders(today)}
            ${getTimeLabels()}
            ${getCalendarCells(today)}
          </div>
        </div>
      </div>
    </div>
  `;
  
  contentEl.innerHTML = calendarHTML;
  
  // Add events to calendar
  renderEvents(mockEvents);
  
  // Add event listeners
  addCalendarEventListeners();
}

// Format month and year (e.g., "January 2025")
function formatMonthYear(date) {
  return date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
}

// Format date range for week view (e.g., "January 15-21, 2025")
function formatDateRange(date) {
  const startOfWeek = getStartOfWeek(date);
  const endOfWeek = new Date(startOfWeek);
  endOfWeek.setDate(startOfWeek.getDate() + 6);
  
  const startMonth = startOfWeek.toLocaleDateString('en-US', { month: 'long' });
  const endMonth = endOfWeek.toLocaleDateString('en-US', { month: 'long' });
  const startDay = startOfWeek.getDate();
  const endDay = endOfWeek.getDate();
  const year = endOfWeek.getFullYear();
  
  if (startMonth === endMonth) {
    return `${startMonth} ${startDay}-${endDay}, ${year}`;
  } else {
    return `${startMonth} ${startDay} - ${endMonth} ${endDay}, ${year}`;
  }
}

// Get day initials (S, M, T, W, T, F, S)
function getDayInitials() {
  return ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
}

// Generate mini calendar days
function generateMiniCalendarDays(date) {
  const today = new Date();
  const daysInMonth = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
  const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
  
  // Calculate previous month's days
  const prevMonthLastDay = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
  
  let days = [];
  
  // Previous month days
  for (let i = firstDayOfMonth - 1; i >= 0; i--) {
    days.push(`<div class="mini-calendar-day other-month">${prevMonthLastDay - i}</div>`);
  }
  
  // Current month days
  for (let i = 1; i <= daysInMonth; i++) {
    const isToday = i === today.getDate() && 
                     date.getMonth() === today.getMonth() &&
                     date.getFullYear() === today.getFullYear();
    
    // Check if there are events on this day
    const hasEvents = mockEvents.some(event => {
      const eventDate = event.start;
      return eventDate.getDate() === i && 
             eventDate.getMonth() === date.getMonth() &&
             eventDate.getFullYear() === date.getFullYear();
    });
    
    const classes = [
      'mini-calendar-day',
      isToday ? 'today' : '',
      hasEvents ? 'has-events' : ''
    ].filter(Boolean).join(' ');
    
    days.push(`<div class="${classes}">${i}</div>`);
  }
  
  // Next month days
  const totalCells = 42; // 6 rows of 7 days
  const nextMonthDays = totalCells - days.length;
  
  for (let i = 1; i <= nextMonthDays; i++) {
    days.push(`<div class="mini-calendar-day other-month">${i}</div>`);
  }
  
  return days.join('');
}

// Get the start of the week (Sunday) for a given date
function getStartOfWeek(date) {
  const result = new Date(date);
  const day = result.getDay();
  result.setDate(result.getDate() - day);
  return result;
}

// Generate day headers for the week view
function getDayHeaders(date) {
  const startOfWeek = getStartOfWeek(date);
  const today = new Date();
  
  let headers = '';
  
  for (let i = 0; i < 7; i++) {
    const currentDate = new Date(startOfWeek);
    currentDate.setDate(startOfWeek.getDate() + i);
    
    const isToday = currentDate.getDate() === today.getDate() && 
                     currentDate.getMonth() === today.getMonth() &&
                     currentDate.getFullYear() === today.getFullYear();
    
    const dayName = currentDate.toLocaleDateString('en-US', { weekday: 'short' });
    const dayNumber = currentDate.getDate();
    
    headers += `
      <div class="calendar-day-header ${isToday ? 'today' : ''}" data-date="${formatDateForData(currentDate)}">
        ${dayName} ${dayNumber}
      </div>
    `;
  }
  
  return headers;
}

// Generate time labels for the week view (8am - 6pm)
function getTimeLabels() {
  let labels = '';
  
  for (let i = 8; i <= 18; i++) {
    const hour = i > 12 ? i - 12 : i;
    const ampm = i >= 12 ? 'PM' : 'AM';
    
    labels += `
      <div class="time-label" data-hour="${i}">${hour} ${ampm}</div>
    `;
  }
  
  return labels;
}

// Generate calendar cells for the week view
function getCalendarCells(date) {
  const startOfWeek = getStartOfWeek(date);
  const today = new Date();
  
  let cells = '';
  
  for (let hour = 8; hour <= 18; hour++) {
    for (let day = 0; day < 7; day++) {
      const currentDate = new Date(startOfWeek);
      currentDate.setDate(startOfWeek.getDate() + day);
      
      const isToday = currentDate.getDate() === today.getDate() && 
                      currentDate.getMonth() === today.getMonth() &&
                      currentDate.getFullYear() === today.getFullYear();
      
      cells += `
        <div class="calendar-cell ${isToday ? 'today-column' : ''}" 
             data-date="${formatDateForData(currentDate)}" 
             data-hour="${hour}">
        </div>
      `;
    }
  }
  
  return cells;
}

// Format date for data attributes (YYYY-MM-DD)
function formatDateForData(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  
  return `${year}-${month}-${day}`;
}

// Render events on the calendar
function renderEvents(events) {
  events.forEach(event => {
    const startDate = formatDateForData(event.start);
    const startHour = event.start.getHours();
    const startMinute = event.start.getMinutes();
    const durationHours = (event.end - event.start) / (1000 * 60 * 60);
    
    // Find the cell where the event starts
    const cell = document.querySelector(`.calendar-cell[data-date="${startDate}"][data-hour="${startHour}"]`);
    
    if (cell) {
      // Calculate position and height
      const topOffset = (startMinute / 60) * 100;
      const height = durationHours * 100;
      
      // Create the event element
      const eventEl = document.createElement('div');
      eventEl.classList.add('calendar-event', `event-${event.type}`);
      eventEl.setAttribute('data-event-id', event.id);
      eventEl.innerHTML = `${event.title} - ${event.client}`;
      eventEl.style.top = `${topOffset}%`;
      eventEl.style.height = `${height}%`;
      
      // Add event to the cell
      cell.appendChild(eventEl);
      
      // Add click event listener to show event details
      eventEl.addEventListener('click', () => {
        // In a real app, this would show event details
        console.log('Show event details:', event);
      });
    }
  });
}

// Add event listeners for calendar interactions
function addCalendarEventListeners() {
  // View toggle (day/week/month)
  const viewButtons = document.querySelectorAll('.view-btn');
  viewButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      viewButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      
      // In a real app, this would switch the calendar view
      console.log(`Switching to ${btn.dataset.view} view`);
    });
  });
  
  // Month navigation in mini calendar
  const prevMonthBtn = document.querySelector('.prev-month');
  const nextMonthBtn = document.querySelector('.next-month');
  
  prevMonthBtn.addEventListener('click', () => {
    // In a real app, this would navigate to the previous month
    console.log('Previous month');
  });
  
  nextMonthBtn.addEventListener('click', () => {
    // In a real app, this would navigate to the next month
    console.log('Next month');
  });
  
  // Clicking on days in mini calendar
  const miniCalendarDays = document.querySelectorAll('.mini-calendar-day');
  miniCalendarDays.forEach(day => {
    day.addEventListener('click', () => {
      // In a real app, this would navigate to the selected day
      console.log('Navigate to day:', day.textContent);
    });
  });
}