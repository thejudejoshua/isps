<?php
    $url = filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);
?>
    <div id="side-nav" class="col-md-2 d-flex flex-column justify-content-center">
        <ul class="nav nav-pills flex-column">
            <li>
                <a class="side-link <?php echo explode('/', $url)[1] == 'dashboard' ? 'active' : ''; ?>" href="/dashboard">
                    <i class="las la-home"></i>Dashboard</a>
            </li>
            <li>
                <a class="side-link <?php echo explode('/', $url)[1] == 'projects' ? 'active' : ''; ?>" href="/projects">
                    <i class="las la-folder-open"></i>Projects</a>
            </li>
            <li>
                <a class="side-link <?php echo explode('/', $url)[1] == 'users' ? 'active' : ''; ?>" href="/users">
                    <i class="las la-user-friends"></i>User Management</a>
            </li>
            <li>
                <a class="side-link <?php echo explode('/', $url)[1] == 'metrics' ? 'active' : ''; ?>" href="/metrics">
                    <i class="las la-chart-bar"></i>Manage Metrics</a>
            </li>
            <li>
                <a class="side-link <?php echo explode('/', $url)[1] == 'budget' ? 'active' : ''; ?>" href="/budget">
                    <i class="las la-clipboard"></i>Budget</a>
            </li>
            <li>
                <a class="side-link" href="/logout">
                    <i class="las la-power-off"></i>Power Down</a>
            </li>
        </ul>
    </div>