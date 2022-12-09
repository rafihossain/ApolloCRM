<ul class="nav nav-tabs nav-bordered border-0">
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-activities', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-activities' ? 'active' : ''}}">
            Activities
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-applications', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-applications' ? 'active' : ''}}">
            Applications
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-services', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-services' ? 'active' : ''}}">
            Interested Services
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-documents', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-documents' ? 'active' : ''}}">
            Documents
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-appointments', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-appointments' ? 'active' : ''}}">
            Appointments
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-notes', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-notes' ? 'active' : ''}}">
            Notes & Terms
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-quotations', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-quotations' ? 'active' : ''}}">
            Quotations
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-accounts', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-accounts' ? 'active' : ''}}">
            Accounts
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-conversation', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-conversation' ? 'active' : ''}}">
            Conversations
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-tasks', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-tasks' ? 'active' : ''}}">
            Tasks
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-educations', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-educations' ? 'active' : ''}}">
            Education
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-informations', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-informations' ? 'active' : ''}}">
            Other Information
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backend.client-profile-logs', ['id' => $client->id]) }}"
        class="nav-link {{request()->route()->getName() == 'backend.client-profile-logs' ? 'active' : ''}}">
            Check-In Logs
        </a>
    </li>
</ul>