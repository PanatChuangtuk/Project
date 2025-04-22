<div class="input-group me-2" style="width: 150px;">
    <select class="form-select" id="statusFilter" name="status" onchange="this.form.submit()">
        <option value="" {{ request()->input('status') == '' ? 'selected' : '' }}>
            กรองตามสถานะ
        </option>
        <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>
            เปิดใช้งาน
        </option>
        <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>
            ปิดใช้งาน
        </option>
    </select>
</div>
