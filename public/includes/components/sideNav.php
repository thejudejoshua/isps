<?php
    $url = filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);

    if($_SESSION['designation'] != 'budgeting officer')
    {
        $project = new Project();
        $unapproved_projects = count($project->getUnapprovedProjects($_SESSION['sector']));
        echo'
            <div id="side-nav" class="col-md-2 d-flex flex-column justify-content-center">
                <ul class="nav nav-pills flex-column">
                    <li>
                        <a class="side-link '; echo explode('/', $url)[1] == 'dashboard' ? 'active' : ''; echo'" href="/dashboard">
                            <i class="las la-home"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="side-link '; echo explode('/', $url)[1] == 'projects' ? 'active' : ''; echo'" href="/projects">
                            <i class="las la-folder-open"></i>Projects'; echo $unapproved_projects > 0 ? '<span id="notify"></span>' : ''; echo'</a>
                            <ul>
                                <li><a href="/projects" class="side-link '; echo explode('/', $url)[1] == 'projects' && isset(explode('/', $url)[2]) == '' ? 'active' : ''; echo'">All Projects</a></li>
                                <li><a href="/projects/add" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'add' ? 'active' : ''; echo'">Add new project</a></li>
                                <li><a href="/projects/approve" class="side-link'; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'approve' ? ' active' : ''; echo'">Approve a project'; echo $unapproved_projects > 0 ? '<span id="notify">'.$unapproved_projects.'</span>' : ''; echo'</a></li>
                                <li><a href="/projects/compare" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'compare' ? 'active' : ''; echo'">Compare Projects</a></li>
                            </ul>
                    </li>
                    <li>
                        <a class="side-link'; echo explode('/', $url)[1] == 'users' ? ' active' : ''; echo'" href="/users">
                            <i class="las la-user-friends"></i>User Management</a>
                    </li>
                    <li>
                        <a class="side-link'; echo explode('/', $url)[1] == 'budget' ? ' active' : ''; echo'" href="/budget">
                            <i class="las la-clipboard"></i>Budget</a>
                    </li>
                            
                    <li>
                        <a class="side-link '; echo explode('/', $url)[1] == 'metrics' ? 'active' : ''; echo'" href="/metrics">
                            <i class="las la-chart-bar"></i>Manage Metrics</a>
                    </li>
                    <li>
                        <a class="side-link" href="/logout">
                            <i class="las la-power-off"></i>Power Down</a>
                    </li>
                </ul>
            </div>
        ';
    }else
    {
        echo '
        <div id="side-nav" class="col-md-2 d-flex flex-column justify-content-center">
                <ul class="nav nav-pills flex-column">
                    <li>
                        <a class="side-link '; echo explode('/', $url)[1] == 'dashboard' ? 'active' : ''; echo'" href="/dashboard">
                            <i class="las la-home"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="side-link '; echo explode('/', $url)[1] == 'projects' ? 'active' : ''; echo'" href="/projects">
                            <i class="las la-folder-open"></i>Projects</a>
                            <ul>
                                <li><a href="/projects" class="side-link '; echo explode('/', $url)[1] == 'projects' && isset(explode('/', $url)[2]) == '' ? 'active' : ''; echo'">All Projects</a></li>
                                <li><a href="/projects/add" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'add' ? 'active' : ''; echo'">Add new project</a></li>
                                <li><a href="/projects/compare" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'compare' ? 'active' : ''; echo'">Compare Projects</a></li>
                            </ul>
                    </li>
                    <li>
                        <a class="side-link '; echo explode('/', $url)[1] == 'metrics' ? 'active' : ''; echo'" href="/metrics">
                            <i class="las la-chart-bar"></i>Manage Metrics</a>
                    </li>
                    <li>
                        <a class="side-link" href="/logout">
                            <i class="las la-power-off"></i>Power Down</a>
                    </li>
                </ul>
            </div>
        ';
    }