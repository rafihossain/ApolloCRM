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
        <form action="{{route('backend.product-update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $productType->id }}">
            <div class="mb-2">
                <label>Master Category <span class="text-danger">*</span></label>
                <select name="master_category_id" id="" class="form-control">
                    <option value="">Select a Master Category</option>
                    @foreach($masterCategories as $masterCategory)
                    <option value="{{ $masterCategory->id }}"
                    {{ $productType->masterCategory->master_category == $masterCategory->master_category ? 'selected' : '' }}
                    >{{ $masterCategory->master_category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-2">
                <label>Product Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="product_name" placeholder="Partner Name"
                value="{{ $productType->product_type }}">
            </div>
            <div class="form-check form-switch mb-2">
                <input type="hidden" name="product_status" value="0" />
                <input type="checkbox" class="form-check-input" id="customSwitch1" name="product_status" value="1"
                {{ $productType->product_status == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="customSwitch1">Publish</label>
            </div>
            <div class="text-center">
                <button class="btn btn-primary" type="submit"> Save </button>
            </div>
        </form>
    </div>
</div>



@endsection