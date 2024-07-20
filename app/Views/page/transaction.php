<div class="p-2 flex h-[100%] w-[100%]">
    <!-- card product -->
    <div class=" h-[100%] w-[60%] px-2">

        <div class="">
            <h4 class="text-2xl font-bold">Product</h4>
        </div>

        <div id="product_card" class="flex gap-1 overflow-scroll h-[100vh] p-2 flex-wrap overflow-x-hidden">

        </div>
    </div>

    <hr>
    <!-- total order -->
    <div class="bg-gray-100 h-[100%] w-[40%] relative box-border rounded-md p-2">
        <div class="flex justify-between items-center">
            <h4>
                Total
                <span class="font-semibold underline decoration-sky-500/30" id="total_Harga"></span>
            </h4>
            <label for="my_modal_9" class="btn btn-outline btn-accent">Bayar</label>
        </div>
        <div>
            <div class="overflow-x-auto">
                <table id="table_order" class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- Open the modal using ID.showModal() method -->

<input type="checkbox" id="my_modal_6" class="modal-toggle" />

<div id="modalStore" class="modal show" role="dialog">
    <div class="modal-box ">
        <form id="setOrder" class="flex flex-col gap-2">
            <label class="input input-bordered flex items-center gap-2">
                Name
                <input autocomplete="off" type="text" disabled class="grow" id="name_product" placeholder="Product" />
            </label>

            <label class="input input-bordered flex items-center gap-2">
                Price
                <input type="number" disabled class="grow" id="price_product" placeholder="Rupiah" />
            </label>
            <label class="input input-bordered flex items-center gap-2">
                Qty
                <input type="number" class="grow" id="qty_product" required />
            </label>
            <label class="input input-bordered flex items-center gap-2">
                Total
                <input type="text" disabled class="grow" id="total_product" placeholder="Rupiah" />
            </label>
            <div class="modal-action">
                <label onclick="clearQty()" for="my_modal_6" class="btn">Close</label>

                <button type="submit" class="btn btn-active btn-primary">
                    <label for="my_modal_6" class="">Simpan</label>
                </button>

            </div>
        </form>
    </div>
</div>

<input type="checkbox" id="my_modal_9" class="modal-toggle" />

<div id="modalStore" class="modal show" role="dialog">
    <div class="modal-box ">
        <form id="setOrder" class="flex flex-col gap-2">
            <label class="input input-bordered flex items-center gap-2">
                Name
                <input autocomplete="off" type="text" disabled class="grow" id="name_product" placeholder="Product" />
            </label>

            <label class="input input-bordered flex items-center gap-2">
                Price
                <input type="number" disabled class="grow" id="price_product" placeholder="Rupiah" />
            </label>
            <label class="input input-bordered flex items-center gap-2">
                Qty
                <input type="number" class="grow" id="qty_product" required />
            </label>
            <label class="input input-bordered flex items-center gap-2">
                Total
                <input type="text" disabled class="grow" id="total_product" placeholder="Rupiah" />
            </label>
            <div class="modal-action">
                <label onclick="clearQty()" for="my_modal_9" class="btn">Close</label>

                <button type="submit" class="btn btn-active btn-primary">
                    <label for="my_modal_9" class="">Simpan</label>
                </button>

            </div>
        </form>
    </div>
</div>

<script>
function clearQty() {
    $('#qty_product').val("")
}

var orderProduct = []

function inputTableOrder() {
    $('#table_order tbody').html("")
    $('#total_Harga').html("")
    var total = 0
    for (const item of orderProduct) {
        total = total + item.setTotal
        $('#table_order tbody').append(`
        <tr>
            <td>null</td>
            <td>${item.setName_product}</td>
            <td>${item.setPrice}</td>
            <td>${item.setQty}</td>
            <td>${item.setTotal}</td>
            <td><button class="btn btn-sm bg-red-500 text-white">Hapus</button></td>
        </tr>
        `)
    }
    $('#total_Harga').append(total)
}


$('#setOrder').on("submit", function(e) {
    e.preventDefault()
    let setInputOrder = {
        setName_product: $('#name_product').val(),
        setQty: $('#qty_product').val(),
        setPrice: $('#price_product').val(),
        setTotal: $('#qty_product').val() * $('#price_product').val()
    }
    orderProduct.push(setInputOrder)
    clearQty()
    inputTableOrder()
    console.log(orderProduct)



})

function detailProduct(id) {

    $.ajax({
        url: "/product/edit/" + id,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#name_product').val(data.name_product)
            $('#price_product').val(data.price_product)
        }
    })
}



$.ajax({
    url: "/product/data",
    method: "GET",
    dataType: "JSON",
    success: function(data) {
        for (const product of data) {
            $('#product_card').append(`
            <label onclick="detailProduct('${product.id_product}')" for="my_modal_6" class="transition delay-80 ease-in-out hover:scale-90 h-fit hover:cursor-pointer">
                <div class="card image-full w-[200px] h-fit shadow-xl">
                    <figure>
                        <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.jpg"
                            alt="Shoes" />
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title">${product.name_product}</h2>
                        <p class="font-semibold">Rp. ${product.price_product}</p>
                    </div>
                </div>
            </label>
            `)
        }

    }
})
</script>