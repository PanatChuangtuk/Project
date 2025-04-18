@extends('main')

@section('title')
    Equipment Management
@endsection

@section('stylesheet')
    <style>
        .equipment-form {
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 2rem;
        }

        .form-header {
            background-image: linear-gradient(135deg, #1e824c, #27ae60);
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 1.5rem;
            margin: -2rem -2rem 2rem;
        }

        .form-header h3 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .form-control:focus {
            border-color: #27ae60;
            box-shadow: 0 0 0 0.2rem rgba(39, 174, 96, 0.25);
        }

        /* Multi-select styling */
        select[multiple] {
            height: auto;
            min-height: 120px;
            overflow-y: auto;
        }

        select[multiple] option {
            padding: 10px;
            margin-bottom: 2px;
            border-radius: 4px;
            position: relative;
        }

        select[multiple] option:hover {
            background-color: rgba(39, 174, 96, 0.1);
        }

        select[multiple] option:checked {
            background-color: rgba(39, 174, 96, 0.2);
            color: #1e824c;
            font-weight: 600;
        }

        .select-info {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
            font-style: italic;
        }

        .star {
            color: #e74c3c;
            margin-left: 4px;
        }

        .btn {
            border-radius: 8px;
            padding: 10px 24px;
            font-weight: 600;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #27ae60;
            border-color: #27ae60;
            box-shadow: 0 4px 6px rgba(39, 174, 96, 0.2);
        }

        .btn-primary:hover {
            background-color: #1e824c;
            border-color: #1e824c;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(39, 174, 96, 0.25);
        }

        .btn-secondary {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .breadcrumb {
            background: transparent;
            padding-left: 0;
        }

        textarea.form-control {
            min-height: 120px;
        }

        /* Make buttons more modern with hover effect */
        .btn-modern {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-modern:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            z-index: -2;
        }

        .btn-modern:before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            transition: all .3s;
            z-index: -1;
        }

        .btn-modern:hover:before {
            width: 100%;
        }

        /* Title styling */
        label.title {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }

        /* Increase space between buttons */
        .btn-space {
            margin-right: 16px;
        }

        /* Styling for equipment selection */
        .equipment-container {
            margin-top: 10px;
        }

        .equipment-selection {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .equipment-selection h5 {
            font-size: 1rem;
            font-weight: 600;
            color: #27ae60;
            margin-bottom: 12px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 8px;
        }

        .equipment-items {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .equipment-item {
            position: relative;
            padding: 8px 12px;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .equipment-item:hover {
            border-color: #27ae60;
            box-shadow: 0 2px 5px rgba(39, 174, 96, 0.1);
        }

        .equipment-item.selected {
            background-color: rgba(39, 174, 96, 0.1);
            border-color: #27ae60;
        }

        .equipment-item input[type="checkbox"] {
            margin-right: 5px;
        }

        .selected-equipment {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: #f0f8f1;
            border: 1px dashed #27ae60;
        }

        .selected-equipment h5 {
            color: #1e824c;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .selected-equipment-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .selected-equipment-list li {
            padding: 8px 12px;
            background-color: white;
            border-radius: 6px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e0e0e0;
        }

        .remove-equipment {
            color: #e74c3c;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .remove-equipment:hover {
            color: #c0392b;
        }

        .equipment-category-header {
            background-color: #f8f9fa;
            padding: 10px 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border-left: 4px solid #27ae60;
        }
    </style>
@endsection

@section('content')
    <div class="section section-profile bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    {{-- Include your sidebar navigation here --}}
                    {{-- <x-nav-profile /> --}}
                </div>

                <div class="col-lg-6">
                    <div class="equipment-form">
                        <div class="form-header">
                            <h3><i class="fas fa-tools mr-2"></i> Equipment Registration</h3>
                        </div>

                        {{-- <form action="{{ route('equipment.store') }}" method="POST">
                            @csrf --}}

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="equipment-category-header">
                                    <h5 class="mb-0">Select Equipment (Max 2 items from different categories)</h5>
                                </div>

                                <div class="equipment-container">
                                    <!-- Machinery Category -->
                                    <div class="equipment-selection">
                                        <h5>Machinery</h5>
                                        <div class="equipment-items">
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="machinery_drill"
                                                    data-category="machinery"> Drill Machine
                                            </div>
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="machinery_generator"
                                                    data-category="machinery"> Generator
                                            </div>
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="machinery_compressor"
                                                    data-category="machinery"> Air Compressor
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tools Category -->
                                    <div class="equipment-selection">
                                        <h5>Tools</h5>
                                        <div class="equipment-items">
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="tools_wrench"
                                                    data-category="tools"> Wrench Set
                                            </div>
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="tools_screwdriver"
                                                    data-category="tools"> Screwdriver Set
                                            </div>
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="tools_pliers"
                                                    data-category="tools"> Pliers
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Electronics Category -->
                                    <div class="equipment-selection">
                                        <h5>Electronics</h5>
                                        <div class="equipment-items">
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="electronics_multimeter"
                                                    data-category="electronics"> Multimeter
                                            </div>
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="electronics_soldering"
                                                    data-category="electronics"> Soldering Iron
                                            </div>
                                            <div class="equipment-item">
                                                <input type="checkbox" name="equipment[]" value="electronics_tester"
                                                    data-category="electronics"> Cable Tester
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Selected Equipment Summary -->
                                    <div class="selected-equipment">
                                        <h5><i class="fas fa-clipboard-list mr-2"></i> Selected Equipment</h5>
                                        <div id="selection-message">No equipment selected yet. Please select up to 2 items
                                            from different categories.</div>
                                        <ul class="selected-equipment-list" id="selected-equipment">
                                            <!-- Selected items will appear here -->
                                        </ul>
                                    </div>
                                </div>

                                @error('equipment')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="title">Serial Number</label>
                                    <input type="text" class="form-control" name="serial_number"
                                        value="{{ old('serial_number') }}" placeholder="Enter serial number" />
                                    @error('serial_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="form-group">
                                    <label class="title">Borrow Date</label>
                                    <input type="date" class="form-control" name="purchase_date"
                                        value="{{ old('purchase_date') }}" />
                                    @error('purchase_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label class="title">Description</label>
                                    <textarea class="form-control" name="description" rows="3" placeholder="Enter equipment description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="reset" class="btn btn-secondary btn-modern btn-space">Reset</button>
                            <button type="submit" class="btn btn-primary btn-modern">Save Equipment</button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const MAX_SELECTIONS = 2;
            const DIFFERENT_CATEGORIES = true;
            let selectedCategories = [];

            // Handle equipment selection
            $('.equipment-item input[type="checkbox"]').on('change', function() {
                const $this = $(this);
                const value = $this.val();
                const category = $this.data('category');
                const label = $this.parent().text().trim();

                if ($this.is(':checked')) {
                    // Check if we've already reached the maximum selections
                    const currentSelections = $('.equipment-item input[type="checkbox"]:checked').length;

                    // Check if we already have this category selected
                    if (DIFFERENT_CATEGORIES && selectedCategories.includes(category) && currentSelections >
                        0) {
                        alert(
                            'You can only select one item per category. Please deselect the previous item from this category first.'
                            );
                        $this.prop('checked', false);
                        return;
                    }

                    // Check if we've reached the maximum selections
                    if (currentSelections > MAX_SELECTIONS) {
                        alert('You can only select up to ' + MAX_SELECTIONS + ' items.');
                        $this.prop('checked', false);
                        return;
                    }

                    // Add to selected categories
                    selectedCategories.push(category);

                    // Add to selected items list
                    $('#selected-equipment').append(
                        `<li data-value="${value}" data-category="${category}">
                            <span>${label}</span>
                            <span class="remove-equipment"><i class="fas fa-times-circle"></i></span>
                        </li>`
                    );

                    // Add selected class to the item
                    $this.parent().addClass('selected');
                } else {
                    // Remove from selected categories
                    selectedCategories = selectedCategories.filter(cat => cat !== category);

                    // Remove from selected items list
                    $(`#selected-equipment li[data-value="${value}"]`).remove();

                    // Remove selected class from the item
                    $this.parent().removeClass('selected');
                }

                // Update the selection message
                updateSelectionMessage();
            });

            // Handle remove button click
            $(document).on('click', '.remove-equipment', function() {
                const $item = $(this).closest('li');
                const value = $item.data('value');
                const category = $item.data('category');

                // Uncheck the corresponding checkbox
                $(`input[value="${value}"]`).prop('checked', false).parent().removeClass('selected');

                // Remove from selected categories
                selectedCategories = selectedCategories.filter(cat => cat !== category);

                // Remove the item from the list
                $item.remove();

                // Update the selection message
                updateSelectionMessage();
            });

            // Handle reset button
            $('button[type="reset"]').on('click', function() {
                // Clear selected equipment
                $('#selected-equipment').empty();
                $('.equipment-item').removeClass('selected');
                selectedCategories = [];

                // Update the selection message
                updateSelectionMessage();
            });

            // Update selection message
            function updateSelectionMessage() {
                const count = $('#selected-equipment li').length;

                if (count === 0) {
                    $('#selection-message').show().text(
                        'No equipment selected yet. Please select up to 2 items from different categories.');
                } else {
                    $('#selection-message').hide();
                }
            }
        });
    </script>
@endsection
