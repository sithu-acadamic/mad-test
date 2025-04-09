@foreach($brands as $brand)
    <div class="card mb-2">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <input type="checkbox" class="shopCheckbox" data-id="{{ $brand->id }}" />
                <label class="form-check-label">
                    @if($brand->vendorCompany->isNotEmpty())
                        {{ $brand->vendorCompany->first()->company_name }}
                    @else
                        No Company Found
                    @endif
                </label>
            </div>
            <i class="fa fa-eye text-primary" style="cursor: pointer;"></i>
        </div>
    </div>
@endforeach
