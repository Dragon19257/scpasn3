<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Info Hub</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body class = "container">
      
    <?php 
        
        include "connection.php"; 
        
        if(isset($_POST['submit']))
        {
            // code a prepared statement to insert form contents to database
            $insert = $connection->prepare(
                "insert into scp(subject, class, description, containment, image) values(?, ?, ?, ?, ?)"
                );
            $insert->bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['description'], $_POST['containment'], $_POST['image']);
            
            if($insert->execute())
            {
                echo "
                <div class='alert alert-success'>Record Added Successfully</div>
                ";
            }
            else
            {
                echo "
                <div class='alert alert-danger'>Error: {$insert->error}</div>
                ";
            }
            
        }
        
    ?>
      
    <button class="btn btn-dark"><a href="index.php" class="text-white">Back to index page</a></button>  
    
    <h1>Add a new Record</h1>
    
    <div>
      <form method="post" action="create.php" class="form-group">
          <label>Enter Subject:</label>
          <br>
          <input type="text" name="subject" placeholder="SCP Subject #..." required class="form-control">
          <br>
          <label>Enter Object Class:</label>
          <br>
          <input type="text" name="class" placeholder="Object Class..." required class="form-control">
          <br>
          <label>Enter Description:</label>
          <textarea name="description" class="form-control">Description here...</textarea>
          <br>
          <label>Enter Containment Procedure:</label>
          <textarea name="containment" class="form-control">Containment procedures here...</textarea>
          <br>
          <label>Enter SCP Image:</label>
          <br>
          <input type="text" name="image" placeholder="image URL or Path e.g images/name-of-image.png" required class="form-control">
          <br>
          <br>
          <input type="submit" name="submit" class="btn btn-primary">
      </form>  
    </div>
    
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <footer>
        <div style="text-align: right; color: white; padding-top: 15px;">SCP Foundation
            <br>Secure. Contain. Protect.    
        </div>
    </footer>  
  </body>
</html>