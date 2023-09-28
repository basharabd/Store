<div class="mb-3 form-group">


  <x-form.input label="Brand Name" name="name" type="text" value="{{ $brand->name }}" />

</div>
<hr />

<div class="mb-3 form-group">
  <x-form.textarea label="Description Brand" name="description" value="{{ $brand->description }}" />
</div>

<div class="mb-3 form-group">
  <x-form.input label="Image Brand" name="image" type="file" accept="image/*" />

  @if ($brand->image)
  <img src="{{ asset('uploads/'.$brand->image) }}" height="90px" width="90px" alt="">
  @endif
  @error('image')
  <div class="invalid-feedback">
    {{ $message }}
  </div>
  @enderror
</div>

 {{-- <div class="mb-3 form-group">
  <x-form.input label="Gallery" name="image_path[]" type="file"  multiple accept="image/*" />

  @if ($product->image_path)
  <img src="{{ $product->image_url }}" height="90px" width="90px" alt="">
  @endif

</div>  --}}




<div class="mb-3 form-group">
  <x-form.lable>Status Brand</x-form.lable>
  <x-form.redio name="status"
   checked="{{ $brand->status }}"
   :options="['active'=>'Active' , 'inactive'=>'InActive' ]"
    />


</div>

<div class="mb-3 form-group">
  <button class="btn btn-sm btn-outline-primary" type="submit">{{ $button_lable ??'Save' }}</button>
</div>
