<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>
                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">
                                <br />
                                <img class="w-15" id="oldImg" src="{{ asset('images/default.jpg') }}" />
                                <br />
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                    class="form-control" id="productImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>

        </div>
    </div>
</div>

<script>
    categoryList();
    async function categoryList() {
        let res = await axios.get("/category-list");
        res.data.data.forEach(function(item, index) {
            let option = `
            <option value="${item.id}" class="">${item.name}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }

    async function singleProduct(id) {
        showLoader();
        let res = await axios.post('/product-by-id', {
            id: id
        })
        hideLoader();
        document.getElementById("updateID").value = id;
        document.getElementById("productNameUpdate").value = res.data.data.name;
        document.getElementById("productPriceUpdate").value = res.data.data.price;
        document.getElementById("productUnitUpdate").value = res.data.data.unit;
        document.getElementById("productCategoryUpdate").value = res.data.data.category_id;
        document.getElementById("oldImg").src = `/storage/${res.data.data.img_url}`;
        document.getElementById('productImgUpdate').src = res.data.data.img_url;
    }

    async function update() {
        let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
        let productNameUpdate = document.getElementById('productNameUpdate').value;
        let productPriceUpdate = document.getElementById('productPriceUpdate').value;
        let productUnitUpdate = document.getElementById('productUnitUpdate').value;
        let productImgUpdate = document.getElementById('productImgUpdate').files[0];
        let updateID = document.getElementById('updateID').value;

        if (productCategoryUpdate.length === 0) {
            errorToast("Select A Category");
        } else if (productNameUpdate.length === 0) {
            errorToast("Product Name Required.");
        } else if (!productPriceUpdate || isNaN(productPriceUpdate) || Number(productPriceUpdate) <= 0) {
            errorToast("Price must be a number & greater than 0.");
        } else if (productUnitUpdate.length === 0) {
            errorToast("Product Unit Required.");
        } else {
            document.getElementById('update-modal-close').click();
            showLoader();
            try {
                let formData = new FormData();
                formData.append('id', updateID);
                formData.append('name', productNameUpdate);
                formData.append('price', productPriceUpdate);
                formData.append('unit', productUnitUpdate);
                formData.append('image', productImgUpdate);
                formData.append('category_id', productCategoryUpdate);

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                let res = await axios.post("/product-update", formData, config);
                hideLoader();
                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message);
                    document.getElementById('update-form').reset();
                    await getList();
                }
            } catch (err) {
                hideLoader();
                if (err.response && err.response.status === 422) {
                    const errors = err.response.data.errors;
                    for (const key in errors) {
                        errorToast(errors[key][0]);
                    }
                    document.getElementById('update-form').reset();
                } else {
                    errorToast("Something went wrong");
                }
            }
        }
    }
</script>
