<?php
    session_start();
    //$conn=mysqli_connect('localhost','root','','studybuddy') or die("Connection failed" .mysqli_connect_error());
    include_once('connection.php');
    $id=$_SESSION['uid'];
    $sql="SELECT * FROM Mentor WHERE Id='$id'";
    $query=mysqli_query($conn,$sql);
    $row=mysqli_fetch_array($query);
    $name=$row['Name'];

    $semesterFilter = isset($_POST['semester']) ? $_POST['semester'] : '';

    if(isset($_POST['delete'])) {
        $deleteId = $_POST['delete'];
        $deleteQuery = "DELETE FROM Doubt WHERE D_Id = '$deleteId'";
        $deleteResult = mysqli_query($conn, $deleteQuery);
        $deleteQuery2 = "DELETE FROM Solution WHERE Q_No = '$deleteId'";
        $deleteResult2 = mysqli_query($conn, $deleteQuery2);
        if($deleteResult) {
            header("Location: MentorDiscuss.php");
            exit;
        } else {
            echo "Error deleting discussion: " . mysqli_error($conn);
        }
    }

    $query="SELECT * FROM Doubt";
    if (!empty($semesterFilter)) {
        $query .= " WHERE Semester = '$semesterFilter'";
    }
    $query .= " ORDER BY D_id DESC";
    $result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="styles.css" rel="stylesheet" />

    <title>Mentor Discussion</title>
    <style>
            @import url('https://fonts.googleapis.com/css?family=Exo:400,700');

*{
    margin: 0px;
    padding: 0px;
}

body{
    font-family: 'Exo', sans-serif;
    z-index: -2;
}


.context {
    width: 100%;
    position: absolute;
    top:50vh;
    
}

.context h1{
    text-align: center;
    color: #fff;
    font-size: 50px;
}


.area{
    background: #4e54c8;  
    background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
    width: 100%;
    height:100%;
    z-index: -2;
   
}

.circles{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: overflow-y;
    z-index: 0;
}

.circles li{
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.2);
    animation: animate 25s linear infinite;
    bottom: -150px;
    
}

.circles li:nth-child(1){
    left: 25%;
    width: 80px;
    height: 80px;
    animation-delay: 0s;
}


.circles li:nth-child(2){
    left: 10%;
    width: 20px;
    height: 20px;
    animation-delay: 2s;
    animation-duration: 12s;
}

.circles li:nth-child(3){
    left: 70%;
    width: 20px;
    height: 20px;
    animation-delay: 4s;
}

.circles li:nth-child(4){
    left: 40%;
    width: 60px;
    height: 60px;
    animation-delay: 0s;
    animation-duration: 18s;
}

.circles li:nth-child(5){
    left: 65%;
    width: 20px;
    height: 20px;
    animation-delay: 0s;
}

.circles li:nth-child(6){
    left: 75%;
    width: 110px;
    height: 110px;
    animation-delay: 3s;
}

.circles li:nth-child(7){
    left: 35%;
    width: 150px;
    height: 150px;
    animation-delay: 7s;
}

.circles li:nth-child(8){
    left: 50%;
    width: 25px;
    height: 25px;
    animation-delay: 15s;
    animation-duration: 45s;
}

.circles li:nth-child(9){
    left: 20%;
    width: 15px;
    height: 15px;
    animation-delay: 2s;
    animation-duration: 35s;
}

.circles li:nth-child(10){
    left: 85%;
    width: 150px;
    height: 150px;
    animation-delay: 0s;
    animation-duration: 11s;
}
.card{
    z-index: 2;
}

.navbar{
    z-index: 2;
}
.card{
                box-shadow: 0 0 20px 2px rgba(0,0,0,.1);
                transition:0.7s;
            }
            .card:hover{
                transform:scale(1.1);
                z-index:2;
            }

            .section{
    z-index: 2;
}
.form{
    z-index: 2;
}
.form-floating{
    z-index: 2;
}
.btn{
    z-index: 2;
}
.d-grid{
    z-index: 2;
}

