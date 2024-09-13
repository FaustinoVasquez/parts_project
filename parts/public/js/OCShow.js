async function manageData(url, method, item) {
    try {
        const response = await fetch(`${url}`, {
            method: method,
            body: JSON.stringify({
                data: item
            }),
            headers: headers
        })
        const data = await response.json()
        return data
    } catch (err) {
        console.log(`Error: ${err}`)
    }
}

clearErrors = (myform) => {
    const form = document.getElementById(myform);
    const formElements = Array.from(form.elements);
    formElements.forEach(element => {
        if (element.classList.contains('is-invalid')) {
            element.classList.remove('is-invalid')
        }
    })
}
displayErrors = (err, myForm) => {
    const form = document.getElementById(myForm);
    const formElements = Array.from(form.elements);
    formElements.forEach(element => {
        let name = element.getAttribute("name")
        // if(element.classList.contains('is-invalid')){
        //     element.classList.remove('is-invalid')
        // }
        if (name in err) {
            element.classList.add('is-invalid')
            const div = element.parentNode.closest('div')
            if (div.children.length === 2) {
                div.children[1].firstElementChild.innerHTML = err[name][0]
            } else {
                div.children[2].firstElementChild.innerHTML = err[name][0]
            }
        }
    });
}
displayMsg = (msg) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: msg,
        showConfirmButton: false,
        timer: 1500
    })
}
clearForm = (input) => {
    if (input === 1) {
        document.getElementById('partNumber').innerHTML = `<option value="">PartNumber</option>`
        document.getElementById('manufacturer').value = ''
        $("#mitSku").val(0).trigger('change');
    } else if (input === 2) {
        document.getElementById('manufacturer').value = ''
        $("#mitSku").val(0).trigger('change');
    } else if (input === 3) {
        $("#mitSku").val(0).trigger('change');
    }

    document.getElementById('instructions').value = ''
    const selectedFile = document.querySelector(".custom-file-input")
    selectedFile.value = ""
    selectedFile.nextElementSibling.innerText = ""
    selectedFile.nextElementSibling.innerText = "Select a file"
}
enableFormElements = (myForm) => {
    const form = document.getElementById(myForm);
    const formElements = Array.from(form.elements);
    formElements.forEach(element => {
        element.disabled = false
    });
}
disableFormElements = (myForm) => {
    const form = document.getElementById(myForm);
    const formElements = Array.from(form.elements);
    formElements.forEach(element => {
        element.disabled = true
    });
}



// const showForm = $('#showForm')
// let putURL =showForm.attr('action')


$('#showForm').on('submit', (e) => {
    e.preventDefault();
    // const assemblyGuide = document.getElementById('assemblyGuide').files[0]
    let fd = new FormData(e.target);
    let method = 'POST'
    let url = "/oc/update"
    if (OcConfigId!==null){
        fd.append("id", OcConfigId)
    }

    let request = $.ajax({
        url: url,
        method: method,
        data: fd,
        dataType: "json",
        processData: false,
        contentType: false
    });
    request.done(function (msg) {

        // OcConfigId = msg.data.accessory_id
        clearErrors('showForm')
        disableFormElements('showForm')
        displayMsg(msg.message)
        // $('#idOCConfig').val(OcConfigId)
        $('#btnOCAccessories').prop('disabled', false);
        $('#btnOCConfig').prop('disabled', true);
        $('#enableUpdate').prop('disabled', false);
    });
    request.fail(function (jqXHR, textStatus) {
        clearErrors('showForm')
        displayErrors(jqXHR.responseJSON.errors, 'showForm')
    });
})

$("#enableUpdate").on('click', (e) => {

    Swal.fire({
        title: "La edición solo puede ser realizada por personal autorizado y requiere una contraseña para continuar. <br><br>Edit can only be performed by authorized personnel and require a password to continue. ",
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        showLoaderOnConfirm: false,
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value === "dLp173Vb") {
                enableFormElements('showForm')
                $("#enableUpdate").prop('disabled', true);
                $("#btnOCAccessories").prop('disabled', false);
                $("#mitSKU").focus()
                $(".btn-remove-acc").removeClass('disabled')
                isDisabled = 1
            }else{
                Swal.fire({
                    title: `Sorry the password is not correct`
                })
            }
        }
    })
})


document.querySelector('#deleteOcConf').addEventListener('click',async(e)=> {
let deletedOc;
    Swal.fire({
        title: "La eliminacion solo puede ser realizada por personal autorizado y requiere una contraseña para continuar. <br><br>Delete can only be performed by authorized personnel and require a password to continue. ",
        input: 'password',
        inputAttributes: {
            autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        showLoaderOnConfirm: false,
    }).then((result) => {
        if (result.isConfirmed) {
            if (result.value === "dLp173Vb") {
                deleteOCConfiguration(OcConfigId)
            }else{
                Swal.fire({
                    title: `Sorry the password is not correct`
                })
            }
        }
    })
})

async function deleteOCConfiguration(OcConfigId){
    const result = await manageData("/oc/delete/"+OcConfigId,'DELETE',OcConfigId)
    if (result){
        Swal.fire(
            'Deleted!',
            result.message,
            'success',
        ).then(function (result1) {
            if (result1) {
                window.location.href = '/oc';
            }
        });
    }

}


///////////////////////  Modal /////////////////////


async function getMPartName() {
    const partNames = await manageData('/oc/getAPartName', 'POST', 'notting')
    let parModelOptions = `<option value="">PartName</option>`;
    document.getElementById('aPartName').innerHTML = ""
    partNames.forEach((e) => {
        parModelOptions += `<option value="${e.PartName}">${e.PartName}</option>`
    })
    document.getElementById('aPartName').innerHTML = parModelOptions
}

async function getMitSKUFromPartName(partName) {

    const mitSkus = await manageData('/oc/getAMitSKu', 'POST', partName)

    let mitSkuOptions = `<option value="">MITSKU</option>`;
    document.getElementById('aMitSKU').innerHTML = ""
    mitSkus.forEach((e) => {
        mitSkuOptions += `<option value="${e.MITSKU}">${e.ProductSKU}</option>`
    })
    document.getElementById('aMitSKU').innerHTML = mitSkuOptions
}


$('#accDataForm').on('submit', (e) => {
    e.preventDefault();
    let fd = new FormData(e.target);

    let request = $.ajax({
        url: "/oc/accessories/store",
        method: 'post',
        data: fd,
        dataType: "json",
        processData: false,
        contentType: false
    });

    request.done(function (msg) {
        clearErrors('accDataForm')
        displayMsg(msg.message)
        $('#ocAccModal').modal('hide')
        $OCAccessoriesTable.ajax.reload()
    });
    request.fail(function (jqXHR, textStatus) {

        clearErrors('accDataForm')
        displayErrors(jqXHR.responseJSON.errors, 'accDataForm')
    });
})


$(document).on('click', '.btn-remove-acc', function (e) {
    e.stopPropagation();
    e.stopImmediatePropagation();
    let $tr = $(this).closest('tr');
    let rowId = $tr.attr('ID');
    let urld = '/oc/accessories/' + rowId;
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            let request = $.ajax({
                url: urld,
                method: 'delete',
                dataType: 'json',
                processData: false,
                contentType: false
            });
            request.done(function (data) {
                Swal.fire(
                    'Deleted!',
                    data.message,
                    'success'
                );
                $OCAccessoriesTable.draw();
            });
            request.fail(function (jqXHR, textStatus, errorThrown) {
                Swal.fire('Failed!', "There was something wrong", "warning");
            });
        }
    });
});
