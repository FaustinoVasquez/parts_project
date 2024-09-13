async function manageData(url, method='POST', item={}) {
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


function manageBrand($table) {
    selBrand = document.getElementById('search_brand');
    selModel = document.getElementById('search_model');

    if(selBrand.value !== '0'){
        $table.column(3).search(`${selBrand.value}`).draw()
    }
}

function manageModel($table) {
    selBrand = document.getElementById('search_brand');
    selModel = document.getElementById('search_model');

    if(selModel.value !== '0'){
        $table.column([4]).search(`${selModel.value}`).draw();
    }
    if(selModel.value === '0'){
        $table.columns([4]).search("").draw();
        document.querySelectorAll('#search_model option').forEach(o =>{if (o.value !=0){ o.remove()}});
    }
}


// async function updateBulkSkuMaster(url, kitsArray, sku) {
//
//     await manageData(kitsArray, sku, url,'POST').then(
//         data => {
//             if (!data.errors) {
//                 console.log(`Msg: ${data}`)
//                 $kitsBulkTable.ajax.reload()
//             } else {
//                 console.log(`Error: ${data.errors}`)
//             }
//         }
//     )
// }

// async function deleteData(url) {
//     try {
//         const response = await fetch(`${url}`, {
//             method: 'DELETE',
//             headers: headers,
//         })
//         const data = await response.json()
//         return data
//     } catch (err) {
//         console.log(err);
//     }
// }

// $(document).on('click', '.kits-count', function (e) {
//     e.stopPropagation();
//     let $tr = $(this).closest('tr');
//     let rowId = $tr.attr('id');
//     let row = $skusTable.row($tr).data();
//     $('#ajaxModalKits')
//         .on('shown.bs.modal', function () {
//             $(this).find(".modal-title").html(row['qty']+' Kits related to SKU: '+rowId)
//             $(this).find(".modal-body").html('<table class="table table-striped table-hover table-bordered nowrap" id="kitsTable"> <thead> <tr> <th>ID</th> <th>Kit LCN</th> <th>BoxID</th> <th>SKU Count</th> <th>Brand</th> <th>Model</th> <th>Ref SKU</th> <th>Images Qty</th> <th>Parts Qty</th> <th>Keywords</th> <th>CapturedBy</th> <th>Created At</th> </tr> </thead> </table>')
//             $kitsTable = $('#kitsTable').DataTable({
//                 order: [[0, 'desc']],
//                 pageLength: 100,
//                 lengthMenu: [
//                     [100,500, -1],
//                     [100,500,'All']
//                 ],
//                 processing: true,
//                 serverSide: true,
//                 scrollY: "53vh",
//                 scrollX: true,
//                 scrollCollapse: true,
//                 stateSave: true,
//                 dom: '"<\'row\'<\'col-md-6\'B><\'col-md-6\'f>>" +\n' +
//                     '"<\'row\'<\'col-sm-12\'tr>>" +\n' +
//                     '"<\'row\'<\'col-sm-12 col-md-5\'i ><\'col-sm-12 col-md-7\'p>>"',
//                 buttons: {
//                     dom: {
//                         container: {
//                             tag: 'div',
//                             className: 'flexcontent'
//                         },
//                         buttonLiner: {
//                             tag: null
//                         }
//                     },
//                     buttons: [{
//                         extend: 'excelHtml5',
//                         text: '<i class="fas fa-file-excel"></i> Excel',
//                         title: 'Kits to Excel',
//                         titleAttr: 'Excel',
//                         className: 'btn btn-success',
//                         init: function (api, node, config) {
//                             $(node).removeClass('btn-secondary buttons-html5 buttons-excel')
//                         },
//                     },
//                         {
//                             extend: 'pageLength',
//                             titleAttr: 'Show Records',
//                             className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
//                         }
//                     ],
//                 },
//                 ajax: {
//                     url: "/sku/getKitsBySku",
//                     data: function (d) {
//                         d.sku = rowId;
//                     },
//                 },
//                 columns: [
//                     {data: 'kitid', name: 'kitid'},
//                     {data: 'kitlcn', name: 'kitlcn'},
//                     {data: 'boxname', name: 'boxname'},
//                     {data: 'SKU_count', name: 'SKU_count'},
//                     {data: 'brand', name: 'brand'},
//                     {data: 'model', name: 'model'},
//                     {data: 'ref_sku', name: 'ref_sku'},
//                     {data: 'image_count', name: 'image_count'},
//                     {data: 'noofparts', name: 'noofparts'},
//                     {data: 'keywords', name: 'keywords'},
//                     {data: 'name', name: 'name'},
//                     {data: 'created_at', name: 'created_at'},
//                 ],
//                 columnDefs: [
//                     {
//                         targets: [0],
//                         searchable: true,
//                         // visible: false,
//                     },
//                 ]
//             });
//         }).on('hidden.bs.modal', function (e) {
//         $(this).find(".modal-title").html('');
//         $(this).find(".modal-body").html("");
//         $kitsTable='';
//     }).modal('show');
// });
//
// $(document).on('click', '.kits-delete', function (e) {
//     let $tr = $(this).closest('tr');
//     let rowId = $tr.attr('id');
//     // console.log(rowId)
//
//     Swal.fire({
//         title: 'Password to delete SKU',
//         input: 'password',
//         inputAttributes: {
//             autocapitalize: 'off'
//         },
//         showCancelButton: true,
//         confirmButtonText: 'Submit',
//     }).then((result) => {
//         if (result.value === 'pLa13t1B') {
//
//             deleteData(`/skus/${rowId}`)
//
//             Swal.fire({
//                 title: 'The SKU!',
//                 html: `
//                 <h3>${rowId}</h3>
//                 <h3><b>Has been deleted</b></h3>
//               `,
//                 confirmButtonText: 'Exit'
//             })
//             $skusTable.ajax.reload()
//         }else{
//             Swal.fire({
//                 title: 'Sorry!',
//                 html: `<h3><b>The password is not correct</b></h3>`,
//                 confirmButtonText: 'Exit'
//             })
//         }
//
//     });
// });
//
// async function getSkuEditData(rowId){
//     try {
//         let response = await fetch(`skus/${rowId}/edit`)
//         const data = await response.json();
//         return  data
//     }catch (e) {
//         console.log(e)
//     }
// }
//
// async function modifyModal(rowId,row) {
//     let data = await getSkuEditData(rowId)
//     const country_manufactured = row['country_manufactured'];
//     let options=''
//     for (let i in data.countries) {
//         let selected = null;
//         if (data.countries[i].CountryName === country_manufactured) {
//             selected = 'selected'
//         }
//         options += `<option value="${data.countries[i].CountryName}" ${selected}>${data.countries[i].CountryName}</option>`;
//         document.getElementById('country_manufactured').innerHTML = options
//     }
//
//     // const inputs = document.querySelectorAll('#skuForm input');
//     document.getElementById('skuForm').action =`/sku/updateKitData/${rowId}`
//
//     document.getElementById('skuID').innerHTML =`${rowId}`
//
//     document.getElementById('bluetoothmodule_partref1').value =data.sku['bluetoothmodule_partref1']
//     document.getElementById('bluetoothmodule_partref2').value = data.sku['bluetoothmodule_partref2']
//     document.getElementById('bluetoothmodule_partref3').value = data.sku['bluetoothmodule_partref3']
//     document.getElementById('bluetoothmodule_partref4').value = data.sku['bluetoothmodule_partref4']
//     document.getElementById('bluetoothmodule_partref5').value = data.sku['bluetoothmodule_partref5']
//
//     document.getElementById('irsensor_partref1').value = data.sku['irsensor_partref1']
//     document.getElementById('irsensor_partref2').value = data.sku['irsensor_partref2']
//     document.getElementById('irsensor_partref3').value = data.sku['irsensor_partref3']
//     document.getElementById('irsensor_partref4').value = data.sku['irsensor_partref4']
//     document.getElementById('irsensor_partref5').value = data.sku['irsensor_partref5']
//
//     document.getElementById('mainboard_partref1').value = data.sku['mainboard_partref1']
//     document.getElementById('mainboard_partref2').value = data.sku['mainboard_partref2']
//     document.getElementById('mainboard_partref3').value = data.sku['mainboard_partref3']
//     document.getElementById('mainboard_partref4').value = data.sku['mainboard_partref4']
//     document.getElementById('mainboard_partref5').value = data.sku['mainboard_partref5']
//
//     document.getElementById('opencell_partref1').value =data.sku['opencell_partref1']
//     document.getElementById('opencell_partref2').value =data.sku['opencell_partref2']
//     document.getElementById('opencell_partref3').value =data.sku['opencell_partref3']
//     document.getElementById('opencell_partref4').value =data.sku['opencell_partref4']
//     document.getElementById('opencell_partref5').value =data.sku['opencell_partref5']
//
//     document.getElementById('powersupply_partref1').value = data.sku['powersupply_partref1']
//     document.getElementById('powersupply_partref2').value = data.sku['powersupply_partref2']
//     document.getElementById('powersupply_partref3').value = data.sku['powersupply_partref3']
//     document.getElementById('powersupply_partref4').value = data.sku['powersupply_partref4']
//     document.getElementById('powersupply_partref5').value = data.sku['powersupply_partref5']
//
//     document.getElementById('tconboard_partref1').value = data.sku['tconboard_partref1']
//     document.getElementById('tconboard_partref2').value = data.sku['tconboard_partref2']
//     document.getElementById('tconboard_partref3').value = data.sku['tconboard_partref3']
//     document.getElementById('tconboard_partref4').value = data.sku['tconboard_partref4']
//     document.getElementById('tconboard_partref5').value = data.sku['tconboard_partref5']
//
//     document.getElementById('wifimodule_partref1').value = data.sku['wifimodule_partref1']
//     document.getElementById('wifimodule_partref2').value = data.sku['wifimodule_partref2']
//     document.getElementById('wifimodule_partref3').value = data.sku['wifimodule_partref3']
//     document.getElementById('wifimodule_partref4').value = data.sku['wifimodule_partref4']
//     document.getElementById('wifimodule_partref5').value = data.sku['wifimodule_partref5']
//
//     document.getElementById('chasis').value = data.sku['chasis']
//     document.getElementById('opencell_manufacturer').value = data.sku['opencell_manufacturer']
//     document.getElementById('opencell_sku').value = data.sku['opencell_sku']
//     document.getElementById('product_version_number').value = data.sku['product_version_number']
//
//     document.getElementById('brand').innerHTML = data.sku['Brand']
//     document.getElementById('model').innerHTML =data.sku['Model']
//
//     $('#ajaxModalSkuEdit').modal('show')
// }
//
// $(document).on('click', '.sku-edit', function (e) {
//     let $tr = $(this).closest('tr');
//     let rowId = $tr.attr('id');
//     let row = $skusTable.row($tr).data();
//
//     modifyModal(rowId,row)
//
// });
//
// ////////////////////////////////////////////////////////////////
// /// Update Sku
// async function updateMySkuEditData(url,jsonData) {
//     try {
//         const response = await fetch(`${url}`, {
//             method: 'PATCH',
//             body: JSON.stringify({
//                 sku:jsonData
//             }),
//             headers: headers
//         })
//         const data = await response.json()
//         return data
//
//
//     } catch (err) {
//         console.log(`Error: ${err}`)
//     }
//
// }
//
// // Get Imformation
// document.getElementById('skuForm').addEventListener('submit',async(e)=>{
//     e.preventDefault()
//     const action = document.getElementById("skuForm").action
//     const fd = new FormData(e.target);
//     let data = {};
//     for (let [key, prop] of fd) {
//         data[key] = prop;
//     }
//     let myData = await updateMySkuEditData(action,data)
//     if(myData){
//         Swal.fire({
//             position: 'top-end',
//             icon: 'success',
//             title: myData,
//             showConfirmButton: false,
//             timer: 1500
//         })
//     }
//     $skusTable.ajax.reload()
//     $('#ajaxModalSkuEdit').modal('toggle');
//
// })
//
//
// document.getElementById('search_brand').addEventListener('change', (e)=>{
//     e.preventDefault();
//     selModel = document.getElementById('search_model');
//
//     if (selModel.value !== '0' && selModel.value !== ''){
//         $skusTable.columns([2,3]).search('').draw();
//         selModel.value ='0';
//     }
//
//
//     fetch('/sku/getSKUModels', {
//         method: 'POST',
//         body: JSON.stringify({text: e.target.value}),
//         headers:headers
//     }).then(response=>{
//         return response.json()
//     }).then(data =>{
//         let options = "<option value='0'>Model</option>";
//         for (let i in data){
//             options += '<option value="'+data[i].model+'">'+data[i].model+'</option>';
//         }
//         document.getElementById('search_model').innerHTML = options
//     }).catch(error => console.log(error))
//
//
//     manageBrand($skusTable)
// })
//
// document.getElementById('search_images').addEventListener('change', (e)=>{
//     e.preventDefault();
//     $skusTable.ajax.reload()
// })
//
// document.getElementById('btn-reset-form').addEventListener('click', (e)=>{
//     document.getElementById('search_brand').selectedIndex = 0;
//     document.getElementById('search_images').selectedIndex = 0;
//     document.querySelectorAll('#search_model option').forEach(o =>{if (o.value !=0){ o.remove()}});
//     $skusTable.columns([2,3]).search("").draw();
// });
//
//
// $('.mySelect2').select2({
//     theme: 'bootstrap4',
//     width: 'resolve'
// }).on('select2:select', function(e) {
//     manageModel($skusTable)
// });
//
// window.onload = function (){
//     $skusTable.columns().search("").draw();
// }
