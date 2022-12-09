@extends('backend.layouts.app')
@section('content')

<style>
    .innerTitle {
        font-weight: 600;
        font-size: 0.8rem;
        padding: 15px 30px;
        text-transform: uppercase;
    }

    .formPage-lg {
        padding: 10px 30px;
    }
</style>


<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-12">
                <div class="text-end">
                    <a class="btn btn-primary" href="{{ route('backend.add-partner') }}"><i class="mdi mdi-plus"></i> Add Partner</a>
                </div>
                @if(Session::has('success'))
                <div class="alert alert-success" style="text-align: center;">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="card">
                    <div class="card-body table-responsive">
                        <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Name</th>
                                    <th>Sync</th>
                                    <th>Workflow</th>
                                    <th>Partner Type</th>
                                    <th>City</th>
                                    <th>Product</th>
                                    <th>Enrolled</th>
                                    <th>In Progress</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($partners))
                                    @foreach($partners as $partner)
                                    <tr>
                                        <td>
                                            <div class="overflow-hidden">
                                                <div class="float-start me-2">
                                                    <img src="{{ asset($partner->partner_image) }}" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
                                                </div>
                                                <div>
                                                    <div class="text-truncate">
                                                        <a href="{{ route('backend.partner-profile-application', ['id' => $partner->id]) }}">
                                                        {{ $partner->name }}
                                                        </a>
                                                    </div>
                                                    <div class="text-truncate">
                                                        <a href="mailto:info@sydneymet.edu.au">info@sydneymet.edu.au</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ '-' }}</td>
                                        <td></td>
                                        <td>{{ $partner->partnerType->partner_type }}</td>
                                        <td>{{ $partner->city }}</td>
                                        <td>{{ $partner->product_id }}</td>
                                        <td>{{ $partner->enrolled }}</td>
                                        <td>{{ $partner->in_progress }}</td>
                                        <td>
                                            <a href="{{ route('backend.partneredit', ['id' => $partner->id]) }}" class="btn btn-sm btn-primary waves-effect waves-light"><i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="{{ route('backend.partnerdelete', ['id' => $partner->id]) }}" id="delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="mdi mdi-trash-can-outline"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end row -->

    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
<script>
    //delete sweetalert
    $(document).on('click', '#delete', function(e) {
        e.preventDefault();
        var Id = $(this).attr('href');

        swal({
                title: "Are you sure?",
                text: "You want to delete!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Successfully deleted!", {
                        icon: "success",
                    });

                    window.location.href = Id;

                } else {
                    swal("safe!");
                }

            });
    });
</script>
@endsection