<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Category</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                            {{-- <tr>
                                <td>1</td>
                                <td>Category 1</td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#update-modal">Edit</button>
                                    <button data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getList();
    async function getList() {
        showLoader();
        let res = await axios.get('/category-list');
        hideLoader();
        let tableList = $("#tableList");
        let tableData = $("tableData");
        // tableData.DataTable().destroy();
        $('#tableData').DataTable().destroy();
        tableList.empty();
        res.data.data.forEach(function(item, index) {
            let row = ` <tr>
                             <td>${index + 1}</td>
                            <td>${item.name}</td>
                            <td>
                                <button data-id="${item.id}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                                <button data-id="${item.id}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                            </td>
                            </tr>`
            tableList.append(row);
        })

        $(".deleteBtn").on("click", function() {
            let id = $(this).data("id");
            $("#deleteID").val(id);
            $("#delete-modal").modal("show");
        })

        $(".editBtn").on("click",async function(){
            let id = $(this).data("id");
            await getSingleData(id);
            $("#update-modal").modal("show");
        })
        let table = new DataTable('#tableData', {
            order:[[0, 'desc']],
            lengthMenu: [
                [ 5,10, 25, 50, -1 ],
                [ '5 rows','10 rows', '25 rows', '50 rows', 'Show all' ]
            ]
        });
    }
</script>
