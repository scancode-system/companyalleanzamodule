<?php 
namespace Modules\CompanyAlleanza\Exports;

use Modules\Order\Repositories\ItemRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ItemsExport implements FromCollection, WithStrictNullComparison
{
    public function collection()
    {
        return new Collection($this->data());
    }


    private function data(){
        //return $this->header();
    	return array_merge($this->header(), $this->body());
    }

    private function header(){
        return [[
            'Cod. Pedido', 
            '', 
            'Data Abertura',
            'Hora Abertura',
            '',
            'Cod. Representante',
            '',
            'Cod. Cliente',
            'Cliente',
            'Cpf/Cnpj',
            '',
            '',
            'Cod. Pagamento',
            '',
            '',
            '',
            '',
            '',
            'Cod. Produto',
            '',
            '',
            '',
            '',
            '',
            '',
            'Quantidade',
            'Perc. Desconto',
            '',
            'Valor unit.',
            '',
            'Perc. IPI',
            'Comissao',
            'Perc. Acrescimo'
        ]];
        /*return [['codigo', 'concluido', 'referencia', 'produto', 'preco', 'quantidade', 'total_bruto', 'desconto_valor', 'acrescimo_Valor', 'total', 'pagamento', 'comprador', 'email', 'telefone', 'representante']];*/
    }


    private function body(){
    	$items = ItemRepository::loadItemsClosedOrders();
    	$body = [];

    	foreach ($items as $item) {
            $order = $item->order;

            array_push($body, [
                $this->order_id($order),

                $this->blank(),
                
                $this->closing_date($order),
                $this->closing_hour($order),
                
                $this->blank(),
                
                $this->saller_id($order),
                
                $this->blank(),
                
                $this->client_id($order),
                $this->client_corporate_name($order),
                $this->client_cpf_cnpj($order),
                
                $this->blank(),
                $this->blank(),

                $this->payment_id($order),

                $this->blank(),
                $this->blank(),
                $this->blank(),
                $this->blank(),
                $this->blank(),

                $this->product_sku($item),

                $this->blank(),
                $this->blank(),
                $this->blank(),
                $this->blank(),
                $this->blank(),
                $this->blank(),

                $this->qty($item),
                $this->discount($item),

                $this->blank(),

                $this->price($item),

                $this->blank(),

                $this->ipi($item),  

                $this->blank(),

                $this->addition($item),

            ]);
        }

        return $body;
    }

    private function blank()
    {
        return '';
    }

    private function order_id($order)
    {
    	return $order->id;
    }

    private function closing_date($order)
    {
        return $order->closing_date->format('d/m/Y H:m');
    }

    private function closing_hour($order)
    {
        return $order->closing_date->format('H:m:i');
    }

    private function saller_id($order)
    {
        return $order->order_saller->saller_id;
    }

    private function client_id($order)
    {
        return $order->order_client->client_id;
    }

    private function client_corporate_name($order)
    {
        return $order->order_client->corporate_name;
    }

    private function client_cpf_cnpj($order)
    {
        return $order->order_client->cpf_cnpj;
    }

    private function payment_id($order)
    {
        return $order->order_payment->payment_id;
    }

    private function product_sku($item)
    {
        return $item->item_product->sku;
    }

    private function qty($item)
    {
        return $item->qty;
    }

    private function discount($item)
    {
        return $item->discount;
    }

    private function price($item)
    {
        return $item->price;
    }

    private function ipi($item)
    {
        $tax_ipi = $item->item_taxes()->where('module', 'ipi')->first();
        if($tax_ipi)
        {
            return $tax_ipi->porcentage;
        }else
        {
            return 0;
        }
    }


    private function addition($item)
    {
        return $item->addition;
    }



}