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
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

<script>
    getList();


async function getList() {

    showLoader();
    let res = await axios.get("/list-category");
    
    
    
    hideLoader();

    let tableList = $("#tableList");
    let tableData = $("#tableData");

    tableData.DataTable().destroy();
    tableList.empty();

    res.data.categories.forEach(function (item, index) {
        
        
        const created_at = moment(item['created_at']);
        const updated_at = moment(item['updated_at']);
        
        
    
        let row = `<tr>
                    <td>${index+1}</td>
                    <td>${item['name']}</td>
                    <td>${ created_at.format('D MMMM, YYYY')  }</td>
                    <td>${ updated_at.format('D MMMM, YYYY')  }</td>
                    
                    
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                    </td>
                </tr>`

        tableList.append(row)
    })



    $('.editBtn').on('click', async function () {
        let id= $(this).data('id');
        await FillUpUpdateForm(id)
        $("#update-modal").modal('show');


    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        $("#delete-modal").modal('show');
        $("#deleteID").val(id);
    })

    new DataTable('#tableData', {
        order:[[0,'desc']],
        lengthMenu:[5,10,15,20,30]
    });

}


</script>