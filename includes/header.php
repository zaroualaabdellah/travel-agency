<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $pageTitle ?? 'My PHP Project'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { overflow-x: hidden; }
    #sidebar {
      min-height: 100vh;
      background-color: #343a40;
      color: white;
    }
    #sidebar a {
      color: white;
      display: block;
      padding: 10px;
      text-decoration: none;
    }
    #sidebar a:hover {
      background-color: #495057;
    }
    .topbar {
      background-color: #f8f9fa;
      padding: 10px;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
