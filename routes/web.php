<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CreditInvoiceController;
use App\Http\Controllers\HoldCartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PosCartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\PosOrderController;
use App\Http\Controllers\PosPaymentController;
use App\Http\Controllers\PosReceiptController;
use App\Http\Controllers\PosCustomerController;
use App\Http\Controllers\PosOrderItemController;
use App\Http\Controllers\PosSavedOrderController;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use App\Http\Controllers\PosCustomOrderController;
use App\Http\Controllers\PosCustomerTypeController;
use App\Http\Controllers\ReturnsController;
use App\Http\Controllers\PosAdvanceReceiptController;
use App\Http\Controllers\PosCustomOrderItemController;
use App\Http\Controllers\PosHistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TaxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


require __DIR__ . '/auth.php';

Route::get('/', [HomeController::class, "index"])->name('dashboard');

Route::get('/cart', [PosCartController::class, "index"])->name('cart');

Route::prefix('order')->group(function () {
    Route::get('/', [PosCartController::class, "index"])->name('cart.index');
    Route::get('/{order_id}/process', [PosCartController::class, "process"])->name('cart.process');
    Route::post('/update', [PosOrderController::class, "update"])->name('cart.update');
    Route::post('/product-with-name-barcode', [PosCartController::class, "finishGoodByNameBarcode"])->name('product.name.all');
    Route::get('/{product_id}/select', [PosOrderController::class, "selectProduct"])->name('cart.select.product');
    Route::get('/get-order', [PosOrderController::class, "getOrderProduct"])->name('cart.get.products');
    Route::get('/clear-order', [PosOrderController::class, "clearOrder"])->name('cart.clear.order');
    Route::get('/get-subtotal-order', [PosOrderController::class, "getTotals"])->name('cart.getsubtotal.order');
    Route::get('/{product_id}/decrease-qty', [PosOrderController::class, "decreaseQty"])->name('cart.decrease.product');
    Route::get('/{product_id}/increase-qty', [PosOrderController::class, "increaseQty"])->name('cart.increase.product');
    Route::post('/{product_id}/update-qty', [PosOrderController::class, "updateQty"])->name('cart.product.qty');
    Route::get('/{product_id}/remove-item', [PosOrderController::class, "removeItem"])->name('cart.remove.product');
    Route::post('/change-price', [PosOrderController::class, "changeUnitPrice"])->name('cart.update.unit.price');
    Route::get('/{order_id}/remove-select-customer', [PosOrderController::class, "removeCustomerId"])->name('customer.remove');
    Route::post('/discount', [PosOrderController::class, "discount"])->name('cart.discount');
    Route::get('/{order_id}/remove-discount', [PosOrderController::class, "removeDiscount"])->name('remove.discount');
    Route::get('/hold-cart', [PosOrderController::class, "holdCart"])->name('cart.hold');
    Route::post('/payment-done', [PosOrderController::class, "paymentDone"])->name('order.done');
    Route::get('/{payment_id}/print', [PosPaymentController::class,"print"])->name('payment.print');
    Route::get('/{payment_id}/return-print', [PosPaymentController::class,"returnPrint"])->name('return.print');
});

//Hold Cart
Route::prefix('saved-order')->group(function () {
    Route::get('/', [HoldCartController::class, "index"])->name('cart.hold.index');
    Route::get('/all', [HoldCartController::class, "all"])->name('cart.hold.all');
    Route::get('/get', [HoldCartController::class, "edit"])->name('cart.item.edit');
    Route::get('/{order_id}/order/reactive', [HoldCartController::class, "reActive"])->name('cart.order.reactive');
    Route::get('/{order_id}/order/delete', [HoldCartController::class, "deleteOrder"])->name('order.delete');
});

//Categories
Route::prefix('categories')->group(function () {
    Route::get('/all', [CategoryController::class, "all"])->name('categories.all');
    Route::get('/category-all', [CategoryController::class, "categoryAll"])->name('categoryDetails.all');
    Route::post('/category-store', [CategoryController::class, "store"])->name('category.store');
    Route::get('/{category_id}/get-category', [CategoryController::class, "getCategory"])->name('select.category.get');
    Route::get('/{category_id}/get', [CategoryController::class, "get"])->name('category.get');
    Route::post('/{category_id}/update', [CategoryController::class, "update"])->name('category.update');
    Route::delete('/{category_id}/delete', [CategoryController::class, "delete"])->name('category.delete');

    Route::get('/units-all', [CategoryController::class, "unitsAll"])->name('units.all');
    Route::get('/{unit_id}/get-unit', [CategoryController::class, "getUnit"])->name('select.unit.get');
});

//Taxes
Route::prefix('taxes')->group(function () {
    Route::get('/all', [TaxController::class, "all"])->name('tax.all');
    Route::post('/add-order-tax', [TaxController::class, "addTaxes"])->name('add.order.tax');
    Route::get('/show-order-tax', [TaxController::class, "showTaxes"])->name('show.order.tax');
    Route::get('/{tax_id}/remove-order-tax', [TaxController::class, "removeTax"])->name('remove.order.tax');
});

