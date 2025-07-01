import { emitir, getInformacionConsumoCliente, index } from "../api/facturacion.api";
import { searchCliente } from "../api/clientes.api";

Alpine.data('searchClient', () => ({
    searchQuery: '',
    searchResults: [],
    selectedClient: null,

    searchClients() {
        if (this.searchQuery.length > 2) {
            searchCliente(this.searchQuery).then(response => {
                this.searchResults = response.data || response || []
            }).catch(error => {
                console.error('Error searching clients:', error)
                this.searchResults = []
            })
        } else {
            this.searchResults = []
        }
    },

    init() {
        // Initialize with empty results
        this.searchResults = []
    },

    selectClient(client) {
        this.selectedClient = client

        // Update the form fields
        const clienteInput = document.getElementById('cliente')
        const clienteNameInput = document.getElementById('cliente_name')

        if (clienteInput) clienteInput.value = client.id
        if (clienteNameInput) clienteNameInput.value = `${client.dni} - ${client.nombre} ${client.apellido}`
        getInformacionConsumoCliente(client.id).then(response => {
            console.log(response, response.cliente.consumos)
            // Update documentsEmit data through $store reference
            this.$store.documentsEmitConsumo.resultConsumo = {
                consumos: response.cliente.consumos,
                tarifa: response.cliente.tarifa
            }
        }).catch(error => {
            console.error('Error loading client consumption data:', error)
            this.$store.toast.error('Error al cargar los datos del cliente')
        })
        // Close the modal
        this.close()
    },

    close() {
        // Dispatch close event to close the modal
        this.$dispatch('close-modal')
    }
}))

// console.log('asdsad', Alpine)
// document.addEventListener('alpine:init', () => {
//    Alpine.data('documentsEmit', {
//     async init() {
//         console.log('asdasd122')
//     }
//    })
// })
console.log('asdasd')
// window.documentsEmit = () => {
//     return {
//         values: [],

//         async init() {
//             console.log('asdasd122')
//         }
//     }
// }

Alpine.store('documentsEmitConsumo', {
    resultConsumo: {
        consumos: [],
        tarifa: null,
    },
})

Alpine.data('documentsEmit', () => ({
    establecimientos: [],
    series: [],
    tipo_comprobante: [],
    selectedTipoComprobante: null,
    unit_type: [],
    resultConsumo: {
        consumos: [],
        tarifa: null,
    },

    get filteredSeries() {
        if (!this.selectedTipoComprobante) return [];
        return this.series.filter(
            s => s.document_type_id == this.selectedTipoComprobante
        );
    },

    init() {
        this.selectedTipoComprobante = null;
        index().then(response => {
            if (response.establecimiento) {
                this.establecimientos = [response.establecimiento];
            }
            if (response.series) {
                this.series = Array.isArray(response.series)
                    ? response.series
                    : [response.series];
            }
            if (response.tipo_comprobante) {
                this.tipo_comprobante = Array.isArray(response.tipo_comprobante)
                    ? response.tipo_comprobante
                    : [response.tipo_comprobante];
            }
            if (response.unit_type) {
                this.unit_type = Array.isArray(response.unit_type)
                    ? response.unit_type
                    : [response.unit_type];
            }
            // Selecciona el primer tipo de comprobante por defecto si existe
            if (this.tipo_comprobante.length > 0) {
                this.selectedTipoComprobante = this.tipo_comprobante[0].id;
            }
        }).catch(error => {
            console.error('Error loading document data:', error);
            this.$store.toast.error('Error al cargar los datos del documento');
        });
    },
    onClickGenerar() {
        console.log('onClickGenerar')
        console.log(this.$store.documentsEmitConsumo.resultConsumo)

        const form = document.getElementById('form-emitir')

        // Validaciones
        if (!this.$store.documentsEmitConsumo.resultConsumo.consumos.length) {
            this.$store.toast.error('Debe seleccionar un cliente con consumos');
            return;
        }

        if (form.elements.valor_recibido.value == 0) {
            this.$store.toast.error('El valor recibido no puede ser 0', { title: 'Error!' });
            return;
        }

        if (form.elements.cliente.value == '') {
            this.$store.toast.error('Debe seleccionar un cliente');
            return;
        }

        // Mostrar toast de éxito antes de enviar
        this.$store.toast.success('Generando comprobante...', { duration: 2000 });
        let _total_base = this.$store.documentsEmitConsumo.resultConsumo.consumos.reduce((sum, consumo) => sum + parseFloat(consumo.valor), 0).toFixed(2);
        let _total_recibido = form.elements.valor_recibido.value;
        if (_total_recibido != _total_base) {
            this.$store.toast.error('El valor recibido no puede ser diferente al total base');
            return;
        }
        // let _total_igv = (_total_base * 0.18).toFixed(2);
        // let _total_value = (_total_base + _total_igv).toFixed(2);
        // let _total = (_total_value + _total_recibido).toFixed(2);
        emitir({
            document_type_id: form.elements.tipo_comprobante.value,
            series_id: form.elements.serie.value,
            establishment_id: form.elements.establecimiento.value,
            date_of_issue: form.elements.fecha_emision.value,
            // time_of_issue: form.elements.hora_emision.value,
            customer_id: form.elements.cliente.value,
            items: this.$store.documentsEmitConsumo.resultConsumo.consumos.map(item => {
                return {
                    item_id: item.id,
                    description: this.$store.documentsEmitConsumo.resultConsumo.tarifa.categoria,
                    quantity: item.m3_consumidos,
                    unit_price: this.$store.documentsEmitConsumo.resultConsumo.tarifa.tarifa_agua,
                    total: item.valor
                }
            }),
            total_exonerated: _total_base,
            total_value: _total_base,
            total: _total_base,
            // currency_type_id: form.elements.moneda.value,
        }).then(response => {
            console.log(response)
            this.$store.toast.success('Comprobante emitido correctamente')
        }).catch(error => {
            console.error('Error al emitir el comprobante:', error)
            this.$store.toast.error('Error al emitir el comprobante')
        })
        // Enviar formulario
        // setTimeout(() => {
        //     form.submit();
        // }, 1000);
    }
}))
