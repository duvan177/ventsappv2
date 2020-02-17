<template>
    <v-app id="inspire">
        <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            primary
            app
        >
            <v-list nav dense>
                <template v-for="item in items">
                    <v-row
                        v-if="item.heading"
                        :key="item.heading"
                        align="center"
                    >
                        <v-col cols="6">
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-col>
                        <v-col cols="6" class="text-center">
                            <a href="#!" class="body-2 black--text">EDIT</a>
                        </v-col>
                    </v-row>
                    <v-list-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :prepend-icon="
                            item.model ? item.icon : item['icon-alt']
                        "
                        append-icon=""
                    >
                        <template v-slot:activator>
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ item.text }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <v-list-item
                            v-for="(child, i) in item.children"
                            :key="i"
                            link
                        >
                            <v-list-item-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content @click="menu = child.nun">
                                <v-list-item-title>
                                    {{ child.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                    <v-list-item
                        v-else
                        :key="item.text"
                        link
                        @click="menu = item.nun"
                    >
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="blue darken-3"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
                <span class="hidden-sm-and-down">VentsApp</span>
            </v-toolbar-title>

            <v-spacer />
            <v-btn icon>
                <v-icon>mdi-apps</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>mdi-bell</v-icon>
            </v-btn>
    
            <v-menu
                v-model="cerrar"
                :close-on-content-click="false"
                :nudge-width="200"
            >
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-avatar item>
                            <v-icon size="32px">mdi-account-circle</v-icon>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar>
                                <img
                                    src="https://cdn.vuetifyjs.com/images/john.jpg"
                                    alt="John"
                                />
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>User</v-list-item-title>
                                <v-list-item-subtitle
                                    >Tienda Tutipandebono</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list>
                        <v-list-item>
                            <v-list-item-action>
                                <v-btn color="error" @click="cerrars()"
                                    ><v-icon>mdi-power</v-icon></v-btn
                                >
                            </v-list-item-action>
                            <v-list-item-title
                                >Cerrar session</v-list-item-title
                            >
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </v-app-bar>
  <form action="../logout" method="post">
               <input type="hidden" name="_token" :value="csrf">
                    <button ref="submib" type="hidden"></button>
                  </form>
        <template v-if="menu == 0">
            <transition name="component-fade" mode="out-in">
                <venta-component v-bind:iduser="id"></venta-component>
            </transition>
        </template>

        <template v-if="menu == 1">
            <transition name="component-fade" mode="out-in">
                <nav-component></nav-component>
            </transition>
        </template>

        <template v-if="menu == 3">
            <transition name="component-fade" mode="out-in">
                <alimentos-component></alimentos-component>
            </transition>
        </template>
        <template v-if="menu == 4">
            <transition name="component-fade" mode="out-in">
                <dataingresos-component></dataingresos-component>
            </transition>
        </template>
        <template v-if="menu == 5">
            <transition name="component-fade" mode="out-in">
                <dataventas-component></dataventas-component>
            </transition>
        </template>
        <template v-if="menu == 6">
            <transition name="component-fade" mode="out-in">
                <listpan-component></listpan-component>
            </transition>
        </template>
        <template v-if="menu == 7">
            <transition name="component-fade" mode="out-in">
                <createpan-component></createpan-component>
            </transition>
        </template>
        <template v-if="menu == 8">
            <transition name="component-fade" mode="out-in">
                <ingresospan-component></ingresospan-component>
            </transition>
        </template>
        <template v-if="menu == 9">
            <transition name="component-fade" mode="out-in">
                <listbaja-component></listbaja-component>
            </transition>
        </template>
               <template v-if="menu == 10">
            <transition name="component-fade" mode="out-in">
                <balance-component></balance-component>
            </transition>
        </template>
                <template v-if="menu == 11">
            <transition name="component-fade" mode="out-in">
                <resumen-component></resumen-component>
            </transition>
        </template>

     

        <v-btn
            bottom
            color="pink"
            dark
            fab
            fixed
            right
            @click="dialog = !dialog"
        >
            <v-icon>mdi-plus</v-icon>
        </v-btn>
        <v-dialog v-model="dialog" width="800px">
            <v-card>
                <v-card-title class="grey darken-2">
                    Create contact
                </v-card-title>
                <v-container>
                    <v-row class="mx-2">
                        <v-col
                            class="align-center justify-space-between"
                            cols="12"
                        >
                            <v-row align="center" class="mr-0">
                                <v-avatar size="40px" class="mx-3">
                                    <img
                                        src="//ssl.gstatic.com/s2/oz/images/sge/grey_silhouette.png"
                                        alt=""
                                    />
                                </v-avatar>
                                <v-text-field placeholder="Name" />
                            </v-row>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                prepend-icon="business"
                                placeholder="Company"
                            />
                        </v-col>
                        <v-col cols="6">
                            <v-text-field placeholder="Job title" />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                prepend-icon="mail"
                                placeholder="Email"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                type="tel"
                                prepend-icon="phone"
                                placeholder="(000) 000 - 0000"
                            />
                        </v-col>
                        <v-col cols="12">
                            <v-text-field
                                prepend-icon="notes"
                                placeholder="Notes"
                            />
                        </v-col>
                    </v-row>
                </v-container>
                <v-card-actions>
                    <v-btn text color="primary">More</v-btn>
                    <v-spacer />
                    <v-btn text color="primary" @click="dialog = false"
                        >Cancel</v-btn
                    >
                    <v-btn text @click="dialog = false">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
export default {
    props: ["id"],
    data: () => ({
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        cerrar: false,
        iduser: null,
        menu: 0,
        dialog: false,
        drawer: null,
        resp: false,
        items: [
            { icon: "mdi-home", text: "Ventas", nun: 0 },
            { icon: "mdi-food", text: "Ingresos", nun: 1 },
            { icon: "mdi-content-copy", text: "Panaderia", nun: 7 },

            {
                icon: "mdi-chevron-up",
                "icon-alt": "mdi-chevron-down",
                text: "Productos",
                nun: 2,
                model: false,
                children: [
                    { text: "Almacen", nun: 3 },

                    { text: "Panadera", nun: 6 },
                    { text: "Productos dados de baja", nun: 9 },

                    { text: "Other contacts", nun: 1 }
                ]
            },
            {
                icon: "mdi-chevron-up",
                "icon-alt": "mdi-chevron-down",
                text: "Informes",
                nun: 2,
                model: false,
                children: [
                    { text: "Ingresos", nun: 4 },

                    { text: "Ventas", nun: 5 },
                    { text: "Ingresos pan", nun: 8 },
                     { text: "Balances", nun: 10 },
                       { text: "Resumen Balances", nun: 11 }
                ]
            },
            { icon: "mdi-settings", text: "Configuracion" },
            { icon: "mdi-message", text: "Usuarios" },
            { icon: "mdi-help-circle", text: "Help" }
        ]
    }),
    methods:{
  cerrars(){
          this.$refs.submib.click();
        }
    },
    watch: {
        menu() {
            if (this.resp) {
                this.drawer = false;
            }
        },
      
    },
    mounted() {
        console.log(this.id);
        this.iduser = this.id;
        if (screen.width <= 600) {
            this.resp = true;
        }
    }
};
</script>

<style>
.component-fade-enter-active,
.component-fade-leave-active {
    transition: opacity 0.3s ease;
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active for <2.1.8 */ {
    opacity: 0;
}
.menus.v-menu__content {
    right: 10px !important ;
    left: 0px !important;
}
</style>
