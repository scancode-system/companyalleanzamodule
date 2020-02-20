<?php

namespace Modules\CompanyAlleanza\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\CompanyAlleanza\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function excelOrders(){
        return Excel::download(new ItemsExport, 'Exportação de Items.xlsx');
    }


}