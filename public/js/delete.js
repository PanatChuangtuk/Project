// Check All Checkbox
document.getElementById("checkAll").addEventListener("change", function () {
    const isChecked = this.checked;
    const checkboxes = document.querySelectorAll(".check-item");
    checkboxes.forEach((checkbox) => {
        checkbox.checked = isChecked;
    });
    toggleBulkDeleteButton();
});

// Toggle Bulk Delete Button Visibility
document.querySelectorAll(".check-item").forEach((checkbox) => {
    checkbox.addEventListener("change", toggleBulkDeleteButton);
});

function toggleBulkDeleteButton() {
    const checkboxes = document.querySelectorAll(".check-item");
    const anyChecked = Array.from(checkboxes).some(
        (checkbox) => checkbox.checked
    );
    document.getElementById("bulk-delete-button").style.visibility = anyChecked
        ? "visible"
        : "hidden";
}

// Single Delete Button
$(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const form = $("#deleteForm" + id);

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: form.serialize(),
                success: function (response) {
                    Swal.fire(
                        "Deleted!",
                        "Your item has been deleted.",
                        "success"
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire(
                        "Error!",
                        "An error occurred while deleting.",
                        "error"
                    );
                },
            });
        }
    });
});

// Bulk Delete Button
$("#bulk-delete-button").click(function () {
    const ids = $(".check-item:checked")
        .map(function () {
            return $(this).val();
        })
        .get();

    if (ids.length > 0) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete them!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: bulkDeleteUrl,
                    type: "POST",
                    data: {
                        ids: ids,
                        _token: $("meta[name='csrf-token']").attr("content"),
                    },
                    success: function (response) {
                        Swal.fire("Deleted!", response.message, "success").then(
                            () => {
                                location.reload();
                            }
                        );
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        Swal.fire(
                            "Error!",
                            "An error occurred while deleting: " +
                                xhr.responseText,
                            "error"
                        );
                    },
                });
            }
        });
    } else {
        Swal.fire(
            "No item selected",
            "Please select at least one item to delete.",
            "info"
        );
    }
});
