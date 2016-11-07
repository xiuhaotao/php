<!DOCTYPE HTML>
<html>
<head>
    <style>
        div.left {
            float: left;
            width: 400px;
        }

        div.right {
            float: left;
            width: 800px;
        }

        div.form {
            float: left;
            width: 300px;
        }

        .error {
            float: left;
            width: 300px;
            color: red;
        }

        .label {
            float: left;
            width: 100px;
            display: inline-block;
            height: 30px;
        }

        .input {
            float: left;
            width: 200px;
            display: inline-block;
            height: 30px;
        }

        select option {
            width: 160px;
        }

        input {
            width: 180px;
        }

        table {
            border-collapse: collapse;
        }

        table tr td {
            padding: 5px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php
$servername = "localhost";
$username = "mydb";
$password = "mydb";
$dbname = "mydb";

$firstName = "";
$firstNameErr = "";
$lastName = "";
$lastNameErr = "";
$department = "";
$departmentErr = "";
$hireDate = "";
$hireDateErr = "";
$result = "";
$keyword = "";
$keywordErr = "";
$show = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        if ("Add" == $_POST["req"]) {
            if (empty($_POST["firstName"])) {
                $firstNameErr = "First name is required";
                $show = false;
            } else {
                $firstName = test_input($_POST["firstName"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
                    $firstNameErr = "Only letter, space are allowed";
                    $show = false;
                }
            }

            if (empty($_POST["lastName"])) {
                $lastNameErr = "Last name is required";
                $show = false;
            } else {
                $lastName = test_input($_POST["lastName"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
                    $lastNameErr = "Only letter, space are allowed";
                    $show = false;
                }
            }

            if (empty($_POST["department"])) {
                $departmentErr = "Please choose a department";
                $show = false;
            } else {
                $department = test_input($_POST["department"]);
                if (!preg_match("/[Act, Mkt, Sal, Shp, Exe]/", $department)) {
                    $departmentErr = "Undefined department";
                    $show = false;
                }
            }

            if (empty($_POST["hireDate"])) {
                $hireDateErr = "Hire date is required";
                $show = false;
            } else {
                $hireDate = test_input($_POST["hireDate"]);
                if (!preg_match("/[1-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]/", $hireDate)) {
                    $hireDateErr = "Date format as YYYY-MM-DD";
                    $show = false;
                } else if (!strtotime($hireDate)) {
                    $hireDateErr = "Invalid date, please try again";
                    $show = false;
                } else if (strtotime($hireDate) > strtotime("now")) {
                    $hireDateErr = "The hire date can not in future";
                    $show = false;
                }
            }

            if ($show) {
                $stmt = $conn->prepare("INSERT INTO employees (first_name, last_name, dept_code, hire_date) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $firstName, $lastName, $department, $hireDate);
                $stmt->execute();
                $stmt->close();
                $conn->close();

                date_default_timezone_set('Canada/Eastern');
                $result = "<h3>Thank you! <br> the new employee is added to database<br>" . date('Y-m-d', time()) . "</h3>";
            }
        }
        if ("Search" == $_POST["req"]) {
            $stmt = $conn->prepare("SELECT * FROM employees WHERE first_name LIKE ? OR last_name LIKE ? OR dept_code LIKE ? OR hire_date = ?");

            $keyword = $_POST['keyword'];
            $likeKeyword = "%{$_POST['keyword']}%";
            $stmt->bind_param("ssss", $likeKeyword, $likeKeyword, $likeKeyword, $keyword);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id,$fname,$lname,$dept,$hire,$credit,$phone);
            if ($stmt->num_rows > 0) {
                $result .= "<table>";
                $result .= "<tr><td>ID</td><td>Name</td><td>Department</td><td>Hire Date</td><td>Credit</td><td>Ext</td><td>Email</td></tr>";
                while ($stmt->fetch()) {
                    $result .= "<tr><td>" . $id . "</td><td>" . $fname . " " . $lname . "</td><td>" . $dept . "</td><td>"  . $hire . "</td><td>"  . $credit . "</td><td>"  . $phone . "</td><td><a href='mailto:" . $fname . "_" . $lname . "@localhost.com'>" . $fname . "_" . $lname . "@localhost.com</a></td></tr>";
                }
                $result .= "</table>";
            } else {
                $result = "0 results";
            }
            $stmt->close();
            $conn->close();
        }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<br><br>
<div>
    <div class="left">
        <div class="form">
            <fieldset>
                <legend>Add</legend>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="req" value="Add">
                    <div class="form">
                        <span class="label">First name: </span>
                <span class="input"><input type="text" name="firstName"
                                           value="<?php if (!$show) echo $firstName; ?>"></span>
                    </div>
                    <div class="form">
                        <span class="error"><?php echo $firstNameErr; ?></span>
                    </div>

                    <div class="form">
                        <span class="label">Last name: </span>
                <span class="input"><input type="text" name="lastName"
                                           value="<?php if (!$show) echo $lastName; ?>"></span>
                    </div>
                    <div class="form">
                        <span class="error"><?php echo $lastNameErr; ?></span>
                    </div>

                    <div class="form">
                        <span class="label">Department: </span>
            <span class="input">
                <select name="department">
                    <option value="">Select...</option>
                    <option value="Act" <?php if (!$show && $department == "Act") echo "selected"; ?>>
                        Accounting
                    </option>
                    <option value="Mkt" <?php if (!$show && $department == "Mkt") echo "selected"; ?>>
                        Marketing
                    </option>
                    <option value="Sal" <?php if (!$show && $department == "Sal") echo "selected"; ?>>
                        Sales
                    </option>
                    <option value="Shp" <?php if (!$show && $department == "Shp") echo "selected"; ?>>
                        Shipping
                    </option>
                    <option value="Exe" <?php if (!$show && $department == "Exe") echo "selected"; ?>>
                        Executive
                    </option>
                </select>
            </span>
                    </div>
                    <div class="form">
                        <span class="error"><?php echo $departmentErr; ?></span>
                    </div>

                    <div class="form">
                        <span class="label">Date of hire: </span>
                <span class="input"><input type="text" name="hireDate"
                                           value="<?php if (!$show) echo $hireDate; ?>"></span>
                    </div>
                    <div class="form">
                        <span class="error"><?php echo $hireDateErr; ?></span>
                    </div>
                    <input style="width:80px;" type="submit" name="submit" value="Insert">
                </form>
            </fieldset>
            <br><br>
            <fieldset>
                <legend>Search</legend>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="req" value="Search">
                    <div class="form">
                        <span class="label">Keyword: </span>
                        <span class="input"><input type="text" name="keyword"
                                           value="<?php if (!$show) echo $keyword; ?>"></span>
                    </div>
                    <div class="form">
                        <span class="error"><?php echo $keywordErr; ?></span>
                    </div>
                    <input style="width:80px;" type="submit" name="submit" value="search">
                </form>
            </fieldset>
        </div>
    </div>

    <div class="right">
        <?php
        echo $result;
        ?>
    </div>
</div>
</body>
</html>
