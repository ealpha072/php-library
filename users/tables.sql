/*inserting books into database*/

INSERT INTO `books`(`id`, `book_name`, `book_author`, `subject`) VALUES 
(1,'Management Accounting','R.J.Reddy','Accounting')
(2,'Financial Accounting','Ashok Banerjee','Accounting'),
(3,'Fundamentals of Accounting','Donatila Agtarap-San Juan','Accounting'),
(4,'Financial Accounting for BBA','S.N. Maheshwari ','Accounting'),
(5,'Intermediate Accounting'.'Donald E. Kieso','Accounting'),
(6,'BASIC FINANCIAL ACCOUNTING','Toye Adelaja','Accounting'),
(7,'Accounting All-in-One For Dummies','Kenneth Boyd','Accounting'),
(8,'Corporate Accounting, 6th Edition','Maheshwari S.N. & Maheshwari S.K.','Accounting'),
(9,'Accounting For Management','Vijayakumar','Accounting');


/* code for adding image column*/

ALTER TABLE `users` ADD `user_image` VARCHAR(255) NOT NULL AFTER `password`;

/*borrowed books table*/
CREATE TABLE `library`. ( `book_id` INT NULL , `user_name` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;

/*alter tables*/
ALTER TABLE `borrowed_books` CHANGE `user_name` `user_email` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
ALTER TABLE `borrowed_books` ADD `user_id` INT(100) NOT NULL AFTER `user_email`;
ALTER TABLE `borrowed_books` CHANGE `user_email` `user_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `borrowed_books` ADD `time` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `user_id`;

/*drop column*/
ALTER TABLE `borrowed_books`
  DROP `user_name`;

/* new columns*/
ALTER TABLE `users` ADD `phone` INT(10) NOT NULL AFTER `user_image`, 
ADD `course` VARCHAR(10) NOT NULL AFTER `phone`, 
ADD `proof` VARCHAR(255) NOT NULL AFTER `course`, 
ADD `study_year` VARCHAR(100) NOT NULL AFTER `proof`;

/*dropped the proof column*/
ALTER TABLE `users`
  DROP `proof`;

/*added address column*/
ALTER TABLE `users` ADD `address` VARCHAR(50) NOT NULL AFTER `study_year`