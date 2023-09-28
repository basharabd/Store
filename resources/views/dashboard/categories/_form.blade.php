<div class="mb-3 form-group">


  <x-form.input label="Category Name" name="name" type="text" value="{{ $category->name }}" class="form-control"
    role="input" />

</div>
<hr />

<div class="mb-3 form-group">
  <x-form.textarea label="Description Category" name="description" value="{{ $category->description }}" />
</div>

<div class="mb-3 form-group">
  <x-form.input label="Image Ctegory" name="image" type="file" accept="image/*" />

  @if ($category->image)
  <img src="{{ asset('uploads/'.$category->image) }}" height="90px" width="90px" alt="">
  @endif
  @error('image')
  <div class="invalid-feedback">
    {{ $message }}
  </div>
  @enderror
</div>


<div class="mb-3 form-group">
  <x-form.lable>Parent Category</x-form.lable>
  <select name="parent_id" @class([ 'form-select' , 'mb-3' , 'form-group' , 'form-control'
    , 'is-invalid'=>$errors->has('parent_id'),
    ])
    >


    <option value="">Primary Category</option>
    @foreach ($parents as $parent )
    <option value="{{ $parent->id }}" @selected(old('parent_id',$category->parent_id) ==$parent->id)>{{ $parent->name }}
    </option>
    @endforeach
  </select>

  @error('parent_id')
  <div class="invalid-feedback">
    {{ $message }}
  </div>
  @enderror

</div>

<div class="mb-3 form-group">
  <x-form.lable>Status Ctegory</x-form.lable>
  <x-form.redio name="status"
   checked="{{ $category->status }}"
   :options="['active'=>'Active'  , 'archvied'=>'Archvied']"
    />


</div>

<div class="mb-3 form-group">
  <button class="btn btn-sm btn-outline-primary" type="submit">{{ $button_lable ??'Save' }}</button>
</div>