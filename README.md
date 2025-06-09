# Catalyst HomePro - Home Services Management System

A comprehensive web application built with CodeIgniter 4 for independent home service providers to manage their business operations.

## Features

### Core Features
- **Dashboard** - Overview of business metrics and upcoming jobs
- **Client Management** - Store and manage client information
- **Job Scheduling** - Schedule and track service appointments
- **Invoicing** - Create and manage invoices with payment tracking
- **Calendar View** - Visual schedule management
- **Mobile Responsive** - Works on all devices

### Key Capabilities
- Drag-and-drop calendar scheduling
- Automated client notifications (SMS/Email ready)
- Job status tracking (Scheduled → In Progress → Completed)
- One-tap invoice creation
- Payment integration ready (Stripe, PayPal)
- Photo documentation for jobs
- Offline mode support (sync when online)
- Professional invoice templates

## Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer

### Setup Instructions

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd catalyst-homepro
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Database Setup**
   - Create a MySQL database named `catalyst_homepro`
   - Update database credentials in `app/Config/Database.php`
   
4. **Run migrations**
   ```bash
   php spark migrate
   ```

5. **Configure environment**
   - Copy `env` to `.env`
   - Update the base URL and database settings

6. **Start the development server**
   ```bash
   php spark serve
   ```

7. **Access the application**
   - Open your browser to `http://localhost:8080`

## Usage

### Getting Started
1. **Add Clients** - Start by adding your client information
2. **Schedule Jobs** - Create job appointments for your clients
3. **Track Progress** - Update job status as you work
4. **Create Invoices** - Generate professional invoices for completed work
5. **Manage Payments** - Track payment status and send reminders

### Key Workflows

#### Scheduling a Job
1. Go to Jobs → Schedule New Job
2. Select client and service type
3. Set date, time, and duration
4. Add job details and notes
5. Save to schedule

#### Creating an Invoice
1. Go to Invoices → Create Invoice
2. Select client and completed job
3. Add line items (labor, materials, etc.)
4. Set payment terms
5. Send to client

#### Managing Clients
1. Go to Clients → Add New Client
2. Enter contact information
3. Add notes and preferences
4. Track job history and payments

## Technical Details

### Architecture
- **Framework**: CodeIgniter 4
- **Database**: MySQL with proper migrations
- **Frontend**: Bootstrap 5 + Custom CSS
- **Icons**: Font Awesome 6
- **Responsive**: Mobile-first design

### Database Schema
- **clients** - Client information and contact details
- **jobs** - Job scheduling and tracking
- **invoices** - Invoice management
- **invoice_items** - Line items for invoices

### Security Features
- CSRF protection
- SQL injection prevention
- Input validation and sanitization
- Secure password handling (ready for auth)

## Deployment

### Production Deployment
1. Upload files to your web server
2. Set up the database and run migrations
3. Configure the web server (Apache/Nginx)
4. Update environment settings for production
5. Set proper file permissions

### Server Requirements
- PHP 7.4+ with required extensions
- MySQL 5.7+ or MariaDB
- Web server with URL rewriting
- SSL certificate (recommended)

## Customization

### Branding
- Update company name in `app/Views/layouts/main.php`
- Replace logo and colors in CSS
- Customize invoice templates

### Service Types
- Modify service types in job creation forms
- Update database enums as needed
- Add custom fields for specific trades

### Payment Integration
- Implement Stripe/PayPal in payment controllers
- Add webhook handlers for payment notifications
- Configure payment gateway credentials

## Support

This application is designed to be:
- **Easy to deploy** - Standard CodeIgniter 4 deployment
- **Customizable** - Clean code structure for modifications
- **Scalable** - Database design supports growth
- **Mobile-ready** - Responsive design works on all devices

## License

This project is open source and available under the MIT License.