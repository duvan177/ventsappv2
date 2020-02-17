<template>
    <v-content>
        <v-container style="max-width:1600px !important;">
            <v-card>
                <v-row>
                    <v-col cols="12" md="12" lg="8">
                        <v-card-text>
                            <v-card max-width="auto" outlined>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-5">1105</div>
                                        <v-list-item-title class="headline mb-1"
                                            >Caja</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Greyhound divisely hello coldly
                                            fonwderfully</v-list-item-subtitle
                                        >
                                  
                                           <v-list-item-title>
                                               <v-text-field
                                               v-model="serchCodg"
                                                   name="name"
                                                   label="codigo comprbante"
                                                   id="id"
                                                   type="number"
                                               ></v-text-field>
                                           </v-list-item-title>
                                        
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="green"
                                    >
                                        <v-icon size="40px" color="white"
                                            >mdi-arrow-down-bold</v-icon
                                        >
                                    </v-list-item-avatar>
                                </v-list-item>
                                <v-row>
                                    <v-col cols="12" md="12" lg="6">
                                          <v-list-item-title
                                            class="headline mb-1 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totalventa.toLocaleString()
                                            }}
                                        </v-list-item-title>

                                        <v-list-item three-line>
                                            <v-data-table
                                            :search="serchCodg"
                                                :items="ventasp"
                                                :headers="headers"
                                            >
                                                <template
                                                    v-slot:item.nombre="{
                                                        item
                                                    }"
                                                    >{{
                                                        item.articulo.nombre
                                                    }}</template
                                                >
                                                <template
                                                    v-slot:item.total="{ item }"
                                                    >{{
                                                        setTotal(item)
                                                    }}</template
                                                >
                                            </v-data-table>
                                        </v-list-item>
                                    </v-col>
                                    <v-col cols="12" md="12" lg="6">
                                          <v-list-item-title
                                            class="headline mb-1 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totalIng.toLocaleString()
                                            }}
                                        </v-list-item-title>
                                        <v-list-item three-line>
                                            <v-data-table 
                                            :items="ingresos"
                                             :headers="headers">
                                                 <template
                                                    v-slot:item.nombre="{
                                                        item
                                                    }"
                                                    >{{
                                                        item.articulo.nombre
                                                    }}</template
                                                >
                                                     <template
                                                    v-slot:item.total="{ item }"
                                                    >{{
                                                      setTotalIng(item)
                                                    }}</template
                                                >
                                            </v-data-table>
                                        </v-list-item>
                                    </v-col>
                                </v-row>

                                <v-card-actions> </v-card-actions>
                            </v-card>
                        </v-card-text>
                    </v-col>

                    <v-col cols="12" md="12" lg="4">
                        <v-card-text>
                            <v-card max-width="auto" outlined>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-5">4135</div>
                                        <v-list-item-title class="headline mb-1"
                                            >Venta Productos</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Greyhound divisely hello coldly
                                            fonwderfully</v-list-item-subtitle
                                        >
                                        <v-list-item-title
                                            class="headline mb-1 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totalSinInva.toLocaleString()
                                            }}
                                        </v-list-item-title>
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="red lighten-1"
                                    >
                                        <v-icon size="40px" color="white"
                                            >mdi-arrow-up-bold</v-icon
                                        >
                                    </v-list-item-avatar>
                                </v-list-item>
                                <v-list-item three-line>
                                    <v-data-table
                                       :search="serchCodg"
                                        :headers="headers"
                                        :items="ventas"
                                    >
                                        <template
                                            v-slot:item.nombre="{ item }"
                                            >{{
                                                item.articulo.nombre
                                            }}</template
                                        >
                                        <template
                                            v-slot:item.total="{ item }"
                                            >{{ setIva(item) }}</template
                                        >
                                    </v-data-table>
                                </v-list-item>

                                <v-card-actions> </v-card-actions>
                            </v-card>
                        </v-card-text>
                    </v-col>
                   
                    <v-col cols="12" md="12" lg="8">
                        <v-card-text>
                            <v-card max-width="auto" outlined>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-5">2408</div>
                                        <v-list-item-title class="headline mb-1"
                                            >Iva</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Greyhound divisely hello coldly
                                            fonwderfully</v-list-item-subtitle
                                        >
                                   
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="orange lighten-3"
                                    >
                                        <v-icon size="40px" color="white"
                                            >mdi-swap-vertical</v-icon
                                        ></v-list-item-avatar
                                    >
                                </v-list-item>
                                <v-list-item three-line>
                                   <v-row>
                                    <v-col cols="12" md="12" lg="6">
                                         <v-list-item-title
                                            class="headline mb-5 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totaliva2.toLocaleString()
                                            }}
                                        </v-list-item-title>
                                    <v-data-table
                                       :search="serchCodg"
                                        :items="ingresos"
                                        :headers="headers"
                                    >
                                        <template
                                            v-slot:item.nombre="{ item }"
                                            >{{
                                                item.articulo.nombre
                                            }}</template
                                        >
                                        <template
                                            v-slot:item.total="{ item }"
                                                >{{ setIvaAllIng(item) }}</template
                                          
                                        >
                                    </v-data-table>
                                    </v-col>
                                          <v-col cols="12" md="12" lg="6">
                                               <v-list-item-title
                                            class="headline mb-5 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totaliva1.toLocaleString()
                                            }}
                                        </v-list-item-title>
                                    <v-data-table
                                       :search="serchCodg"
                                        :items="ventas"
                                        :headers="headers"
                                    >
                                        <template
                                            v-slot:item.nombre="{ item }"
                                            >{{
                                                item.articulo.nombre
                                            }}</template
                                        >
                                        <template
                                            v-slot:item.total="{ item }"
                                          >{{ setIvaAll(item) }}</template  
                                        >
                                    </v-data-table>
                                    </v-col>
                                   </v-row>
                                </v-list-item>

                                <v-card-actions> </v-card-actions>
                            </v-card>
                        </v-card-text>
                    </v-col>
                            <v-col cols="12" md="12" lg="4">
                        <v-card-text>
                            <v-card max-width="auto" outlined>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-5">3105</div>
                                        <v-list-item-title class="headline mb-1"
                                            >Capital</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Greyhound divisely hello coldly
                                            fonwderfully</v-list-item-subtitle
                                        >
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="red lighten-1"
                                    >
                                        <v-icon size="40px" color="white"
                                            >mdi-account-convert</v-icon
                                        ></v-list-item-avatar
                                    >
                                </v-list-item>
                                <v-list-item three-line>
                                    <v-data-table :items="baseday" :headers="headers">
                                    </v-data-table>
                                </v-list-item>

                                <v-card-actions> </v-card-actions>
                            </v-card>
                        </v-card-text>
                    </v-col>
                  
                     <v-col cols="12" md="12" lg="4">
                        <v-card-text>
                            <v-card max-width="auto" outlined>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-5">1305</div>
                                        <v-list-item-title class="headline mb-1"
                                            >Cuentas por
                                            cobrar</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Greyhound divisely hello coldly
                                            fonwderfully</v-list-item-subtitle
                                        >
                                        <v-list-item-title
                                            class="headline mb-1 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totalventaxp.toLocaleString()
                                            }}
                                        </v-list-item-title>
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="orange lighten-3"
                                    >
                                        <v-icon size="40px" color="white"
                                            >mdi-arrow-down-bold</v-icon
                                        ></v-list-item-avatar
                                    >
                                </v-list-item>
                                <v-list-item three-line>
                                    <v-data-table
                                        :items="ventasxcomb"
                                        :headers="headers"
                                           :search="serchCodg"
                                    >
                                        <template
                                            v-slot:item.nombre="{ item }"
                                            >{{
                                                item.articulo.nombre
                                            }}</template
                                        >
                                        <template
                                            v-slot:item.total="{ item }"
                                            >{{ setTotal(item) }}</template
                                        >
                                    </v-data-table>
                                </v-list-item>

                                <v-card-actions> </v-card-actions>
                            </v-card>
                        </v-card-text>
                    </v-col>
                        <v-col cols="12" md="12" lg="4">
                        <v-card-text>
                            <v-card max-width="auto" outlined>
                                <v-list-item three-line>
                                    <v-list-item-content>
                                        <div class="overline mb-5">1435</div>
                                        <v-list-item-title class="headline mb-1"
                                            >Mercancias</v-list-item-title
                                        >
                                        <v-list-item-subtitle
                                            >Greyhound divisely hello coldly
                                            fonwderfully</v-list-item-subtitle
                                        >
                                        <v-list-item-title
                                            class="headline mb-1 align-center"
                                        >
                                            {{
                                                "Total: + $" +
                                                    this.totalIngSin.toLocaleString()
                                            }}
                                        </v-list-item-title>
                                    </v-list-item-content>

                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                        color="green"
                                    >
                                        <v-icon size="40px" color="white"
                                            >mdi-arrow-down-bold</v-icon
                                        ></v-list-item-avatar
                                    >
                                </v-list-item>
                                <v-list-item three-line>
                                    <v-data-table
                                        :items="ingresos"
                                        :headers="headers"
                                           :search="serchCodg"
                                    >
                                        <template
                                            v-slot:item.nombre="{ item }"
                                            >{{
                                                item.articulo.nombre
                                            }}</template
                                        >
                                        <template
                                            v-slot:item.total="{ item }"
                                            >{{ totalMerc(item) }}</template
                                        >
                                   
                                    </v-data-table>
                                </v-list-item>

                                <v-card-actions> </v-card-actions>
                            </v-card>
                        </v-card-text>
                    </v-col>
            
                </v-row>
            </v-card>
        </v-container>
    </v-content>
