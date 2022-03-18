<?php
    $url = filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);
?>
<div id="side-nav" class="col-md-2 d-flex flex-column justify-content-center">
    <ul class="nav nav-pills flex-column">
        <li><a class="side-link <?php echo explode('/', $url)[1] == 'dashboard' ? 'active' : ''; ?>" href="/dashboard">Overview</a></li>
        <li><a class="side-link <?php echo explode('/', $url)[1] == 'projects' ? 'active' : ''; ?>" href="/projects">Projects</a></li>
        <li><a class="side-link <?php echo explode('/', $url)[1] == 'users' ? 'active' : ''; ?>" href="/users">Users</a></li>
        <li><a class="side-link <?php echo explode('/', $url)[1] == 'metrics' ? 'active' : ''; ?>" href="/metrics">Metrics</a></li>
        <li><a class="side-link <?php echo explode('/', $url)[1] == 'budget' ? 'active' : ''; ?>" href="/budget">Budget</a></li>
        <li><a class="side-link <?php echo explode('/', $url)[1] == 'jobs' ? 'active' : ''; ?>" href="/jobs">Jobs</a></li>
        <li><a class="side-link" href="/logout">Logout</a></li>
    </ul>
</div>