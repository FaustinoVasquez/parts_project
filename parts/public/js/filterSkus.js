async function manageData(kits, sku, url, method) {
    try {
        const response = await fetch(`${url}`, {
            method: method,
            body: JSON.stringify({
                kits: kits,
                sku:sku
            }),
            headers: headers
        })
        const data = await response.json()
        return data
    } catch (err) {
        console.log(`Error: ${err}`)
    }
}

async function editSkuData(url, method) {
    try {
        const response = await fetch(`${url}`, {
            method: method,
            headers: headers
        })
        const data = await response.json()
        return data
    } catch (err) {
        console.log(`Error: ${err}`)
    }
}



async function updateBulkKits(url, kitsArray, sku) {

    await manageData(kitsArray, sku, url,'POST').then(
        data => {
            if (!data.errors) {
                console.log(`Msg: ${data}`)
                $kitsBulkTable.ajax.reload()
            } else {
                console.log(`Error: ${data.errors}`)
            }
        }
    )
}

function manageBrand($table) {
    selBrand = document.getElementById('search_brand');
    selModel = document.getElementById('search_model');

    if(selBrand.value !== '0'){
        $table.column(2).search(`${selBrand.value}`).draw()
    }
}
function manageModel($table) {
    selBrand = document.getElementById('search_brand');
    selModel = document.getElementById('search_model');

    if(selModel.value !== '0'){
        $table.column([3]).search(`${selModel.value}`).draw();
    }
    if(selModel.value === '0'){
        $table.columns([3]).search("").draw();
        document.querySelectorAll('#search_model option').forEach(o =>{if (o.value !=0){ o.remove()}});
    }
}

