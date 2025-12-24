# AutoBird – Smart Auto-Rickshaw Booking System

AutoBird is a browser-based auto-rickshaw booking system designed for local areas where mobile app–based, GPS-heavy platforms are not reliable or accessible.

It provides a simple, fair, and cost-effective way to connect users with nearby auto drivers using open-source maps and backend logic.

---

## Problem

In many small cities, campuses, and residential areas:
- Auto booking is manual and inconsistent
- Drivers remain idle while users struggle to find rides
- Existing platforms require smartphones, GPS, and paid APIs

---

## Solution

AutoBird offers a lightweight web-based booking system that:
- Works directly in a browser
- Avoids Google Maps and paid APIs
- Automatically assigns the most suitable driver
- Ensures fair ride distribution among drivers

---

## Key Features

- Automatic driver assignment based on distance and availability
- Fair driver selection using ride count and idle time
- Auto reassignment if a driver cancels
- Map-based pickup and drop location selection
- ETA and fare estimation
- Separate dashboards for Users, Drivers, and Admin
- No mobile app required

---

## How It Works

1. User selects pickup and drop locations using the map  
2. System finds all available drivers  
3. Distance is calculated using latitude and longitude  
4. Driver is selected based on:
   - Nearest distance
   - Fewer completed rides
   - Longer idle time  
5. Booking is confirmed with driver and ETA  
6. If the driver cancels, reassignment happens automatically  

---

## Tech Stack

**Frontend**
- HTML
- CSS
- Bootstrap
- JavaScript
- Leaflet.js

**Backend**
- Core PHP

**Database**
- MySQL

**APIs**
- Photon API (location search)

**Tools**
- XAMPP
- phpMyAdmin
- Visual Studio Code

---

## Setup (Local)

```bash
1. Install XAMPP
2. Start Apache and MySQL
3. Copy project folder to:
   xampp/htdocs/autobird
4. Import the database using phpMyAdmin
5. Configure database credentials
6. Open browser:
   http://localhost/autobird
