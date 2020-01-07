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
                  label="Codigo articulo"
                ></v-text-field>
                <v-autocomplete
                  v-else
                  autofocus
                  :items="articulos"
                  item-text="nombre"
                  item-value="id"
                  type="text"
                  name="producto"
                  label="nombre clave articulo"
                  no-data-text="articulo no encontrado"
                ></v-autocomplete>
              </v-col>
              <v-col cols="6" sm="2" md="2">
                <v-text-field
                  centered
                  type="number"
                  label="cantidad"
                  v-model.number="und"
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
                <v-radio-group v-model="radios" :mandatory="false">
                  <v-radio color="success" label="pago" value="radio-1"></v-radio>
                  <v-radio color="warning" label="credito" value="radio-2"></v-radio>
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
              <v-icon color="red">mdi-delete</v-icon>
            </template>

            <template v-slot:item.impuesto="{ item }">
              <v-chip gray></v-chip>
            </template>
          </v-data-table>
          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="red" text>Terminar</v-btn>
          </v-card-actions>
        </v-card-text>
      </v-card>
    </v-container>
  </v-content>
</template>

<script>
export default {
  data: () => ({
    loading: false,
    //datos para gregar articulos a la tabla
    numcomp: 1001,
    tipocomp: "factura",
    cliente: 2,
    und: "",
    //-------------------------------------------
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
    radios: "radio-1"
  }),
  methods: {
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
      let data = this.articulosventa.filter(res => res.codigo == this.articulo);

      //
      let v = data.forEach(value => {
        let total = value.precio_venta * this.und;
        let newobj = {
          nombre: value.nombre,
          cantidad: this.und,
          codigo: value.codigo,
          total:total,
          precio_venta:value.precio_venta,
          idpersona:this.cliente,
          tipocomp:this.tipocomp,
          numcomp:this.numcomp
        };
        this.datatable.push(newobj);
        // console.log(value)
      });
    }
  },
  mounted() {
    this.getarticulos();
  }
};
</script>

<style>
</style>