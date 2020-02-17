<template>
    <v-content>
        <v-container max-width="100% !imporant">
            <!-- 
          data table -->
            <v-card>
                <v-card-title>
                    <v-col style="background: #1565c0;" cols="12" sm="4">
                        <span class="white--text">Productos</span>
                    </v-col>
                            <v-col cols="12" sm="6">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Buscar palabra clave"
                            single-line
                            hide-details
                        >
                        </v-text-field>
                    </v-col>
                       <v-col cols="12" sm="2" center>
                        <v-btn
                            outlined
                            @click="dialogcreate = true"
                            color="primary"
                        >
                            <v-icon>mdi-plus-circle</v-icon></v-btn
                        >
                    </v-col>

                
                </v-card-title>
                
                <v-tabs
                    v-model="tab"
                    background-color="primary"
                    class="elevation-2"
                    dark
                    
               
                   
                >
                    <v-tabs-slider></v-tabs-slider>

                    <v-tab  :href="`#tab-1`">
                             Art. activos
                     
                    </v-tab>
                        <v-tab  :href="`#tab-2`">
                           Art. sin existencia fisica
                     
                    </v-tab>

                    <v-tab-item :value="'tab-1'">
                        <v-card-title primary-title>
                      
                        </v-card-title>
                      <v-data-table
                    :headers="headers"
                    :items="desserts"
                    :search="search"
                >
                    <template v-slot:item.estado="{ item }">
                      
                            <v-avatar left>
                                <v-icon :color="getColor(item.estado)">{{ iconest(item.estado) }}</v-icon>
                            </v-avatar>
                            {{ estadoart(item.estado) }}
                        
                    </template>
                    <template v-slot:item.acciones="{ item }">
                        <v-btn text icon color="gray" @click="dialogo(item)">
                            <v-icon>mdi-tooltip-edit</v-icon>
                        </v-btn>
                        <v-btn
                            text
                            icon
                            color="red"
                            @click="[(delet = true), (id_delete = item.id)]"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>


                    </v-tab-item>
                    <v-tab-item :value="'tab-2'">
                            <v-card-title primary-title>
                      
                        </v-card-title>
                         <v-data-table
                    :headers="headers2"
                    :items="articulosn"
                    :search="search"
                >
        
                    <template v-slot:item.acciones="{ item }">
                        <v-btn text icon color="gray" @click="dialogo(item)">
                            <v-icon>mdi-tooltip-edit</v-icon>
                        </v-btn>
                        <v-btn
                            text
                            icon
                            color="red"
                            @click="[(delet = true), (id_delete = item.id)]"
                        >
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </template>
                </v-data-table>

                    </v-tab-item>
                </v-tabs>

               
            </v-card>

            <!-- ------------------------------------------------------------------------------------------------ -->
            <v-dialog v-model="dialog" max-width="690">
                <v-card ref="mecard">
                    <v-card-title>
                        <span class="headline">Articulo</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field
                                        label="Nombre del articulo"
                                        v-model="nombreart"
                                        required
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field
                                        label="codigo"
                                        v-model="codigoart"
                                        hint="example of helper text only on focus"
                                        v-bind:value="arti.codigo"
                                    >
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field
                                        v-model="categoriaart"
                                        label="categoria"
                                        hint="example of persistent helper text"
                                        persistent-hint
                                        required
                                        v-bind:value="arti.idcategoria"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="descripart"
                                        label="descripcions"
                                        required
                                        v-bind:value="arti.descripcion"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                    v-if="pcompra"
                                        v-model="pcompra"
                                        ref="compra"
                                        label="Precio compra"
                                        type="number"
                                       readonly
                                        v-bind:value="arti.precio_compra"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-text-field
                                        v-model="pventa"
                                        label="Precio venta"
                                        type="number"
                                        required
                                        v-bind:value="arti.precio_venta"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-select
                                        :selected="estados.id === arti.estado"
                                        :items="estados"
                                        item-text="nombre"
                                        item-value="id"
                                        v-model="estado"
                                        label="Estado"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field
                                        v-model="stock"
                                        label="Stock"
                                        type="number"
                                        required
                                        v-bind:value="arti.stock"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                        <small>*indicates required field</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="dialog = false"
                            >Cancelar</v-btn
                        >
                        <v-btn color="blue darken-1" text @click="saveart()"
                            >Guardar</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="dialog2"
                max-width="500px"
                transition="dialog-transition"
            >
                <v-card color="primary" dark>
                    <v-card-text>
                        Please stand by
                        <v-progress-linear
                            indeterminate
                            color="white"
                            class="mb-0"
                        ></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
            <v-dialog v-model="delet" persistent max-width="290">
                <v-card>
                    <v-card-title class="headline align-center" color="primary">
                        <v-icon>mdi-delete</v-icon>
                    </v-card-title>
                    <v-card-text>¿Eliminar articulo?</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="delet = false"
                            >cancelar</v-btn
                        >
                        <v-btn color="green darken-1" text @click="deleteart"
                            >ok</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                persistent
                v-model="dialogcreate"
                max-width="500px"
                transition="dialog-transition"
            >
                <v-card>
                    <v-card-title primary-title>
                        Nuevo articulo
                    </v-card-title>
                    <v-card-text>
                        <div class="row">
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    label="Codigo articulo"
                                    placeholder="0 0000-000-000-000"
                                    outlined
                                    v-model="codigo"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    label="Nombre"
                                    outlined
                                    v-model="nombre"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12">
                                <v-text-field
                                    label="Descripcion"
                                    persistent-hint
                                    v-model="descripcion"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="idcategoria"
                                    :items="categorias"
                                    item-text="nombre"
                                    item-value="idcategoria"
                                    menu-props="auto"
                                    label="Selecione categoria"
                                    hide-details
                                    prepend-icon="mdi-file-tree"
                                    single-line
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    v-model="estadonew"
                                    :items="estados"
                                    item-value="id"
                                    item-text="nombre"
                                    menu-props="auto"
                                    label="Estado"
                                    hide-details
                                    prepend-icon="mdi-clipboard-check"
                                    single-line
                                ></v-select>
                            </v-col>
                            <v-col cols="4" sm="4" md="4">
                                <v-text-field
                                    label="Cantidad"
                                    outlined
                                    v-model="stocknew"
                                    dense
                                ></v-text-field>
                            </v-col>
                            <v-col cols="8" sm="8" md="8">
                                <v-text-field
                                    prefix="$"
                                    label="Precio venta"
                                    outlined
                                    v-model="precio_venta_art"
                                    dense
                                ></v-text-field>
                            </v-col>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="red lighten-1"
                            text
                            @click="dialogcreate = false"
                            >Cancelar</v-btn
                        >
                        <v-btn :loading="loadingsave" @click="newarticulo()" color="blue darken-1" text
                            >Guardar</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
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
    </v-content>
