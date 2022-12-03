# ORBS(Online Restaurant Booking System)

### Introduction
ORBS is a restaurant booking webapp with minimal UI.
ORBS allows anyone who signed up as ***customer*** to request time slot, menu and seats at any restaurants. Each restaurant needs to create a ***restaurant*** account.
Restaurants can add, edit and hide menu items. When a *customer* place a request, *restaurant* can review the request. If the customer's requirement is available, *restaurant* can accept the request.
Otherwise they can reject. Customers are allowed to cancel their request anytime before the restaurant accept or reject it. If the request got accepted, customer can pay.
Customers can post their review below the restaurant's profile. Both customers and restaurants can send complaints to Admin. Admin will take action if needed.
Admin can view status of the webapp and manage customer and restaurant account.


### Installation
#### Requirements
- Apache WebServer
- MySQL
- PHP

#### Steps
- Clone this repository.
- Create a new database and user.
- Assign the credentials to respective variables in `db/credentials.php`.
- Import `db/orbs.sql` to the database you created.
- Add the folder to root of webserver.
- Start the server.
- The webapp will be available at <http://localhost/orbs>


### Note
- Admin panel url is <http://localhost/orbs/admin/login.php>
- Default admin username : `admin-123@gmail.com` and password : `password`
- Admin accounts can managed only by directly interacting with the database
- MD5 hashing algorithm is used to secure passwords
