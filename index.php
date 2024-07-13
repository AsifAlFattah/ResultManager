<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['stdid'];

    // Course 1
    $course_code1 = $_POST['cc1'];
    $course_credit1 = $_POST['ccr1'];
    $obtained_marks1 = $_POST['om1'];

    // Course 2
    $course_code2 = $_POST['cc2'];
    $course_credit2 = $_POST['ccr2'];
    $obtained_marks2 = $_POST['om2'];

    // Course 3
    $course_code3 = $_POST['cc3'];
    $course_credit3 = $_POST['ccr3'];
    $obtained_marks3 = $_POST['om3'];

    // Insert Course 1
    $stmt1 = $conn->prepare("INSERT INTO results (student_id, course_code, course_credit, obtained_marks) VALUES (?, ?, ?, ?)");
    $stmt1->bind_param("isdd", $student_id, $course_code1, $course_credit1, $obtained_marks1);
    $stmt1->execute();

    // Insert Course 2
    $stmt2 = $conn->prepare("INSERT INTO results (student_id, course_code, course_credit, obtained_marks) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("isdd", $student_id, $course_code2, $course_credit2, $obtained_marks2);
    $stmt2->execute();

    // Insert Course 3
    $stmt3 = $conn->prepare("INSERT INTO results (student_id, course_code, course_credit, obtained_marks) VALUES (?, ?, ?, ?)");
    $stmt3->bind_param("isdd", $student_id, $course_code3, $course_credit3, $obtained_marks3);
    $stmt3->execute();

    // Close statements
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();

    $conn->close();

    // Redirect to result.php with student_id
    header("Location: result.php?student_id=" . $student_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Result Manager | NWU</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="wrapper" style="width: 80%;">
        <div class="title">
           Enter Result
        </div>
        <form action="" method="post" style="margin-top: 20px;">
           <label for="stdid"><b>Student ID: </b></label> 
           <input type="number" name="stdid" id="stdid" required> <br> <br>

           <h4 style="color: blueviolet;">Course 1</h4>

           <label for="cc1"><b>Course Code: </b></label>
           <input type="text" name="cc1" id="cc1" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <label for="ccr1"><b>Course Credit: </b></label>
           <select name="ccr1" id="ccr1">
                <option value="3.00">3.00</option>
                <option value="1.5">1.5</option>
                <option value="0.75">0.75</option>
           </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <label for="om1"><b>Obtained Marks: </b></label>
           <input type="number" name="om1" id="om1" required> <br>

           <br>
           <h4 style="color: blueviolet;">Course 2</h4>

           <label for="cc2"><b>Course Code: </b></label>
           <input type="text" name="cc2" id="cc2" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <label for="ccr2"><b>Course Credit: </b></label>
           <select name="ccr2" id="ccr2">
                <option value="3.00">3.00</option>
                <option value="1.5">1.5</option>
                <option value="0.75">0.75</option>
           </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <label for="om2"><b>Obtained Marks: </b></label>
           <input type="number" name="om2" id="om2" required> <br>

           <br>
           <h4 style="color: blueviolet;">Course 3</h4>

           <label for="cc3"><b>Course Code: </b></label>
           <input type="text" name="cc3" id="cc3" required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <label for="ccr3"><b>Course Credit: </b></label>
           <select name="ccr3" id="ccr3">
                <option value="3.00">3.00</option>
                <option value="1.5">1.5</option>
                <option value="0.75">0.75</option>
           </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <label for="om3"><b>Obtained Marks: </b></label>
           <input type="number" name="om3" id="om3" required> <br>

           <br>
           <div class="field">
            <input type="submit" value="Save and Show Result">
           </div>
        </form>
     </div>
     <a href="logout.php">Logout</a>
</body>
</html>
