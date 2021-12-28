<template>
    <v-card>
        <v-img
        src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
        height="200px"
        ></v-img>

        <v-card-title>
            {{this.parentData.title}}
        </v-card-title>

        <v-card-subtitle>
            <div>{{this.parentData.author}} - {{this.parentData.editorial}}</div>
            <div>{{this.parentData.date}}</div>
        </v-card-subtitle>

        <v-card-text>
            <v-row>
                <v-col cols="6">
                    <v-icon>mdi-codepen</v-icon>
                    <span>{{this.parentData.code}}</span>
                </v-col>
                <v-col cols="6">
                    <v-icon>mdi-tag</v-icon>
                    <span>{{this.parentData.category.name}}</span>
                </v-col>
                <v-col cols="6">
                    <v-icon>mdi-book-open-page-variant</v-icon>
                    <span>{{this.parentData.pages}}</span>
                </v-col>
                <v-col cols="6">
                    <v-chip
                        class="ma-2"
                        color="green"
                        outlined
                    >
                        Stock: {{this.parentData.stock}}
                    </v-chip>
                </v-col>
            </v-row>
        </v-card-text>

        <v-card-actions>
            <v-btn
                color="orange lighten-2"
                text
                @click="rentBook()"
            >
                Rentar Libro
            </v-btn>

            <v-spacer></v-spacer>

            <v-btn
                icon
                @click="deleteBook()"
            >  
                <v-icon color="red">mdi-delete</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        props: {
            parentData: Object,
        },
        methods: {
            deleteBook() {
                axios.delete( 'book/'+this.parentData.id )
                    .then( response => {
                        if( response.data.status ) {
                            this.$toast.success( response.data.message.description , response.data.message.title )
                            this.$emit('deleted')
                        }
                    })
            },
            rentBook() {
                let params = {
                    book_id: this.parentData.id,
                    user_id: this.$store.getters.getUser.id,
                }
                axios.post( 'book/rent' , params )
                    .then( response => {
                        if( response.data.status ) {
                            this.$toast.success( response.data.message.description , response.data.message.title )
                            this.parentData.stock = this.parentData.stock - 1 
                        }
                    })
            }
        }
    }
</script>