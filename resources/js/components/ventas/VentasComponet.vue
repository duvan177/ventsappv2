<template>
  <v-content>
    <v-container max-width="100% !imporant">
      <v-card>
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
        <v-card-text transition="scale-transition">
          <v-container>
            <div class="row">
              <v-col cols="6" sm="6" md="4">
                <v-select
                  v-model="tipocomp"
                  prepend-icon="mdi-file-document"
                  :items="['factura', 'recibo de caja',]"
                  label="T. comprobante"
                  required
                ></v-select>
              </v-col>
              <v-col cols="6" sm="6" md="4">
                <v-text-field readonly v-model="numcomp" label="N. Comprobante" id="id"></v-text-field>
              </v-col>
            </div>
            <v-row>
              <v-col cols="2" md="1">
                <v-btn text icon color="error" @click="tipobusq = !tipobusq ">
                  <v-icon>mdi-priority-low</v-icon>
                </v-btn>
              </v-col>
              <v-col cols="10" sm="6" md="4">
                <v-text-field
                  v-if="tipobusq"
                  autofocus
                  clearable
                  v-model="articulo"
                  type="number"
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

              <v-col cols="6" sm="3">
                <v-select
                  v-model="cliente"
                  item-text="nombre"
                  item-value="id"
                  :items="clientes"
                  label="persona"
                  required
                ></v-select>
              </v-col>
              <v-col cols="6" sm="2" md="2">
                <v-radio-group v-model="estado" :mandatory="false">
                  <v-radio color="success" label="pago" :value="1"></v-radio>
                  <v-radio color="warning" label="credito" :value="2"></v-radio>
                </v-radio-group>
              </v-col>
            </v-row>
          </v-container>
          <small>*todos los campos son requeridos</small>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text>Limpiar</v-btn>
            <v-btn color="blue darken-1" text @click="addarticulo()">Agregar</v-btn>
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
              <v-icon color="red"  @click="remove(item)">mdi-delete</v-icon>
            </template>

            <template v-slot:item.impuesto="{ item }">
              <v-chip gray></v-chip>
            </template>
          </v-data-table>
          <v-card-actions>
            <h3 v-text="'Total: '+eventoNum(total_venta)"></h3>
            <v-spacer></v-spacer>

            <v-btn color="red" @click="sendventa" text>Terminar</v-btn>
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
   props: ['iduser'],
  data: () => ({
 
    loading: false,
    snackbar: false,
    x: "right",
    y: "top",
    color: "",
    timeout: 4000,
    mode: "",
    text: "",
    //datos para gregar articulos a la tabla
    numcomp: 1001,
    tipocomp: "factura",
    cliente: 2,
    und: 1,
    //-------------------------------------------
    impuesto:19,
    descuento:0,
    total_venta:0,
    estado:1,
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
    articulo: "",
   
  }),
  methods: {

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
    addarticulo() {
      let th = this;
      let promise = new Promise(resolve => resolve("¡Éxito!"));
      if (this.articulo && this.und) {
        let data = this.articulosventa.filter(
          res => res.codigo == this.articulo
        );

        let v = data.forEach(value => {
          let total = parseInt(value.precio_venta) *this.und;
          //  th.total_venta = th.total_venta + total;
          let newobj = {
            nombre: value.nombre,
            idarticulo: value.id,
            cantidad: this.und,
            codigo: value.codigo,
            total: total,
            precio_venta: value.precio_venta,
            idventa:null,
            descuento:null
          };
          this.datatable.push(newobj);
          // console.log(value)
          this.articulo = '';
          this.und = 1;
          this.$refs.art.focus();
        });

      } else {
        let msg = ["complete los datos requeridos", "error"];
        this.notificacion(msg);
      }
    },
    sendventa() {
      let mt = this;
      axios
        .post("api/create-venta", {
          idcliente:this.cliente,
          tipo_comprobante:this.tipocomp,
          num_comprobante:this.numcomp,
          impuesto:this.impuesto,
          descuento:this.descuento,
          total_venta:this.total_venta,
          estado:this.estado,
          serie_comprobante:'F',
          user_id:this.iduser,
          detalles:this.datatable
          })
        .then(res => {
          // this.articulos = res.data;
          console.log(res);
          mt.seddetalleventa();
        })
        .finally(() => (this.loading = false))
        .catch(e => {});
    },
    seddetalleventa() {
      axios
        .post("api/create-detalle-venta")
        .then(res => {
          // this.articulos = res.data;
          console.log(res);
          let msg = ["venta registrada", "success"];
          this.notificacion(msg);
        })
        .finally(() => (this.loading = false))
        .catch(e => {});
    }
  },
  mounted() {
      console.log( this.iduser)
    this.getarticulos();
  },
  watch:{
    datatable(val){
      let total = 0;
      val.forEach(element => {
         total += parseInt(element.precio_venta);
      });
      this.total_venta = total;
      console.log(total);
    }
  }
};
</script>

<style>
</style>