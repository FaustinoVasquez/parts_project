<div class="modal fade show" id="ocAccModal" aria-modal="true" aria-hidden="true" style="padding-right: 15px;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Extra Large Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form name="accDataForm" role="form" method="POST" id="accDataForm" action="{{route('oc.store')}}">
                @csrf
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="ocId" class="col-sm-2 col-form-label">OCConfigId</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="ocId" id="ocId" readonly>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aPartName" class="col-sm-2 col-form-label">Part Name</label>
                        <div class="col-sm-10">
                            <select name="aPartName" aria-label="select model" id="aPartName"
                                    class=" form-control">
                                <option value="">PartName</option>
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aMitSKU" class="col-sm-2 col-form-label">MITSKU</label>
                        <div class="col-sm-10">
                            <select name="aMitSKU" aria-label="select model" id="aMitSKU"
                                    class=" form-control ">
                                <option value="">MITSKU</option>
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aQtyRequired" class="col-sm-2 col-form-label">Qty Required</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="aQtyRequired" id="aQtyRequired">
                            <span class="invalid-feedback" role="alert">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aNotes" class="col-sm-2 col-form-label">Notes</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="aNotes" id="aNotes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnOCAccessories" class="btn btn-primary mb-4 btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
