
# Event Booking System – Laravel Assessment

Techical Assessment - Andry Rachdian Sumardi

---

## Features

- **Authentication & Roles**  
  - Register & login with API tokens (Laravel Sanctum)  
  - Roles: `admin`, `organizer`, `customer`

- **Events & Tickets**  
  - Admin/Organizer can create and manage events  
  - Tickets are linked to events with stock control

- **Bookings**  
  - Customers can book tickets  
  - Middleware to **prevent double booking**

- **Payments**  
  - Mock `PaymentService` processes payments  
  - Updates booking status

- **Other**  
  - Event list caching  
  - Notifications via queue  
  - Feature & Unit tests with Pest/Laravel TestSuite  

---

##  Installation

1. **Clone repo**
   ```bash
   git clone -b master git@github.com:andryrads/event-booking.git
   cd automatedpros-assessment-andry
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations & seeders**
   ```bash
   php artisan migrate --seed
   ```

   Seeder will create:
   - Admin → `admin@example.com / password`
   - Organizer → `organizer@example.com / password`
   - Customer → `customer@example.com / password`
   - Sample event + tickets

5. **Run server**
   ```bash
   php artisan serve
   ```

---

## Testing

Run all tests:
```bash
php artisan test
```

- **Feature Tests** → Auth, Booking, Payment, Events  
- **Unit Tests** → PaymentService logic  

Screenshot of Testing (All covered up):
[Screenshot of Tests](https://drive.google.com/file/d/1_xIJPP7wBogIaBdrr1GiSRFwQUIc5IaA/view?usp=drive_link)

---

## Queue & Notifications

Start worker:
```bash
php artisan queue:work
```

---
## Postman API Collection
[Link to Postman Collection File](https://drive.google.com/file/d/1vRf-hS9E939vEqIpNhExS7bWzdoOA6lC/view?usp=drive_link)

