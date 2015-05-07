<?php
function html($text)
{
  return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
  echo html($text);
}


function update_lessons_received_for_student($id, $num_of_lessons){
  include 'db.inc.php';
  try
    {
    $sql = 'UPDATE student SET
      lessons_received = :lessons_received
      WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':lessons_received', $num_of_lessons);
    $s->bindValue(':id', $id);
    $s->execute();
    }
  catch (PDOException $e)
    {
    $error = 'Error updating lessons received for this student.';
    include 'errorPage.html.php';
    exit();
    }
}

function update_cycle_info($id, $lessons_sent){
  include 'db.inc.php';
  try
    {
    $sql = 'UPDATE _cycle_ SET
      lessons_sent = :lessons_sent
      WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':lessons_sent', $lessons_sent);
    $s->bindValue(':id', $id);
    $s->execute();
    }
  catch (PDOException $e)
    {
    $error = 'Error updating lessons sent for this cycle.';
    include 'errorPage.html.php';
    exit();
    }
    
  if ($lessons_sent == MAX_LESSONS){
  try
    {
    $sql = 'UPDATE _cycle_ SET
      active = 0
      WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $id);
    $s->execute();
    }
  catch (PDOException $e)
    {
    $error = 'Error deactivating the cycle.';
    include 'errorPage.html.php';
    exit();
    }
  }
}



function get_students($cycle_id){
  include 'db.inc.php';
  try
  {
    if ($cycle_id == 'all'){
      $result = $pdo->query('SELECT id, name, email, cycle_id, lessons_received, date_added FROM student');
    }
    else {
      $sql = 'SELECT id, name, email, cycle_id, lessons_received, date_added FROM student WHERE cycle_id = :cycle_id';
      $result = $pdo->prepare($sql);
      $result->bindValue(':cycle_id', $cycle_id);
      $result->execute();
    }
  }

  catch (PDOException $e)
  {
    $error = 'Error fetching students from the database!';
    include 'errorPage.html.php';
    exit();
  }
  

  $students = array();

  foreach ($result as $row)
  {
    $students[] = array('id' => $row['id'], 'name' => $row['name'], 'email' => $row['email'], 'cycle_id' => $row['cycle_id'], 'lessons_received' => $row['lessons_received'], 'date_added' => $row['date_added']);
  }

  return $students;
}



function get_cycles(){
  include 'db.inc.php';
  try
  {
    $result = $pdo->query('SELECT id, active FROM _cycle_');
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
    $cycles[] = array('id' => $row['id'], 'active' => $row['active']);
  }
  return $cycles;
}


function get_active_cycles(){
  include 'db.inc.php';
  try
  {
    $result = $pdo->query('SELECT id FROM _cycle_ WHERE active = 1 ORDER BY id DESC');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching cycles.';
    include 'errorPage.html.php';
    exit();
  }

  $active_cycles = array();
  
  foreach ($result as $row)
  {
    $active_cycles[] = $row['id'];
  }
  return $active_cycles;
}