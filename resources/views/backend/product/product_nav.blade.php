
{{ Request()->parameter }}

    <ul class="nav nav-tabs nav-bordered border-0">
        <li class="nav-item">
            <a href="{{ url('/admin/product/applications') }}/{{ $product['id'] }}" class="nav-link {{ ($type =='Applications' ? 'active':'') }}">
                Applications
            </a>
        </li> 
        <li class="nav-item">
            <a href="{{ url('/admin/product/document') }}/{{ $product['id'] }}" class="nav-link {{ ($type =='Documents' ? 'active':'') }}">
                Documents
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/admin/product/fees') }}/{{ $product['id'] }}" class="nav-link {{ ($type =='Fees' ? 'active':'') }}">
                Fees
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/admin/product/requirement') }}/{{ $product['id'] }}" class="nav-link {{ ($type =='Requirements' ? 'active':'') }}">
                Requirements
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/admin/product/otherinformation') }}/{{ $product['id'] }}" class="nav-link {{ ($type =='OtherInformation' ? 'active':'') }}">
                Other Information
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/admin/product/promotion') }}/{{ $product['id'] }}" class="nav-link {{ ($type =='Promotions' ? 'active':'') }}">
               Promotions
            </a>
        </li>
     </ul>