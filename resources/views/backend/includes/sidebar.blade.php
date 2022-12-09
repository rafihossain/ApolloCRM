<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu"> 
    <div class="h-100" data-simplebar> 
        <!-- User box -->
        <div class="user-box text-center"></div>

        <!--- Sidemenu -->
        <div id="sidebar-menu"> 
            <ul id="side-menu">
                <li>
                    <a href="{{route('backend.dashboard')}}">
                        <i class="fas fa-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('backend.office-visit-waiting') }}">
                        <i class="mdi mdi-account-arrow-right-outline mdi-18px"></i>
                        <span> Office Check In </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('backend.manage-clients') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Client </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('backend.quotations-active-list') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Quotations </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('backend.manage-application') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Application </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('backend.manage-partner') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Partner </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('backend.manage-product') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Product </span>
                    </a>
                </li>
                <li>
                    <a href="#team" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document-multiple-outline mdi-18px"></i>
                        <span>Teams</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="team">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('backend.manage-offices') }}">Offices</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.manage-users') }}">Users</a>
                            </li>
                            <li>
                                <a href="{{ url('/test') }}">Roles</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('backend.agent-active-list') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Agents </span>
                    </a>
                </li>
                <li>
                    <a href="#Settings" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document-multiple-outline mdi-18px"></i>
                        <span>Settings</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Settings">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('backend.company-profile') }}"> Preferences</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.tag-management') }}"> Tag Management </a>
                            </li> 
                            <li>
                                <a href="{{ route('backend.setting-subscription') }}"> Subscription & Billing </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-account') }}"> Accounts </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-workflow') }}"> Workflows </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-email') }}"> Company Email </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-template-email') }}"> Templates </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.phone-setting') }}"> Phone Settings </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-lead-form') }}"> Lead Forms </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-automation') }}"> Advanced Automation Settings </a>
                            </li>
                            <li>
                                <a href="{{ route('backend.customfield-client') }}">Custom Fields</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.pp-type-list') }}">General</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.dataimport-partner-product') }}">Data Import</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-office-checkin') }}">Office Checkin</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.setting-automation') }}">API & Integrations</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('backend.list-task') }}">
                        <i class="mdi mdi-account-multiple-outline mdi-18px"></i>
                        <span> Tasks </span>
                    </a>
                </li>
                  <li>
                    <a href="#Reports" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document-multiple-outline mdi-18px"></i>
                        <span>Reports</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Reports">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('backend.report_client') }}">Client</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.report_application') }}">Applications</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.report_invoice') }}">Invoice</a>
                            </li>
                             <li>
                                <a href="{{ url('/reportofficevisit') }}">Office Check-In</a>
                            </li>
                            <li>
                                <a href="{{ url('/reportsalesforecast_application') }}">Sales Forecast</a>
                            </li>
                            <li>
                                <a href="{{ route('backend.report_personaltask') }}">Tasks</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ url('/') }}">
                        <i class="fe-log-out mdi-24px"></i>
                        <span>Logout </span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End