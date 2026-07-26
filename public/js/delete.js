// ตรวจสอบทั้งหมด Checkbox
document.getElementById("checkAll").addEventListener("change", function () {
    const isChecked = this.checked;
    const checkboxes = document.querySelectorAll(".check-item");
    checkboxes.forEach((checkbox) => {
        checkbox.checked = isChecked;
    });
    toggleBulkDeleteButton();
});

// เปลี่ยนสถานะการแสดงปุ่มลบหลายรายการ
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

// ปุ่มลบเดี่ยว
$(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const form = $("#deleteForm" + id);

    Swal.fire({
        title: "คุณแน่ใจหรือไม่?",
        text: "คุณจะไม่สามารถกู้คืนได้!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ใช่, ลบเลย!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: form.attr("action"),
                type: "POST",
                data: form.serialize(),
                success: function (response) {
                    Swal.fire(
                        "ลบแล้ว!",
                        "รายการของคุณได้ถูกลบแล้ว.",
                        "success"
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function (xhr) {
                    Swal.fire(
                        "เกิดข้อผิดพลาด!",
                        "เกิดข้อผิดพลาดระหว่างการลบ.",
                        "error"
                    );
                },
            });
        }
    });
});

// ปุ่มลบหลายรายการ
$("#bulk-delete-button").click(function () {
    const ids = $(".check-item:checked")
        .map(function () {
            return $(this).val();
        })
        .get();

    if (ids.length > 0) {
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณจะไม่สามารถกู้คืนได้!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ใช่, ลบทั้งหมด!",
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
                        Swal.fire("ลบแล้ว!", response.message, "success").then(
                            () => {
                                location.reload();
                            }
                        );
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "เกิดข้อผิดพลาด!",
                            "เกิดข้อผิดพลาดระหว่างการลบ " ,
                            "error"
                        );
                    },
                });
            }
        });
    } else {
        Swal.fire(
            "ยังไม่ได้เลือกไอเท็ม",
            "กรุณาเลือกไอเท็มอย่างน้อยหนึ่งรายการเพื่อทำการลบ.",
            "info"
        );
    }
});
