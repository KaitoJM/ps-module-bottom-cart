/**
 * Presta Cream Bottom Cart
 * NOTICE OF LICENSE
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * DISCLAIMER
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 * @author     John Mark Mancol
 * @copyright  2023 Presta Cream
 * @license    MIT License (or the license you choose)
 */
jQuery(function() {
    $(document).on('click','.cart-summary-fixed', function() {
        if ($('.cart-summary-container').hasClass('open')) {
            $('.cart-summary-container').removeClass('open');
            setTimeout(function() {
                $('.cart-items-container-js').hide();
            },300)
        } else {
            $('.cart-items-container-js').show();
            setTimeout(function() {
                $('.cart-summary-container').addClass('open');
            },300)
        }
    })
})

prestashop.on('updateCart', function(e) {
    let cart = e.resp.cart;
    console.log(cart)
    let total_count = cart.products.map((product) => {
        return product.quantity
    }).reduce((partialSum, a) => partialSum + a, 0);

    $('.cart-count').html(total_count);
    $('.cart-subtotal').html(cart.subtotals.products.value);

    //update cart items
    let cart_items = '';

    if (cart.products.length) {
        cart.products.forEach(product => {
            cart_items += '<div class="pc-box cart-item"> \
                <div class="product-img-container">';
            
            if (product.cover) {
                cart_items += '<img src="' + product.cover.bySize.cart_default.url + '" alt="' + product.name + '" loading="lazy">'
            } else {
                cart_items += '<img src="' + prestashop.urls.no_picture_image.bySize.cart_default.url + '" alt="' + product.name + '" loading="lazy">'
            }

            cart_items += '</div> \
                <div class="product-line-info"> \
                    <a class="label" href="' + product.url + '" data-id_customization="' + product.id_customization + '">' + product.name + '</a> \
                    <div class="product-attrs">';

            if (product.attributes.length) {
                cart_items += '<div class="attribute-pill"> \
                        <span class="value">{$value}</span> \
                    </div>'
            }

            if (typeof product.attributes === 'object') {
                const keys = Object.keys(product.attributes);

                keys.forEach((key, index) => {
                    cart_items += '<div class="attribute-pill ' + key + '"> \
                            <span class="value">' + key + ': ' + product.attributes[key] + '</span> \
                        </div>'
                });
            }

            cart_items += '</div> \
                </div> \
                <div class="price-container"> \
                    ' + product.price_amount + ' \
                </div> \
                <a href="' + product.remove_from_cart_url + '" class="btn-remove-item"> \
                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg"> \
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14 3V2C14 0.895431 13.1046 0 12 0H6C4.89543 0 4 0.89543 4 2V3H1C0.447716 3 0 3.44772 0 4C0 4.55228 0.447716 5 1 5H2V16C2 17.6569 3.34315 19 5 19H13C14.6569 19 16 17.6569 16 16V5H17C17.5523 5 18 4.55228 18 4C18 3.44772 17.5523 3 17 3H14ZM12 2H6V3H12V2ZM14 5H4V16C4 16.5523 4.44772 17 5 17H13C13.5523 17 14 16.5523 14 16V5Z" fill="#B1B1B1"/> \
                    </svg> \
                </a> \
            </div>'
            
        });

        $('.items-cont').html(cart_items);
    }
})