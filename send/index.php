<?php 

include '../includes/db.inc.php';
include '../includes/functions.inc.php';

try
{
  $result = $pdo->query('SELECT id, startdate, lessons_sent FROM _cycle_ WHERE active = 1');
}
catch (PDOException $e)
{
  $error = 'Error fetching cycles.';
  include 'errorPage.html.php';
  exit();
}

$cycles = array();

foreach ($result as $row)
{
  $cycles[] = array('id' => $row['id'], 'startdate' => $row['startdate'], 'lessons_sent' => $row['lessons_sent']);
}

if ( isset($_GET['sendnow']) ){
  if ($cycles){
    foreach ($cycles as $cycle)
    {
      $students = get_students($cycle['id']);
      $lesson_to_send = ($cycle['lessons_sent']+1);
      $folder = LESSONSPATH.LESSONFOLDER.$lesson_to_send;
      echo '<pre>';
      echo "Cycle {$cycle['id']}, Lesson: {$lesson_to_send}";
      echo "<br />";
      if ($students){
        
        require '../includes/smtp.php';
        $mail->SMTPKeepAlive = true;
        $mail->Subject = COURSE_NAME.' '.LESSONFOLDER.' '.$lesson_to_send;
        $mail->msgHTML("test");
        $mail->AltBody = 'This is a plain-text message body';
        

        foreach ($students as $student)
        {
          echo $student['name'].', '.$student['email'].' <br />Send lesson No.'.$lesson_to_send.'<br />';
          
          $mail->addAddress($student['email'], $student['name']);
          
          foreach (glob( "{$folder}/*.*") as $filename) {
            echo "Attaching $filename <br />";
            $mail->addAttachment($filename);
            }
            echo "Sending...<br />";
            if (!$mail->send()) {
              echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
              echo "Message sent!<br />";
              update_lessons_received_for_student($student['id'], $lesson_to_send);
            }
            $mail->clearAddresses();
            $mail->clearAttachments();
        }

        unset($students);
        update_cycle_info($cycle['id'], $lesson_to_send);
      }
      echo '</pre>';
    }
  }
  echo "<p><a href='..'>Return to home</a></p>";
}
else{

  if ($cycles){
    foreach ($cycles as $cycle)
    {
      $students = get_students($cycle['id']);
      $lesson_to_send = ($cycle['lessons_sent']+1);
      $folder = LESSONSPATH.LESSONFOLDER.$lesson_to_send;
      echo "<pre>"; 
      echo "For cycle {$cycle['id']} the next due lesson is {$lesson_to_send}.";
      echo "<br /><pre>";
    }
    ?>
    <form action="?sendnow" method="post">
      <div>
        <input type="submit" value="Send Now">
      </div>
    </form>
    <p><a href="..">Return to home</a></p>
    <?php 
  }
}
