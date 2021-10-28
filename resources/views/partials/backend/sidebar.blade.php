<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{{asset('img/profile/'.Auth::user()->image)}}" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</strong></a>                    
                <ul class="dropdown-menu dropdown-menu-right account animated flipInY">
                    <li><router-link to="/member_area/profile"><i class="icon-user"></i>My Profile</router-link></li>
                    <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                    <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
            <hr>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#coop_menu">Cooperators</a></li>
            @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin') || Auth::user()->hasRole('Super Admin'))
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#admin_menu">Admin</a></li>
            @endif
        </ul>
            
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane animated fadeIn active" id="coop_menu">
                <nav class="sidebar-nav">
                    <ul class="main-menu metismenu">
                        <li><router-link to="/member_area/dashboard"><i class="icon-speedometer"></i><span>Dashboard</span></router-link></li>
                        <li><router-link to="/member_area/profile"><i class="icon-user"></i>Profile</router-link>
                        <li>
                            <a href="#" class="has-arrow"><i class="icon-wallet"></i><span>Savings</span></a>
                            <ul>
                                <li><router-link to="/member_area/savings/create">Create SPS Account</router-link></li>
                                <li><router-link to="/member_area/contribution/create">Add Contribution</router-link></li>
                                <li><router-link to="/member_area/savings/">Savings Accounts</router-link></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="has-arrow"><i class="icon-book-open"></i><span>Loans</span></a>
                            <ul>
                                <li><router-link to="/member_area/loans/create">Apply For Loan</router-link></li>
                                <li><router-link to="/member_area/repayments">Add Repayment</router-link></li>
                                <li><router-link to="/member_area/loans">Loans</router-link></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Withdrawals" class="has-arrow"><i class="icon-share-alt"></i><span>Withdrawals</span></a>
                            <ul>
                                <li><router-link to="/member_area/withdrawals/create">Apply</router-link></li>
                                <li><router-link to="/member_area/withdrawals">History</router-link></li>
                            </ul>
                        </li>
                        <li><router-link to="/member_area/closures"><i class="icon-close"></i>Closure</router-link>
                        <li>
                            <a href="#Guarantors" class="has-arrow"><i class="icon-user-following"></i><span>Guarantors</span></a>
                            <ul>
                                <li><router-link to="/member_area/guarantors">My Guarantor</router-link></li>
                                <li><router-link to="/member_area/guarantees">Request Guarantee</router-link></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#Guarantors" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-login"></i><span>Log Out</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="tab-pane animated fadeIn" id="admin_menu">
                <nav class="sidebar-nav">
                    <ul class="main-menu metismenu">
                        <li><router-link to="/admin_area/dashboard"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>
                        <li>
                            <a to="#Cooperators" class="has-arrow"><i class="icon-users"></i><span>Cooperators</span></a>
                            <ul>
                                @if (Auth::user()->hasRole('Branch Admin'))
                                <li><router-link :to="'/admin_area/members/'+ {{Auth::user()->branch_id}}">My Members</router-link></li>
                                @endif
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin') || Auth::user()->hasRole('Admin'))
                                <li><router-link to="/admin_area/members">All Members</router-link></li>
                                @endif
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin') || Auth::user()->hasRole('Financial Admin'))
                                <li><router-link to="/admin_area/savings/all">See Member Contributions</router-link></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a to="#Projects" class="has-arrow"><i class="icon-list"></i><span>Savings</span></a>
                            <ul>
                                <li><router-link to="/admin_area/savings/create">Add Member Saving Account</router-link></li>
                                <li><router-link to="/admin_area/contributions/create">Add Member Contribution</router-link></li>
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin'))
                                <li><a href="/contributions">Upload Excel</a></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a to="#Projects" class="has-arrow"><i class="icon-list"></i><span>Loans</span></a>
                            <ul>
                                <li><router-link to="/admin_area/loans/create">Add Member Loan Account</router-link></li>
                                <li><router-link to="/admin_area/repayments/create">Add Member Repayment</router-link></li>
                                <li><router-link to="/repayments">Upload Excel</router-link></li>
                                <li><router-link to="/admin_area/loans/active">Active Loans</router-link></li>
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin'))
                                <li><router-link to="/admin_area/loans/pending">Pending Loans</router-link></li>
                                @endif
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Financial Admin'))
                                <li><router-link to="/admin_area/repayments/all">See Member Repayments</router-link></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a to="#Projects" class="has-arrow"><i class="icon-list"></i><span>Withdrawals</span></a>
                            <ul>
                                <li><router-link to="/admin_area/withdrawals/all">All Withdrawals</router-link></li>
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin'))
                                <li><a href="/admin_area/withdrawals/pending">Pending Withdrawals</a></li>
                                @endif
                            </ul>
                        </li>
                        <li>
                            <a to="#Projects" class="has-arrow"><i class="icon-list"></i><span>Closures</span></a>
                            <ul>
                                <li><router-link to="/admin_area/closures/all">All Closures</router-link></li>
                                @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Deanery Admin'))
                                <li><a href="/admin_area/closures/pending">Pending Closures</a></li>
                                @endif
                            </ul>
                        </li>
                        @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Financial Admin'))
                        <li>
                            <a to="#Projects" class="has-arrow"><i class="icon-list"></i><span>Payments</span></a>
                            <ul>
                                <li><router-link to="/admin_area/payments/recent">Recent Payments</router-link></li>
                                <li><router-link to="/admin_area/payments/unconfirm">Unconfirmed Payments</router-link></li>
                            </ul>
                        </li>
                        @endif
                    </ul>                        
                </nav>                    
            </div>            
        </div>          
    </div>
</div>
