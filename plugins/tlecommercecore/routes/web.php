<?php

use Illuminate\Support\Facades\Route;
use Plugin\TlcommerceCore\Http\Controllers\TaxController;
use Plugin\TlcommerceCore\Http\Controllers\UnitController;
use Plugin\TlcommerceCore\Http\Controllers\BrandController;
use Plugin\TlcommerceCore\Http\Controllers\ColorController;
use Plugin\TlcommerceCore\Http\Controllers\OrderController;
use Plugin\TlcommerceCore\Http\Controllers\ReportController;
use Plugin\TlcommerceCore\Http\Controllers\ProductController;
use Plugin\TlcommerceCore\Http\Controllers\CategoryController;
use Plugin\TlcommerceCore\Http\Controllers\CurrencyController;
use Plugin\TlcommerceCore\Http\Controllers\CustomerController;
use Plugin\TlcommerceCore\Http\Controllers\LocationController;
use Plugin\TlcommerceCore\Http\Controllers\SettingsController;
use Plugin\TlcommerceCore\Http\Controllers\ShippingController;
use \Plugin\TlcommerceCore\Http\Controllers\MarketingController;
use Plugin\TlcommerceCore\Http\Controllers\ProductTagsController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\PaddleController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\PaypalController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\StripeController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\PaymentController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\PaystackController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\RazorpayController;
use Plugin\TlcommerceCore\Http\Controllers\ProductAttributeController;
use Plugin\TlcommerceCore\Http\Controllers\ProductConditionController;
use Plugin\TlcommerceCore\Http\Controllers\ProductCollectionController;
use Plugin\TlcommerceCore\Http\Controllers\Payment\SSLCommerzController;

