<template>
  <v-content>
    <v-container max-width="100% !imporant">
      <v-card>
        <v-card-title>
          Productos
          <v-spacer></v-spacer>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-card-title>
        <v-skeleton-loader
          :loading="loading"
          :transition="transition"
          height="94"
          type="list-item-two-line"
        >
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left title">Codigo</th>
                  <th class="text-left title">Producto</th>
                  <th class="text-left title">Categoria</th>
                  <th class="text-left title">Stock</th>
                  <th class="text-left title">Estado</th>
                  <th class="text-left title">Descripcion</th>
                  <th class="text-left title">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in desserts" :key="item.name">
                  <td class="subtitle-1">{{ item.codigo }}</td>
                  <td class="subtitle-1">{{ item.nombre }}</td>
                  <td class="subtitle-1">{{ item.idcategoria }}</td>
                  <td class="subtitle-1">{{ item.stock }}</td>

                  <td class="subtitle-1" v-if="item.estado == 1">
                    <v-chip class="ma-2" color="teal" text-color="white">
                      <v-avatar left>
                        <v-icon>mdi-checkbox-marked-circle</v-icon>
                      </v-avatar>Estable
                    </v-chip>
                  </td>

                  <td class="subtitle-1" v-if="item.estado == 2">
                    <v-chip class="ma-2" color="amber " text-color="white">
                      <v-avatar left>
                        <v-icon>mdi-alert-outline</v-icon>
                      </v-avatar>Bajo
                    </v-chip>
                  </td>
                  <td class="subtitle-1" v-if="item.estado == 3">
                    <v-chip class="ma-2" color="red darken-3" text-color="white">
                      <v-avatar left>
                        <v-icon>mdi-cancel</v-icon>
                      </v-avatar>Agotado
                    </v-chip>
                  </td>
                  <td class="subtitle-1" v-if="item.estado == 4 ">
                    <v-chip class="ma-2" color="deep-purple " text-color="white">
                      <v-avatar left>
                        <v-icon>mdi-cart-off</v-icon>
                      </v-avatar>Icnativo
                    </v-chip>
                  </td>
                  <td class="subtitle-1">{{ item.descripcion }}</td>
                  <td class="subtitle-1">
                    <v-btn text icon color="gray" @click="dialogo(item)">
                      <v-icon>mdi-tooltip-edit</v-icon>
                    </v-btn>
                    <v-btn text icon color="red"  @click="[ delet = true , id_delete = item.id]" >
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-skeleton-loader>
        <v-card-actions></v-card-actions>
      </v-card>
      <v-dialog v-model="dialog" max-width="690">
        <v-card ref="mecard">
          <v-card-title>
            <span class="headline">Articulo</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field label="Nombre del articulo" v-model="nombreart" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="codigo"
                    v-model="codigoart"
                    hint="example of helper text only on focus"
                    v-bind:value="arti.codigo"
                  ></v-text-field>
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
                    v-model="pcompra"
                    ref="compra"
                    label="Precio compra"
                    type="number"
                    required
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
                    :selected=" estados.id === arti.estado"
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
            <v-btn color="blue darken-1" text @click="dialog = false">Cancelar</v-btn>
            <v-btn color="blue darken-1" text @click="saveart()">Guardar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="500px" transition="dialog-transition">
        <v-card color="primary" dark>
          <v-card-text>
            Please stand by
            <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog v-model="delet" persistent max-width="290">

      <v-card>
        <v-card-title  class="headline align-center" color="primary">   <v-icon>mdi-delete</v-icon></v-card-title>
        <v-card-text >¿Eliminar articulo?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="delet = false">cancelar</v-btn>
          <v-btn color="green darken-1" text @click=" deleteart">ok</v-btn>
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
        {{text}}
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
      delet:false,
      id_delete:'',
      arti: [],
      estados: [
        { id: 1, nombre: "Estable" },
        { id: 2, nombre: "Bajo" },
        { id: 3, nombre: "Agotado" },
        { id: 4, nombre: "Inactivo" }
      ],

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
        notificacion(msg){
      this.text = msg[0];
      this.color = msg[1];
      this.snackbar = true;
    },
    dialogo(arti) {
      this.id = arti.id;
      this.dialog = true;
      this.nombreart = arti.nombre;
      this.codigoart = arti.codigo;
      this.descripart = arti.descripcion;
      this.pcompra = arti.precio_compra;
      this.pventa = arti.precio_venta;
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
    saveart() {
      let meth = this;
      axios
        .post("api/update-art", {
          id: this.id,
          idcategoria: this.categoriaart,
          codigo: this.codigoart,
          nombre: this.nombreart,
          stock: this.stock,
          descripcion: this.descripart,
          estado: this.estado
        })
        .then(res => {
              meth.articulos();                                                                                               
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
          this.dialog=false;
           let msg = ['articulo actualizado','success'];
            this.notificacion(msg);
        })
        .catch(e => {
          console.log(e);
        });
    },
    deleteart() {
      
        let meth = this;
      axios
        .post("api/delete-art",{
          id:this.id_delete,
          artdelete:2
        })
        .then(res => {
       meth.articulos();    
          console.log(res);
        })
        .finally(() => {
          this.delet = false
        })
        .catch(e => {});
   
    }
  },
  mounted() {
    this.articulos();
    setTimeout(() => {}, 3000);
  }
};
</script>

<style>
</style>