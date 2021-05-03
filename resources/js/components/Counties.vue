<template>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <select id="megyeselect" class="form-control col-12" v-on:change="getcities">
                    <option disabled selected="selected">Válasszon</option>
                    <option v-for="county in counties" :key="county.id" v-bind:id="county.id" class="city">
                        {{ county.name }}
                    </option>

                </select>
                <div class="create" v-if="selected==1">
                    <div class="row">
                        <label for="createcity" class="col-3">Új Város</label> <input type="text"
                                                                                      class="form-control col-8"
                                                                                      id="createcity" name="createcity">
                    </div>
                    <button v-on:click="insertcity">Felvesz</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cityrow rows" v-for="city in cities">
                    <div class="row">
                <span v-bind:class="'col-md-12 city'+city.id" v-if="type!=city.id" v-bind:id="'city'+city.id"
                      v-on:click="change">{{ city.name }}</span>
                        <input type="text" class="form-control col-3" v-if="type==city.id" v-bind:value="city.name"
                               v-bind:id="'input'+city.id">
                        <input type="hidden" v-bind:value="city.name" v-bind:id="'hidden'+city.id"/>
                        <div class="actions">
                            <button v-if="type==city.id" v-bind:id="city.id" v-on:click="deletecity">Törlés</button>
                            <button v-if="type==city.id" v-bind:id="city.id" v-on:click="updatecity">Módosítás</button>
                            <button v-if="type==city.id" v-on:click="cancel">Mégsem</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    data: function () {
        return {
            type: 0,
            selected: 0,
            counties: [],
            cities: []

        }

    },
    mounted() {
        this.loadCounties();
    },
    methods: {
        loadCounties: function () {
            axios.get('/api/county')
                .then((response) => {
                    this.counties = response.data.data

                })
                .catch(function (error) {
                    console.log(error);

                })

        },
        cancel: function (event) {
            this.$set(this.$data, 'type', 0);
        },
       async getcities() {
            this.$set(this.$data, 'selected', 1);
            let options = document.getElementsByClassName("city");
            let megye = document.getElementById("megyeselect");
            let countyid = options[megye.selectedIndex - 1].id;
            axios.get('/api/county/' + countyid)
                .then((response) => {
                    this.cities = response.data[0].hascities;
                })
                .catch(function (error) {
                    console.log("asd");

                });

        },
        async deletecity(event) {
            let cityid = event.target.id;
            axios.delete('/api/county/' + cityid);
            await this.getcities();

        },
        async updatecity(event) {
            let id = event.target.id;
            let szoveg = document.getElementById("hidden" + id).previousElementSibling.value
            let options = document.getElementsByClassName("city");
            let megye = document.getElementById("megyeselect");
            let countyid = options[megye.selectedIndex - 1].id;
            axios.put('/api/county/' + id, {
                city: szoveg,
                countyid: countyid

            })
            this.$set(this.$data, 'type', 0);
            await this.getcities();
            await this.getcities();


        },
        change: function (event) {
            if (event) {
                let text = event.target.innerText;
                const id = event.target.id.replace('city', '');

                this.$set(this.$data, 'type', id)

            }

        },
        async insertcity (event) {
            let value = document.getElementById("createcity").value;
            let options = document.getElementsByClassName("city");
            let megye = document.getElementById("megyeselect");
            let countyid = options[megye.selectedIndex - 1].id;
            axios.post('/api/county/insertcity', {
                city: value,
                id: countyid

            })
            await this.getcities();
            await this.getcities();


        },


    }

}
</script>
