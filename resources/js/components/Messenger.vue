<template>
    <div class="Messages bg-white">
        <div class="row ml-0 mr-0">
            <!-- Left block -->
            <div class="left col-lg-3 col-md-4 col-select">
                <h3 class="color-back">Messages</h3>
                <hr class="web-block">
                <ChannelList v-model="groupChannelId" :user-id="userId" v-if="isConnected"></ChannelList>
            </div>
            <!-- # Left block -->

            <!-- Right block -->
            <div class="tab-content col-lg-9 col-md-8 col-select">
<!--                <ChatBox :user="user" :group="groupActivated" v-if="isConnected && false"></ChatBox>-->
                <ChatBox :group-channel-id="groupChannelId" :user-id="userId" v-if="isConnected && groupChannelId"></ChatBox>
                <p v-else class="color-gray select-message">Select message beside to start messaging.</p>
            </div>
            <!-- #Right block -->

        </div>
    </div>
</template>

<script>
    import ChatBox from './ChatBox.vue';
    import ChannelList from './ChannelList.vue';
    import MessengerService from '../services/messenger.service';

    export default {
        name: "Messenger",
        props: {
            userId: {}
        },
        components: {
            ChatBox,
            ChannelList
        },

        data() {
            return {
                user: {},
                originGroupChannels: [],
                groupActivatedId: '',
                groupActivated: null,
                isConnected: false,
                groupChannelId: '',
            }
        },

        computed: {
            groupChannels() {
                if (!this.originGroupChannels.length) {
                    return [];
                }

                const _this = this;

                return groupChannels;
            }
        },

        async created() {
            const _this = this;

            Promise.all([
                MessengerService.connectToUser(_this.userId),
                MessengerService.setupSyncManager(_this.userId)
            ]).then((values) => {
                const groupChannelId = localStorage.getItem('chatGroupActivatedId');

                if (groupChannelId) {
                    _this.groupChannelId = groupChannelId;
                }

                _this.isConnected = true;
            });
        },
        methods: {
            defaultImg(event) {
                var url = location.protocol + "//" + location.host;
                event.target.src = url + '/img/store-avatar/default-avatar.png';
            },
        },
        watch: {
            groupChannelId: {
                immediate: true,
                handler(groupChannelId) {
                    if (!groupChannelId) {
                        return;
                    }

                    localStorage.setItem('chatGroupActivatedId', groupChannelId);
                }
            }
        }
    }
</script>

<style scoped>

</style>
