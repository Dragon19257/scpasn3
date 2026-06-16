<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Info Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class = "container">
      
    <?php 
        
        //enable error reporting, romove these when application is finished
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        include "connection.php";
        
        // initialise $row as empty array
        $row = [];
        
        // redirected from index page with update get value
        if (isset($_GET['update']))
        {
            // save get value
            $id = $_GET['update'];
            
            // based on the above, retrieve appropriate record from table
            $recordID = $connection->prepare("select * from scp where id = ?");
            
            if(!$recordID)
            {
                echo"<div class='alert alert-danger'>Error preparing record for updating</div>";
                exit;
            }
            
            $recordID->bind_param("i", $id);
            
            if($recordID->execute())
            {
                echo"<div class='alert alert-success'>Record ready for updating</div>";
                $temp = $recordID->get_result();
                $row =  $temp->fetch_assoc();
            }
            
        }
        
        if(isset($_POST['update']))
        {
            //write a prepared statement to save edit/update from this form 
            $update = $connection->prepare("update scp set subject=?, class=?, description=?, containment=?, image=? where id=?");
            $update->bind_param("sssssi", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image'], $_POST['id']);
            
            if($update->execute())
            {
                echo "<div class='alert alert-primary'>Record Updated Successfully</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Error: {$update->error}</div>";
            }
        }
        
    ?>
      
    <button class="btn btn-dark"><a href="index.php" class="text-white">Back to index page</a></button>  
    
    <h1>Update the Existing Record</h1>
    
    <div>
      <form method="post" action="update.php" class="form-group">
          <input type="hidden" name="id" value ="<?php echo isset($row['id']) ? $row['id'] : '' ?>">
          <label>Enter Subject:</label>
          <br>
          <input type="text" name="subject" value ="<?php echo isset($row['subject']) ? $row['subject'] : '' ?>" placeholder="SCP Subject #..." required class="form-control">
          <br>
          <label>Enter Object Class:</label>
          <br>
          <input type="text" name="class" value ="<?php echo isset($row['class']) ? $row['class'] : '' ?>" placeholder="Object Class..." required class="form-control">
          <br>
          <label>Enter Description:</label>
          <textarea name="description" class="form-control"><?php echo isset($row['description']) ? $row['description'] : '' ?></textarea>
          <br>
          <label>Enter Containment Procedure:</label>
          <textarea name="containment" class="form-control"><?php echo isset($row['containment']) ? $row['containment'] : '' ?></textarea>
          <br>
          <label>Enter SCP Image:</label>
          <br>
          <input type="text" name="image" value ="<?php echo isset($row['image']) ? $row['image'] : '' ?>" placeholder="image URL or Path e.g images/name-of-image.png" required class="form-control">
          <br>
          <br>
          <input type="submit" name="update" class="btn btn-primary">
      </form>  
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>