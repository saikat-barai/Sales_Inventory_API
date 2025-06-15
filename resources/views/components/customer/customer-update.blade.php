<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <input type="text" class="form-control" id="customerNameUpdate">

                                <label class="form-label mt-3">Customer Email *</label>
                                <input type="text" class="form-control" id="customerEmailUpdate">

                                <label class="form-label mt-3">Customer Mobile *</label>
                                <input type="text" class="form-control" id="customerMobileUpdate">

                                <input type="text" class="form-control d-none" id="updateID">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>
        </div>
    </div>
</div>



<script>
    // getList();
    async function getSingleData(id) {
        document.getElementById("updateID").value = id;
        showLoader();
        let res = await axios.post('/customer-by-id', {
            id: id
        })
        hideLoader();
        document.getElementById("customerNameUpdate").value = res.data.data.name;
        document.getElementById("customerEmailUpdate").value = res.data.data.email;
        document.getElementById("customerMobileUpdate").value = res.data.data.mobile;
    }

    async function Update() {
        let customerNameUpdate = document.getElementById('customerNameUpdate').value;
        let customerEmailUpdate = document.getElementById('customerEmailUpdate').value;
        let customerMobileUpdate = document.getElementById('customerMobileUpdate').value;
        let updateID = document.getElementById('updateID').value;
        if (customerNameUpdate.length === 0) {
            errorToast('Customer Name is required');
        } else if (!customerEmailUpdate.includes("@") || !customerEmailUpdate.includes(".")) {
            errorToast('Must be Email required');
        } else {
            try {
                document.getElementById('update-modal-close').click();
                showLoader();
                let res = await axios.post('/customer-update', {
                    name: customerNameUpdate,
                    email: customerEmailUpdate,
                    mobile: customerMobileUpdate,
                    id: updateID
                })
                hideLoader();
                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    getList();
                    document.getElementById('update-form').reset();
                } else {
                    document.getElementById('update-form').reset();
                    errorToast(res.data.message);
                }
            } catch (err) {
                hideLoader();
                if (err.response.status === 422) {
                    let errors = err.response.data.message;
                    for (let key in errors) {
                        errorToast(errors[key][0]);
                    }
                } else {
                    errorToast("Something went wrong");
                }
            }
        }

    }
</script>
