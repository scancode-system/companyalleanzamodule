<?php 
namespace Modules\Order\Exports;

use Modules\Order\Repositories\ItemRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ItemsFullExport implements FromCollection, WithStrictNullComparison
{
    public function collection()
    {
        return new Collection($this->data());
    }


    private function data(){
        return array_merge($this->header(), $this->body());
    }

    private function header(){
        return [['codigo', 'concluido','referencia', 'produto', 'preco', 'quantidade', 'total_bruto', 'desconto_valor', 'desconto_porcentagem', 'acrescimo_valor', 'acrescimo_porcentagem', 'total', 'observacao', 'cod_pagamento', 'pagmento', 'cod_cliente', 'comprador', 'email_cliente', 'telefone', 'razao_social', 'nome_fantasia', 'cpf_cnpj', 'rua', 'numero', 'bairo', 'cidade', 'estado', 'cep',  'cod_representante', 'representante', 'email_representante', 'cod_transportadora', 'transportadora']];
    }


    private function body(){
        $items = ItemRepository::loadItemsClosedOrders();
        $body = [];

        foreach ($items as $item) {
            $order = $item->order;

            array_push($body, [
                $this->codigo($order),
                $this->concluido($order),

                $this->referencia($item),
                $this->produto($item),
                $this->preco($item),
                $this->quantidade($item),
                $this->total_bruto($item),
                $this->desconto_valor($item),
                $this->desconto_porcentagem($item),
                $this->acrescimo_valor($item),
                $this->acrescimo_porcentagem($item),
                $this->total($item),

                $this->observacao($order),
                $this->cod_pagamento($order),
                $this->pagamento($order),
                $this->cod_cliente($order),
                $this->comprador($order),
                $this->email_cliente($order),
                $this->telefone($order),
                $this->razao_social($order),
                $this->nome_fantasia($order),
                $this->cpf_cnpj($order),
                $this->rua($order),
                $this->numero($order),
                $this->bairro($order),
                $this->cidade($order),
                $this->estado($order),
                $this->cep($order),
                $this->cod_representante($order),
                $this->representante($order),
                $this->email_representante($order),
                $this->cod_transportadora($order),
                $this->transportadora($order),
            ]);
        }

        return $body;
    }

    private function codigo($order){
        return $order->id;
    }

    private function concluido($order){
        return $order->closing_date;
    }

    private function referencia($item){
        return $item->item_product->sku;
    }

    private function produto($item){
        return $item->item_product->description;
    }

    private function preco($item){
        return $item->price;
    }

    private function quantidade($item){
        return $item->qty;
    }

    private function total_bruto($item){
        return $item->total_gross;
    }

    private function desconto_valor($item){
        return $item->total_discount_value;
    }

        private function desconto_porcentagem($item){
        return $item->discount;
    }

    private function acrescimo_valor($item){
        return $item->total_addittion_value;
    }

    private function acrescimo_porcentagem($item){
        return $item->addittion;
    }

    private function total($item){
        return $item->total;
    }


    private function observacao($order){
        return $order->observation;
    }

    private function cod_pagamento($order){
        return $order->order_payment->payment_id;
    }

    private function pagamento($order){
        return $order->order_payment->description;
    }

    private function cod_cliente($order){
        return $order->order_client->client_id;
    }

    private function comprador($order){
        return $order->order_client->buyer;
    }

    private function email_cliente($order){
        return $order->order_client->email;
    }

    private function telefone($order){
        return $order->order_client->phone;
    }

    private function razao_social($order){
        return $order->order_client->corporate_name;
    }

    private function nome_fantasia($order){
        return $order->order_client->fantasy_name;
    }

    private function cpf_cnpj($order){
        return $order->order_client->cpf_cnpj;
    }

    private function rua($order){
        return $order->order_client->order_client_address->street;
    }

    private function numero($order){
        return $order->order_client->order_client_address->number;
    }

    private function bairro($order){
        return $order->order_client->order_client_address->neighborhood;
    }

    private function cidade($order){
        return $order->order_client->order_client_address->city;
    }

    private function estado($order){
        return $order->order_client->order_client_address->st;
    }

    private function cep($order){
        return $order->order_client->order_client_address->postcode;
    }

    private function cod_representante($order){
        return $order->order_saller->saller_id;
    }

    private function representante($order){
        return $order->order_saller->name;
    }

    private function email_representante($order){
        return $order->order_saller->email;
    }


    private function cod_transportadora($order){
        return $order->order_shipping_company->shipping_company_id;
    }

    private function transportadora($order){
        return $order->order_shipping_company->description;
    }

}