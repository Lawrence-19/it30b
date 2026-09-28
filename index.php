<?php

//Database connection
$host = 'localhost';
$db = 'it30b_lab_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host; dbname=$db; charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try{
   $pdo = new PDO($dsn, $user, $pass, $options); 
}catch(PDOException $e){
    die("Database connection failed: " . $e->getMessage());
}

//Session
session_start();

//Determine current section
$SECTION = $_GET['section'] ?? 'students';

//Determine CRUD Operation
$ACTION = $_GET['action'] ?? '';

/* STUDENTS SECTION NGA LOGIC*/

//Fetch students
if($SECTION === 'students'){
    $stmt = $pdo->query("SELECT * FROM students ORDER BY students_id DESC");    
    $students = $stmt->fetchAll();
}


// Create Student
if($SECTION==='students' && $ACTION==='create'){
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $firstName  = trim($_POST['student_first_name'] ?? '');
        $lastName   = trim($_POST['student_last_name'] ?? '');
        $course     = trim($_POST['student_course'] ?? '');

        if($firstName !== '' && $lastName !== '' && $course !== ''){
            $sql = "
                INSERT INTO students(
                    student_first_name,
                    student_last_name,
                    student_course
                )VALUES (?,?,?)";

            $stmt=$pdo->prepare($sql);

            $stmt->execute([
                $firstName,
                $lastName,
                $course
            ]);

            header("Location: index.php?section=students");
            exit;
        }
    }
}

