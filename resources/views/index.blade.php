@extends('master')

@section('content')
    <div class="alert" id="feedback"></div>
    @if($products->count())
    @foreach($products->chunk(3) as $productSet)
        <div class="card-deck">
            @foreach($productSet as $product)
                <div class="card">
                    <img class="card-img-top" src="{{asset('storage/'.$product->img_url)}}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->title}}</h5>
                        <p class="card-text">{{$product->price}} $</p>
                    </div>
                    <div class="card-footer">
                        <input type="number" min="0" max="{{$product->quantity}}" name="quantity" value="0"
                               @change="addToCart('{{json_encode($product)}}', $event )">
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    @endif
@endsection
@section('body-scripts')
    <script>
        let app = new Vue({
            el: '#app',
            data: {
                cart: [],
                total: 0,
                loading: false
            },
            methods: {
                addToCart(productData, event) {
                    let product = JSON.parse(productData);
                    let quantity = Number(event.target.value);
                    if (isNaN(quantity)) {
                        alert('Please Enter a valid number');
                        return;
                    }
                    product.quantity = quantity;
                    let itemIndex = this.spotCartItem(product.id);
                    this.updateCartItems(product, itemIndex);
                    this.updateCartTotal();
                },
                spotCartItem(id) {
                    return this.cart.findIndex((item) => item.id === id)
                },
                updateCartItems(product, itemIndex) {
                    if (!product.quantity && itemIndex > -1) {
                        this.cart.splice(itemIndex, 1);
                        return;
                    }
                    if (itemIndex > -1) {
                        this.cart[itemIndex].quantity = product.quantity;
                    } else {
                        this.cart.push(product);
                    }
                },
                updateCartTotal() {
                    if (!this.cart.length) {
                        this.total = 0;
                        return;
                    }
                    this.total = 0;
                    this.cart.forEach((product) => {
                        this.total += product.quantity * product.price;
                    })
                },
                toggleCart() {
                    $('#cart-menu').toggle();
                },
                placeOrder() {
                    this.loading = true;
                    axios.post('order/create', this.cart)
                        .then((response) => {
                            this.loading = false;
                            let data = response.data;
                            if (data.success) {
                                $('#feedback').html('The order has been placed').addClass('alert-success').fadeIn().fadeOut(2000);
                                this.resetCart();
                            } else {
                                $('#feedback').html(data.error).addClass('alert-danger').fadeIn().fadeOut(5000);
                            }
                        })
                        .catch(error => {
                            this.loading = false;
                            let data = error.response.data;
                            this.toggleCart();
                            $('#feedback').html(data.error).addClass('alert-danger').fadeIn().fadeOut(5000);
                        })
                },
                resetCart(){
                    this.cart = [];
                    this.total = 0;
                    this.toggleCart();
                }
            }
        });
    </script>
@endsection
