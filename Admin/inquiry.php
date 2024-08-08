<?php 
  include_once 'components/connection.php';
  session_start();
    
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Cakery</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.css"> 
<!-- jQuery -->
<!-- <script src="js/jquery-2.1.4.min.js"></script> -->
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
</head> 

<body> 
    <div class="dashboard-container">
        <?php include 'components/sidemenu.php'?>
        <div class="dashboard-container2">
            <?php include 'components/header.php'?>

            <!-- breadcrumb -->
            <nav aria-label="breadcrumb" class="bd">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Inquiry</li>
                </ol>
            </nav>
            <!-- breadcrumb -->

            <div class="main-container">
                <div class="user-container">
					<h2 style="text-align: center;">View Inquiry</h2>
					<table>
						<thead>
							<tr>
							<th>Sr.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Message</th>
							<th>Date</th>
							</tr>
						</thead>
						<tbody>
						<?php $sql = "SELECT * from inquiries";
						$query = $conn -> prepare($sql);
						$query->execute();
						$results=$query->fetchAll(PDO::FETCH_OBJ);
						$cnt=1;
						if($query->rowCount() > 0){
						foreach($results as $result)
						{				?>		
						  <tr>
							<td><?php echo htmlentities($cnt);?></td>
							<td><?php echo htmlentities($result->name);?></td>
							<td><?php echo htmlentities($result->email);?></td>
							<td><?php echo htmlentities($result->message);?></td>
							<td><?php echo htmlentities($result->created_at);?></td>
							<!-- <td><a href="user-bookings.php?uid=<?php //echo htmlentities($result->EmailId);?>&&uname=<?php //echo htmlentities($result->FullName);?>" class="btn btn-primary">User Bookings</td> -->
						  </tr>
						 <?php $cnt=$cnt+1;} }?>

						</trbody>
					<table>
                </div>
                
            </div>
        <div>
    </div>        
</body>

</html>