</template>

<script>
export default {
    data: () => ({
        serchCodg:null,
        baseday:[],
        ventasp: [],
        ingresos:[],
        capital:[],
        totalventa: 0,
        totalventaxp: 0,
        ventas: [],
        ventasxcomb: [],
        totaliva1: 0,
        totaliva2:0,
        totalIng:0,
        totalSinInva: 0,
        totalIngSin:0,
        headers: [
            {
                text: "N. factura",
                align: "left",
                sortable: false,
                value: "num_comprobante"
            },
            {
                text: "Producto",
                value: "nombre"
            },
            {
                text: "total",
                value: "total"
            }
        ]
    }),
    methods: {
        totalMerc(item){
        let total =      (item.precio_compra * item.cantidad) - ((item.precio_compra * item.cantidad) * 0.19);
        return '$'+total.toLocaleString()
        },
        setTotalIng(obj){
            let total = parseFloat( obj.precio_compra) * obj.cantidad;
            return '$'+ total.toLocaleString()
        },
        getingresos(){
                axios.post('api/all-ingresos')  
                .then(res => {
                   this.ingresos = res.data;
                   if(res.data.length > 0){
                       this.setIvaIndresos(res.data);
                   }
                })
                .catch(err => {
                    console.error(err); 
                })
        },
         basedia(){
                  axios.post('api/base')
            .then(res => {
                console.log(res.data)
                let _total = parseFloat( res.data[0].basetotal);
             
                this.baseday.push({num_comprobante:'01',nombre:'capital', total:_total.toLocaleString()})
                
            })
            .catch(err => {
                console.error(err); 
            })
        
         },
        getventas() {
            this.lgtable = true;
            axios
                .post("api/all-ventas")
                .then(res => {
                    this.ventas = res.data;
                    this.ventasp = res.data.filter(res => res.estado != 2);
                    this.ventasxcomb = res.data.filter(obj => obj.estado == 2);
                    this.totalventas();
                    // console.log(res);
                })
                .finally(() => {
                    //   this.loading = false;
                    //   this.newdatatable = this.datatable;
                    //    this.coversionfecha();
                })
                .catch(e => {});
        },
        setTotal(obj) {
            return "$" + obj.total_venta.toLocaleString();
        },
        setIva(obj) {
            let iva = 0;
            iva = parseFloat(obj.total_venta) * 0.19;

            return "$" + (parseFloat(obj.total_venta) - iva);
        },
        totalventas() {
            let cont = 0;
            let cont_ = 0;

            let iva = 0;
            let totalsin = 0;
            this.ventas.forEach(obj => {
                iva += parseFloat(obj.total_venta) * 0.19;
                totalsin +=
                    parseFloat(obj.total_venta) -
                    parseFloat(obj.total_venta) * 0.19;
            });
            this.ventasp.forEach(obj => {
                cont += parseFloat(obj.total_venta);
            });
            this.ventasxcomb.forEach(obj => {
                cont_ += parseFloat(obj.total_venta);
            });
            this.totalventaxp = cont_;
            this.totalventa = cont;
            this.totaliva1  =   iva.toFixed(2);
            this.totalSinInva = totalsin.toFixed(2);
        },
        setIvaAll(obj) {
            return "$" + parseFloat(obj.total_venta) * 0.19;
        },
          setIvaAllIng(obj) {
            return "$" + ((parseFloat(obj.precio_compra) * obj.cantidad) *  0.19).toFixed(2);
        },
        setIvaIndresos(arr){
            let iva = 0;
            let tIng =0;
            let tIngS = 0;
            arr.forEach((obj)=>{
                iva += (parseFloat(obj.precio_compra) * obj.cantidad) * 0.19;
                tIng += parseFloat(obj.precio_compra) * obj.cantidad;
                tIngS += (parseFloat(obj.precio_compra) * obj.cantidad) -((parseFloat(obj.precio_compra) * obj.cantidad) * 0.19);
            });

            this.totaliva2 = iva;
            this.totalIng = tIng;
            this.totalIngSin = tIngS;
        }
    },
    mounted() {
        this.basedia()
        this.getventas();
        this.getingresos();
    },
    watch:{
       
    
    }
};
</script>

<style></style>
