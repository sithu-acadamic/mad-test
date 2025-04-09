
<input type="hidden" id="id" name="id" @if(isset($product)) value="{{\Illuminate\Support\Facades\Crypt::encrypt($product->id)}}" @endif>
<div class="col-md-4">
    <label for="product_type" class="my-3 mb-2">PRODUCT TYPE</label>
    <select class="form-control form-select" id="product_type" name="product_type">
        <option value="" ></option>
        @foreach($types as $type)
            <option value="{{ $type->id }}" @if(isset($product)) {{ ($type->id === $product->productType->id ) ? 'selected' : '' }} @endif>{{ $type->name }}</option>
        @endforeach
    </select>
</div>
<div class="col-md-4">
    <label for="product_name" class="my-3 mb-2">NAME</label>
    <input type="text" class="form-control" id="product_name" name="product_name" @if(isset($product)) value="{{ $product->name }}" @endif>
</div>
<div class="col-md-2">
    <label for="product_index" class="my-3 mb-2">PRODUCT INDEX</label>
    <select class="form-control form-select" id="product_index" name="product_index">
            <option value="" ></option>
        @for($index = 1; $index <= $produtCount; $index++)
            <option value="{{ $index }}" @if(isset($product)) {{ ($index === $product->product_index ) ? 'selected' : '' }} @endif>{{ $index }}</option>
        @endfor
    </select>
</div>
<div class="col-md-2">
    <label for="product_price" class="my-3 mb-2">PRICE</label>
    <input type="text" class="form-control" id="product_price" name="product_price" @if(isset($product)) value="{{ $product->price }}" @endif>
</div>
<div class="col-md-12">
    <label for="product_short_description" class="my-3 mb-2">Product Short Description</label>
    <textarea name="product_short_description" class="form-control" id="product_short_description" style="text-align:left;width:100%;">@if(isset($product)) {{ $product->short_description }} @endif</textarea>
</div>
<div class="col-md-12">
    <label for="product_description" class="my-3 mb-2">Product Description</label>
    <textarea name="product_description" class="form-control" id="product_description" style="text-align:left;width:100%;">@if(isset($product)) {{ $product->description }} @endif</textarea>
</div>
<div class="col-md-12">
    <label for="product_additional_information" class="my-3 mb-2">Additional information</label>
    <textarea name="product_additional_information" class="form-control" id="product_additional_information" style="text-align:left;width:100%;">@if(isset($product)) {{ $product->additional_information }} @endif</textarea>
</div>
<div class="col-md-3">
    <label for="product_image" class="my-3 mb-2">Product Image (Width = 420px, Hight = 520px)</label>
    @if(isset($product))
        @if(!empty($product->image))
            <div class="left-content m-2" style="display: flex; align-items: center;">
                <img src="{{asset('admin/assets/images/product_images/'.$product->image)}}" alt=""  style="width: 420PX; height: 520PX;">
            </div>
        @endif
    @endif
    <input type="file" id="product_image" name="product_image" class="form-control">
    @if(isset($product))
        <input type="hidden" id="image_old_value" name="image_old_value" value="{{  $product->image }}" class="form-control">
    @endif
</div>
<div class="row">
    <div class="col-sm-3 my-3" align="left">
        <a class="btn btn-info" id="btn-product">
            <span>SUBMIT</span>
        </a>
    </div>
</div>


