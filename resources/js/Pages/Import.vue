<template>
    <GeneralLayout>
        <Snackbar :timeout="snackbar.timeout" :text="snackbar.text" :type="snackbar.type"
                  :show="snackbar.status" @closeSnackbar="snackbar.status = false"></Snackbar>

        <v-container>

            <v-card>
                <v-card-title>
                        <span>
                        </span>
                    <span class="text-h5">Añadir base de libros</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <template>
                                    <v-file-input
                                        label="Click aquí para agregar el archivo (formato excel)"
                                        ref="inputFile"
                                        outlined
                                        dense
                                        @change="onFileChanged"
                                    ></v-file-input>
                                    <h3 style="margin-top: 10px; text-align: center"> {{this.loadingMessage}} </h3>
                                </template>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        style="background-color: #db5523"
                        class="white--text"
                        text
                        @click="cancelUpload"
                    >
                        Cancelar
                    </v-btn>
                    <v-btn
                        style="background-color: #db5523"
                        class="white--text"
                        text
                        @click="updateBooksInformation"
                    >
                        Confirmar
                    </v-btn>
                </v-card-actions>
            </v-card>
<!--


            <div class="d-flex flex-column align-end mb-7">
                <h2 class="align-self-start">Importador base de libros</h2>
                <div>
                    <v-btn
                        color="primario"
                        class="grey&#45;&#45;text text&#45;&#45;lighten-4 ml-4"
                        @click="handleFileImport"
                    >
                        Cargar base
                    </v-btn>


                    &lt;!&ndash; Create a File Input that will be hidden but triggered with JavaScript &ndash;&gt;
                    <input
                        ref="uploader"
                        class="d-none"
                        type="file"
                        name="booksList"
                        @change="onFileChanged"
                    >

                </div>
            </div>
-->

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
        snackbar: {
            text: '...',
            status: false,
            timeout: 3000
        },

        loadingMessage: '',
        selectedFile: null,

        isLogged: false
    }),

    created() {
        this.isLogged = this.$page.props.user.email !== undefined;
    },

    methods:{

        cancelUpload(){
            this.$refs.inputFile.reset();
        },

        async onFileChanged(e) {
            console.log(e, "info obtenida");
            if (e === null){
                return;
            }
            this.selectedFile = e;
        },

        async updateBooksInformation(){

            if (this.selectedFile !== null){
                const file = new FormData();
                file.append("books", this.selectedFile)
                this.loadingMessage = "Por favor espera mientras se actualiza la lista de libros, no recargues ni cierres la página";

                try {
                    let request = await axios.post(route('api.bookList.store'), file,
                        {headers:{'content-type': 'multipart/form-data'}});
                    showSnackbar(this.snackbar, request.data.message, 'success', 7000);
                } catch (e) {
                    showSnackbar(this.snackbar, e.response.data.message, 'alert', 12000);
                }
                this.$refs.inputFile.reset();
                this.loadingMessage = "";
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
