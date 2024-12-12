# Project Documentation :: RodudApp 

## Overview
The project is a Simple Truck Ordering Application designed for Android and iOS platforms, with a React Native frontend and Laravel backend. The application facilitates user registration, truck request creation, and order tracking, along with an admin interface for monitoring and managing orders.

---

## Features

### User Interface (React Native)
- **User Authentication**: Login and registration pages.
- **Truck Request Page**: Form to fill in shipping details such as location, size, weight, and schedule pickup/delivery time.
- **Dashboard**: Users can monitor the status of their orders.

### Backend Infrastructure (Laravel)
- **API Development**: RESTful APIs for user and order management.
- **Database Management**: Models and controllers for data handling.
- **User Authentication**: Laravel Sanctum for secure authentication.
- **Notifications**: New order notifications to the admin.

### Admin Interface (Laravel)
- **Order Monitoring**: View and manage all submitted orders.
- **Order Status Updates**: Update order status (e.g., pending, in-progress, delivered).
- **User Communication**: Email notifications for updates.

---

## Backend Documentation (API)

### Setup Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/godfredakpan/rodudapp
   ```
2. Navigate to the project directory:
   ```bash
   cd backend
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Set up the `.env` file:
   - Configure the database connection.
   - Add Laravel Passport or Sanctum keys.
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Start the server:
   ```bash
   php artisan serve
   ```

### API Endpoints
#### Authentication
- **POST** `/api/register`
  - Register a new user.
  - **Parameters**:
    - `name`: string
    - `email`: string
    - `password`: string
- **POST** `/api/login`
  - User login.
  - **Parameters**:
    - `email`: string
    - `password`: string

#### Truck Requests
- **POST** `/api/orders/create`
  - Create a new truck request.
  - **Parameters**:
    - `pickup_location`: string
    - `delivery_location`: string
    - `truck_size`: string
    - `weight`: integer
    - `pickup_time`: datetime
    - `delivery_time`: datetime
    - `order_reference`: string
- **GET** `/api/orders/user`
  - Retrieve all orders for a user.
- **GET** `/api/orders/{id}`
  - Retrieve details of a specific order.
- Full API Documentation here: https://documenter.getpostman.com/view/23218164/2sAYHxmP7n

#### Admin Features are on the backend (login and see the interface)

### Notifications
Notifications are sent to admins using Laravel Notifications. Email integration is configurable in the `.env` file.

---

## Frontend Documentation (React Native)

### Setup Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/godfredakpan/rodudapp
   ```
2. Navigate to the project directory:
   ```bash
   cd frontend
   ```
3. Install dependencies:
   ```bash
   npm install
   ```
4. Start the development server:
   ```bash
   npm start or yarn start
   ```

### Folder Structure
```
frontend
├── assets          # Images and static files
├── components      # Reusable React components
├── screens         # Screen components for navigation
├── navigation      # Navigation setup
├── elements        # API service and Utility functions files
└── App.js          # Entry point
```

### Key Components
#### Authentication
- **LoginScreen.js**: Handles user login.
- **RegisterScreen.js**: Handles user registration.

#### Dashboard
- **HomeScreen.js**: Displays components for seeing last 3 orders, news, and a form component for sending new truck request.

#### API Integration
- **elements/api:
  - Base URL configuration.
  - API files such as `orders`, `auth`, and `notifications`.

### Styling
Styling is managed using `StyleSheet` from React Native, with a focus on responsiveness and a user-friendly design.

---

## Deployment

### Backend
1. Deploy the Laravel application to a hosting provider (e.g., AWS, DigitalOcean, or Heroku). I already deployed for testing here; https://rodudapp.hrmaneja.com/api

### Frontend
1. Build the React Native app for Android and iOS:
   - Android:
     ```bash
     yarn android
     ```
   - iOS:
     ```bash
     yarn ios
     ```
    
2. Note:  This is the link to the android and ios folders: https://www.mediafire.com/file/d0v834j6egmdv9n/AndroidAndIosFiles.zip/file

---

## Testing 

### Backend
- Use PHPUnit for testing API endpoints.
- Example:
  ```bash
  php artisan test
  ```

### Frontend
- Use `jest` and `react-native-testing-library` for component and integration testing.
- Example:
  ```bash
  npm test
  ```

---

## Future Enhancements
1. Implement push notifications for real-time updates.
2. Add payment gateway integration for order payments.
3. Include multi-language support for wider accessibility.
4. Enhance admin features with analytics and reporting tools.
5. Proper testing to be done in the future.

## Developer:
Godfred Akpan, Senior Fullstack Developer
godfredakpan@gmail.com

## SideNote:
I am grateful to have worked on this simple app, please reach out to me if you have any questions or you just want to give me an update. ;D.
Thank you.

