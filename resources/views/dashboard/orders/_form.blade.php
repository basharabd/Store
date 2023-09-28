<div class="mb-3 form-group">


  <x-form.input label="Product Name" name="name" type="text" value="{{ $product->name }}" />

</div>
<hr />

<div class="mb-3 form-group">
  <x-form.textarea label="Description Product" name="description" value="{{ $product->description }}" />
</div>

<div class="mb-3 form-group">
  <x-form.input label="Image Product" name="image" type="file" accept="image/*" />

  @if ($product->image)
  <img src="{{ asset('uploads/'.$product->image) }}" height="90px" width="90px" alt="">
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
  <x-form.lable>Status Product</x-form.lable>
  <x-form.redio name="status"
   checked="{{ $product->status }}"
   :options="['active'=>'Active' , 'draft'=>'Draft' , 'archvied'=>'Archvied' ]"
    />


</div>

<div class="mb-3 form-group">
  <button class="btn btn-sm btn-outline-primary" type="submit">{{ $button_lable ??'Save' }}</button>
</div>