<?php
include_once '../includes/magicquotes.inc.php';

if (isset($_GET['add']))
{
  include '../includes/db.inc.php';
  include '../includes/functions.inc.php';
  
  //Get last student ID
  try
  {
    $sql = 'SELECT id FROM student ORDER BY id DESC LIMIT 1';
    $s = $pdo->prepare($sql);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching last student ID.';
    include 'errorPage.html.php';
    exit();
  }

  $row = $s->fetch();


  //Get active Cycles
  $active_cycles = get_active_cycles();
  
  $pageTitle = 'New Student';
  $action = 'addform';
  $name = '';
  $email = '';
  $id = $row['id']+1;
  $cycle_id = $active_cycles[0];  //We preselect the latest cycle
  $button = 'Add student';

  include 'form.html.php';
  exit();
}

if (isset($_GET['multiadd']))
{
  include '../includes/functions.inc.php';
  
  //Get active Cycles
  $active_cycles = get_active_cycles();
  
  $pageTitle = 'New Students';
  $action = 'multiaddform';
  $name = '';
  $email = '';
  $id = '';
  if ($active_cycles){
    $cycle_id = $active_cycles[0];  //We preselect the latest cycle if there are active cycles
  }
  else{
    $cycle_id='';
  }
  
  $button = 'Add students';

  include 'multiform.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include '../includes/db.inc.php';

  //Add new student to the database
  try
  {
    $sql = 'INSERT INTO student SET
        name = :name,
        email = :email,
        id = :id,
        date_added = CURDATE(),
        cycle_id = :cycle_id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':cycle_id', $_POST['cycle_id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted student.';
    include 'errorPage.html.php';
    exit();
  }
  
  //Get lessons to be sent
  try
  {
    $sql = 'SELECT lessons_sent FROM _cycle_ WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['cycle_id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching lessons sent.';
    include 'errorPage.html.php';
    exit();
  }

  $row = $s->fetch();
  $lessons_sent = $row['lessons_sent'];

  include 'added.html.php';
  exit();
}

if (isset($_GET['multiaddform']))
{
  include '../includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO student SET
        email = :email,
        date_added = CURDATE(),
        cycle_id = :cycle_id';
    $s = $pdo->prepare($sql);
    $emails = explode("\n", str_replace("\r", "", $_POST['emails']));  //Some systems post \r\n for new line so we always sort it to \n
    foreach($emails as $email)
    {
      $s->bindValue(':email', $email);
      $s->bindValue(':cycle_id', $_POST['cycle_id']);
      $s->execute();
    }
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted student.';
    include 'errorPage.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

if ( isset($_POST['action']) and $_POST['action'] == 'sendpastlessons' and isset($_POST['id'], $_POST['name'], $_POST['email'], $_POST['num_of_lessons']) )
{

  include_once '../includes/functions.inc.php';
  require '../includes/smtp.php';

  $mail->addAddress($_POST['email'], $_POST['name']);
  $mail->Subject = 'Welcome to the course';
  $mail->msgHTML("test");
  $mail->AltBody = 'This is a plain-text message body';


  for ($i = 0; $i <= $_POST['num_of_lessons']; $i++) {
    $folder = LESSONSPATH.LESSONFOLDER.$i;
    foreach (glob( "{$folder}/*.*") as $filename) {
      echo "Attaching $filename <br />";
      $mail->addAttachment($filename);
    }
  }
  echo "Sending...<br />";
  if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Message sent!";
    update_lessons_received_for_student($_POST['id'], $_POST['num_of_lessons']);
  }
  
  echo "<p><a href='.'>Return to students</a></p>";
  exit();
}

if ( isset($_POST['action']) and $_POST['action'] == 'Edit' )
{
  include '../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, name, email, cycle_id FROM student WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching student details.';
    include 'errorPage.html.php';
    exit();
  }
  
  $row = $s->fetch();
  
  try
  {
    $result = $pdo->query('SELECT id FROM _cycle_ WHERE active = 1 ORDER BY id DESC');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching available cycles.';
    include 'errorPage.html.php';
    exit();
  }
  
  foreach ($result as $row2)
  {
    $available_cycles[] = $row2['id'];
  }
  
  $pageTitle = 'Edit Student';
  $action = 'editform';
  $name = $row['name'];
  $email = $row['email'];
  $cycle_id = $row['cycle_id'];
  $id = $row['id'];
  $button = 'Update student';

  include 'form.html.php';
  exit();
}

if (isset($_GET['editform']))
{
  include '../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE student SET
        name = :name,
        email = :email,
        cycle_id = :cycle_id
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':name', $_POST['name']);
    $s->bindValue(':email', $_POST['email']);
    $s->bindValue(':cycle_id', $_POST['cycle_id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted student.';
    include 'errorPage.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../includes/db.inc.php';

  // Delete the student
  try
  {
    $sql = 'DELETE FROM student WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting student.';
    include 'errorPage.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

if (isset($_GET['cycle']))
{
  include '../includes/functions.inc.php';
  
  $cycles = get_cycles();
  $students = get_students($_GET['cycle']);

  include 'students.html.php';
  
  exit();
}


// Default: display all students
include '../includes/functions.inc.php';

$cycles = get_cycles();
$students = get_students('all');

include 'students.html.php';
