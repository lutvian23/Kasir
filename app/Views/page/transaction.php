<div class="p-2 flex h-[100%] w-[100%]">

    <!-- card product -->
    <div class=" h-[100%] w-[55%] px-2">
        <!-- Header -->
        <div class="">
            <h4 class="text-2xl font-bold">Product</h4>
        </div>
        <!-- content card -->
        <div id="product_card" class="flex gap-1 overflow-scroll h-[100vh] p-2 flex-wrap overflow-x-hidden"></div>
    </div>

    <hr>

    <!-- total order -->
    <div class="bg-gray-100 h-[100%] w-[45%] relative box-border rounded-md p-2">
        <div class="flex justify-between items-center">
            <div>
                <p>
                    Total
                    <span class="font-semibold underline decoration-sky-500/30" id="sub_total"></span>
                </p>
                <p>No : <span id="no_transaction"></span></p>
            </div>
            <label for="my_modal_9" class="btn btn-outline btn-accent">Bayar</label>
        </div>
        <div class="h-[100%] overflow-y-scroll overflow-x-hidden border-box">
            <div class="">
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

<!-- Modal Order -->
<input type="checkbox" id="my_modal_6" class="modal-toggle" />

<div id="modalStore" class="modal show" role="dialog">
    <div class="modal-box ">
        <form id="setOrder" class="flex flex-col gap-2">
            <input type="text" id="id_product" class="hidden">
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
            <div class="modal-action">
                <label onclick="clearQty()" for="my_modal_6" class="btn">Close</label>
                <button type="submit" class="btn btn-active btn-primary">
                    <label for="my_modal_6" class="">Simpan</label>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Transaction -->
<input type="checkbox" id="my_modal_9" class="modal-toggle" />

<div id="modalStore" class="modal show" role="dialog">
    <div class="modal-box ">
        <form id="actTransaction" class="flex flex-col gap-2">
            <label class="input input-bordered flex items-center gap-2">
                No
                <input class="bg-white no_transaction" type="number" disabled class="grow" />
            </label>
            <label class="input input-bordered flex items-center gap-2">
                Total Item
                <input class="bg-white" type="number" disabled class="grow" id="total_item" placeholder="Qty" />
            </label>
            <label class="input input-bordered flex items-center gap-2">
                Total Price
                <input type="text" disabled class="grow" id="total_harga" />
            </label>
            <div class="flex justify-center gap-2">
                <label class="input input-bordered flex items-center gap-2">
                    Debit
                    <input type="radio" id="debit" value="debit" name="radio-1" class="radio" />
                </label>
                <label class="input input-bordered flex items-center gap-2">
                    Cash
                    <input type="radio" id="cash" value="cash" name="radio-1" class="radio" />
                </label>
            </div>
            <label class="input input-bordered flex items-center gap-2">
                Received
                <input type="number" class="grow" id="received" placeholder="Rupiah" />
            </label>
            <p id="alert_payment" class="text-red-500 font-semibold"></p>
            <div class="modal-action">
                <label onclick="clearQty()" for="my_modal_9" class="btn">Close</label>
                <button type="submit" class="btn btn-active btn-primary">
                    <label for="my_modal_9" class="">Bayar</label>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// For Place Order
var orderProduct = []

// Function clear Qty order
function clearQty() {
    $('#qty_product').val("")
}

// variable total price
var total

// Handle Table Order
function inputTableOrder() {
    total = 0
    $('#table_order tbody').html("")
    $('#sub_total').html("")
    let setNo = 1
    for (const [index, item] of orderProduct.entries()) {
        total += item.setTotal
        $('#table_order tbody').append(`
        <tr>
            <td>${setNo}</td>
            <td>${item.setName_product}</td>
            <td>${currency(item.setPrice)}</td>
            <td>${item.setQty}</td>
            <td>${currency(item.setTotal)}</td>
            <td><button onclick="clearArrProduct('${index}')" class="btn btn-sm bg-red-500 text-white">Hapus</button></td>
        </tr>
        `)
        setNo++
    }
    $('#sub_total').append(currency(total))
    $('#total_harga').val(currency(total))
    $('#total_item').val(orderProduct.length)
}

// Delete In Array Product
function clearArrProduct(id) {
    orderProduct.splice(id, 1)
    inputTableOrder()
    console.log(orderProduct)
}

// Form Order 
$('#setOrder').on("submit", function(e) {
    e.preventDefault()
    let setInputOrder = {
        setId_product: $('#id_product').val(),
        setName_product: $('#name_product').val(),
        setQty: $('#qty_product').val(),
        setPrice: $('#price_product').val(),
        setTotal: $('#qty_product').val() * $('#price_product').val()
    }
    orderProduct.push(setInputOrder)
    clearQty()
    inputTableOrder()
})


// Handle detail product for card form
function detailProduct(id) {
    $.ajax({
        url: "/product/edit/" + id,
        method: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#id_product').val(data.id_product)
            $('#name_product').val(data.name_product)
            $('#price_product').val(data.price_product)
        }
    })
}

// Show Card from data product
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
                        <p class="font-semibold">${currency(product.price_product)}</p>
                    </div>
                </div>
            </label>
            `)
        }
    }
})

// Call Number Transaction
$.ajax({
    url: "/transaction/data",
    method: "GET",
    dataType: "JSON",
    success: function(response) {
        $('#no_transaction').append(response.success)
        $('.no_transaction').val(response.success)
    }
})



$('#actTransaction').on("submit", function(e) {
    e.preventDefault()
    var payment = $('#received').val()
    var paymentType = $('input[name="radio-1"]:checked').val()
    console.log(payment, total)
    if (Number(payment) <= Number(total)) {
        $('#message_danger').append('Jumlah yang di berikan tidak cukup')
        alertMessage()
        $('#received').val(0)
    } else {
        for (const item of orderProduct) {
            $.ajax({
                url: "/transaction/detail/add",
                method: "POST",
                dataType: "JSON",
                data: {
                    id_transaction: $('.no_transaction').val(),
                    id_product: item.setId_product,
                    name_product: item.setName_product,
                    qty: item.setQty,
                    sub_total: item.setTotal
                },
                success: function(response) {
                    console.log(response)
                }
            })
        }

        $.ajax({
            url: "/transaction/add",
            method: "POST",
            dataType: "JSON",
            data: {
                id_transaction: $('.no_transaction').val(),
                payment_type: paymentType,
                total: total
            },
            success: function(response) {
                console.log(response)
            }
        })
        $('#content').load('/transaction')
        alertSuccess()
    }
})
</script>