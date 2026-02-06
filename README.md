# Travel Bunny

## Project Overview
Travel Bunny is a comprehensive travel management web application designed to streamline the operations of travel agencies and tour operators. The platform enables users to manage travel packages, handle customer enquiries, showcase testimonials, and administer user roles efficiently. Built with a custom MVC architecture in PHP, Travel Bunny provides both an admin dashboard for backend management and a public-facing interface for customers.

### Key Features
- **Package Management:** Create, update, and display travel packages with images and details.
- **Enquiry Handling:** Receive and manage customer enquiries for various travel offerings.
- **User Management:** Administer user roles, permissions, and authentication for secure access.
- **Testimonials:** Collect and display customer feedback to build trust and credibility.
- **Content Management:** Manage pages, sliders, and other website content easily.
- **RESTful API:** Expose endpoints for integration with other systems or mobile apps.
- **File Uploads:** Support for uploading images and documents related to packages and testimonials.
- **Logging:** Maintain error logs for troubleshooting and monitoring application health.

### Intended Use
Travel Bunny is ideal for travel businesses seeking a flexible, self-hosted solution to manage their offerings and engage with customers online. The application can be customized and extended to fit specific business needs, making it suitable for small to medium-sized agencies.

## Tools & Technologies Used
- **Programming Language:** PHP (main backend language)
- **Frontend:** HTML, CSS, JavaScript
- **Database:** MySQL
- **Libraries:** PHPMailer, custom helpers for email, file, image upload, session, etc.
- **Framework:** Custom MVC (no external framework)
- **Other Tools:** XAMPP (local development), Composer (for autoloading)

## Project Structure
- `admin/` and `controllers/`: Backend logic and admin panel
- `core/`: MVC core classes (Controller, Model, View)
- `libs/`: Helper libraries and database drivers
- `models/`: Data models
- `modules/`: Feature modules (enquiries, packages, users, etc.)
- `uploads/`: File uploads
- `views/`: Frontend views
- `restful/`: REST API structure
- `logs/`: Error logs
- `vendor/`: Composer dependencies

## GitHub Language Highlight
If your GitHub repository is showing only CSS, it's likely because the CSS files are larger or more prominent. To highlight PHP:
- Ensure your main code files are `.php` and not hidden in subfolders.
- Add a description in your README specifying PHP as the main language.
- Optionally, add a `.gitattributes` file with:
	```
	*.php linguist-language=PHP
	```
This will help GitHub recognize PHP as the primary language.

## Getting Started
1. Clone the repository
2. Set up XAMPP and place the project in the `htdocs` folder
3. Configure the database in `libs/config.php`
4. Access the application via `localhost/travel_bunny`

## License
MIT