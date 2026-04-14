# LAN Device Monitoring System

## Overview
A complete Laravel 10 application for monitoring LAN devices via IP ping connectivity checks. Features:
- CRUD for devices (name, IP, status)
- Real-time status check (ONLINE/OFFLINE) using Windows `ping`
- Bootstrap 5 responsive dashboard
- Auto-refresh every 5s, search, filter by status
- Stats cards for online/offline counts

## Prerequisites
- PHP 8.1+
- Composer
- MySQL (local running)
- Node.js/npm (optional for assets)

## Setup Instructions
1. **Clone/Navigate:**
   ```
   cd c:/Users/TESDA/Documents/GonzalesDocs/testing/lan-device-monitor
   ```

2. **Configure Database** (edit `.env`):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lan_device_monitor
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Install Dependencies** (if not done):
   ```
   composer install
   ```

4. **Generate Key & Migrate:**
   ```
   php artisan key:generate
   php artisan migrate
   ```

5. **Assets** (optional):
   ```
   npm install
   npm run dev
   ```

6. **Start Server:**
   ```
   php artisan serve
   ```

7. **Access Dashboard:**
   Open http://127.0.0.1:8000/devices

## Usage
- **Add Device:** /devices/create (valid IP required)
- **Dashboard:** Auto-pings all IPs every load/refresh (5s JS auto-refresh)
- **Ping Logic:** Uses `exec('ping -n 1 IP')` - works on Windows
- **Filter/Search:** Client-side JS on dashboard
- **Responsive:** Bootstrap 5 mobile-friendly

## Sample Devices to Test
Add these IPs:
- 127.0.0.1 (local - ONLINE)
- 8.8.8.8 (Google DNS - usually ONLINE)
- 999.999.999.999 (invalid - OFFLINE)

## Screenshots
(Dashboard with stats, colored status, actions)

## Tech Stack
- Laravel 10
- MySQL
- Bootstrap 5 + Font Awesome
- Blade templates
- PHP exec() for ping

**Fully functional - ready to use!**

