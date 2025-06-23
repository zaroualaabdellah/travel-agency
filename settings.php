<?php
$pageTitle = "Settings";
include('includes/header.php');
include('includes/sidebar.php');
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?php echo $pageTitle; ?></h4>
    <div>
      <span>Welcome, Admin</span>
      <a href="#" class="btn btn-sm btn-outline-secondary">Logout</a>
    </div>
  </div>
  <div class="content mt-4">
    <p>This is the settings page.</p>
  </div>
</main>

<?php include('includes/footer.php'); ?>
