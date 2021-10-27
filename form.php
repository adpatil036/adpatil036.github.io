<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ab Reader</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


</head>
<style>
    body {
        font-family: fantasy
    }

    .wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10%;
        padding: 20px;
        width: 100%;
        flex-direction: column;
    }

    @media only screen and (min-width: 320px) and (max-width: 479px) {
        .wrapper {
            margin-top: 20%;
        }
    }

    @media only screen and (min-width: 480px) and (max-width: 767px) {
        .wrapper {
            margin-top: 20%;
        }
    }

    @media only screen and (min-width: 768px) and (max-width: 979px) {
        .wrapper {
            margin-top: 20%;
        }
    }
</style>
<script>
    function showCreateForm() {
        if (document.getElementById('createForm').style.display !== "none") {
            document.getElementById('createForm').style.display = "none";
        } else {
            document.getElementById('createForm').style.display = "block";
        }
        if (document.getElementById('user-search-results')) {
            document.getElementById('user-search-results').style.display = "none";
        }
        document.getElementById('searchForm').style.display = "none";
    }

    function showSearchForm() {
        if (document.getElementById('searchForm').style.display !== "none") {
            document.getElementById('searchForm').style.display = "none";
        } else {
            document.getElementById('searchForm').style.display = "block";
        }
        document.getElementById('createForm').style.display = "none";
    }

    function closePopup() {
        document.getElementById('popup').style.display = "none";
        window.location.href = './users.php';
    }
</script>

