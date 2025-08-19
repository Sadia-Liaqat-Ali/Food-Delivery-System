# 🍴 Food Delivery Management System  

A complete **Food Delivery Web Application** built with **PHP, MySQL, HTML, CSS, Bootstrap, and JavaScript**.  
The system provides **Admin, Restaurant, Rider, and Customer panels** to manage the entire process of ordering, preparing, delivering, and tracking food.  

---

## 🚀 Features  

### 🔑 Authentication & User Roles  
- Secure **Login & Registration** for all roles (Admin, Restaurant, Rider, Customer).  
- Passwords stored using hashing for security.  
- Session-based authentication.  

### 🛒 Customer Panel  
- Update profile and reset password.  
- Browse available restaurants & menus.  
- View all dishes available in each menu.  
- Add items to **Cart**, proceed to checkout, view order summary (delivery charges, discounts, total price, etc.), and place orders.  
- Avail **discounts & promotions**.  
- Track **order status** (Pending → Preparing → Out for Delivery → Completed).  
- Provide **feedback & ratings on foods and restaurants**.  
- View other customers’ feedback.  

### 🍽️ Restaurant Panel  
- **Manage Menus & Foods** (Add, Update, Delete).  
- Update **Restaurant Open/Close Delivery Status**.  
- Manage **Promotions / Discounts**.  
- Receive notifications from riders when orders are delivered successfully.  
- Receive payment notifications and view payment details.  
- Profile section with restaurant name & contact information.  

### 🚴 Rider Panel  
- Apply for rider role (**tbl_rider_applications**).  
- View application status.  
- View **Assigned Deliveries**.  
- Update delivery status (**Picked Up → Out for Delivery → Delivered**).  
- Track **Payments earned**.  
- Send automatic notifications to restaurants after successful delivery.  
- Manage rider profile with contact details.  

### 🛠️ Admin Panel  
- **Dashboard** showing overall system statistics.  
- Manage **Users, Restaurants, and Riders**.  
- Approve new restaurants & rider applications.  
- Apply discounts, create offers, and send promotional messages to customers.  
- View & manage **all orders, payments, feedback, and reports**.  
- Monitor system performance and maintain logs.  


---

## 📊 Database Design  

Database: `food_delivery_db`  

### Main Tables:
- **`tblusers`** → Stores all users (Admin, Restaurant, Rider, Customer).  
- **`tblrestaurants_delivery`** → Restaurant delivery details (status, contact, availability).  
- **`tbl_menus`** → Menus created by restaurants.  
- **`tbl_foods`** → Food items under menus.  
- **`tbl_cart`** → Customer’s cart items before order confirmation.  
- **`tbl_orders`** → Orders placed by customers.  
- **`tbl_promotions`** → Discounts & promotion codes for restaurants.  
- **`tbl_feedback`** → Customer reviews, likes/dislikes, and abuse reports.  
- **`tbl_rider_applications`** → Rider applications & approval process.  

---

## 🖥️ Tech Stack  

- **Frontend:** HTML5, CSS3, Bootstrap, JavaScript  
- **Backend:** PHP (Core)  
- **Database:** MySQL  
- **Icons:** Bootstrap Icons  
- **Server:** XAMPP / WAMP / LAMP  

---

## 📂 Project Structure  