$(document).on('click', '.kits-bulk', function (e) {
    e.stopPropagation();
    let $tr = $(this).closest('tr');
    let rowId = $tr.attr('id');
    let row = $skusTable.row($tr).data();
    let brand = row.brand;
    let model = row.model;

    $('#ajaxModalKits')
        .on('shown.bs.modal', function () {
            $(this).find(".modal-title").html("Add Kits to Sku: "+rowId)
            $(this).find(".modal-body").html(
                '<table class="table table-striped table-hover table-bordered nowrap" id="skuHeaderTable">'+
                '<thead>'+
                '<tr>'+
                '<th>Ref Sku</th>'+
                '<th>Country Mfr</th>'+
                '<th>Open Cell</th>'+
                '<th>Main Board</th>'+
                '<th>T-Con Board</th>'+
                '<th>Power Supply</th>'+
                '<th>WiFi Module</th>'+
                '<th>IR Sensor</th>'+
                '<th>Button Set</th>'+
                '<th>Blutooth Module</th>'+
                '<th>Chasis</th>'+
                '<th>Product Ver Num</th>'+
                '</tr>'+
                '</thead>'+
                '<tbody>' +
                '<tr>'+
                '<td>'+row['ref_sku']+'</td>' +
                '<td>'+row['country_manufactured']+'</td>' +
                '<td>'+row['Open Cell']+'</td>' +
                '<td>'+row['Main Board']+'</td>' +
                '<td>'+row['T-Con Board']+'</td>' +
                '<td>'+row['Power Supply']+'</td>' +
                '<td>'+row['WiFi Module']+'</td>' +
                '<td>'+row['IR Sensor']+'</td>' +
                '<td>'+row['Button Set']+'</td>' +
                '<td>'+row['Blutooth Module']+'</td>' +
                '<td>'+row['chasis']+'</td>' +
                '<td>'+row['product_version_number']+'</td>' +
                '</tr>'+
                '</tbody>'+
                '</table>'+
                '<br>'+
                '<hr>'+


                '<table class="table table-striped table-hover table-bordered nowrap" id="kitsBulkTable">\n' +
                '                            <thead>\n' +
                '                            <tr>\n' +
                '                                <th></th>\n' +
                '                                <th>KitID</th>\n' +
                '                                <th>Brand</th>\n' +
                '                                <th>Model</th>\n' +
                '                                <th>Open Cell</th>\n' +
                '                                <th>Main Board</th>\n' +
                '                                <th>T-Con Board</th>\n' +
                '                                <th>Power Supply</th>\n' +
                '                                <th>WiFi Module</th>\n' +
                '                                <th>IR Sensor</th>\n' +
                '                                <th>Button Set</th>\n' +
                '                                <th>Blutooth Module</th>\n' +
                '                            </tr>\n' +
                '                            </thead>\n' +
                '                        </table>')
            $kitsBulkTable = $('#kitsBulkTable').DataTable({
                order: [[0, 'desc']],
                pageLength: 100,
                lengthMenu: [
                    [50,100, -1],
                    [50,100,'All']
                ],
                processing: true,
                serverSide: true,
                scrollY: "45vh",
                scrollX: true,

                scrollCollapse: true,
                dom: '"<\'row\'<\'col-md-6\'B><\'col-md-6\'f>>" +\n' +
                    '"<\'row\'<\'col-sm-12\'tr>>" +\n' +
                    '"<\'row\'<\'col-sm-12 col-md-5\'i ><\'col-sm-12 col-md-7\'p>>"',
                buttons: {
                    dom: {
                        container: {
                            tag: 'div',
                            className: 'flexcontent'
                        },
                        buttonLiner: {
                            tag: null
                        }
                    },
                    buttons: [
                        {
                            extend: 'pageLength',
                            titleAttr: 'Show Records',
                            className: 'btn btn-secondary buttons-collection dropdown-toggle buttons-colvis',
                        },{
                            text: '<i class="fas fa-plus-circle"></i> Assign to SKU',
                            title: 'Assign to SKU',
                            titleAttr: 'Assign to SKU',
                            className: 'btn btn-primary',
                            attr: {
                                id: 'create-sku-btn'
                            },
                            init: function (api, node, config) {
                                $(node).removeClass('btn-secondary buttons-html5')
                                // this.disable();
                            },
                            action: function ( e, dt, node, config ) {
                                let kitsArray = [];
                                if(dt.column(0).checkboxes.selected().count()){
                                    $.each(dt.column(0).checkboxes.selected(), function(index, rowId){
                                        kitsArray.push(rowId);
                                    });

                                    updateBulkKits('/sku/kitBulkUpdate',kitsArray,rowId)

                                    $skusTable.ajax.reload();

                                }else{
                                    alert("Please select some kits")
                                }

                                // window.location = '/skus/create';
                            }
                        }
                    ],
                },


                ajax: {
                    url:'/sku/getBulkKitsWSku',
                    data: function (d) {
                        // d.brand1 = $('select[name=brand]').val();
                        // d.model1 = $('select[name=model]').val();
                        d.brand = brand;
                        d.model = model;
                        // console.log(d.model)
                    }
                },
                columns: [
                    // {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'KitID', name: 'KitID'},
                    {data: 'brand', name: 'brand'},
                    {data: 'model', name: 'model'},
                    {data: 'Open Cell', name: 'Open Cell'},
                    {data: 'Main Board', name: 'Main Board'},
                    {data: 'T-Con Board', name: 'T-Con Board'},
                    {data: 'Power Supply', name: 'Power Supply'},
                    {data: 'WiFi Module', name: 'WiFi Module'},
                    {data: 'IR Sensor', name: 'IR Sensor'},
                    {data: 'Button Set', name: 'Button Set'},
                    {data: 'Blutooth Module', name: 'Blutooth Module'},
                ],
                columnDefs: [
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        },
                    },
                ],
                select: {
                    style: 'multi'
                },
            });
            $('#skuHeaderTable').DataTable({
                dom:'rt',
                scrollX: true,
            })
        }).on('hidden.bs.modal', function (e) {
        $(this).find(".modal-title").html('');
        $(this).find(".modal-body").html("");
        $kitsBulkTable='';
    }).modal('show');
});



//1451
