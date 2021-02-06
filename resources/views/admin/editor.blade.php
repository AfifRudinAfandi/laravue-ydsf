<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

  <label class="col-sm-2"></label>
  <div class="col-sm-8">

    @include('admin::form.error')
    <textarea class="form-control {{$class}}" id="{{$id}}" name="{{$name}}" placeholder="{{ $placeholder }}" {!! $attributes !!}>{{ old($column, $value) }}</textarea>

    @include('admin::form.help-block')

  </div>
</div>