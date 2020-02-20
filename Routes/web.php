<?php

Route::prefix('companyalleanza')->group(function() {
    Route::get('/', 'CompanyAlleanzaController@index');

    Route::get('excel/orders/alleanza', 'ExportController@excelOrders')->name('exports.excel.orders.alleanza');
});
