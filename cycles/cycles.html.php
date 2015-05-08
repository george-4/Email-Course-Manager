<?php include_once '../includes/functions.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="../includes/style.css">
    <script>

    $(function() {
      $( "#dialog-confirm" ).dialog({
        autoOpen: false,
        resizable: false,
        height:230,
        width:450,
        modal: true,
        buttons: {
          "Delete cycle and students": function() {
            document.getElementById(currentFormID).submit();
          },
          Cancel: function() {
            $( this ).dialog( "close" );
          }
        }
      });
      
      $('input[value="Delete"]').click(function() {
        currentFormID = $(this).closest('form').attr('id');
        $( "#dialog-confirm" ).dialog( "open" );
      });
      
    });


    </script>
    <title>Manage Cycles</title>
  </head>
  <body>
    <h1>Manage Cycles</h1>
    <p><a href="?add">Add new cycle</a></p>
    <?php if ($cycles): ?>
    <table>
      <tr><td>ID</td><td>Starting Date</td><td>Lessons Sent</td></tr>

      <?php foreach ($cycles as $cycle): ?>
        <tr>
          <td><?php htmlout($cycle['id']); ?></td>
          <td><?php htmlout($cycle['startdate']); ?></td>
          <td><?php htmlout($cycle['lessons_sent']); ?></td>
          <td>
            <form class="cycle_editform" action="" method="post">
              <input type="submit" name="action" value="Edit">
              <input type="hidden" name="id" value="<?php echo $cycle['id']; ?>">
            </form>
          </td>
          <td>
            <form class="cycle_deleteform" id="del<?php htmlout($cycle['id']); ?>" action="" method="post">
              <input type="button" value="Delete">
              <input type="hidden" name="action" value="Delete">
              <input type="hidden" name="id" value="<?php echo $cycle['id']; ?>">
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
    
  <div id="dialog-confirm" title="Delete this cycle?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>These will also delete the students associated with this cycle. Are you sure?</p>
  </div>

    <?php else: ?>
      <p> No Cycles created yet. </p>
    <?php endif; ?>
    <p><a href="..">Return to home</a></p>
  </body>
</html>
