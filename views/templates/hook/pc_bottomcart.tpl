{*
 * Presta Cream Bottom Cart
 * 
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 wesite only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 * 
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please contact us for extra customization service at an affordable price
 *
 * @author     John Mark Mancol
 * @copyright  2023 Presta Cream
 * @license    MIT License (or the license you choose)
 *}

<div id="pc-bottom-cart" class="cart-summary-container {$appearance}">
    <div class="cart-items-container cart-items-container-js" style="display:none">
        <p>{$summary_title}</p>
        <div class="items-cont">
            {if $cart_items|count}
                {foreach from=$cart_items item="product" key="item_k"}
                    <div class="pc-box cart-item">
                        <div class="product-img-container">
                        {if $product.default_image}
                            <img src="{$product.default_image}" alt="{$product.name}" loading="lazy">
                        {else}
                            <img src="{$urls.no_picture_image.bySize.cart_default.url}" loading="lazy" />
                        {/if}
                        </div>
                        <div class="product-line-info">
                            <a class="label" href="{$product.url}" data-id_customization="{$product.id_customization|intval}">{$product.name}</a>
                            <div class="product-attrs">
                                {if $product.attributes}
                                    {foreach from=$product.attributes key="attribute" item="value"}
                                        <div class="attribute-pill {$attribute}">
                                            <span class="value">{$value}</span>
                                        </div>
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                        <div class="price-container">
                            {$product.formatted_price}
                        </div>
                        <a href="{$product.remove_from_cart_url}" class="btn-remove-item">
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14 3V2C14 0.895431 13.1046 0 12 0H6C4.89543 0 4 0.89543 4 2V3H1C0.447716 3 0 3.44772 0 4C0 4.55228 0.447716 5 1 5H2V16C2 17.6569 3.34315 19 5 19H13C14.6569 19 16 17.6569 16 16V5H17C17.5523 5 18 4.55228 18 4C18 3.44772 17.5523 3 17 3H14ZM12 2H6V3H12V2ZM14 5H4V16C4 16.5523 4.44772 17 5 17H13C13.5523 17 14 16.5523 14 16V5Z" fill="#B1B1B1"/>
                            </svg>
                        </a>
                    </div>
                {/foreach}
                <a href="{$urls.pages.cart}" class="checkout-btn">{$cart_btn_lbl}</a>
            {else}
                <div class="empty-message pc-box">
                    <p>{$no_cart_item_text}</p>
                </div>
            {/if}
        </div>
        {* <pre>{$cart_items|print_r}</pre> *}
    </div>
    <div class="cart-summary-fixed">
        <div class="cart-count">{$cart_total_items}</div>
        <div class="cart-icon">
            <svg width="23" height="28" viewBox="0 0 23 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.0724 24.3613C22.0286 23.2299 21.9775 22.0766 21.9264 20.9672C21.9118 20.6314 21.8972 20.2883 21.8753 19.9526C21.7366 16.9526 21.5906 13.9526 21.452 10.9599L21.4374 10.6241C21.4155 10.1277 21.3936 9.61679 21.3498 9.11314C21.233 7.62409 19.9629 6.43431 18.4593 6.41241C18.0286 6.40511 17.6052 6.40511 17.1527 6.41241C17.0724 6.41241 16.9921 6.41241 16.9191 6.41241C16.9483 4.81387 16.4812 3.5 15.5031 2.40511C14.379 1.14964 12.9629 0.507299 11.2914 0.5C11.2841 0.5 11.2695 0.5 11.2622 0.5C9.88991 0.5 8.67094 0.952555 7.63444 1.85037C6.29867 3.00365 5.63444 4.5365 5.66364 6.40511C5.58334 6.40511 5.49575 6.40511 5.41546 6.40511C4.97021 6.40511 4.54685 6.40511 4.11619 6.40511C2.77313 6.42701 1.58334 7.38321 1.29867 8.68248C1.21838 9.04015 1.20378 9.39781 1.18188 9.74818L1.17459 9.82847C1.11619 10.9526 1.0651 12.0985 1.014 13.2007C0.984805 13.8066 0.955607 14.4124 0.93371 15.0182C0.889914 15.9964 0.838819 16.9672 0.795024 17.9453C0.692834 20.0401 0.590644 22.208 0.503053 24.3394C0.466556 25.1934 0.758527 25.9891 1.31327 26.573C1.88261 27.1642 2.67094 27.4927 3.53225 27.4927C6.10159 27.4927 8.69283 27.5 11.2768 27.5C13.8607 27.5 16.452 27.5 19.0213 27.4927C19.8826 27.4927 20.6709 27.1715 21.233 26.5876C21.8096 26.011 22.1016 25.2153 22.0724 24.3613ZM19.5906 24.4343C19.5906 24.5657 19.576 24.7482 19.452 24.8723C19.3352 24.9964 19.1454 25.0182 19.014 25.0182C17.1381 25.0182 15.2549 25.0182 13.379 25.0182H9.77313C7.73663 25.0182 5.70013 25.0182 3.66364 25.0182C3.40086 25.0182 3.21838 24.9672 3.12349 24.865C3.0286 24.7628 2.9848 24.5876 2.9994 24.3394C3.13079 21.4635 3.26948 18.5876 3.40816 15.7044L3.59794 11.5949C3.61254 11.354 3.61984 11.1204 3.62714 10.8796C3.64904 10.4051 3.67094 9.91606 3.70013 9.43431C3.72203 9.03285 3.89721 8.87226 4.31327 8.87226C5.78042 8.86496 7.24028 8.86496 8.70743 8.86496C10.5468 8.85767 12.3863 8.85767 14.2257 8.85037C15.5687 8.85037 16.9118 8.84307 18.2476 8.83577H18.2549C18.6928 8.83577 18.868 9.00365 18.8899 9.41971C18.9556 10.6606 19.014 11.9307 19.0724 13.1496C19.0943 13.6533 19.1162 14.1569 19.1454 14.6606L19.2622 17.1934C19.3644 19.3029 19.4593 21.4124 19.5614 23.5219C19.576 23.9015 19.5833 24.1788 19.5906 24.4343ZM9.43736 3.59489C10.5322 2.80657 11.6709 2.74088 12.8242 3.39781C13.9337 4.02555 14.4593 5.01095 14.4301 6.39781H8.14539C8.10889 5.16423 8.53225 4.24453 9.43736 3.59489Z" fill="black"/>
                <path d="M15.9337 10.0401C15.233 9.86496 14.5979 10.2591 14.379 10.9964C14.2914 11.3029 14.2038 11.5949 14.0651 11.8504C13.452 13.0255 12.2038 13.6533 10.8169 13.4781C9.60524 13.3248 8.56875 12.3613 8.24028 11.0766C8.0359 10.2883 7.41546 9.87226 6.68553 10.0474C6.37167 10.1204 6.10889 10.3102 5.94831 10.573C5.75853 10.8796 5.71473 11.2737 5.81692 11.6825C6.44466 14.208 8.70013 15.9672 11.2987 15.9672C13.9483 15.9672 16.2111 14.1715 16.8096 11.6022C16.9848 10.8723 16.6052 10.208 15.9337 10.0401Z" fill="black"/>
            </svg>
        </div>
        <div><b>{l s='Shopping Cart' mod='pc_bottomcart'}</b></div>
        <div class="total-container">
            {l s='Total' mod='pc_bottomcart'}:
            <b class="cart-subtotal">{$cart_total}</b>
        </div>
    </div>
</div>