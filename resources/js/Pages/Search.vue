<template>
    <GeneralLayout>
        <Snackbar :timeout="snackbar.timeout" :text="snackbar.text" :type="snackbar.type"
                  :show="snackbar.status" @closeSnackbar="snackbar.status = false"></Snackbar>

        <v-container>

            <v-card>
                <v-card-title>
                        <span>
                        </span>
                    <span class="text-h5">Buscar libros</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <template>
                                    <v-text-field
                                        label="Escriba el código, título, autor o editorial del libro que te interesa"
                                        ref="search"
                                        outlined
                                        dense
                                        v-model="input"
                                        @keyup.enter="searchBooks"
                                    ></v-text-field>
                                </template>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn
                        class="white--text"
                        text
                        @click="searchBooks"
                        style="border-radius: 20px; background-color: #FF6F00 ;padding: 10px 50px 10px 50px"
                    >
                        Buscar
                    </v-btn>
                </v-card-actions>
            </v-card>


            <div style="margin-top: 50px">
            <h2 style="text-align: center"> {{this.message}} </h2>
            <v-card  class="mt-2"  v-if="books.length>0">
                <v-data-table
                    loading-text="Cargando, por favor espere..."
                    no-results-text="No hay resultados que coincidan con tu búsqueda, intenta nuevamente"
                    :headers="headers"
                    :items="books"
                    disable-pagination
                    hide-default-footer
                    class="elevation-1"
                >

                </v-data-table>
            </v-card>
            </div>

        </v-container>


    </GeneralLayout>
</template>

<script>
import GeneralLayout from "@/Layouts/GeneralLayout";
import {Link} from '@inertiajs/inertia-vue';
import {prepareErrorText, showSnackbar} from "@/HelperFunctions"
import Snackbar from "@/Components/Snackbar.vue"



export default {
    components: {
        Link,
        GeneralLayout,
        Snackbar
    },

    data: () => ({

        headers:[
            {text: 'Libro', value: 'title'},
            {text: 'Autor', value: 'author', sortable: false},
            {text: 'Código', value: 'identifier', sortable: false, width:'15%'},
            {text: 'Precio', value: 'price', width:'15%'},
            {text: 'Editorial', value: 'publisher', sortable: false},
        ],

        snackbar: {
            text: '...',
            status: false,
            timeout: 3000
        },

        message: "",
        books:[],

        lastInput: "",
        isLoading:true,
        input:"",
        isLogged: false
    }),

    created() {
        this.isLogged = this.$page.props.user.email !== undefined;
    },

    methods:{

        async searchBooks(){

            if(this.input !== "" && this.input !== this.lastInput){
                let data = {search:this.input}
                try {
                    this.lastInput = this.input;
                    let request = await axios.get(route('api.bookList.index', data));
                    this.books = request.data;
                    if(this.books.length > 0){
                        this.message = "Resultados encontrados";
                    }
                    else {
                        this.message = "No se han encontrado resultados que coincidan con tu búsqueda."
                    }
                } catch (e) {
                    showSnackbar(this.snackbar, e.response.data.message, 'alert', 12000);
                }
            }
        }
    }
}
</script>
<style>
.active-button {
    color: #FAFAFA !important;
}
</style>
