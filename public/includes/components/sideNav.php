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
                        <a class="side-link '; isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'dashboard' || !isset(explode('/', $url)[1]) ? print 'active' : print ''; echo'" href="/dashboard">
                        <i class="las la-icons"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="side-link '; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'projects' || explode('/', $url)[1] == 'edit' ? 'active' : ''; echo'" href="/projects">
                            <i class="las la-folder-open"></i>Manage Projects'; echo $unapproved_projects > 0 ? '<span id="notify"></span>' : ''; echo'
                        </a>
                        <ul>
                            <li><a href="/projects" class="side-link '; echo explode('/', $url)[1] == 'projects' && isset(explode('/', $url)[2]) == '' ? 'active' : ''; echo'">Active Projects</a></li>';
                            if($_SESSION['designation'] == 'director')
                            {
                                echo'
                                    <li><a href="/projects/add" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'add' ? 'active' : ''; echo'">Add a new project</a></li>
                                ';
                            } echo'
                            <li><a href="/projects/approve" class="side-link'; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'approve' ? ' active' : ''; echo'">Approve a project'; echo $unapproved_projects > 0 ? '<span id="notify">'.$unapproved_projects.'</span>' : ''; echo'</a></li>
                            <li><a href="/projects/compare" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'compare' ? 'active' : ''; echo'">Compare Projects</a></li>
                            <li><a href="/projects/suspended" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'suspended' ? 'active' : ''; echo'">Suspended Projects</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="side-link '; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'sector' || explode('/', $url)[1] == 'edit' ? 'active' : ''; echo'" href="/sector">
                            <i class="las la-chart-pie"></i>Sector Management
                        </a>
                        <ul>
                            <li><a href="/sector" class="side-link '; echo explode('/', $url)[1] == 'sector' && isset(explode('/', $url)[2]) == '' ? 'active' : ''; echo'">Sector Summary</a></li>
                            <li><a class="side-link'; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'budget' ? ' active' : ''; echo'" href="/sector/budget">Manage Budget</a></li>  
                            <li><a class="side-link'; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'jobs' ? ' active' : ''; echo'" href="/sector/jobs">Sector Jobs</a></li>  
                        </ul>
                    </li>
                    <li>
                        <a class="side-link'; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'users' ? ' active' : ''; echo'" href="/users">
                            <i class="las la-user-friends"></i>User Management</a>
                    </li> 
                    <!--<li>
                        <a class="side-link '; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'metrics' ? 'active' : ''; echo'" href="/metrics">
                            <i class="las la-chart-bar"></i>Manage Metrics</a>
                    </li>-->
                    <li>
                        <a class="side-link" href="/logout">
                            <i class="las la-power-off"></i>Log Out</a>
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
                        <a class="side-link '; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'dashboard' ? 'active' : ''; echo'" href="/dashboard">
                        <i class="las la-icons"></i>Dashboard</a>
                    </li>
                    <li>
                        <a class="side-link '; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'projects' ? 'active' : ''; echo'" href="/projects">
                            <i class="las la-folder-open"></i>Projects</a>
                            <ul>
                                <li><a href="/projects" class="side-link '; echo explode('/', $url)[1] == 'projects' && isset(explode('/', $url)[2]) == '' ? 'active' : ''; echo'">Active Projects</a></li>
                                <li><a href="/projects/add" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'add' ? 'active' : ''; echo'">Add new project</a></li>
                                <li><a href="/projects/compare" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'compare' ? 'active' : ''; echo'">Compare Projects</a></li>
                                <li><a href="/projects/unapproved" class="side-link'; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'unapproved' ? ' active' : ''; echo'">Unapproved projects</a></li>
                                <li><a href="/projects/suspended" class="side-link '; echo isset(explode('/', $url)[2]) && explode('/', $url)[2] == 'suspended' ? 'active' : ''; echo'">Suspended Projects</a></li>
                            </ul>
                    </li>
                    <li>
                        <a class="side-link '; echo isset(explode('/', $url)[1]) && explode('/', $url)[1] == 'metrics' ? 'active' : ''; echo'" href="/metrics">
                            <i class="las la-chart-bar"></i>Manage Metrics</a>
                    </li>
                    <li>
                        <a class="side-link" href="/logout">
                            <i class="las la-power-off"></i>Log Out</a>
                    </li>
                </ul>
            </div>
        ';
    }