<!DOCTYPE HTML>
<html>
<head>
 
    <style>
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
            width: 80px;
            display: inline-block;
            height: 30px;
        }

        .input {
            float: left;
            width: 220px;
            display: inline-block;
            height: 30px;
        }

        select option {
            width: 160px;
        }

        input {
            width: 180px;
        }
    </style>
</head>
<body>

    <?php
    // define variables and set to empty values
    $from = $fromErr = $fromPostCodeErr = $fromProvince = $fromPostCode = $fromProvinceErr = $to = $toErr = $toPostCodeErr = $toProvince = $toProvinceErr = $toPostCode = $weight = $weightErr = $width = $widthErr = $height = $heightErr = $depth = $depthErr = "";
    $show = true;
    $showResult = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["from"])) {
            $fromErr = "Address is required";
            $show = false;
        } else {
            $from = test_input($_POST["from"]);
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $from)) {
                $fromErr = "Only letter, number, space are allowed";
                $show = false;
            }
        }
        if (empty($_POST["fromProvince"])) {
            $fromProvinceErr = "Please choose a province";
            $show = false;
        } else {
            $fromProvince = test_input($_POST["fromProvince"]);
            if (!preg_match("/[a-zA-Z][a-zA-Z]/", $fromProvince)) {
                $fromProvinceErr = "error";
                $show = false;
            }
        }
        if (empty($_POST["fromPostCode"])) {
            $fromPostCodeErr = "Post code is required";
            $show = false;
        } else {
            $fromPostCode = test_input($_POST["fromPostCode"]);
            if (!preg_match("/[a-zA-Z][0-9][a-zA-Z][0-9][a-zA-Z][0-9]/", $fromPostCode)) {
                $fromPostCodeErr = "Invalid post code";
                $show = false;
            }
        }
        if (empty($_POST["to"])) {
            $toErr = "Address is required";
            $show = false;
        } else {
            $to = test_input($_POST["to"]);
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $to)) {
                $toErr = "Only letter, number, space are allowed";
                $show = false;
            }
        }
        if (empty($_POST["toProvince"])) {
            $toProvinceErr = "Please choose a province";
            $show = false;
        } else {
            $toProvince = test_input($_POST["toProvince"]);
            if (!preg_match("/[a-zA-Z][a-zA-Z]/", $toProvince)) {
                $toProvinceErr = "error";
                $show = false;
            }
        }
        if (empty($_POST["toPostCode"])) {
            $toPostCodeErr = "post code is required";
            $show = false;
        } else {
            $toPostCode = test_input($_POST["toPostCode"]);
            if (!preg_match("/[a-zA-Z][0-9][a-zA-Z][0-9][a-zA-Z][0-9]/", $toPostCode)) {
                $toPostCodeErr = "Invalid post code";
                $show = false;
            }
        }
        if (empty($_POST["weight"])) {
            $weightErr = "Please input weight";
            $show = false;
        } else {
            $weight = test_input($_POST["weight"]);
            if (!preg_match("/[0-9]{1,3}/", $weight)) {
                $weightErr = "Invalid number";
                $show = false;
            }
            if (0 == (int)$weight || (int)$weight > 50) {
                $weightErr = "The weight should between 1kg - 50kg";
                $show = false;
            }
        }
        if (empty($_POST["width"])) {
            $widthErr = "Please input height";
            $show = false;
        } else {
            $width = test_input($_POST["width"]);
            if (!preg_match("/[0-9]{1,3}/", $width)) {
                $widthErr = "Invalid number";
                $show = false;
            }
            if (0 == (int)$width || (int)$width > 150) {
                $widthErr = "The size should between 1cm - 150cm";
                $show = false;
            }
        }
        if (empty($_POST["height"])) {
            $heightErr = "Please input height";
            $show = false;
        } else {
            $height = test_input($_POST["height"]);
            if (!preg_match("/[0-9]{1,3}/", $height)) {
                $heightErr = "Invalid number";
                $show = false;
            }
            if (0 == (int)$height || (int)$height > 150) {
                $heightErr = "The size should between 1cm - 150cm";
                $show = false;
            }
        }
        if (empty($_POST["depth"])) {
            $depthErr = "Please input height";
            $show = false;
        } else {
            $depth = test_input($_POST["depth"]);
            if (!preg_match("/[0-9]{1,3}/", $depth)) {
                $depthErr = "Invalid number";
                $show = false;
            }
            if (0 == (int)$depth || (int)$depth > 150) {
                $depthErr = "The size should between 1cm - 150cm";
                $show = false;
            }
        }

        $showResult = $show;
    }
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>

    <div style="width:400px; float:left;">
        <h2>Shipping Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form">
                <fieldset>
                    <legend>From</legend>
                    <div class="form">
                        <span class="label">Address : </span>
                        <span class="input"><input type="text" name="from"
                                                   value="<?php if (!$show) echo $from; ?>"></span>
                    </div>
                    <div><span class="error"><?php echo $fromErr; ?></span></div>

                    <div class="form">
                        <span class="label">Province: </span>
							<span class="input">
								<select name="fromProvince">
                                    <option value="">Select...</option>
                                    <option value="AB" <?php if (!$show && $fromProvince == "AB") echo "selected"; ?>>
                                        Alberta
                                    </option>
                                    <option value="BC" <?php if (!$show && $fromProvince == "BC") echo "selected"; ?>>
                                        British Columbia
                                    </option>
                                    <option value="MB" <?php if (!$show && $fromProvince == "MB") echo "selected"; ?>>
                                        Manitoba
                                    </option>
                                    <option value="NB" <?php if (!$show && $fromProvince == "NB") echo "selected"; ?>>
                                        New Brunswick
                                    </option>
                                    <option value="NL" <?php if (!$show && $fromProvince == "NL") echo "selected"; ?>>
                                        Newfoundland and Labrador
                                    </option>
                                    <option value="NS" <?php if (!$show && $fromProvince == "NS") echo "selected"; ?>>
                                        Nova Scotia
                                    </option>
                                    <option value="ON" <?php if (!$show && $fromProvince == "ON") echo "selected"; ?>>
                                        Ontario
                                    </option>
                                    <option value="PE" <?php if (!$show && $fromProvince == "PE") echo "selected"; ?>>
                                        Prince Edward Island
                                    </option>
                                    <option value="QC" <?php if (!$show && $fromProvince == "QC") echo "selected"; ?>>
                                        Quebec
                                    </option>
                                    <option value="SK" <?php if (!$show && $fromProvince == "SK") echo "selected"; ?>>
                                        Saskatchewan
                                    </option>
                                    <option value="NT" <?php if (!$show && $fromProvince == "NT") echo "selected"; ?>>
                                        Northwest Territories
                                    </option>
                                    <option value="NU" <?php if (!$show && $fromProvince == "NU") echo "selected"; ?>>
                                        Nunavut
                                    </option>
                                    <option value="YT" <?php if (!$show && $fromProvince == "YT") echo "selected"; ?>>
                                        Yukon
                                    </option>
                                </select>
							</span>
                    </div>
                    <div><span class="error"><?php echo $fromProvinceErr; ?></span></div>

                    <div class="form">
                        <span class="label">PostCode: </span>
                    <span class="input"><input type="text" name="fromPostCode"
                                               value="<?php if (!$show) echo $fromPostCode; ?>"></span>
                    </div>
                    <div><span class="error"><?php echo $fromPostCodeErr; ?></span></div>
                </fieldset>

                <fieldset>
                    <legend>To</legend>
                    <div class="form">
                        <span class="label">Address: </span>
                        <span class="input"><input type="text" name="to" value="<?php if (!$show) echo $to; ?>"></span>
                    </div>
                    <div><span class="error"><?php echo $toErr; ?></span></div>

                    <div class="form">
                        <span class="label">Province: </span>
							<span class="input">
								<select name="toProvince">
                                    <option value="">Select...</option>
                                    <option value="AB" <?php if (!$show && $toProvince == "AB") echo "selected"; ?>>
                                        Alberta
                                    </option>
                                    <option value="BC" <?php if (!$show && $toProvince == "BC") echo "selected"; ?>>
                                        British Columbia
                                    </option>
                                    <option value="MB" <?php if (!$show && $toProvince == "MB") echo "selected"; ?>>
                                        Manitoba
                                    </option>
                                    <option value="NB" <?php if (!$show && $toProvince == "NB") echo "selected"; ?>>New
                                        Brunswick
                                    </option>
                                    <option value="NL" <?php if (!$show && $toProvince == "NL") echo "selected"; ?>>
                                        Newfoundland and Labrador
                                    </option>
                                    <option value="NS" <?php if (!$show && $toProvince == "NS") echo "selected"; ?>>Nova
                                        Scotia
                                    </option>
                                    <option value="ON" <?php if (!$show && $toProvince == "ON") echo "selected"; ?>>
                                        Ontario
                                    </option>
                                    <option value="PE" <?php if (!$show && $toProvince == "PE") echo "selected"; ?>>
                                        Prince Edward Island
                                    </option>
                                    <option value="QC" <?php if (!$show && $toProvince == "QC") echo "selected"; ?>>
                                        Quebec
                                    </option>
                                    <option value="SK" <?php if (!$show && $toProvince == "SK") echo "selected"; ?>>
                                        Saskatchewan
                                    </option>
                                    <option value="NT" <?php if (!$show && $toProvince == "NT") echo "selected"; ?>>
                                        Northwest Territories
                                    </option>
                                    <option value="NU" <?php if (!$show && $toProvince == "NU") echo "selected"; ?>>
                                        Nunavut
                                    </option>
                                    <option value="YT" <?php if (!$show && $toProvince == "YT") echo "selected"; ?>>
                                        Yukon
                                    </option>
                                </select>
							</span>
                    </div>
                    <div><span class="error"><?php echo $toProvinceErr; ?></span></div>

                    <div class="form">
                        <span class="label">PostCode: </span>
                        <span class="input"><input type="text" name="toPostCode"
                                                   value="<?php if (!$show) echo $toPostCode; ?>"></span>
                    </div>
                    <div><span class="error"><?php echo $toPostCodeErr; ?></span></div>
                </fieldset>

                <fieldset>
                    <legend>Package</legend>
                    <div class="form">
                        <span class="label">weight:</span>
                        <span class="input"><input type="text" name="weight" value="<?php if (!$show) echo $weight; ?>">kg</span>
                    </div>
                    <div><span class="error"><?php echo $weightErr; ?></span></div>

                    <div class="form">
                        <span class="label">width:</span>
                        <span class="input"><input type="text" name="width" value="<?php if (!$show) echo $width; ?>">cm</span>
                    </div>
                    <div><span class="error"><?php echo $widthErr; ?></span></div>

                    <div class="form">
                        <span class="label">height:</span>
                        <span class="input"><input type="text" name="height" value="<?php if (!$show) echo $height; ?>">cm</span>
                    </div>
                    <div><span class="error"><?php echo $heightErr; ?></span></div>

                    <div class="form">
                        <span class="label">depth:</span>
                        <span class="input"><input type="text" name="depth" value="<?php if (!$show) echo $depth; ?>">cm</span>
                    </div>
                    <div><span class="error"><?php echo $depthErr; ?></span></div>
                </fieldset>
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
    </div>

    <?php
    if ($showResult) {
        echo "<div class='form'>";
        echo "<h2>Package Info:</h2>";
        echo "Send From:";
        echo "<br>";
        echo $from;
        echo ", ";
        echo $fromProvince;
        echo ", ";
        echo $fromPostCode;
        echo "<br>";
        echo "<br>";
        echo "Send To:";
        echo "<br>";
        echo $to;
        echo ", ";
        echo $toProvince;
        echo ", ";
        echo $toPostCode;
        echo "<br>";
        echo "<br>";
        echo "Package Info:";
        echo "<br>";
        echo "Weight: ";
        echo $weight;
        echo ", ";
        echo $width;
        echo "cm x ";
        echo $height;
        echo "cm x ";
        echo $depth;
        echo "cm";
        echo "</div>";
    }
    ?>

</body>
</html>
