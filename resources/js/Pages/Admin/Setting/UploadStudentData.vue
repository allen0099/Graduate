<template>
    <v-card flat>
        <v-row dense>
            <v-col
                cols="12"
                sm="4"
            >
                <v-card flat>
                    <v-card-title>學生資料上傳</v-card-title>
                </v-card>
            </v-col>
            <v-col
                cols="12"
                sm="8"
            >
                <v-card
                    elevation="1"
                    class="pa-3"
                >
                    <v-card-text>
                        <v-file-input
                            accept=".csv"
                            label="學生資料"
                            ref="std_data"
                            id="std_data"
                        ></v-file-input>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn dark>上傳</v-btn>
                    </v-card-actions>

                </v-card>
            </v-col>
        </v-row>
    </v-card>
</template>

<script>
    export default {
        name: "UploadStudentData",
        data() {
            return {

            }
        },

        methods: {

        },
    }

</script>
