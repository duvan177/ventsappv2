<template>
  <v-content>
    <v-container>
      <v-card>
        <v-card-title>
          <v-col
            style="text-align: center !important; background: #1565c0;
    color: white; height: 70px;"
            cols="12"
            sm="6"
            md="6"
          >
            <span class="headline font-weight-bold">
              Detalle Ingreso
              <v-icon color="white">mdi-basket-fill</v-icon>
            </span>
          </v-col>
          <v-spacer></v-spacer>
          <v-text-field label="Proveedor" v-model="proveedor" filled rounded readonly dense></v-text-field>
          <v-spacer></v-spacer>
          <v-text-field label="Numero Comprobante" v-model="ncomp" filled rounded readonly dense></v-text-field>
        </v-card-title>
       
        <v-card-text transition="scale-transition" v-if="persona">
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="4">
                <v-autocomplete
                  :items="productos"
                  item-text="nombre"
                  item-value="id"
                  v-model="articulo"
                  name="producto"
                  label="Articulo"
                  no-data-text="articulo no encontrado"
                ></v-autocomplete>
              </v-col>
              <v-col cols="6" sm="2" md="2">
                <v-text-field
                  centered
                  type="number"
                  label="cantidad"
                  v-model.number="cantidad"
                  outlined
                  hint="example of helper text only on focus"
                ></v-text-field>
              </v-col>
              <v-col cols="6" sm="2" md="2">
                <v-text-field
                  centered
                  type="number"
                  label="inpuesto"
                  v-model.number="impuesto"
                  readonly
                  outlined
                  filled
                  hint="example of helper text only on focus"
                ></v-text-field>
              </v-col>

              <v-col cols="12" sm="6">
                <v-text-field
                  type="number"
                  outlined
                  color="red"
                  label="Precio Compra"
                  v-model.number="p_compra"
                  prepend-inner-icon="mdi-cash-usd"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6">
                <v-text-field
                  type="number"
                  outlined
                  color="green"
                  label="Precio Venta"
                  v-model.number="p_venta"
                  prepend-inner-icon="mdi-cash-usd"
                ></v-text-field>
              </v-col>
              <v-col cols="6" sm="6">
                <v-select :items="['0-17', '18-29', '30-54', '54+']" label="Age*" required></v-select>
              </v-col>
            </v-row>
          </v-container>
          <small>*todos los campos son requeridos</small>
        </v-card-text>
        <v-card-text transition="fade-transition" v-else>
          <v-col style="text-align: center;" cols="12" class="mt-12">
            <v-tooltip v-model="show" top>
              <template v-slot:activator="{ on }">
                <v-btn @click="dialog = true" color="#e91e63!important" rounded v-on="on">
                  <v-icon color="white">mdi-cart-plus</v-icon>
                </v-btn>
              </template>
              <span>has click para u ingreso y continuar</span>
            </v-tooltip>
          </v-col>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="limpiar()">Limpiar</v-btn>
          <v-btn color="blue darken-1" text @click=" addingreso()">Agregar</v-btn>
        </v-card-actions>

        <!-- secion de data table -->

        <v-card-title>
          Articulos ingresados
          <v-spacer></v-spacer>
          <v-text-field
            v-model="buscar"
            append-icon="mdi-magnify"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
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
              <v-icon color="red" @click="remove(item)">mdi-delete</v-icon>
            </template>

            <template v-slot:item.impuesto="{ item }">
              <v-chip gray>{{ item.impuesto+'%' }}</v-chip>
            </template>
          </v-data-table>
          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="red" text @click="sendingreso()">Terminar</v-btn>
          </v-card-actions>
        </v-card-text>

        <!--------------------------------------------------------------------------------------------------------------------- -->
      </v-card>

      <!-- secion de dialogo creacion de registro -->
      <v-dialog loading="true" v-model="dialog" persistent max-width="600px">
        <v-card :disabled="card1">
          <v-card-title>
            <span class="headline">Crear ingreso</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="10" sm="10" md="10">
                  <v-select
                    :items="personas"
                    item-value="idpersona"
                    item-text="nombre"
                    v-model.number="persona"
                    label="seleccione proveedor"
                    solo
                  ></v-select>
                </v-col>
                <v-col cols="2" sm="2" md="2">
                  <v-btn text icon color="gray">
                    <v-icon>mdi-account-multiple-plus</v-icon>
                  </v-btn>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-text-field v-model="ncomp" label="N. comprobante" outlined></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                  <v-select
                    :items="tipocomp"
                    item-text="name"
                    v-model="comprobante"
                    item-value="name"
                    filled
                    label="tipo de comprobante"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    v-model="impuest"
                    label="inpuesto"
                    hint="iva que se le impone al articulo"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
            <small>*campos requeridos para el ingreso</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="[dialog = false , persona = '',proveedor ='' , ncomp  ='' ]"
            >cerrar</v-btn>
            <v-btn color="blue darken-1" text :loading="btncard" @click="createingreso()">Crear</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <!-- fin de creacion de registro de ingreeso -->
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
        {{text}}
        <v-btn dark text @click="snackbar = false">
          <v-icon color="white">mdi-close-circle</v-icon>
        </v-btn>
      </v-snackbar>
    </v-container>
  </v-content>
