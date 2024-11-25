<div class="input-group" style="max-width: 350px;">
    <input type="text" id="searchInput" name="query" class="form-control"
        placeholder="Search ..." value="{{ request()->input('query') }}"
        aria-label="Search" style="height: 38px; padding: 0.375rem 0.75rem;">
    
    <div class="input-group-append">
        <button id="searchButton" class="btn btn-primary" type="submit" 
            style="min-width: 90px; margin-left: 1px; height: 38px; padding: 0.375rem 0.75rem;">Search</button>
        <button id="bulk-delete-button" class="btn btn-danger" type="button"
            style="min-width: 90px; visibility: hidden; height: 38px; padding: 0.375rem 0.75rem;">Delete</button>
    </div>
</div>
