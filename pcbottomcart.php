<?php
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
if (!defined('_PS_VERSION_')) {
    exit;
}
class PcBottomCart extends Module
{
    public function __construct()
    {
        $this->module_key = 'f0ae3ad939b4584d860bacee62de8b46';
        $this->name = 'pcbottomcart';
        $this->tab = 'front_office_features';
        $this->version = '1.0.1';
        $this->author = 'PrestaCream';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => '8.99.99',
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('PC Bottom Cart Dialog');
        $this->description = $this->l('This will display a fancy summary of cart at the bottom of your shop page which will expand for more cart information when clicked.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        if (!Configuration::get('PC_CART_TITLE')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        Configuration::updateValue('PC_SUMMARY_TITLE', 'Cart Item Details');
        Configuration::updateValue('PC_NO_ITEMS_TEXT', 'Your shopping cart is empty.');
        Configuration::updateValue('PC_CART_BUTTON_LABEL', 'Proceed to Checkout');
        Configuration::updateValue('APPEARANCE_TYPE', 'glassy');

        return
            parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('actionFrontControllerSetMedia')
            && Configuration::updateValue('PC_CART_TITLE', 'Cart Summary');
    }

    public function uninstall()
    {
        return
            parent::uninstall()
            && Configuration::deleteByName('PC_CART_TITLE');
    }

    public function getContent()
    {
        $output = '';
        // this part is executed only when the form is submitted
        if (Tools::isSubmit('submit' . $this->name)) {
            // retrieve the value set by the user
            $summary_title = (string) Tools::getValue('PC_SUMMARY_TITLE');
            $no_items_text = (string) Tools::getValue('PC_NO_ITEMS_TEXT');
            $cart_btn_lbl = (string) Tools::getValue('PC_CART_BUTTON_LABEL');
            $appearance = (string) Tools::getValue('APPEARANCE_TYPE');

            // check that the value is valid
            if (empty($summary_title) || !Validate::isGenericName($summary_title) || empty($no_items_text) || empty($cart_btn_lbl)) {
                // invalid value, show an error
                $output = $this->displayError($this->l('Invalid Configuration value'));
            } else {
                // value is ok, update it and display a confirmation message
                Configuration::updateValue('PC_SUMMARY_TITLE', $summary_title);
                Configuration::updateValue('PC_NO_ITEMS_TEXT', $no_items_text);
                Configuration::updateValue('PC_CART_BUTTON_LABEL', $cart_btn_lbl);
                Configuration::updateValue('APPEARANCE_TYPE', $appearance);
                $output = $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output . $this->displayForm();
    }

    public function displayForm()
    {
        $options = [
            [
                'id' => 'glassy',
                'name' => $this->l('Glassy Effect'),
            ],
            [
                'id' => 'light',
                'name' => $this->l('Light'),
            ],
        ];
        $form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Settings'),
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Summary Title'),
                        'name' => 'PC_SUMMARY_TITLE',
                        'size' => 30,
                        'required' => true,
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('No Items Message'),
                        'name' => 'PC_NO_ITEMS_TEXT',
                        'size' => 30,
                        'required' => true,
                        'desc' => $this->l('Text to display when there is no cart items yet'),
                    ],
                    [
                        'type' => 'text',
                        'label' => $this->l('Proceed to Checkout Label'),
                        'name' => 'PC_CART_BUTTON_LABEL',
                        'size' => 30,
                        'required' => true,
                    ],
                    [
                        'type' => 'select',
                        'label' => $this->l('Proceed to Checkout Label'),
                        'name' => 'APPEARANCE_TYPE',
                        'required' => true,
                        'options' => [
                            'query' => $options,
                            'id' => 'id',
                            'name' => 'name',
                        ],
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                ],
            ],
        ];
        $helper = new HelperForm();
        $helper->table = $this->table;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&' . http_build_query(['configure' => $this->name]);
        $helper->submit_action = 'submit' . $this->name;
        $helper->default_form_language = (int) Configuration::get('PS_LANG_DEFAULT');
        $helper->fields_value['PC_SUMMARY_TITLE'] = Tools::getValue('PC_SUMMARY_TITLE', Configuration::get('PC_SUMMARY_TITLE'));
        $helper->fields_value['PC_NO_ITEMS_TEXT'] = Tools::getValue('PC_NO_ITEMS_TEXT', Configuration::get('PC_NO_ITEMS_TEXT'));
        $helper->fields_value['PC_CART_BUTTON_LABEL'] = Tools::getValue('PC_CART_BUTTON_LABEL', Configuration::get('PC_CART_BUTTON_LABEL'));
        $helper->fields_value['APPEARANCE_TYPE'] = Tools::getValue('APPEARANCE_TYPE', Configuration::get('APPEARANCE_TYPE'));

        return $helper->generateForm([$form]);
    }

    public function hookDisplayHeader($params)
    {
        $context = Context::getContext();
        $cart = $context->cart;
        $totalAmount = $cart->getOrderTotal(true, Cart::BOTH);
        $currency = new Currency($cart->id_currency);
        $formattedTotal = Tools::displayPrice($totalAmount, $currency);
        $products = $cart->getProducts();
        foreach ($products as $product_key => $product) {
            $productObject = new Product($product['id_product']);
            $coverImage = $productObject->getCover($productObject->id);
            $imageUrl = $this->context->link->getImageLink($productObject->link_rewrite, $coverImage['id_image']);
            $formattedPrice = Tools::displayPrice($product['price'], $context->currency);
            $removeFromCartUrl = $this->context->link->getPageLink(
                'cart',
                true,
                null,
                [
                    'delete' => 1,
                    'ipa' => $product['id_product_attribute'],
                    'id_product' => $product['id_product'],
                ],
            );
            if ($coverImage) {
                $products[$product_key]['default_image'] = $imageUrl;
            }
            $products[$product_key]['url'] = $productObject->getLink();
            $products[$product_key]['formatted_price'] = $formattedPrice;
            $products[$product_key]['remove_from_cart_url'] = $removeFromCartUrl;
        }
        $this->context->smarty->assign([
            'summary_title' => Configuration::get('PC_SUMMARY_TITLE'),
            'no_cart_item_text' => Configuration::get('PC_NO_ITEMS_TEXT'),
            'cart_btn_lbl' => Configuration::get('PC_CART_BUTTON_LABEL'),
            'appearance' => Configuration::get('APPEARANCE_TYPE'),
            'cart_items' => $products,
            'cart_total_items' => $cart->nbProducts(),
            'cart_total' => $formattedTotal,
        ]);

        return $this->display(__FILE__, 'pcbottomcart.tpl');
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'mymodule-style',
            'modules/' . $this->name . '/views/css/pcbottomcart.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );
        $this->context->controller->registerJavascript(
            'mymodule-javascript',
            'modules/' . $this->name . '/views/js/pcbottomcart.js',
            [
                'position' => 'bottom',
                'priority' => 1000,
            ]
        );
    }
}
