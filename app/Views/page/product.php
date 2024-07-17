<div class="p-2 flex flex-col gap-2 ">
    <div class="flex justify-between ">
        <h4 class="font-bold text-[20px]">PRODUCT</h4>
        <label class="btn btn-sm" for="my_modal_6">Tambah Data</label>
    </div>
    <div class="">
        <table class="" id="table_product">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>


    <input type="checkbox" id="my_modal_6" class="modal-toggle" />

    <div id="modalStore" class="modal show" role="dialog">
        <div class="modal-box ">
            <form id="storeProduct" class="flex flex-col gap-2">
                <label class="input input-bordered flex items-center gap-2">
                    Name
                    <input autocomplete="off" type="text" class="grow" id="name_product" placeholder="Product" />
                </label>
                <select id="category_product" class="select select-bordered w-full">
                    <option disabled selected>Category</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Pembersih">Alat Pembersih</option>
                    <option value="Barang">Barang</option>
                </select>

                <label class="input input-bordered flex items-center gap-2">
                    Price
                    <input type="number" class="grow" id="price_product" placeholder="Rupiah" />
                </label>
                <div class="modal-action">
                    <label for="my_modal_6" class="btn">Close</label>

                    <button type="submit" class="btn btn-active btn-primary">
                        <label for="my_modal_6" class="">Simpan</label>
                    </button>

                </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="my_modal_7" class="modal-toggle" />

    <div id="modalStore" class="modal show" role="dialog">
        <div class="modal-box ">
            <form id="editProduct" class="flex flex-col gap-2">
                <label class="input input-bordered flex items-center gap-2">
                    Name
                    <input autocomplete="off" type="text" class="grow" id="name_product_edit" placeholder="Product" />
                </label>
                <select id="category_product_edit" class="select select-bordered w-full">
                    <option disabled selected>Category</option>
                    <option value="Minuman">Minuman</option>
                    <option value="Makanan">Makanan</option>
                    <option value="Pembersih">Alat Pembersih</option>
                    <option value="Barang">Barang</option>
                </select>

                <label class="input input-bordered flex items-center gap-2">
                    Price
                    <input type="number" class="grow" id="price_product_edit" placeholder="Rupiah" />
                </label>
                <div class="modal-action">
                    <label for="my_modal_7" class="btn">Close</label>

                    <button type="submit" class="btn btn-active btn-primary">
                        <label for="my_modal_7" class="">Simpan</label>
                    </button>

                    <input type="text" id="id_product" class="hidden">
                </div>
            </form>
        </div>
    </div>


</div>

<!-- Put this part before </body> tag -->

<script>
$.ajax({
    url: "/product/data",
    method: "GET",
    dataType: "JSON",
    success: function(data) {
        $('#table_product').dataTable({
            lengthChange: false,
            // processing: true,
            responsive: true,
            // info: false,
            // paging: false,
            // serverSide: true,
            data: data,
            columns: [{
                    data: null,
                    label: "No"
                },
                {
                    data: "name_product",
                    label: "Name"
                },
                {
                    data: "category_product",
                    label: "Category"
                },
                {
                    data: "price_product",
                    label: "Price"
                },
                {
                    data: null,
                    label: "Stock"
                },
                {
                    data: "id_product",
                    label: "Action",
                    render: function(data, row, type) {
                        return `
                        <div class="flex gap-2">
                            <label class="btn btn-sm bg-[#FBFF01]" for="my_modal_7" onclick="editProduct('${data}')">Edit</label>
                            <button class="btn btn-sm bg-[#FF5050]" onclick="deleteProduct('${data}')">Delete</button>
                        </div>
                        `
                    }
                },
            ]
        })
    }
})


$('#storeProduct').on("submit", function(e) {
    e.preventDefault()

    $.ajax({
        url: "/product/add",
        method: "POST",
        dataType: "JSON",
        data: {
            name_product: $('#name_product').val(),
            category_product: $('#category_product').val(),
            price_product: $('#price_product').val()
        },
        success: function(response) {
            var resError = response.error
            if (response.error) {
                //
                Object.keys(resError).forEach(key => {
                    $('#message_danger').append(`<li>${resError[key]}</li>`)
                })
                alertMessage()
            } else {
                $('#content').load('/product')
                alertSuccess()
            }
        },
        error: function(textStatus, xhr) {
            console.log(textStatus)
        }
    })
})

function editProduct(id) {
    $.ajax({
        url: "/product/edit/" + id,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#name_product_edit').val(data.name_product)
            $('#category_product_edit').val(data.category_product)
            $('#price_product_edit').val(data.price_product)
            $('#id_product').val(data.id_product)
        }
    })
}

$('#editProduct').on("submit", function(e) {
    e.preventDefault()
    var id_product = $('#id_product').val()
    console.log(id_product)
    $.ajax({
        url: "/product/update/" + id_product,
        method: "PUT",
        dataType: "JSON",
        data: {
            name_product_edit: $('#name_product_edit').val(),
            category_product_edit: $('#category_product_edit').val(),
            price_product_edit: $('#price_product_edit').val()
        },
        success: function(response) {
            if (response.error) {
                var resError = response.error
                Object.keys(resError).forEach(key => {
                    $('#message_danger').append(`<li>${resError[key]}</li>`)
                })
                alertMessage()
            } else {
                $('#content').load('/product')
                alertSuccess()
            }
            console.log(response)
        },
        error: function(textStatus, xhr, errorThrow) {
            console.log(textStatus)
        }

    })
})

function deleteProduct(id) {
    $.ajax({
        url: "/product/delete/" + id,
        method: 'DELETE',
        success: function(response) {
            console.log(response)
            $('#content').load('/product')
            alertSuccess()
        }
    })
}
</script>