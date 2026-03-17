<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="#"><img
                src="{{ URL::asset('assets/admin/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="#"><img
                src="{{ URL::asset('assets/admin/img/brand/logo-white.png') }}" class="main-logo dark-theme"
                alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="#"><img
                src="{{ URL::asset('assets/admin/img/brand/favicon.png') }}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="#"><img
                src="{{ URL::asset('assets/admin/img/brand/favicon-white.png') }}" class="logo-icon dark-theme"
                alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround" src="{{ auth()->user()->image_url }}"><span
                        class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ auth()->user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ auth()->user()->roles()->first()->name }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">

            <!-- START DASHBOARDS -->
            <li class="side-item side-item-category">{{ __('admin.sidebar.dashboard') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3" />
                        <path
                            d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.dashboard') }}</span></a>
            </li>

            <!-- START ACADEMIC STRUCTURE -->
            <li class="side-item side-item-category">{{ __('admin.sidebar.academic_structure') }}</li>
            @can('view_grades')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.grades.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" width="24px"
                            fill="#e3e3e3">
                            <g>
                                <rect fill="none" height="24" width="24" x="0" />
                            </g>
                            <g>
                                <g>
                                    <path
                                        d="M23,8c0,1.1-0.9,2-2,2c-0.18,0-0.35-0.02-0.51-0.07l-3.56,3.55C16.98,13.64,17,13.82,17,14c0,1.1-0.9,2-2,2s-2-0.9-2-2 c0-0.18,0.02-0.36,0.07-0.52l-2.55-2.55C10.36,10.98,10.18,11,10,11c-0.18,0-0.36-0.02-0.52-0.07l-4.55,4.56 C4.98,15.65,5,15.82,5,16c0,1.1-0.9,2-2,2s-2-0.9-2-2s0.9-2,2-2c0.18,0,0.35,0.02,0.51,0.07l4.56-4.55C8.02,9.36,8,9.18,8,9 c0-1.1,0.9-2,2-2s2,0.9,2,2c0,0.18-0.02,0.36-0.07,0.52l2.55,2.55C14.64,12.02,14.82,12,15,12c0.18,0,0.36,0.02,0.52,0.07 l3.55-3.56C19.02,8.35,19,8.18,19,8c0-1.1,0.9-2,2-2S23,6.9,23,8z" />
                                </g>
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.grades') }}</span></a>
                </li>
            @endcan
            @can('view_years')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.academic_years.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" width="24px"
                            fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"
                                opacity=".9" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.academic_years') }}</span></a>
                </li>
            @endcan
            @can('view_classrooms')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.classrooms.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" width="24px"
                            fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path
                                d="M21 3H3c-1.1 0-2 .9-2 2v3h2V5h18v14h-7v2h7c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM1 18v3h3c0-1.66-1.34-3-3-3zm0-4v2c2.76 0 5 2.24 5 5h2c0-3.87-3.13-7-7-7zm0-4v2c4.97 0 9 4.03 9 9h2c0-6.08-4.93-11-11-11zm10 1.09v2L14.5 15l3.5-1.91v-2L14.5 13 11 11.09zM14.5 6L9 9l5.5 3L20 9l-5.5-3z" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.classes') }}</span></a>
                </li>
            @endcan
            @can('view_sections')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.sections.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" width="24px"
                            fill="#e3e3e3">
                            <g>
                                <rect fill="none" height="24" width="24" x="0" />
                            </g>
                            <g>
                                <g>
                                    <rect height="14" opacity=".3" width="4" x="5" y="5" />
                                    <rect height="4" opacity=".3" width="4" x="15" y="15" />
                                    <rect height="4" opacity=".3" width="4" x="15" y="5" />
                                    <path d="M3,5v14c0,1.1,0.89,2,2,2h6V3H5C3.89,3,3,3.9,3,5z M9,19H5V5h4V19z" />
                                    <path d="M19,3h-6v8h8V5C21,3.9,20.1,3,19,3z M19,9h-4V5h4V9z" />
                                    <path d="M13,21h6c1.1,0,2-0.9,2-2v-6h-8V21z M15,15h4v4h-4V15z" />
                                </g>
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.sections') }}</span></a>
                </li>
            @endcan

            <!-- START USERS MANAGEMENT -->
            <li class="side-item side-item-category">{{ __('admin.sidebar.users') }}</li>
            @canany(['view_teachers', 'view_specializations'])
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <g>
                                <rect fill="none" height="24" width="24" />
                            </g>
                            <g>
                                <g>
                                    <g opacity=".3">
                                        <path
                                            d="M11.34,9.76L9.93,8.34C8.98,7.4,7.73,6.88,6.39,6.88C5.76,6.88,5.14,7,4.57,7.22l1.04,1.04h2.28v2.14 c0.4,0.23,0.86,0.35,1.33,0.35c0.73,0,1.41-0.28,1.92-0.8L11.34,9.76z" />
                                    </g>
                                    <g opacity=".3">
                                        <path
                                            d="M11,6.62l6,5.97V14h-1.41l-2.83-2.83l-0.2,0.2c-0.46,0.46-0.99,0.8-1.56,1.03V15h6v2c0,0.55,0.45,1,1,1s1-0.45,1-1V6h-8 V6.62z" />
                                    </g>
                                    <g>
                                        <path
                                            d="M9,4v1.38c-0.83-0.33-1.72-0.5-2.61-0.5c-1.79,0-3.58,0.68-4.95,2.05l3.33,3.33h1.11v1.11c0.86,0.86,1.98,1.31,3.11,1.36 V15H6v3c0,1.1,0.9,2,2,2h10c1.66,0,3-1.34,3-3V4H9z M7.89,10.41V8.26H5.61L4.57,7.22C5.14,7,5.76,6.88,6.39,6.88 c1.34,0,2.59,0.52,3.54,1.46l1.41,1.41l-0.2,0.2c-0.51,0.51-1.19,0.8-1.92,0.8C8.75,10.75,8.29,10.63,7.89,10.41z M19,17 c0,0.55-0.45,1-1,1s-1-0.45-1-1v-2h-6v-2.59c0.57-0.23,1.1-0.57,1.56-1.03l0.2-0.2L15.59,14H17v-1.41l-6-5.97V6h8V17z" />
                                    </g>
                                </g>
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.teachers') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        @can('view_teachers')
                            <li><a class="slide-item"
                                    href="{{ route('admin.teachers.index') }}">{{ __('admin.sidebar.teachers') }}</a></li>
                        @endcan
                        @can('view_teacher_assignments')
                            <li><a class="slide-item"
                                    href="{{ route('admin.teacher_assignments.index') }}">{{ __('admin.sidebar.teacher_assignments') }}</a>
                            </li>
                        @endcan
                        @can('view_specializations')
                            <li><a class="slide-item"
                                    href="{{ route('admin.specializations.index') }}">{{ __('admin.specializations.title') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @can('view_students')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M7 12.27v3.72l5 2.73 5-2.73v-3.72L12 15zM5.18 9 12 12.72 18.82 9 12 5.28z"
                                opacity=".3" />
                            <path
                                d="M12 3 1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm5 12.99-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72zm-5-3.27L5.18 9 12 5.28 18.82 9 12 12.72z" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.students') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item"
                                href="{{ route('admin.students.index') }}">{{ __('admin.sidebar.students') }}</a></li>
                        @can('promote_students')
                            <li><a class="slide-item"
                                    href="{{ route('admin.students.promotions.index') }}">{{ __('admin.sidebar.promotions') }}</a>
                            </li>
                        @endcan
                        @can('graduate_students')
                            <li><a class="slide-item" href="#">{{ __('admin.sidebar.graduations') }}</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('view_guardians')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.guardians.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <g>
                                <rect fill="none" height="24" width="24" />
                                <path
                                    d="M16,4c0-1.11,0.89-2,2-2s2,0.89,2,2s-0.89,2-2,2S16,5.11,16,4z M20,22v-6h2.5l-2.54-7.63C19.68,7.55,18.92,7,18.06,7h-0.12 c-0.86,0-1.63,0.55-1.9,1.37l-0.86,2.58C16.26,11.55,17,12.68,17,14v8H20z M12.5,11.5c0.83,0,1.5-0.67,1.5-1.5s-0.67-1.5-1.5-1.5 S11,9.17,11,10S11.67,11.5,12.5,11.5z M5.5,6c1.11,0,2-0.89,2-2s-0.89-2-2-2s-2,0.89-2,2S4.39,6,5.5,6z M7.5,22v-7H9V9 c0-1.1-0.9-2-2-2H4C2.9,7,2,7.9,2,9v6h1.5v7H7.5z M14,22v-4h1v-4c0-0.82-0.68-1.5-1.5-1.5h-2c-0.82,0-1.5,0.68-1.5,1.5v4h1v4H14z" />
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.guardians') }}</span></a>
                </li>
            @endcan
            @can('view_admins')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.admins.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <g>
                                <path d="M0,0h24v24H0V0z" fill="none" />
                            </g>
                            <g>
                                <g>
                                    <g>
                                        <circle cx="10" cy="8" enable-background="new" opacity=".3"
                                            r="2" />
                                        <path
                                            d="M10,16c0-0.34,0.03-0.67,0.08-0.99C10.05,15,10.03,15,10,15 c-1.97,0-3.9,0.53-5.59,1.54C4.16,16.68,4,17,4,17.35V18h6.29C10.1,17.37,10,16.7,10,16z"
                                            enable-background="new" opacity=".3" />
                                    </g>
                                    <path
                                        d="M4,18v-0.65c0-0.34,0.16-0.66,0.41-0.81C6.1,15.53,8.03,15,10,15c0.03,0,0.05,0,0.08,0.01c0.1-0.7,0.3-1.37,0.59-1.98 C10.45,13.01,10.23,13,10,13c-2.42,0-4.68,0.67-6.61,1.82C2.51,15.34,2,16.32,2,17.35V20h9.26c-0.42-0.6-0.75-1.28-0.97-2H4z M10,12c2.21,0,4-1.79,4-4s-1.79-4-4-4S6,5.79,6,8S7.79,12,10,12z M10,6c1.1,0,2,0.9,2,2s-0.9,2-2,2S8,9.1,8,8S8.9,6,10,6z" />
                                    <path
                                        d="M20.83,12.63l-1.45,0.49c-0.32-0.27-0.68-0.48-1.08-0.63L18,11h-2l-0.3,1.49c-0.4,0.15-0.76,0.36-1.08,0.63l-1.45-0.49 l-1,1.73l1.14,1c-0.03,0.21-0.06,0.41-0.06,0.63s0.03,0.42,0.06,0.63l-1.14,1l1,1.73l1.45-0.49c0.32,0.27,0.68,0.48,1.08,0.63 L16,21h2l0.3-1.49c0.4-0.15,0.76-0.36,1.08-0.63l1.45,0.49l1-1.73l-1.14-1c0.03-0.21,0.06-0.41,0.06-0.63s-0.03-0.42-0.06-0.63 l1.14-1L20.83,12.63z M17,18c-1.1,0-2-0.9-2-2c0-1.1,0.9-2,2-2s2,0.9,2,2C19,17.1,18.1,18,17,18z" />
                                </g>
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.admins') }}</span></a>
                </li>
            @endcan
            @can('view_roles')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.roles.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <circle cx="11" cy="8" opacity=".3" r="2" />
                            <path d="M5 18h4.99L9 17l.93-.94C7.55 16.33 5.2 17.37 5 18z" opacity=".3" />
                            <path
                                d="M11 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm-1 12H5c.2-.63 2.55-1.67 4.93-1.94h.03l.46-.45L12 14.06c-.39-.04-.68-.06-1-.06-2.67 0-8 1.34-8 4v2h9l-2-2zm10.6-5.5l-5.13 5.17-2.07-2.08L12 17l3.47 3.5L22 13.91z" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.roles') }}</span></a>
                </li>
            @endcan

            <!-- START LMS & OPERATIONS -->
            <li class="side-item side-item-category">{{ __('admin.sidebar.lms') }}</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.attendances.index') }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                        width="24px" fill="#e3e3e3">
                        <g>
                            <rect fill="none" height="24" width="24" />
                        </g>
                        <g>
                            <rect height="2" opacity=".3" width="14" x="5" y="6" />
                            <path
                                d="M19,4h-1V2h-2v2H8V2H6v2H5C3.89,4,3.01,4.9,3.01,6L3,20c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V6C21,4.9,20.1,4,19,4z M19,20 H5V10h14V20z M19,8H5V6h14V8z M9,14H7v-2h2V14z M13,14h-2v-2h2V14z M17,14h-2v-2h2V14z M9,18H7v-2h2V18z M13,18h-2v-2h2V18z M17,18 h-2v-2h2V18z" />
                        </g>
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.attendance') }}</span></a>
            </li>
            @can('view_subjects')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.subjects.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="m13 13-3-2.25L7 13V4H6v16h12V4h-5z" opacity=".3" />
                            <path
                                d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 4h2v5l-1-.75L9 9V4zm9 16H6V4h1v9l3-2.25L13 13V4h5v16z" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.subjects') }}</span></a>
                </li>
            @endcan
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.exams.index') }}"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                        width="24px" fill="#e3e3e3">
                        <g>
                            <path d="M0,0h24v24H0V0z" fill="none" />
                        </g>
                        <g>
                            <path
                                d="M8,4v12h12V4H8z M14.74,14.69C14.54,14.9,14.3,15,14.01,15c-0.29,0-0.54-0.1-0.74-0.31 c-0.21-0.21-0.31-0.45-0.31-0.74c0-0.29,0.1-0.54,0.31-0.74c0.21-0.2,0.45-0.3,0.74-0.3c0.29,0,0.54,0.1,0.74,0.3 c0.2,0.2,0.3,0.45,0.3,0.74C15.05,14.24,14.94,14.49,14.74,14.69z M16.51,8.83c-0.23,0.34-0.54,0.69-0.92,1.06 c-0.3,0.27-0.51,0.52-0.64,0.75c-0.12,0.23-0.18,0.49-0.18,0.78v0.4h-1.52v-0.56c0-0.42,0.09-0.78,0.26-1.09 C13.69,9.85,14,9.5,14.46,9.1c0.32-0.29,0.55-0.54,0.69-0.74c0.14-0.2,0.21-0.44,0.21-0.72c0-0.36-0.12-0.65-0.36-0.87 c-0.24-0.23-0.57-0.34-0.99-0.34c-0.4,0-0.72,0.12-0.97,0.36c-0.25,0.24-0.42,0.53-0.53,0.87l-1.37-0.57 c0.18-0.55,0.52-1.03,1-1.45C12.63,5.21,13.25,5,13.99,5c0.56,0,1.05,0.11,1.49,0.33c0.44,0.22,0.78,0.53,1.02,0.93 c0.24,0.4,0.36,0.84,0.36,1.33C16.86,8.08,16.75,8.49,16.51,8.83z"
                                opacity=".3" />
                            <path
                                d="M4,6H2v14c0,1.1,0.9,2,2,2h14v-2H4V6z M20,2H8C6.9,2,6,2.9,6,4v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V4 C22,2.9,21.1,2,20,2z M20,16H8V4h12V16z M13.51,10.16c0.41-0.73,1.18-1.16,1.63-1.8c0.48-0.68,0.21-1.94-1.14-1.94 c-0.88,0-1.32,0.67-1.5,1.23l-1.37-0.57C11.51,5.96,12.52,5,13.99,5c1.23,0,2.08,0.56,2.51,1.26c0.37,0.6,0.58,1.73,0.01,2.57 c-0.63,0.93-1.23,1.21-1.56,1.81c-0.13,0.24-0.18,0.4-0.18,1.18h-1.52C13.26,11.41,13.19,10.74,13.51,10.16z M12.95,13.95 c0-0.59,0.47-1.04,1.05-1.04c0.59,0,1.04,0.45,1.04,1.04c0,0.58-0.44,1.05-1.04,1.05C13.42,15,12.95,14.53,12.95,13.95z" />
                        </g>
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.exams') }}</span></a>
            </li>
            @can('view_online_classes')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.online_classes.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <g>
                                <rect fill="none" height="24" width="24" />
                            </g>
                            <g>
                                <path
                                    d="M20,3H4C2.9,3,2,3.9,2,5v12c0,1.1,0.9,2,2,2h4v2h8v-2h4c1.1,0,1.99-0.9,1.99-2L22,5C22,3.9,21.1,3,20,3z M20,17H4V5h16V17 z M5,14v2h2C7,14.89,6.11,14,5,14z M5,11v1.43c1.97,0,3.57,1.6,3.57,3.57H10C10,13.24,7.76,11,5,11z M5,8v1.45 c3.61,0,6.55,2.93,6.55,6.55H13C13,11.58,9.41,8,5,8z" />
                                <rect height="12" opacity=".3" width="16" x="4" y="5" />
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.zoom') }}</span></a>
                </li>
            @endcan
            <li class="slide">
                @can('view_library')
                    <a class="side-menu__item" href="{{ route('admin.library.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M20 4h-1v9l-3-2.25L13 13V4H8v12h12z" opacity=".3" />
                            <path
                                d="M4 22h14v-2H4V6H2v14c0 1.1.9 2 2 2zm18-6V4c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2zM15 4h2v5l-1-.75L15 9V4zM8 4h5v9l3-2.25L19 13V4h1v12H8V4z" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.library') }}</span></a>
                @endcan
            </li>
            <!-- START  Accounts -->
            <li class="side-item side-item-category">{{ __('admin.sidebar.accounts') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                        width="24px" fill="#e3e3e3">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M11.5 17.1c-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79z" />
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.fees_parent') }}</span><i
                        class="angle fe fe-chevron-down"></i></a>
                <ul class="slide-menu">
                    @can('view_fee_categories')
                        <li><a class="slide-item"
                                href="{{ route('admin.fee_categories.index') }}">{{ __('admin.sidebar.fee_categories') }}</a>
                        </li>
                    @endcan
                    @can('view_fees')
                        <li><a class="slide-item"
                                href="{{ route('admin.fees.index') }}">{{ __('admin.sidebar.fees') }}</a></li>
                    @endcan
                    @can('view_currencies')
                        <li><a class="slide-item"
                                href="{{ route('admin.currencies.index') }}">{{ __('admin.sidebar.currencies') }}</a>
                        </li>
                    @endcan

                </ul>
            </li>
            @can('view_invoices')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.invoices.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M5 19.09h14V4.91H5v14.18zM6 7h12v2H6V7zm0 4h12v2H6v-2zm0 4h12v2H6v-2z"
                                opacity=".3" />
                            <path
                                d="M19.5 3.5L18 2l-1.5 1.5L15 2l-1.5 1.5L12 2l-1.5 1.5L9 2 7.5 3.5 6 2 4.5 3.5 3 2v20l1.5-1.5L6 22l1.5-1.5L9 22l1.5-1.5L12 22l1.5-1.5L15 22l1.5-1.5L18 22l1.5-1.5L21 22V2l-1.5 1.5zM19 19.09H5V4.91h14v14.18zM6 15h12v2H6zm0-4h12v2H6zm0-4h12v2H6z" />
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.invoices') }}</span></a>
                </li>
            @endcan
            @can('view_receipts')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('admin.receipts.index') }}"><svg
                            xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                            width="24px" fill="#e3e3e3">
                            <path d="M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z" opacity=".3" />
                            <path d="M0,0h24v24H0V0z" fill="none" />
                            <g>
                                <path
                                    d="M19.5,3.5L18,2l-1.5,1.5L15,2l-1.5,1.5L12,2l-1.5,1.5L9,2L7.5,3.5L6,2v14H3v3c0,1.66,1.34,3,3,3h12c1.66,0,3-1.34,3-3V2 L19.5,3.5z M19,19c0,0.55-0.45,1-1,1s-1-0.45-1-1v-3H8V5h11V19z" />
                                <rect height="2" width="6" x="9" y="7" />
                                <rect height="2" width="2" x="16" y="7" />
                                <rect height="2" width="6" x="9" y="10" />
                                <rect height="2" width="2" x="16" y="10" />
                            </g>
                        </svg><span class="side-menu__label">{{ __('admin.sidebar.receipts') }}</span></a>
                </li>
            @endcan
            <li class="slide">
                <a class="side-menu__item" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon" viewBox="0 0 24 24" width="24px" fill="#e3e3e3">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M4 6h16v2H4zm0 6h16v6H4z" opacity=".3" />
                        <path
                            d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.payment') }}</span></a>
            </li>

            <li class="side-item side-item-category">{{ __('admin.sidebar.reports_settings') }}</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#"><svg
                        xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"
                        width="24px" fill="#e3e3e3">
                        <g>
                            <rect height="14" opacity=".3" width="14" x="5" y="5" />
                            <g>
                                <rect fill="none" height="24" width="24" />
                                <g>
                                    <path
                                        d="M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M19,19H5V5h14V19z" />
                                    <rect height="5" width="2" x="7" y="12" />
                                    <rect height="10" width="2" x="15" y="7" />
                                    <rect height="3" width="2" x="11" y="14" />
                                    <rect height="2" width="2" x="11" y="10" />
                                </g>
                            </g>
                        </g>
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.reports') }}</span><i
                        class="angle fe fe-chevron-down"></i></a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="#">{{ __('admin.sidebar.attendance_report') }}</a></li>
                    <li><a class="slide-item" href="#">{{ __('admin.sidebar.financial_report') }}</a></li>
                    <li><a class="slide-item" href="#">{{ __('admin.sidebar.grades_report') }}</a></li>
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3" />
                        <path
                            d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z" />
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.logs') }}</span></a>
            </li>
            @canany(['view_payment_gateways'])
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#"><svg xmlns="http://www.w3.org/2000/svg"
                        class="side-menu__icon" viewBox="0 0 24 24" width="24px" fill="#e3e3e3">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M19.28 8.6l-.7-1.21-1.27.51-1.06.43-.91-.7c-.39-.3-.8-.54-1.23-.71l-1.06-.43-.16-1.13L12.7 4h-1.4l-.19 1.35-.16 1.13-1.06.44c-.41.17-.82.41-1.25.73l-.9.68-1.05-.42-1.27-.52-.7 1.21 1.08.84.89.7-.14 1.13c-.03.3-.05.53-.05.73s.02.43.05.73l.14 1.13-.89.7-1.08.84.7 1.21 1.27-.51 1.06-.43.91.7c.39.3.8.54 1.23.71l1.06.43.16 1.13.19 1.36h1.39l.19-1.35.16-1.13 1.06-.43c.41-.17.82-.41 1.25-.73l.9-.68 1.04.42 1.27.51.7-1.21-1.08-.84-.89-.7.14-1.13c.04-.31.05-.52.05-.73 0-.21-.02-.43-.05-.73l-.14-1.13.89-.7 1.1-.84zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"
                            opacity=".3" />
                        <path
                            d="M19.43 12.98c.04-.32.07-.64.07-.98 0-.34-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.09-.16-.26-.25-.44-.25-.06 0-.12.01-.17.03l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61.25-1.17.59-1.69.98l-2.49-1c-.06-.02-.12-.03-.18-.03-.17 0-.34.09-.43.25l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.09.16.26.25.44.25.06 0 .12-.01.17-.03l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.06.02.12.03.18.03.17 0 .34-.09.43-.25l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zm-1.98-1.71c.04.31.05.52.05.73 0 .21-.02.43-.05.73l-.14 1.13.89.7 1.08.84-.7 1.21-1.27-.51-1.04-.42-.9.68c-.43.32-.84.56-1.25.73l-1.06.43-.16 1.13-.2 1.35h-1.4l-.19-1.35-.16-1.13-1.06-.43c-.43-.18-.83-.41-1.23-.71l-.91-.7-1.06.43-1.27.51-.7-1.21 1.08-.84.89-.7-.14-1.13c-.03-.31-.05-.54-.05-.74s.02-.43.05-.73l.14-1.13-.89-.7-1.08-.84.7-1.21 1.27.51 1.04.42.9-.68c.43-.32.84-.56 1.25-.73l1.06-.43.16-1.13.2-1.35h1.39l.19 1.35.16 1.13 1.06.43c.43.18.83.41 1.23.71l.91.7 1.06-.43 1.27-.51.7 1.21-1.07.85-.89.7.14 1.13zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                    </svg><span class="side-menu__label">{{ __('admin.sidebar.settings') }}</span><i
                        class="angle fe fe-chevron-down"></i></a>
                <ul class="slide-menu">
                    @can('view_payment_gateways')
                        <li><a class="slide-item"
                                href="{{ route('admin.payment_gateways.index') }}">{{ __('admin.sidebar.settings_payment_gateways') }}</a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany
        </ul>
    </div>
</aside>
<!-- main-sidebar -->
