<?php
   session_start();
?>
<!DOCTYPE html>
<html>
<head>

<style>

        body{
                background-color: #ffccff;
        }

        table{
                text-align: center;
                background-color: #ffb3ff;
        }

        a{
                text-decoration: none;
                font-family: Cursive, serif;
                font-weight: bold;
                font-size: 18pt;
                color: #eb2d53
        }



        h1{
                font-size: 18pt;
                font-family: "Comic Sans MS", cursive, sans-serif;
                color: #cc0066;
        }



</style>

        <title>Groomer Page</title>

</head>
<body>
        <?php
                session_start();
                $USERNAME = $_SESSION['USERNAME'];


   echo '<table width= 100%>';

         echo '<tr>';
               echo "<td><a class='vlink' href='?AddTimeSlot'>Add Timeslot</a></td>";
               echo "<td><a class='Llink' href='?ListSlots'>List All TimeSlots</a></td>";
               echo "<td><a class='viewLink' href='?ViewSchedule'>View My Schedule</a></td>";
        echo '</tr>';
echo '</table><br>';

echo '<div align="right">';
        echo '<a href="GradAssignment.php" style="font-family: serif; color: black; font-weight: bold; background-color: #ffb3ff;">LOGOUT</a>';
echo '</div> <br><br>';

        echo "<h1>Welcome!</h1>";

  $dsn = 'mysql:host=courses;dbname=z1779093';
  $username = 'z1779093';
  $password = '1993Aug03';
  $conn = new PDO($dsn,$username,$password);


if(isset($_GET["AddTimeSlot"]))
{
  echo '<form method ="post" action= "GroomerPage.php">';
  echo '<div align="left">';
  echo '<table border ="1" width ="400">';
  echo '<tr>';
  echo '<td align="left">';
  echo 'Date ';
  echo '<select name=day  id = day>';
  echo '<option> Day  </option>';
  $day = array("01","02","03","04","05","06","07","08","09",10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
  foreach($day as $dayVal)
    {
      echo "<option value=$dayVal>".$dayVal."</option>";
    }
  echo '</select>';


  echo '<select name=month id = month>';
  echo '<option> Month  </option>';
  $month = array("01","02","03","04","05","06","07","08","09","10","11","12");
  foreach($month as $monthVal)
    {
      echo "<option value=$monthVal>".$monthVal."</option>";
    }

   echo '</select>';


   echo '<select name= year id=year>';
   echo '<option> Year  </option>';
   $year = array(2014,2015,2016,2017,2018,2019,2020);
   foreach($year as $yearVal)
    {
      echo "<option value=$yearVal>".$yearVal."</option>";
    }

   echo '</select> <br><br>';
   echo 'Start Time ';
   echo 'HH: <input type="text" name ="hour" id="hour" size="2">';
   echo 'MM: <input type="text" name ="minute" id="minute" size = "2">';
   echo 'SS: <input type="text" name ="second" id="second" size ="2">  ';
   echo '</select> <br><br>';
   echo '<input type="submit" name="SelectValue" value="ADD"/>';
   echo '</td>';
   echo '</tr>';
   echo '</table>';
   echo '</div>';
   echo '</form>';

}

if(isset($_POST['SelectValue']))
{
  $day= $_POST['day'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $hour = $_POST['hour'];
  $minute = $_POST['minute'];
  $second = $_POST['second'];

 if($month == "February")
  {
    if(($year %4 ==0 && $year %100 !=0) ||($year %400)== 0)
    {
      $day = 29;
    }
    else
    {
     $day = 28;
    }

    echo 'Resetting date value to format YYYY-MM-DD : '.$year.'-'.$month.'-'.$day;
  }
 $date = $year.'-'.$month.'-'.$day;
 $time1 = $hour.':'.$minute.':'.$second;
 $new = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;
  if($date !='Year-Month-Day' &&  $time1 !='::')
    {
     $sql = 'insert into Timeslot(slot_time) values (?)';
     try
      {
        $stmt = $conn-> prepare($sql);
        $stmt -> execute(array($new));
        echo 'Time Slot Added Successfully';
      }
     catch(PDOException $e)
      {
       echo 'Error!! '.$e->getMessage();
      }

     }

  else
   echo 'Please provide Proper date and time details to be added.';

}

if(isset($_GET['ListSlots']))
{
  $sql = 'SELECT SlotId, date_format(slot_time,"%m-%d-%Y %h:%i %p") AS slot_time  FROM Timeslot order by  slot_time';
   $q = $conn->query($sql) or die("ERROR: " . implode(":", $conn->errorInfo()));
   $count = $q->rowCount();

   if($count >0)
      {
         echo "<div align='left'>";
         echo "<table border='1' width='300'>
               <tr>
                     <th> Slot Time </th>
                     <th> </th>
               </tr>";
      }

    while ($row=$q->fetch(PDO::FETCH_ASSOC))
      {
          echo "<tr><td>".$row['slot_time']."</td><td> <a href=\"GroomerPage.php?id=".$row['SlotId']."\"> Delete </a></td></tr>";
      }
    echo "</table>";
    echo "</div>";
}

if(isset($_GET['id']))
{
   $id = $_GET['id'];
   $sql = "delete from Timeslot where SlotId ='".$id."'";
    try
      {
        $stmt = $conn-> prepare($sql);
        $stmt -> execute(array($id));
        echo 'Time Slot Deleted  Successfully';
      }
     catch(PDOException $e)
      {
       echo 'No Timeslot found';
      }
}


if(isset($_GET['ViewSchedule']))
{
   $sql = 'SELECT date_format(appDate,"%Y-%m-%d") as AppDate , start_time, Custname, petName, petBreed from Appointment a, Customer c,Pet p where
           a.PetId=p.PetId and p.CustId = c.CustId and DATE(AppDate) >= DATE(now()) order by AppDate, start_time';
   $q = $conn->query($sql) or die("ERROR: " . implode(":", $conn->errorInfo()));
   $count = $q->rowCount();

   if($count >0)
      {
         echo "<div align='left'>";
         echo "<table border='1' width='800'>
               <tr>
                     <th> Appointment Date </th>
                     <th> Start Time </th>
                     <th> Customer Name</th>
                     <th> Pet Name </th>
                     <th> Pet Breed </th>
               </tr>";
      }
   else
     echo "No upcoming Appointment Found";

  while ($row=$q->fetch(PDO::FETCH_ASSOC))
   {
     echo "<tr><td>".$row['AppDate']."</td><td>".$row['start_time']."</td><td>".$row['Custname']."</td><td>".$row['petName']."</td><td>".$row['petBreed']."</td></tr>";
   }
    echo "</table>";
    echo "</div>";


}


?>
</body>
</html>