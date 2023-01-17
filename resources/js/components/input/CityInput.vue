<template>
    <select v-model="model"  class="form-control" required>
        <option :value="item.id" v-for="item in items">{{item.name}}</option>
    </select>
</template>

<script>
    import AddressService from '../../services/address.service';

    export default {
        name: "CityInput",

        props: {
            value: '',
            provinceId: ''
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
                const {data} = await AddressService.getListCity(this.provinceId);

                this.items = data;
            }
        },

        watch: {
            provinceId: {
                handler(provinceId) {
                    // this.$emit('input', null);
                    this.items = [];

                    if (!provinceId) {
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
