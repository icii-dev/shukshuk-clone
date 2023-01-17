<template>
    <a class="btn-pure-secondary" href="#" role="button" @click.prevent="startChat">
        <slot></slot>
    </a>
</template>

<script>
    import SendBirdService from "../../services/send-bird.service";
    import ChatStorageService from "../../services/storage.service";

    export default {
        name: "ChatButton",
        props: ["userId", "storeId", "productUrl", "messengerUrl"],
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
                    localStorage.setItem('chatProductUrl', '');
                    localStorage.setItem('chatStoreId', this.storeId);

                    localStorage.setItem('attachment.url', '');
                    localStorage.setItem('attachment.group_id', `buyer-${this.userId}-store-${this.storeId}`)

                    window.location.href = this.messengerUrl;
                } catch (e) {
                    console.log(e);
                }
            },
        }
    }
</script>

<style scoped>

</style>
