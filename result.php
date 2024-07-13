<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit();
}

include 'config.php';

$student_id = $_GET['student_id'];

// Fetch results for the student
$query = "SELECT course_code, course_credit, obtained_marks FROM results WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$results = [];
$total_credits = 0;
$total_grade_points = 0;
while ($row = $result->fetch_assoc()) {
    $row['grade_point'] = calculateGradePoint($row['obtained_marks']);
    $row['letter_grade'] = calculateLetterGrade($row['obtained_marks']);
    $total_credits += $row['course_credit'];
    $total_grade_points += $row['grade_point'] * $row['course_credit'];
    $results[] = $row;
}

$stmt->close();
$conn->close();

$cgpa = ($total_credits > 0) ? ($total_grade_points / $total_credits) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result | Result Manager | NWU</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
    <div class="wrapper" style="width: 80%;">
        <div class="title">
            Result
        </div>
        <table style="margin: 20px; width: 96%;">
            <tr>
                <th>Student ID:</th>
                <th colspan="4"><?php echo htmlspecialchars($student_id); ?></th>
            </tr>
            <tr>
                <th>Course Code</th>
                <th>Credit</th>
                <th>Obtained Marks</th>
                <th>Grade Point</th>
                <th>Letter Grade</th>
            </tr>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['course_code']); ?></td>
                <td><?php echo htmlspecialchars($row['course_credit']); ?></td>
                <td><?php echo htmlspecialchars($row['obtained_marks']); ?></td>
                <td><?php echo calculateGradePoint($row['obtained_marks']); ?></td>
                <td><?php echo calculateLetterGrade($row['obtained_marks']); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td rowspan="2" colspan="5" style="text-align: center;">CGPA - <?php echo round($cgpa, 2); ?></td>
            </tr>
        </table>
        <br>
        <form action="#">
        <div class="field">
            <input type="button" value="Back to Save Another" onclick="window.location.href='index.php';" style="background: linear-gradient(-135deg, #c850c0, #4158d0);">
        </div>
        </form>
    </div>
</body>
</html>

<?php
function calculateGradePoint($marks) {
    if ($marks >= 80) return 4.0;
    if ($marks >= 75) return 3.75;
    if ($marks >= 70) return 3.5;
    if ($marks >= 65) return 3.25;
    if ($marks >= 60) return 3.0;
    if ($marks >= 55) return 2.75;
    if ($marks >= 50) return 2.5;
    if ($marks >= 45) return 2.25;
    if ($marks >= 40) return 2.0;
    return 0;
}

function calculateLetterGrade($marks) {
    if ($marks >= 80) return 'A+';
    if ($marks >= 75) return 'A';
    if ($marks >= 70) return 'A-';
    if ($marks >= 65) return 'B+';
    if ($marks >= 60) return 'B';
    if ($marks >= 55) return 'B-';
    if ($marks >= 50) return 'C+';
    if ($marks >= 45) return 'C';
    if ($marks >= 40) return 'D';
    return 'F';
}
?>