//Products
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, "index"])->name('products.index');
    Route::get('/all', [ProductController::class, "all"])->name('products.all');
    Route::get('/{product_id}/get', [ProductController::class, "get"])->name('product.get');
    Route::get('/{product_id}/get-details', [ProductController::class, "getWithDetails"])->name('product.get.details');
    Route::post('/search/product', [ProductController::class, 'search'])->name('product.search');
    Route::get('/all-products', [ProductController::class, "cartAll"])->name('cart.products.all');
    Route::post('/all-store', [ProductController::class, "store"])->name('product.store');
    Route::post('/{product_id}/update', [ProductController::class, "update"])->name('product.update');
    Route::post('/{product_id}/stock-update', [ProductController::class, "stockUpdate"])->name('stock.update');
    Route::delete('/{customer_id}/delete', [ProductController::class, "delete"])->name('product.delete');

    Route::get('/category-store', [ProductController::class, "storeCategory"])->name('products.category');
    Route::get('/{category_id}/category/all', [ProductController::class, "searchByCategory"])->name('products.category.all');
});

//Return cart
Route::prefix('returns')->group(function () {
    Route::get('/', [ReturnsController::class, "index"])->name('return.index');
    Route::get('/return-order-get', [ReturnsController::class, "returnOrder"])->name('return.order');
    Route::get('/{order_id}/process', [ReturnsController::class, "process"])->name('cart.return.process');
    Route::post('/{order_code}/getOrder', [ReturnsController::class, "getOrder"])->name('get.order');
    Route::post('/{order_code}/get', [ReturnsController::class, "get"])->name('get.order.products');
    Route::post('/bill', [ReturnsController::class, "returnBill"])->name('cart.return.bill');

    Route::post('/return-customer', [ReturnsController::class, "setCustomer"])->name('return.customer');
    Route::get('/{order_id}/remove-return-customer', [ReturnsController::class, "removeCustomerId"])->name('return.customer.remove');
    Route::post('/add/return-items/', [ReturnsController::class, "addItems"])->name('return.item.store');
    Route::get('/get-returns', [ReturnsController::class, "getReturnProduct"])->name('return.get.products');
    Route::delete('/{id}/delete-item', [ReturnsController::class, "deleteItem"])->name('return.delete.product');
    Route::get('/get-return-total', [ReturnsController::class, "getTotals"])->name('return.get.total');
    Route::post('/return-done', [ReturnsController::class, "returnDone"])->name('return.done');
});

//Credit Invoice
Route::prefix('credit-invoice')->group(function () {
    Route::get('/', [CreditInvoiceController::class, "index"])->name('credit.index');
});

//Customer
Route::prefix('customer')->group(function () {
    Route::get('/', [PosCustomerController::class, "index"])->name('customer.index');
    Route::post('/store', [PosCustomerController::class, "store"])->name('customer.store');
    Route::post('/all-store', [PosCustomerController::class, "allStore"])->name('customer.all.store');
    Route::post('/{customer_id}/update', [PosCustomerController::class, "update"])->name('customer.update');
    Route::delete('/{customer_id}/delete', [PosCustomerController::class, "delete"])->name('customer.delete');
    Route::get('/all', [PosCustomerController::class, "all"])->name('customer.all');
    Route::get('/{customer_id}/get', [PosCustomerController::class, "get"])->name('customer.get');
    Route::get('/{contact}/get-by-phone-number', [PosCustomerController::class, "getByNumber"])->name('customer.number.get');
});

//User
Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, "index"])->name('user.index');
    Route::get('/all', [UserController::class, "all"])->name('user.all');
    Route::post('/store', [UserController::class, "store"])->name('user.store');
    Route::get('/{user_id}/get', [UserController::class, "get"])->name('user.get');
    Route::get('/{user_id}/edit', [UserController::class, "edit"])->name('user.edit');
    Route::post('/{user_id}/update', [UserController::class, "update"])->name('user.update');
    Route::delete('/{user_id}/delete', [UserController::class, "delete"])->name('user.delete');
    Route::get('/{user_id}/restore', [UserController::class, "restore"])->name('user.restore');
});

//Configuration
Route::prefix('configuration')->group(function () {
    Route::get('/', [ConfigurationController::class, "index"])->name('configuration.index');
    Route::get('/get', [ConfigurationController::class, "get"])->name('configuration.get');
    Route::post('/store', [ConfigurationController::class, "store"])->name('configuration.store');
    Route::post('/{id}/update', [ConfigurationController::class, "update"])->name('configuration.update');
    Route::delete('/{id}/delete', [ConfigurationController::class, "delete"])->name('configuration.delete');
    Route::get('/{id}/remove-logo', [ConfigurationController::class, "removeLogo"])->name('configuration.logo.remove');
});

