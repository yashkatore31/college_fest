<?php
// Include the database connection file
include('db_connection.php');

// Check if ID is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch the current student details from the database
    $sql = "SELECT * FROM students WHERE id = $student_id";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);
    
    // Check if student data is retrieved
    if (!$student) {
        die("Student not found.");
    }
} else {
    die("Invalid student ID.");
}

// Handle form submission to update the student details
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $prn_number = $_POST['prn_number'];
    
    // Update student details in the database
    $update_sql = "UPDATE students SET 
                   name = '$name', 
                   email = '$email', 
                   phone = '$phone', 
                   department = '$department', 
                   year = '$year', 
                   prn_number = '$prn_number' 
                   WHERE id = $student_id";
    
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Student details updated successfully!'); window.location.href='manage_students.php';</script>";
    } else {
        echo "Error updating student details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container mb-10">
        <h2 class="text-black text-center mb-4" >Edit Student</h2>
        <div class="row justify-content-center">
            
            <div class="col-md-6">
                <div class="card shadow-lg">
                    
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo $student['email']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $student['phone']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="department" class="form-label">Department:</label>
                                <input type="text" id="department" name="department" class="form-control" value="<?php echo $student['department']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="year" class="form-label">Year:</label>
                                <input type="text" id="year" name="year" class="form-control" value="<?php echo $student['year']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="prn_number" class="form-label">PRN Number:</label>
                                <input type="text" id="prn_number" name="prn_number" class="form-control" value="<?php echo $student['prn_number']; ?>" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-info" style="border-radius:5px;">Update Student</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