</template>

<script>
export default {
    data() {
        return {
            categorias: [],
            articulosn:[],
            e1: "",

            // datos para el registro de nuevos articulos

            codigo: null,
            nombre: "",
            stocknew: 0,
            descripcion: "",
            precio_venta_art: 0,
            estadonew: 3,
            idcategoria: null,
            tab: null,
            centered: true,
            grow: true,
         
            loadingsave:false,

            // -----------------------------------------------------------------------

            // datos de alerta
            color: "green",
            mode: "",
            snackbar: false,
            text: "",
            timeout: 6000,
            x: "right",
            y: "top",
            // --------------------------
            valid: false,
            desserts: [],
            search: "",
            loading: true,
            transition: "scale-transition",
            dialog: false,
            dialog2: false,
            dialogcreate: false,
            delet: false,
            id_delete: "",
            arti: [],
            estados: [
                {
                    id: 1,
                    nombre: "Estable"
                },
                {
                    id: 2,
                    nombre: "Bajo"
                },
                {
                    id: 3,
                    nombre: "Agotado"
                },
                {
                    id: 4,
                    nombre: "Inactivo"
                }
            ],

            // datos data table
            headers: [
                {
                    text: "codigo",
                    align: "left",
                    sortable: false,
                    value: "codigo"
                },
                {
                    text: "Producto",
                    value: "nombre"
                },
                {
                    text: "Categoria",
                    value: "idcategoria"
                },
                {
                    text: "Stock",
                    value: "stock"
                },
                {
                    text: "Precio venta",
                    value: "precio_venta_art"
                },
                {
                    text: "Estado",
                    value: "estado",
                    align: "center"
                },
                {
                    text: "Descripcion",
                    value: "descripcion"
                },
                {
                    text: "Acciones",
                    value: "acciones"
                }
            ],
               headers2: [
                {
                    text: "codigo",
                    align: "left",
                    sortable: false,
                    value: "codigo"
                },
                {
                    text: "Producto",
                    value: "nombre"
                },
                {
                    text: "Categoria",
                    value: "idcategoria"
                },
                {
                    text: "Stock",
                    value: "stock"
                },
                {
                    text: "Precio venta",
                    value: "precio_venta_art"
                },
           
                {
                    text: "Descripcion",
                    value: "descripcion"
                },
                {
                    text: "Acciones",
                    value: "acciones"
                }
            ],
            // ------------------------------------------------------
            datos: [],
            // datos de dialog editar
            id: "",
            nombreart: "",
            codigoart: "",
            descripart: "",
            pcompra: "",
            pventa: "",
            stock: "",
            estado: "",
            categoriaart: ""
        };
    },
    methods: {
        getColor(est) {
            if (est == 1) return "success";
            if (est == 2) return "amber";
            if (est == 3) return "red darken-3";
            if (est == 4) return "deep-purple";
        },
        estadoart(est) {
            if (est == 1) return "Estable";
            if (est == 2) return "Bajo";
            if (est == 3) return "Agotado";
            if (est == 4) return "Icnativo";
        },
        notificacion(msg) {
            this.text = msg[0];
            this.color = msg[1];
            this.snackbar = true;
        },
        iconest(est) {
            if (est == 1) return "mdi-checkbox-marked-circle";
            if (est == 2) return "mdi-alert-outline";
            if (est == 3) return "mdi-cancel";
            if (est == 4) return "mdi-cart-off";
        },
        dialogo(arti) {
            this.id = arti.id;
            this.dialog = true;
            this.nombreart = arti.nombre;
            this.codigoart = arti.codigo;
            this.descripart = arti.descripcion;
            this.pcompra = arti.precio_compra;
            this.pventa = arti.precio_venta_art;
            this.stock = arti.stock;
            this.estado = arti.estado;
            this.categoriaart = arti.idcategoria;
        },
        articulos() {
            axios
                .post("api/articulos")
                .then(res => {
                    this.desserts = res.data;
                    // console.log(res);
                })
                .finally(() => {
                    this.loading = false;
                })
                .catch(e => {});
        },
        getcategorias() {
            axios
                .post("api/categoria-all")
                .then(res => {
                    this.categorias = res.data;
                })
                .finally(() => {})
                .catch(e => {});
        },
        newarticulo() {
            this.loadingsave = true;
            axios
                .post("api/save-articulo", {
                    codigo: this.codigo,
                    nombre: this.nombre,
                    stock: this.stocknew,
                    descripcion: this.descripcion,
                    precio_venta_art: this.precio_venta_art,
                    estado: this.estadonew,
                    idcategoria: this.idcategoria
                })
                .then(res => {
                    this.getarticulos();
                    console.log(res);
                })
                .finally(() => {
                    this.dialogcreate = false;
                        this.loadingsave = false;
                })
                .catch(e => {});
        },
        getarticulos(){
             axios
                .post("api/set-articulos-sin    ")
                .then(res => {
                    this.articulosn = res.data;
                })
                .finally(() => {})
                .catch(e => {});
        },
        saveart() {
            let meth = this;
            axios
                .post("api/update-art", {
                    id: this.id,
                    idcategoria: this.categoriaart,
                    codigo: this.codigoart,
                    nombre: this.nombreart,
                    stock: this.stock,
                    precio_venta_art: this.pventa,
                    descripcion: this.descripart,
                    estado: this.estado
                })
                .then(res => {
                    meth.articulos();
                     this.getarticulos();
                    console.log(res);
                })
                .finally(() => {
                    this.nombreart = "";
                    this.codigoart = "";
                    this.descripart = "";
                    this.pventa = "";
                    this.stock = "";
                    this.estado = "";
                    this.categoriaart = "";
                    this.dialog = false;
                    let msg = ["articulo actualizado", "success"];
                    this.notificacion(msg);
                })
                .catch(e => {
                    console.log(e);
                });
        },
        deleteart() {
            let meth = this;
            axios
                .post("api/delete-art", {
                    id: this.id_delete,
                    artdelete: 2
                })
                .then(res => {
                    meth.articulos();
                     this.getarticulos();
                    console.log(res);
                })
                .finally(() => {
                    this.delet = false;
                })
                .catch(e => {});
        }
    },
    mounted() {
        this.articulos();
        this.getarticulos();
        this.getcategorias();
        setTimeout(() => {}, 3000);
    }
};
</script>

<style></style>
