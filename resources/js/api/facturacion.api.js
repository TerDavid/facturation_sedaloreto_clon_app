import axios from "axios";
import dayjs from 'dayjs'
export function index() {
  return axios.get('/api/facturacion/emitir').then(response => {
    return response.data;
  }).catch(error => {
    return error;
  });
}

export function getInformacionConsumoCliente(cliente) {
  return axios.get(`/api/facturacion/get-informacion-consumo-cliente?cliente=${cliente}`).then(response => {
    return response.data;
  }).catch(error => {
    return error;
  });
}

export function emitir(data) {
  console.log(data.date_of_issue)
  console.log(dayjs(data.date_of_issue))
  let date_of_due = dayjs(data.date_of_issue).add(1, 'day').format('YYYY-MM-DD')
  let time_of_issue = dayjs().format('HH:mm:ss')


  let items = data.items.map(item => {

    let base =
    {
      "item_id": 3,
      "item": {
        "id": 3,
        "description": "KG MANZANA ROYAL",
        "item_type_id": "01",
        "internal_id": "IF54",
        "item_code": null,
        "item_code_gs1": null,
        "unit_type_id": "NIU",
        "currency_type_id": "PEN",
        "sale_unit_price": "10.0000",
        "purchase_unit_price": "0.0000",
        "icbper": 0,
        "included_igv": 1,
        "has_isc": 0,
        "amount_plastic_bag_taxes": "0.50",
        "system_isc_type_id": null,
        "percentage_isc": "0.00",
        "suggested_price": "0.000",
        "sale_affectation_igv_type_id": "20",
        "purchase_affectation_igv_type_id": "20",
        "minimum_sale_unit_price": "0.0000",
        "stock": "-761.680",
        "stock_min": "0.000",
        "attributes": null,
        "created_at": [],
        "updated_at": [],
        "trademark_id": null,
        "item_category_id": null,
        "warehouse_id": null,
        "item_status": 0,
        "proyect_number_concar": null,
        "product_account_number_concar": null,
        "cost_center_code_concar": null,
        "use_additional_information": false,
        "adicionales_disponibles": [],
        "warehouses": [
          {
            "id": 3,
            "item_id": 3,
            "warehouse_id": 1,
            "stock": "-761.6800",
            "created_at": "2020-06-06 13:52:06",
            "updated_at": "2020-07-24 18:45:09",
            "warehouse": {
              "id": 1,
              "establishment_id": 1,
              "description": "Almacén - Oficina Principal",
              "created_at": "2020-06-05 15:55:49",
              "updated_at": "2020-06-05 15:55:49"
            }
          }
        ],
        "use_variations": false,
        "variation_warehouses": [],
        "use_subitems": false,
        "price_list": [],
        "item_price_list": [],
        "unit_price": "10.0000",
        "unit_value": "10.0000"
      },
      "currency_type_id": "PEN",
      "quantity": 1,
      "unit_value": 10,
      "affectation_igv_type_id": "20",
      "affectation_igv_type": {
        "id": "20",
        "active": 1,
        "exportation": 0,
        "free": 0,
        "description": "Exonerado - Operación Onerosa"
      },
      "total_base_igv": 10,
      "percentage_igv": 18,
      "total_igv": 0,
      "system_isc_type_id": null,
      "total_base_isc": 0,
      "percentage_isc": 0,
      "total_isc": 0,
      "total_base_other_taxes": 0,
      "percentage_other_taxes": 0,
      "total_other_taxes": 0,
      "total_taxes": 0,
      "price_type_id": "01",
      "unit_price": 10,
      "total_value": 10,
      "total_discount": 0,
      "total_charge": 0,
      "total": 10,
      "attributes": [],
      "charges": [],
      "discounts": [],
      "item_informacion": "",
      "total_plastic_bag_taxes": 0,
      "selected_price_list_item": null,
      "adicionales_seleccionados": [],
      "variation_stock": [],
      "has_plastic_bag_taxes": false
    }

    return {
      "item_id": item.item_id,
      "item": {
        "id": item.item_id,
        "description": item.description,
        "unit_price": item.unit_price,
        "total": item.total
      },
      "description": item.description,
      "quantity": item.quantity,
      "unit_price": item.unit_price,
      "total": item.total
    }
  })


  let payload = {
    "establishment_id": data.establishment_id,
    "document_type_id": data.document_type_id,
    "series_id": data.series_id,
    "number": "#",
    "type": "invoice",
    "date_of_issue": data.date_of_issue,
    "time_of_issue": time_of_issue,
    "customer_id": data.customer_id,
    "currency_type_id": "PEN",
    // "purchase_order": null,
    "exchange_rate_sale": 3.845,
    // "total_prepayment": 0,
    // "total_charge": 0,
    // "total_discount": 0,
    // "total_exportation": 0,
    // "total_free": 0,
    "total_taxed": 0,
    "total_unaffected": 0,
    "total_exonerated": data.total_exonerated,
    "total_igv": 0,
    "total_icbper": 0,
    // "total_base_isc": 0,
    // "total_isc": 0,
    // "total_base_other_taxes": 0,
    // "total_other_taxes": 0,
    "total_taxes": 0,
    "total_value": data.total_value,
    "total": data.total,
    // "additional_information": null,
    // "item_informacion": null,
    "operation_type_id": "0101",
    "date_of_due": null,
    "items": items,
    // "charges": [],
    // "discounts": [],
    // "attributes": [],
    // "guides": [],
    "actions": {
      "format_pdf": "a4"
    },
    "price_list_id": 0,
    // "cuotas": [
    //   {
    //     "description": "",
    //     "amount": "10.00",
    //     // "date_of_due": "2025-06-29"
    //     "date_of_due": date_of_due
    //   }
    // ],
    "operations_campos_items_ids": [],
    "status_paid": "1",
    "is_credit": 0,
    // "external_seller_id": null
  }



  return axios.post('/api/facturacion/emitir', payload).then(response => {
    return response.data;
  }).catch(error => {
    return error;
  });
}

