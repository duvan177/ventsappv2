<template>
  <v-content>
    <v-container max-width="100% !imporant">
      <v-card>
        <v-card-subtitle style="background:#1565c0;color: white;">
          <h2>
            ingresos
            <v-icon size="45" color="white">mdi-garage</v-icon>
          </h2>
          <v-spacer></v-spacer>
          <!-- <v-col cols="6" sm="6">
            <v-select :items="['0-17', '18-29', '30-54', '54+']" label="Age*" required></v-select>
          </v-col>-->
        </v-card-subtitle>
        <v-card-text transition="scale-transition">
          <v-container>
            <div class="row">
              <v-row></v-row>
            </div>
          </v-container>
          <small>*Historia grafica de los ultimos 7 dias</small>
          <v-card-actions></v-card-actions>
        </v-card-text>
        <ve-line :data="chartData" :colors="colorline"></ve-line>
        <v-card-text class="mx-auto text-center">
          <div justify-center class="row">
            <v-col class cols="12" md="6">
              <v-card color="primary" height="130%">
                <v-toolbar-title
                  style="color: white;"
                  v-text="'Total ingreso: $'+eventoNum(totalingreso)"
                ></v-toolbar-title>
              </v-card>
            </v-col>
            <v-col cols="12" md="6">
              <v-card color="primary" height="130%">
                <v-toolbar-title
                  style="color: white;"
                  v-text="' cant articulos: '+eventoNum(cantidadart)"
                ></v-toolbar-title>
              </v-card>
            </v-col>
          </div>
        </v-card-text>
        <!-- <v-sheet 
          class="v-sheet--offset mx-auto"
          color="cyan"
          elevation="12"
          max-width="calc(100% - 22px)"
        >
          <v-sparkline  :smooth="7" :label-size="4" :labels="labels" :value="values" color="white" line-width="2" padding="16"></v-sparkline>
        </v-sheet>-->
        <v-card-title>
          <div class="row">
            <v-col cols="12" md="6">Detalle de ingresos</v-col>
            <v-col cols="12" md="3">
              <v-btn @click="busq=true" class="ma-2" text icon>
                <v-icon>mdi-magnify</v-icon>avanzada
              </v-btn>
            </v-col>
            <v-col cols="12" md="3">
              <v-text-field
                v-model="buscar"
                append-icon="mdi-magnify"
                label="Buscar por comprobante"
                single-line
                hide-details
              ></v-text-field>
            </v-col>
          </div>
        </v-card-title>
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
      <v-dialog
        v-model="busq"
        scrollable
        :overlay="false"
        max-width="700px"
        transition="dialog-transition"
      >
        <v-card>
          <v-toolbar flat color="primary" dark>
            <v-toolbar-title>
              Busqueda avanzada
              <v-icon>mdi-calendar-question</v-icon>
            </v-toolbar-title>
          </v-toolbar>
          <v-tabs vertical>
            <v-tab>
              <v-icon left>mdi-account</v-icon>Rango
            </v-tab>
            <v-tab>
              <v-icon left>mdi-lock</v-icon>fecha
            </v-tab>
            <v-tab>
              <v-icon left>mdi-access-point</v-icon>Option 3
            </v-tab>

            <v-tab-item>
              <v-card flat>
                <v-card-text>
                  <div class="row">
                    <v-col cols="12" md="4">
                      <v-menu
                        ref="menu1"
                        v-model="menu1"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="date1"
                            label="fecha inicio"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="date1" no-title scrollable locale="es-co">
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu1 = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu1.save(date)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>

                    <v-col cols="12" md="4">
                      <v-menu
                        ref="menu2"
                        v-model="menu2"
                        :close-on-content-click="false"
                        :return-value.sync="date"
                        transition="scale-transition"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="date2"
                            label="fecha fin"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker v-model="date2" no-title scrollable locale="es-co">
                          <v-spacer></v-spacer>
                          <v-btn text color="primary" @click="menu2 = false">Cancel</v-btn>
                          <v-btn text color="primary" @click="$refs.menu2.save(date)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-col>
                  </div>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item>
              <v-card flat>
                <v-card-text></v-card-text>
              </v-card>
            </v-tab-item>
            <v-tab-item>
              <v-card flat>
                <v-card-text></v-card-text>
              </v-card>
            </v-tab-item>
          </v-tabs>
        </v-card>
      </v-dialog>
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
    buscar: "",
    desc: true,
    loading: false,
    snackbar: false,
    x: "right",
    y: "top",
    color: "",
    timeout: 4000,
    mode: "",
    text: "",
    //datos para gregar articulos a la tabla

    //-------------------------------------------
    // datos para la busqueda avanzada
    busq: false,
    date1: new Date().toISOString().substr(0, 10),
     date2: new Date().toISOString().substr(0, 10),
    menu1: false,
    modal: false,
    menu2: false,
    // ---------------------------------------------
    lgtable: false,
    newdatatable: [],
    datatable: [],
    totalingreso: "",
    cantidadart: 0,
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
    blokdesc() {
      alert("desbloquear");
    },
    alltotal(item) {},
    coversionfecha() {
      var fecha = new Date();
      let ingresos = [];
      let day = 0;
      this.datatable.forEach(element => {
        let fechas = element.created_at;
        ingresos.push(fechas.substring(0, 10));
      });

      const unique = (value, index, self) => {
        return self.indexOf(value) === index;
      };
      const uniqueAges = ingresos.filter(unique);
      const newarr = uniqueAges.reverse();
      newarr.forEach(element => {
        if (day <= 6) {
          this.validation(element);
          day++;
        }
      });
      // this.labels = uniqueAges;
      //  console.log(uniqueAges);
    },
    validation(obj) {
      // console.log(obj);
      let data = [];
      this.datatable.forEach(element => {
        let fechas = element.created_at;
        let fecha = fechas.substring(0, 10);
        if (fecha.substring(0, 10) == obj) {
          data.push(element);
          // console.log(fecha);
        } else {
          // console.log("no esta validando");
        }
      });
      this.calcular(data);
    },
    calcular(obj) {
      let total = 0;
      let fecha = obj[0].created_at;
      obj.forEach(element => {
        total += parseInt(element.precio_compra) * element.cantidad;
      });
      let data = { date: fecha.substring(0, 10), valor: total };
      this.chartData.rows.push(data);
      console.log(obj);
    },
    showtotal(obj) {
      let total = 0;
      total = parseInt(obj.precio_compra) * obj.cantidad;
      return total;
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
    getimgresos() {
      this.lgtable = true;
      axios
        .post("api/all-ingresos")
        .then(res => {
          this.datatable = res.data;

          console.log(res);
        })
        .finally(() => {
          this.loading = false;
          this.newdatatable = this.datatable;
          this.coversionfecha();
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
      const newarray = this.datatable.filter(
        obj => obj.num_comprobante == val.toString()
      );
      if (newarray.length >= 1) {
        this.newdatatable = newarray;
      } else {
        this.newdatatable = this.datatable;
      }
    },
    newdatatable(val) {
      let total = 0;
      let cant = 0;
      val.forEach(element => {
        cant += element.cantidad;
        total += parseInt(element.precio_compra) * parseInt(element.cantidad);
      });
      this.totalingreso = total;
      this.cantidadart = cant;
      console.log(total);
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