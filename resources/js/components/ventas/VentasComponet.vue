<template>
    <v-content>
        <v-container max-width="100% !imporant">
            <v-card >
                <v-card-subtitle style="background:#1565c0;color: white;">
                
                    <h2>
                        Venta
                        <v-icon color="white">mdi-cart</v-icon>
                    </h2>
                    <v-spacer></v-spacer>
                    <!-- <v-col cols="6" sm="6">
            <v-select :items="['0-17', '18-29', '30-54', '54+']" label="Age*" required></v-select>
          </v-col>-->
                </v-card-subtitle>
                <v-card-text v-if="showvent  == true">
                  <div class="row justify-center">
                            <v-col cols="6" sm="6" md="4">
                         <img src="img/comprasx.png" alt="">
                         <v-btn @click="dialog = true" class="animated bounce infinite " color="warning" text  dark> agregar base</v-btn>
                            </v-col>
                  </div>
                </v-card-text>
                <v-card-text v-else transition="scale-transition">
                    <v-container>
                        <div class="row">
                            <v-col cols="6" sm="6" md="4">
                                <v-select
                                    v-model="tipocomp"
                                    prepend-icon="mdi-file-document"
                                    :items="['factura', 'recibo de caja']"
                                    label="T. comprobante"
                                    required
                                ></v-select>
                            </v-col>
                            <v-col cols="6" sm="6" md="4">
                                <v-text-field
                                    readonly
                                    v-model="numcomp"
                                    label="N. Comprobante"
                                    id="id"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="6" sm="6" md="4">
                                <v-select
                                    v-model="cliente"
                                    item-text="nombre"
                                    item-value="id"
                                    :items="clientes"
                                    label="persona"
                                    required
                                ></v-select>
                            </v-col>
                        </div>
                        <v-row>
                            <v-col cols="2" md="1">
                                <v-btn
                                    text
                                    icon
                                    color="error"
                                    @click="tipobusq = !tipobusq"
                                >
                                    <v-icon>mdi-priority-low</v-icon>
                                </v-btn>
                            </v-col>
                            <v-col cols="10" sm="6" md="4">
                                <v-text-field
                                    v-if="tipobusq"
                                    autofocus
                                    clearable
                                    v-model="articulo"
                                    ref="art"
                                    label="Codigo articulo"
                                ></v-text-field>
                                <v-autocomplete
                                    v-else
                                    autofocus
                                    :items="articulos"
                                    item-text="nombre"
                                    item-value="codigo"
                                    v-model="articulo"
                                    type="text"
                                    name="producto"
                                    label="nombre clave articulo"
                                    ref="art"
                                    no-data-text="articulo no encontrado"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="6" sm="2" md="2">
                                <v-text-field
                                    centered
                                    type="number"
                                    label="cantidad"
                                    v-model.number="und"
                                    ref="und"
                                    v-on:keyup.enter="addarticulo"
                                    outlined
                                    hint="example of helper text only on focus"
                                ></v-text-field>
                            </v-col>

                            <v-col cols="6" sm="2">
                                <v-text-field
                                    centered
                                    type="number"
                                    label="descuento"
                                    v-model.number="descuento"
                                    ref="des"
                                    :readonly="desc"
                                    outlined
                                    :append-icon="'mdi-lock'"
                                    filled
                                    @click:append="blokdesc()"
                                    hint="ingrese contraseña de administrador"
                                ></v-text-field>
                            </v-col>

                            <v-col cols="6" sm="2" md="2">
                                <v-radio-group
                                    v-model="estado"
                                    :mandatory="false"
                                >
                                    <v-radio
                                        color="success"
                                        label="pago"
                                        :value="1"
                                    ></v-radio>
                                    <v-radio
                                        color="warning"
                                        label="credito"
                                        :value="2"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*todos los campos son requeridos</small>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text>Limpiar</v-btn>
                        <v-btn color="blue darken-1" text @click="addarticulo()"
                            >Agregar</v-btn
                        >
                    </v-card-actions>
                </v-card-text>
                <v-card-text>
                    <v-data-table
                        :sort-by="'ordenar'"
                        :search="buscar"
                        :items="datatable"
                        :headers="headers"
                        :items-per-page="5"
                        class="elevation-1"
                    >
                        <template v-slot:item.action="{ item }">
                            <v-icon color="red" @click="remove(item)"
                                >mdi-delete</v-icon
                            >
                        </template>

                        <!-- <template v-slot:item.impuesto="{ item }">
              <v-chip gray></v-chip>
            </template> -->
                    </v-data-table>
                    <v-card-actions>
                        <h3 v-text="'Total: ' + eventoNum(total_venta)"></h3>
                        <v-spacer></v-spacer>

                        <v-btn
                            :loading="send"
                            color="red"
                            @click="sendventa"
                            text
                            >Terminar</v-btn
                        >
                    </v-card-actions>
                </v-card-text>
            </v-card>
            <v-snackbar
                v-model="snackbar"
                :bottom="y === 'bottom'"
                :color="color"
                :left="x === 'left'"
                :multi-line="mode === 'multi-line'"
                :right="x === 'right'"
                :timeout="timeout"
                :top="y === 'top'"
                :vertical="mode === 'vertical'"
            >
                {{ text }}
                <v-btn dark text @click="snackbar = false">
                    <v-icon color="white">mdi-close-circle</v-icon>
                </v-btn>
            </v-snackbar>
            <v-dialog
                v-model="dialog"
                scrollable  
                persistent :overlay="false"
                max-width="350px"
                transition="dialog-transition"
            >
                <v-card>
                    <v-card-title>
                        Base del Dia
                    </v-card-title>
            <v-card-text>
                Ingrese la base del dia para inciar con las ventas.
            </v-card-text>
                    <v-card-text>
                   <v-row>
                    <v-col cols="12" md="12" lg="6" offset-lg="3">
                       <v-text-field
                       outlined
                      type="number"
                           name="name"
                           label="cantidad"
                           id="id"
                           v-model="baseday"
                           prefix="$"
                       ></v-text-field>
                    </v-col>
                <v-col cols="12" class="d-flex justify-center">
                <v-btn  @click=" savebase()"  text > <v-icon color="green">mdi-content-save-settings</v-icon></v-btn>
                       <v-btn   text @click="dialog=false" > <v-icon color="red">mdi-close</v-icon></v-btn>
                
                </v-col>
                   </v-row>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-container>
    </v-content>
