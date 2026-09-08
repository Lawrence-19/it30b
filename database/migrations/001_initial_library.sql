-- #1 students table
CREATE TABLE IF NOT EXIST students (
    -- Primary key for the student table
    students_id INT AUTO_INCREMENT PRIMARY KEY,

    -- student name
    student_first_name VARCHAR(50) NOT NULL,
    student_last_name VARCHAR(50 NOT NULL),

    -- student course
    student_course VARCHAR(50) NOT NULL,

    -- student created at timestamp
    student_created_at TIMESTAMP NOT NULL 
    DEFAULT CURRENT_TIMESTAMP
    
) ENGINE=InnoDB;
DEFAULT CHARSET = utf8mb4
COLLATE= utf8mb4_general_ci;


-- #2 books table
CREATE TABLE IF NOT EXIST books (
    -- Primary key for the books tbale
    book_id INT PRIMARY KEY AUTO_INCREMENT,

    -- books details
    book_title VARCHAR(100) NOT NULL,
    book_author VARCHAR(100) NOT NULL,
    book_category VARCHAR(50) NOT NULL,

    -- book crated at timestamp
    book_created_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP

)ENGINE=InnoDB;
DEFAULT CHARSET = utf8mb4
COLLATE= utf8mb4_general_ci;

-- #3 borrow table

CREATE TABLE IF NOT EXIST borrow (
    -- Primary key for the borrow table
    borrow_id INT AUTO_INCREMENT PRIMARY KEY,

    -- Foreign key references
    student_id INT NOT NULL,
    book_id INT NOT NULL,

    -- Borrow timestamp not null by default
    borrow_date TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP,

    -- Borrow return timestamp null by default
    borrow_return_date TIMESTAMP NOT NULL
        DEFAULT NULL,
    
    -- Borrow table constraints and foreign keys
    CONSTRAINT fk_borrow_student
        FOREIGN KEY(student_id)
        REFERENCES students(student__id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_borrow_book
        FOREIGN KEY(book_id)
        REFERENCES books(book_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT

)ENGINE=InnoDB;
DEFAULT CHARSET = utf8mb4
COLLATE= utf8mb4_general_ci;

-- Insert statement #1: Insert Students
INSERT INTO students(
    student_first_name,
    student_last_name,
    student_course
) VALUES
('LAWRENCE', 'SOMBRENO', 'BSIT')
('PEDRO', 'PENDUKO', 'BSBA-MM')
('PAULMAR', 'SOMBRENO', 'BSED');

-- Insert Statement #2: Insert Book
INSERT INTO books(
    book_title,
    book_author,
    book_category
) VALUES
('Harry Potter and the Sorcerer''s Stone', 'J.K. Rowling', 'Fantasy'),
('The Chronicles of Narnia', 'C.S. Lewis', 'Fantasy'),
('The Hunger Games', 'Suzanne Collins', 'Dystopian');

--Insert Statement #3: Insert Borrow
INSERT INTO borrow (
    student_id,
    book_id
) VALUES
(1, 1),
(2, 2),
(3, 3);

