# Meru National Polytechnic Gym Website

A simple informational website for the Meru National Polytechnic Gym with a membership/registration system.

## Features
- Gym information and facility details
- Operating hours
- Contact information
- Member registration system
- Member login system
- Responsive design

## Technology Stack
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Authentication**: Simple login system for members

## Project Structure
```
meru-polytechnic-gym/
├── index.html
├── register.html
├── login.html
├── dashboard.html
├── css/
│   └── style.css
├── js/
│   └── script.js
├── php/
│   ├── config.php
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   └── header.php
├── database/
│   └── schema.sql
└── README.md
```

## Setup Instructions
1. Clone the repository
2. Create MySQL database using `database/schema.sql`
3. Update database credentials in `php/config.php`
4. Upload files to your web server
5. Access the website through your browser

## Database
The system uses MySQL to store member information including:
- Member details (name, email, phone)
- Login credentials (username, password)
- Registration date
- Membership status

## License
MIT License