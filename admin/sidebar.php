<div class="admin-section admin-section1">
    <ul>
        <li><i class="fas fa-sliders-h"></i><a href="admin.php">Dashboard </a><i class="fas admin-dropdown fa-chevron-right"></i></li>
        <li><i class="fas fa-ticket-alt"></i><a href="view.php">Bookings</a> <i class="fas admin-dropdown fa-chevron-right"></i></li>
        
        <li><i class="fas fa-film"></i><a href="addmovie.php">Movies</a> <i class="fas admin-dropdown fa-chevron-right"></i></a></li>
        <li><i class="fas fa-plus-circle"></i><a href="add.php">Add entry</a> <i class="fas admin-dropdown fa-chevron-right"></i></a></li>
        <li><i class="fas fa-id-card"></i><a href="contactus.php">User Feedback</a> <i class="fas admin-dropdown fa-chevron-right"></i></a></li>
        <li><i class="fa fa-check-circle"></i><a href="../TxnStatus.php" target="_blank">Check Status</a> <i class="fas admin-dropdown fa-chevron-right"></i></a></li>
    </ul>
</div>

<style>
.sidebar {
    width: 250px;
    background-color: var(--secondary-color);
    color: white;
    padding: 1rem 0;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    height: 100vh;
    top: 0;
    left: 0;
    margin-top: 60px; /* Adjust based on your navbar height */
}

.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-menu li {
    margin-bottom: 0.5rem;
}

.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
}

.sidebar-menu a:hover, 
.sidebar-menu a.active {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
}

.sidebar-menu i {
    margin-right: 0.75rem;
    width: 20px;
    text-align: center;
}
</style>
