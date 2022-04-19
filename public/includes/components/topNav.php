<nav id="top-nav" class="navbar d-flex justify-content-between align-items-center">
    <div class="system-own d-flex align-items-center">
        <img src="/includes/assets/img/Coat_of_arms.png">
        <p class="paragraphsdescriptions">Federal Ministry of Finance, Budgeting and National Planning</p>
    </div>

    <div class="">
        <div class="" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="profile-link nav-link dropdown-toggle text-center text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?=$_SESSION['name']?></span><br><span id="nav-email"><?=$_SESSION['sector'] . '  '. $_SESSION['designation'] ?></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="#">Change Password</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="/login">Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>