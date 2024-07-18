

@if (!empty($errors) && $errors->any())
<div class="alert alert-danger">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
   
    <strong>{{ trans('general/admin_lang.corregir_errores') }}</strong>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(Session::has('error-alert'))
    <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
        <strong>{{ date('d/m/Y H:i:s') }}</strong>
        {{ Session::get('error-alert') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true" aria-label="Close"></button>
    </div>
@endif

