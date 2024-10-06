 <div id="sidebar">
        <div class="sidebar__title">
          <div class="sidebar__img">
            <!-- <img src="assets/logo.png" alt="logo" /> -->
            <h1>MOCK JAMB</h1>
          </div>
          <i
            onclick="closeSidebar()"
            class="fa fa-times"
            id="sidebarIcon"
            aria-hidden="true"
          ></i>
        </div>

        <div class="sidebar__menu">
          <div class="sidebar__link active_menu_link">
            <i class="fa fa-home"></i>
            <a href="admin_dashboard.php">Dashboard</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-user" aria-hidden="true"></i>
            <a href="#">Profile</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-building-o"></i>
            <a href="add_subject.php">Add Subject</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-wrench"></i>
            <a href="add_category.php">Add Category</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-archive"></i>
            <a href="add_question.php">Add Question</a>
          </div>
          <div class="sidebar__link">
            <i class="fa fa-handshake-o"></i>
            <a href="manage_students.php">Manage Students</a>
          </div>
          
          <div class="sidebar__logout">
            <i class="fa fa-power-off"></i>
            <a href="logout.php">Log out</a>
          </div>
        </div>
      </div>
    </div>