// Update Student
if($SECTION==='students' && $ACTION==='update'){

    $studentId = (int) ($_GET['id'] ?? 00);


    //Retrieve student info by default
    $stmt = $pdo->prepare("
        SELECT *
        FROM students
        WHERE students_id = ?
    ");

    $stmt->execute([$studentId]);

    $student = $stmt->fetch();

    if(!$student){
        die("Student Not Found");
    }    

     //Update student on post
    If($_SERVER['REQUEST_METHOD'] ==='POST'){
        $firstName  = trim($_POST['student_first_name'] ?? '');
        $lastName   = trim($_POST['student_last_name'] ?? '');
        $course     = trim($_POST['student_course'] ?? '');
        
        if ($firstName !== '' && $lastName !== '' && $course !== ''){
            $sql=(" UPDATE students SET
                student_first_name = ?,
                student_last_name = ?,
                student_course = ?
                WHERE students_id = ?
            ");

         $stmt = $pdo->prepare($sql);

         $stmt->execute([
            $firstName,
            $lastName,
            $course,
            $studentId
         ]);

        header("Location: index.php?section=students");
        exit;
        }
    }
}

/* BOOKS SECTION NGA LOGIC */

//Fetch books
if($SECTION === 'books'){
    $stmt = $pdo->query("SELECT * FROM books ORDER BY book_id DESC");    
    $books = $stmt->fetchAll();
}


// Create Book
if($SECTION==='books' && $ACTION==='create'){
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $bookTitle  = trim($_POST['book_title'] ?? '');
        $bookAuthor   = trim($_POST['book_author'] ?? '');
        $bookCateg    = trim($_POST['book_category'] ?? '');

        if($bookTitle !== '' && $bookAuthor !== '' && $bookCateg !== ''){
            $sql = "
                INSERT INTO books(
                    book_title,
                    book_author,
                    book_category
                )VALUES (?,?,?)";

            $stmt=$pdo->prepare($sql);

            $stmt->execute([
                $bookTitle,
                $bookAuthor,
                $bookCateg
            ]);

            header("Location: index.php?section=books");
            exit;
        }
    }
}

// Update Books
if($SECTION==='books' && $ACTION==='update'){

    $bookID = (int) ($_GET['id'] ?? 0);


    //Retrieve student info by default
    $stmt = $pdo->prepare("
        SELECT *
        FROM books
        WHERE book_id = ?
    ");

    $stmt->execute([$bookID]);

    $bk = $stmt->fetch();

    if(!$bk){
        die("Book Not Found");
    }    

     //Update books on post
    if($_SERVER['REQUEST_METHOD']==='POST'){
        $bookTitle  = trim($_POST['book_title'] ?? '');
        $bookAuthor   = trim($_POST['book_author'] ?? '');
        $bookCateg    = trim($_POST['book_category'] ?? '');

        if($bookTitle !== '' && $bookAuthor !== '' && $bookCateg !== ''){
            $sql = "
                UPDATE books SET
                    book_title = ?,
                    book_author = ?,
                    book_category = ?
                WHERE book_id = ?
                ";


            $stmt=$pdo->prepare($sql);

            $stmt->execute([
                $bookTitle,
                $bookAuthor,
                $bookCateg,
                $bookID
            ]);

            header("Location: index.php?section=books");
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
</head>
<body>
    <h1>Simple Library System</h1>
    <nav>
        <a href="index.php?section=students">Students</a> |
        <a href="index.php?section=books">Books</a> |
        <a href="index.php?section=borrow">Borrow</a>
    </nav>
    <hr>

    <!--Student Section-->
    <?php if ($SECTION === 'students') : ?>
    <h1>Students</h1>
    
    <!--Create Section-->
    <?php if($ACTION==='create'): ?>
        
        <h2>Create Student</h2>

        <form method="POST">
            <p>
                <label>First Name</label>
                <br>
                <input type="text"
                   name="student_first_name"
                   required
                />
            </p>
            <p>
                <label>Last Name</label>
                <br>
                <input type="text"
                   name="student_last_name"
                   required
                />
            </p>
            <p>
                <label>Course</label>
                <br>
                <input type="text"
                   name="student_course"
                   required
                />
            </p>

            <button type="Submit">
                Save
            </button>

            <a href="index.php?section=students">
                Cancel
        </a>
     </form>

     <!--Update Section-->
    <?php elseif($ACTION==='update'): ?>

        <h2>Update Student</h2>

        <form method="POST">
            <p>
                <label>First Name</label>
                <br>
                <input type="text"
                    name="student_first_name"
                    value="<?= htmlspecialchars($student['student_first_name']) ?>"
                    required
                />
            </p>
            <p>
                <label>Last Name</label>
                <br>
                <input type="text"
                    name="student_last_name"
                    value="<?= htmlspecialchars($student['student_last_name']) ?>"
                    required
                />
            </p>
            <p>
                <label>Course</label>
                <br>
                <input type="text"
                    name="student_course"
                    value="<?= htmlspecialchars($student['student_course']) ?>"
                    required
                />
            </p>

            <button type="submit">
                Update
            </button>

            <a href="index.php?section=students">
                Cancel
        </a>
     </form>

    <!--Default Section-->
    <?php else: ?>
        
        <p>
        <a href="index.php?section=students&action=create"> 
        Add Student
        </a>
    </P>   

        <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
            <tbody>
                <?php foreach($students as $student) : ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($student['students_id']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($student['student_first_name']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($student['student_last_name']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($student['student_course']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($student['student_created_at']) ?>
                        </td>
                        <td>
                            <a href="index.php?section=students&action=update&id=<?= $student['students_id'] ?>">Edit</a>
                            <a >Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
    </table>

    <?php endif; ?>
<?php endif; ?>

     <!--Books Section-->
    <?php if ($SECTION === 'books') : ?>
    <h1>Books</h1>
   
    <!--Create Book -->
    <?php if($ACTION==='create'): ?>
        
        <h2>Add Book</h2>

        <form method="POST">
            <p>
                <label>Title</label>
                <br>
                <input type="text"
                   name="book_title"
                   required
                />
            </p>
            <p>
                <label>Author</label>
                <br>
                <input type="text"
                   name="book_author"
                   required
                />
            </p>
            <p>
                <label>Category</label>
                <br>
                <input type="text"
                   name="book_category"
                   required
                />
            </p>

            <button type="Submit">
                Save
            </button>

            <a href="index.php?section=books">
                Cancel
        </a>
     </form>

     <!--Update Book-->
    <?php elseif($ACTION==='update'): ?>

        <h2>Update Book</h2>
        <form method="POST">
        <p>
            <label>Title</label><br>
                <input type="text" 
                    name="book_title" 
                    value="<?= htmlspecialchars($bk['book_title']) ?>" 
                    required />
                </p>
                <p>
            <label>Author</label><br>
                <input type="text" 
                    name="book_author" 
                    value="<?= htmlspecialchars($bk['book_author']) ?>" 
                    required />
                </p>
                <p>
            <label>Category</label><br>
                <input type="text" 
                    name="book_category" 
                    value="<?= htmlspecialchars($bk['book_category']) ?>" 
                    required />
                </p>
            <button type="Submit">
                Update
            </button>

            <a href="index.php?section=books">
                Cancel
        </a>
     </form>

    <!--Default Section-->
    <?php else: ?>
        
        <p>
        <a href="index.php?section=books&action=create"> 
        Add Book
        </a>
    </P>   

        <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
            <tbody>
                <?php foreach($books as $bk) : ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($bk['book_id']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($bk['book_title']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($bk['book_author']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($bk['book_category']) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($bk['book_created_at']) ?>
                        </td>
                        <td>
                            <a href="index.php?section=books&action=update&id=<?= $bk['book_id'] ?>">Edit</a>
                            <a >Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
    </table>

    <?php endif; ?>


     <!--Borrow Section-->
    <?php if ($SECTION === 'borrow') : ?>
    <h1>Borrow</h1>
    <?php endif; ?>

</body>
</html>