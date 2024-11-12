<div class="input-group me-2" style="width: 150px;">
    <select class="form-select" id="statusFilter" name="status" onchange="this.form.submit()">
        <option value="" {{ request()->input('status') == '' ? 'selected' : '' }}>
            Filter by Status
        </option>
        <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>
            Active
        </option>
        <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>
            Inactive
        </option>
    </select>
</div>