//Receipts / Bills
Route::prefix('receipt')->group(function () {
    Route::get('/view', [PosReceiptController::class, "index"])->name('receipt.index');
    Route::get('/credit', [PosReceiptController::class, "credit"])->name('receipt.credit');
    Route::get('/all', [PosReceiptController::class, "all"])->name('cart.bill.all');

    Route::get('/credit-orders-all', [PosReceiptController::class, "creditAll"])->name('credit.order.all');
    Route::get('/{order_id}/credit-bills-all', [PosReceiptController::class, "bills"])->name('credit.bill.all');
    Route::post('/{order_id}/payment-bill', [PosReceiptController::class, "creditPay"])->name('payment.credit.bill');
    Route::get('/{order_id}/edit', [PosReceiptController::class, 'edit'])->name('credit.edit');
    // Route::get('/notComplete/view', [PosReceiptController::class, 'notCompleteView'])->name('notComplete.view');
    // Route::get('/notComplete/all', [PosReceiptController::class, 'notCompleteAll'])->name('notComplete.all');
});

// Stock
Route::prefix('stock')->group(function () {
    Route::get('/', [StockController::class, "index"])->name('stock.index');
    Route::get('/all', [StockController::class, "all"])->name('stocks.all');
    Route::get('/{product_id}/get', [StockController::class, "get"])->name('stock.get');
    // Route::post('/{product_id}/update', [StockController::class, "update"])->name('product.update');
    Route::post('/export/stock/excel', [StockController::class, "stockExport"])->name('product.stock.export');
});

//Advanced Receipts

Route::prefix('advance-receipt')->group(function () {
    Route::get('/', [PosAdvanceReceiptController::class, "index"])->name('advanceReceipt.index');
    Route::post('/{order_id}/store', [PosAdvanceReceiptController::class, "store"])->name('advanceReceipt.store');
    Route::get('/all', [PosAdvanceReceiptController::class, "all"])->name('advanceReceipt.all');
    Route::delete('/{receipt_id}/delete', [PosAdvanceReceiptController::class, "delete"])->name('advanceReceipt.delete');
    Route::get('/{receipt_id}/edit', [PosAdvanceReceiptController::class, "edit"])->name('advanceReceipt.edit');
    Route::get('/{receipt_id}/get', [PosAdvanceReceiptController::class, "get"])->name('advanceReceipt.get');
    Route::post('/{receipt_id}/update', [PosAdvanceReceiptController::class, "update"])->name('advanceReceipt.update');
    Route::get('/{order_id}/print', [PosAdvanceReceiptController::class, "print"])->name('advanceReceipt.print');
    Route::post('/{order_id}/print', [PosAdvanceReceiptController::class, "printPaymentWise"])->name('advanceReceipt.print.payment-wise');
    Route::get('/{receipt_id}/list', [PosAdvanceReceiptController::class, "list"])->name('advanceReceipt.list');
});

// Order Items

Route::prefix('order-item')->group(function () {
    Route::post('/{order_id}/store', [PosCustomOrderItemController::class, "store"])->name('customOrderItem.store');
    Route::get('/{order_id}/all', [PosCustomOrderItemController::class, "all"])->name('customOrderItem.all');
    Route::delete('/{custom_order_item_id}/delete', [PosCustomOrderItemController::class, "delete"])->name('customOrderItem.delete');
    Route::get('/{custom_order_item_id}/edit', [PosCustomOrderItemController::class, "edit"])->name('customOrderItem.edit');
    Route::get('/{custom_order_item_id}/get', [PosCustomOrderItemController::class, "get"])->name('customOrderItem.get');
    Route::post('/{custom_order_item_id}/update', [PosCustomOrderItemController::class, "update"])->name('customOrderItem.update');

    Route::get('/{order_id}/approve', [PosCustomOrderController::class, "approve"])->name('customOrder.approve');
    Route::get('/{order_id}/reject', [PosCustomOrderController::class, "reject"])->name('customOrder.reject');
    Route::post('/{order_id}/reverse', [PosCustomOrderController::class, "reverse"])->name('customOrder.reverse');
});

// Order Facade

Route::get('/test', function () {
    $response['order'] = PosOrderFacade::get(2);
    // $pdf = PDF::loadView('print.pages.payment', $response)->setPaper([0, 0, 300, 700], 'portrait');
    // return $pdf->stream("Payment.pdf", array("Attachment" => false));
});

Route::prefix('permission')->group(function () {
    Route::get('/role/all', [PermissionController::class, "roles"])->name('role.all');
    Route::get('/group/all', [PermissionController::class, "groups"])->name('permission.group.all');
    Route::get('/list/all', [PermissionController::class, "allList"])->name('permission.list.all');
    Route::get('/{role_id}/role/all', [PermissionController::class, "rolePermissionsList"])->name('permission.role.all');
    Route::post('/{role_id}/update/role/permissions', [PermissionController::class, "updatePermissions"])->name('permission.role.update');
    Route::post('/print/permissions', [PermissionController::class, "print"])->name('permission.print');
});

Route::prefix('role')->group(function () {
    Route::get('/', [RoleController::class, "index"])->name('role.index');
    Route::get('/{role_id}/edit', [RoleController::class, "edit"])->name('role.edit');
    Route::get('/{role_id}/get', [RoleController::class, "get"])->name('role.get');
});
