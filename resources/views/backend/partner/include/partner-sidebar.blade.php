<div class="text-center">
    <div class="form-check form-switch mb-2 text-start">
        <input type="checkbox" class="form-check-input" id="customSwitch1">
        <label class="form-check-label" for="customSwitch1">Auto sync </label>
    </div>
    <div>
        <img src="{{ asset($partner->partner_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-xl">
    </div>
    <h4>{{ $partner->name }}</h4>
    <div>
        <a href="#" class="me-2 left-user-info">
            <i class="mdi mdi-forum-outline mdi-18px"></i>
        </a>
        <a href="#" class="me-2 left-user-info">
            <i class="mdi mdi-email-outline mdi-18px"></i>
        </a>
        <a href="{{ route('backend.partneredit', ['id' => $partner->id]) }}" class="me-2 left-user-info">
            <i class="mdi mdi-pencil mdi-18px"></i>
        </a>
        <a href="{{ route('backend.partnerdelete', ['id' => $partner->id]) }}" id="partner-delete" class="me-2 left-user-info">
            <i class="mdi mdi-delete mdi-18px"></i>
        </a>
    </div>
</div>
<hr />
<h5>General Information:</h5>
<div class="mb-2">
    <strong> Phone No: </strong> {{ $partner->phone_number }}
</div>
<div class="mb-2">
    <strong> Fax: </strong> {{ $partner->fax }}
</div>
<div class="mb-2">
    <strong> Email: </strong> {{ $partner->email }}
</div>
<div class="mb-2">
    <strong> Address: </strong> {{ $partner->street }}
</div>
<div class="mb-2">
    <strong>Website: </strong> {{ $partner->website }}
</div>
<div class="mb-2">
    <strong>Services: </strong>
    @isset($relatedWorkflow)
        @foreach($relatedWorkflow as $workflow)
            <span class="badge bg-success rounded-pill mb-3">{{ $workflow->service_workflow }}</span>
        @endforeach
    @endisset
</div>
<div class="mb-2">
    <strong>Added On: </strong> {{ $partner->created_at }}
</div>
<div class="mb-2">
    <strong>Business Registration Number: </strong> {{ $partner->registration_number }}
</div>
<div class="mb-2">
    <strong>Currency code: </strong> {{ $partner->currency_id }}
</div>