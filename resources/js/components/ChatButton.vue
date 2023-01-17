<template>
    <a class="btn-customer tertiary-icon btn" href="#" role="button" @click.prevent="startChat">
        <slot></slot>
    </a>
</template>

<script>
    import SendBirdService from "../services/send-bird.service";
    import ChatStorageService from "../services/storage.service";

    export default {
        name: "ChatButton",
        props: ["userId", "storeId", "productUrl"],
        data() {
            return {
            }
        },
        mounted() {

        },
        methods: {
            async startChat() {
                try {
                    if (this.userId == '0') {
                        $('#modalLogin').modal('show');
                        return;
                    }

                    localStorage.setItem('chatGroupActivatedId', `buyer-${this.userId}-store-${this.storeId}`);
                    localStorage.setItem('chatProductUrl', this.productUrl);
                    localStorage.setItem('chatStoreId', this.storeId);

                    localStorage.setItem('attachment.url', this.productUrl);
                    localStorage.setItem('attachment.group_id', `buyer-${this.userId}-store-${this.storeId}`)

                    window.location.href = `/messenger/${this.storeId}`;
                } catch (e) {
                    console.log(e);
                }
            },
        }
    }
</script>

<style scoped>

</style>