</template>

<script>
export default {
    props: ["iduser"],
    data: () => ({
        showvent:false,
        baseday:null,
        dialog:false,
        desc: true,
        loading: false,
        snackbar: false,
        x: "right",
        y: "top",
        color: "",
        timeout: 4000,
        mode: "",
        text: "",
        send: false,
        //datos para gregar articulos a la tabla
        numcomp: "",
        tipocomp: "factura",
        cliente: 2,
        und: 1,
        //-------------------------------------------
        impuesto: 19,
        descuento: 0,
        total_venta: 0,
        estado: 1,
        clientes: [{ id: 2, nombre: "cliente" }],
        buscar: "",
        tipobusq: true,
        datatable: [],
        articulos: [],
        articulosventa: "",
        headers: [
            {
                text: "Codigo",
                align: "left",
                sortable: true,
                value: "codigo"
            },

            { text: "nombre", value: "nombre" },
            { text: "cantidad", value: "cantidad" },

            { text: " Precio (und)", value: "precio_venta" },

            { text: "Total", value: "total" },

            { text: "Acciones", value: "action", align: "center" }
        ],
        articulo: ""
    }),
    methods: {
        blokdesc() {
            alert("desbloquear");
        },

        remove(obj) {
            var opcion = confirm("Desea eliminar registro de ingreso");
            if (opcion) {
                const index = this.datatable.indexOf(obj);
                this.datatable.splice(index, 1);
                let msg = ["eliminado", "success"];
                this.notificacion(msg);
            }
        },
        eventoNum(i) {
            i = String(i).replace(/\D/g, "");

            return i === "" ? i : Number(i).toLocaleString();
        },

        notificacion(msg) {
            this.text = msg[0];
            this.color = msg[1];
            this.snackbar = true;
        },
        getarticulos() {
            axios
                .post("api/set-articulos")
                .then(res => {
                    this.articulos = res.data;
                    //   console.log(res);
                })
                .finally(() => (this.loading = false))
                .catch(e => {});

            axios
                .post("api/articulos")
                .then(res => {
                    this.articulosventa = res.data;
                    // console.log(res);
                })
                .finally(() => (this.loading = false))
                .catch(e => {});
        },
        filterart(obj) {
            let data;
            data = obj.filter(res => res.codigo == this.articulo);
            if (data.length <= 0) {
                let panes = this.articulos.filter(res => res.idcategoria == 5);

                let panes2 = panes.filter(res => res.codigo == this.articulo);
                if (panes2 <= 0) {
                    let msg = [
                        "Articulo no diponible, revice el almacen y vuelva a intentar",
                        "warning"
                    ];
                    this.notificacion(msg);
                    return [];
                } else {
                    if (panes2[0]["stock"] > 0) {
                        return panes2;
                    } else {
                        let msg = [
                            "Articulo no diponible, stock en cero",
                            "warning"
                        ];
                        this.notificacion(msg);
                        return [];
                    }
                }
            } else {
                if (data[0]["stock"] > 0) {
                    return data;
                } else {
                    let msg = ["Articulo no diponible, stock en 0", "warning"];
                    this.notificacion(msg);
                    return [];
                }
            }
        },
        addarticulo() {
            let th = this;

            if (this.articulo && this.und) {
                let data = this.filterart(this.articulosventa);

                let v = data.forEach(value => {
                    let total = parseInt(value.precio_venta_art) * this.und;
                    //  th.total_venta = th.total_venta + total;
                    let newobj = {
                        nombre: value.nombre,
                        idarticulo: value.id,
                        cantidad: this.und,
                        codigo: value.codigo,
                        total: total,
                        precio_venta: value.precio_venta_art,
                        idventa: null,
                        descuento: null
                    };
                    this.datatable.push(newobj);
                    // console.log(value)
                    this.articulo = "";
                    this.und = 1;
                    this.$refs.art.focus();
                });
            } else {
                let msg = ["complete los datos requeridos", "error"];
                this.notificacion(msg);
            }
        },
        sendventa() {
            if (this.datatable.length >= 1) {
                this.send = true;
                let mt = this;
                axios
                    .post("api/create-venta", {
                        idcliente: this.cliente,
                        tipo_comprobante: this.tipocomp,
                        num_comprobante: this.numcomp,
                        impuesto: this.impuesto,
                        descuento: this.descuento,
                        total_venta: this.total_venta,
                        estado: this.estado,
                        serie_comprobante: "F",
                        user_id: this.iduser,
                        detalles: this.datatable
                    })
                    .then(res => {
                        // this.articulos = res.data;
                        console.log(res);
                        this.datatable = [];
                        this.articulosventa=[];
                        this.articulosventa = res.data.data;
                        mt.numcomp = parseInt(res.data.numero) + 1;
                        let msg = ["venta registrada", "success"];
                        this.notificacion(msg);
                    })
                    .finally(
                        () => ((this.loading = false), (this.send = false))
                    )
                    .catch(e => {});
            } else {
                let msg = ["Ingrese articulos y continue", "error"];
                this.notificacion(msg);
            }
        },
        seddetalleventa() {
            axios
                .post("api/create-detalle-venta")
                .then(res => {
                    // this.articulos = res.data;
                    console.log(res);

                    this.numcomp = parseInt(res.data) + 1;
                })
                .finally(() => (this.loading = false))
                .catch(e => {});
        },
        basedia(){
            axios.post('api/base')
            .then(res => {
               if(res.data == 4004){
                   this.dialog = true;
                   this.showvent = true;
               }
            })
            .catch(err => {
                console.error(err); 
            })
        },
        savebase(){
            axios.post('api/savebase',{
                basetotal:this.baseday
            })
            .then(res => {
               if(res.data == 200){
                   this.showvent = false;
                   this.dialog = false;
               }
            })
            .catch(err => {
                console.error(err); 
            })
        }
    },
    mounted() {
          this.basedia();
        if (this.numcomp == "") {
            this.numcomp = 1001;
        }
        console.log(this.iduser);
        this.getarticulos();
        if (localStorage.venta2) {
            // this.consulta = atob(JSON.parse(localStorage.getItem("venta")));
            let venta2 = localStorage.getItem("venta2");
            this.datatable = JSON.parse(venta2);
        }

        this.seddetalleventa();
    },
    watch: {
        datatable(val) {
            let total = 0;
            localStorage.venta2 = JSON.stringify(val);
            val.forEach(element => {
                total += parseInt(element.precio_venta) * element.cantidad;
            });
            this.total_venta = total;
            console.log(total);
        }
    }
};
</script>

<style></style>
