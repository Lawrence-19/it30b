-- Student SQL#1 : Select 1 student
SELECT * FROM students

-- Student SQL#2 : Select  students in asc order by id;
SELECT * FROM students
 ORDER BY student_id ASC;

-- Student SQL#3 : Select  students in desc order by id;
SELECT * FROM students
 ORDER BY student_id DESC;

-- Student SQL#4 : Select students in asc order by last_name;
SELECT * FROM students
 ORDER BY student_last_name ASC;

-- Student SQL#5 : Select  students in desc order by last name;
SELECT * FROM students
 ORDER BY student_last_name DESC;

-- Student SQL#6 : Select students in asc order by first name;
SELECT * FROM students
 ORDER BY student_first_name ASC;

-- Student SQL#7 : Select students in desc order by first name;
SELECT * FROM students
 ORDER BY student_first_name DESC;

-- You can modify displayed columns by seletcting 
-- specific columns after SELECT command.
-- Student SQL#8 : display all students first_name and last_name
SELECT student_first_name,
        student_last_name
FROM students
ORDER BY student_first_name ASC;

-- Student SQL#9 LIMIT 1
SELECT student_first_name,
        student_last_name
FROM students
ORDER BY student_first_name ASC
LIMIT 1;

-- Student SQL#10 Select a student based on id
SELECT student_first_name,
        student_last_name
FROM students
WHERE student_id = 1
LIMIT 1;

-- Student SQL#11 - update student name a student based on id
UPDATE students
SET student_first_name = 'Paulmar',
    student_last_name = 'Sombreno'
WHERE student_id = 1;

--student SQL#12 - update book name a book based on id
UPDATE books
SET book_title = 'Ibong Adarna',
    book_author = 'Jose de la Cruz'
WHERE book_id = 1;
