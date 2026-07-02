<?php error_reporting(0);?>
<header class="navbar navbar-default navbar-static-top">
                    <div class="navbar-header">
                        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
                            <i class="ti-align-justify"></i>
                        </a>
                        <a class="navbar-brand" href="#">
                            <h2 style="padding-top:20% ">HMS</h2>
                        </a>
                        <a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
                            <i class="ti-align-justify"></i>
                        </a>
                        <a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="ti-view-grid"></i>
                        </a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-right">
                            <li  style="padding-top:2% ">
                                <h2>Hospital Management System</h2>
                            </li>
                        
                        
                            <li class="dropdown current-user">
                                <a href class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="assets/images/avatar-1.jpg" alt="Peter"> <span class="username">

                                    <?php 
                                    $session_id = $_SESSION['id'];
                                    $query = "select fullName from users where id = ?";
                                    $stmt = mysqli_prepare($con, $query);
                                    if($stmt) {
                                        mysqli_stmt_bind_param($stmt, "i", $session_id); // Assumendo che l'ID sia un intero 'i', usa 's' se stringa
                                        if(mysqli_stmt_execute($stmt)) {
                                            $result = mysqli_stmt_get_result($stmt);
                                            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {   
                                                echo htmlspecialchars((string)$row['fullName'], ENT_QUOTES);
                                            }
                                        }
                                        mysqli_stmt_close($stmt);
                                    }
                                    ?> <i class="ti-angle-down"></i></span>
                                </a>
                                <ul class="dropdown-menu dropdown-dark">
                                    <li>
                                        <a href="edit-profile.php">
                                            My Profile
                                        </a>
                                    </li>
                                
                                    <li>
                                        <a href="change-password.php">
                                            Change Password
                                        </a>
                                    </li>
                                    <li>
                                        <a href="logout.php">
                                            Log Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            </ul>
                        <div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
                            <div class="arrow-left"></div>
                            <div class="arrow-right"></div>
                        </div>
                        </div>
                
                    
                    </header>