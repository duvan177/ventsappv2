<template>
    <v-content>
        <v-container max-width="100% !imporant">
            <v-card>
                        <v-card-title primary-title>
                    lista de productos con baja - Panaderia
                </v-card-title>
                <v-card-text>
                    <v-layout wrap>
                        <v-flex xs12 md8> </v-flex>
                        <v-flex xs12 md4>
                            <v-text-field
                                append-icon="mdi-magnify"
                                v-model="search"
                                placeholder="Buscar"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-data-table
                
                    :headers="headers"
                    :items="eldata"
                    :items-per-page="5"
                    class="elevation-1"
                    pagination.sync="pagination"
                    item-key="id"
                    :search="search"
                >
                     <template v-slot:item.pu="{ item }">
                       
                        {{ covert(item) }}
                    </template>
                </v-data-table>
            </v-card>
        </v-container>
    </v-content>
</template>

<script>
export default {
    data: () => ({
        eldata: [],
        search: "",
        headers: [
            {
                text: "Codigo",
                align: "left",
                sortable: true,
                value: "codigo"
            },

            { text: "nombre", value: "nombre" },
            { text: "cantidad", value: "cantidad" },

            { text: " Precio (und)", value: "pu" },

            { text: "Total", value: "total" },

            { text: "fecha", value: "created_at", align: "center" }
        ]
    }),
    methods: {
        getbaja() {
            axios
                .post("api/list-baja-pan")
                .then(res => {
                    // console.log(res);
                    this.eldata = res.data;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        covert(obj){
            let total = parseInt(obj.total)/ parseInt( obj.cantidad);
            return total;
        }
    },
    mounted(){
        this.getbaja();
    }
};
</script>

<style></style>
