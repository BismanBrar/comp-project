<?php
$cla = $_POST['cla'];
$sname = $_POST['sname'];
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$admno = $_POST['admo'];
$email = $_POST['email'];
$phno = $_POST['phno'];
$alphno = $_POST['alphno'];

if(!empty($cla) || !empty($sname) || !empty($fname) || !empty($mname) || 
!empty($admo) || !empty($email) || !empty($phno) )
{
    $host="BismanBrar";
    $dbUsername ="root";
    $dbPassword ="inayatsran";
    $dbName ="student_data";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
    if ($conn->connect_error) {
        die('Could not connect to the database.');
    }
    else {
        $Select = "SELECT admno FROM studentdata WHERE admno = ? LIMIT 1";
        $Insert = "INSERT INTO studentdata(cla,sname,fname,mname,admno,email,phno,alphno) values (?,?,?,?,?,?,?,?)";

        $stmt = $conn->prepare($Select);
            $stmt->bind_param("i", $admno);
            $stmt->execute();
            $stmt->bind_result($resultadmno);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("isssisii",$cla,$sname,$fname,$mname,$admno,$email,$phno,$alphno);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Student data already available.";
            }
            $stmt->close();
            $conn->close();
        }
    }
else{
    echo "ALL FIELD ARE REQUIRED";
    die();
}
?>