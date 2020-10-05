<nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">{{env('APP_NAME')}}</span>
    <form class="form-inline my-2 my-lg-0" action="/" method="get">
        <div class="input-group">
            <input class="form-control py-2 border-right-0 border" name="search" placeholder="Search" value="{{request('search')??''}}">
            <div class="input-group-append">
                <div class="input-group-text" id="btnGroupAddon2"><i class="fa fa-search"></i></div>
            </div>
        </div>
    </form>
    <div>
        <i class="fa fa-cart-arrow-down fa-4x" @click="toggleCart"></i>
        <div id="cart-menu" style="display: none">
            <h4>Cart Items</h4>
            <ul class="list-group" v-for="product in cart" v-if="cart.length">
                <li class="list-group-item">
                    <div class="d-flex">
                        <img :src="'storage/' + product.img_url" :alt="product.title" class="cart-item-menu">
                        <div>
                            <p>@{{product.title}}</p>
                            <span>@{{ product.price }}$</span>
                        </div>
                    </div>
                </li>
            </ul>
            <p v-if="!cart.length"> No Cart Items Yet</p>
            <div >

            </div>
            <div v-if="total">
                <div style="background: darkgray;" class="text-center">
                    <span style="vertical-align: super;">Total</span>
                    <span style="font-size: 2rem;">@{{ total.toFixed(2) }}</span>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary mt-1" @click="placeOrder">Place Order</button>
                </div>
            </div>
        </div>
    </div>

</nav>