Route::group(['middleware' => 'auth', 'prefix' => getAdminPrefix()], function () {

    //product category module
    Route::middleware(['can:Manage Categories'])->group(function () {
        Route::get('/product-categories', [CategoryController::class, 'categories'])->name('plugin.tlcommercecore.product.category.list');
        Route::get('/new-category', [CategoryController::class, 'newCategory'])->name('plugin.tlcommercecore.product.category.new');
        Route::post('/new-category-store', [CategoryController::class, 'newCategoryStore'])->name('plugin.tlcommercecore.product.category.new.store');
        Route::get('/edit-category/{id}', [CategoryController::class, 'editCategory'])->name('plugin.tlcommercecore.product.category.edit');
        Route::post('/category-update', [CategoryController::class, 'updateCategory'])->name('plugin.tlcommercecore.product.category.update');
        Route::post('/category-delete', [CategoryController::class, 'deleteCategory'])->name('plugin.tlcommercecore.product.category.delete');
        Route::post('/category-bulk--delete', [CategoryController::class, 'deleteBulkCategory'])->name('plugin.tlcommercecore.product.category.delete.bulk');
        Route::post('/category-change-status', [CategoryController::class, 'categoryChangeStatus'])->name('plugin.tlcommercecore.product.category.status.change');
        Route::post('/category-change-featured-status', [CategoryController::class, 'changeCategoryFeaturedStatus'])->name('plugin.tlcommercecore.product.category.featured.change');
    });

    //Product brand module
    Route::middleware(['can:Manage Brands'])->group(function () {
        Route::get('/product-brands', [BrandController::class, 'productBrands'])->name('plugin.tlcommercecore.product.brand.list');
        Route::view('/new-product-brand', 'plugin/tlecommercecore::products.brands.new_brand')->name('plugin.tlcommercecore.product.brand.new');
        Route::post('/store-new-product-brand', [BrandController::class, 'storeNewProductBrand'])->name('plugin.tlcommercecore.product.brand.store');
        Route::get('/edit-brand/{id}', [BrandController::class, 'editBrand'])->name('plugin.tlcommercecore.product.brand.edit');
        Route::post('/update-product-brand', [BrandController::class, 'updateProductBrand'])->name('plugin.tlcommercecore.product.brand.update');
        Route::post('/delete-product-brand', [BrandController::class, 'deleteProductBrand'])->name('plugin.tlcommercecore.product.brand.delete');
        Route::post('/delete-bulk-product-brand', [BrandController::class, 'deleteBulkProductBrand'])->name('plugin.tlcommercecore.product.brand.delete.bulk');
        Route::post('/change-product-brand-status', [BrandController::class, 'changeProductBrandStatus'])->name('plugin.tlcommercecore.product.brand.status.change');
        Route::post('/change-product-brand-featured-status', [BrandController::class, 'changeProductBrandFeatured'])->name('plugin.tlcommercecore.product.brand.featured.status.change');
    });

    //color module
    Route::middleware(['can:Manage Colors'])->group(function () {
        Route::view('/new-product-color', 'plugin/tlecommercecore::products.colors.create_new')->name('plugin.tlcommercecore.product.colors.new');
        Route::get('/product-colors', [ColorController::class, 'colors'])->name('plugin.tlcommercecore.product.colors.list');
        Route::post('/store-new-product-colors', [ColorController::class, 'storeColor'])->name('plugin.tlcommercecore.product.colors.store');
        Route::post('/delete-product-color', [ColorController::class, 'deleteColor'])->name('plugin.tlcommercecore.product.colors.delete');
        Route::get('/product-color-edit/{id}', [ColorController::class, 'editColor'])->name('plugin.tlcommercecore.product.colors.edit');
        Route::post('/update-product-color', [ColorController::class, 'updateColor'])->name('plugin.tlcommercecore.product.colors.update');
        Route::post('/delete-bulk-product-color', [ColorController::class, 'deleteBulkColor'])->name('plugin.tlcommercecore.product.colors.delete.bulk');
    });

    //product unit module
    Route::middleware(['can:Manage Units'])->group(function () {
        Route::get('/product-units', [UnitController::class, 'units'])->name('plugin.tlcommercecore.product.units.list');
        Route::view('/new-product-unit', 'plugin/tlecommercecore::products.units.add_new')->name('plugin.tlcommercecore.product.units.new');
        Route::post('/product-unit-store', [UnitController::class, 'storeUnit'])->name('plugin.tlcommercecore.product.units.store');
        Route::post('/product-unit-delete', [UnitController::class, 'deleteUnit'])->name('plugin.tlcommercecore.product.units.delete');
        Route::post('/product-unit-bulk-delete', [UnitController::class, 'deleteBulkUnit'])->name('plugin.tlcommercecore.product.units.delete.bulk');
        Route::get('/edit-product-unit/{id}', [UnitController::class, 'editUnit'])->name('plugin.tlcommercecore.product.units.edit');
        Route::post('/product-unit-update', [UnitController::class, 'updateUnit'])->name('plugin.tlcommercecore.product.units.update');
    });

    //product condition
    Route::middleware(['can:Manage Product Conditions'])->group(function () {
        Route::get('/product-conditions', [ProductConditionController::class, 'conditions'])->name('plugin.tlcommercecore.product.conditions.list');
        Route::view('/new-product-condition', 'plugin/tlecommercecore::products.conditions.new_condition')->name('plugin.tlcommercecore.product.conditions.new');
        Route::post('/store-product-condition', [ProductConditionController::class, 'storeCondition'])->name('plugin.tlcommercecore.product.conditions.store');
        Route::post('/change-product-condition-status', [ProductConditionController::class, 'changeConditionStatus'])->name('plugin.tlcommercecore.product.conditions.status.change');
        Route::post('/product-condition-delete', [ProductConditionController::class, 'deleteCondition'])->name('plugin.tlcommercecore.product.conditions.delete');
        Route::post('/product-condition-bulk-delete', [ProductConditionController::class, 'deleteBulkCondition'])->name('plugin.tlcommercecore.product.conditions.delete.bulk');
        Route::get('/product-condition-edit/{id}', [ProductConditionController::class, 'editCondition'])->name('plugin.tlcommercecore.product.conditions.edit');
        Route::post('/product-condition-update', [ProductConditionController::class, 'updateCondition'])->name('plugin.tlcommercecore.product.conditions.update');
    });

    //Product tags module
    Route::middleware(['can:Manage Product Tags'])->group(function () {
        Route::get('/product-tags', [ProductTagsController::class, 'productTags'])->name('plugin.tlcommercecore.product.tags.list');
        Route::view('/add-new-tag', 'plugin/tlecommercecore::products.tags.create_new')->name('plugin.tlcommercecore.product.tags.add.new');
        Route::post('/store-new-product-tag', [ProductTagsController::class, 'storeTag'])->name('plugin.tlcommercecore.product.tags.store');
        Route::post('/delete-product-tag', [ProductTagsController::class, 'deleteTag'])->name('plugin.tlcommercecore.product.tags.delete');
        Route::post('/delete-bulk-product-tag', [ProductTagsController::class, 'deleteBulkTag'])->name('plugin.tlcommercecore.product.tags.delete.bulk');
        Route::post('/change-status-product-tag', [ProductTagsController::class, 'changeStatus'])->name('plugin.tlcommercecore.product.tags.status.change');
        Route::get('/edit-product-tag/{id}', [ProductTagsController::class, 'editTag'])->name('plugin.tlcommercecore.product.tags.edit');
        Route::post('/update-product-tag', [ProductTagsController::class, 'updateTag'])->name('plugin.tlcommercecore.product.tags.update');
    });


    //Product Attribute module
    Route::middleware(['can:Manage Attributes'])->group(function () {
        Route::get('/product-attributes', [ProductAttributeController::class, 'productAttributes'])->name('plugin.tlcommercecore.product.attributes.list');
        Route::view('/add-new-product-attribute', 'plugin/tlecommercecore::products.attributes.new_attribute')->name('plugin.tlcommercecore.product.attributes.add');
        Route::post('/store-product-attribute', [ProductAttributeController::class, 'storeAttribute'])->name('plugin.tlcommercecore.product.attributes.store');
        Route::get('/edit-product-attribute/{id}', [ProductAttributeController::class, 'editAttribute'])->name('plugin.tlcommercecore.product.attributes.edit');
        Route::post('/update-product-attribute', [ProductAttributeController::class, 'updateAttribute'])->name('plugin.tlcommercecore.product.attributes.update');
        Route::post('/delete-product-attribute', [ProductAttributeController::class, 'deleteAttribute'])->name('plugin.tlcommercecore.product.attributes.delete');
        Route::post('/delete-bulk-product-attribute', [ProductAttributeController::class, 'deleteBulkAttribute'])->name('plugin.tlcommercecore.product.attributes.delete.bulk');
        Route::get('/product-attribute-values/{id}', [ProductAttributeController::class, 'attributeValues'])->name('plugin.tlcommercecore.product.attributes.values');
        Route::post('/product-attribute-values-store', [ProductAttributeController::class, 'attributeValuesStore'])->name('plugin.tlcommercecore.product.attributes.values.store');
        Route::post('/product-attribute-values-delete', [ProductAttributeController::class, 'attributeValueDelete'])->name('plugin.tlcommercecore.product.attributes.values.delete');
        Route::get('/product-attribute-value-edit/{id}', [ProductAttributeController::class, 'attributeValueEdit'])->name('plugin.tlcommercecore.product.attributes.values.edit');
        Route::post('/product-attribute-value-update', [ProductAttributeController::class, 'attributeValueUpdate'])->name('plugin.tlcommercecore.product.attributes.values.update');
        Route::post('/product-attribute-status-change', [ProductAttributeController::class, 'attributeStatusChange'])->name('plugin.tlcommercecore.product.attributes.status.change');
        Route::post('/product-attribute-value-status-change', [ProductAttributeController::class, 'attributeValueStatusChange'])->name('plugin.tlcommercecore.product.attributes.value.status.change');
    });

    //Product list
    Route::get('/product-dropdown-options', [ProductController::class, 'productDropdownOptions'])->name('plugin.tlcommercecore.product.dropdown.options');
    Route::middleware(['can:Manage All Products'])->group(function () {
        Route::get('/products', [ProductController::class, 'productList'])->name('plugin.tlcommercecore.product.list');
        Route::post('/product-bulk-action', [ProductController::class, 'productBulkAction'])->name('plugin.tlcommercecore.product.bulk.action');
        Route::post('/update-product-status', [ProductController::class, 'updateProductStatus'])->name('plugin.tlcommercecore.product.status.update');
        Route::post('/update-product-featured-status', [ProductController::class, 'updateProductFeaturedStatus'])->name('plugin.tlcommercecore.product.status.featured.update');
        Route::post('/delete-product', [ProductController::class, 'deleteProduct'])->name('plugin.tlcommercecore.product.delete');
        Route::post('/view-product-quick-action-modal', [ProductController::class, 'viewProductQuickActionForm'])->name('plugin.tlcommercecore.product.quick.action.modal.view');
        Route::post('/product-quick-discount-update', [ProductController::class, 'updateProductDiscount'])->name('plugin.tlcommercecore.product.quick.update.discount');
        Route::post('/product-quick-price-update', [ProductController::class, 'updateProductPrice'])->name('plugin.tlcommercecore.product.quick.update.price');
        Route::post('/product-quick-stock-update', [ProductController::class, 'updateProductStock'])->name('plugin.tlcommercecore.product.quick.update.stock');
    });

    //Product reviews
    Route::middleware(['can:Manage Product Reviews'])->group(function () {
        Route::get('/product-reviews', [ProductController::class, 'productReviewsList'])->name('plugin.tlcommercecore.product.reviews.list');
        Route::post('/update-product-review-status', [ProductController::class, 'updateProductReviewStatus'])->name('plugin.tlcommercecore.product.reviews.status.change');
        Route::post('/product-review-details', [ProductController::class, 'productReviewDetails'])->name('plugin.tlcommercecore.product.reviews.details');
        Route::post('/product-review-delete', [ProductController::class, 'productReviewdelete'])->name('plugin.tlcommercecore.product.reviews.delete');
    });

    //product form
    Route::middleware(['can:Manage Add New Product'])->group(function () {
        Route::get('/add-new-product', [ProductController::class, 'addNewProduct'])->name('plugin.tlcommercecore.product.add.new');
        Route::post('/store-new-product', [ProductController::class, 'storeNewProduct'])->name('plugin.tlcommercecore.product.store.new');
    });

    Route::middleware(['can:Manage All Products'])->group(function () {
        Route::get('/edit-product/{id}', [ProductController::class, 'editProduct'])->name('plugin.tlcommercecore.product.edit');
        Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('plugin.tlcommercecore.product.update');
    });

    Route::post('/add-product-choice-option', [ProductController::class, 'addProductChoiceOption'])->name('plugin.tlcommercecore.product.form.add.choice.option');
    Route::post('/generate-product-variant-combination', [ProductController::class, 'variantCombination'])->name('plugin.tlcommercecore.product.form.variant.combination');
    Route::post('/load-color-variant-image-input', [ProductController::class, 'colorVariantImageInput'])->name('plugin.tlcommercecore.product.form.color.variant.image.input');
    Route::post('/product-cod-countries-options', [ProductController::class, 'codCountriesOptions'])->name('plugin.tlcommercecore.product.form.cod.countries.options');
    Route::post('/product-cod-states-options', [ProductController::class, 'codStateOptions'])->name('plugin.tlcommercecore.product.form.cod.state.options');
    Route::post('/product-cod-cities-options', [ProductController::class, 'codCitiesOptions'])->name('plugin.tlcommercecore.product.form.cod.cities.options');

    /**
     * 
     * Product collections
     */
    Route::middleware(['can:Manage Product collections'])->group(function () {
        Route::get('/product-collections', [ProductCollectionController::class, 'collections'])->name('plugin.tlcommercecore.product.collection.list');
        Route::get('/add-new-product-collection', [ProductCollectionController::class, 'newCollection'])->name('plugin.tlcommercecore.product.collection.add.new');
        Route::post('/store-new-product-collection', [ProductCollectionController::class, 'storeNewCollection'])->name('plugin.tlcommercecore.product.collection.store.new');
        Route::get('/edit-product-collection/{id}', [ProductCollectionController::class, 'editCollection'])->name('plugin.tlcommercecore.product.collection.edit');
        Route::post('/update-product-collection', [ProductCollectionController::class, 'updateCollection'])->name('plugin.tlcommercecore.product.collection.update');
        Route::post('/delete-product-collection', [ProductCollectionController::class, 'deleteCollection'])->name('plugin.tlcommercecore.product.collection.delete');
        Route::post('/update-product-collection-status', [ProductCollectionController::class, 'updateCollectionStatus'])->name('plugin.tlcommercecore.product.collection.update.status');
        Route::post('/bulk-delete-product-collection', [ProductCollectionController::class, 'deleteBulkCollection'])->name('plugin.tlcommercecore.product.collection.delete.bulk');
        Route::get('/collection-products/{id}', [ProductCollectionController::class, 'collectionProducts'])->name('plugin.tlcommercecore.product.collection.products');
        Route::post('/store-collection-products', [ProductCollectionController::class, 'storeCollectionProducts'])->name('plugin.tlcommercecore.product.collection.products.store');
        Route::post('/remove-collection-product', [ProductCollectionController::class, 'removeCollectionProduct'])->name('plugin.tlcommercecore.product.collection.products.remove');
        Route::post('/bulk-remove-collection-product', [ProductCollectionController::class, 'removeBulkCollectionProduct'])->name('plugin.tlcommercecore.product.collection.products.remove.bulk');
    });

    /**
     * Shipping modules routes
     */
    Route::group(['prefix' => 'shipping'], function () {
        Route::middleware(['can:Manage Shipping & Delivery'])->group(function () {
            //shipping and delivery
            Route::get('/configuration', [ShippingController::class, 'shippingAndDelivery'])->name('plugin.tlcommercecore.shipping.configuration');
            //Shipping time 
            Route::post('/store-new-shipping-time', [ShippingController::class, 'storeShippingTime'])->name('plugin.tlcommercecore.shipping.time.store');
            Route::post('/delete-shipping-time', [ShippingController::class, 'deleteShippingTime'])->name('plugin.tlcommercecore.shipping.time.delete');

            //Shipping Profiles
            Route::get('/create-shipping-profile', [ShippingController::class, 'shippingProfileForm'])->name('plugin.tlcommercecore.shipping.profile.form');
            Route::post('/store-shipping-profile', [ShippingController::class, 'storeShippingProfile'])->name('plugin.tlcommercecore.shipping.profile.store');
            Route::get('/manage-shipping-profile/{id}', [ShippingController::class, 'manageShippingProfile'])->name('plugin.tlcommercecore.shipping.profile.manage');
            Route::post('/update-shipping-profile', [ShippingController::class, 'updateShippingProfile'])->name('plugin.tlcommercecore.shipping.profile.update');
            Route::post('/update-shipping-from-profile', [ShippingController::class, 'updateShippingFrom'])->name('plugin.tlcommercecore.shipping.profile.update.shipping.from');
            Route::post('/update-shipping-product-list', [ShippingController::class, 'updateShippingProductList'])->name('plugin.tlcommercecore.shipping.profile.update.product.list');
            Route::post('/delete-shipping-profile', [ShippingController::class, 'deleteShippingProfile'])->name('plugin.tlcommercecore.shipping.profile.delete');

            //Shipping Zones
            Route::post('/locations-ul-list', [ShippingController::class, 'locationUlList'])->name('plugin.tlcommercecore.shipping.location.ul.list');
            Route::post('/locations-ul-list-edit', [ShippingController::class, 'locationUlListEdt'])->name('plugin.tlcommercecore.shipping.location.ul.list.edit');
            Route::post('/search-locations-ul-list', [ShippingController::class, 'searchLocationUlList'])->name('plugin.tlcommercecore.shipping.search.location.ul.list');
            Route::post('/search-locations-ul-list-edit', [ShippingController::class, 'searchLocationUlListEdit'])->name('plugin.tlcommercecore.shipping.search.location.ul.list.edit');
            Route::post('/locations-searched-ul-list', [ShippingController::class, 'locationSearchedUlList'])->name('plugin.tlcommercecore.shipping.location.searched.list');
            Route::post('/store-shipping-new-zone', [ShippingController::class, 'storeNewShippingZone'])->name('plugin.tlcommercecore.shipping.profile.zones.store');
            Route::post('/edit-shipping-zone', [ShippingController::class, 'editShippingZone'])->name('plugin.tlcommercecore.shipping.profile.zones.edit');
            Route::post('/update-shipping-zone', [ShippingController::class, 'updateShippingZone'])->name('plugin.tlcommercecore.shipping.profile.zones.update');
            Route::post('/delete-shipping-zone', [ShippingController::class, 'deleteZone'])->name('plugin.tlcommercecore.shipping.zones.delete');
            //Shipping Rates
            Route::post('/store-shipping-rate', [ShippingController::class, 'storeShippingRate'])->name('plugin.tlcommercecore.shipping.store.rate');
            Route::post('/edit-shipping-rate', [ShippingController::class, 'editShippingRate'])->name('plugin.tlcommercecore.shipping.rate.edit');
            Route::post('/update-shipping-rate', [ShippingController::class, 'updateShippingRate'])->name('plugin.tlcommercecore.shipping.rate.update');
            Route::post('/delete-shipping-rate', [ShippingController::class, 'deleteShippingRate'])->name('plugin.tlcommercecore.shipping.delete.rate');
            Route::get('/load-carrier-shipping-weight-range', function () {
                return view('plugin/tlecommercecore::shipping.configuration.carrier-shipping-weight-range');
            })->name('plugin.tlcommercecore.shipping.carrier.weight.range.input');
        });



        Route::middleware(['can:Manage Locations'])->group(function () {
            //countries module
            Route::get('/countries', [LocationController::class, 'countries'])->name('plugin.tlcommercecore.shipping.locations.country.list');
            Route::get('/new-country', [LocationController::class, 'newCountry'])->name('plugin.tlcommercecore.shipping.locations.country.new');
            Route::post('/store-new-country', [LocationController::class, 'storeNewCountry'])->name('plugin.tlcommercecore.shipping.locations.country.new.store');
            Route::post('/delete-country', [LocationController::class, 'deleteCountry'])->name('plugin.tlcommercecore.shipping.locations.country.delete');
            Route::post('/country-status-change', [LocationController::class, 'countryStatusChange'])->name('plugin.tlcommercecore.shipping.locations.country.status.change');
            Route::get('/edit-country/{id}', [LocationController::class, 'editCountry'])->name('plugin.tlcommercecore.shipping.locations.country.edit');
            Route::post('/update-country', [LocationController::class, 'updateCountry'])->name('plugin.tlcommercecore.shipping.locations.country.update');

            //states
            Route::get('/states', [LocationController::class, 'states'])->name('plugin.tlcommercecore.shipping.locations.states.list');
            Route::get('/add-new-state', [LocationController::class, 'newState'])->name('plugin.tlcommercecore.shipping.locations.states.new.add');
            Route::post('/add-new-state', [LocationController::class, 'storeState'])->name('plugin.tlcommercecore.shipping.locations.states.new.store');
            Route::post('/delete-state', [LocationController::class, 'deleteState'])->name('plugin.tlcommercecore.shipping.locations.states.delete');
            Route::post('/change-state-status', [LocationController::class, 'changeStateStatus'])->name('plugin.tlcommercecore.shipping.locations.states.status.change');
            Route::get('/edit-state/{id}', [LocationController::class, 'editState'])->name('plugin.tlcommercecore.shipping.locations.states.edit');
            Route::post('/update-state', [LocationController::class, 'updateState'])->name('plugin.tlcommercecore.shipping.locations.states.update');

            //cities
            Route::get('/cities', [LocationController::class, 'cities'])->name('plugin.tlcommercecore.shipping.locations.cities.list');
            Route::get('/add-new-city', [LocationController::class, 'newCity'])->name('plugin.tlcommercecore.shipping.locations.cities.add.new');
            Route::post('/store-new-city', [LocationController::class, 'storeNewCity'])->name('plugin.tlcommercecore.shipping.locations.cities.store.new');
            Route::post('/delete-city', [LocationController::class, 'deleteCity'])->name('plugin.tlcommercecore.shipping.locations.cities.delete');
            Route::post('/change-city-status', [LocationController::class, 'changeCityStatus'])->name('plugin.tlcommercecore.shipping.locations.cities.status.change');
            Route::get('/edit-city/{id}', [LocationController::class, 'editCity'])->name('plugin.tlcommercecore.shipping.locations.cities.edit');
            Route::post('/update-city', [LocationController::class, 'updateCity'])->name('plugin.tlcommercecore.shipping.locations.cities.update');
        });
    });
    /**
     * E commerce settings Module
     */
    Route::group(['prefix' => 'ecommerce-settings'], function () {
        //taxes
        Route::middleware(['can:Manage Taxes'])->group(function () {
            Route::get('/taxes', [TaxController::class, 'taxes'])->name('plugin.tlcommercecore.ecommerce.settings.taxes.list');
            Route::get('/taxes/{id}', [TaxController::class, 'zoneTaxes'])->name('plugin.tlcommercecore.ecommerce.settings.zone.taxes');
            Route::post('/update-zone-base-tax', [TaxController::class, 'updateBaseTax'])->name('plugin.tlcommercecore.ecommerce.update.zone.base.tax');
            Route::post('/store-shipping-zone-tax', [TaxController::class, 'storeZoneTax'])->name('plugin.tlcommercecore.ecommerce.zone.tax.store');
            Route::post('/delete-shipping-zone-tax', [TaxController::class, 'deleteZoneTax'])->name('plugin.tlcommercecore.ecommerce.zone.tax.delete');
            Route::post('/bulk-delete-shipping-zone-tax', [TaxController::class, 'bulkDeleteZoneTax'])->name('plugin.tlcommercecore.ecommerce.zone.tax.delete.bulk');
            Route::post('/update-shipping-zone-tax', [TaxController::class, 'updateZoneTax'])->name('plugin.tlcommercecore.ecommerce.zone.tax.update');
        });

        //Product share option
        Route::middleware(['can:Manage Product Share Options'])->group(function () {
            Route::get('/product-share-options', [ProductController::class, 'shareOptions'])->name('plugin.tlcommercecore.products.share.options');
            Route::post('/product-share-option-update-status', [ProductController::class, 'shareOptionUpdateStatus'])->name('plugin.tlcommercecore.products.share.options.update.status');
        });

        //e-Commerce settings
        Route::middleware(['can:Manage Settings'])->group(function () {
            Route::get('/config', [SettingsController::class, 'ecommerceConfig'])->name('plugin.tlcommercecore.ecommerce.configuration');
            Route::post('/update-ecommerce-settings', [SettingsController::class, 'updateEcommerceSettings'])->name('plugin.tlcommercecore.ecommerce.configuration.update');
        });

        //Currency Settings
        Route::middleware(['can:Manage Currencies'])->group(function () {
            Route::get('/add-currency', [CurrencyController::class, 'addCurrency'])->name('plugin.tlcommercecore.ecommerce.add.currency');
            Route::post('/add-currency', [CurrencyController::class, 'storeCurrency'])->name('plugin.tlcommercecore.ecommerce.store.currency');
            Route::get('/all-currencies', [CurrencyController::class, 'allCurrencies'])->name('plugin.tlcommercecore.ecommerce.all.currencies');
            Route::post('/update-currency-status', [CurrencyController::class, 'updateCurrencyStatus'])->name('plugin.tlcommercecore.ecommerce.update.currency.status');
            Route::get('/edit-currency/{id}', [CurrencyController::class, 'editCurrency'])->name('plugin.tlcommercecore.ecommerce.edit.currency');
            Route::post('/update-currency', [CurrencyController::class, 'updateCurrency'])->name('plugin.tlcommercecore.ecommerce.update.currency');
            Route::post('/delete-currency', [CurrencyController::class, 'deleteCurrency'])->name('plugin.tlcommercecore.ecommerce.currency.delete');
        });
    });
    /**
     * Orders Module
     */
    Route::group(['prefix' => 'orders'], function () {
        Route::middleware(['can:Manage Inhouse Orders'])->group(function () {
            Route::get('/inhouse-orders', [OrderController::class, 'inhouseOrders'])->name('plugin.tlcommercecore.orders.inhouse');
        });
        Route::post('/order-status-details', [OrderController::class, 'orderStatusDetails'])->name('plugin.tlcommercecore.orders.status.details');
        Route::get('/order-details/{id}', [OrderController::class, 'orderDetails'])->name('plugin.tlcommercecore.orders.details')->middleware('can:Manage Order Details');
        Route::post('/update-order-status', [OrderController::class, 'updateOrderStatus'])->name('plugin.tlcommercecore.orders.status.update');
        Route::post('/cancel-order', [OrderController::class, 'cancelOrder'])->name('plugin.tlcommercecore.orders.cancel');
        Route::post('/cancel-order-item', [OrderController::class, 'cancelOrderItem'])->name('plugin.tlcommercecore.orders.item.cancel');
        Route::post('/accept-order', [OrderController::class, 'acceptOrder'])->name('plugin.tlcommercecore.orders.accept');
        Route::post('/order-bulk-action', [OrderController::class, 'orderBulkAction'])->name('plugin.tlcommercecore.orders.bulk.action');
        Route::post('/print-shipping-label', [OrderController::class, 'printShippingLabel'])->name('plugin.tlcommercecore.orders.print.shipping.label');
        Route::post('/print-order-invoice', [OrderController::class, 'printInvoice'])->name('plugin.tlcommercecore.orders.print.invoice');
    });
    /**
     *Payments Module
     */
    Route::group(['prefix' => 'payments'], function () {
        Route::middleware(['can:Manage Payment Methods'])->group(function () {
            Route::get('/payment-methods', [PaymentController::class, 'paymentMethods'])->name('plugin.tlcommercecore.payments.methods');
            Route::post('/change-payment-method-status', [PaymentController::class, 'changePaymentMethodStatus'])->name('plugin.tlcommercecore.payments.methods.status.update');
            Route::post('/update-payment-method-credential', [PaymentController::class, 'updatePaymentMethodCredential'])->name('plugin.tlcommercecore.payments.methods.credential.update');
        });
        Route::middleware(['can:Manage Transaction history'])->group(function () {
            Route::get('/transaction-history', [PaymentController::class, 'transactionHistory'])->name('plugin.tlcommercecore.payments.transactions.history');
        });
    });

    /**
     *customers Module
     */
    Route::middleware(['can:Manage Customers'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'customers'])->name('plugin.tlcommercecore.customers.list');
        Route::post('/change-customer-status', [CustomerController::class, 'changeCustomerStatus'])->name('plugin.tlcommercecore.customers.change.status');
        Route::get('customer-details/{id}', [CustomerController::class, 'customerDetails'])->name('plugin.tlcommercecore.customers.details');
        Route::post('/reset-customer-password', [CustomerController::class, 'resetCustomerPassword'])->name('plugin.tlcommercecore.customers.password.reset');
        Route::post('/update-customer-info', [CustomerController::class, 'updateCustomerInfo'])->name('plugin.tlcommercecore.customers.info.update');
        Route::post('/customer-secret-login', [CustomerController::class, 'customerSecretLogin'])->name('plugin.tlcommercecore.customers.login.secret');
        Route::post('/delete-customer', [CustomerController::class, 'deleteCustomer'])->name('plugin.tlcommercecore.customers.delete');
    });

    /**
     * Reports Routes
     */
    Route::middleware(['can:Manage Product Reports'])->group(function () {
        Route::get('/products-report', [ReportController::class, 'productReport'])->name('plugin.tlcommercecore.reports.products');
    });

    Route::middleware(['can:Manage Wishlist Reports'])->group(function () {
        Route::get('/products-wishlist-report', [ReportController::class, 'productWishlistReport'])->name('plugin.tlcommercecore.reports.products.wishlist');
    });

    Route::middleware(['can:Manage Keyword Search Reports'])->group(function () {
        Route::get('/user-keyword-search', [ReportController::class, 'userKeywordSearch'])->name('plugin.tlcommercecore.reports.search.keyword');
    });

    Route::post('/sales-chart-report', [ReportController::class, 'salesChartReport'])->name('plugin.tlcommercecore.reports.sales.chart');


    /**
     * Marketing Modules
     */
    Route::middleware(['can:Manage Custom notification'])->group(function () {
        Route::get('/custom-notifications', [MarketingController::class, 'customNotifications'])->name('plugin.tlcommercecore.marketing.custom.notification');
        Route::get('/create-new-custom-notifications', [MarketingController::class, 'newCustomNotifications'])->name('plugin.tlcommercecore.marketing.custom.notification.create.new');
        Route::get('/get-customer-options', [MarketingController::class, 'getCustomerOptions'])->name('plugin.tlcommercecore.marketing.custom.notification.customer.options');
        Route::get('/get-users-options', [MarketingController::class, 'getUsersOptions'])->name('plugin.tlcommercecore.marketing.custom.notification.users.options');
        Route::get('/get-user-roles-options', [MarketingController::class, 'getUserRolesOptions'])->name('plugin.tlcommercecore.marketing.custom.notification.user.roles.options');
        Route::post('/send-custom-notification', [MarketingController::class, 'sendCustomNotification'])->name('plugin.tlcommercecore.marketing.custom.notification.send');
        Route::post('/custom-notification-bulk-action', [MarketingController::class, 'customNotificationBulkAction'])->name('plugin.tlcommercecore.marketing.custom.notification.bulk.action');
    });
});

