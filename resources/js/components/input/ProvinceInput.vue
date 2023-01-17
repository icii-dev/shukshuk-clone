<template>
    <select v-model="model" class="form-control" required>
        <option :value="item.id" v-for="item in items">{{item.name}}</option>
    </select>
</template>

<script>
    import AddressService from '../../services/address.service';

    export default {
        name: "ProvinceInput",

        props: {
            value: ''
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

        created() {
            this.fetch();
        },

        methods: {
            async fetch() {
                const {data} = await AddressService.getListProvince();

                this.items = data;
            }
        }
    }
</script>

<style scoped>

</style>
