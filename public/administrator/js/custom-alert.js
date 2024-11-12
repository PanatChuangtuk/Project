function callAddAlert(formdata,urlSave,urlRedirect){
    swal.showLoading();
    $.ajax({
        url         : urlSave,
        type        : 'post',
        dataType    :'json',
        data        : formdata,
        cache       : false,
        processData : false,
        contentType : false,
    success:function(result){
            swal.close();

            if(result.message == 'successfully'){
                let timerInterval
                if(result.messageAlert !== undefined) {
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: result.messageAlert,
                        icon: "success"
                    });
                }
                else {
                    Swal.fire({
                        title: '<span class="text-success">สำเร็จ!</span>',
                        html: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        // html: 'I will close in <b></b> milliseconds.',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        isDismissed: false,
                        didOpen: () => {
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                            window.location = urlRedirect;
                        }
                    })
                }
            }else {
                if(result.data) {
                    let errMessage = '<ul class="list-group list-group-timeline">';
                    
                    result.data.forEach((item) => errMessage += '<li class="list-group-item list-group-timeline-danger fs-6 text-start">' + item + '</li>');

                    errMessage += '</ul>'

                    Swal.fire({
                        icon: 'error',
                        html: errMessage,
                        // confirmButtonText: 'ตกลง'
                    })
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        html: result.message,
                    })
                }
            }
        }
    });
}

function callEditAlert(formdata,urlSave,urlRedirect){
    swal.showLoading();
    $.ajax({
        url         : urlSave,
        type        : 'post',
        dataType    :'json',
        data        : formdata,
        cache       : false,
        processData : false,
        contentType : false,
    success:function(result){
            swal.close();

            if(result.message == 'successfully'){
                let timerInterval
                if(result.messageAlert !== undefined) {
                    Swal.fire({
                        title: "สำเร็จ!",
                        text: result.messageAlert,
                        icon: "success"
                    });
                }
                else {
                    Swal.fire({
                        title: '<span class="text-success">สำเร็จ!</span>',
                        html: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        // html: 'I will close in <b></b> milliseconds.',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        isDismissed: false,
                        didOpen: () => {
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                            if(urlRedirect)
                                window.location = urlRedirect;
                        }
                    })
                }
            }else {
                if(result.data) {
                    let errMessage = '<ul class="list-group list-group-timeline">';
                    
                    result.data.forEach((item) => errMessage += '<li class="list-group-item list-group-timeline-danger fs-6 text-start">' + item + '</li>');

                    errMessage += '</ul>'

                    Swal.fire({
                        icon: 'error',
                        html: errMessage,
                        // confirmButtonText: 'ตกลง'
                    })
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        html: result.message,
                    })
                }
            }
        }
    });
}

function callDeleteAlert(urlDelete,urlRedirect){
    Swal.fire({
        title: 'ยืนยัน !',
        text: "คุณยืนยันที่จะลบข้อมูลนี้หรือไม่ ?",
        icon: 'warning',
        inputAttributes: {
            autocapitalize: "off"
        },
        showCancelButton: true,
        confirmButtonText: "ยืนยัน",
        cancelButtonText: "ยกเลิก",
        showLoaderOnConfirm: true,
        preConfirm: async (login) => {
            try {
            const url = urlDelete;
            const response = await fetch(url,{
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log(response)
            if (!response.ok) {
                return Swal.showValidationMessage(`
                ${JSON.stringify(await response.json())}
                `);
            }
            return response.json();
            } catch (error) {
            Swal.showValidationMessage(`
                Request failed: ${error}
            `);
            }
        },
        allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: '<span class="text-success">สำเร็จ!</span>',
                html: 'ลบข้อมูลเรียบร้อยแล้ว',
                // html: 'I will close in <b></b> milliseconds.',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                isDismissed: false,
                didOpen: () => {
                },
                willClose: () => {
                    clearInterval(timerInterval)
                    if(urlRedirect)
                        window.location = urlRedirect;
                }
            })
        }
    });
}