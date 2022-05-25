<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="BSA Auto" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Pro Institute</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('shift.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Shifts
                        </p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('course.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Courses
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Students
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user-course.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Student Courses
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('teacher.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Teachers
                        </p>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('result.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Results
                        </p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('attendance.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Attendances
                        </p>
                    </a>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('notice.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Notices
                        </p>
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('school-asset.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-school"></i>
                        <p>
                            Institute Assets
                        </p>
                    </a>
                </li>

                {{-- Reports --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon fas fa-table"></i>
                      <p>
                        Reports
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item">
                            <a href="{{ route('student.marksheet') }}" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Student Marksheet report</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Generate Certificate</p>
                            </a>
                        </li>
                      
                    </ul>
                  </li>
            </ul>
        </nav>

    </div>

</aside>