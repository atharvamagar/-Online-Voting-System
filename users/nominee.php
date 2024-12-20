<?php
require '../common/connect.php';

session_start();

require '../common/links.php';

if (isset($_SESSION['id'])) {
    include '../common/navbar.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nominee Login | <?= $_SESSION['uname'] ?></title>
</head>
<body class="position-relative">
  <?php include '../common/message.php'; ?>
  <div class="container position-relative z-1">
      <div class="row">
          <div class="col-12 mt-5">

              <?php
              $query = "SELECT * FROM candidates WHERE name='{$_SESSION['uname']}'";
              $query_run = mysqli_query($conn, $query);

              if (mysqli_num_rows($query_run) > 0) {
                  foreach ($query_run as $nominee) {
                      ?>
                      <div class="card mb-3">
                          <div class="card-header"><h5>Nominee Application</h5></div>
                          <div class="card-body">

                              <?php if ($nominee['status'] === "Accepted") { ?>
                                <h3 class="text-success">Your Application Form has been accepted.</h3>

                              <?php } else if ($nominee['status'] === "Rejected") { ?>
                                  <?php
                                    $attempts = isset($nominee['attempts']) ? $nominee['attempts'] : 0;
                                    if ($attempts < 3) {
                                  ?>
                                    <?php
                                        if(!empty($nominee['comments'])):
                                    ?>
                                            <div class="alert alert-warning" role="alert"><?=$nominee['comments']?></div>
                                    <?php
                                        endif;
                                    ?>
                                      <h3 class="text-danger">Your Application Form has been rejected.
                                          Application edits left - <?= 3 - $attempts ?></h3>
                                      <a href="editNominee.php?name=<?=$nominee['name']?>" class="btn btn-primary">Edit Application</a>
                                  <?php } else { ?>
                                      <h3 class="text-danger">You have reached the maximum number of edit attempts.
                                          Please contact the administrator for further assistance.</h3>
                                  <?php } ?>

                              <?php } else if ($nominee['status'] === "Pending") { ?>
                                  <h5 class="text-warning">Your Application Form has been submitted. Kindly await for Administrator confirmation.</h5>
                                    <a href="viewNominee.php?name=<?=$nominee['name']?>" class="btn btn-primary">View Application</a>
                              <?php } ?>
                          </div>
                      </div>
                      
                      <?php 
                      if ($nominee['status'] === "Accepted"):
                        $query = "SELECT * FROM campaign WHERE id=?";
                        $stmt = mysqli_prepare($conn, $query);
                
                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, 's', $_SESSION['id']);
                            mysqli_stmt_execute($stmt);
                
                            $result = mysqli_stmt_get_result($stmt);
                        ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card my-5">
                                                <div class="card-header text-center"><h3>Campaigns</h3></div>
                                                <div class="card-body">
                                                    <div class="card col-2 m-2">
                                                        <a class="btn btn-primary" href="../users/newCampaign.php">
                                                            Add New Campaign
                                                        </a>
                                                    </div>
                                                <?php
                                                if (mysqli_num_rows($result) > 0) {
                                                    $campaign = mysqli_fetch_assoc($result);
                                                ?>
                                                    <div class="<?=$campaign['size']?> position-relative" style="object-fit: cover;">
                                                        <p class="position-absolute text-center fs-2"><?=$campaign['motto']?></p>
                                                        <img src="<?=htmlspecialchars($campaign['campaign'])?>" alt="<?=htmlspecialchars($campaign['campaign'])?>" class="img-fluid" style="object-fit: cover;">
                                                    </div>
                                                <?php
                                                    } else {
                                                        echo "<div class='container alert alert-warning' role='alert'>No Campaigns Found.</div>";
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                              <?php 
                                    mysqli_stmt_close($stmt);
                                } else {
                                    // Handle the case where the prepared statement couldn't be created
                                    echo "Error preparing statement: " . mysqli_error($conn);
                                }
                                endif;
                  }
              } else {
                  ?>
                  <div class="card mb-3">
                      <div class="card-header"><h5>Nominee Application</h5></div>
                      <div class="card-body">
                        <p class="card-text">To apply as a nominee, firstly note the criterias to stand as mentioned
                            <a type="button" class="link-underline-primary" data-bs-toggle="modal"
                              data-bs-target="#criteria">here</a>
                            , then proceed to fill the <strong>Nominee Application Form</strong>.</p>
                        <a href="newNominee.php" class="btn btn-primary">Application Form</a>
                      </div>
                  </div>
                  <?php
              }
              ?>
          </div>
      </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="criteria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Criterias to be a Nominee</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <!-- Add content for the criteria modal -->
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <a href="newNominee.php" class="btn btn-primary">Fill Form</a>
              </div>
          </div>
      </div>
  </div>


</body>
</html>

<?php
} else {
    header("Location:../login.php");
    exit();
}
?>
