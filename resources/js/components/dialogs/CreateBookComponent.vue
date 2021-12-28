<template>
    <div>
        <v-dialog
            v-model="dialog"
            transition="dialog-bottom-transition"
            max-width="600"
        >

            <v-form
                ref="formBook"
                v-model="form.valid"
                lazy-validation
            >
                <v-card>
                    <v-toolbar
                        color="primary"
                        dark
                    >CREAR LIBRO</v-toolbar>
                    <v-card-text>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="form.code"
                                    :rules="form.rules"
                                    label="Código"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="6">
                                <v-menu
                                    ref="menu"
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                    >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="form.date"
                                            :rules="form.rules"
                                            label="Fecha lanzamiento"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="form.date"
                                        :active-picker.sync="activePicker"
                                        :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                                        min="1950-01-01"
                                        @change="saveDate"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>

                            <v-col cols="12">
                                <v-text-field
                                    v-model="form.title"
                                    :rules="form.rules"
                                    label="Título"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    v-model="form.author"
                                    :rules="form.rules"
                                    label="Autor"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="6">  
                                <v-text-field
                                    v-model="form.editorial"
                                    :rules="form.rules"
                                    label="Editorial"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12">
                                <v-select
                                    v-model="form.categoryBook"
                                    :items="categories"
                                    item-text="name"
                                    item-value="id"
                                    :rules="[v => !!v || 'Categoría es requerida']"
                                    label="Categoría"
                                    required
                                ></v-select>
                            </v-col>

                            <v-col cols="6">
                                <v-text-field
                                    v-model="form.pages"
                                    type="number"
                                    :rules="form.rules"
                                    label="Páginas"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="6">  
                                <v-text-field
                                    v-model="form.stock"
                                    type="number"
                                    :rules="form.rules"
                                    label="Stock"
                                    required
                                ></v-text-field>
                            </v-col>

                            <v-col cols="12">
                                <v-file-input
                                    v-model="form.file"
                                    label="Portada"
                                    outlined
                                    dense
                                ></v-file-input>
                            </v-col>
                        </v-row>
                       
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            color="success"
                            @click="save()"
                        >Crear</v-btn>

                        <v-btn
                        text
                        @click="dialog = false"
                        >Cancelar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                page : {
                    loading: true,
                    proccess: false,
                },
                dialog: false,
                categories: [],
                activePicker: null,
                menu: false,
                form: {
                    rules: [
                        v => !!v || 'Campo es requerido',
                    ],
                    valid: true,
                    file: null,
                    title: '',
                    code: '',
                    author: '',
                    editorial: '',
                    date: null,
                    categoryBook: null,
                    pages: '',
                    stock: '',
                }
            }
        },
        created () {
        },
        computed: {
        },
        methods: {
            open() {
                this.dialog = true
            },
            saveDate(date) {
                this.$refs.menu.save(date)
            },
            getCategories() {
                axios.get( 'book/create' )
                    .then( response => {
                        this.categories = response.data.category
                    })
            },
            save() {
                
                if( !this.form.valid ) {
                    return false;
                }
                
                let data = {
                    date: this.form.date,
                    code: this.form.code,
                    title: this.form.title,
                    author: this.form.author,
                    editorial: this.form.editorial,
                    category_book_id: this.form.categoryBook,
                    pages: this.form.pages,
                    stock: this.form.stock,
                }

                if( this.form.file ) {
                    data.file = this.form.file
                }
                axios.post( 'book' , data )
                    .then( response => {
                        if( response.data.status ) {
                            this.$toast.success( response.data.message.description , response.data.message.title )
                            this.$emit('created')
                            this.dialog = false;
                        }
                    })
            },
            validate () {
                this.$refs.formBook.validate()
            },
            reset () {
                this.$refs.formBook.reset()
            },
            resetValidation () {
                this.$refs.formBook.resetValidation()
            },
        },
        mounted() {
            this.getCategories();
        }
    }
</script>