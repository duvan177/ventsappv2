<template>
  <v-content>
    <v-container max-width="100% !imporant">
      <v-card>
    
        <v-card-text>
          <v-data-table
            :sort-by="'ordenar'"
            :loading="lgtable"
            :items="newdatatable"
            :headers="headers"
            :items-per-page="10"
            class="elevation-1"
          >
            <!-- <template v-slot:item.action="{ item }">
              <v-icon color="red" @click="remove(item)">mdi-delete</v-icon>
            </template>-->
            <template v-slot:item.nombreart="{ item }">{{item.articulo.nombre}}</template>
            <template v-slot:item.totaling="{ item }">{{showtotal(item)}}</template>
            <template v-slot:item.nombreprov="{ item }">{{item.proveedor.nombre}}</template>

            <template v-slot:item.articulo="{ item }">
              <v-chip gray>{{item.impuesto}}</v-chip>
            </template>
          </v-data-table>
          <v-card-actions>
            <div class="row">
              <v-col cols="12" md="4">
                <v-toolbar-title v-text="'Total ingreso: $'+eventoNum(totalingreso)"></v-toolbar-title>
              </v-col>
              <v-col cols="12" md="4">
                <v-toolbar-title v-text="' cant articulos: '+eventoNum(cantidadart)"></v-toolbar-title>
              </v-col>
            </div>
          </v-card-actions>
        </v-card-text>
      </v-card>
     
    </v-container>
  </v-content>
</template>

<script>
import VeLine from "v-charts/lib/line.common";
export default {
  components: { VeLine },
  props: ["iduser"],
  data: () => ({
    chartData: {
      columns: ["date", "valor"],
      rows: []
    },
    colorline: ["#db002c"],
  buscar:'',
  lgtable:false,

    // datos de la tabla de registros de ventas
newdatatable:[],
totalingreso:0,
    //-----------------------------------------------------

    headers: [
      {
        text: "Numero comprobante",
        align: "left",
        sortable: true,
        value: "num_comprobante"
      },

      { text: "Proveedor", value: "nombreprov" },
      { text: " tipo comprobante", value: "tipo_comprobante" },
      { text: "articulo", value: "nombreart" },
      { text: "Cantidad", value: "cantidad" },
      { text: "Impuesto", value: "impuesto" },
      { text: "Precio compra", align: "right", value: "precio_compra" },
      { text: "Precio venta", align: "right", value: "precio_venta" },
      { text: "Total", align: "right", value: "totaling" },
      { text: "fecha de ingreso", value: "created_at" }

      //   { text: "Acciones", value: "action", align: "center" }
    ],
    labels: [],
    value: [200, 675, 410, 390, 310, 460, 250, 240],
    values: []
  }),
  methods: {
      eventoNum(){},
      cantidadart(){},
    getimgresos() {
      this.lgtable = true;
      axios
        .post("api/all-ingresos")
        .then(res => {
          this.datatable = res.data;

          console.log(res);
        })
        .finally(() => {
         
        })
        .catch(e => {});

      axios
        .post("api/articulos")
        .then(res => {
          this.articulosventa = res.data;
          // console.log(res);
        })
        .finally(() => (this.lgtable = false))
        .catch(e => {});
    }
  },
  mounted() {
    this.getimgresos();
  },
  watch: {
    buscar(val) {
    //   const newarray = this.datatable.filter(
    //     obj => obj.num_comprobante == val.toString()
    //   );
    //   if (newarray.length >= 1) {
    //     this.newdatatable = newarray;
    //   } else {
    //     this.newdatatable = this.datatable;
    //   }
    },
    newdatatable(val) {
    //   let total = 0;
    //   let cant = 0;
    //   val.forEach(element => {
    //     cant += element.cantidad;
    //     total += parseInt(element.precio_compra) * parseInt(element.cantidad);
    //   });
    //   this.totalingreso = total;
    //   this.cantidadart = cant;
    //   console.log(total);
    }
  }
};
</script>

<style>
.v-sheet--offset {
  top: -24px;
  position: relative;
}
</style>