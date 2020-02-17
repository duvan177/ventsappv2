<template>
    <v-content>
        <v-container max-width="100% !imporant">
            <v-card>
                <v-card-title primary-title>
                    lista Panaderia
                </v-card-title>
                <v-card-text>
                    <v-layout wrap>
                        <v-flex xs12 md8> </v-flex>
                        <v-flex xs12 md4>
                            <v-text-field
                                append-icon="mdi-magnify"
                                v-model="buscarp"
                                placeholder="Buscar"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-card-text>

                <v-data-table
                    :search="buscarp"
                    :loading="lgdata"
                    :headers="headers"
                    :items="panes"
                    :items-per-page="5"
                    class="elevation-1"
                >
                    <template v-slot:item.estad="{ item }">
                        <v-icon :color="colordata(item)">{{
                            istock(item)
                        }}</v-icon>
                        {{ stockestado(item) }}
                    </template>
                    <template v-slot:item.opciones="{ item }">
                        <v-btn text @click="editpan(item)">
                            <v-icon color="grey"
                                >mdi-tooltip-edit</v-icon
                            ></v-btn
                        >
                        <v-btn text @click="baja(item)">
                            <v-icon color="red"
                                >mdi-minus-circle-outline</v-icon
                            ></v-btn
                        >
                    </template>
                </v-data-table>
            </v-card>
        </v-container>
        <v-dialog
            v-model="dialogbaja"
            scrollable
            persistent
            :overlay="false"
            max-width="300px"
            height="400px"
            transition="dialog-transition"
        >
            <v-card>
                <v-card-text>
                    <v-card-title primary-title>
                        <v-row align="center" justify="center">
                            <p class="text-center">
                                Baja de articulo <br />
                                {{nompan}}
                            </p>
                        </v-row>
                    </v-card-title>
                    <v-row align="center" justify="center">
                        <v-flex md4 lg4>
                            <v-text-field
                          v-bind:style="{ 'text-aling':'center' }"
                            id="cantidad"
                            text-align="center"
                                outlined
                           v-model.number="cantidadbaja"
                                label="cantidad"
                          
                              type="number"
                              max="20"
                                autofocus

                                 class="centertext"
                            ></v-text-field>
                        </v-flex>
                    </v-row>
                    <v-row align="center" justify="center">
                        <v-btn color="red" text icon>
                            <v-icon @click="dialogbaja = false">mdi-cancel</v-icon></v-btn
                        >

                        <v-btn color="success" text icon>
                            <v-icon @click="savebajapan()"
                                >mdi-content-save</v-icon
                            ></v-btn
                        >
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogedit" persistent max-width="500px">
            <v-card>
                <v-card-title>
                    <span class="headline"
                        >Editar <v-icon>mdi-marker</v-icon></span
                    >
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 sm6 md6>
                                <v-text-field
                                    v-model="codigo"
                                    label="Codigo"
                                    required
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm6 md6>
                                <v-text-field
                                    v-model="nombre"
                                    label="Nombre"
                                    hint="example of helper text only on focus"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm8 md8>
                                <v-text-field
                                    v-model="descripcion"
                                    label="Descripcion"
                                    hint="example of persistent helper text"
                                    persistent-hint
                                    required
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm4>
                                <v-text-field
                                    v-model="stock"
                                    outlined
                                    label="Stock"
                                    required
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm4>
                                <v-text-field
                                    v-model="precio_venta_art"
                                    outlined
                                    label="Precio venta"
                                    type="number"
                                    required
                                    prefix="$"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12 sm4>
                                <v-select
                                    label="Estado"
                                    item-text="text"
                                    item-value="id"
                                    v-model="estado"
                                    required
                                    :items="[
                                        { id: '1', text: 'Estable' },
                                        { id: '2', text: 'bajo' },
                                        { id: '3', text: 'Agotado' }
                                    ]"
                                ></v-select>
                            </v-flex>
                            <v-flex xs12 sm6>
                                <v-select
                                    v-model="idcategoria"
                                    append-icon="mdi-sitemap"
                                    label="categoria"
                                    autocomplete
                                    item-text="nombre"
                                    item-value="idcategoria"
                                    :items="categorias"
                                ></v-select>
                            </v-flex>
                        </v-layout>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        text
                        color="red darken-1"
                        flat
                        @click.native="dialogedit = false"
                        class="text--white"
                    >
                        <v-icon>mdi-close</v-icon></v-btn
                    >
                    <v-btn
                        :loading="lgsave"
                        text
                        color="green darken-1"
                        flat
                        @click.native="updatepan()"
                        ><v-icon>mdi-content-save</v-icon></v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar
            v-model="snackbar"
            :color="color"
            right="right"
            :timeout="timeout"
            top="top"
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
            dialogbaja: false,
            nompan:'',
            idbaja:'',
            cantidadbaja:null,
            // variables para la edicion de artiuclos pan
            snackbar: false,
            idpan: null,
            dialogedit: false,
            codigo: "",
            nombre: "",
            stock: "",
            descripcion: "",
            precio_venta_art: "",
            estado: "",
            categorias: [],
            idcategoria: "",
            timeout: 4000,
            text: "",
            color: "",
            lgsave: false,
            // }-------------------------------------------------------
            buscarp: "",
            lgdata: false,
            panes: [],
            headers: [
                {
                    text: "Codigo",
                    align: "left",
                    sortable: false,
                    value: "codigo"
                },
                { text: "Nombre", value: "nombre" },
                { text: "Descripcion", value: "descripcion" },
                { text: "stock", value: "stock" },
                { text: "Precio venta", value: "precio_venta_art" },
                { text: "Estado", value: "estad" },
                { text: "fecha actualizado", value: "updated_at" },
                { text: "Opciones", value: "opciones" }
            ]
        };
    },
    methods: {
        baja(obj){
            this.dialogbaja = true;
            this.nompan = obj.nombre;
            this.idbaja = obj.id;
           
        },
        savebajapan() {
           
           axios.post('api/baja-pan',{
               id:this.idbaja,
               cantidad:this.cantidadbaja
           })
           .then(res => {
               console.log(res)
               if(res.data != 'error'){
                  this.dialogbaja = false;
            this.nompan ='';
            this.idbaja =null;
               }else{
                   alert('error en el proceso') 
               }
           }).finally(()=>this.getpanes())
           .catch(err => {
               console.error(err); 
           })
       
        },
        notificacion(msg) {
            this.text = msg[0];
            this.color = msg[1];
            this.snackbar = true;
        },
        colordata(obj) {
            if (obj.estado == 1) {
                return "success";
            }
            if (obj.estado == 2) {
                return "warning";
            }
            if (obj.estado == 3) {
                return "error";
            }
        },
        istock(obj) {
            if (obj.estado == 1) {
                return "mdi-checkbox-marked-circle";
            }
            if (obj.estado == 2) {
                return "mdi-alert-circle";
            }
            if (obj.estado == 3) {
                return "mdi-information";
            }
        },
        stockestado(obj) {
            if (obj.estado == 1) {
                return "Estable";
            }
            if (obj.estado == 2) {
                return "Bajo";
            }
            if (obj.estado == 3) {
                return "Agotado";
            }
        },
        getpanes() {
            this.lgdata = true;
            this.selectlg = true;
            axios
                .post("api/set-pan")
                .then(res => {
                    console.log(res);
                    this.panes = res.data;
                })
                .finally(() => {
                    this.selectlg = false;
                    this.lgdata = false;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        editpan(obj) {
            // alert(obj.nombre);
            this.dialogedit = true;
            this.codigo = obj.codigo;
            this.nombre = obj.nombre;
            this.descripcion = obj.descripcion;
            this.stock = obj.stock;
            this.estado = obj.estado;
            this.precio_venta_art = obj.precio_venta_art;
            this.idcategoria = obj.categoria.idcategoria;
            this.idpan = obj.id;
        },
        updatepan() {
            this.lgsave = true;
            axios
                .post("api/update-pan", {
                    codigo: this.codigo,
                    nombre: this.nombre,
                    descripcion: this.descripcion,
                    stock: this.stock,
                    estado: this.estado,
                    precio_venta_art: this.precio_venta_art,
                    idcategoria: this.idcategoria,
                    idpan: this.idpan
                })
                .then(res => {
                    let msg = ["Actualizado", "success"];
                    this.notificacion(msg);
                    this.getpanes();
                })
                .finally(() => {
                    this.dialogedit = false;
                    this.lgsave = false;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        getcategorias() {
            axios
                .post("api/categoria-all")
                .then(res => {
                    this.categorias = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        }
    },
    mounted() {
        this.getpanes();
        this.getcategorias();
    }
};
</script>

<style>

.centertext.v-input input{
text-align: center;
}
</style>
