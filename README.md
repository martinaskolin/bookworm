# D0018E - Bookworm
This project is a part of the database course D0018E at Luleå University of Technology. The task was to create a simple e-commerce site using a relational database. Our website is called "Bookworm" and as the name suggests it provides a platform for selling books. The website is not functional as a real e-commerce site but it provides a shell that can be expanded on. Security features have been implemented where deemed necessary such as hashed passwords, prepared PHP-statements and blocking of certain pages through direct URL access. MySQL transactions have been used when placing orders to ensure the possibility of multiple customers placing orders concurrently.

The website provides the following structure:
- A page for browsing books in stock and placing books in the cart
  - When clicking on a book additional information and reviews are displayed
  - An admin profile can add, delete and edit books from the home page when clicking on a book
- A signup page were a user can create an account with name, email and encrypted password
- A login page were a user can login if they have created an account
- A profile page were a logged in user can edit and delete their account information
- A cart page where items can be removed from the cart and where the customer can go to checkout
- A checkout page were an order can be placed on the items in the cart

The website and database are running on a LUDD DUST server at LTU.

Link to website: http://130.240.200.15/bookworm/ **(Currently down)**
