@if($errors->any())
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle me-2"></i><strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
