<?php
include_once '../includes/magicquotes.inc.php';

if (isset($_GET['add']))
{
  $pageTitle = 'New Cycle';
  $action = 'addform';
  $startdate = '';
  $id = '';
  $lessons_sent= '';
  $button = 'Add cycle';

  include 'form.html.php';
  exit();
}

if (isset($_GET['addform']))
{
  include '../includes/db.inc.php';

  try
  {
    $sql = 'INSERT INTO _cycle_ SET
        startdate = :startdate,
        id = :id,
        lessons_sent = :lessons_sent';
    $s = $pdo->prepare($sql);
    $s->bindValue(':startdate', $_POST['startdate']);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':lessons_sent', $_POST['lessons_sent']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error adding submitted cycle.';
    include 'errorPage.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Edit')
{
  include '../includes/db.inc.php';

  try
  {
    $sql = 'SELECT id, startdate, lessons_sent FROM _cycle_ WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching cycle details.';
    include 'errorPage.html.php';
    exit();
  }

  $row = $s->fetch();

  $pageTitle = 'Edit Cycle';
  $action = 'editform';
  $startdate = $row['startdate'];
  $id = $row['id'];
  $lessons_sent= $row['lessons_sent'];
  $button = 'Update cycle';

  include 'form.html.php';
  exit();
}

if (isset($_GET['editform']))
{
  include '../includes/db.inc.php';

  try
  {
    $sql = 'UPDATE _cycle_ SET
        startdate = :startdate,
        lessons_sent = :lessons_sent
        WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->bindValue(':startdate', $_POST['startdate']);
    $s->bindValue(':lessons_sent', $_POST['lessons_sent']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error updating submitted cycle.';
    include 'errorPage.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Delete')
{
  include '../includes/db.inc.php';

  // Delete students that belong in this cycle
  try
  {
    $sql = 'DELETE FROM student WHERE cycle_id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing the students of this cycle.';
    include 'errorPage.html.php';
    exit();
  }

  // Delete the cycle
  try
  {
    $sql = 'DELETE FROM _cycle_ WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindValue(':id', $_POST['id']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error deleting cycle.';
    include 'errorPage.html.php';
    exit();
  }

  header('Location: .');
  exit();
}

// Display cycle list
include '../includes/db.inc.php';

try
{
  $result = $pdo->query('SELECT id, startdate, lessons_sent FROM _cycle_');
}
catch (PDOException $e)
{
  $error = 'Error fetching cycles from database!';
  include 'errorPage.html.php';
  exit();
}

$cycles = array();

foreach ($result as $row)
{
  $cycles[] = array('id' => $row['id'], 'startdate' => $row['startdate'], 'lessons_sent' => $row['lessons_sent']);
}

include 'cycles.html.php';
