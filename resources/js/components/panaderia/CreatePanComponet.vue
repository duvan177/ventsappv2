<template>
    <v-content>
        <v-container max-width="100% !imporant">
            <v-card>
                <v-card-title primary-title>
                    Gestión Panaderia
                </v-card-title>
                <v-card-title primary-title>
                    <div class="row">
                        <v-col cols="12" md="12" lg="3">
                            <v-select
                                v-model="pan"
                                :items="panes"
                                item-text="nombre"
                                item-value="id"
                                menu-props="auto"
                                label="Seleccione"
                                hide-details
                                prepend-icon="mdi-plus-circle"
                                :rules="[
                                    () => pan != null || 'Campo requerido'
                                ]"
                                single-line
                                :loading="selectlg"
                            ></v-select>
                        </v-col>
                        <v-col cols="6" md="6" lg="2">
                            <v-text-field
                                label="Cantidad"
                                outlined
                                v-model="cantidad"
                                :rules="[
                                    () =>
                                        cantidad.length > 0 || 'Campo requerido'
                                ]"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6" md="6" lg="2">
                            <v-btn @click="adddata()" color="success"
                                >Añadir</v-btn
                            >
                        </v-col>
                    </div>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="addpanes"
                    :items-per-page="5"
                    class="elevation-1"
                >
                    <template v-slot:item.opcion="{ item }">
                        <v-icon color="red" @click="remove(item)"
                            >mdi-delete</v-icon
                        >
                    </template>
                </v-data-table>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red"
                        text
                        @click="setpanes()"
                        :loading="savepanlg"
                        >Terminar
                        <v-icon>mdi-checkbox-marked-circle-outline</v-icon>
                    </v-btn>
                </v-card-actions>
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
        </v-container>
    </v-content>
</template>

<script>
export default {
    data() {
        return {
            savepanlg: false,
            selectlg: false,
            cantidad: "",
            headers: [
                {
                    text: "Codigo",
                    align: "left",

                    value: "codigo"
                },
                { text: "Nombre", value: "nombre" },
                { text: "Cantidad", value: "cantidad" },
                { text: "Descripcion", value: "Descripcion" },
                { text: "Fecha", value: "fecha" },
                { text: "Opciones", value: "opcion" }
            ],
            snackbar: false,
            panes: [],
            addpanes: [],
            pan: null,
            x: "right",
            y: "top",
            color: "",
            timeout: 4000,
            mode: "",
            text: ""
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
                const index = this.addpanes.indexOf(obj);
                this.addpanes.splice(index, 1);
                let msg = ["eliminado", "success"];
                this.notificacion(msg);
            }
        },
        filterdata(obj) {
            return obj.id == this.pan;
        },
        adddata() {
            if ((this.pan, this.cantidad)) {
                let val = this.addpanes.find(element => element.id == this.pan);

                // console.log(val);
                if (!val) {
                    let arr = this.panes.filter(arr => arr.id == this.pan);
                    let _arr = [];
                    let date = new Date();
                    let newarr = {
                        Descripcion: arr[0].descripcion,
                        codigo: arr[0].codigo,
                        id: arr[0].id,
                        nombre: arr[0].nombre,
                        cantidad: this.cantidad,
                        fecha: this.formatdate(date)
                    };

                    this.addpanes.push(newarr);
                    this.addpanes.reverse();
                } else {
                    let msg = ["articulo ya ingresado", "error"];
                    this.notificacion(msg);
                }

                this.pan = null;
                this.cantidad = "";
            } else {
                let msg = ["Ingrese los campos requeridos", "error"];
                this.notificacion(msg);
            }
        },
        getPanes() {
            this.selectlg = true;
            axios
                .post("api/set-pan")
                .then(res => {
                    console.log(res);
                    this.panes = res.data;
                })
                .finally(() => (this.selectlg = false))
                .catch(err => {
                    console.error(err);
                });
        },
        setpanes() {
            this.savepanlg = true;
            axios
                .post("api/save-pan", {
                    data: this.addpanes
                })
                .then(res => {
                    let msg = ["Guardado", "success"];
                    this.notificacion(msg);
                    this.addpanes = [];
                    // console.log(res);
                })
                .finally(() => {
                    this.savepanlg = false;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        formatdate(current_datetime) {
            let formatted_date =
                current_datetime.getFullYear() +
                "-" +
                (current_datetime.getMonth() + 1) +
                "-" +
                current_datetime.getDate() +
                " " +
                current_datetime.getHours() +
                ":" +
                current_datetime.getMinutes() +
                ":" +
                current_datetime.getSeconds();
                return formatted_date;
        }
    },
    mounted() {
        this.getPanes();
    }
};
</script>

<style></style>
