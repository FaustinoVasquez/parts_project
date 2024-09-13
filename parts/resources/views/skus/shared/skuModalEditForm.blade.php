

<div class="modal fade show" id="ajaxModalSkuEdit" aria-modal="true" aria-hidden="true"  style="padding-right: 15px;">
    <div class="modal-dialog modal-xl verybigmodal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update SKU:<span id="skuID"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="skuForm" name="skuForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="brand">Brand:</label>
                            <span id="brand">brand</span>
                        </div>
                        <div class="col-md-2">
                            <label for="model">Model:</label>
                            <span id="model">model</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="country_manufactured">Country Manufactured</label>
                            <select class="custom-select" id="country_manufactured" name="country_manufactured"></select>
                        </div>

                        <div class="col-md-2">
                            <label for="product_version_number">Product Version Number</label>
                            <input id="product_version_number" type="text"class="form-control" name="product_version_number"autocomplete="off" autofocus >
                        </div>
                        <div class="col-md-2">
                            <label for="opencell_manufacturer">Open Cell Manuf</label>
                            <input id="opencell_manufacturer" type="text"class="form-control" name="opencell_manufacturer"autocomplete="off" autofocus >
                        </div>
                        <div class="col-md-2">
                            <label for="opencell_sku">Open Cell SKU</label>
                            <input id="opencell_sku" type="text"class="form-control" name="opencell_sku"autocomplete="off" autofocus  >
                        </div>
                        <div class="col-md-2">
                            <label for="chasis">Chasis</label>
                            <input id="chasis" type="text"class="form-control " name="chasis"autocomplete="off" autofocus  >
                        </div>
                        <div class="col-md-2">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part1Name" type="text"class="form-control" name="part1Name"value="Open Cell"  autocomplete="off" autofocus readonly>
                        </div>
                        <div class="col-md-2">
                            <input id="opencell_partref1" type="text"class="form-control" name="opencell_partref1"autocomplete="off" autofocus placeholder="Ref 1">
                        </div>
                        <div class="col-md-2">
                            <input id="opencell_partref2" type="text"class="form-control" name="opencell_partref2"autocomplete="off" autofocus placeholder="Ref 2" >
                        </div>
                        <div class="col-md-2">
                            <input id="opencell_partref3" type="text"class="form-control" name="opencell_partref3"autocomplete="off" autofocus placeholder="Ref 3" >
                        </div>
                        <div class="col-md-2">
                            <input id="opencell_partref4" type="text"class="form-control" name="opencell_partref4"autocomplete="off" autofocus placeholder="Ref 4" >
                        </div>
                        <div class="col-md-2">
                            <input id="opencell_partref5" type="text"class="form-control" name="opencell_partref5"autocomplete="off" autofocus placeholder="Ref 5" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part2Name" type="text" class="form-control" name="part2Name" value="Main Board"  autocomplete="off" autofocus readonly>
                        </div>
                        <div class="col-md-2">
                            <input id="mainboard_partref1" type="text" class="form-control" name="mainboard_partref1" autocomplete="off" autofocus placeholder="Ref 1" >
                        </div>
                        <div class="col-md-2">
                            <input id="mainboard_partref2" type="text" class="form-control" name="mainboard_partref2" autocomplete="off" autofocus placeholder="Ref 2" >
                        </div>
                        <div class="col-md-2">
                            <input id="mainboard_partref3" type="text" class="form-control" name="mainboard_partref3" autocomplete="off" autofocus placeholder="Ref 3" >
                        </div>

                        <div class="col-md-2">
                            <input id="mainboard_partref4" type="text" class="form-control" name="mainboard_partref4" autocomplete="off" autofocus placeholder="Ref 4" >
                        </div>

                        <div class="col-md-2">
                            <input id="mainboard_partref5" type="text" class="form-control" name="mainboard_partref5" autocomplete="off" autofocus placeholder="Ref 5" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part3Name" type="text" class="form-control" name="part3Name" value="T-Con Board"  autocomplete="off" autofocus readonly>
                        </div>

                        <div class="col-md-2">
                            <input id="tconboard_partref1" type="text" class="form-control" name="tconboard_partref1" autocomplete="off" autofocus placeholder="Ref 1">
                        </div>
                        <div class="col-md-2">
                            <input id="tconboard_partref2" type="text" class="form-control" name="tconboard_partref2" autocomplete="off" autofocus placeholder="Ref 2">
                        </div>
                        <div class="col-md-2">
                            <input id="tconboard_partref3" type="text" class="form-control" name="tconboard_partref3" autocomplete="off" autofocus placeholder="Ref 3">
                        </div>

                        <div class="col-md-2">
                            <input id="tconboard_partref4" type="text" class="form-control" name="tconboard_partref4" autocomplete="off" autofocus placeholder="Ref 4">
                        </div>

                        <div class="col-md-2">
                            <input id="tconboard_partref5" type="text" class="form-control" name="tconboard_partref5" autocomplete="off" autofocus placeholder="Ref 5">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part4Name" type="text" class="form-control" name="part4Name" value="Power Supply"  autocomplete="off" autofocus readonly>
                        </div>
                        <div class="col-md-2">
                            <input id="powersupply_partref1" type="text" class="form-control" name="powersupply_partref1" autocomplete="off" autofocus placeholder="Ref 1">
                        </div>
                        <div class="col-md-2">
                            <input id="powersupply_partref2" type="text" class="form-control" name="powersupply_partref2" autocomplete="off" autofocus placeholder="Ref 2">
                        </div>
                        <div class="col-md-2">
                            <input id="powersupply_partref3" type="text" class="form-control" name="powersupply_partref3" autocomplete="off" autofocus placeholder="Ref 3">
                        </div>

                        <div class="col-md-2">
                            <input id="powersupply_partref4" type="text" class="form-control" name="powersupply_partref4" autocomplete="off" autofocus placeholder="Ref 4">
                        </div>

                        <div class="col-md-2">
                            <input id="powersupply_partref5" type="text" class="form-control" name="powersupply_partref5" autocomplete="off" autofocus placeholder="Ref 5">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part5Name" type="text" class="form-control" name="part5Name" value="WiFi Module"  autocomplete="off" autofocus readonly>
                        </div>
                        <div class="col-md-2">
                            <input id="wifimodule_partref1" type="text" class="form-control" name="wifimodule_partref1" autocomplete="off" autofocus placeholder="Ref 1">
                        </div>
                        <div class="col-md-2">
                            <input id="wifimodule_partref2" type="text" class="form-control" name="wifimodule_partref2" autocomplete="off" autofocus  placeholder="Ref 2">
                        </div>
                        <div class="col-md-2">
                            <input id="wifimodule_partref3" type="text" class="form-control" name="wifimodule_partref3" autocomplete="off" autofocus placeholder="Ref 3">
                        </div>

                        <div class="col-md-2">
                            <input id="wifimodule_partref4" type="text" class="form-control" name="wifimodule_partref4" autocomplete="off" autofocus  placeholder="Ref 4">
                        </div>

                        <div class="col-md-2">
                            <input id="wifimodule_partref5" type="text" class="form-control" name="wifimodule_partref5" autocomplete="off" autofocus  placeholder="Ref 5">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part6Name" type="text"class="form-control" name="part6Name"value="IR Sensor"  autocomplete="off" autofocus readonly>
                        </div>
                        <div class="col-md-2">
                            <input id="irsensor_partref1" type="text"class="form-control" name="irsensor_partref1"autocomplete="off" autofocus placeholder="Ref 1">
                        </div>
                        <div class="col-md-2">
                            <input id="irsensor_partref2" type="text"class="form-control" name="irsensor_partref2"autocomplete="off" autofocus placeholder="Ref 2">
                        </div>
                        <div class="col-md-2">
                            <input id="irsensor_partref3" type="text"class="form-control" name="irsensor_partref3" autocomplete="off" autofocus placeholder="Ref 3">
                        </div>
                        <div class="col-md-2">
                            <input id="irsensor_partref4" type="text" class="form-control" name="irsensor_partref4" autocomplete="off" autofocus placeholder="Ref 4">
                        </div>
                        <div class="col-md-2">
                            <input id="irsensor_partref5" type="text" class="form-control" name="irsensor_partref5" autocomplete="off" autofocus placeholder="Ref 5">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <input id="part8Name" type="text" class="form-control" name="part8Name" value="Bluetooth Module"  autocomplete="off" autofocus readonly>
                        </div>
                        <div class="col-md-2">
                            <input id="bluetoothmodule_partref1" type="text" class="form-control" name="bluetoothmodule_partref1" autocomplete="off" autofocus placeholder="Ref 1">
                        </div>
                        <div class="col-md-2">
                            <input id="bluetoothmodule_partref2" type="text" class="form-control" name="bluetoothmodule_partref2" autocomplete="off" autofocus placeholder="Ref 2">
                        </div>
                        <div class="col-md-2">
                            <input id="bluetoothmodule_partref3" type="text" class="form-control" name="bluetoothmodule_partref3" autocomplete="off" autofocus placeholder="Ref 3">

                        </div>
                        <div class="col-md-2">
                            <input id="bluetoothmodule_partref4" type="text" class="form-control" name="bluetoothmodule_partref4" autocomplete="off" autofocus placeholder="Ref 4">

                        </div>
                        <div class="col-md-2">
                            <input id="bluetoothmodule_partref5" type="text" class="form-control" name="bluetoothmodule_partref5" autocomplete="off" autofocus placeholder="Ref 5">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="submitSku" class="btn btn-primary" value="Update SKU" />
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
{{--                    <input type="submit"  >Update SKU</input>--}}
                </div>
            </form>
        </div>
    </div>
</div>
