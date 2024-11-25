<?php include('header.php') ?>
<nav class="navbar navbar-header navbar-dark bg-dark">
    <div class="container-fluid">
        <div class="navbar-header">
        <img src="logoireply.png" alt="logo" width="200px">
            
        </div>
        <div class="nav navbar-nav navbar-right">
            <a href="logout.php" class="text-light"> <i class="fa fa-user"> </i> <?php echo $user_name ?></a>
        </div>
    </div>
</nav>

<div id="sidebar" class="bg-dark">
    <div id="sidebar-field">
        <a href="home.php" class="sidebar-item">
            <div class="sidebar-icon"><i class="fa fa-dashboard">
            </i>  Dashboard</div>
        </a>
    </div>
    <div id="sidebar-field">
        <a href="employee.php" class="sidebar-item">
            <div class="sidebar-icon"><i class="fa fa-columns"></i> Employee </div>
        
        </a>
    </div>
    <div id="sidebar-field">
        <a href="attendance.php" class="sidebar-item">
            <div class="sidebar-icon"><i class="fa fa-list"></i> Attendance</div> 
        </a>
    </div>
    <div id="sidebar-field">
        <a href="users.php" class="sidebar-item">
            <div class="sidebar-icon"><i class="fa fa-users"></i> User</div> 

        </a>
    </div>
    <div id="sidebar-field">
        <a href="announcements.php" class="sidebar-item">
            <div class="sidebar-icon"><i class="fa fa-bullhorn"></i> Announcement </div>
        </a>
    </div>
    <div id="sidebar-field">
        <a href="leave.php" class="sidebar-item">
            <div class="sidebar-icon"><i class="fa fa-dashboard"> 
            </i>  Leave</div>
        </a>
    </div>
    <div id="sidebar-field">
        <a href="events.php" class="sidebar-item">
            <div class="sidebar-icon" ><i class="fa fa-calendar" > </i> Event</div>
        </a>
    </div>
    <div id="sidebar-field">
        <a href="holiday_display.php" class="sidebar-item">
            <div class="sidebar-icon" ><i class="fa fa-calendar" ></i> Holidays</div>
        </a>
    </div>
</div> <!-- Closing div for sidebar -->

<script>
    $(document).ready(function(){
        var loc = window.location.href;
        $('#sidebar a').each(function(){
            if($(this).attr('href') == loc.substr(loc.lastIndexOf("/") + 1)){
                $(this).addClass('active');
            }
        });
    });
</script>
