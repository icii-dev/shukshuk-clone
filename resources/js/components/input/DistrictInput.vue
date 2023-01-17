<template>
    <select v-model="model" class="form-control" required>
        <option :value="item.id" v-for="item in items">{{item.name}}</option>
    </select>
</template>

<script>
    import AddressService from '../../services/address.service';

    export default {
        name: "DistrictInput",
        props: {
            value: '',
            cityId: ''
        },

        data() {
            return {
                items: []
            };
        },

        computed: {
            model: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit('input', value);
                }
            }
        },

        methods: {
            async fetch() {
                const {data} = await AddressService.getListDistrict(this.cityId);

                this.items = data;
            }
        },

        watch: {
            cityId: {
                handler(cityId) {
                    // this.$emit('input', null);
                    this.items = [];

                    if (!cityId) {
                        return;
                    }

                    this.fetch();
                }
            }
        }
    }
</script>

<style scoped>

</style>
