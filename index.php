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
      
      <?php include "connection.php"; ?>
      
       <!--Nav menu -->
      <nav>
          <ul>
              <?php foreach($result as $link): ?>
                <li>
                    <a href="index.php?link=<?php echo $link['subject']; ?>"><?php echo $link['subject']; ?></a>
                </li>
              <?php endforeach; ?>
              <li>
                  <a href="create.php">Enter a New Record</a>
              </li>
              <li>
                  <a href="index.php">Index Page</a>
              </li>
          </ul>
      </nav>
    <h1 style="font-size: 70px;"><b>Secure Contain Protect</b>
        <br> SCP Foundation Info Hub</h1>
    
    <div>
        <?php
        
            if(isset($_GET['link']))
            {
                $subject = $_GET['link'];
                
                //prepared statement to retrieve record based on get value
                $stmt = $connection->prepare("select * from scp where subject = ?");
                
                $stmt->bind_param("s", $subject);
                
                if($stmt->execute())
                {
                    $record = $stmt->get_result();
                    $array = $record->fetch_assoc();
                    
                    //create update get value based on record id
                    $update = "update.php?update=" . $array['id'];
                    
                    //create delete get value based on record id
                    $delete = "index.php?delete=" . $array['id'];
                   
                    echo"
                    
                        <div class='p-3 border shadow rounded'>
                            <h3>{$array['subject']}</h3>
                            <h4>{$array['class']}</h4>
                            <p class='text-centre'><image class='img-fluid' src='{$array['image']}' alt='{$array['subject']}'></p>
                            <p>{$array['description']}</p>
                            <p>{$array['containment']}</p>
                            <p class='text-center'>
                                <a href='{$update}' class='btn btn-warning'>Update Record</a>
                                <a href='{$delete}' class='btn btn-danger'>Delete Record</a>
                            </p>
                        </div>
                    
                    ";
                }
                
                else
                {
                    echo "<p class='alert alert-danger'>No record found</p>";
                }
            }
            else
            {
                echo"
                    <div class='p-3 border shadow rounded'>
                        <h2>SCP Info Hub</h2>
                        <p>Use the Nav Bar above to browse this site.</p>
                        <p class='text-centre'><image class='img-fluid' src='images/SCP=logo.png' alt='SCP Logo'></p>
                    </div>
                
                ";
            }
            
            // delete record
            if(isset($_GET['delete']))
            {
                $deleteID = $_GET['delete'];
                $delete = $connection->prepare("delete from scp where id=?");
                $delete->bind_param("i", $deleteID);
                
                if($delete->execute())
                {
                    echo "<div class='alert alert-warning'>Record Deleted...</div>";
                }
                else
                {
                    echo "<div class='alert alert-danger'>Error: {$delete->error}</div>";
                }
            }
            
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <footer>
        <div style="text-align: right; color: white; padding-top: 15px;">SCP Foundation
            <br>Secure. Contain. Protect.    
        </div>
    </footer>
  </body>
</html>