<body style="background: #F79489;">
    <!-- ======= Header ======= -->
    <div class="wrapper" style="">
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="popup" style="display: none">
            <strong>Success!</strong> User added successfully <button onclick="closePopup()" type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: transparent;border: none;">
                <span aria-hidden="true" style="line-height: 10px;font-size: 30px;">×</span>
            </button>
        </div>
        <div style="background:#fff;display: flex;align-items: center;border: 1px solid black;padding: 20px;width: 100%;height: 100%;flex-direction: column;">
            <button style="width: 100%;height: 60px;background: floralwhite;font-weight: bold;" onclick="showCreateForm()">Create New User</button>
            <div id="createForm" style="border: 1px solid black; width: 100%; display: none">
                <div class="container">
                    <h2 style="padding: 20px 0 0 0">Register User</h2>
                    <form id="register-form" class="form" method="post">
                        <div class="form-group" style="margin-bottom: 20px">
                            <label for="fname">First Name</label>
                            <input type="text" class="form-control" placeholder="Enter first name" name="fname" required="">
                        </div>
                        <div class="form-group" style="margin-bottom: 20px">
                            <label for="lname">Last Name</label>
                            <input type="text" class="form-control" placeholder="Enter last name" name="lname" required="">
                        </div>
                        <div class="form-group" style="margin-bottom: 20px">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" placeholder="Enter email" name="email" required="">
                        </div>
                        <div class="form-group" style="margin-bottom: 20px">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="5" name="address"></textarea>
                        </div>
                        <div class="form-group" style="margin-bottom: 20px">
                            <label for="homephone">Home Phone</label>
                            <input type="tel" class="form-control" placeholder="Enter home phone (Ex: 123-456-7890)" name="homephone" required="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>
                        <div class="form-group" style="margin-bottom: 20px">
                            <label for="cellphone">Cell Phone</label>
                            <input type="tel" class="form-control" placeholder="Enter cell phone (Ex: 123-456-7890)" name="cellphone" required="" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </div>
                        <input type="submit" name="create" value="create" style="margin-bottom: 2%;width: 30%;border-radius: 5px;height: 40px;background: darkseagreen;" />
                    </form>
                </div>
            </div>
            <button style="width: 100%;margin-top: 20px;height: 60px;background: floralwhite;font-weight: bold;" onclick="showSearchForm()">Search User</button>
            <div id="searchForm" style="border: 1px solid black; width: 100%; display: none">
                <div class="container">
                    <h1 style="padding: 20px 0 0 0">Search Form</h1>
                    <form id="search-form" class="form-inline" method="post">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" placeholder="Enter name" name="name" style="margin-bottom: 20px">
                        <label for="email">Email address</label>
                        <input type="text" class="form-control" placeholder="Enter email" name="searchemail" style="margin-bottom: 20px">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" placeholder="Enter phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" style="margin-bottom: 20px">
                        <input type="submit" name="search" value="search" style="margin-bottom: 2%;width: 30%;border-radius: 5px;height: 40px;background: darkseagreen;" />
                    </form>
                </div>
            </div>
            <?php
            $username = "phpmyadmin";
            $password = "Password@12345";
            $dbname = "defaultdb";
            try {

                $db = new PDO('mysql:host=127.0.0.1;dbname=' . $dbname . ';charset=utf8', $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            extract($_POST);
            if (isset($_POST['create'])) {
                $fname         = $_POST['fname'];
                $lname         = $_POST['lname'];
                $email             = $_POST['email'];
                $cellphone        = $_POST['cellphone'];
                $homephone         = $_POST['homephone'];
                $address    = $_POST['address'];


                $sql = "insert into users (fname,lname,email,cellphone,homephone,address) VALUES (UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?),UPPER(?))";
                $stmtinsert = $db->prepare($sql);
                $result = $stmtinsert->execute([$fname, $lname, $email, $cellphone, $homephone, $address]);
                if ($result) {
                    echo '<div style="color:green;"><h3>' . $fname . " " . $lname . ' : User Successfully saved.</h3></div>';
                } else {
                    echo 'There were errors while saving the data.';
                }
            } elseif (isset($_POST['search'])) {
                $firstname = $_POST['name'];
                $emailid = $_POST['searchemail'];
                $cellphoneVal = $_POST['phone'];

                $query = "Select * from users where fname like '$firstname' OR email like '$emailid' OR cellphone like '$cellphoneVal'";
                $result = mysqli_query($conn, $query);
                echo ">>> ", $result;
                if ($result->num_rows > 0) {
                    echo '<table id="user-search-results" cellspacing="0" cellpadding="1" border="1" width="300" class="table" style="table-layout:fixed;word-break: break-word;display: table; margin-top: 20px; width: 100%">';
                    echo '<thead style="border-bottom: 2px solid grey">';
                    echo '<tr>';
                    echo '<th scope="col">#</th>';
                    echo '<th scope="col">First Name</th>';
                    echo '<th scope="col">Last Name</th>';
                    echo '<th scope="col">Email</th>';
                    echo '<th scope="col">Address</th>';
                    echo '<th scope="col">Home Phone</th>';
                    echo '<th scope="col">Cell Phone</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody id="users-table-body">';
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id'];
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $email = $row['email'];
                        $address = $row['address'];
                        $cellphone = $row['cellphone'];
                        $homephone = $row['homephone'];
                        echo '<tr>';
                        echo "<td>$id</td>";
                        echo "<td>$fname</td>";
                        echo "<td>$lname</td>";
                        echo "<td>$email</td>";
                        echo "<td>$address</td>";
                        echo "<td>$cellphone</td>";
                        echo "<td>$homephone</td>";
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<table id="user-search-results" style="display: table; table-layout:fixed;word-break: break-word;margin-top: 20px; width: 100%">';
                    echo '<thead style="border-bottom: 2px solid grey">';
                    echo '<tr>';
                    echo '<th scope="col">#</th>';
                    echo '<th scope="col">First Name</th>';
                    echo '<th scope="col">Last Name</th>';
                    echo '<th scope="col">Email</th>';
                    echo '<th scope="col">Address</th>';
                    echo '<th scope="col">Home Phone</th>';
                    echo '<th scope="col">Cell Phone</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody id="users-table-body">';
                    echo '<tr>';
                    echo "<td colspan='7' style='text-align:center'>No data found</td>";
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>