/**
 * Payment page
 */
Route::get('/payment/{id}/pay', [PaymentController::class, 'createPayment']);

/**
 * Stripe payment 
 */
Route::any('/stripe/create-session', [StripeController::class, 'create_checkout_session'])->name('stripe.generate.token');
Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success.payment');
Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel.payment');

/**
 * Paypal payment
 */
Route::get('/paypal/success', [PaypalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PaypalController::class, 'cancel'])->name('paypal.cancel');

/**
 * paddle payment
 */
Route::any('/paddle/success', [PaddleController::class, 'paddleSuccess'])->name('paddle.payment.success');
Route::any('/paddle/return', [PaddleController::class, 'paddleReturn'])->name('paddle.payment.return');

/**
 * SSLCommerz payment 
 */
Route::any('/ssl-commerce/success', [SSLCommerzController::class, 'success'])->name('sslcommerz.success.payment');
Route::any('/ssl-commerce/cancel', [SSLCommerzController::class, 'cancel'])->name('sslcommerz.cancel.payment');
Route::any('/ssl-commerce/fail', [SSLCommerzController::class, 'fail'])->name('sslcommerz.fail.payment');

//Paystack
Route::get('/pay/callback', [PaystackController::class, 'callback'])->name('pay.callback');

//Razorpay
Route::post('/razorpay-payment-submit', [RazorpayController::class, 'paymentStatus'])->name('razorpay.payment.submit');