</template>

<script>
export default {
  data() {
    return {
      show: true,
      n: 0,
      //------------------
      dis: true,
      datatable: [],
      cantidad: "",
      impuesto: 19,
      codigoart: "",
      p_compra: "",
      p_venta: "",
      articulo: "",
      productos: [],
      producto: "",
      idproducto: "",
      buscar: "",
      proveedor: "",
      // datos de alerta
      color: "green",
      mode: "",
      snackbar: false,
      text: "Hello, I'm a snackbar",
      timeout: 6000,
      x: "right",
      y: "top",
      // --------------------------
      impuest: "",
      ncomp: "z",
      persona: 26,
      card1: false,
      btncard: false,
      personas: [],
      dialog: false,
      alert: false,
      tipocomp: [
        { id: 1, name: "factura" },
        { id: 2, name: "recibo de caja" },
        { id: 3, name: "otros" }
      ],
      comprobante: "",
      headers: [
        {
          text: "Codigo",
          align: "left",
          sortable: true,
          value: "codigo"
        },

        { text: "nombre", value: "nombre" },
        { text: "cantidad", value: "cantidad" },
        { text: "Precio Compra", value: "precio_compra" },
        { text: " Precio Venta", value: "precio_compra" },
        { text: "Impuesto", value: "impuesto" },
        { text: "Total", value: "total" },
        { text: "Total Neto", value: "total_neto" },
        { text: "Acciones", value: "action", align: "center" }
      ]
    };
  },
  methods: {
    notificacion(msg) {
      this.text = msg[0];
      this.color = msg[1];
      this.snackbar = true;
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
    limpiar() {
      this.codigoart = "";
      this.producto = "";
      this.cantidad = "";
      this.p_compra = "";
      this.p_venta = "";
      this.articulo = "";
    },
    sendingreso() {
      if (this.datatable.length >= 1) {
        axios
          .post("api/create-detalle-ingreso", {
            arraydata: this.datatable
          })
          .then(res => {
            // this.productos = res.data;
            console.log(res);
          })
          .finally(() => {
            this.loading = false;
            let msg = ["ingreso finalizado con exito", "success"];
            this.notificacion(msg);
          })
          .catch(e => {});
      } else {
        let msg = ["Ingrese articulos y finalizar", "red"];
        this.notificacion(msg);
      }
    },
    addingreso() {
      //datatable
      if (
        this.articulo &&
        this.cantidad &&
        this.p_compra &&
        this.p_venta &&
        this.p_compra > 0 &&
        this.p_venta > 0 &&
        this.cantidad > 0
      ) {
        let total = parseInt(this.p_compra * this.cantidad);

        this.datatable.push({
          codigo: this.codigoart,
          nombre: this.producto,
          cantidad: this.cantidad,
          precio_compra: this.p_compra,
          precio_venta: this.p_venta,
          impuesto: this.impuesto,
          total: total,
          idingreso: this.persona,
          idarticulo: this.idproducto
        });

        this.limpiar();
      } else {
        let msg = ["Complete los campos requeridos y que sean validos", "red"];
        this.notificacion(msg);
      }
      //console.log(this.datatable);
    },

    articulos() {
      axios
        .post("api/set-articulos")
        .then(res => {
          this.productos = res.data;
           console.log(res);
        })
        .finally(() => (this.loading = false))
        .catch(e => {});
    },
    alerta(item) {
      alert(item);
    },
    createingreso() {
      this.card1 = true;
      this.btncard = true;
      axios
        .post("api/create-ingreso", {
          idproveedor: this.persona,
          tipo_comprobante: this.comprobante,
          serie_comprobante: this.ncomp,
          num_comprobante: this.ncomp,
          impuesto: this.impuest,
          estado: 2
        })
        .then(res => {
          console.log(res);
        })
        .finally(() => {
          this.dialog = false;
          this.card1 = false;
          this.btncard = false;
        })
        .catch(e => {});
    },
 
    getpersonas() {
      axios
        .post("api/personas")
        .then(res => {
          this.personas = res.data;
          // console.log(res);
        })
        .finally(() => {})
        .catch(e => {});
    }
  },
  watch: {
    datatable(newdatos) {
      localStorage.venta = JSON.stringify(newdatos);
    },

    persona(val) {
      if (val) {
        let data = this.personas.filter(res => (res.id = val));
        this.proveedor = data[0].nombre;
        // console.log(data);
      }
    },
    articulo(val) {
      if (val) {
        let data = this.productos.filter(res => res.id == val);
        this.producto = data[0].nombre;
        this.codigoart = data[0].codigo;
        this.idproducto = data[0].id;
        //  console.log(data);
      }
    }
  },
  mounted() {
    if (localStorage.venta) {
      // this.consulta = atob(JSON.parse(localStorage.getItem("venta")));
      let venta = localStorage.getItem("venta");
      this.datatable = JSON.parse(venta);
    }
    if (!this.persona) {
      this.dialog = true;
    }
   
    this.getpersonas();
    this.articulos();
  }
};
</script>

<style>
</style>