@keyframes animate {

    0%{
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }

    100%{
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }

}

        </style>

</head>
<body class="area">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-5">
                <a class="navbar-brand" href="Prof.php" style="font-size: 40px"><b>StudyBuddy</b></a>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                         <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">User Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="#!">Services</a></li> 
                    </ul>
                </div> -->
            </div>
            <!-- <a class="btn btn-primary btn-lg px-4 me-sm-3" href="AddAnnouncement.php">Announce Something</a> -->
        </nav>
<section class="py-5">
    <div class="container px-5 my-5 px-5">
        <div class="text-center mb-5">
            <h1 style="color: white">Mentor Discussion</h1><br>
            <div class="d-flex justify-content-end form-floating mb-3">
                <form class="d-flex justify-content-end form-floating mb-3" method="post" >
                    <select class="form-select" name="semester" id="semester" style="padding-top: 15px">
                        <option value="">Filter by Semesters</option>
                        <option value="1" <?php if ($semesterFilter == '1') echo 'selected'; ?>>Semester 1</option>
                        <option value="2" <?php if ($semesterFilter == '2') echo 'selected'; ?>>Semester 2</option>
                        <option value="3" <?php if ($semesterFilter == '3') echo 'selected'; ?>>Semester 3</option>
                        <option value="4" <?php if ($semesterFilter == '4') echo 'selected'; ?>>Semester 4</option>
                        <option value="5" <?php if ($semesterFilter == '5') echo 'selected'; ?>>Semester 5</option>
                        <option value="6" <?php if ($semesterFilter == '6') echo 'selected'; ?>>Semester 6</option>
                        <option value="7" <?php if ($semesterFilter == '7') echo 'selected'; ?>>Semester 7</option>
                        <option value="8" <?php if ($semesterFilter == '8') echo 'selected'; ?>>Semester 8</option>
                        <!-- Add more semester options as needed -->
                    </select>
                    <button  class="btn btn-primary btn-lg px-3 me-sm-2" type="submit" style="margin-left: 8px">Filter</button>
                </form>
            </div>
        </div>
        <div class="row gx-5 justify-content-center">
    <div class="col-lg-8">
        <?php if ($result->num_rows > 0) {
            while($row=mysqli_fetch_assoc($result)){ ?>
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <h4 class="mb-1"><?php echo $row['Doubt'];?></h4>
                        </div>
                        <div class="ms-4">
                            <p class="mb-1">
                                Doubt Name: <?php echo $row['D_Name'];?><br>
                                Semester: <?php echo $row['Semester'];?><br>
                                Subject: <?php echo $row['Subject'];?><br>
                                Doubt of: <?php
                                    $poster=$row['Poster_id'];
                                    $query2="SELECT * FROM student WHERE Rollno='$poster'";
                                    $result2=mysqli_query($conn,$query2);
                                    $row2=mysqli_fetch_array($result2);
                                    echo $row2['Name'] . " ID: " . $row['Poster_id'];?><br>
                            </p>
                            <div class=" d-flex justify-content-end">
                                <div class="mx-3">

                                    <form method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this discussion?');">
                                        <input type="hidden" name="delete" value="<?php echo $row['D_Id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-lg"><i class="bi bi-trash"></i> Delete</button>
                                    </form>
                                    <button class="btn btn-primary btn-lg"><a class="text-decoration-none" style="color:white" href="post.php?id=<?php echo $row['D_Id']; ?>">Answer</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } else {
            echo "<tr><td colspan='3'>No announcements found.</td></tr>";
        }
        ?>
    </div>
</div>

    </div>
</section>


        <br>
            
                
                
        
               
        <br>
        <table style="width:100%">
        
            
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    
</body>
<ul class="circles" >
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul>
</html>







