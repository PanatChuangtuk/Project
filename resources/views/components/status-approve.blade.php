<div class="col-12 d-flex justify-content-center align-items-center">
    <label class="switch switch-square">
        <input type="checkbox" class="switch-input" id="approveSwitch{{ $item }}" data-id="{{ $item }}"
            {{ $status ? 'checked' : '' }} />
        <span class="switch-toggle-slider">
            <span class="switch-on text-white bg-success"></span>
            <span class="switch-off text-white bg-danger"></span>
        </span>
        <span class="switch-label"></span>
    </label>
</div>
