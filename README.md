# AtHome2

A Laravel-based property rental platform for listing, searching, and booking houses, apartments, condos, and more.

---

## Features

- **User Registration & Login** (Livewire, Volt, Tailwind UI)
- **Multi-step Property Listing Creation**
- **Image Gallery** with modal lightbox and mobile swipe support
- **Map Pinning** for property location (OpenStreetMap + Leaflet)
- **Search & Filter** for listings (by type, guests, etc.)
- **Favorites** system for users
- **Contact Host** messaging
- **House Rules & Amenities** display
- **Admin & Regular User Roles**
- **Seeder for Demo Data** (with images)

---

## Setup Instructions

### 1. Clone the Repository

```sh
git clone https://github.com/yourusername/athome2.git
cd athome2
```

### 2. Install Dependencies

```sh
composer install
npm install
```

### 3. Environment Setup

Copy `.env.example` to `.env` and set your database and mail credentials.

```sh
cp .env.example .env
php artisan key:generate
```

### 4. Storage Link

```sh
php artisan storage:link
```

### 5. Database Migration & Seeding

```sh
php artisan migrate --seed
```

Seeder images are located in `public/storage/seeders/images/`.  
**If you want to add your own demo images, place them in this folder.**

### 6. Build Frontend Assets

```sh
npm run build
```
or for development:
```sh
npm run dev
```

### 7. Run the Application

```sh
php artisan serve
```

### 8. To run both Assets and Application

```sh
composer run dev
```

Visit [http://localhost:8000](http://localhost:8000)

---

## Default Accounts

- **Admin:**  
  Email: `admin@example.com`  
  Password: `password`

- **User:**  
  Email: `user@example.com`  
  Password: `password`

---

## Notes

- All demo images are tracked in git via `.gitignore` exceptions.
- Map pinning uses OpenStreetMap and Leaflet.js.
- For production, configure your mail and storage drivers.

---

## License

MIT
