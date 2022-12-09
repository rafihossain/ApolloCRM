<ul class="nav nav-tabs nav-bordered border-0">
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-application', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-application' ? 'active' : ''}}">
            Applications
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-product', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-product' ? 'active' : ''}}">
            Products
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-branche', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-branche' ? 'active' : ''}}">
            Branches
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-agreement', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-agreement' ? 'active' : ''}}">
            Agreements
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-contact', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-contact' ? 'active' : ''}}">
            Contacts
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-note', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-note' ? 'active' : ''}}">
            Notes & Terms
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-document', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-document' ? 'active' : ''}}">
            Documents
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-appointment', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-appointment' ? 'active' : ''}}">
            Appointments
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-account', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-account' ? 'active' : ''}}">
            Accounts
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-conversation', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-conversation' ? 'active' : ''}}">
            Conversations
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-task', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-task' ? 'active' : ''}}">
            Tasks
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-otherinformation', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-otherinformation' ? 'active' : ''}}">
            Other Information
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.partner-profile-promotion', ['id' => $partner->id]) }}" 
            class="nav-link {{request()->route()->getName() == 'backend.partner-profile-promotion' ? 'active' : ''}}">
            Promotions
        </a>
    </li>
</ul>